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
                        <td>Cicilan Ke</td>
                        <td>Tanggal Jatuh Tempo</td>
                        <td>Tanggal Pembayaran</td>
                        <td>Nominal</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                  for($i=1;$i<=$pinjaman->jangka_waktu;$i++){
                    $cek = \DB::table('pelunasan')->select('nominal_pembayaran','tanggal_pembayaran')->where('id_pinjaman',$pinjaman->id)->where('cicilan_ke',$i)->get();
                ?>
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{date('d-m-Y',strtotime("+$i month", strtotime($pinjaman->tanggal_diterima)))}}</td>
                    <td>{{count($cek)==0 ? '-' : date('Y-m-d', strtotime($cek[0]->tanggal_pembayaran)) }}</td>
                    <td>{{count($cek)==0 ? '-' : number_format($cek[0]->nominal_pembayaran, 2, ',', '.')." <span class='fa fa-check-circle'></span>" }}</td>
                  </tr>
                <?php
                  }
                ?>
<!--                     @php
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
 -->                </tbody>
            </table>
        </div>
@endsection
