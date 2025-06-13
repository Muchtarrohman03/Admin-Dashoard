<section>
    <header>
        <h2 class="text-lg font-medium text-secondary">
            {{ __('Ganti Password') }}
        </h2>

        <p class="mt-1 text-sm text-base-400">
            {{ __('Pastikan password yang anda buat terdiri dari minimal 8 karakter dengan kombinasi huruf, angka, dan simbol unik') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label class="text-secondary" for="update_password_current_password" :value="__('Password Lama')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label class="text-secondary" for="update_password_password" :value="__('Password Baru')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label class="text-secondary" for="update_password_password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
             <button class="btn btn-primary btn-sm">{{__('Simpan')}}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-succes"
                >{{ __('Password berhasil diperbarui !') }}</p>
            @endif
        </div>
    </form>
</section>
