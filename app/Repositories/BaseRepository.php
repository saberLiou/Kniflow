<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class BaseRepository
{
    /**
     * The Model instance.
     *
     * @var Model
     */
    private $model;

    /**
     * The Builder instance of the model.
     *
     * @var \Illuminate\Database\Query\Builder
     */
    protected $query;

    /**
     * Create a BaseRepository instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = DB::table($model->getTable());
    }

    /**
     * Convert the object queried from database by Builder into an Eloquent model,
     * return null if not an object.
     *
     * @param object $object
     * @return Model|null
     */
    protected function toModel($object)
    {
        return is_object($object) ? $this->model->forceFill((array) $object) : null;
    }
}
