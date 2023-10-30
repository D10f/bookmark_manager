<?php

namespace App\Models;

use App\Events\BookmarkProcessed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'category',
        'favicon_url',
        'user_id'
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, event>
     */
    protected $dispatchesEvents = [
        'creating' => BookmarkProcessed::class,
        'updating' => BookmarkProcessed::class,
    ];

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
