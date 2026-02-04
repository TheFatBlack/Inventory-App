@extends('template-admin.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Edit Transaksi Barang</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('item-transaction.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="item">Item</label>
                            <input type="text" class="form-control" value="{{ $transaction->item->name }} ({{ $transaction->item->code }})" readonly>
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe Transaksi</label>
                            <input type="text" class="form-control" value="{{ strtoupper($transaction->type) }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                value="{{ old('quantity', $transaction->quantity) }}" required>
                            @error('quantity')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jumlah sebelumnya: {{ $transaction->quantity }} {{ $transaction->item->unit }}</small>
                        </div>

                        <div class="form-group">
                            <label for="transaction_date">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
                                value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required>
                            @error('transaction_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="note">Keterangan/Catatan</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                rows="3">{{ old('note', $transaction->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('item-transaction.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
