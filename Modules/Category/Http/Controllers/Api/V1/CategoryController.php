<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use App\Platform;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\Api\V1\CategoryResource;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param string $diningPeriod
     * @return \Illuminate\Http\JsonResponse
     */

    public function getCategoriesByPeriod(string $diningPeriod): JsonResponse
    {

        return ApiResponse::success([
            "records" => CategoryResource::collection(
                app(Pipeline::class)
                    ->send(Category::whereHas('diningPeriods', fn ($query) => $query->where('dining_period_id', $diningPeriod)))
                    ->thenReturn()
                    ->latest()
                    ->skip(request()->get('skip', 0))
                    ->take(Platform::paginate())
                    ->get()
            )
        ]);
    }
}