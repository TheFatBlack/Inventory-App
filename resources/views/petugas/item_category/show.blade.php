@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Detail Kategori Item</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" value="{{ $category->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" rows="5" readonly>{{ $category->description ?? '-' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Item</label>
                        <input type="text" class="form-control" value="{{ $category->items()->count() }}" readonly>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('petugas.item-category.edit', $category->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('petugas.item-category.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('petugas.item-category.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

