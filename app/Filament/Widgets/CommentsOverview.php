<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class CommentsOverview extends Widget
{
    protected int|string|array $columnSpan = 2;
    protected static string $view = 'filament.widgets.comments-overview';

    public ?Model $comment = null;
    protected static ?int $sort = 3;
    protected $listeners = [
        'deleteComment',
        'approveComment',
    ];

    protected function getViewData(): array
    {
        return [
            'comments' => Comment::where('is_active', false)->get(),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->canAccessFilament();
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();
    }
    public function approveComment($id)
    {
        $comment = Comment::find($id);
        $comment->update([
            'is_active' => true
        ]);
    }
}
