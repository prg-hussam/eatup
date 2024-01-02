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
        $this->load('times', 'files');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'times' => DiningPeriodTimeResource::collection($this->times),
            'icon' => new MediaResource($this->icon),
        ];
    }
}