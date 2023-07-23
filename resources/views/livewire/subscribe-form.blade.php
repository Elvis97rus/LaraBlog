<div class="w-full bg-white shadow flex flex-col my-4 p-6">
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('warning'))
            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                <a href="{{ route('profile.edit') }}" class="underline hover:no-underline">
                    {{ session('warning') }} <i class="fas fa-arrow-right pl-1"></i>
                </a>
            </div>
    @endif
    <form wire:submit.prevent="submit">
        <p class="text-xl font-semibold mb-3">Подпишись на еженедельную новостную рассылку!</p>
        <div>
            <label for="email" class="hidden">Email:</label>
            <input type="text" id="email" wire:model="email" placeholder="example@gmail.com" class="peer block min-h-[auto] w-full rounded text-black border-0 bg-transparent py-[0.32rem] px-3 leading-[2.15]  outline transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none ">
            @error('email') <div class="text-center font-semibold mt-4 px-4 text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">Подписаться</button>
        </div>
    </form>
</div>
