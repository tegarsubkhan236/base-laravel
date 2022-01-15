<?php
    namespace App\Casts;

    class UserLevel
    {
        public const SUPER_ADMIN = 1;
        public const ADMIN = 2;
        public const STOCK_USER = 3;

        public static function lang($v): string
        {
            switch ($v){
                case self::SUPER_ADMIN :
                    return "SUPER ADMIN";
                case self::ADMIN :
                    return "ADMIN";
                case self::STOCK_USER :
                    return "STOCK_USER";
                default:
                    return "Unidentified";
            }
        }
    }
