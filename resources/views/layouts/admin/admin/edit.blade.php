@extends('template-admin.home')

@section('content')

<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Edit Data Admin</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                            <div class="pass-group">
                                <input type="password" name="password" id="password" class="pass-input @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                                value="{{ old('nip', $user->nip) }}" required>
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
                                value="{{ old('no_hp', $user->no_hp) }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Profile Picture</label>
                            @if($user->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" style="max-width: 150px; border-radius: 5px;">
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
                    <a href="{{ route('admin.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
