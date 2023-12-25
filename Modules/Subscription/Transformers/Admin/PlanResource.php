<?php

namespace Modules\Subscription\Transformers\Admin;

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
            'price' => $this->price->format(),
            'duration' => $this->getDurationText(),
            'is_active' => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}