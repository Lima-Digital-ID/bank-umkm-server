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
        <div class="row">
          <div class="col-md-2">
            <a href="{{$btnRight['link']}}?t={{$pinjaman->status}}" class="btn btn-primary mb-3"> <span class="fa fa-arrow-alt-circle-left"></span> {{$btnRight['text']}}</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-custom">
                    <tr>
                      <td>Nama Nasabah</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->nama}}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->jenis_kelamin}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lahir</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->nasabah->tanggal_lahir))}}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->nik}}</td>
                    </tr>
                    <tr>
                      <td>No Handphone</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->no_hp}}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->email}}</td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td>{{$pinjaman->nasabah->alamat}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Pengajuan</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_pengajuan))}}</td>
                    </tr>
                    @if ($pinjaman->status == 'Terima')
                    <tr>
                      <td>Tanggal Diterima</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_diterima))}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Batas Pelunasan</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_batas_pelunasan))}}</td>
                    </tr>
                    @endif
                    @if ($pinjaman->status == 'Lunas')
                    <tr>
                      <td>Tanggal Diterima</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_diterima))}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Batas Pelunasan</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_batas_pelunasan))}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lunas</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($pinjaman->tanggal_lunas))}}</td>
                    </tr>
                    @endif
                    <tr>
                      <td>Nominal</td>
                      <td>:</td>
                      <td>{{number_format($pinjaman->nominal, 2, ',', '.')}}</td>
                    </tr>
                    @if ($pinjaman->status == 'Terima')
                    <tr>
                      <td>Terbayar</td>
                      <td>:</td>
                      <td>{{number_format($pinjaman->terbayar, 2, ',', '.')}}</td>
                    </tr>
                    @endif
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td><span class="badge badge-{{$pinjaman->status == 'Pending' ? 'warning' : ($pinjaman->status == 'Terima' || $pinjaman->status == 'Lunas' ? 'success' : 'danger') }}">{{$pinjaman->status}}</span></td>
                    </tr>
                  </table>
                </div>
                @if ($pinjaman->status == 'Pending')
                  <a href="{{ url('pinjaman/update-status', $pinjaman->id) }}?status=Terima" class="btn btn-success" onclick="return confirm('Anda yakin?')">Terima</a>
                  <a href="{{ url('pinjaman/update-status', $pinjaman->id) }}?status=Tolak" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Tolak</a>
                @endif
              </div>
            </div>
          </div>
        </div>
@endsection