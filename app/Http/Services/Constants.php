<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\App;

class Constants {
    // locales array
    public static function getLocales(): array
    {
        return ['ru', 'en'];
    }

    public static function getCurrentLocale(): string
    {
        return App::getLocale() == 'ru'?'':'.en';
    }


}
