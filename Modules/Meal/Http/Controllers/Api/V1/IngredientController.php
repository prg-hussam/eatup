<?php

namespace Modules\Meal\Http\Controllers\Api\V1;

use App\Platform;
use Modules\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Meal\Entities\Ingredient;
use Modules\Meal\Transformers\Api\V1\IngredientResource;

class IngredientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            "records" => IngredientResource::collection(
                app(Pipeline::class)
                    ->send(Ingredient::query())
                    ->thenReturn()
                    ->latest()
                    ->skip(request()->get('skip', 0))
                    ->take(Platform::paginate())
                    ->get()
            )
        ]);
    }
}