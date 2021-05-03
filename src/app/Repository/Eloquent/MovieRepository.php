<?php

namespace App\Repository\Eloquent;

use App\Models\Movie;
use App\Repository\MovieRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

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
    public function __construct(
        Movie $model
    ) {
        parent::__construct($model);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection
    {
        $collection = $this->model;

        /* Only if available */
        $collection = $collection->where('availability', $this->model::DEFAULT_POSITIVE_AVAILABILITY);

        $collection->withCount('likes as popularity');

        if ($request->has('title')) {
            $collection = $collection->where('title', 'like', '%' . $request->title . '%');
        }

        /* Order By Likes and Title */
        $collection = $collection->orderBy('popularity', 'desc')->orderBy('title', 'asc');

        return $collection->get();
    }
}
