@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Edit Category</h4>
            <h6>Update product Category</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('petugas.item-category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="code">Category Code</label>
                            <input
                                type="text"
                                name="code"
                                id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $category->code) }}"
                            >
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea
                                name="description"
                                id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="5"
                            >{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="image"> Product Image</label>
                            @if($category->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="product" style="max-width: 120px; border-radius: 6px;">
                                </div>
                            @endif
                            <div class="image-upload">
                                <input type="file" name="image" id="image" class="@error('image') is-invalid @enderror">
                                <div class="image-uploads">
                                    <img src="{{ asset('template/assets/img/icons/upload.svg') }}" alt="img">
                                    <h4>Drag and drop a file to upload</h4>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('petugas.item-category.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

