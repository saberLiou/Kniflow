<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class UserService
{
    /**
     * The UserRepository instance.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a UserService instance.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a user with a personal access token.
     *
     * @param array $data
     * @param string $tokenName
     * @return \App\Models\User
     */
    public function registerUser(array $data, string $tokenName)
    {
        return DB::transaction(function () use ($data, $tokenName) {
            $user = $this->userRepository->refreshUser(
                $this->userRepository->createUser($data)
            );
            $user->token = $this->userRepository->createPersonalAccessTokenForUser($user, $tokenName);
            return $user;
        });
    }
}
