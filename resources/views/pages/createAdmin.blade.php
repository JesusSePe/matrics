<x-app-layout page="students">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('breadcrumbs')
        {{ Breadcrumbs::render('createAdmin') }}
    @endsection
    <form method="POST" action={{ route('dashboard') }}>
        @csrf

        <!-- Username -->
        <div>
            <x-label for="username" :value="__('Username')" />

            <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required
                autofocus />
        </div>

        <!-- Name -->
        <div>
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus />
        </div>

        <!-- Surname -->
        <div>
            <x-label for="lastname1" :value="__('Lastname1')" />

            <x-input id="lastname1" class="block mt-1 w-full" type="text" name="lastname1" :value="old('lastname1')" required
                autofocus />
        </div>

        <!-- Second Surname -->
        <div>
            <x-label for="lastname2" :value="__('Lastname2')" />

            <x-input id="lastname2" class="block mt-1 w-full" type="text" name="lastname2" :value="old('lastname2')" required
                autofocus />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email" :value="__('Email')" />

            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />

            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-yellow-600 hover:text-yellow-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-button class="ml-4">
                {{ __('Register') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
