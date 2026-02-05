@extends('template-pengguna.home')

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>ITEM TRANSACTION LIST</h4>
        </div>
        <div class="page-btn">
            <a href="{{ route('pengguna.transaction.create') }}" class="btn btn-added">
                <img src="{{ asset('template/assets/img/icons/plus.svg') }}" alt="img">Add New Transaction
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <a href="{{ route('pengguna.transaction.exportPDF') }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
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

            <div class="card" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="datetimepicker cal-icon" placeholder="Choose Date">
                            </div>
                        </div>
                        <div class="col-lg col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Reference">
                            </div>
                        </div>
                        <div class="col-lg col-sm-6 col-12">
                            <div class="form-group">
                                <select class="select">
                                    <option>Choose Item</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg col-sm-6 col-12">
                            <div class="form-group">
                                <select class="select">
                                    <option>Choose Type</option>
                                    <option>Masuk</option>
                                    <option>Keluar</option>
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
                            <th>Item Name</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Qty</th>
                            <th>Created By</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $key => $transaction)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td class="text-bolds">{{ $transaction->item->name }}</td>
                                <td>{{ $transaction->item->code }}</td>
                                <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td>
                                    @if($transaction->type === 'masuk')
                                        <span class="badges bg-lightgreen">Masuk</span>
                                    @else
                                        <span class="badges bg-lightred">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->quantity }} {{ $transaction->item->unit }}</td>
                                <td>{{ $transaction->pengguna->name ?? auth()->user()->name ?? '-' }}</td>
                                <td>{{ $transaction->note ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pengguna.transaction.show', $transaction->id) }}" class="me-3">
                                        <img src="{{ asset('template/assets/img/icons/eye.svg') }}" alt="img">
                                    </a>
                                    <a href="{{ route('pengguna.transaction.edit', $transaction->id) }}" class="me-3">
                                        <img src="{{ asset('template/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <form action="{{ route('pengguna.transaction.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 confirm-text">
                                            <img src="{{ asset('template/assets/img/icons/delete.svg') }}" alt="img">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
