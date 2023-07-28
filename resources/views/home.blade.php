<?php
/** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
?>


<x-app-layout meta-description="Learn2Crypto's personal blog about crypto tutorials.">
    <div class="container max-w-6xl mx-auto py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Latest Post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                    {{ __('basic.latest_post') }}
                </h2>
                @if($latestPost)
                    <x-post-item :post="$latestPost"/>
                @endif
            </div>

            <!-- Popular 3 Post -->
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                    {{ __('basic.popular_posts') }}
                </h2>
                @if($popularPosts)
                    @foreach($popularPosts as $post)
                        <div class="grid grid-cols-4 gap-2 mb-2 py-2">
                            <div class="pt-2">
                                <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}">
                                    <img src="{{$post->getThumbnail()}}" alt="{{ app()->getLocale() == 'en' ? $post->title_en : $post->title }}">
                                </a>
                            </div>
                            <div class="col-span-3">
                                <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}">
                                    <h3 class="font-bold text-sm truncate">{{ app()->getLocale() == 'en' ? $post->title_en : $post->title }}</h3>
                                </a>
                                @if($post->categories)
                                    <div class="flex gap-4 mb-2">
                                        @foreach($post->categories as $category)
                                            <a href="{{ route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category) }}"
                                               class="bg-blue-500 text-white p-1 text-xs font-bold rounded uppercase">{{ app()->getLocale() == 'en' ? $category->title_en : $category->title }}</a>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="text-sm">
                                    {{ $post->shortBody(10) }}
                                </div>
                                <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}"
                                   class="uppercase text-xs text-gray-800 hover:text-black">{{ __('basic.continue_reading') }} <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        @if($recommendedPosts->count())
        <!-- Recommended Posts -->
        <div class="mb-8">
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                {{ __('basic.recommended_posts') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    @foreach($recommendedPosts as $post)
                        <x-post-item :post="$post" :show-author="false"/>
                    @endforeach

            </div>
        </div>
        @endif

        <!-- Latest Categories -->

        @if($categories)
            @foreach($categories as $category)
                <div class="mb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">
                        <a href="{{route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category)}}">
                            {{ __('basic.posts_to_category') }} {{app()->getLocale() == 'en' ? $category->title_en : $category->title}} <i class="fas fa-arrow-right"></i>
                        </a>
                    </h2>

                    <div class="flex flex-col items-center my-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            @foreach($category->publishedPosts()->limit(3)->get() as $post)
                                <div class="mb-2">
                                    <x-post-item :post="$post" :show-author="false" :title-size="2"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
