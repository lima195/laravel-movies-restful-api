<?php

namespace App\Repository;

use App\Model\Movie;
use Illuminate\Support\Collection;

/**
 * Interface MovieRepositoryInterface
 * @package App\Repository
 */
interface MovieRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
