<?php

namespace Modules\Subscription\Http\Requests\Api\V1;


use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;

class SubscribeRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'subscribe';

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
            'plan_id' => ['required', Rule::exists("plans", "id")],
        ];
    }
}