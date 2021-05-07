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
                      <td>{{$dataTambahan->nasabah->nama}}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{$dataTambahan->nasabah->jenis_kelamin}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lahir</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($dataTambahan->nasabah->tanggal_lahir))}}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>:</td>
                      <td>{{$dataTambahan->nasabah->nik}}</td>
                    </tr>
                    <tr>
                      <td>No Handphone</td>
                      <td>:</td>
                      <td>{{$dataTambahan->nasabah->no_hp}}</td>
                    </tr>
                    {{-- <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{$dataTambahan->email}}</td>
                    </tr> --}}
                    <tr>
                      <td>Tempat Tinggal</td>
                      <td>:</td>
                      <td>{{$dataTambahan->tempat_tinggal}}</td>
                    </tr>
                    <tr>
                      <td>NPWP</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->scan_npwp) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>KTP Suami</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->ktp_suami) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>KTP Istri</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->ktp_istri) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Surat Nikah</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->surat_nikah) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>BPKP</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->bpkb) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Domisili Usaha</td>
                      <td>:</td>
                      <td><a href="{{ url($dataTambahan->domisili_usaha) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Status Kelengkapan Data</td>
                      <td>:</td>
                      <td><span class="badge badge-{{$dataTambahan->nasabah->status_kelengkapan_data == '1' ? 'success' : ($dataTambahan->nasabah->status_kelengkapan_data == '0' ? 'warning' : 'danger')}}">
                        {{$dataTambahan->nasabah->status_kelengkapan_data == '0' ? 'Pending' : ($dataTambahan->nasabah->status_kelengkapan_data=='1' ? 'ACC' : ($dataTambahan->nasabah->status_kelengkapan_data=='0' ? 'Pending' : 'Ditolak'))}}
                      </span></td>
                    </tr>
                  </table>
                </div>

                @if($dataTambahan->nasabah->status_kelengkapan_data==0)
                  <a href="{{ url('data-tambahan-nasabah/update-status?status=1', $dataTambahan->id)}}" class="btn btn-success">ACC</a>
                  <a href="{{ url('data-tambahan-nasabah/update-status?status=3', $dataTambahan->id)}}"class="btn btn-danger">Tolak</a>
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
@endsection
