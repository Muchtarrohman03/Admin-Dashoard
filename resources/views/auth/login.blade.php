@section('title', 'Log In')
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mx-2" >
        @csrf

        <div class="flex items-center justify-center my-10">
            <h1 class="text-xl text-primary font-bold">Log in</h1>
        </div>
        
        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
<!-- Password -->
<div class="mt-4" x-data="{ show: false }">
        <div class="relative">
            <x-text-input 
                id="password" 
                class="block mt-1 w-full pr-10"
                placeholder="Password"
                x-bind:type="show ? 'text' : 'password'"
                name="password"
                required 
                autocomplete="current-password" />

            <!-- Tombol toggle -->
            <button type="button" 
                    class="absolute inset-y-0 right-2 flex items-center text-sm text-gray-600"
                    @click="show = !show">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.964 9.964 0 013.157-4.568M15 12a3 3 0 00-3-3M3 3l18 18" />
                </svg>
            </button>
        </div>

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>


        
        <div class="mt-4">
             <button class=" w-full btn btn-sm btn-primary ml-1">Log in</button>
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-priamry" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingatkan Saya') }}</span>
            </label>
        </div>


        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

           
        </div>
    </form>
</x-guest-layout>
