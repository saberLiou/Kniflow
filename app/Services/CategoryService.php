<?php

namespace App\Services;

use App\Models\User;
use App\Models\Category;
use App\Repositories\CategoryRepository;

/**
 * Class CategoryService.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class CategoryService
{
    /**
     * The CategoryRepository instance.
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Create a CategoryService instance.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function indexCategories()
    {
        return $this->categoryRepository->getCategories();
    }

    /**
     * Store a newly created category in storage.
     *
     * @param User $authUser
     * @param array $data
     * @return Category
     */
    public function createCategory(User $authUser, array $data)
    {
        return $this->categoryRepository->refreshCategory(
            $this->categoryRepository->createCategory($authUser, $data)
        );
    }

    /**
     * Update the specified category in storage.
     *
     * @param Category $category
     * @param array $data
     * @return void
     */
    public function updateCategory(Category $category, array $data)
    {
        $this->categoryRepository->updateCategory($category, $data);
    }

    /**
     * Remove the specified category from storage,
     * and return the deleted category.
     *
     * @param Category $category
     * @return Category
     */
    public function deleteCategory(Category $category)
    {
        $deletedCategory = $category;
        $this->categoryRepository->deleteCategory($category);
        return $deletedCategory;
    }
}
