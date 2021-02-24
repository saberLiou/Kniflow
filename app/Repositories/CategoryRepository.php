<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\User;

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
     * Create a category by the authenticated user into the database,
     * and return the created user instance with original attributes.
     *
     * @param User $authUser
     * @param array $data
     * @return Category
     */
    public function createCategory(User $authUser, array $data)
    {
        return $authUser->categories()->create($data);
    }

    /**
     * Return the category instance with fresh attributes from the database.
     *
     * @param Category $category
     * @return Category
     */
    public function refreshCategory(Category $category)
    {
        return $category->refresh();
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
