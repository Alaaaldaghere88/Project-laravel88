<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            'title'=>$this->title,
            'body'=>$this->body,
            'property'=>PropertyResource::make(Property::find($this->property_id)),
            'user'=>UserResource::make(User::find($this->user_id)),
            'replays'=>ReviewReplayResource::collection($this->replays),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
