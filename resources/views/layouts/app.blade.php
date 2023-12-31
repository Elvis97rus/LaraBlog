<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{str_contains(request()->route()->getName(), 'post.show') && $postMeta ? 'prefix="og:http://ogp.me/ns#"' : ''}}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: env('APP_NAME') }}{{$pag && $pag['currentPage'] > 1 ? $pag['meta_addition'] : ''}}</title>
    <meta name="author" content="Learn2Crypto">
    <meta name="title"
          content="{{ $metaTitle ?: env('APP_NAME') }}{{$pag && $pag['currentPage'] > 1 ? $pag['meta_addition'] : ''}}">
    <meta name="description"
          content="{{ $metaDescription }}{{$pag && $pag['currentPage'] > 1 ? $pag['meta_addition'] : ''}}">

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    @if($pages && $pag['currentPage'])
        <link rel="canonical"
              href="{{$pag['currentPage'] == 1 ? $pag['url'] : $pag['url'] . '?page='. $pag['currentPage']}}">
    @endif
    @if($pages && $pag['nextPage'])
        <link rel="next" href="{{$pag['url']}}?page={{$pag['nextPage']}}">
    @endif
    @if($pages && $pag['prevPage'])
        <link rel="prev" href="{{$pag['prevPage'] == 1 ? $pag['url'] : $pag['url']."?page={$pag['prevPage']}"}}">
    @endif

    @if(str_contains(request()->route()->getName(), 'post.show') && $postMeta)
        <meta property="og:title"
              content="{{ app()->getLocale() == 'en' ? $postMeta->title_en :$postMeta->title }}{{$pag && $pag['currentPage'] > 1 ? $pag['meta_addition'] : ''}}">
        <meta property="og:description"
              content="{{ app()->getLocale() == 'en' ? $postMeta->meta_description_en :$postMeta->meta_description }}{{$pag && $pag['currentPage'] > 1 ? $pag['meta_addition'] : ''}}">
        <meta property="og:image" content="{{ config('app.url') }}{{ $postMeta->getThumbnail() }}">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:type" content="article">
        <meta property="og:site_name"
              content="{{ __('basic.name_crypto') }} - Блог о криптовалютах для новичков и не только!">
        <meta property="og:locale" content="ru_RU"/>
        <meta property="og:locale:alternate" content="en_GB"/>
    @endif

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    </style>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
            integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-family-karla">
    <div class="w-full border-t border-b bg-gray-100 flex justify-end">
        <div class="flex px-4 text-md font-bold">
            <a href="{{ route('locale.ru') }}"
               class="mr-2 px-2 py-2 rounded hover:bg-blue-600 leading-4 hover:text-white {{app()->getLocale() == 'ru'? 'bg-blue-600 text-white': ''}}">RU</a>
            <a href="{{ route('locale.en') }}"
               class="px-2  py-2 rounded hover:bg-blue-600 leading-4 hover:text-white {{app()->getLocale() == 'en'? 'bg-blue-600 text-white': ''}}">EN</a>
        </div>
        @auth
            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ml-6 text-black mr-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-md text-black leading-4 font-bold rounded-md hover:bg-blue-600 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-danger-button>{{ __('Log Out') }}
                            </x-danger-button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @else
            <a href="{{route('login')}}"
               class="hover:bg-blue-600 hover:text-white rounded py-1 px-4 mx-2 {{ ( request()->route()->getName() == 'login') ? 'bg-blue-600 text-white' : '' }}">
                Login</a>
            <a href="{{route('register')}}"
               class="bg-blue-600 text-white rounded py-1 px-4 mx-2 {{ ( request()->route()->getName() == 'register') ? 'bg-blue-600 text-white' : '' }}">
                Register</a>
        @endauth
    </div>

    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl"
               href="{{route('home'. \App\Http\Services\Constants::getCurrentLocale())}}">
                {{ __('basic.name_crypto') }}
            </a>
            <p class="text-lg text-gray-600">
                {{ __('basic.name_sub_crypto') }}
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a
                href="#"
                class="block md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                @click="open = !open"
            >
                {{__('basic.menu')}} <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div
                class="w-full container mx-auto flex flex-col sm:flex-row justify-between text-sm font-bold uppercase mt-0 px-6 py-2">
                <div class="flex flex-wrap whitespace-nowrap justify-between">
                    <a href="{{route('home'. \App\Http\Services\Constants::getCurrentLocale())}}"
                       class="hover:bg-blue-600 hover:text-white rounded py-4 px-4 mx-2"> {{ __('basic.home') }}</a>
                    @foreach($categories as $category)
                        <a href="{{ route('post.by-category'. \App\Http\Services\Constants::getCurrentLocale(), $category) }}"
                           class="hover:bg-blue-600 hover:text-white rounded py-4 px-4 mx-2 {{ ( request('category')?->slug === $category->slug) ? 'bg-blue-600 text-white' : '' }}">
                            {{app()->getLocale() == 'en' ? $category->title_en : $category->title}}
                        </a>
                    @endforeach
                    <a href="{{route('page.about-us'. \App\Http\Services\Constants::getCurrentLocale())}}"
                       class="hover:bg-blue-600 hover:text-white rounded py-4 px-4 mx-2 {{ ( request()->route()->getName() == 'page.about-us') ? 'bg-blue-600 text-white' : '' }}">
                        {{__('basic.about_us')}}</a>
                </div>

                <div class="flex items-center w-full py-2 md:max-w-lg lg:max-w-xl">
                    <form method="get" class="w-full"
                          action="{{ route('post.search'. \App\Http\Services\Constants::getCurrentLocale()) }}">
                        <input name="q" value="{{ request()->get('q') }}" placeholder="{{__('basic.search')}}"
                               class=" block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300
                       placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div
        class="w-full container mx-auto flex flex-wrap sm:gap-2 sm:flex-row items-center justify-around text-sm font-bold uppercase mt-0 px-6 py-2">
        @foreach($coins as $key => $coin)
            <div class="coin-card px-2 py-2 sm:min-w-fit cursor-pointer">
                <div class="coin-card-header font-bold text-xl">{{$key}} <span><i class="fa fa-question-circle-o"
                                                                                  aria-hidden="true"></i></span></div>
                <div class="toPriceMenu font-bold text-xl">$ {{$coin->USD}}</div>
                <div class="currencyMenuBox p-2 text-lg">
                    <div class="toPriceMenu min-w-full">€ {{$coin->EUR}}</div>
                    <div class="toPriceMenu min-w-full">¥ {{$coin->CNY}}</div>
                    <div class="toPriceMenu min-w-full">£ {{$coin->GBP}}</div>
                    <div class="toPriceMenu min-w-full">₽ {{$coin->RUB}}</div>
                    <div class="toPriceMenu min-w-full">฿ {{$coin->THB}}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="container mx-auto py-6 sm:px-4 px-8">
        {{ $slot }}

    </div>
    <livewire:scroll-to-top-link/>
    <footer class="w-full border-t bg-white pb-12">

        <div class="w-full container mx-auto flex flex-col items-center">
            <div class="uppercase py-6">&copy; myblog.com</div>
            <a href="/sitemap" class="font-bold text-md hover:text-blue-600">{{__('basic.sitemap')}}</a>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
