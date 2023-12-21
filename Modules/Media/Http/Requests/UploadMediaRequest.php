<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;
use Modules\Media\MediaHelper;

class UploadMediaRequest extends Request
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
            'file' => "file||mimes:{$this->getAllowedMimeTypes()}|max:" . MediaHelper::$maxFileSize,
            "folder_id" => ["nullable", Rule::exists('files', 'id')
                ->where("entity_id", $user->id)
                ->where("entity_type", get_class($user))]
        ];
    }

    /**
     * Get allowed mime types
     * @return string
     */
    protected function getAllowedMimeTypes(): string
    {
        return implode(',', MediaHelper::$supportedMime);
    }
}
