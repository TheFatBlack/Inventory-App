@extends('template-admin.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Detail Data Petugas</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Kolom kiri -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" class="form-control" value="{{ $user->nip }}" readonly>
                    </div>
                </div>

                <!-- Kolom kanan -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="no_hp">Nomor Hp</label>
                        <input type="text" id="no_hp" class="form-control" value="{{ $user->no_hp }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" id="role" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-submit me-2">Edit</a>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-cancel">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
