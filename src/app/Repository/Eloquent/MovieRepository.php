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
    public $page;
    public $perPage;

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
        /* Only if available */
        $collection = $this->model
            ->where('availability', $this->model::DEFAULT_POSITIVE_AVAILABILITY)
            ->where('stock', '>', 0)
            ->withCount('likes as popularity');

        if ($request->has('title')) {
            $collection->where('title', 'like', '%' . $request->title . '%');
        }

        /* Total */
        $count = $collection->count();

        /* Pagination */
        $this->perPage = !empty($request->per_page) ? (int)$request->per_page : (int)self::DEFAULT_PER_PAGE;
        $this->perPage = ($this->perPage > self::DEFAULT_MAX_PER_PAGE) ? (int)self::DEFAULT_MAX_PER_PAGE : $this->perPage;
        if ($this->perPage) {
            $collection->limit($this->perPage);
        }
        $this->page = !empty($request->page) ? (int)$request->page : (int)self::DEFAULT_PAGE;
        if ($this->page) {
            $collection->offset(($this->page - 1) * $this->perPage);
        }

        /* Order By Likes and Title */
        $collection->orderBy('popularity', 'desc')->orderBy('title', 'asc');

        /* Run query */
        $collection = $collection->get();

        /* Add total to collection */
        $collection->total = $count;

        return $collection;
    }
}
