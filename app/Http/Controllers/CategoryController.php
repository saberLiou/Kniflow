<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;
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
        $this->categoryService = $categoryService;

        $routesWithoutAuth = ['except' => ['index', 'show']];
        $this->middleware('auth:sanctum', $routesWithoutAuth);
        $this->authorizeResource(Category::class, 'category', $routesWithoutAuth);
    }

    /**
     * Display a listing of the categories.
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
     * Store a newly created category in storage.
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
     * Display the specified category.
     *
     * @group 02. Categories
     * @unauthenticated
     * @responseFile status=200 scenario="when category displayed." responses/categories.show/200.json
     * @responseFile status=404 scenario="when category not found." responses/404_model.json
     *
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified category in storage.
     *
     * @group 02. Categories
     * @responseFile status=200 scenario="when category updated." responses/categories.update/200.json
     * @responseFile status=401 scenario="without personal access token." responses/401.json
     * @responseFile status=403 scenario="when category updated by wrong user." responses/403.json
     * @responseFile status=404 scenario="when category not found." responses/404_model.json
     * @responseFile status=422 scenario="when any validation failed." responses/categories.update/422.json
     *
     * @param  UpdateRequest  $request
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->merge([
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
