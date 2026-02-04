@extends('template-petugas.home')

@section('content')

<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Halo {{ Auth::user()->name }} Selamat Datang</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{$total_admin}}</h4>
                    <h5>Total Admin</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{$total_petugas}}</h4>
                    <h5>Total Petugas</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>{{$total_pengguna}}</h4>
                    <h5>Total Pengguna</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{$total_stock}}</h4>
                    <h5>Total Stock</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="package"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{$total_barang}}</h4>
                    <h5>Total Items</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="package"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection