@extends('template-admin.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Kategori Item</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('item-category.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan Nama Kategori" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan Deskripsi Kategori" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('item-category.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
