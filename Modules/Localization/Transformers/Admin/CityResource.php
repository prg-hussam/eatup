<?php

namespace Modules\Localization\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'province' => $this->province->name,
            'is_active' => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}