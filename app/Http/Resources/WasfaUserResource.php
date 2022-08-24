<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WasfaUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'note' => $this->note,
            'countity' => $this->countity,
            'status' => $this->status,
            'chef' => $this->chef->name,
            'user' => $this->user->name,
            'wasfa' => $this->wasfa->name,
        ];
    }
}
