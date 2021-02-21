<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class UserRepository extends BaseRepository
{
    /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a UserRepository instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct(User::TABLE);
        $this->user = $user;
    }

    /**
     * Create a user into the database,
     * and return the created user instance with original attributes.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $data[User::PASSWORD] = Hash::make($data[User::PASSWORD]);
        return $this->user->create($data);
    }

    /**
     * Return the user instance with fresh attributes from the database.
     *
     * @param User $user
     * @return User
     */
    public function refreshUser(User $user)
    {
        return $user->refresh();
    }

    /**
     * Create a personal access token into the database for the user,
     * and return the created personal access token string.
     *
     * @param User $user
     * @param string $tokenName
     * @return string
     */
    public function createPersonalAccessTokenForUser(User $user, string $tokenName)
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}
