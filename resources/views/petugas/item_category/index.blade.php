@extends('template-admin.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Kategori Item</h4>
            <a href="{{ route('item-category.create') }}" class="btn btn-primary">
                <span class="d-flex align-items-center">
                    <i class="fas fa-plus"></i>&nbsp;Tambah Kategori
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('item-category.show', $category->id) }}" class="me-3">
                                        <img src="assets/img/icons/eye.svg" alt="img">
                                    </a>
                                    <a href="{{ route('item-category.edit', $category->id) }}" class="me-3">
                                        <img src="assets/img/icons/edit.svg" alt="img">
                                    </a>
                                    <form action="{{ route('item-category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" onclick="return confirm('Yakin ingin menghapus?')">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
