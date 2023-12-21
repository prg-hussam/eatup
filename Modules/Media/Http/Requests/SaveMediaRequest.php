<?php

namespace Modules\Media\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveMediaRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'media';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        return [
            "name" => "required|max:200",
        ];
    }
}
