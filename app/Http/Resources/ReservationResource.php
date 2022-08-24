<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'date' => $this->date,
            'start_from' => $this->start_from,
            'end_from' => $this->end_from,
            'location' => $this->location,
            'location' => $this->location,
            'notes' => $this->notes,
            'status' => $this->status,
            'user_id' => $this->user->name,
            'chif_id' => $this->chif->name,
            'payment_status' => $this->payment_status,
        ];
    }
}
