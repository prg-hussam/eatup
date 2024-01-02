<?php

namespace Modules\Subscription\Transformers\Api\V1;

use Modules\Support\Money;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Meal\Transformers\Api\V1\DiningPeriodResource;

class PlanPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->load(['diningPeriod']);

        return [
            'price' => $this->price,
            'period' => new DiningPeriodResource($this->diningPeriod),
        ];
    }
}