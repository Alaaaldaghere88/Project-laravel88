<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ['name'];
    protected $casts = [
        'name' => 'array',
    ];
}
