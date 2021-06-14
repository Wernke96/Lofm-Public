<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\User $this */
        return [
            '_id' => $this->getId(),
            'username' => $this->getName(),
            'created_at' => $this->getCreatedAt()
        ];
    }
}
