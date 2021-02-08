<?php

namespace App\Repositories;

use Illuminate\Support\Str;

class CookieRepository
{
    public static function setCookie($field, $value) 
    {
        if (setcookie($field, $value))
            return $value;

        return (false);
    }

    public static function getCookie($field) 
    {
        if(isset($_COOKIE[$field]))
            return $_COOKIE[$field];

        return (false);
    }

    public static function generateToken()
    {
        return hash('sha256', Str::random(60));
    }
}
