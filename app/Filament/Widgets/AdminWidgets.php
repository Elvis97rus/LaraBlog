<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminWidgets extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Всего пользователей', User::count()),
            Card::make('Зарегистрировано сегодня', User::whereDate('created_at', today())->count()),
            Card::make('Опубликовано постов', Post::where('active', 1)->whereDate('published_at', '<', Carbon::now())->count()),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->canAccessFilament();
    }
}
