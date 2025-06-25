<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * THIS IS THE CRITICAL FIX.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_item_id',
        'rating',
        'comment',
        'is_approved',
    ];

    /**
     * Get the menu item that the review belongs to.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}