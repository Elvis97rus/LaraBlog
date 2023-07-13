<?php
 /** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
?>


<x-app-layout :pages="$posts"
              :meta-title="env('APP_NAME') .' - Posts by Search '"
              :meta-description="'Search  Posts - Learn2Crypto\'s personal blog about crypto tutorials.'">
    <div class="flex flex-wrap justify-center">
        <!-- Posts Section -->
        <section class="w-full max-w-3xl md:w-2/3 flex flex-col px-3">

            @foreach($posts as $post)
                <div>
                    <a href="{{ route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post) }}">
                        <h2 class="text-blue-500 font-bold text-lg sm:text-xl mb-2">
                            {!!
                                str_replace(
                                    request()->get('q'),
                                    '<span class="bg-yellow-300">'.request()->get('q').'</span>',
                                    $post->title)
                            !!}
                        </h2>
                    </a>
                    <div>
{{--        TODO сделать подсветку искомого текста в теле и в предпоказе тела показывать участок текста с вхождением --}}
                        {{$post->shortBody()}}
                    </div>
                    <hr class="my-4">
                </div>
            @endforeach

            {{$posts->links()}}

        </section>

        <x-sidebar />
    </div>
</x-app-layout>
