<?php

namespace Modules\User\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => substr($this->phone, 1),
            'is_active' => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}