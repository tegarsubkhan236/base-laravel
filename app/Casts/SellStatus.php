<?php
namespace App\Casts;

class SellStatus
{
    public const Pending = 1;
    public const Complete = 2;

    public static function lang($status): string
    {
        switch ($status){
            case self::Pending :
                return "PENDING";
                break;
            case self::Complete :
                return "COMPLETE";
                break;
            default :
                return "Unidentified";
        }
    }
}
