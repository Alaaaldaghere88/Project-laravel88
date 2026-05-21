<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    public function label(): string
    {
        return match($this) {
            self::Available => 'متاحة',
            self::Reserved => 'محجوزة',
        };
    }
}
