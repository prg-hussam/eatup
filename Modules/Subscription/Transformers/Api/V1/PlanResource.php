<?php

namespace Modules\Subscription\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'duration' => $this->duration,
            'pricing' => PlanPriceResource::collection($this->planPrices),

        ];
    }
}