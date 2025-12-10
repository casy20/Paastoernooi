<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus class="mt-1 w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required class="mt-1 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" type="text" name="phone" :value="old('phone')" class="mt-1 w-full" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required class="mt-1 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <button 
                type="button" 
                id="toggle-password" 
                class="mb-2 w-full py-2 bg-gray-200 rounded flex justify-start text-sm"
            >
                Show Password
            </button>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <button 
                type="button" 
                id="toggle-password-confirm" 
                class="mb-2 w-full py-2 bg-gray-200 rounded flex justify-start text-sm"
            >
                Show Confirm Password
            </button>
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button type="submit">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');
            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.innerText = 'Hide Password';
                } else {
                    passwordInput.type = 'password';
                    togglePassword.innerText = 'Show Password';
                }
            });

            const passwordConfirmInput = document.getElementById('password_confirmation');
            const togglePasswordConfirm = document.getElementById('toggle-password-confirm');
            togglePasswordConfirm.addEventListener('click', function() {
                if (passwordConfirmInput.type === 'password') {
                    passwordConfirmInput.type = 'text';
                    togglePasswordConfirm.innerText = 'Hide Confirm Password';
                } else {
                    passwordConfirmInput.type = 'password';
                    togglePasswordConfirm.innerText = 'Show Confirm Password';
                }
            });
        });
    </script>
</x-guest-layout>
