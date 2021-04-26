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
                      <td>{{$nasabah->nama}}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{$nasabah->jenis_kelamin}}</td>
                    </tr>
                    <tr>
                      <td>Tanggal Lahir</td>
                      <td>:</td>
                      <td>{{date('d-m-Y', strtotime($nasabah->tanggal_lahir))}}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>:</td>
                      <td>{{$nasabah->nik}}</td>
                    </tr>
                    <tr>
                      <td>No Handphone</td>
                      <td>:</td>
                      <td>{{$nasabah->no_hp}}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{$nasabah->email}}</td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td>{{$nasabah->alamat}}</td>
                    </tr>
                    <tr>
                      <td>KTP</td>
                      <td>:</td>
                      <td><a href="{{ url('upload/nasabah'. '/' . $nasabah->nik . '/' .$nasabah->scan_ktp) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Foto Dengan KTP</td>
                      <td>:</td>
                      <td><a href="{{ url('upload/nasabah'. '/' . $nasabah->nik . '/' .$nasabah->foto_dengan_ktp) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>NPWP</td>
                      <td>:</td>
                      <td><a href="{{ url('upload/nasabah'. '/' . $nasabah->nik . '/' .$nasabah->npwp) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Surat Nikah</td>
                      <td>:</td>
                      <td><a href="{{ url('upload/nasabah'. '/' . $nasabah->nik . '/' .$nasabah->surat_nikah) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Surat Domisili Usaha</td>
                      <td>:</td>
                      <td><a href="{{ url('upload/nasabah'. '/' . $nasabah->nik . '/' .$nasabah->surat_domisili_usaha) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a></td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td><span class="badge badge-{{$nasabah->status == 'Aktif' ? 'success' : 'danger'}}">{{$nasabah->status}}</span></td>
                    </tr>
                  </table>
                </div>
                {{-- <a href="{{ url('nasabah/update-status', $nasabah->id) }}" class="btn btn-{{$nasabah->status == 'Aktif' ? 'danger' : 'success'}}" onclick="return confirm('Anda yakin?')">{{$nasabah->status == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan'}}</a> --}}
              </div>
            </div>
          </div>
        </div>
@endsection
