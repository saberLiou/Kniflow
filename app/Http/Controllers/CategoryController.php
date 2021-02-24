<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Categories\StoreRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * The CategoryService instance.
     *
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * Create a CategoryController instance.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->authorizeResource(Category::class, 'category', ['except' => ['index', 'show']]);
        $this->categoryService = $categoryService;
    }

    /**
     * 2-1. Display a listing of the categories.
     *
     * @group 02. Categories
     * @unauthenticated
     * @responseFile status=200 scenario="when categories displayed." responses/categories.index/200.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return new CategoryCollection($this->categoryService->indexCategories());
    }

    /**
     * 2-2. Store a newly created category in storage.
     *
     * @group 02. Categories
     * @responseFile status=201 scenario="when category created." responses/categories.store/201.json
     * @responseFile status=401 scenario="without personal access token." responses/401.json
     * @responseFile status=422 scenario="when any validation failed." responses/categories.store/422.json
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        return new CategoryResource($this->categoryService->createCategory($request->user(), $request->only([
            Category::NAME,
            Category::SORT,
        ])), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
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
            Category::NAME => 'string|max:255',
            Category::SORT => 'integer',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update($request->merge([
            Category::SORT => (int) $request->sort,
        ])->only([
            Category::NAME,
            Category::SORT,
        ]));
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // TODO: idempotent response for DELETE.
        $deletedCategory = $category;
        $category->delete();
        return new CategoryResource($deletedCategory);
    }
}
