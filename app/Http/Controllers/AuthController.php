<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register a user with a personal access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            User::NAME => 'required|string|max:255',
            User::EMAIL => 'required|string|email|max:255|unique:' . User::TABLE,
            User::PASSWORD => 'required|string|min:8',
            'device_name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return DB::transaction(function() use ($request) {
            $user = User::create($request->merge([
                User::PASSWORD => Hash::make($request->password),
            ])->only([
                User::NAME,
                User::EMAIL,
                User::PASSWORD,
            ]))->refresh();

            $user->token = $user->createToken($request->device_name)->plainTextToken;

            return new UserResource($user);
        });
    }
}
