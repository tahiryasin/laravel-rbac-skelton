<?php

namespace App\Helpers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper
{

    public static function version()
    {
        $laravel = app();
        return $laravel::VERSION;
    }

    public static function splitAtUpperCase($s)
    {
        return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
    }

}
