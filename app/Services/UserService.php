<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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
     * Register a user with a personal access token for the device.
     *
     * @param array $data
     * @param string $deviceName
     * @return User
     */
    public function registerUser(array $data, string $deviceName)
    {
        return DB::transaction(function () use ($data, $deviceName) {
            $user = $this->userRepository->refreshUser(
                $this->userRepository->createUser($data)
            );
            $user->token = $this->userRepository->createPersonalAccessTokenForUser($user, $deviceName);
            return $user;
        });
    }

    /**
     * Login a user with a new personal access token for the device.
     *
     * @param array $data
     * @param string $deviceName
     * @return User
     */
    public function loginUser(array $data, string $deviceName)
    {
        $user = $this->userRepository->getUserByEmail($data[User::EMAIL]);
        if (is_null($user) || ! Hash::check($data[User::PASSWORD], $user->password)) {
            throw new HttpResponseException(error_response(
                (ValidationException::withMessages([
                    User::EMAIL => trans('auth.failed'),
                ]))->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            ));
        }

        return DB::transaction(function () use ($user, $deviceName) {
            $this->userRepository->deletePersonalAccessTokensByNameForUser($user, $deviceName);
            $user->token = $this->userRepository->createPersonalAccessTokenForUser($user, $deviceName);
            return $user;
        });
    }

    /**
     * Logout a user with all the personal access tokens being revoked on the device.
     *
     * @param string $deviceName
     * @return User
     */
    public function logoutUser(User $user, string $deviceName)
    {
        $this->userRepository->deletePersonalAccessTokensByNameForUser($user, $deviceName);
        return $user;
    }
}
