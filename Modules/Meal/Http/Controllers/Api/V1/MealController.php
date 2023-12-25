<?php

namespace Modules\Meal\Http\Controllers\Api\V1;

use App\Platform;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Meal\Entities\Meal;
use Modules\Meal\Transformers\Api\V1\MealResource;

class MealController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $period, string $category): JsonResponse
    {

        return ApiResponse::success([
            "records" => MealResource::collection(
                app(Pipeline::class)
                    ->send(Meal::with(['files', 'ingredients'])->where('category_id', $category)->whereHas('diningPeriods', fn ($query) => $query->where('dining_period_id', $period)))
                    ->thenReturn()
                    ->latest()
                    ->skip(request()->get('skip', 0))
                    ->take(Platform::paginate())
                    ->get()
            )
        ]);
    }
}