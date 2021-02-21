<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class AuthController extends Controller
{
    /**
     * The UserService instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Create an AuthController instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a user with a personal access token.
     *
     * @group 01. Authentication
     * @unauthenticated
     * @responseFile status=201 scenario="when registration succeeded." responses/auth.register/201.json
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        return new UserResource($this->userService->registerUser($request->only([
            User::NAME,
            User::EMAIL,
            User::PASSWORD,
        ]), $request->device_name), Response::HTTP_CREATED);
    }
}
