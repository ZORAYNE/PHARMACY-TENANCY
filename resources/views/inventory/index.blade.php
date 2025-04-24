@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Stock</th>
                <th>Low Stock Threshold</th>
                <th>Status</th>
                <th>Adjust</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr @if($product->isLowStock()) style="background-color: #ffecec;" @endif>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->low_stock_threshold }}</td>
                <td>
                    @if($product->isLowStock())
                        <span class="badge bg-danger">Low Stock</span>
                    @else
                        <span class="badge bg-success">OK</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('inventory.adjust', $product) }}" method="POST" class="d-inline-flex">
                        @csrf
                        <input type="number" name="adjustment" class="form-control me-2" style="width: 80px;" required>
                        <button type="submit" class="btn btn-primary">Adjust</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
