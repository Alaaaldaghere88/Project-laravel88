<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Available = 'available';
    case NOT_Available = 'not_available';
    public function label(): string
    {
        return match($this) {
            self::Available => 'متاحة',
            self::NOT_Available => 'غير متاحة',
        };
    }
}
