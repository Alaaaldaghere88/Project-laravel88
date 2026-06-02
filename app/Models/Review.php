<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = ['user_id','property_id','title','body'];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function property():BelongsTo{
        return $this->belongsTo(Property::class);
    }
    public function replays():HasMany{
        return $this->hasMany(ReviewReplay::class);
    }
}
