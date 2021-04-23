@extends('template')

@section('container')
<div class="alert alert-success custom-alert">
    <span class="fa fa-exclamation-triangle sticky"></span>
    <label>Selamat datang di Bank UMKM</label>
    <br>
    <label class="font-weight-normal">{{date('d-M-Y H:m:s')}}</label>
</div>
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">2</h2>
                        Jumlah User
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-box-open fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('admin/user')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2 has-notif">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">5</h2>
                        Blog
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-boxes fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('admin/blog')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">7</h2>
                        Informasi
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-tag fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('admin/informasi')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">12</h2>
                        Galeri
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-secret fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('admin/galeri')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

@endsection