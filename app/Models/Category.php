<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',

    ];
    protected $casts = ['name'=>'array'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
