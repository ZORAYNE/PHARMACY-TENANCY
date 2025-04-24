@extends('layouts.app')

@section('content')
<h2>Edit Supplier</h2>

<form action="{{ route('suppliers.update', $supplier) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="{{ $supplier->contact }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ $supplier->address }}">
    </div>
    <button type="submit" class="btn btn-primary">Update Supplier</button>
</form>
@endsection
