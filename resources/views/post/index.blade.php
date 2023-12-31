<?php
 /** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
?>


<x-app-layout :pages="$posts"
              :meta-title="env('APP_NAME') .' - Posts by category '. $category->title"
              :meta-description="$category->title  . ' By Category - Learn2Crypto\'s personal blog about crypto tutorials.'">
    <div class="flex flex-wrap">
        <!-- Posts Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">

            @foreach($posts as $post)
                <x-post-item :post="$post"></x-post-item>
            @endforeach

            {{$posts->onEachSide(1)->links()}}

        </section>

        <x-sidebar />
    </div>
</x-app-layout>
