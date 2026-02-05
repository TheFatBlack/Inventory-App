@extends('template-petugas.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Barang List</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('petugas.item.create') }}" class="btn btn-added">
                <img src="{{ asset('template/assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Barang
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
                    <div class="wordset">
                        <ul>
                            <li>
                                <a href="{{ route('petugas.item.exportPDF') }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
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

            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Barang</option>
                                            <option>Macbook pro</option>
                                            <option>Orange</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Category</option>
                                            <option>Computers</option>
                                            <option>Fruits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Sub Category</option>
                                            <option>Computer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto">
                                            <img src="{{ asset('template/assets/img/icons/search-whites.svg') }}" alt="img">
                                        </a>
                                    </div>
                                </div>
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
                            <th>Barang</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items->count())
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            @if(!empty($item->photo))
                                                <img src="{{ asset('storage/' . $item->photo) }}" alt="product">
                                            @else
                                                <img src="{{ asset('template/assets/img/product/product1.jpg') }}" alt="product">
                                            @endif
                                        </a>
                                        <a href="javascript:void(0);">{{ $item->name }}</a>
                                    </td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->category->name ?? '-' }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->stock->stock ?? 0 }}</td>
                                    <td>{{ $item->petugas->name ?? '-' }}</td>
                                    <td>
                                        <a class="me-3" href="{{ route('petugas.item.edit', $item->id) }}">
                                            <img src="{{ asset('template/assets/img/icons/edit.svg') }}" alt="img">
                                        </a>
                                        <form action="{{ route('petugas.item.destroy', $item->id) }}" method="POST" class="d-inline">
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
