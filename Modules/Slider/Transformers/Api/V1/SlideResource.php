<?php

namespace Modules\Slider\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\Transformers\Api\V1\MediaResource;

class SlideResource extends JsonResource
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
            'id' => $this->id,
            'banner' =>  new MediaResource($this->banner),
        ];
    }
}