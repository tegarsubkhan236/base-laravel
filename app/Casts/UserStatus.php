<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UserStatus
{
    const ACTIVE = 1;
    const INACTIVE = 0;
}
