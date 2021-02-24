<?php

namespace App\Http\Requests\Categories;

use App\Http\Requests\Traits\ValidatorFailed;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRequest.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class StoreRequest extends FormRequest
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
            Category::NAME => 'required|string|max:255',
            Category::SORT => 'integer',
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
            Category::NAME => [
                'description' => 'The name of the category.',
                'example' => config('scribe.example_values.name'),
            ],
            Category::SORT => [
                'description' => 'The sort of the category.',
                'example' => 0,
            ],
        ];
    }
}
