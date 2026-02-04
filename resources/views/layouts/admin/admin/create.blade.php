@extends('template-admin.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Data Admin</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                                placeholder="Masukkan Username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="pass-group">
                                <input type="password" name="password" id="password" class="pass-input @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password" required>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Masukkan Name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" 
                                placeholder="Masukkan NIP" value="{{ old('nip') }}" required>
                            @error('nip')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom tengah -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="no_hp">Nomor Hp</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                placeholder="Masukkan nomor handphone" value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan Email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <div class="image-upload image-upload-new">
                                <input type="file" name="photo" id="photo" accept="image/*" class="@error('photo') is-invalid @enderror">
                                <div class="image-uploads">
                                    <img src="assets/img/icons/upload.svg" alt="img">
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
                    <a href="{{ route('admin.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
