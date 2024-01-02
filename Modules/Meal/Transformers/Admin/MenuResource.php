<?php

namespace Modules\Meal\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}
