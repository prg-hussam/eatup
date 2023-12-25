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
            'duration' => 'required|numeric|min:1|max:100|' . $this->uniqueRule('plans', 'admin.plans.update'),
            'price' => 'required|numeric|min:1|max:9999',
            "is_active" => "required|boolean",
        ];
    }
}