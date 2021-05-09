@extends('template')
@section('container')
        {{-- <div class="col-12"> --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- </div> --}}
        {{-- <div class="row">
          <div class="col-2">
            <a href="{{$btnRight['link']}}" class="btn btn-primary mb-3"> <span class="fa fa-plus-circle"></span> {{$btnRight['text']}}</a>
          </div>
        </div> --}}
        <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-custom">
                      <thead>
                        <tr>
                          <td>Nama Nasabah</td>
                          <td>:</td>
                          <td>{{$pinjaman->nasabah->nama}}</td>
                        </tr>
                        <tr>
                          <td>NIK</td>
                          <td>:</td>
                          <td>{{$pinjaman->nasabah->nik}}</td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-custom">
                      <thead>
                        <tr>
                          <td>Nominal Pinjaman</td>
                          <td>:</td>
                          <td>{{number_format($pinjaman->nominal, 2, ',', '.')}}</td>
                        </tr>
                        <tr>
                          <td>Terbayar</td>
                          <td>:</td>
                          <td>{{number_format($pinjaman->terbayar, 2, ',', '.')}}</td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Tanggal Pembayaran</td>
                        <td>Cicilan Ke</td>
                        <td>Nominal</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $page = Request::get('page');
                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                    @endphp
                    @foreach ($pelunasan as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{date('d-m-Y', strtotime($value->tanggal_pembayaran))}}</td>
                            <td>{{$value->cicilan_ke}}</td>
                            <td>{{number_format($value->nominal_pembayaran, 2, ',', '.')}}</td>
                        </tr>
                        @php
                            $no++
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
