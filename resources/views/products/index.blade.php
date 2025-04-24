@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product List</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->stock }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->expiration_date }}</td>
                <td>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
