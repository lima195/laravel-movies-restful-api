<?php

namespace App\Repository\Eloquent;

use App\Models\Movie;
use App\Repository\MovieRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class MovieRepository
 * @package App\Repository\Eloquent
 */
class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{

    /**
     * MovieRepository constructor.
     *
     * @param Movie $model
     */
    public function __construct(Movie $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
