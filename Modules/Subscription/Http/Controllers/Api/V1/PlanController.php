<?php

namespace Modules\Subscription\Http\Controllers\Api\V1;


use App\Platform;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Subscription\Entities\Plan;
use Modules\Subscription\Transformers\Api\V1\PlanResource;

class PlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            "records" => PlanResource::collection(
                app(Pipeline::class)
                    ->send(Plan::with('planPrices'))
                    ->thenReturn()
                    ->latest()
                    ->skip(request()->get('skip', 0))
                    ->take(Platform::paginate())
                    ->get()
            )
        ]);
    }
}