<?php

namespace Modules\Slider\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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

            'slides' => SlideResource::collection($this->slides)
        ];
    }
}