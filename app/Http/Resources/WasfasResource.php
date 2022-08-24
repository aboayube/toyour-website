<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WasfasResource extends JsonResource
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
            'name' => $this->name,
            'discription' => $this->description,
            'status' => $this->status,
            'image' => $this->image,
            'price' => $this->price,
            'time_make' => $this->time_make,
            'number_user' => $this->number_user,
            'advertise' => $this->advertise,
            'catory' => $this->category->name,
            'wafa_contnet' => WasfaContentResource::collection($this->wasfa_content),
        ];
    }
}
