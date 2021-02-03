<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    /* Field names in the database. */
    const ID = "id";
    const USER_ID = "user_id";
    const SLUG = "slug";
    const NAME = "name";
    const SORT = "sort";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

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
}
