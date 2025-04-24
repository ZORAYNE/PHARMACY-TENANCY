<x-app-layout>
    <h2>Generate Sales Report</h2>

    <form action="{{ route('reports.sales') }}" method="GET" target="_blank">
        <label>From:</label>
        <input type="date" name="from" required>
        <label>To:</label>
        <input type="date" name="to" required>
        <button type="submit">Generate Report</button>
    </form>

    <h2>Reports</h2>

    <div style="margin-top:20px;">
        <a href="{{ route('reports.sales') }}" target="_blank">
            <button>Sales Report</button>
        </a>

        <a href="{{ route('reports.stock') }}" target="_blank">
            <button>Stock Report</button>
        </a>

        <a href="{{ route('reports.customers') }}" target="_blank">
            <button>Customer Trend Report</button>
        </a>
    </div>


</x-app-layout>

