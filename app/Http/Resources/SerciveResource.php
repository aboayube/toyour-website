<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SerciveResource extends JsonResource
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
            'discription' => $this->discription,
            'status' => $this->status == 1 ? 'مفعل' : 'غير مفعل',
            'price' => $this->price,
            'day' => $this->day,
            'user_id' => $this->user->name,
        ];
    }
}
