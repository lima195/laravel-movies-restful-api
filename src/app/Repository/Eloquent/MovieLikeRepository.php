<?php
declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\MovieLike;
use App\Repository\MovieLikeRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

/**
 * Class MovieLikeRepository
 * @package App\Repository\Eloquent
 */
class MovieLikeRepository extends BaseRepository implements MovieLikeRepositoryInterface
{
    /**
     * @var int $userId
     */
    protected $userId;

    /**
     * MovieRepository constructor.
     *
     * @param MovieLike $model
     */
    public function __construct(MovieLike $model)
    {
        $this->userId = auth('api')->user()->id;

        parent::__construct($model);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function all(Request $request): Collection
    {
        $collection = $this->model->where('error', 0)->orderBy('created_at', 'desc');

        return $collection->get();
    }

    /**
     * @param $movieId
     * @return bool
     */
    public function like($movieId): bool
    {
        if (!$this->userAlreadyLiked($movieId)) {
            $this->create(['user_id' => $this->userId, 'movie_id' => $movieId]);
            return true;
        }

        return false;
    }

    /**
     * @param $movieId
     * @return bool
     */
    public function dislike($movieId): bool
    {
        if ($id = $this->userAlreadyLiked($movieId)) {
            $this->delete($id);
            return true;
        }

        return false;
    }

    /**
     * @param $movieId
     * @return false
     */
    public function userAlreadyLiked($movieId)
    {
        $data = $this->model
            ->where('movie_id', $movieId)
            ->where('user_id', $this->userId)
            ->first();

        return $data ? $data->id : false;
    }
}
