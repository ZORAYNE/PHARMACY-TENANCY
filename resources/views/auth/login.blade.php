<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Modal Trigger -->
    <button id="openModal" class="hidden">Open Modal</button>

    <!-- Modal -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Super Admin Login</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form method="POST" action="{{ route('superadmin.login.submit') }}">
                @csrf
                <input type="email" name="email" placeholder="Super Admin Email" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
                <button type="submit" class="w-full p-2 bg-blue-600 text-white rounded">Login</button>
            </form>
        </div>
    </div>

    <!-- Main Login Form (Original) -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>

            <x-primary-button class="ms-3">
                {{ __('Register') }}
            </x-primary-button>

        </div>
        <div class="text-center mt-4">
            <!-- Replaced the anchor tag with a button element -->
            <button type="button" onclick="document.getElementById('loginModal').classList.remove('hidden');" class="text-white-600 hover:underline">
                Login as Super Admin
            </button>
        </div>

    </form>
    <div class="text-center mt-6">
    <a href="{{ url('auth/google') }}" 
       class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21.35 11.1h-9.18v2.8h5.27c-.23 1.25-.94 2.3-1.99 3l3.23 2.51c1.88-1.73 2.97-4.28 2.97-7.32 0-.69-.06-1.36-.17-2z" />
            <path d="M12.17 22c2.7 0 4.97-.9 6.62-2.45l-3.23-2.51c-.9.61-2.05.97-3.39.97-2.6 0-4.8-1.76-5.58-4.14H3.22v2.6C4.95 19.43 8.26 22 12.17 22z" />
            <path d="M6.59 13.87A5.994 5.994 0 0 1 6.17 12c0-.65.11-1.28.31-1.87v-2.6H3.22A9.966 9.966 0 0 0 2.17 12c0 1.64.39 3.19 1.05 4.54l3.37-2.67z" />
            <path d="M12.17 5.97c1.47 0 2.8.51 3.85 1.5l2.88-2.88C17.14 2.62 14.87 2 12.17 2 8.26 2 4.95 4.57 3.22 7.97l3.37 2.67c.78-2.38 2.98-4.14 5.58-4.14z" />
        </svg>
        Continue with Google
    </a>
</div>

    <!-- Modal JS -->
    <script>
        // Open the modal when the "Login as Super Admin" button is clicked
        document.getElementById('openModal').onclick = function() {
            document.getElementById('loginModal').classList.remove('hidden');
        };

        // Close the modal when the close button (×) is clicked
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('loginModal').classList.add('hidden');
        };
        
        // Close the modal when clicked outside of the modal content
        window.onclick = function(event) {
            if (event.target === document.getElementById('loginModal')) {
                document.getElementById('loginModal').classList.add('hidden');
            }
        };
    </script>
</x-guest-layout>
