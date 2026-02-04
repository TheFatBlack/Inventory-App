@extends('template-ItemTransaction.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Transaksi Barang</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('item-transaction.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="item_id">Item</label>
                            <select name="item_id" id="item_id" class="select @error('item_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Item --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" @if(old('item_id') == $item->id) selected @endif>
                                        {{ $item->name }} ({{ $item->code }}) - Stok: {{ $item->stock->stock ?? 0 }} {{ $item->unit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe Transaksi</label>
                            <select name="type" id="type" class="select @error('type') is-invalid @enderror" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="masuk" @if(old('type') == 'masuk') selected @endif>
                                    <span style="color: green;">MASUK (Penambahan Stok)</span>
                                </option>
                                <option value="keluar" @if(old('type') == 'keluar') selected @endif>
                                    <span style="color: red;">KELUAR (Pengurangan Stok)</span>
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantity">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                placeholder="Masukkan Jumlah Barang" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="transaction_date">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
                                value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                            @error('transaction_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="note">Keterangan/Catatan</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                placeholder="Masukkan Keterangan Transaksi (Opsional)" rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('item-transaction.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
