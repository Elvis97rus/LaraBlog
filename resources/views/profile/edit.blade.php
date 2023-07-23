<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-around gap-y-2 gap-x-2">
            <div class="p-4 bg-white shadow sm:rounded-lg w-full max-w-xl my-4">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4  bg-white shadow sm:rounded-lg w-full max-w-xl my-4">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 bg-white shadow sm:rounded-lg w-full max-w-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-subscription-form')
                </div>
            </div>


            <div class="p-4 bg-white shadow sm:rounded-lg w-full max-w-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
