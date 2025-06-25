<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->latest()->paginate(10);
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all()->groupBy('type'); // Group tags for easier display in the view
        return view('admin.menu-items.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.am' => 'nullable|string|max:255',
            'name.so' => 'nullable|string|max:255',
            'name.om' => 'nullable|string|max:255',
            'description.en' => 'required|string',
            'description.am' => 'nullable|string',
            'description.so' => 'nullable|string',
            'description.om' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_active' => 'nullable',
            'is_special' => 'nullable',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');
        $data['is_special'] = $request->has('is_special'); 

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu-images', 'public');
            $data['image_path'] = $path;
        }

        $menuItem = MenuItem::create($data);

        if ($request->has('tags')) {
            $menuItem->tags()->sync($request->tags);
        }

        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu Item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        $tags = Tag::all()->groupBy('type');
        return view('admin.menu-items.edit', compact('menuItem', 'categories', 'tags'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.am' => 'nullable|string|max:255',
            'name.so' => 'nullable|string|max:255',
            'name.om' => 'nullable|string|max:255',
            'description.en' => 'required|string',
            'description.am' => 'nullable|string',
            'description.so' => 'nullable|string',
            'description.om' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_active' => 'nullable',
            'is_special' => 'nullable',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');
        $data['is_special'] = $request->has('is_special'); 

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($menuItem->image_path) {
                Storage::disk('public')->delete($menuItem->image_path);
            }
            $path = $request->file('image')->store('menu-images', 'public');
            $data['image_path'] = $path;
        }

        $menuItem->update($data);
        $menuItem->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu Item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Delete the associated image from storage
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }

        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu Item deleted successfully.');
    }
}