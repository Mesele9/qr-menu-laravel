<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// We no longer need Storage

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.am' => 'nullable|string|max:255',
            'name.so' => 'nullable|string|max:255',
            'name.om' => 'nullable|string|max:255',
            'type' => ['required', Rule::in(['general', 'dietary', 'allergen'])],
            'icon_path' => 'nullable|string|max:255', // Changed from image validation
        ]);

        Tag::create($validated); // Simplified creation

        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.am' => 'nullable|string|max:255',
            'name.so' => 'nullable|string|max:255',
            'name.om' => 'nullable|string|max:255',
            'type' => ['required', Rule::in(['general', 'dietary', 'allergen'])],
            'icon_path' => 'nullable|string|max:255', // Changed from image validation
        ]);

        $tag->update($validated); // Simplified update

        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        // No need to delete a file from storage anymore
        $tag->delete();

        return redirect()->route('admin.tags.index')
                         ->with('success', 'Tag deleted successfully.');
    }
}