<?php

namespace App\Http\Resources;

use App\Models\Category;

class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return format_resource_object(
            $this->id,
            Category::TABLE,
            array_remove_pairs(parent::toArray($request), [
                Category::ID,
                Category::USER_ID,
            ]),
            [
                Category::USER => (is_null($this->user)) ? null : [
                    'data' => $this->user,
                ],
                Category::POSTS => ($this->posts->isEmpty()) ? [] : [
                    'data' => $this->posts,
                ],
            ]
        );
    }
}
