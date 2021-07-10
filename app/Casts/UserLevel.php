<?php
    namespace App\Casts;

    class UserLevel
    {
        public const SUPER_ADMIN = 1;
        public const ADMIN = 2;
        public const WAREHOUSE = 3;
        public const OWNER = 4;
        public const SUPPLIER = 5;

        public static function lang($v): string
        {
            switch ($v){
                case self::SUPER_ADMIN :
                    return "SUPER ADMIN";
                case self::ADMIN :
                    return "ADMIN";
                case self::WAREHOUSE :
                    return "WAREHOUSE";
                case self::OWNER :
                    return "OWNER";
                case self::SUPPLIER :
                    return "SUPPLIER";
                default:
                    return "Unidentified";
            }
        }
    }
