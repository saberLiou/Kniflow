<?php

namespace App\Services;

use App\Models\User;
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
     * @return \App\Models\Category
     */
    public function createCategory(User $authUser, array $data)
    {
        return $this->categoryRepository->refreshCategory(
            $this->categoryRepository->createCategory($authUser, $data)
        );
    }
}
