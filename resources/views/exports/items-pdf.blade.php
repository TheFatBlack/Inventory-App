<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f2f2f2; }
        .muted { color: #666; font-size: 11px; }
    </style>
</head>
<body>
    <h2>Items List</h2>
    <div class="muted">Generated: {{ $tanggal }}</div>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->stock->stock ?? 0 }}</td>
                    <td>{{ $item->petugas->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
