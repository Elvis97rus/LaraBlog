<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TextWidget extends Model
{
    use HasFactory;

    protected $fillable = [
                            'key',
                            'image',
                            'title',
                            'content',
                            'active'
    ];

    public static function getTitle(string $key): string
    {
//        $widget = Cache::get('text-widget-' . $key, function () use($key) {
//            return TextWidget::query()
//                ->where('key', '=', $key)
//                ->where('active', '=', 1)
//                ->first();
//        });
        $widget = TextWidget::getCacheWidgetByKey('text-widget-', $key);

        if ($widget) {
            return  $widget->title;
        }

        return '';
    }
    public static function getContent(string $key): string
    {
//        $widget = Cache::get('text-widget-' . $key, function () use($key) {
//            return TextWidget::query()
//                ->where('key', '=', $key)
//                ->where('active', '=', 1)
//                ->first();
//        });
        $widget = TextWidget::getCacheWidgetByKey('text-widget-', $key);

        if ($widget) {
            return  $widget->content;
        }

        return '';
    }

    public static function getFull(string $key): TextWidget | string
    {
        $widget = TextWidget::getCacheWidgetByKey('text-widget-', $key);

        if ($widget) {
            return  $widget;
        }

        return '';
    }

    protected static function getCacheWidgetByKey($prefix, $key){
        return Cache::get($prefix . $key, function () use($key) {
            return TextWidget::query()
                ->where('key', '=', $key)
                ->where('active', '=', 1)
                ->first();
        });
    }
}
