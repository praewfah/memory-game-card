<?php

namespace App\Repositories;

use Illuminate\Support\Str;

class CookieRepository
{
    public static function setCookie($field, $value) 
    {
        return setcookie($field, $value);
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
