<?php

namespace App\Http\Controllers;

use App\Http\Services\Constants;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitemapXmlController extends Controller
{
    public function index() {
        // посты для ру/ен
        $posts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->get();
        $langs = Constants::getLocales();

        // категории для ру/ен
        $categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->join('posts', 'category_post.post_id', '=', 'posts.id')
            ->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now())
            ->select('categories.title','categories.title_en', 'categories.slug','categories.updated_at', DB::raw('count(*) as total'))
            ->groupBy('categories.id')
            ->orderByDesc('total')
            ->get();

        return response()
            ->view('sitemap.index', compact('posts', 'langs', 'categories'))
            ->header('Content-Type', 'text/xml');
    }

    public function humanMap()
    {
        $posts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->get();
        $langs = Constants::getLocales();

        // категории для ру/ен
        $categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->join('posts', 'category_post.post_id', '=', 'posts.id')
            ->where('active', '=', true)
            ->whereDate('published_at', '<', Carbon::now())
            ->select('categories.title','categories.title_en', 'categories.slug','categories.updated_at', DB::raw('count(*) as total'))
            ->groupBy('categories.id')
            ->orderByDesc('total')
            ->get();

        return view('sitemap.human', compact('posts', 'langs', 'categories'));
    }
}
