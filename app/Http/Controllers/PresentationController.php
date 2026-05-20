<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PresentationAIService;
use App\Models\Presentation;
use App\Models\Workspace;
use Barryvdh\DomPDF\Facade\Pdf;

class PresentationController extends Controller
{
    public function index()
    {
        $presentations = Presentation::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('presentations'));
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
            'points' => 'required|array',
            'workspace_id' => 'nullable|exists:workspaces,id'
        ]);

        $structure = $ai->generate($data['topic'], $data['points']);

        $presentation = Presentation::create([
            'user_id'      => auth()->id(),
            'title'        => $data['title'],
            'topic'        => $data['topic'],
            'workspace_id' => $data['workspace_id'] ?? null,
            'structure'    => $structure
        ]);

        return redirect()->route('presentations.show', $presentation);
    }

    public function show(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.show', compact('presentation'));
    }

    public function edit(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.edit', compact('presentation'));
    }

    public function update(Request $request, Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        $presentation->update([
            'title'     => $request->title,
            'topic'     => $request->topic,
            'structure' => ['slides' => $request->slides]
        ]);

        return redirect()->route('presentations.show', $presentation);
    }

    public function destroy(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        $presentation->delete();

        return redirect()->route('presentations.index');
    }

    public function regenerateSlide(PresentationAIService $ai, $id, $index)
    {
        $presentation = Presentation::findOrFail($id);

        abort_if($presentation->user_id !== auth()->id(), 403);

        $slides = $presentation->structure['slides'];

        abort_if(!isset($slides[$index]), 404);

        $newSlide = $ai->regenerateSlide($presentation->topic, $slides[$index]);

        if (!$newSlide) {
            return back()->with('error', 'AI response invalid');
        }

        $slides[$index] = $newSlide;

        $presentation->update([
            'structure' => ['slides' => $slides]
        ]);

        return redirect()->route('presentations.edit', $presentation);
    }

    public function exportPdf($id)
    {
        $presentation = Presentation::findOrFail($id);

        abort_if($presentation->user_id !== auth()->id(), 403);

        $pdf = Pdf::loadView('presentations.pdf', [
            'presentation' => $presentation
        ]);

        return $pdf->download('presentation-' . $presentation->id . '.pdf');
    }

    public function present($id)
    {
        $presentation = Presentation::findOrFail($id);

        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.present', compact('presentation'));
    }

    public function updateWorkspace(Request $request, Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'workspace_id' => 'nullable|exists:workspaces,id'
        ]);

        $presentation->update([
            'workspace_id' => $data['workspace_id']
        ]);

        return back();
    }
}
