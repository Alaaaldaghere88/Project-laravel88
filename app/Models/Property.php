<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'description',
        'price',
        'location_id',
        'type_id',
        'category_id',
        'status',
        'video',
        'document',
        'active',
        'user_id',
    ];
    public function location()
    {
        return $this->belongsTo(Loctaion::class);
    }
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
