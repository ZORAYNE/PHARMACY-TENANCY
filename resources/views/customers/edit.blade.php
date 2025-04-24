@extends('layouts.app')

@section('content')
<h2>Edit Customer</h2>

<form action="{{ route('customers.update', $customer) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ $customer->address }}">
    </div>
    <button type="submit" class="btn btn-primary">Update Customer</button>
</form>
@endsection
