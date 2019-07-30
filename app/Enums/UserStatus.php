<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    public const AVAILABLE = 'AVAILABLE';
    public const BLOCKED = 'BLOCKED';
}
