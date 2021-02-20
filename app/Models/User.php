<?php

namespace App\Models;

use App\Models\Traits\DateTimeFormatted;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class User extends Authenticatable
{
    use DateTimeFormatted, HasApiTokens, HasFactory, Notifiable;

    /* Table name in the database. */
    const TABLE = "users";

    /* Field names in the database. */
    const ID = "id";
    const NAME = "name";
    const EMAIL = "email";
    const EMAIL_VERIFIED_AT = "email_verified_at";
    const PASSWORD = "password";
    const REMEMBER_TOKEN = "remember_token";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /* Dynamic Property names for relationships. */
    const TOKENS = "tokens";
    const CATEGORIES = "categories";
    const POSTS = "posts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];

    /**
     * Get the categories for the user.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the posts for the user.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
