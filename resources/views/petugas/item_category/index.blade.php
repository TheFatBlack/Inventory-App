@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Product Category list</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('petugas.item-category.create') }}" class="btn btn-added">
                <img src="{{ asset('template/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Category
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('template/assets/img/icons/filter.svg') }}" alt="img">
                            <span><img src="{{ asset('template/assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="{{ asset('template/assets/img/icons/search-white.svg') }}" alt="img"></a>
                    </div>
                </div>
            </div>

            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <select class="select">
                                    <option>Choose Category</option>
                                    <option>Computers</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <select class="select">
                                    <option>Choose Sub Category</option>
                                    <option>Fruits</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <select class="select">
                                    <option>Choose Sub Brand</option>
                                    <option>Iphone</option>
                                </select>
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

            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Category name</th>
                            <th>Category Code</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($categories->count())
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        @php
                                            $categoryImage = null;
                                            if (!empty($category->image) && file_exists(public_path('storage/' . $category->image))) {
                                                $categoryImage = asset('storage/' . $category->image);
                                            }
                                        @endphp
                                        <a href="javascript:void(0);" class="product-img">
                                            <img
                                                src="{{ $categoryImage ?? asset('template/assets/img/product/noimage.png') }}"
                                                alt=""
                                            >
                                        </a>
                                        <a href="javascript:void(0);">{{ $category->name }}</a>
                                    </td>
                                    <td>{{ $category->code ?? '-' }}</td>
                                    <td>{{ $category->description ?? '-' }}</td>
                                    <td>{{ $category->created_by ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('petugas.item-category.edit', $category->id) }}" class="me-3">
                                            <img src="{{ asset('template/assets/img/icons/edit.svg') }}" alt="img">
                                        </a>
                                        <form action="{{ route('petugas.item-category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 confirm-text">
                                                <img src="{{ asset('template/assets/img/icons/delete.svg') }}" alt="img">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td class="text-center">Data tidak ditemukan</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
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
