<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $fullUrl = $request->fullUrl();
        if (Cache::has($fullUrl)) return Cache::get($fullUrl);

        $query = Post::query()
            ->where(Post::TITLE, "LIKE", "%$request->q%")
            ->orWhere(Post::CONTENT, "LIKE", "%$request->q%");

        if (isset($request->sorts)) {
            foreach (explode(',', $request->sorts) as $sort) {
                list($field, $order) = explode(':', $sort);
                if (in_array($order, ["asc", "desc"])) {
                    $query->orderBy($field, $order);
                }
            }
        } else {
            $query->orderBy(Post::PUBLISHED_AT, "DESC");
        }

        $posts = $query->paginate((int) $request->limit ?? 10)->appends($request->query());

        return Cache::remember($fullUrl, 60, function () use ($posts) {
            return json_response($posts, Response::HTTP_OK);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            Post::USER_ID => "required|integer",
            Post::CATEGORY_ID => "nullable|integer",
            Post::TITLE => "required|string|max:255",
            Post::CONTENT => "required",
            Post::STATUS => "integer",
            Post::PUBLISHED_AT => "required|date",
        ]);
        if ($validator->fails()) {
            return json_response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return json_response(
            Post::create($request->only([
                Post::USER_ID,
                Post::CATEGORY_ID,
                Post::TITLE,
                Post::CONTENT,
                Post::STATUS,
                Post::PUBLISHED_AT,
            ]))->refresh(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return json_response($post, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            Post::CATEGORY_ID => "nullable|integer",
            Post::TITLE => "string|max:255",
            Post::STATUS => "integer",
            Post::PUBLISHED_AT => "date",
        ]);
        if ($validator->fails()) {
            return json_response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post->update($request->replace([
            Post::STATUS => (int) $request->status,
        ])->only([
            Post::CATEGORY_ID,
            Post::TITLE,
            Post::CONTENT,
            Post::STATUS,
            Post::PUBLISHED_AT,
        ]));
        return json_response($post, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return json_response(null, Response::HTTP_NO_CONTENT);
    }
}
