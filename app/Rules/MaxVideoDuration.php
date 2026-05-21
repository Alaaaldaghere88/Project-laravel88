<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use getID3;

class MaxVideoDuration implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $getID3 = new getID3;
        $file = $getID3->analyze($value->getRealPath());
        if (!isset($file['playtime_seconds']) || $file['playtime_seconds'] > 30) {
            $fail(__('validation.max_video_duration', ['seconds' => 30]));
        }
    }
}
