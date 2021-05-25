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
                      <td>
                        <a data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{url($nasabah->scan_ktp)}}">
                          <img src="{{url($nasabah->scan_ktp)}}" alt="" width="200px">
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>Foto Dengan KTP</td>
                      <td>:</td>
                      <td>
                        <a data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{url($nasabah->selfie_ktp)}}">
                          <img src="{{url($nasabah->selfie_ktp)}}" alt="" width="200px">
                        </a>
                      </td>
                      {{-- <td>
                        <img src="{{ url('upload/nasabah') . '/' . $nasabah->nik . '/' .$nasabah->selfie_ktp }}" alt="" width="200px">
                      </td> --}}
                    </tr>
                    <tr>
                      <td>NPWP</td>
                      <td>:</td>
                      <td>
                        @if ($nasabah->npwp)
                        <img src="{{ url($nasabah->npwp) }}" alt="" width="200px">
                        <a data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{ url($nasabah->npwp) }}">
                        </a>
                            
                        @endif
                      </td>
                      {{-- <td>
                        <img src="{{ url($nasabah->selfie_ktp) }}" alt="" width="200px">
                      </td> --}}
                    </tr>
                    <tr>
                      <td>Surat Nikah</td>
                      <td>:</td>
                      <td>
                        <a data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{ $nasabah->surat_nikah}}">
                          <img src="{{ $nasabah->surat_nikah}}" alt="" width="200px">
                        </a>
                      </td>
                      {{-- <td>
                        <img src="{{ url('upload/nasabah') . '/' . $nasabah->nik . '/' .$nasabah->surat_nikah }}" alt="" width="200px">
                      </td> --}}
                    </tr>
                    <tr>
                      <td>Surat Domisili Usaha</td>
                      <td>:</td>
                      <td>
                        <a data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{ $nasabah->surat_domisili_usaha }}">
                          <img src="{{ $nasabah->surat_domisili_usaha }}" alt="" width="200px">
                        </a>
                      </td>
                      {{-- <td>
                        <img src="{{ url('upload/nasabah') . '/' . $nasabah->nik . '/' .$nasabah->surat_domisili_usaha }}" alt="" width="200px">
                      </td> --}}
                    </tr>
                    
                    @if($nasabah->is_verified=='3')
                    <tr>
                      <td>Alasan Ditolak</td>
                      <td>:</td>
                      <td>{{$nasabah->alasan_penolakan}}</td>
                    </tr>
                    @endif

                  </table>
                </div>

                
                @if($nasabah->is_verified==2)
                  <a href="" data-toggle="modal" data-target=".modal-acc" class="btn btn-success">ACC</a>
                  <a href="" data-toggle="modal" data-target=".modal-tolak" class="btn btn-danger">Tolak</a>
                {{-- @elseif($nasabah->is_verified==3)
                  <a href="" data-toggle="modal" data-target=".modal-acc" class="btn btn-success">ACC</a> --}}
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <td>Total Skor</td>
                        <td>:</td>
                        <td>{{$nasabah->skor}}</td>
                      </tr>
                      <tr>
                        <td>Limit Pinjaman</td>
                        <td>:</td>
                        <td>{{number_format($nasabah->limit_pinjaman, 2, ',', '.')}}</td>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-custom">
                    {{-- @php
                        
                        echo "<pre>";
                        print_r ($hasilSkoring);
                        echo "</pre>";
                        
                    @endphp --}}
                    @foreach ($hasilSkoring as $item)
                      <tr>
                        <th>
                          <h5>{{$loop->iteration . '. ' . $item->nama_kategori}}</h5>
                        </th>
                      </tr>
                      @foreach ($item->kriteria as $kriteria)
                          @php
                              $selectedOption = '';
                              $skor = '';
                          @endphp
                          <tr>
                            <h5><th>{{$loop->iteration . '. ' . $kriteria->nama_kriteria}}</th></h5>
                          </tr>
                          @foreach ($kriteria->option as $option)
                            @php
                              $isSelected = DB::table('scoring')->where('id_nasabah', $nasabah->id)->where('id_option', $option->id)->count() > 0 ? true : false;
                            @endphp
                            <tr>
                              <td>
                                <div class="form-check">
                                  <input class="form-check-input skoringOption" type="radio" {{$isSelected ? 'checked' : ''}} >
                                  <label class="form-check-label">
                                    {{$option->option}}
                                  </label>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                      @endforeach
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal modal-acc">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Verifikasi Data</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form action="{{ url('nasabah/update-status', $nasabah->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tipe" value="acc">
                <label for="">Nama</label>
                <input type="text" value="{{$nasabah->nama}}" class="form-control" readonly>
                <div class="mt-4">
                  <button type="reset" class="btn btn-default"> <span class="fa fa-times"></span> Cancel</button>
                  &nbsp;
                  <button type="submit" class="btn btn-primary"> <span class="fa fa-check-circle"></span> Verifikasi</button>
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
      
      <div class="modal modal-show-detail">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              {{-- <h6 class="modal-title">Detail Data</h6> --}}
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <img alt="" id="showDetail" width="100%">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
