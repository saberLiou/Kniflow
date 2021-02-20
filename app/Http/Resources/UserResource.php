<?php

namespace App\Http\Resources;

use App\Models\User;

/**
 * Class UserResource.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class UserResource extends BaseResource
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
            User::TABLE,
            array_remove_pairs(parent::toArray($request), [
                User::ID,
            ]),
            [
                User::TOKENS => ($this->tokens->isEmpty()) ? [] : [
                    'data' => $this->tokens,
                ],
                User::CATEGORIES => ($this->categories->isEmpty()) ? [] : [
                    'data' => $this->categories,
                ],
                User::POSTS => ($this->posts->isEmpty()) ? [] : [
                    'data' => $this->posts,
                ],
            ]
        );
    }
}
