<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the menuItem relationship to prevent N+1 query problems
        $reviews = Review::with('menuItem')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Update the specified resource in storage.
     * We use this to toggle the 'is_approved' status.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
        ]);

        $review->update(['is_approved' => $request->is_approved]);

        $message = $request->is_approved ? 'Review approved successfully.' : 'Review hidden successfully.';

        return redirect()->route('admin.reviews.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}