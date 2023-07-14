<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\returnArgument;

class Cookies {
    public static function cookieHandler() {
        if(!isset($_COOKIE['user_activity'])) {
            $hash = md5(time()) . time();
            setcookie('user_activity', $hash, time() + 86400, '/');
        }else{
            $hash = $_COOKIE['user_activity'];
        }

        return $hash;
    }
}












