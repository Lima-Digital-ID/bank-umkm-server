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
        </div>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Tanggal Pembayaran</td>
                        <td>Nasabah</td>
                        <td>Cicilan Ke</td>
                        <td>Nominal</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $page = Request::get('page');
                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                    @endphp
                    @foreach ($pelunasan as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value->tanggal_pembayaran}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->cicilan_ke}}</td>
                            <td>{{number_format($value->nominal_pembayaran, 2, ',', '.')}}</td>
                            <td>
                                <div class="form-inline">
                                    {{-- <a href="{{ route('pelunasan.edit', $value) }}" class="btn btn-success mr-2" title="Edit" data-toggle="tooltip"> <span class="fa fa-pen"></span> </a> --}}
                                    <a href="{{ route('pelunasan.show', $value->id_pinjaman) }}" class="btn btn-warning mr-2" title="Detail" data-toggle="tooltip"> <span class="fa fa-eye"></span> </a>
                                    {{-- <form action="{{ route('pelunasan.destroy', $value) }}" method="post">
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
            {{$pelunasan->appends(Request::all())->links('vendor.pagination.custom')}}
        </div>
@endsection
