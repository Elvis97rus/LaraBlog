<?php
 /** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
?>


<x-app-layout meta-description="Learn2Crypto's personal blog about crypto tutorials.">
    <div class="container max-w-4xl mx-auto py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Latest Post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                    Latest Post
                </h2>

                <x-post-item :post="$latestPost" />
            </div>

            <!-- Popular 3 Post -->
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                    Popular Posts
                </h2>

                @foreach($popularPosts as $post)
                    <div class="grid grid-cols-4 gap-2 mb-2 py-2">
                        <div class="pt-2">
                            <a href="{{route('post.show', $post)}}">
                                <img src="{{$post->getThumbnail()}}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        <div class="col-span-3">
                            <a href="{{route('post.show', $post)}}">
                                <h3 class="font-bold text-sm truncate">{{ $post->title }}</h3>
                            </a>
                            @if($post->categories)
                            <div class="flex gap-4 mb-2">
                                @foreach($post->categories as $category)
                                    <a href="{{ route('post.by-category', $category) }}"
                                       class="bg-blue-500 text-white p-1 text-xs font-bold rounded uppercase">{{ $category->title }}</a>
                                @endforeach
                            </div>
                            @endif
                            <div class="text-sm">
                                {{ $post->shortBody(10) }}
                            </div>
                            <a href="{{route('post.show', $post)}}" class="uppercase text-xs text-gray-800 hover:text-black">Continue Reading <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recommended Posts -->
        <div class="mb-8">
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                Recommended Posts
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($recommendedPosts as $post)
                    <x-post-item :post="$post" :show-author="false" />
                @endforeach
            </div>
        </div>

        <!-- Latest Categories -->

        @foreach($categories as $category)
        <div class="mb-4">
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                <a href="{{route('post.by-category', $category)}}">
                   Posts to category {{$category->title}} <i class="fas fa-arrow-right"></i>
                </a>
            </h2>

            <div class="flex flex-col items-center my-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    @foreach($category->publishedPosts()->limit(3)->get() as $post)
                        <div class="mb-2">
                            <x-post-item :post="$post" :show-author="false" :title-size="2" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
