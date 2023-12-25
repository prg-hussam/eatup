<?php

namespace Modules\Localization\Http\Requests\Admin;


use Modules\Core\Http\Requests\Request;


class SaveProvinceRequest extends Request
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
            "is_active" => "required|boolean",

        ];
    }
}