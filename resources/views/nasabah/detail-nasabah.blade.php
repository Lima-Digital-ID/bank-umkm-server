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
                    {{-- <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{$nasabah->email}}</td>
                    </tr> --}}
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
                      <td><span class="badge badge-{{$nasabah->is_verified == '1' ? 'success' : $nasabah->is_verified=='2' ? 'primary' : 'danger'}}">
                        {{$nasabah->is_verified=='0' ? 'Pending' : $nasabah->is_verified=='1' ? 'ACC' : $nasabah->is_verified=='2' ? 'Pending' : 'Ditolak'}}
                      </span></td>
                    </tr>
                    @if($nasabah->is_verified=='3')
                    <tr>
                      <td>Alasan Ditolak</td>
                      <td>:</td>
                      <td>{{$nasabah->alasan_penolakan}}</td>
                    </tr>
                    @endif

                    <tr>
                      <td>Limit Pinjaman</td>
                      <td>:</td>
                      <td>Rp. {{number_format($nasabah->limit_pinjaman,0,',','.')}}</td>
                    </tr>
                  </table>
                </div>

                
                @if($nasabah->is_verified==0)
                  <a href="" data-toggle="modal" data-target=".modal-acc" class="btn btn-success">ACC</a>
                  <a href="" data-toggle="modal" data-target=".modal-tolak" class="btn btn-danger">Tolak</a>
                @elseif($nasabah->is_verified==3)
                  <a href="" data-toggle="modal" data-target=".modal-acc" class="btn btn-success">ACC</a>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="modal modal-acc">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Limit Pinjaman</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form action="{{ url('nasabah/update-status', $nasabah->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tipe" value="acc">
                <label for="">Limit Pinjaman</label>
                <input type="number" name="limit" class="form-control">
                <div class="mt-4">
                  <button type="reset" class="btn btn-default"> <span class="fa fa-times"></span> Cancel</button>
                  &nbsp;
                  <button type="submit" class="btn btn-primary"> <span class="fa fa-save"></span> Save</button>
              </div>

              </form>
            </div>
          </div>
        </div>
      </div>        

      <div class="modal modal-tolak">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Alasan Penolakan</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form action="{{ url('nasabah/update-status', $nasabah->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tipe" value="tolak">
                <label for="">Alasan</label>
                <textarea name="alasan" class="form-control"  id="" rows="5"></textarea>
                <div class="mt-4">
                  <button type="reset" class="btn btn-default"> <span class="fa fa-times"></span> Cancel</button>
                  &nbsp;
                  <button type="submit" class="btn btn-primary"> <span class="fa fa-save"></span> Save</button>
              </div>

              </form>
            </div>
          </div>
        </div>
      </div>        
@endsection
