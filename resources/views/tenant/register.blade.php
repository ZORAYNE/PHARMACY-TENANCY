<x-app-layout>
    <div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Tenant Registration</h2>
        <form method="POST" action="{{ route('tenants.register') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Business Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Gmail</label>
                <input type="email" name="email" class="w-full border rounded p-2" required>
            </div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Register</button>
        </form>
    </div>
</x-app-layout>
