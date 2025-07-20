<?php

namespace App\Imports;

use App\Models\MenuItem;
use App\Models\Category;
use App\Models\Tag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuItemsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Find or Create the Category
        // We use firstOrCreate to prevent duplicates. It's smart!
        // We assume the import is for the default 'en' language.
        $category = Category::firstOrCreate(
            ['name->en' => trim($row['category_name'])],
            ['name' => ['en' => trim($row['category_name'])]]
        );

        // 2. Create the Menu Item
        $menuItem = new MenuItem([
            'name'        => ['en' => $row['name']],
            'description' => ['en' => $row['description']],
            'price'       => $row['price'],
            'category_id' => $category->id,
            'is_active'   => $row['is_active'] ?? 1,
            'is_special'  => $row['is_special'] ?? 0,
        ]);
        
        // We need to save the menu item first to get an ID for tag relationships
        $menuItem->save();

        // 3. Find or Create Tags and attach them
        if (!empty($row['tags'])) {
            $tagIds = [];
            $tagNames = explode(',', $row['tags']); // Split the tags string into an array

            foreach ($tagNames as $tagName) {
                $trimmedName = trim($tagName);
                if (empty($trimmedName)) continue;

                // For each tag, find or create it. Default new tags to 'general' type.
                $tag = Tag::firstOrCreate(
                    ['name->en' => $trimmedName],
                    ['name' => ['en' => $trimmedName], 'type' => 'general']
                );
                $tagIds[] = $tag->id;
            }
            // Sync the tags with the menu item
            $menuItem->tags()->sync($tagIds);
        }

        return $menuItem;
    }
}