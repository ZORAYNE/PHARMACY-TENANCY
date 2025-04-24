@extends('layouts.app')

@section('content')
<h2>Add New Supplier</h2>

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save Supplier</button>
</form>
@endsection
