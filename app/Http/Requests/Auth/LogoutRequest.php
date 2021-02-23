<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Traits\ValidatorFailed;
use App\Models\PersonalAccessToken;
use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends FormRequest
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
            PersonalAccessToken::DEVICE_NAME => 'required|string|max:255',
        ];
    }

    /**
     * Body parammeters for Scribe to document.
     *
     * @return array
     */
    public function bodyParameters()
    {
        return [
            PersonalAccessToken::DEVICE_NAME => [
                'description' => 'The device name of the user.',
                'example' => config('scribe.example_values.device_name'),
            ],
        ];
    }
}
