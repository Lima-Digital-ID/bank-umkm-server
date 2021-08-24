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
        <div class="col-6 ml-auto">
            <form class="" action=""
                method="get">
                <div class="input-group">
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
                    <div class="col-md-5">
                        <input type="text" class="form-control bg-light border-1 small" placeholder="Cari Data..." aria-label="Search" name="keyword" aria-describedby="basic-addon2" value="{{Request::get('keyword')}}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                  <tr>
                      <td>#</td>
                      <td>Peminjam</td>
                      <td>Jenis Pinjaman</td>
                      <td>Tanggal Pinjaman</td>
                      <td>Jangka Waktu</td>
                      <td>Jatuh Tempo</td>
                      <td>Jumlah Pinjaman</td>
                      <td>Jumlah Terbayar</td>
                      <td>Status</td>
                      <td>Aksi</td>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $page = Request::get('page');
                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                    @endphp
                    @forelse ($listPembayaran as $value)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value->nasabah->nama}}</td>
                            <td>{{$value->jenisPinjaman->jenis_pinjaman}}</td>
                            <td>{{date('d-m-Y', strtotime($value->tanggal_diterima))}}</td>
                            <td>{{$value->jangka_waktu}} Bulan</td>
                            <td>{{date('d-m-Y', strtotime($value->jatuh_tempo))}}</td>
                            <td>Rp {{number_format($value->nominal, 2, ',', '.')}}</td>
                            <td>Rp {{number_format($value->terbayar, 2, ',', '.')}}</td>
                            <td><span class="badge badge-{{$value->status == 'Terima' ? 'primary' : 'success'}}">{{$value->status}}</span></td>
                            <td>
                                <div class="form-inline">
                                    <a href="{{ url('pembayaran-pinjaman/list-pembayaran/'.$value->id.'/detail') }}" class="btn btn-success mr-2" title="Detail Pembayaran" data-toggle="tooltip">
                                        Selengkapnya
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php
                            $no++
                        @endphp
                    @empty
                    <tr>
                        <td colspan="10">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{$listPembayaran->appends(Request::all())->links('vendor.pagination.custom')}}
        </div>
@endsection

