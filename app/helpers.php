<?php

function number_format_short( $n, $precision = 2 ): string
{
    if ($n > 0){
        if ($n < 900000) {
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000000) {
            $n_format = number_format($n / 1000000, $precision);
            $suffix = ' M';
        } else if ($n < 900000000000) {
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = ' B';
        } else {
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = ' T';
        }
    }
    else{
        if ($n > -900000) {
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n > -900000000) {
            $n_format = number_format($n / 1000000, $precision);
            $suffix = ' M';
        } else if ($n > -900000000000) {
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = ' B';
        } else {
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = ' T';
        }
    }
    if ( $precision > 0 ) {
        $zero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $zero, '', $n_format );
    }
    return $n_format . $suffix;
}

function number_format_percentage($n): string
{
    return (number_format($n,4)*100) . " %";
}

function date_format_diffForHumans($n){
    return $n->diffForHumans();
}
