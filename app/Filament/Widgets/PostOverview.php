<?php

namespace App\Filament\Widgets;

use App\Models\PostView;
use App\Models\UpvoteDownvote;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends Widget
{
    protected int | string | array $columnSpan = 3;
    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'viewCount' => $this->record ? PostView::where('post_id', $this->record->id)->count() : 0,
            'upvotes' => $this->record ? UpvoteDownvote::where('post_id', $this->record->id)->where('is_upvote', 1)->count() : 0,
            'downvotes' => $this->record ? UpvoteDownvote::where('post_id', $this->record->id)->where('is_upvote', 0)->count() : 0,
        ];
    }

    protected static string $view = 'filament.widgets.post-overview';

    public static function canView(): bool
    {
        return request()->route()->getName() != 'filament.pages.dashboard';
    }

}
