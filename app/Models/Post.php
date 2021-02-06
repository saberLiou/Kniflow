<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    /* Table name in the database. */
    const TABLE = "posts";

    /* Field names in the database. */
    const ID = "id";
    const USER_ID = "user_id";
    const CATEGORY_ID = "category_id";
    const SLUG = "slug";
    const TITLE = "title";
    const CONTENT = "content";
    const STATUS = "status";
    const PUBLISHED_AT = "published_at";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /* Dynamic Property names for relationships. */
    const USER = "user";
    const CATEGORY = "category";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::CATEGORY_ID,
        self::TITLE,
        self::CONTENT,
        self::STATUS,
        self::PUBLISHED_AT,
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
                'source' => self::TITLE,
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
     * Get the category that owns the post.
     *
     * @return Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
