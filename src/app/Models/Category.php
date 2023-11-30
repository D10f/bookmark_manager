<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'order',
        'user_id',
        'parent_id'
    ];

    /**
     * Returns the user it belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns the parent category it belongs to, unless it's null.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
