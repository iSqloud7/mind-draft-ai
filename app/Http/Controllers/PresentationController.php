<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PresentationAIService;
use App\Models\Presentation;

class PresentationController extends Controller
{
    public function index()
    {
        $presentations = Presentation::latest()->get();

        return view('presentations.index', compact('presentations'));
    }

    public function show($id)
    {
        $presentation = Presentation::findOrFail($id);

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
}
