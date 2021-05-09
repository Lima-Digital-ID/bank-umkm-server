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
            <a href="{{$btnRight['link']}}" class="btn btn-primary mb-3"> <span class="fa fa-arrow-alt-circle-left"></span> {{$btnRight['text']}}</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-custom">
                    <tr>
                      <td>Nama</td>
                      <td>:</td>
                      <td>{{$syaratPinjamanUmroh->nasabah->nama}}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{$syaratPinjamanUmroh->nasabah->jenis_kelamin}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lahir</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($syaratPinjamanUmroh->nasabah->tanggal_lahir))}}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>:</td>
                      <td>{{$syaratPinjamanUmroh->nasabah->nik}}</td>
                    </tr>
                    <tr>
                      <td>No Handphone</td>
                      <td>:</td>
                      <td>{{$syaratPinjamanUmroh->nasabah->no_hp}}</td>
                    </tr>
                    {{-- <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{$syaratPinjamanUmroh->email}}</td>
                    </tr> --}}
                    <tr>
                      <td>Surat Keterangan Travel</td>
                      <td>:</td>
                      <td><a href="{{ url($syaratPinjamanUmroh->suket_travel) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Foto Selfie Usaha</td>
                      <td>:</td>
                      <td><a href="{{ url($syaratPinjamanUmroh->selfie_usaha) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>SIUP</td>
                      <td>:</td>
                      <td><a href="{{ url($syaratPinjamanUmroh->siup) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>NIB</td>
                      <td>:</td>
                      <td><a href="{{ url($syaratPinjamanUmroh->nib) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Jaminan</td>
                      <td>:</td>
                      <td><a href="{{ url($syaratPinjamanUmroh->scan_jaminan) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Status Syarat Pinjaman</td>
                      <td>:</td>
                      <td><span class="badge badge-{{$syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh == '1' ? 'success' : ($syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh == '2' ? 'warning' : 'danger')}}">
                        {{$syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh == '2' ? 'Pending' : ($syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh=='1' ? 'ACC' : ($syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh=='2' ? 'Pending' : 'Ditolak'))}}
                      </span></td>
                    </tr>
                  </table>
                </div>

                @if($syaratPinjamanUmroh->nasabah->syarat_pinjaman_umroh==2)
                  <a href="{{ url('syarat-pinjaman-umroh/update-status?status=1', $syaratPinjamanUmroh->id)}}" class="btn btn-success">ACC</a>
                  <a href="{{ url('syarat-pinjaman-umroh/update-status?status=3', $syaratPinjamanUmroh->id)}}"class="btn btn-danger">Tolak</a>
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
@endsection
