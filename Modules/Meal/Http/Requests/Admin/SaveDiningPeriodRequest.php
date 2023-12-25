<?php

namespace Modules\Meal\Http\Requests\Admin;


use Modules\Core\Http\Requests\Request;


class SaveDiningPeriodRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'dining_periods';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            ...$this->getTranslationRules(['name' => 'required']),
            "is_active" => "required|boolean",
            'categories' => 'required|array',
            'files.icon' => 'required',
            'times' => 'required|array',
            'times.*.from' => 'required',
            'times.*.to' => 'required|after:times.*.from',
            'times.*.is_active' => 'required|boolean',

        ];
    }
}