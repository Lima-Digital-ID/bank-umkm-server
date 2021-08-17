@extends('template')
@section('container')
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
        <form action="{{ url('laporan') }}" method="get">
          <div class="row">
            <div class="col-md-4">
              <label for="">Dari</label>
              <input type="text" autocomplete="off" name="dari" class="form-control datepicker" value="{{Request::get('dari') != null ? Request::get('dari') : date('Y-m-01')}}">
            </div>
            <div class="col-md-4">
              <label for="">Sampai</label>
              <input type="text" autocomplete="off" name="sampai" class="form-control datepicker" value="{{Request::get('sampai') != null ? Request::get('sampai') : date('Y-m-d')}}">
            </div>
            <div class="col-md-4">
              <label for="">Nasabah</label>
              <select name="nasabah" class="form-control select2">
                <option value="">Semua Nasabah</option>
                @foreach ($allNasabah as $nasabah)
                    <option value="{{$nasabah->id}}" {{Request::get('nasabah') != null && Request::get('nasabah') == $nasabah->id ? 'selected' : '' }} >{{$nasabah->nama . ' - ' . $nasabah->nik}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mt-4">
              <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
            </div>
          </div>
        </form>

        @if (Request::get('dari') && Request::get('sampai'))
        <hr>
          <div class="row col-auto">
            <div class="form-group mr-3">
                <a href="{{ url('laporan/chart')."?dari=$_GET[dari]&sampai=$_GET[sampai]"}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-chart-line" aria-hidden="true"></i> Detail
                </a>
            </div>
            <div class="form-group">
              <form action="{{ route('export-excel') }}" target="_blank" method="get">
                <input type="hidden" name="dari" value="{{ $_GET['dari'] }}" />
                <input type="hidden" name="sampai" value="{{ $_GET['sampai'] }}" />
                <input type="hidden" name="nasabah" value="{{ $_GET['nasabah'] }}" />
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-file-excel" aria-hidden="true"></i> Export Excel
                </button>
              </form>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-custom">
              <thead>
                <tr>
                    <td>#</td>
                    <td>Peminjam</td>
                    <td>Tanggal Pinjaman</td>
                    <td>Jangka Waktu</td>
                    <td>Jatuh Tempo</td>
                    <td>Jumlah Pinjaman</td>
                    <td>Terbayar</td>
                    <td>Status</td>
                </tr>
              </thead>
              <tbody>
                @php
                    $totalPinjaman = 0;
                    $totalPelunasan = 0;
                @endphp
                @foreach ($laporan as $value)
                  @php
                    $totalPinjaman += $value->nominal;
                    $totalPelunasan += $value->terbayar;
                  @endphp
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->nasabah->nama}}</td>
                    <td>{{date('d-m-Y', strtotime($value->tanggal_diterima))}}</td>
                    <td>{{$value->jangka_waktu}} bulan</td>
                    <td>{{date('d-m-Y', strtotime($value->jatuh_tempo))}}</td>
                    <td>{{number_format($value->nominal, 2, ',', '.')}}</td>
                    <td>{{number_format($value->terbayar, 2, ',', '.')}}</td>
                    <td><span class="badge badge-{{$value->status == 'Lunas' ? 'success' : 'primary'}}">{{$value->status == 'Lunas' ? 'Lunas' : 'Berjalan'}}</span></td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5" style="text-align: center">Total</th>
                  <th>{{number_format($totalPinjaman, 2, ',', '.')}}</th>
                  <th>{{number_format($totalPelunasan, 2, ',', '.')}}</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        @endif
@endsection
