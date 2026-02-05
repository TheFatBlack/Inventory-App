@extends('template-pengguna.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Ambil Barang</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengguna.transaction.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Purchase Date</label>
                            <div class="input-groupicon">
                                <input
                                    type="date"
                                    class="form-control @error('transaction_date') is-invalid @enderror"
                                    name="transaction_date"
                                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                                >
                                <div class="addonset">
                                    <img src="{{ asset('template/assets/img/icons/calendars.svg') }}" alt="img">
                                </div>
                            </div>
                            @error('transaction_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Product Name</label>
                            <select name="item_id" class="select @error('item_id') is-invalid @enderror" required>
                                <option value="">Choose</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" @if(old('item_id') == $item->id) selected @endif>
                                        {{ $item->name }} ({{ $item->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Reference No.</label>
                            <input type="text" class="form-control" value="{{ old('reference', '') }}" placeholder="Auto / Optional" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th class="text-end">Unit</th>
                                    <th class="text-end">Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="productimgname">
                                        <a class="product-img">
                                            <img src="{{ asset('template/assets/img/product/product7.jpg') }}" alt="product">
                                        </a>
                                        <a href="javascript:void(0);">
                                            {{ optional($items->first())->name ?? 'Item' }}
                                        </a>
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            step="1"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            value="{{ old('quantity') }}"
                                            placeholder="Qty"
                                            required
                                        >
                                        @error('quantity')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td class="text-end">{{ optional($items->first())->unit ?? '-' }}</td>
                                    <td class="text-end">
                                        <input type="hidden" name="type" value="keluar">
                                        <span class="badges bg-lightred">Keluar</span>
                                    </td>
                                    <td>
                                        <a class="delete-set"><img src="{{ asset('template/assets/img/icons/delete.svg') }}" alt="svg"></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order">
                            <ul>
                                <li class="total">
                                    <h4>Stok Tersedia</h4>
                                    <h5>{{ optional($items->first())->stock->stock ?? 0 }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="3"
                                placeholder="Keterangan transaksi (opsional)">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('pengguna.transaction.index') }}" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
