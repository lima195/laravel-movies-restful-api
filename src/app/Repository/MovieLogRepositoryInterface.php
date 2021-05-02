<?php

namespace App\Repository;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;

/**
 * Interface MovieLogRepositoryInterface
 * @package App\Repository
 */
interface MovieLogRepositoryInterface
{
    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection;
}
