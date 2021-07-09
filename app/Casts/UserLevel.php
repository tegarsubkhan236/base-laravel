<?php
    namespace App\Casts;

    class UserLevel
    {
        public const SUPER_ADMIN = 1;
        public const ADMIN = 2;
        public const WAREHOUSE = 3;
        public const OWNER = 4;

        public static function lang($v): string
        {
            switch ($v){
                case self::SUPER_ADMIN :
                    return "SUPER ADMIN";
                    break;
                case self::ADMIN :
                    return "ADMIN";
                    break;
                case self::WAREHOUSE :
                    return "WAREHOUSE";
                    break;
                case self::OWNER :
                    return "OWNER";
                    break;
                default:
                    return "Unidentified";
            }
        }
    }
