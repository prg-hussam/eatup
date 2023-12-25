<?php

namespace Modules\Meal\Http\Controllers\Api\V1;

use App\Platform;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Meal\Entities\DiningPeriod;
use Modules\Meal\Transformers\Api\V1\DiningPeriodResource;

class DiningPeriodController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            "records" => DiningPeriodResource::collection(
                app(Pipeline::class)
                    ->send(DiningPeriod::with('files'))
                    ->thenReturn()
                    ->latest()
                    ->skip(request()->get('skip', 0))
                    ->take(Platform::paginate())
                    ->get()
            )
        ]);
    }
}