<?php

namespace Modules\Verification\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Request;

class VerifyRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var array
     */
    protected $availableAttributes = 'verifications';

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
            "token" => "required|string|max:60",
            "code" => "required|string|max:5",
        ];
    }
}
