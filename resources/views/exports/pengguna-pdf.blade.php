<!DOCTYPE html>
<html>
<head>
    <title>Data Pengguna</title>
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
        <h2>📋 Data Pengguna</h2>
        <p>Tanggal Export: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>No HP</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengguna as $key => $p)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $p->user->username }}</td>
                <td>{{ $p->user->email }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->user->nip }}</td>
                <td>{{ $p->user->no_hp }}</td>
                <td>{{ $p->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #999;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
