<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Loctaion;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'description' => $this->description,
            'price' => (double) $this->price,
            'status' => $this->status,
            'active' => (bool) $this->active,
            'video_url' => $this->video ? asset('storage/' . $this->video) : null,
            'document_url' => $this->document ? asset('storage/' . $this->document) : null,
            'user'=>UserResource::make(User::find($this->user_id)),
            'type' => PropertyTypeResource::make(PropertyType::find($this->type_id)),
            'location' => LoctaionResource::make(Loctaion::find($this->location_id)),
            'category' => CategoryResource::make(Category::find($this->category_id)),
        ];
    }
}
