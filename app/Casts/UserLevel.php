<?php
    namespace App\Casts;

    class UserLevel
    {
        const SUPER_ADMIN = 1;
        const ADMIN = 2;
        const USER = 3;

        public static function lang($v): string
        {
            switch ($v){
                case self::SUPER_ADMIN :
                    return "SUPER ADMIN";
                    break;
                case self::ADMIN :
                    return "ADMIN";
                    break;
                case self::USER :
                    return "USER";
                    break;
                default:
                    return "Unidentified";
            }
        }
    }
