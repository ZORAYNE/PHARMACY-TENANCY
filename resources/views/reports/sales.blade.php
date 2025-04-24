<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sales Report</h2>
    </x-slot>

    <div class="p-6 bg-white border-b border-gray-200">
        <h3 class="text-lg mb-4">Sales Report for {{ $period }}</h3>
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr>
                    <td class="border px-4 py-2">{{ $sale->date }}</td>
                    <td class="border px-4 py-2">{{ $sale->product->name }}</td>
                    <td class="border px-4 py-2">{{ $sale->quantity }}</td>
                    <td class="border px-4 py-2">{{ $sale->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
