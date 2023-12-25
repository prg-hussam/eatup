<?php

namespace Modules\Meal\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\Transformers\Api\V1\MediaResource;

class DiningPeriodResource extends JsonResource
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
            'name' => $this->name,
            'time_slots' => array_filter($this->times, fn ($item) =>  $item['is_active'] === true),
            'icon' => new MediaResource($this->icon),
        ];
    }
}