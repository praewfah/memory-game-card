<?php

if (!function_exists('is_matched')) {
    function is_matched($first, $second)
    {
        return $first == $second ? true : false;
    }
}