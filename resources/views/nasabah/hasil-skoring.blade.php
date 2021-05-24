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
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <td>Nama Nasabah</td>
                        <td>:</td>
                        <td>{{$nasabah->nama}}</td>
                      </tr>
                      <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{$nasabah->nik}}</td>
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
                                  <input class="form-check-input" type="radio" value="option1" {{$isSelected ? 'checked' : ''}} >
                                  <label class="form-check-label" for="exampleRadios1">
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
        
        <script>
          $('.form-check-input').click(function (e) { 
            $(this).attr('disabled','disabled');();
            
          });
        </script>

@endsection
