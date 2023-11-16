<?php

namespace App\Models;

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
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Evaluates if the bookmark's URL is actually valid.
     */
    public function hasValidUrl(): bool
    {
        return filter_var($this->url, FILTER_VALIDATE_URL);
    }
}
