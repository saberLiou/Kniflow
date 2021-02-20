<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\ValidatorFailed;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class RegisterRequest extends FormRequest
{
    use ValidatorFailed;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            User::NAME => 'required|string|max:255',
            User::EMAIL => 'required|string|email|max:255|unique:' . User::TABLE,
            User::PASSWORD => 'required|string|min:8',
            PersonalAccessToken::DEVICE_NAME => 'required|string|max:255',
        ];
    }
}
