<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
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
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null,
                                public ?Post $postMeta = null, public $pages = null)
    {
//        $this->categories = Category::query()
//            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
//            ->select('categories.*', DB::raw('count(*) as total'))
//            ->groupBy('categories.id')
//            ->orderByDesc('total')
//            ->limit(5)
//            ->get();
        $this->categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->join('posts', 'category_post.post_id', '=', 'posts.id')
            ->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now())
            ->select('categories.title','categories.title_en', 'categories.slug','categories.updated_at', DB::raw('count(*) as total'))
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
        $pag= '';

        $currentPage = request()->get('page') ?? 1;
        if ($this->pages){
            $lastPage = $this->pages->lastPage();
            $nextPage = ($currentPage == $lastPage || $currentPage > $lastPage)?'': $currentPage + 1;
            $prevPage = ($currentPage > 1 || $currentPage < $lastPage) ? $currentPage - 1 : '';
            $pag = [
                'currentPage' => $currentPage,
                'meta_addition' => " - " . __('basic.page_meta') . ' ' . $currentPage,
                'nextPage' => $nextPage,
                'prevPage' => $prevPage,
                'url' => request()->url(),
            ];
        }
        $categories = $this->categories;
        return view('layouts.app', compact('categories', 'pag'));
    }
}
