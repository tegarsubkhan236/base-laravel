<?php
    namespace App\Casts;

    class UserLevel
    {
        public const SUPER_ADMIN = 1;
        public const ADMIN = 2;
        public const USER = 3;

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
