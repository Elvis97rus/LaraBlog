<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class PostItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Post $post, public bool $showAuthor = true, public int $titleSize = 3)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-item');
    }
}
