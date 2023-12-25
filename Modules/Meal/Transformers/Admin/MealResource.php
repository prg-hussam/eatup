<?php

namespace Modules\Meal\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'calories' => $this->calories,
            'category' => $this->category->name,
            'type_text' => $this->getTypeText(),
            'thumbnail' => $this->thumbnail['url'] ?? null,
            'is_active' => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}