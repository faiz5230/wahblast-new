<?php

namespace App\Enums;

enum StatusMessage: int
{
    case FAILED                       = 0;
    case DELIVERED                    = 90;
    case RECEIVED                  = 100;

    public function alias(): string
    {
        return match ($this)
        {
            StatusMessage::FAILED                       => 'Failed',
            StatusMessage::DELIVERED                    => 'Delivered',
            StatusMessage::RECEIVED                  => 'Received',
        };
    }

    public function color(): string
    {
        return match ($this) {
            StatusMessage::FAILED                  => 'danger',
            StatusMessage::DELIVERED              => 'primary',
            StatusMessage::RECEIVED        => 'success',
        };
    }
}
