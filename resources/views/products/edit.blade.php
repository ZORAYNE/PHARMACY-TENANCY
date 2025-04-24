@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-2">
            <label>Brand</label>
            <input type="text" name="brand" value="{{ $product->brand }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Category</label>
            <input type="text" name="category" value="{{ $product->category }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
            @error('stock')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-2">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-2">
            <label>Expiration Date</label>
            <input type="date" name="expiration_date" value="{{ $product->expiration_date }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
