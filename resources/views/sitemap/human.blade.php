<x-app-layout >
    <div class="flex flex-wrap justify-center">
        <h1 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 boder-blue-500 mb-3">{{__('basic.sitemap')}}</h1>
        <section class="w-full flex px-3 gap-4 justify-between flex-wrap">
            @foreach($langs as $lang)
                <div class="flex flex-col w-2/5 px-6 py-2">
                    <a class="font-bold text-lg hover:text-blue-600" href="{{ route('home'.($lang == 'ru' ? '' : '.en')) }}">{{($lang == 'ru' ? 'Главная' : 'Home')}}</a>
                    <a class="font-bold text-lg hover:text-blue-600" href="{{ route('page.about-us'.($lang == 'ru' ? '' : '.en')) }}">{{($lang == 'ru' ? 'О нас' : 'About')}}</a>

                    @foreach ($categories as $category)
                        <a class="font-bold text-lg hover:text-blue-600" href="{{ route('post.by-category'.($lang == 'ru' ? '' : '.en'), $category) }}">{{($lang == 'ru' ? 'Категория '.$category->title : 'Category '.$category->title_en)}}</a>
                    @endforeach
                    @foreach ($posts as $post)
                        <a class="font-bold text-lg pl-3 hover:text-blue-600" href="{{route('post.show'.($lang == 'ru' ? '' : '.en'), $post)}}">{{($lang == 'ru' ? $post->title : $post->title_en)}}</a>
                    @endforeach
                </div>
            @endforeach

        </section>
    </div>
</x-app-layout>
