<?php
declare(strict_types=1);

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Interface MovieActivityRepositoryInterface
 * @package App\Repository
 */
interface MovieActivityRepositoryInterface
{
    /**
     * @param $type
     * @param int|false $id
     * @return Collection
     */
    public function all($type, $id = false): Collection;
}
