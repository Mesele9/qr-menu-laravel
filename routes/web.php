<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\LocalizationController; 
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\ImportController; // Add this line at the top


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// GUEST-FACING ROUTES
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/language/{locale}', [LocalizationController::class, 'setLocale'])->name('language.set'); 

/* --- Authentication & Admin Routes --- */
Auth::routes();

// Optional: Redirect the default /home to the new admin dashboard
Route::get('/home', function() {
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Route
    Route::get('/dashboard', function () {
        // We will fetch stats here to make the dashboard dynamic
        $stats = [
            'menu_items' => \App\Models\MenuItem::count(),
            'categories' => \App\Models\Category::count(),
            'reviews_pending' => \App\Models\Review::where('is_approved', false)->count(),
        ];
        return view('admin.dashboard', compact('stats')); // Pass stats to the view
    })->name('dashboard');

    // Resource Routes
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('menu-items', MenuItemController::class);
    
    // Note: We alias the AdminReviewController to avoid name conflicts
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'update', 'destroy']);

    // Settings Routes
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');

    // QR Code Generator Route
    Route::get('qr-code', [QrCodeController::class, 'show'])->name('qrcode.show'); 

    Route::get('import/menu-items', [ImportController::class, 'showForm'])->name('import.menu.form');
    Route::post('import/menu-items', [ImportController::class, 'handleImport'])->name('import.menu.handle');

});