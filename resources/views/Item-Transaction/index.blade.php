@extends('template-ItemTransaction.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Transaksi Barang (Masuk/Keluar)</h4>
            <a href="{{ route('item-transaction.create') }}" class="btn btn-primary">
                <span class="d-flex align-items-center">
                    <i class="fas fa-plus"></i>&nbsp;Tambah Transaksi
                </span>
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Item</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $key => $transaction)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $transaction->item->name }}</strong><br>
                                    <small>{{ $transaction->item->code }}</small>
                                </td>
                                <td>
                                    @if($transaction->type === 'masuk')
                                        <span class="badge bg-success">MASUK</span>
                                    @else
                                        <span class="badge bg-danger">KELUAR</span>
                                    @endif
                                </td>
                                <td><strong>{{ $transaction->quantity }} {{ $transaction->item->unit }}</strong></td>
                                <td>{{ $transaction->petugas->name ?? '-' }}</td>
                                <td>{{ $transaction->note ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('item-transaction.show', $transaction->id) }}" class="me-3">
                                        <img src="assets/img/icons/eye.svg" alt="img">
                                    </a>
                                    <a href="{{ route('item-transaction.edit', $transaction->id) }}" class="me-3">
                                        <img src="assets/img/icons/edit.svg" alt="img">
                                    </a>
                                    <form action="{{ route('item-transaction.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" onclick="return confirm('Yakin ingin menghapus? Stok akan direset ke kondisi sebelumnya.')">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
