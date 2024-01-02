<?php

namespace Modules\Meal\Http\Requests\Admin;


use Modules\Core\Http\Requests\Request;


class SaveMenuRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'menus';

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
            "is_default" => "required|boolean",
        ];
    }
}
