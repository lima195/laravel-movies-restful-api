<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MovieRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    private $movieRepository;

    /**
     * MovieController constructor.
     * @param MovieRepositoryInterface $movieRepository
     */
    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function find($id): \Illuminate\Http\JsonResponse
    {
        $movie = $this->movieRepository->find($id);

        return response()->json($movie);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        $movie = $this->movieRepository->all($request);
        return response()->json($movie)->withHeaders(['X-Total-Count', 1]);
    }
}
