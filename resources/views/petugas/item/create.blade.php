@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Data Item</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('petugas.item.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="code">Kode Item</label>
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                placeholder="Masukkan Kode Item" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Item</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan Nama Item" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit">Satuan</label>
                            <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror"
                                placeholder="Masukkan Satuan (pcs, box, dll)" value="{{ old('unit') }}" required>
                            @error('unit')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Stok Awal</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                min="0"
                                step="1"
                                class="form-control @error('stock') is-invalid @enderror"
                                placeholder="Masukkan Stok Awal"
                                value="{{ old('stock', 0) }}"
                            >
                            @error('stock')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="item_category_id">Kategori</label>
                            <select name="item_category_id" id="item_category_id" class="select @error('item_category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('item_category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom tengah -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan Deskripsi Item" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Foto Item</label>
                            <div class="image-upload image-upload-new">
                                <input type="file" name="photo" id="photo" accept="image/*" class="@error('photo') is-invalid @enderror">
                                <div class="image-uploads">
                                    <img src="{{ asset('template/assets/img/icons/upload.svg') }}" alt="img">
                                    <h4>Drag and drop a file to upload</h4>
                                </div>
                            </div>
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <button type="submit" class="btn btn-submit me-2">Submit</button>
                    <a href="{{ route('petugas.item.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

