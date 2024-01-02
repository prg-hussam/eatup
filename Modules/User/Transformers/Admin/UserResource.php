<?php

namespace Modules\User\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'profile_photo_url' => $this->profile_photo_url,
            'is_active' => $this->is_active,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->roles),
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}