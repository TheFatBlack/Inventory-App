@extends('template-admin.home')

@section('content')

<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Rekap Barang</h4>
            <h6>Ringkasan stok dan transaksi barang</h6>
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
                <div class="wordset">
                    <ul>
                        <li>
                            <a href="{{ route('admin.rekap.exportPDF') }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                    src="{{ asset('template/assets/img/icons/pdf.svg') }}" alt="img"></a>
                        </li>
                        <li>
                            <a href="javascript:window.print()" data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                    src="{{ asset('template/assets/img/icons/printer.svg') }}" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="Cari Nama / SKU">
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
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Sold qty</th>
                            <th>Instock qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td class="productimgname">
                                <a class="product-img">
                                    @if(!empty($item->photo))
                                        <img src="{{ Storage::url($item->photo) }}" alt="product">
                                    @else
                                        <img src="{{ asset('template/assets/img/product/product1.jpg') }}" alt="product">
                                    @endif
                                </a>
                                <a href="javascript:void(0);">{{ $item->name }}</a>
                            </td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->category->name ?? 'N/D' }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->sold_qty ?? 0 }}</td>
                            <td>{{ $item->instock ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection