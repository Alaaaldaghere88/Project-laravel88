<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
protected $fillable = [
    'user_id',
    'property_id',
    'appointment_date',
    'status',
    'days_num',
    'total_price'
];
protected $casts = [
    'appointment_date' => 'datetime',
    'status' => AppointmentStatus::class,
];
public function user():BelongsTo
{
    return $this->belongsTo(User::class);
}
public function property():BelongsTo
{
    return $this->belongsTo(Property::class);
}
public function payment():HasOne
{
    return $this->hasOne(Payment::class);
}
}
