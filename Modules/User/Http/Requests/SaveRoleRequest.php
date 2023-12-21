<?php

namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveRoleRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'roles';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => ['required', $this->uniqueRule('roles', 'admin.roles.update')],
        ], $this->getTranslationRules([
            'display_name' => 'required',
        ]));
    }
}
