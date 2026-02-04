@extends('template-admin.home')

@section('content')

<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Data Petugas</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-added">
                <img src="{{ asset('template/assets/img/icons/plus.svg') }}" alt="img">Add User
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Table top filter/search -->
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('template/assets/img/icons/filter.svg') }}" alt="img">
                            <span><img src="{{ asset('template/assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img
                                src="{{ asset('template/assets/img/icons/search-white.svg') }}" alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
                    <ul>
                        <li>
                            <a href="{{ route('admin.petugas.exportPDF') }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                <img src="{{ asset('template/assets/img/icons/pdf.svg') }}" alt="img">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:window.print()" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                <img src="{{ asset('template/assets/img/icons/printer.svg') }}" alt="img">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Filter inputs -->
            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="Masukkan Nama">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="Masukkan No Hp">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="datetimepicker cal-icon" placeholder="Choose Date">
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                            <div class="form-group">
                                <a class="btn btn-filters ms-auto">
                                    <img src="{{ asset('template/assets/img/icons/search-whites.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Data -->
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>No Hp</th>
                            <th>Role</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($petugas as $p)
                        <tr>
                            <td>{{ $p->user->name ?? $p->name }}</td>
                            <td>{{ $p->user->no_hp ?? $p->no_hp }}</td>
                            <td>{{ $p->user->role ?? $p->role }}</td>
                            <td>{{ $p->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a class="me-3" href="{{ route('admin.petugas.edit', $p->user_id) }}">
                                    <img src="{{ asset('template/assets/img/icons/edit.svg') }}" alt="img">
                                </a>

                                <form action="{{ route('admin.petugas.destroy', $p->user_id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="me-3 border-0 bg-transparent p-0">
                                        <img src="{{ asset('template/assets/img/icons/delete.svg') }}" alt="img">
                                    </button>
                                </form>
                                <a class="me-3" href="{{ route('admin.petugas.show', $p->user_id) }}">
                                    <img src="{{ asset('template/assets/img/icons/eye.svg') }}" alt="img">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // stop submit dulu
        if (confirm("Yakin ingin menghapus?")) {
            form.submit(); // baru submit kalau OK
        }
    });
});
</script>
@endsection