@extends('layouts.app')

@section('content')
<style>
    .dashboard { display: flex; }
    .items-panel {
        width: 25%;
        border: 1px solid #ccc;
        display: flex;
        flex-direction: column;
    }
    .items-panel h3 {
        background-color: #e97430;
        color: white;
        padding: 10px;
        margin: 0;
    }
    .items-list {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
    }
    .checkout-btn {
        background-color: #e97430;
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }
    .product-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 10px;
        padding: 10px;
    }
    .product-card {
        background-color: #e97430;
        color: white;
        padding: 20px;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<div class="dashboard">
    <div class="items-panel">
        <h3>ITEMS</h3>
        <div class="items-list" id="items-list"></div>
        <div class="checkout-btn" onclick="checkout()">CHECK OUT</div>
    </div>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card" onclick="addItem('{{ $product->name }}', {{ $product->price }}, {{ $product->id }})">
                {{ $product->name }}<br>₱{{ number_format($product->price, 2) }}
            </div>
        @endforeach
    </div>
</div>

<script>
    let cart = [];

    function addItem(name, price, id) {
        cart.push({name, price, id});
        updateCart();
    }

    function updateCart() {
        const itemsList = document.getElementById('items-list');
        itemsList.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            const div = document.createElement('div');
            div.textContent = `${item.name} - ₱${item.price.toFixed(2)}`;
            itemsList.appendChild(div);
            total += item.price;
        });
        const totalDiv = document.createElement('div');
        totalDiv.innerHTML = `<strong>Total: ₱${total.toFixed(2)}</strong>`;
        totalDiv.style.marginTop = '10px';
        itemsList.appendChild(totalDiv);
    }

    function checkout() {
        if (cart.length === 0) {
            alert('Cart is empty!');
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('sales.store') }}";

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        cart.forEach(item => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'products[]';
            input.value = item.id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
</script>

@endsection
