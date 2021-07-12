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
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ route('syarat-pinjaman-umroh.index') }}" method="get">
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
                        <td>NIK</td>
                        <td>Alamat</td>
                        <td>Status</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $page = Request::get('page');
                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                    @endphp
                    @foreach ($syaratPinjamanUmroh as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value->nasabah->nama}}</td>
                            <td>{{$value->nasabah->nik}}</td>
                            <td>{{$value->nasabah->alamat}}</td>
                            <td>
                                @php
                                    if ($value->nasabah->syarat_pinjaman_umroh == '1')
                                        $statusData = 'Terverifikasi';
                                    elseif($value->nasabah->syarat_pinjaman_umroh == '2')
                                        $statusData = 'Pending';
                                    elseif($value->nasabah->syarat_pinjaman_umroh == '3')
                                        $statusData = 'Ditolak';
                                    else
                                        $statusData = 'Pending'                                    
                                @endphp
                                <span class="badge badge-{{$value->nasabah->syarat_pinjaman_umroh == '1' ? 'success' : ($value->is_verified=='2' ? 'primary' : 'danger')}}">{{$statusData}}</span>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <a href="{{ route('syarat-pinjaman-umroh.show', $value) }}" class="btn btn-warning mr-2" title="Detail" data-toggle="tooltip"> <span class="fa fa-eye"></span> </a>
                                    {{-- <form action="{{ route('syarat-pinjaman-umroh.destroy', $value) }}" method="post">
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
            {{$syaratPinjamanUmroh->appends(Request::all())->links('vendor.pagination.custom')}}
        </div>
@endsection
