<?php

namespace Modules\Meal\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class DiningPeriodTimeResource extends JsonResource
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
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}