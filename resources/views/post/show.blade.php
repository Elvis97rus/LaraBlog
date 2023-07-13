<x-app-layout :post-meta="$post"
    :meta-title="app()->getLocale() == 'en' ? ($post->meta_title_en ?? $post->title_en . ' - ' . env('APP_NAME')) : ($post->meta_title ?? $post->title . ' - ' . env('APP_NAME'))"
    :meta-description="app()->getLocale() == 'en' ? $post->meta_description_en : $post->meta_description">
    <div class="flex flex-wrap">
        <!-- Post Section -->
        <section class="w-full md:w-2/3 flex flex-col px-3">

            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                <div class="hover:opacity-75">
                    <img src="{{$post->getThumbnail()}}" alt="{{ app()->getLocale() == 'en' ? $post->title_en : $post->title }}" class="aspect-[4/3] object-contain">
                </div>
                <div class="bg-white flex flex-col justify-start p-6">

                    <div class="flex gap-4">
                        @foreach($post->categories as $category)
                            <a href="{{ route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category) }}" class="text-blue-700 text-sm font-bold uppercase pb-4">{{ app()->getLocale() == 'en' ? $category->title_en : $category->title }}</a>
                        @endforeach
                    </div>

                    <h1 class="text-3xl font-bold hover:text-gray-700 pb-4">
                        {{ app()->getLocale() == 'en' ? $post->title_en : $post->title }}
                    </h1>
                    <p href="#" class="text-sm pb-8">
                        By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on
                        {{ $post->getFormattedDate() }} | {{ $post->human_read_time }}
                    </p>

                    <div>
                        {!! app()->getLocale() == 'en' ? $post->body_en : $post->body !!}
                    </div>

                    <livewire:upvote-downvote :post="$post" />
                </div>
            </article>

            <div class="w-full flex pt-6">
                <div class="w-1/2">
                    @if($prev)
                        <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $prev)}}" class="block w-full bg-white shadow hover:shadow-md text-left p-6">
                            <p class="text-lg text-blue-800 font-bold flex items-center">
                                <i class="fas fa-arrow-left pr-1"></i>
                                {{__('basic.prev')}}
                            </p>
                            <p class="pt-2">{{ \Illuminate\Support\Str::words(app()->getLocale() == 'en' ? $prev->title_en : $prev->title, 5) }}</p>
                        </a>
                    @endif
                </div>

                <div class="w-1/2">
                    @if($next)
                        <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $next)}}" class="block w-full bg-white shadow hover:shadow-md text-right p-6">
                            <p class="text-lg text-blue-800 font-bold flex items-center justify-end">
                                {{__('basic.next')}}
                                <i class="fas fa-arrow-right pl-1"></i>
                            </p>
                            <p class="pt-2">{{ \Illuminate\Support\Str::words(app()->getLocale() == 'en' ? $next->title_en : $next->title, 5) }}</p>
                        </a>
                    @endif
                </div>
            </div>

            @if($related->count())
                <div class="w-full pt-6">
                    <h2 class="text-xl font-bold hover:text-gray-700 pb-4">{{__('basic.related_posts')}}</h2>
                    <div class="flex">
                        @foreach($related as $p)
                            <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $p)}}" class="block w-1/3 bg-white shadow hover:shadow-md text-left p-4">
                                <p class="text-blue-800 font-bold text-lg">{{ \Illuminate\Support\Str::words(app()->getLocale() == 'en' ? $p->title_en : $p->title, 5) }}</p>
                                <p class="pb-6">{!! $post->shortBody() !!}</p>
                                <p class=" flex items-center text-sm">
                                    <i class="fas fa-arrow-right pr-1"></i>
                                    {{__('basic.continue_reading')}}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <livewire:comments :post="$post"/>
        </section>

        <x-sidebar />
    </div>
</x-app-layout>
