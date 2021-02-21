<?php

namespace App\Repositories;

use App\Models\PersonalAccessToken;
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
        parent::__construct($user);
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
     * Create a personal access token into the database for the user,
     * and return the created personal access token string.
     *
     * @param User $user
     * @param string $deviceName
     * @return string
     */
    public function createPersonalAccessTokenForUser(User $user, string $deviceName)
    {
        return $user->createToken($deviceName)->plainTextToken;
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
     * Get a user instance by his/her email,
     * return null if not found.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email)
    {
        return $this->toModel(
            $this->query->where(User::EMAIL, $email)->first()
        );
    }

    /**
     * Delete all the personal access tokens by their name for the user.
     *
     * @param User $user
     * @param string $deviceName
     * @return void
     */
    public function deletePersonalAccessTokensByNameForUser(User $user, string $deviceName)
    {
        $user->tokens()->where(PersonalAccessToken::NAME, $deviceName)->delete();
    }
}
