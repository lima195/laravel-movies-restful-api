<?php
declare(strict_types=1);

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Interface MovieLikeRepositoryInterface
 * @package App\Repository
 */
interface MovieLikeRepositoryInterface
{
    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection;
}
