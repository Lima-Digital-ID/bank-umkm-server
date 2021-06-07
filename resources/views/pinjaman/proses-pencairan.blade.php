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
              <form action="{{ url('pinjaman/update-pencairan', [$pinjaman->id, 'Terima'],) }}" method="get">
                @csrf
                @method("GET")
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-custom">
                      <tr>
                        <td>Peminjam</td>
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
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td>{{$pinjaman->nasabah->pekerjaan}}</td>
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
                        <td>{{date('d-m-Y', strtotime($pinjaman->jatuh_tempo))}}</td>
                      </tr>
                      @endif
                     
                      {{-- <tr>
                        <td>Jenis Pinjaman</td>
                        <td>:</td>
                        <td>{{ $pinjaman->jenisPinjaman->jenis_pinjaman }} </td>
                      </tr> --}}
                      <tr>
                        <td>Pelunasan</td>
                        <td>:</td>
                        <td>{{ $pinjaman->jangka_waktu }} Bulan</td>
                      </tr>

                      @if ($pinjaman->status != 'Tolak')
                      <tr>
                        <td>Nominal</td>
                        <td>:</td>
                        <td>
                          @if ($pinjaman->status == 'Pending')
                          Rp. {{number_format($pinjaman->nominal, 2, ',', '.')}}
                          @else
                          Rp. {{number_format($pinjaman->nominal, 2, ',', '.')}}
                          @endif
                        </td>
                      </tr>
                      @endif
                      <tr>
                        <td>Skor</td>
                        <td>:</td>
                        <td>
                          {{$pinjaman->nasabah->skor}}
                        </td>
                      </tr>
                    </table>
                  </div>
                  @if (auth()->user()->level == 'Pencairan')
                    @if ($pinjaman->status_pencairan == 'Pending')
                      {{-- <a href="{{ url('pinjaman/update-status', $pinjaman->id) }}?status=Terima" class="btn btn-success" onclick="return confirm('Anda yakin?')">Terima</a> --}}
                      <button type="submit" class="btn btn-success" onclick="return confirm('Anda yakin?')">Terima</button>
                      <a href="" data-toggle="modal" data-target=".modal-tolak" class="btn btn-danger">Tolak</a>
                    @endif
                  @endif
                </div>
              </form>
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
              <form action="{{ url('pinjaman/update-pencairan', $pinjaman->id).'/Tolak' }}" method="get">
                @csrf
                <label for="">Alasan</label>
                <textarea name="alasan_penolakan_pencairans" class="form-control"  id="" rows="5"></textarea>
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
