<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'rooms',
        'capacity'
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
    public function scopeVisibleToUser($query)
{
    $user = auth()->user();
    if ($user?->hasRole('admin')) {
        return $query;
    }
    return $query->where(function ($q) use ($user) {
        $q->where('active', true)
          ->orWhere(function ($subQ) use ($user) {
              $subQ->where('active', false)
                   ->where('user_id', $user?->id);
          });
    });
}
public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
