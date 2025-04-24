@extends('layouts.app') {{-- or your custom layout --}}

@section('title', 'Select Tenant')

@section('content')
<div class="container mx-auto mt-10 max-w-md">
    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Select Tenant</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-500 text-sm list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('tenant.selector.redirect') }}">
            @csrf
            <div class="mb-4">
                <label for="tenant_id" class="block text-gray-700 dark:text-gray-200">Tenant ID</label>
                <input type="text" name="tenant_id" id="tenant_id" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Proceed to Login
            </button>
        </form>
    </div>
</div>
@endsection
