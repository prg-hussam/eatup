<?php

namespace Modules\Meal\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowMealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load('menus');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'menus' => MenuResource::collection($this->menus),
            'calories' => $this->calories,
            'category' => $this->category->name,
            'type_text' => $this->getTypeText(),
            'thumbnail' => $this->thumbnail['url'] ?? null,
            'is_active' => $this->is_active,
        ];
    }
}
