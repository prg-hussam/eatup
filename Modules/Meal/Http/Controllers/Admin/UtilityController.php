<?php

namespace Modules\Meal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Illuminate\Http\Response;

class UtilityController extends Controller
{
    public function getPeriodsByCategory($id)
    {
        $category = Category::with('diningPeriods')->where('id', $id)->first();
        if (!$category) {
            return response()->json([
                'diningPeriods' => [],
            ]);
        }

        $diningPeriods =  $category->diningPeriods->map(function ($diningPeriod) {
            return [
                'id' => $diningPeriod->id,
                'name' => $diningPeriod->name
            ];
        })->toArray();

        return response()->json([
            'diningPeriods' => $diningPeriods
        ], Response::HTTP_OK);
    }
}