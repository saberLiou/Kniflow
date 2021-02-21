<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class BaseRepository
{
    /**
     * The Builder instance of the model.
     *
     * @var \Illuminate\Database\Query\Builder
     */
    protected $query;

    /**
     * Create a BaseRepository instance.
     *
     * @param string $tableName
     */
    public function __construct(string $tableName)
    {
        $this->query = DB::table($tableName);
    }
}
