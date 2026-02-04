<!DOCTYPE html>
<html>
<head>
    <title>Rekap Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin-bottom: 10px;
            color: #333;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #4472C4;
            color: white;
        }
        th {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>📊 Rekap Barang</h2>
        <p>Tanggal Export: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>SKU</th>
                <th>Kategori</th>
                <th>Unit</th>
                <th>Terjual (qty)</th>
                <th>Stok (qty)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->category->name ?? 'N/D' }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->sold_qty ?? 0 }}</td>
                <td>{{ $item->instock ?? 0 }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
