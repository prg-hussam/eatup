<?php

namespace Modules\Coupon\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "used" => $this->used,
            "code" => $this->code,
            'discount' => $this->isPercent() ? "{$this->value}%" : $this->value->format(),
            "is_active" => $this->is_active,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}