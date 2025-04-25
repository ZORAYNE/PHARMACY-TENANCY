@extends('layouts.app')

@section('content')
    <div class="container bg-white py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold text-gray-800">Super Admin Dashboard</h2>


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
        @if($admin->status === 'pending')
                        <span class="text-yellow-500">Pending</span>
                    @elseif($admin->status === 'accepted')
                        <span class="text-green-500">Accepted</span>
                    @endif
                </td>
                <td>
                    @if($admin->status === 'pending')
                        <form action="{{ url('superadmin/accept/' . $admin->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Accept</button>
                        </form>
                    @elseif($admin->status === 'accepted')
                        <form action="{{ url('superadmin/disable/' . $admin->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Disable</button>
                        </form>
                    @endif
                </td>
                <td>
                    @if($admin->status === 'accepted')
                        <a href="{{ url('superadmin/tenant/' . $admin->tenant_id . '/dashboard') }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded">
                            Access Dashboard
                        </a>
                    @else
                        <span class="text-gray-400 italic">Unavailable</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-gray-500">No tenants found.</td>
            </tr>
        @endforelse
</tbody>
    </div>
@endsection
