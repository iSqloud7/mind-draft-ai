<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = auth()->user()->workspaces()->withCount('presentations')->latest()->get();

        return view('workspaces.index', compact('workspaces'));
    }

    public function create()
    {
        return view('workspaces.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'presentations' => 'array',
            'presentations.*' => 'exists:presentations,id',
        ]);

        $workspace = Workspace::create([
            'user_id' => auth()->id(),
            'name'    => $data['name'],
            'slug'    => \Illuminate\Support\Str::slug($data['name']) . '-' . \Illuminate\Support\Str::random(5),
        ]);

        if (!empty($data['presentations'])) {
            \App\Models\Presentation::whereIn('id', $data['presentations'])
                ->where('user_id', auth()->id())
                ->update([
                    'workspace_id' => $workspace->id
                ]);
        }

        return redirect()->route('workspaces.show', $workspace);
    }

    public function show(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $presentations = $workspace->presentations()->latest()->get();

        return view('workspaces.show', compact('workspace', 'presentations'));
    }

    public function edit(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        return view('workspaces.edit', compact('workspace'));
    }

    public function update(Request $request, Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'presentations' => 'array',
            'presentations.*' => 'exists:presentations,id',
        ]);

        // 1. update name
        $workspace->update([
            'name' => $data['name']
        ]);

        $selected = $data['presentations'] ?? [];

        // 2. remove old relations
        \App\Models\Presentation::where('workspace_id', $workspace->id)
            ->where('user_id', auth()->id())
            ->update(['workspace_id' => null]);

        // 3. add selected
        if (!empty($selected)) {
            \App\Models\Presentation::whereIn('id', $selected)
                ->where('user_id', auth()->id())
                ->update([
                    'workspace_id' => $workspace->id
                ]);
        }

        return redirect()->route('workspaces.show', $workspace);
    }

    public function destroy(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $workspace->delete();

        return redirect()->route('workspaces.index');
    }
}
