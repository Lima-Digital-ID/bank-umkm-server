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
        <div class="col-6 ml-auto">
            <form class="" action=""
                method="get">
                <div class="input-group">
                    @if (auth()->user()->level == 'Administrator')
                        <div class="col-md-5">
                            <select class="form-control select2" name="id_kantor_cabang" id="id_kantor_cabang">
                                <option value="">Semua Kantor Cabang</option>
                                @foreach ($kantorCabang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ Request::get('id_kantor_cabang') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-5">
                        <select class="form-control select2" name="id_jenis_pinjaman" id="id_jenis_pinjaman">
                            <option value="">Semua Jenis Pinjaman</option>
                            @foreach ($jenisPinjaman as $item)
                                <option value="{{ $item->id }}"
                                    {{ Request::get('id_jenis_pinjaman') == $item->id ? 'selected' : '' }}>
                                    {{ $item->jenis_pinjaman }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- @if (Request::get('t')) --}}
    <br>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Peminjam</td>
                    <td>NIK</td>
                    <td>Kode Pinjaman</td>
                    <td>Jenis Pinjaman</td>
                    <td>Tanggal Pengajuan</td>
                    <td>Termin</td>
                    <td>Jatuh Tempo</td>
                    <td>Kantor Cabang</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $page = Request::get('page');
                    $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                @endphp
                @foreach ($pinjaman as $value)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ $value->nik }}</td>
                        <td>{{ $value->kode_pinjaman }}</td>
                        <td>{{ $value->jenis_pinjaman }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->tanggal_pengajuan)) }}</td>
                        <td>{{ $value->jangka_waktu }} bulan</td>
                        <td>{{ date('d-m-Y', strtotime($value->jatuh_tempo)) }}</td>
                        <td>{{ $value->kecamatan }}</td>
                        <td>
                            <div class="form-inline">
                                <a href="{{ route('pinjaman.monitoring-detail', $value->id) }}"
                                    class="btn btn-primary mr-2" title="Detail Pinjaman" data-toggle="tooltip"> <span
                                        class="fa fa-eye"></span> </a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        {{ $pinjaman->appends(Request::all())->links('vendor.pagination.custom') }}
    </div>
    {{-- @endif --}}
@endsection
