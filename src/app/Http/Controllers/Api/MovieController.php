<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MovieRepositoryInterface;
use App\Models\Movie as MovieModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    use Movie\FormValidations;

    /**
     * @var MovieRepositoryInterface
     */
    private $movieRepository;

    /**
     * @var MovieModel
     */
    private $movie;

    /**
     * MovieController constructor.
     * @param MovieRepositoryInterface $movieRepository
     * @param MovieModel $movie
     */
    public function __construct(
        MovieRepositoryInterface $movieRepository,
        MovieModel $movie
    ) {
        $this->movieRepository = $movieRepository;
        $this->movie = $movie;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function find($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->movieRepository->find($id);

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->movieRepository->all($request);

        $pagination = [
            'page' => $this->movieRepository->page,
            'per_page' => $this->movieRepository->perPage,
            'total_this_page' => $data->count(),
            'total' => $this->movieRepository->total,
            'total_pages' => ceil($this->movieRepository->total / $this->movieRepository->perPage)
        ];

        return response()->json(['pagination' => $pagination, 'data' => $data])->withHeaders([
            'X-Total-Count',
            $this->movieRepository->total
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $this->movieRepository->create($this->_prepareData($request));
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $data = false;
        $updated = $this->movieRepository->update($request->route('id'), $this->_prepareData($request));

        if ($updated) {
            $newData = $this->find($request->route('id'));
            $data = $newData->original->toArray();
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $data = $this->movieRepository->delete($request->route('id'));
        return response()->json($data);
    }
}
