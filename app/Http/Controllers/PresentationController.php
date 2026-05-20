<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PresentationAIService;
use App\Models\Presentation;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PresentationController extends Controller
{
    public function index()
    {
        $presentations = Presentation::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('presentations.index', compact('presentations'));
    }

    public function show(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.show', compact('presentation'));
    }

    public function create()
    {
        return view('presentations.create');
    }

    public function store(Request $request, PresentationAIService $ai)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'topic' => 'required|string',
            'points' => 'required|array'
        ]);

        $structure = $ai->generate(
            $data['topic'],
            $data['points']
        );

        $presentation = Presentation::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'topic' => $data['topic'],
            'structure' => $structure
        ]);

        return redirect()->route('presentations.show', $presentation->id);
    }

    public function edit(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.edit', compact('presentation'));
    }

    public function update(Request $request, $id)
    {
        $presentation = Presentation::findOrFail($id);

        $structure = [
            'slides' => $request->slides
        ];

        $presentation->update([
            'title' => $request->title,
            'topic' => $request->topic,
            'structure' => $structure
        ]);

        return redirect('/presentations/' . $presentation->id);
    }

    public function regenerateSlide($id, $index)
    {
        $presentation = Presentation::findOrFail($id);

        $slides = $presentation->structure['slides'];

        if (!isset($slides[$index])) {
            abort(404, 'Slide not found');
        }

        $topic = $presentation->topic;
        $currentSlide = $slides[$index];

        $prompt = "
    Topic: {$topic}

    Rewrite ONLY one presentation slide.

    Existing slide:
    Title: {$currentSlide['title']}
    Bullets: " . implode(', ', $currentSlide['bullets']) . "
    Notes: {$currentSlide['notes']}

    Return JSON:
    {
      \"title\": \"...\",
      \"bullets\": [\"...\", \"...\", \"...\"],
      \"notes\": \"...\"
    }
    ";

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.8
            ]);

        $content = $response['choices'][0]['message']['content'];

        $newSlide = json_decode($content, true);

        if (!$newSlide) {
            return back()->with('error', 'AI response invalid');
        }

        $slides[$index] = $newSlide;

        $presentation->update([
            'structure' => [
                'slides' => $slides
            ]
        ]);

        return redirect('/presentations/' . $presentation->id . '/edit');
    }

    public function exportPdf($id)
    {
        $presentation = Presentation::findOrFail($id);

        $pdf = Pdf::loadView('presentations.pdf', [
            'presentation' => $presentation
        ]);

        return $pdf->download(
            'presentation-' . $presentation->id . '.pdf'
        );
    }

    public function present($id)
    {
        $presentation = Presentation::findOrFail($id);

        return view('presentations.present', compact('presentation'));
    }
}
