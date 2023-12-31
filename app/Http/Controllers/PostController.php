<?php

namespace App\Http\Controllers;

use App\Http\Services\Constants;
use App\Http\Services\Cookies;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(Request $request): View
    {
        // show latest post
        $latestPost = Post::where('active',1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        // show 3 most popular posts based upvotes/downvotes
        $popularPosts = Post::query()
            ->leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
            ->select('posts.*', DB::raw('COUNT(upvote_downvotes.id) as upvote_count'))
            ->where(function ($query){
                $query->whereNull('upvote_downvotes.is_upvote')->orWhere('upvote_downvotes.is_upvote',1);
            })
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderByDesc('upvote_count')
            ->groupBy('posts.id')
            ->limit(3)
            ->get();

        // authorised - show posts based on user upvotes
        // not authorised - show posts based on views
        $user = auth()->user();
        if ($user){
            $leftJoin = "(SELECT cp.category_id, cp.post_id FROM upvote_downvotes JOIN category_post cp ON upvote_downvotes.post_id = cp.post_id WHERE upvote_downvotes.is_upvote = 1 and upvote_downvotes.user_id = ?) as t";
            $recommendedPosts = Post::query()
                ->leftJoin('category_post as cp', 'post_id', '=', 'cp.post_id')
                ->leftJoin(DB::raw($leftJoin), function ($join){
                    $join->on('t.category_id', '=', 'cp.category_id')
                        ->on('t.post_id', '!=', 'cp.post_id');
                })
                ->select('posts.*')
                ->where('posts.id', '!=', DB::raw('t.post_id'))
                ->setBindings([$user->id])
                ->distinct('id')
                ->limit(3)
                ->get();
        }else{
            $recommendedPosts = Post::query()
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
                ->where('active', 1)
                ->whereDate('published_at', '<', Carbon::now())
                ->orderByDesc('view_count')
                ->groupBy('posts.id')
                ->limit(3)
                ->get();

        }


        //show recent categories with their latest posts
        $categories = Category::query()
            ->whereHas('posts', function($query){
                $query->where('active', 1)
                    ->whereDate('published_at', '<', Carbon::now());
            })
            ->select('categories.*')
            ->selectRaw("MAX(posts.published_at) as max_date")
            ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
            ->leftJoin('posts', 'posts.id', '=', 'category_post.post_id')
            ->orderByDesc('max_date')
            ->groupBy('categories.id')
            ->limit(5)
            ->get();
        return view('home', compact('latestPost', 'popularPosts', 'categories', 'recommendedPosts' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * return Post collection according to query
     */
    public function search(Request $request)
    {
        $q = htmlspecialchars($request->get('q'));

        $posts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->where(function ($query) use ($q){
                $query->where('title', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%");
            })
            ->paginate(2);

        return view('post.search', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        if (!$post->active || $post->published_at > Carbon::now()) {
            throw  new NotFoundHttpException();
        }

        $next = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)->first();


        $prev = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)->first();

        $related = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post){
                $query->where('related_posts_id', $post->id)->orWhere('id', $post->related_posts_id);
            })
            ->orderBy('published_at', 'asc')
            ->get();

//        dd($prev);
//        if (!$prev) {
//            $prev = Post::query()
//                ->where('active', 1)
//                ->whereDate('published_at', '<=', Carbon::now())
//                ->orderBy('published_at', 'desc')
//                ->limit(2)->get()[1];
//        }
//        if (!$next) {
//            $next = Post::query()
//                ->where('active', 1)
//                ->whereDate('published_at', '<=', Carbon::now())
//                ->orderBy('published_at', 'asc')
//                ->limit(1)->first();
//        }
        // TODO relink_section

        $user = $request->user();

        $hash = Cookies::cookieHandler();
        PostView::firstOrCreate([
            'user_token' => $hash
        ],[
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'post_id' => $post->id,
            'user_id' => $user?->id,
        ]);

        return view('post.show', compact('post', 'next', 'prev', 'related'));
    }

    public function byCategory(Category $category, Request $request)
    {
        $posts = Post::query()
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('category_post.category_id', '=', $category->id)
            ->where('active', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(1);

        return view('post.index', compact('posts', 'category'));
    }
}
