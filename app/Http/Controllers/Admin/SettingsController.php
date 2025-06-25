<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Validation\Rule; 


class SettingsController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        // Pluck all settings from the database and create a key-value array
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Store or update the settings.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'main_bg_color' => 'nullable|string|max:7',
            'primary_brand_color' => 'nullable|string|max:7',
            'secondary_brand_color' => 'nullable|string|max:7',
            'header_bg_color' => 'nullable|string|max:7',
            'header_text_color' => 'nullable|string|max:7',
            'footer_bg_color' => 'nullable|string|max:7',
            'footer_text_color' => 'nullable|string|max:7',
            'default_language' => ['required', Rule::in(['en', 'am', 'so', 'om'])],

        ]);

        // Loop through all validated data (except the logo) and update or create the setting
        foreach ($validated as $key => $value) {
            if ($key === 'company_logo') continue;

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Handle the logo upload
        if ($request->hasFile('company_logo')) {
            // Get the old logo path
            $oldLogoPath = Setting::where('key', 'company_logo_path')->first()->value ?? null;

            // Delete the old logo if it exists
            if ($oldLogoPath && Storage::disk('public')->exists($oldLogoPath)) {
                Storage::disk('public')->delete($oldLogoPath);
            }

            // Store the new logo and get its path
            $path = $request->file('company_logo')->store('logos', 'public');

            // Save the new path to the settings table
            Setting::updateOrCreate(
                ['key' => 'company_logo_path'],
                ['value' => $path]
            );
        }

        Cache::forget('settings.default_language');
        
        return redirect()->route('admin.settings.index')
                         ->with('success', 'Settings saved successfully.');
    }
}