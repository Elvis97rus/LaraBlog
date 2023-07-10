<article class="bg-white flex flex-col shadow my-4">
    <!-- Article Image -->
{{--    {{dd(\App\Http\Services\Constants::getCurrentLocale())}}--}}
    <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}" class="hover:opacity-75">
        <img class="aspect-[4/3] object-contain" src="{{$post->getThumbnail()}}" alt="{{app()->getLocale() == 'en' ? $post->title_en : $post->title}}">
    </a>

    <div class="bg-white flex flex-col justify-start p-6">
        <div class="flex gap-4">
            @foreach($post->categories as $category)
                <a href="{{ route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category) }}" class="text-blue-700 text-sm font-bold uppercase pb-4">{{ app()->getLocale() == 'en' ? $category->title_en : $category->title }}</a>
            @endforeach
        </div>
        <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}" class="text-{{$titleSize}}xl font-bold hover:text-gray-700 pb-4">{{ app()->getLocale() == 'en' ? $post->title_en : $post->title }}</a>
        @if($showAuthor)
            <p class="text-sm pb-3">
                By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on
                {{ $post->getFormattedDate() }} | {{ $post->human_read_time }}
            </p>
        @endif
        <p class="pb-6">{!! $post->shortBody() !!}</p>

        <a href="{{route('post.show'. \App\Http\Services\Constants::getCurrentLocale(), $post)}}" class="uppercase text-gray-800 hover:text-black">{{ __('basic.continue_reading') }} <i
                class="fas fa-arrow-right"></i></a>
    </div>
</article>

