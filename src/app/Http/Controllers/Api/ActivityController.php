<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MovieActivityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MovieActivity;

/**
 * Class ActivityController
 * @package App\Http\Controllers\Api
 */
class ActivityController extends Controller
{
    /**
     * @var MovieActivityRepositoryInterface
     */
    private $activityRepository;

    /**
     * @var MovieActivity
     */
    private $movieActivity;

    /**
     * LogController constructor.
     * @param MovieActivityRepositoryInterface $movieActivityRepository
     */
    public function __construct(
        MovieActivityRepositoryInterface $movieActivityRepository,
        MovieActivity $movieActivity
    ) {
        $this->movieActivity = $movieActivity;
        $this->activityRepository = $movieActivityRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \App\Exceptions\MoivieAlreadyPaidException
     * @throws \App\Exceptions\MovieNotAvailableException
     */
    public function purchase(Request $request): JsonResponse
    {
        if(!$request->input('credit')) {
            return response()->json(['error' => "Missing Credit"], 500);
        }

        $data = $this->activityRepository->purchase($request->route('id'), $request->input('credit'));
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listPurchase(): JsonResponse
    {
        $data = $this->activityRepository->all($this->movieActivity::PURCHASE);
        return response()->json($data)->withHeaders(['X-Total-Count', 1]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findPurchase(Request $request): JsonResponse
    {
        $data = $this->activityRepository->all($this->movieActivity::PURCHASE, $request->route('purchase_id'));
        return response()->json($data)->withHeaders(['X-Total-Count', 1]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \App\Exceptions\MovieNotAvailableException
     */
    public function rent(Request $request): JsonResponse
    {
        $data = $this->activityRepository->rent($request->route('id'));
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listRent(Request $request): JsonResponse
    {
        $data = $this->activityRepository->all($this->movieActivity::RENT);
        return response()->json($data)->withHeaders(['X-Total-Count', 1]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findRent(Request $request): JsonResponse
    {
        $rentId = $request->route('rent_id');

        $data = $this->activityRepository->all($this->movieActivity::RENT, $rentId);
        return response()->json($data)->withHeaders(['X-Total-Count', 1]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function payRent(Request $request): JsonResponse
    {
        $movieId = $request->route('id');
        $rentId = $request->route('rent_id');

        if(!$request->input('credit')) {
            return response()->json(['error' => "Missing Credit"], 500);
        }

        $data = $this->activityRepository->payRent($movieId, $rentId, $request->input('credit'));
        return response()->json($data);
    }
}
