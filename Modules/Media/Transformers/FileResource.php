<?php

namespace Modules\Media\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "is_folder" => $this->is_folder,
            "filename" => $this->filename,
            "extension" => $this->extension,
            "mime" => $this->mime,
            "type" => strtok($this->mime, '/'),
            "download_url" => $this->download_url,
            "url" => $this->url,
            "preview_image_url" => $this->preview_image_url,
            "human_size" => $this->human_size,
            "size" => $this->size,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}
