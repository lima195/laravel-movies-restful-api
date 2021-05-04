<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected const DEFAULT_PAGE = 1;
    protected const DEFAULT_PER_PAGE = 10;
    protected const DEFAULT_MAX_PER_PAGE = 25;

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        $data = $this->model->find($id);

        if (!$data) {
            throw new DataNotFoundException($this->model->getTable());
        }

        return $data;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|null
     */
    public function update($id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }
}
