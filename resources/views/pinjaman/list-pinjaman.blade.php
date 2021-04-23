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
            {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ route('pinjaman.index') }}" method="get">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-1 small" placeholder="Cari Data..." aria-label="Search" name="keyword" aria-describedby="basic-addon2" value="{{Request::get('keyword')}}">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form> --}}
          </div>
        </div>
        @if (Request::get('t'))
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        @if (Request::get('t') == 'Pending')
                            <tr>
                                <td>#</td>
                                <td>Nama Peminjam</td>
                                <td>Jangka Waktu</td>
                                <td>Nominal</td>
                                <td>Status</td>
                                <td>Aksi</td>
                            </tr>
                        @elseif(Request::get('t') == 'Terima')
                            <tr>
                                <td>#</td>
                                <td>Nama Peminjam</td>
                                <td>Tanggal Pinjaman</td>
                                <td>Tanggal Lunas</td>
                                <td>Jangka Waktu</td>
                                <td>Nominal</td>
                                <td>Status</td>
                                <td>Aksi</td>
                            </tr>
                        @else
                            <tr>
                                <td>#</td>
                                <td>Nama Peminjam</td>
                                <td>Jangka Waktu</td>
                                <td>Nominal</td>
                                <td>Status</td>
                                <td>Aksi</td>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @php
                            $page = Request::get('page');
                            $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                        @endphp
                        @foreach ($pinjaman as $value)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$value->nasabah->nama}}</td>
                                @if ($value->status == 'Terima')
                                <td>{{date('d-m-Y', strtotime($value->tanggal_diterima))}}</td>
                                <td>{{date('d-m-Y', strtotime($value->tanggal_lunas))}}</td>
                                @endif
                                <td>{{$value->jangka_waktu}}</td>
                                <td>{{$value->nominal}}</td>
                                <td><span class="badge badge-{{$value->status == 'Pending' ? 'warning' : ($value->status == 'Terima' ? 'success' : 'warning')}}">{{$value->status}}</span></td>
                                <td>
                                    <div class="form-inline">
                                        <a href="{{ route('pinjaman.edit', $value) }}" class="btn btn-success mr-2" title="Edit" data-toggle="tooltip"> <span class="fa fa-pen"></span> </a>
                                        <a href="{{ route('pinjaman.show', $value) }}" class="btn btn-warning mr-2" title="Detail" data-toggle="tooltip"> <span class="fa fa-eye"></span> </a>
                                        <a href="{{ route('nasabah.show', $value->id_nasabah) }}" class="btn btn-warning mr-2" title="Detail Peminjam" data-toggle="tooltip"> <span class="fa fa-user"></span> </a>
                                        <form action="{{ route('pinjaman.destroy', $value) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" title="Hapus" data-toggle="tooltip" onclick="confirm('{{ __("Apakah anda yakin ingin menghapus?") }}') ? this.parentElement.submit() : ''">
                                                <span class="fa fa-minus-circle"></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $no++
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{$pinjaman->appends(Request::all())->links('vendor.pagination.custom')}}
            </div>
        @endif
@endsection
