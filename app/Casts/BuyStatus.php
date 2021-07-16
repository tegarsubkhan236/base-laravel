<?php
namespace App\Casts;

class BuyStatus
{
    public const Pending = 1;
    public const AccOwner = 2;
    public const AccSupplier = 3;
    public const OnGoing = 4;
    public const Complete = 5;

    public static function lang($status): string
    {
        switch ($status){
            case self::Pending :
                return "PENDING";
                break;
            case self::AccOwner :
                return "Acc by Owner";
                break;
            case self::AccSupplier :
                return "Acc by Supplier";
                break;
            case self::OnGoing :
                return "On Going";
                break;
            case self::Complete :
                return "COMPLETE";
                break;
            default :
                return "Unidentified";
        }
    }
}
