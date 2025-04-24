<!-- Check if $tenant has an id property -->
@if($tenant)
    <form method="POST" action="{{ route('tenant.login.submit', ['tenant_id' => $tenant->id]) }}">
        @csrf
        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" required class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
@else
    <p>No tenant found.</p>
@endif
