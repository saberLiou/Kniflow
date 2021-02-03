<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return json_response(Category::all(), Response::HTTP_OK);
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
            Category::USER_ID => "required|integer",
            Category::NAME => "required|string|max:255",
            Category::SORT => "integer",
        ]);
        if ($validator->fails()) {
            return json_response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return json_response(
            Category::create($request->only([
                Category::USER_ID,
                Category::NAME,
                Category::SORT,
            ]))->refresh(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return json_response($category, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            Category::NAME => "string|max:255",
            Category::SORT => "integer",
        ]);
        if ($validator->fails()) {
            return json_response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update($request->replace([
            Category::SORT => (int) $request->sort,
        ])->only([
            Category::NAME,
            Category::SORT,
        ]));
        return json_response($category, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return json_response(null, Response::HTTP_NO_CONTENT);
    }
}
