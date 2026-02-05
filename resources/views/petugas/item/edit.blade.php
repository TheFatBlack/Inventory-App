@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Edit Data Item</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('petugas.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="code">Kode Item</label>
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $item->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Item</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $item->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit">Satuan</label>
                            <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror"
                                value="{{ old('unit', $item->unit) }}" required>
                            @error('unit')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Stok Saat Ini</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                min="0"
                                step="1"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $item->stock->stock ?? 0) }}"
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
                                    <option value="{{ $category->id }}" @if(old('item_category_id', $item->item_category_id) == $category->id) selected @endif>
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
                                rows="4">{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Foto Item</label>
                            @if($item->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="Photo" style="max-width: 150px; border-radius: 5px;">
                                </div>
                            @endif
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
                    <button type="submit" class="btn btn-submit me-2">Update</button>
                    <a href="{{ route('petugas.item.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

