<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
];
}
