<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
//use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public Collection $categories;
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {
        $this->categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->select('categories.*', DB::raw('count(*) as total'))
            ->groupBy('categories.id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $categories = $this->categories;
        return view('layouts.app', compact('categories'));
    }
}
