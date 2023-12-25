<?php

namespace Modules\Meal\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'icon' => $this->icon['url'] ?? null,
            'is_active' => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}