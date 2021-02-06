<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Post;

class PostResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => Post::TABLE,
            'attributes' => array_remove_pairs(parent::toArray($request), [
                Post::ID,
                Post::USER_ID,
                Post::CATEGORY_ID,
                Post::CATEGORY,
            ]),
            'relationships' => [
                Post::USER => (is_null($this->user)) ? null : [
                    'data' => $this->user,
                ],
                Post::CATEGORY => (is_null($this->category)) ? null : [
                    'data' => $this->category,
                ],
            ],
        ];
    }
}
