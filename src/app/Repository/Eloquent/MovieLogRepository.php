<?php

namespace App\Repository\Eloquent;

use App\Models\MovieLog;
use App\Repository\MovieLogRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

/**
 * Class MovieLogRepository
 * @package App\Repository\Eloquent
 */
class MovieLogRepository extends BaseRepository implements MovieLogRepositoryInterface
{

    /**
     * MovieRepository constructor.
     *
     * @param MovieLog $model
     */
    public function __construct(MovieLog $model)
    {
        parent::__construct($model);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection
    {
        $collection = $this->model->where('error', 0);

        /* Total */
        $this->total = $collection->count();

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

        /* Order by lastest */
        $collection->orderBy('created_at', 'desc');

        return $collection->get();
    }

    /**
     * @param $movieId
     * @return Collection|null
     */
    public function findByMovie($movieId): ?Collection
    {
        $data = $this->model->where('movie_id', $movieId);

        return $data->get();
    }
}
