<x-tenant-layout>
    <h2 class="text-2xl font-bold mb-4">Customer Purchase Report</h2>
    <table class="table-auto w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Customer Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Total Purchases</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td class="border px-4 py-2">{{ $customer->name }}</td>
                    <td class="border px-4 py-2">{{ $customer->email }}</td>
                    <td class="border px-4 py-2">₱{{ $customer->total_purchases }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-tenant-layout>
