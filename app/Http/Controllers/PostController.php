<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
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

        $query = Post::query()->with('category')
            ->where(Post::TITLE, 'LIKE', "%$request->q%")
            ->orWhere(Post::CONTENT, 'LIKE', "%$request->q%");

        if (isset($request->sorts)) {
            foreach (explode(',', $request->sorts) as $sort) {
                list($field, $order) = explode(':', $sort);
                if (in_array($order, ['asc', 'desc'])) {
                    $query->orderBy($field, $order);
                }
            }
        } else {
            $query->orderBy(Post::PUBLISHED_AT, 'DESC');
        }

        $posts = $query->paginate((int) $request->limit ?? 10)->appends($request->query());

        return Cache::remember($fullUrl, 60, function () use ($posts) {
            return new PostCollection($posts);
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
            Post::USER_ID => 'required|integer',
            Post::CATEGORY_ID => 'nullable|integer|exists:'.Category::TABLE.',id',
            Post::TITLE => 'required|string|max:255',
            Post::CONTENT => 'required',
            Post::STATUS => 'integer',
            Post::PUBLISHED_AT => 'required|date',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new PostResource(
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
        return new PostResource($post);
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
            Post::CATEGORY_ID => 'nullable|integer|exists:'.Category::TABLE.',id',
            Post::TITLE => 'string|max:255',
            Post::STATUS => 'integer',
            Post::PUBLISHED_AT => 'date',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post->update($request->merge([
            Post::STATUS => (int) $request->status,
        ])->only([
            Post::CATEGORY_ID,
            Post::TITLE,
            Post::CONTENT,
            Post::STATUS,
            Post::PUBLISHED_AT,
        ]));
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        // TODO: idempotent response for DELETE.
        $deletedPost = $post;
        $post->delete();
        return new PostResource($deletedPost);
    }
}
