<?php

namespace Modules\User\Http\Requests\Admin;

use Modules\Core\Http\Requests\Request;

class SaveUserRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'users';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'alpha_dash', 'max:255', $this->uniqueRule('users', 'admin.users.update')],
            'email' => ['required', 'email', $this->uniqueRule('users', 'admin.users.update')],
            'name' => ['required', 'max:255'],
            'password' => $this->requiredInSpecificRoute('admin.users.store') . '|confirmed|min:8|max:25',
            'roles' => 'required|array',
        ];
    }
}