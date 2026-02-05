@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Detail Barang</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('petugas.item.index') }}" class="btn btn-added">
                <img src="{{ asset('template/assets/img/icons/return1.svg') }}" alt="img" class="me-1">Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        @if(!empty($item->photo))
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="product" style="max-width: 100%; border-radius: 8px;">
                        @else
                            <img src="{{ asset('template/assets/img/product/product1.jpg') }}" alt="product" style="max-width: 100%; border-radius: 8px;">
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <p class="form-control-plaintext">{{ $item->name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SKU</label>
                                <p class="form-control-plaintext">{{ $item->code }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Kategori</label>
                                <p class="form-control-plaintext">{{ $item->category->name ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit</label>
                                <p class="form-control-plaintext">{{ $item->unit }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Qty</label>
                                <p class="form-control-plaintext">{{ $item->stock->stock ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Dibuat Oleh</label>
                                <p class="form-control-plaintext">{{ $item->petugas->name ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <p class="form-control-plaintext">{{ $item->description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
