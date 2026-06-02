<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewReplay extends Model
{
    protected $fillable = ['user_id','review_id','title','body'];
    public function review():BelongsTo{
        return $this->belongsTo(Review::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
