<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PropertyStatus extends Enum
{
    public const AVAILABLE = 'AVAILABLE';
    public const RENTED = 'RENTED';
    public const EXPIRED = 'EXPIRED';
    public const DISABLED = 'DISABLED';
    public const MODERATING = 'MODERATING';
    public const PAYMENT_PENDING = 'PAYMENT_PENDING';
}
