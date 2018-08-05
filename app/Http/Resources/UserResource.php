<?php

namespace App\Http\Resources;

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
            'id'        => $this->id,
            'name'      => $this->name,
            'truename'  => $this->when(!is_null($this->truename), $this->truename),
            'sex'       => $this->sex,
            'phone'     => $this->phone,
            'avatar'    => $this->avatar,
            'identify'  => $this->identify,
            'points'    => $this->points,
            'status'    => $this->status
        ];
    }
}
