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
          <div class="col-2">
        
          </div>
          <div class="col-auto ml-auto">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ route('nasabah.index') }}" method="get">
              <div class="input-group">
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
                        <td>Nama</td>
                        <td>Jenis Kelamin</td>
                        <td>NIK</td>
                        <td>Email</td>
                        <td>Status</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $page = Request::get('page');
                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                    @endphp
                    @foreach ($nasabah as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->jenis_kelamin}}</td>
                            <td>{{$value->nik}}</td>
                            <td>{{$value->email}}</td>
                            <td><span class="badge badge-{{$value->is_verified == '1' ? 'success' : ($value->is_verified=='2' ? 'primary' : 'danger')}}">{{$value->is_verified == '1' ? 'Terverifikasi' : 'Pending'}}</span></td>
                            <td>
                                <div class="form-inline">
                                    {{-- <a href="{{ route('nasabah.edit', $value) }}" class="btn btn-success mr-2" title="Edit" data-toggle="tooltip"> <span class="fa fa-pen"></span> </a> --}}
                                    <a href="{{ route('nasabah.show', $value) }}" class="btn btn-success mr-2" title="Detail Nasabah" data-toggle="tooltip"> <span class="fa fa-eye"></span> </a>
                                    {{-- <a href="{{ url('nasabah/hasil-skoring', $value) }}" class="btn btn-secondary mr-2" title="Hasil Skoring" data-toggle="tooltip"> <span class="fa fa-clipboard-list"></span> </a> --}}
                                    {{-- @if ($value->dataTambahan)
                                        <a href="{{ route('data-tambahan-nasabah.show', $value->dataTambahan->id) }}" class="btn btn-primary mr-2" title="Data Tambahan" data-toggle="tooltip"> <span class="fa fa-folder-plus"></span> </a>
                                    @endif
                                    @if ($value->syaratPinjamanUmroh)
                                        <a href="{{ route('syarat-pinjaman-umroh.show', $value->syaratPinjamanUmroh->id) }}" class="btn btn-info mr-2" title="Syarat Pinjaman Umroh" data-toggle="tooltip"> <span class="fa fa-kaaba"></span> </a>
                                    @endif --}}

                                    {{-- <form action="{{ route('nasabah.destroy', $value) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger" title="Hapus" data-toggle="tooltip" onclick="confirm('{{ __("Apakah anda yakin ingin menghapus?") }}') ? this.parentElement.submit() : ''">
                                            <span class="fa fa-minus-circle"></span>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                        @php
                            $no++
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{$nasabah->appends(Request::all())->links('vendor.pagination.custom')}}
        </div>
@endsection
