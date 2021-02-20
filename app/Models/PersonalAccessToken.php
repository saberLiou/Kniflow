<?php

namespace App\Models;

use App\Models\Traits\DateTimeFormatted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use DateTimeFormatted, HasFactory;

    /* Table name in the database. */
    const TABLE = "personal_access_tokens";

    /* Field names in the database. */
    const ID = "id";
    const TOKENABLE_TYPE = "tokenable_type";
    const TOKENABLE_ID = "tokenable_id";
    const NAME = "name";
    const TOKEN = "token";
    const ABILITIES = "abilities";
    const LAST_USED_AT = "last_used_at";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /* Field names in query parameters from a request. */
    const DEVICE_NAME = 'device_name';
    const TOKEN_NAME = 'token_name';

    /* Dynamic Property names for relationships. */
    const USER = "user";

    /**
     * Get the user that owns the personal access token.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
