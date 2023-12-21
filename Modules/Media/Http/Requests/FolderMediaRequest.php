<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;

class FolderMediaRequest extends Request
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
            "folder_name" => "required|max:200",
            "folder_id" => ["nullable", Rule::exists('files', 'id')
                ->where("entity_id", $user->id)
                ->where("entity_type", get_class($user))]
        ];
    }
}
