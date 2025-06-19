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
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            placeholder="Password"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

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
