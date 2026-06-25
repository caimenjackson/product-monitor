<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Control Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sheet-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .sheet-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px; /* Add margin for separation between products */
        }
        .product-table th, .product-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }
        .product-table th {
            background-color: #f2f2f2;
        }
        .page-break {
            page-break-after: always;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .summary-table th, .summary-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-size: 14px;
        }
        .summary-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="sheet-title">Product Control Sheet</div>

    <div class="sheet-header">
        <div>Day: {{ \Carbon\Carbon::now()->format('l') }}                      Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
        <div>AM Shift Manager: ___________________          PM Shift Manager: ___________________</div>
    </div>

    @foreach ($products as $product)
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>No</th>
                    <th>OUT</th>
                    <th>EXP</th>
                    <th>Fresh Sold</th>
                    <th>Wasted</th>
                    <th>Expired Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->batches as $batch)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $batch->quantity }}</td>
                        <td>{{ $batch->cooked_at->format('H:i') }}</td>
                        <td>{{ $batch->expires_at->format('H:i') }}</td>
                        <td>{{ $batch->fresh_sold }}</td>
                        <td>{{ $batch->waste }}</td>
                        <td>{{ $batch->expired_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="page-break"></div> <!-- Page break before the summary table -->

    <div class="sheet-title">Daily Summary</div>
    <table class="summary-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Cooked</th>
                <th>Total Sold</th>
                <th>Total Waste</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->batches->sum('quantity') }}</td>
                    <td>{{ $product->batches->sum('fresh_sold') + $product->batches->sum('expired_sold') }}</td>
                    <td>{{ $product->batches->sum('waste') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
