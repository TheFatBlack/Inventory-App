@extends('template-pengguna.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Detail Transaksi Barang</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Item</label>
                        <input type="text" class="form-control" value="{{ $transaction->item->name }} ({{ $transaction->item->code }})" readonly>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" class="form-control" value="{{ $transaction->item->category->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tipe Transaksi</label>
                        <div>
                            @if($transaction->type === 'masuk')
                                <span class="badge bg-success" style="font-size: 14px;">MASUK (Penambahan Stok)</span>
                            @else
                                <span class="badge bg-danger" style="font-size: 14px;">KELUAR (Pengurangan Stok)</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" class="form-control" value="{{ $transaction->quantity }} {{ $transaction->item->unit }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control" value="{{ $transaction->transaction_date->format('d/m/Y') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Petugas</label>
                        <input type="text" class="form-control" value="{{ $transaction->petugas->name ?? '-' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" rows="3" readonly>{{ $transaction->note ?? '-' }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dibuat Pada</label>
                                <input type="text" class="form-control" value="{{ $transaction->created_at->format('d/m/Y H:i') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Diupdate Pada</label>
                                <input type="text" class="form-control" value="{{ $transaction->updated_at->format('d/m/Y H:i') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('pengguna.transaction.edit', $transaction->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('pengguna.transaction.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus? Stok akan direset ke kondisi sebelumnya.')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('pengguna.transaction.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
