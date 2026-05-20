<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PresentationAIService;
use App\Models\Presentation;
use App\Models\Workspace;
use Barryvdh\DomPDF\Facade\Pdf;

class PresentationController extends Controller
{
    // List user presentations on dashboard.
    public function index()
    {
        $presentations = Presentation::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('presentations.index', compact('presentations'));
    }

    // Show creation form.
    public function create()
    {
        return view('presentations.create');
    }

    // Generate and save new AI presentation.
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
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'topic' => $data['topic'],
            'workspace_id' => $data['workspace_id'] ?? null,
            'structure' => $structure
        ]);

        return redirect()->route('presentations.show', $presentation);
    }

    // View specific presentation.
    public function show(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.show', compact('presentation'));
    }

    // Show edit form.
    public function edit(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.edit', compact('presentation'));
    }

    // Update presentation details and slides.
    public function update(Request $request, Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        $presentation->update([
            'title' => $request->title,
            'topic' => $request->topic,
            'structure' => ['slides' => $request->slides]
        ]);

        return redirect()->route('presentations.show', $presentation);
    }

    // Delete presentation.
    public function destroy(Presentation $presentation)
    {
        abort_if($presentation->user_id !== auth()->id(), 403);

        $presentation->delete();

        return redirect()->route('presentations.index');
    }

    // Re-generate a single slide using AI.
    public function regenerateSlide(PresentationAIService $ai, $id, $index)
    {
        $presentation = Presentation::findOrFail($id);

        abort_if($presentation->user_id !== auth()->id(), 403);

        $structure = $presentation->structure;
        $slides = $structure['slides'] ?? [];

        abort_if(!isset($slides[$index]), 404);

        $currentSlide = $slides[$index];

        $promptText = "Regenerate this specific slide for the presentation topic: '{$presentation->topic}'. " .
            "Current slide title: '{$currentSlide['title']}'. " .
            "Make it more detailed, professional, and well-structured. " .
            "Return ONLY a single slide object inside the expected JSON structure containing 'title', 'bullets' array, and 'notes'.";

        $aiResponse = $ai->generate($presentation->topic, [$promptText]);

        $newSlide = null;
        if (isset($aiResponse['slides'][0])) {
            $newSlide = $aiResponse['slides'][0];
        } elseif (isset($aiResponse[0])) {
            $newSlide = $aiResponse[0];
        }

        if (!$newSlide) {
            return back()->with('error', 'AI response invalid');
        }

        $slides[$index] = [
            'title' => $newSlide['title'] ?? $currentSlide['title'],
            'bullets' => $newSlide['bullets'] ?? $currentSlide['bullets'],
            'notes' => $newSlide['notes'] ?? $currentSlide['notes']
        ];

        $structure['slides'] = $slides;

        $presentation->update([
            'structure' => $structure
        ]);

        return back();
    }

    // Download presentation as PDF.
    public function exportPdf($id)
    {
        $presentation = Presentation::where('id', $id)->firstOrFail();

        $pdf = Pdf::loadView('presentations.export-layout', compact('presentation'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'DejaVu Sans'
            ]);

        return $pdf->download(str_replace(' ', '_', $presentation->title) . '.pdf');
    }

    // Enter full-screen presentation mode.
    public function present($id)
    {
        $presentation = Presentation::findOrFail($id);

        abort_if($presentation->user_id !== auth()->id(), 403);

        return view('presentations.present', compact('presentation'));
    }

    // Move presentation to a different workspace.
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
