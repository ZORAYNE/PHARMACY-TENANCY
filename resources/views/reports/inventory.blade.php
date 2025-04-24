<x-tenant-layout>
    <h2 class="text-2xl font-bold mb-4">Inventory Report</h2>
    <table class="table-auto w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Product</th>
                <th class="border px-4 py-2">Stock</th>
                <th class="border px-4 py-2">Expiration Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventory as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2">{{ $item->stock }}</td>
                    <td class="border px-4 py-2">{{ $item->expiration_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-tenant-layout>
