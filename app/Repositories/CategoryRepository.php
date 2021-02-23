<?php

namespace App\Repositories;

use App\Models\Category;

/**
 * Class UserRepository.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class CategoryRepository extends BaseRepository
{
    /**
     * The Category instance.
     *
     * @var Category
     */
    protected $category;

    /**
     * Create a CategoryRepository instance.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->category = $category;
    }

    /**
     * Get all categories from the database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        return Category::all();
    }
}
