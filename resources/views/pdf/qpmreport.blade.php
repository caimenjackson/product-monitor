<!-- resources/views/pdf/products.blade.php -->
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
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="sheet-title">Product Control Sheet</div>

    <div class="sheet-header">
        <div>Day: {{ \Carbon\Carbon::now()->format('l') }}                      Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <div>AM Shift Manager: ___________________          PM Shift Manager: ___________________</div>

    </div>

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
            @foreach ($products as $product)
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
            @endforeach
        </tbody>
    </table>
</body>
</html>
