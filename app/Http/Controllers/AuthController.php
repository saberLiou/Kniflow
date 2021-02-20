<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class AuthController extends Controller
{
    /**
     * Register a user with a personal access token.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::create($request->merge([
                User::PASSWORD => Hash::make($request->password),
            ])->only([
                User::NAME,
                User::EMAIL,
                User::PASSWORD,
            ]))->refresh();

            $user->token = $user->createToken($request->device_name)->plainTextToken;

            return new UserResource($user, Response::HTTP_CREATED);
        });
    }
}
