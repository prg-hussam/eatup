<?php

namespace Modules\User\Http\Requests\Api\V1\Auth;


use Modules\Core\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'auth';

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
            "phone" => ["required", "max:50", "phone:" . setting('default_country'), "unique:customers"],

        ];
    }

    /** @inheritDoc */
    public function validationData(): array
    {

        return  [
            ...parent::validationData(),
            'phone' => phone($this->phone, setting('default_country')),
        ];
    }
}