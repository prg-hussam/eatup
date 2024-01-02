<?php

namespace Modules\Subscription\Http\Requests\Admin;


use Modules\Core\Http\Requests\Request;


class SavePlanRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'plans';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {



        return [
            ...$this->getTranslationRules(['name' => 'required|min:3']),
            'duration' => 'required|numeric|min:1|max:365|' . $this->uniqueRule('plans', 'admin.plans.update'),
            'prices' => 'required|array',
            'prices.*.dining_period_id' => 'required',
            'prices.*.price' => 'required|numeric|min:1|max:999999',
            'prices.*.is_active' => 'required|boolean',
            "is_active" => "required|boolean",
        ];
    }
}