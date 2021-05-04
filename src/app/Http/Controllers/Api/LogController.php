<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MovieLogRepositoryInterface;
use App\Models\Movie as MovieModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class LogController
 * @package App\Http\Controllers\Api
 */
class LogController extends Controller
{
    /**
     * @var MovieRepositoryInterface
     */
    private $logRepository;

    /**
     * LogController constructor.
     * @param MovieLogRepositoryInterface $movieLogRepository
     */
    public function __construct(
        MovieLogRepositoryInterface $movieLogRepository
    ) {
        $this->logRepository = $movieLogRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->logRepository->all($request);

        $pagination = [
            'page' => $this->logRepository->page,
            'per_page' => $this->logRepository->perPage,
            'total_this_page' => $data->count(),
            'total' => $this->logRepository->total,
            'total_pages' => ceil($this->logRepository->total / $this->logRepository->perPage)
        ];

        $data = $data->map(function ($log) {
            $log->data = unserialize($log->data);
            return $log;
        });

        return response()->json(['pagination' => $pagination, 'data' => $data])->withHeaders([
            'X-Total-Count',
            $this->logRepository->total
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function findByMovie($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->logRepository->findByMovie($id)->map(function ($log) {
            $log->data = unserialize($log->data);
            return $log;
        })->first();

        return response()->json($data);
    }
}
