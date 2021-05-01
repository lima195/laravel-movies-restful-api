<?php

namespace App\Repository;

use App\Model\Movie;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;

/**
 * Interface MovieRepositoryInterface
 * @package App\Repository
 */
interface MovieRepositoryInterface
{
    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection;
}
