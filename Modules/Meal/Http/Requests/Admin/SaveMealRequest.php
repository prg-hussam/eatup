<?php

namespace Modules\Meal\Http\Requests\Admin;


use Modules\Core\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Modules\Meal\Enums\MealType;
use Modules\Meal\Enums\MealUnit;

class SaveMealRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'meals';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // TODO:: check if calories = sum of all fileds
        return [
            ...$this->getTranslationRules(['name' => 'required']),
            "is_active" => "required|boolean",
            'category_id' => [
                'required', Rule::exists("categories", "id")->where("is_active", true)
                    ->whereNull("deleted_at")
            ],

            "ingredients" => [
                "required",
                'array',
                Rule::exists("ingredients", "id")
                    ->where("is_active", true)
                    ->whereNull("deleted_at")
            ],
            "menus" => [
                "required",
                'array',
                Rule::exists("menus", "id")
                    ->where("is_active", true)
                    ->whereNull("deleted_at")
            ],
            "diningPeriods" => [
                "required",
                'array',
                Rule::exists("dining_periods", "id")
                    ->where("is_active", true)
                    ->whereNull("deleted_at")
            ],

            'type' => [
                'required',
                'string',
                Rule::in(MealType::values()),
            ],

            'unit' => [
                'required',
                'string',
                Rule::in(MealUnit::values()),
                Rule::in($this->type == MealType::Count->value ?  MealUnit::Piece->value :  MealUnit::Gram->value),
            ],

            'min_qty' => ['required', 'numeric', 'min:1', 'max:999', 'lt:max_qty'],
            'max_qty' => ['required', 'numeric', 'min:1', 'max:999', 'gt:min_qty'],

            'protein_calories_per_unit' => ['required', 'numeric', 'min:0', 'max:99999'],
            'carbs_calories_per_unit' => ['required', 'numeric', 'min:0', 'max:99999'],
            'fat_calories_per_unit' => ['required', 'numeric', 'min:0', 'max:99999'],
            'sugars_calories_per_unit' => ['required', 'numeric', 'min:0', 'max:99999'],


            'files.thumbnail' => 'required',
        ];
    }
}
