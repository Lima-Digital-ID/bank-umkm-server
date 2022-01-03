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
          {{-- <div class="col-2">
            <a href="{{$btnRight['link']}}" class="btn btn-primary mb-3"> <span class="fa fa-plus-circle"></span> {{$btnRight['text']}}</a>
          </div> --}}
          <div class="col-auto ml-auto">
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="" method="get">
              <div class="input-group">
              <input type="hidden" name="t" value="Pending">
                <input type="text" class="form-control bg-light border-1 small" placeholder="Cari Data..." aria-label="Search" name="keyword" aria-describedby="basic-addon2" value="{{Request::get('keyword')}}">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                      <tr>
                          <td>#</td>
                          <td>Kode Pinjaman</td>
                          <td>Tanggal Pinjaman</td>
                          <td>Jangka Waktu</td>
                          <td>Batas Pelunasan</td>
                          <td>Nominal</td>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $page = Request::get('page');
                            $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                        @endphp
                        @foreach ($pencairan as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value->pinjaman->kode_pinjaman}}</td>
                            <td>{{date('d-m-Y', strtotime($value->pinjaman->tanggal_diterima))}}</td>
                            <td>{{$value->pinjaman->jangka_waktu}}</td>
                            <td>{{date('d-m-Y', strtotime($value->pinjaman->jatuh_tempo))}}</td>
                            <td>Rp {{number_format($value->pinjaman->nominal, 2, ',', '.')}}</td>                            
                        </tr>
                            @php
                                $no++
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{$pencairan->appends(Request::all())->links('vendor.pagination.custom')}}
            </div>
@endsection
