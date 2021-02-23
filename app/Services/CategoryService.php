<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;

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
}
