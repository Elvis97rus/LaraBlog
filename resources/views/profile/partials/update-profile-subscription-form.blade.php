<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Subscription Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your subscription's settings.") }}
        </p>
    </header>
    <form method="post" action="{{ route('profile.subscribe') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div class="flex justify-between w-2/3">
            <x-input-label for="subscribe" :value="__('I want to subscribe on weekly newsletters.')" class="py-2" />
            <x-text-input id="subscribe" name="subscribe" type="checkbox" class="mt-1 block w-8 py-3" :checked="$user->subscribe->send_mail ? 'on' : null" autofocus />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
