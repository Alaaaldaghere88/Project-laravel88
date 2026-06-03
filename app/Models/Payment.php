<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
protected $fillable = [
    'appointment_id',
    'amount',
    'currency',
    'stripe_session_id',
    'status',
    'stripe_session_url',
];
protected $casts = [
    'amount' => 'decimal:2',
    'stripe_session_id' => 'encrypted',
    'stripe_session_url' => 'encrypted',
];
public function appointment():BelongsTo
{
    return $this->belongsTo(Appointment::class);
}
}
