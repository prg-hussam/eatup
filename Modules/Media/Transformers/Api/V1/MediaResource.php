<?php

namespace Modules\Media\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return !is_null($request)
            ? [
                "url" => $this['url'],
            ]
            : null;
    }
}