<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;
use Closure;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // --- PREPARE DATA ---
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $filterableTags = Tag::where('type', 'dietary')->orWhere('type', 'allergen')->get();
        
        // --- BUILD DYNAMIC QUERIES ---
        $specials = MenuItem::where('is_active', true)
                            ->where('is_special', true)
                            ->with('tags')
                            ->latest()
                            ->get();

        $menuItemFilter = function ($query) use ($request) {
            $query->where('is_active', true);

            // --- THIS IS THE CORRECTED SEARCH LOGIC ---
            if ($searchTerm = $request->input('search')) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $lowerSearchTerm = '%' . strtolower($searchTerm) . '%';

                    // Search English name AND description
                    $subQuery->whereRaw("LOWER(JSON_UNQUOTE(name->'$.en')) LIKE ?", [$lowerSearchTerm])
                             ->orWhereRaw("LOWER(JSON_UNQUOTE(description->'$.en')) LIKE ?", [$lowerSearchTerm]);
                    
                    // Also search the names in other languages
                    $otherLocales = ['am', 'so', 'om'];
                    foreach ($otherLocales as $locale) {
                        $subQuery->orWhereRaw("LOWER(JSON_UNQUOTE(name->'$." . $locale . "')) LIKE ?", [$lowerSearchTerm]);
                    }
                });
            }
            // --- END CORRECTION ---
            
            if ($tagId = $request->input('filter_tag')) {
                $query->whereHas('tags', function ($tagQuery) use ($tagId) {
                    $tagQuery->where('tags.id', $tagId);
                });
            }
        };

        $categoriesQuery = Category::whereHas('menuItems', $menuItemFilter);

        // --- THIS IS THE KEY UPDATE ---
        // Eager load the menu items, their tags, AND their approved reviews.
        $categoriesQuery->with([
            'menuItems' => $menuItemFilter, 
            'menuItems.tags', 
            'menuItems.reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            }
        ]);

        $categories = $categoriesQuery->orderBy('order', 'asc')->get();
        
        return view('menu.index', compact(
            'settings',
            'filterableTags',
            'specials',
            'categories'
        ));
    }

}