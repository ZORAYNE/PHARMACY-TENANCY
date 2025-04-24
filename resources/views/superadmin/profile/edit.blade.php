<hr class="my-8 border-gray-300 dark:border-gray-600">

<h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Change Password</h2>

@if (session('password_success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
        {{ session('password_success') }}
    </div>
@endif

<form method="POST" action="{{ route('superadmin.password.update') }}">
    @csrf

    <!-- Current Password -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
        <input type="password" name="current_password"
               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('current_password')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- New Password -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
        <input type="password" name="password"
               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('password')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm New Password -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
        <input type="password" name="password_confirmation"
               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    <!-- Submit -->
    <div>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-700">
            Update Password
        </button>
    </div>
</form>
