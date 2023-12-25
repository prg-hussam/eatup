<?php

namespace Modules\Localization\Http\Requests\Admin;


use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;

class SaveCityRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'provinces';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            ...$this->getTranslationRules(['name' => 'required']),
            'province_id' => [
                'required', Rule::exists("provinces", "id")
            ],
            "is_active" => "required|boolean",

        ];
    }
}