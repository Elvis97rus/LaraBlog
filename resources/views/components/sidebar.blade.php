<!-- Sidebar Section -->
<aside class="w-full md:w-1/3 flex flex-col items-center px-3">

    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <h3 class="text-xl font-semibold mb-3">All Categories</h3>
        @foreach($categories as $category)
            <a href="{{ route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category) }}"
               class="text-semibold block py-2 px-3 rounded {{ ( request('category')?->slug === $category->slug) ? 'bg-blue-600 text-white' : '' }}">
                {{$category->title}} ({{ $category->total }})
            </a>
        @endforeach
    </div>

    @if(\App\Models\TextWidget::getTitle('about-us-aside'))
    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5">
            {{ \App\Models\TextWidget::getTitle('about-us-aside') }}
        </p>
        <p class="pb-2">
            {!! \App\Models\TextWidget::getContent('about-us-aside') !!}
        </p>
        <a href="{{ route('page.about-us'. \App\Http\Services\Constants::getCurrentLocale()) }}" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
            Get to know us
        </a>
    </div>
    @endif

    <livewire:subscribe-form />
</aside>
