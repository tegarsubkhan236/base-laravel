<?php
    namespace App\Casts;

    class UserStatus
    {
        const ACTIVE = 1;
        const INACTIVE = 0;

        public static function lang($status): string
        {
            switch ($status){
                case self::ACTIVE :
                    return "ACTIVE";
                    break;
                case self::INACTIVE :
                    return "INACTIVE";
                    break;
                default :
                    return "Unidentified";
            }
        }
    }
