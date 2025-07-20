<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MenuItemsImport;

class ImportController extends Controller
{
    /**
     * Show the form for uploading the Excel file.
     */
    public function showForm()
    {
        return view('admin.import.form');
    }

    /**
     * Handle the file upload and start the import process.
     */
    public function handleImport(Request $request)
    {
        $request->validate([
            'menu_import_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MenuItemsImport, $request->file('menu_import_file'));
        } catch (\Exception $e) {
            // A basic way to catch errors during import
            return back()->withErrors(['msg' => 'An error occurred during import. Please check your file format. Error: ' . $e->getMessage()]);
        }
        
        return redirect()->route('admin.menu-items.index')
                         ->with('success', 'Menu items imported successfully!');
    }
}