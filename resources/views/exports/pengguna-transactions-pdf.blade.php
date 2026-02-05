<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions List</title>
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
    <h2>Item Transactions</h2>
    <div class="muted">Generated: {{ $tanggal }}</div>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Code</th>
                <th>Date</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->item->name ?? '-' }}</td>
                    <td>{{ $t->item->code ?? '-' }}</td>
                    <td>{{ $t->transaction_date->format('d-m-Y') }}</td>
                    <td>{{ strtoupper($t->type) }}</td>
                    <td>{{ $t->quantity }} {{ $t->item->unit ?? '' }}</td>
                    <td>{{ $t->note ?? '-' }}</td>
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
