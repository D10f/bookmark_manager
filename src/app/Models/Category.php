<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Returns the lowest order value from all categories under the same parent
     * @param $parentId The common category parent to filter by.
     * @param $userId   The user owning the categories to filter by.
     */
    public static function lowestOrder(int | null $parentId, int $userId)
    {
        return DB::table('categories')
            ->where('user_id', '=', $userId)
            ->where('parent_id', '=', $parentId)
            ->min('order');
    }
}
