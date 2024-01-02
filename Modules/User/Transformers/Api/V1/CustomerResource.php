<?php

namespace Modules\User\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;


class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //TODO:: if we want eager loading some relations
        // $this->load([

        // ]);
        dd($this->subscription);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => str_replace(' ', '', $this->phone),
            'is_profile_completed' => $this->is_profile_completed,
            'weight' => $this->weight,
            'height' => $this->height,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'daily_calories' => $this->daily_calories,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}