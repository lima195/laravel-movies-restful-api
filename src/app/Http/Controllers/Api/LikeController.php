<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MovieLikeRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class LikeController
 * @package App\Http\Controllers\Api
 */
class LikeController extends Controller
{
    /**
     * @var MovieLikeRepositoryInterface
     */
    private $likeRepository;

    /**
     * LogController constructor.
     * @param MovieLikeRepositoryInterface $movieLikeRepository
     */
    public function __construct(
        MovieLikeRepositoryInterface $movieLikeRepository
    ) {
        $this->likeRepository = $movieLikeRepository;
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function like($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->likeRepository->like($id);

        return response()->json($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function dislike($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->likeRepository->dislike($id);

        return response()->json($data);
    }
}
