<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    /* Table name in the database. */
    const TABLE = "categories";

    /* Field names in the database. */
    const ID = "id";
    const USER_ID = "user_id";
    const SLUG = "slug";
    const NAME = "name";
    const SORT = "sort";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /* Dynamic Property names for relationships. */
    const USER = "user";
    const POSTS = "posts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::NAME,
        self::SORT,
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            self::SLUG => [
                'source' => self::NAME,
                'onUpdate' => true,
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return self::SLUG;
    }

    /**
     * Get the user that owns the post.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts for the category.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
