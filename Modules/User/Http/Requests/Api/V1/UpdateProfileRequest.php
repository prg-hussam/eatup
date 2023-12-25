<?php

namespace Modules\User\Http\Requests\Api\V1;


use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;

class UpdateProfileRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'profile';

    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributesPrefix = 'api';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required|min:2|max:200',
            'birth_date' => 'required|date',
            'daily_calories' => 'required|numeric|min:1|max:9999999',
            'gender' => 'required|numeric|' . Rule::in([1, 2]),  // 1-Male 2-Female
            'weight' => 'required|numeric|min:30|max:300',
            'height' => 'required|numeric|min:100|max:250',
            'ingredients' => 'array',
            'ingredients.*' => 'nullable|numeric|' . Rule::exists("ingredients", "id"),
        ];
    }
}