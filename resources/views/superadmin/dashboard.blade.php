@extends('layouts.app')

@section('content')
    <div class="container bg-white py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold text-gray-800">Super Admin Dashboard</h2>

        <!-- Admins Section -->
        <h4 class="text-lg font-medium text-gray-600 mt-6">Registered Admins</h4>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tenant</th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Tenant Dashboard</th>
                    </tr>
                </thead>

                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->tenant->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($admin->status == 'pending')
                            <span class="text-yellow-500">Pending</span>
                        @elseif($admin->status == 'accepted')
                            <span class="text-green-500">Accepted</span>
                        @endif
                    </td>

                        <td>
                            @if($admin->status == 'pending')
                                <form action="{{ route('admin.accept', $admin->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">Accept</button>
                                </form>
                                <form action="{{ route('admin.remove', $admin->id) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                </form>
                            @elseif($admin->status == 'accepted')
                                <form action="{{ route('admin.disable', $admin->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700">Disable</button>
                                </form>
                                <a href="{{ route('admin.edit', $admin->id) }}" class="text-blue-500 hover:text-blue-700 ml-4">Edit</a>
                            @endif
                        </td>
                        <td>
                            @if($admin->status == 'accepted')
                                    <a href="{{ route('tenant.dashboard', $tenant->id) }}" class="text-blue-500 hover:text-blue-700">
                                        Access Tenant Dashboard
                                    </a>
                                <br>
                                <a href="{{ route('tenant.login', $admin->tenant_id) }}" target="_blank" class="inline-block mt-2 py-1 px-4 bg-blue-500 text-white rounded hover:bg-blue-700">
                                    Tenant Login
                                </a>
                            @else
                                <span class="text-gray-400">No access</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No admins found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

                <!-- Tenants Section -->
            <h4 class="text-lg font-medium text-gray-600 mt-6">Registered Tenants</h4>
            <table class="table table-bordered mt-4">
               <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Admin Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Tenant Dashboard</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($tenants as $tenant)
    @php
        $admin = $tenant->admins->first();
    @endphp

    <tr>
        <td>{{ $tenant->name }}</td>
        <td>{{ $admin->name ?? 'No Admin' }}</td>
        <td>{{ $admin->email ?? 'No Admin' }}</td>
        <td>{{ $tenant->created_at->format('Y-m-d') }}</td>
        <td>
            @if($tenant->status == 'pending')
                <span class="text-yellow-500">Pending</span>
            @elseif($tenant->status == 'accepted')
                <span class="text-green-500">Accepted</span>
            @endif
        </td>
        <td>
            @if($tenant->status == 'pending' && $admin)
                <form action="{{ route('admin.accept', $admin->id) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="text-blue-500 hover:text-blue-700">Accept</button>
                </form>

                <form action="{{ route('admin.remove', $admin->id) }}" method="POST" class="inline-block ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                </form>
            @elseif($tenant->status == 'accepted' && $admin)
                <form action="{{ route('admin.disable', $admin->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-yellow-500 hover:text-yellow-700">Disable</button>
                </form>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No tenants found.</td>
    </tr>
@endforelse

</tbody>
    </div>
@endsection
