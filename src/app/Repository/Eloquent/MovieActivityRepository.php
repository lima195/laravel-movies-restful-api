<?php

namespace App\Repository\Eloquent;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InsufficientMoneyException;
use App\Exceptions\MovieAlreadyPaidException;
use App\Exceptions\MovieNotAvailableException;
use App\Models\MovieActivity;
use App\Repository\MovieActivityRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Repository\MovieRepositoryInterface;

/**
 * Class MovieActivityRepository
 * @package App\Repository\Eloquent
 */
class MovieActivityRepository extends BaseRepository implements MovieActivityRepositoryInterface
{
    /**
     * @var MovieRepositoryInterface
     */
    private $movieRepository;

    /**
     * MovieActivityRepository constructor.
     * @param MovieActivity $model
     * @param MovieRepositoryInterface $movieRepository
     */
    public function __construct(
        MovieActivity $model,
        MovieRepositoryInterface $movieRepository
    ) {
        $this->movieRepository = $movieRepository;
        parent::__construct($model);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function all($type, $id = false): Collection
    {
        $collection = $this->model;

        /* Only if available */
        $collection = $collection->where('user_id', auth()->user()->id);
        $collection = $collection->where('type', $type);

        if ($id) {
            $collection = $collection->where('id', $id);
        }

        $collection = $collection->orderBy('created_at', 'desc');

        return $collection->get();
    }

    /**
     * @param $movieId
     * @param $credit
     * @return bool
     * @throws MoivieAlreadyPaidException
     * @throws MovieNotAvailableException
     */
    public function purchase($movieId, $credit): bool
    {
        $movie = $this->movieRepository->find($movieId);

        if ($movie->stock < $movie::MIN_STOCK || $movie->availability != $movie::DEFAULT_POSITIVE_AVAILABILITY) {
            throw new MovieNotAvailableException();
        }

        if ($movie->sale_price > $credit) {
            throw new MoivieAlreadyPaidException($movie->sale_price);
        }

        $movieActivity = $this->model;

        \DB::transaction(function () use ($movie, $movieActivity, $credit) {
            try {
                $movie->update(['stock' => $movie->stock - 1]);
                $movieActivity->create([
                    'movie_id' => $movie->id,
                    'user_id' => auth('api')->user()->id,
                    'type' => $movieActivity::PURCHASE,
                    'paid' => $credit,
                    'penalty' => $movieActivity::PENALTY_NONE,
                    'concluded' => $movieActivity::CONCLUDED
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                var_dump($e->getMessage());
                return false;
            }
        });

        return true;
    }

    /**
     * @param $movieId
     * @return bool
     * @throws MovieNotAvailableException
     */
    public function rent($movieId): bool
    {
        $movie = $this->movieRepository->find($movieId);

        if ($movie->stock < $movie::MIN_STOCK || $movie->availability != $movie::DEFAULT_POSITIVE_AVAILABILITY) {
            throw new MovieNotAvailableException();
        }

        $movieActivity = $this->model;

        \DB::transaction(function () use ($movie, $movieActivity) {
            try {
                $movie->update(['stock' => $movie->stock - 1]);
                $movieActivity->create([
                    'movie_id' => $movie->id,
                    'user_id' => auth('api')->user()->id,
                    'type' => $movieActivity::RENT,
                    'paid' => 0,
                    'penalty' => $movieActivity::PENALTY_NONE,
                    'concluded' => $movieActivity::UNCONCLUDED
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                var_dump($e->getMessage());
                return false;
            }
        });

        return true;
    }

    /**
     * @param $movieId
     * @param $rentId
     * @param $credit
     * @return bool
     */
    public function payRent($movieId, $rentId, $credit): bool
    {
        $movieActivity = $this->find($rentId);

        if ($movieActivity->concluded == $movieActivity::CONCLUDED) {
            throw new MovieAlreadyPaidException();
        }

        $movie = $this->movieRepository->find($movieActivity->movie->id);

        $penalty = $movieActivity->getPenalty();
        $totalToPay = $movie->sale_price + $penalty;

        if ($totalToPay > $credit) {
            throw new InsufficientMoneyException("$totalToPay|$penalty");
        }

        \DB::transaction(function () use ($movie, $movieActivity, $credit, $penalty) {
            try {
                $movie->update(['stock' => $movie->stock + 1]);
                $movieActivity->update([
                    'paid' => $credit,
                    'penalty' => $penalty,
                    'concluded' => $movieActivity::CONCLUDED
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                var_dump($e->getMessage());
                return false;
            }
        });

        return true;
    }
}
