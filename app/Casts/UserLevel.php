<?php
    namespace App\Casts;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class UserLevel
    {
        const SUPER_ADMIN = 1;
        const ADMIN = 2;
        const USER = 0;
    }
