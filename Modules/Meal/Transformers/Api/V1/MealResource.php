<?php

namespace Modules\Meal\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\Transformers\Api\V1\MediaResource;


class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $customer = $request->user("customer");

        return [
            'id' => $this->id,
            'name' => $this->name,
            'calories' => [
                'total' => $this->calories,
                'protein' => $this->protein_calories_per_unit,
                'carbs' => $this->carbs_calories_per_unit,
                'fat' => $this->fat_calories_per_unit,
                'sugars' => $this->sugars_calories_per_unit,
            ],
            'thumbnail' => new MediaResource($this->thumbnail),
            'meal_ingredients' => IngredientResource::collection($this->ingredients),
            'min_qty' => $this->min_qty,
            'max_qty' => $this->max_qty,
            'has_unfavourable_ingredients' => $customer->unfavourableIngredients($this->ingredients->pluck('id')->toArray())['have_unfavourite_ingredients'],
            'unfavourable_ingredients' => $customer->unfavourableIngredients($this->ingredients->pluck('id')->toArray())['unfavourite_ingredient_names'],



        ];
    }
}