<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'property' => PropertyResource::make($this->property),
            'appointment_date' => $this->appointment_date,
            'days_num'=>$this->days_num,
            'total_price'=>$this->total_price,
           'status' => $this->status?->value
        ];
    }
}
