<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    // List all user workspaces with presentation counts.
    public function index()
    {
        $workspaces = auth()->user()->workspaces()->withCount('presentations')->latest()->get();

        return view('workspaces.index', compact('workspaces'));
    }

    // Show workspace creation form.
    public function create()
    {
        return view('workspaces.create');
    }

    // Save new workspace and link selected presentations.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'presentations' => 'array',
            'presentations.*' => 'exists:presentations,id',
        ]);

        $workspace = Workspace::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'slug' => \Illuminate\Support\Str::slug($data['name']) . '-' . \Illuminate\Support\Str::random(5),
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

    // View specific workspace and its presentations.
    public function show(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $presentations = $workspace->presentations()->latest()->get();

        return view('workspaces.show', compact('workspace', 'presentations'));
    }

    // Show edit form for existing workspace.
    public function edit(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        return view('workspaces.edit', compact('workspace'));
    }

    // Update workspace name and sync presentation links.
    public function update(Request $request, Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'presentations' => 'array',
            'presentations.*' => 'exists:presentations,id',
        ]);

        $workspace->update([
            'name' => $data['name']
        ]);

        $selected = $data['presentations'] ?? [];

        \App\Models\Presentation::where('workspace_id', $workspace->id)
            ->where('user_id', auth()->id())
            ->update(['workspace_id' => null]);

        if (!empty($selected)) {
            \App\Models\Presentation::whereIn('id', $selected)
                ->where('user_id', auth()->id())
                ->update([
                    'workspace_id' => $workspace->id
                ]);
        }

        return redirect()->route('workspaces.show', $workspace);
    }

    // Delete workspace.
    public function destroy(Workspace $workspace)
    {
        abort_if($workspace->user_id !== auth()->id(), 403);

        $workspace->delete();

        return redirect()->route('workspaces.index');
    }
}
