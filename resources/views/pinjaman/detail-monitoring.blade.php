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
    {{-- <div class="solid-color font-weight-bold infopage">
        Data Peminjam
    </div> --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <td>Nama Peminjam</td>
                                    <td>:</td>
                                    <td>{{ $detail->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>{{ $detail->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{ date('d-m-Y', strtotime($detail->tanggal_lahir)) }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ $detail->jenis_kelamin }}</td>
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
                                    <td>Pekerjaan</td>
                                    <td>:</td>
                                    <td>{{ $detail->pekerjaan }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $detail->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>No Handphone</td>
                                    <td>:</td>
                                    <td>{{ $detail->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $detail->email }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- start timeline --}}
    <div class="row d-flex justify-content-center mt-5 mb-5">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Log Aktifitas</h5>
                    <div class="vertical-timeline vertical-timeline--animate
                                    vertical-timeline--one-column">
                        {{-- <div class="vertical-timeline-item
                                    vertical-timeline-element">
                            <div> <span class="vertical-timeline-element-icon
                                            bounce-in"> <i class="badge badge-dot
                                                badge-dot-xl badge-success"></i>
                                </span>
                                <div class="vertical-timeline-element-content
                                            bounce-in">
                                    <h4 class="timeline-title">Meeting with
                                        client</h4>
                                    <p>Meeting with USA Client, today at <a href="javascript:void(0);" data-abc="true">12:00
                                            PM</a></p>
                                    <span
                                        class="vertical-timeline-element-date">{{ date('d/m/y', strtotime($detail->tanggal_pengajuan)) }}</span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="vertical-timeline-item
                                        vertical-timeline-element">
                            <div> 
                                <span class="vertical-timeline-element-icon
                                                bounce-in"> <i class="badge badge-dot
                                                    badge-dot-xl badge-secondary"> </i>
                                </span>
                                <div class="vertical-timeline-element-content
                                                bounce-in">
                                    <h4 class="timeline-title">Peminjam mengajukan pinjaman</h4>
                                    {{-- <p>Yet another one, at <span class="text-success">5:00 PM</span></p> --}}
                                    <span
                                        class="vertical-timeline-element-date">{{ date('d/m/y', strtotime($detail->tanggal_pengajuan)) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="vertical-timeline-item vertical-timeline-element mt-4">
                            <div>
                                <span class="vertical-timeline-element-icon bounce-in"> <i
                                        class="badge badge-dot badge-dot-xl badge-success"></i>
                                </span>
                                <div class="vertical-timeline-element-content
                                                bounce-in">
                                    <p>Menunggu Verifikasi</p>
                                    {{-- <span class="vertical-timeline-element-date">{{ date('d/m/y', strtotime($detail->tanggal_pengajuan)) }}</span> --}}
                                </div>
                            </div>
                        </div>
                        @php
                            if ($detail->status != 'Pending') {
                                $verificator = \App\Models\User::select('nama')->where('id',$detail->id_user)->first();
                            }
                        @endphp
                        <div class="vertical-timeline-item vertical-timeline-element">
                            <div> 
                                <span class="vertical-timeline-element-icon
                                                bounce-in"> <i class="badge badge-dot
                                                    badge-dot-xl badge-{{$detail->status == 'Pending' ? 'warning' : ($detail->status == 'Terima' || $detail->status == 'Lunas' ? 'success' : ($detail->status == 'Tolak' ? 'danger' : '')) }}"> </i>
                                </span>
                                <div class="vertical-timeline-element-content
                                                bounce-in">
                                    <h4 class="timeline-title {{$detail->status == 'Terima' || $detail->status == 'Lunas' ? 'text-success' : ($detail->status == 'Tolak' ? 'text-danger' : 'text-warning')}}" > 
                                        {{$detail->status == 'Pending' ? 'Pengajuan Pinjaman belum terverifikasi' : ($detail->status == 'Terima' || $detail->status == 'Lunas' ? 'Pengajuan pinjaman diterima oleh ' . $verificator->nama : ($detail->status == 'Tolak' ? 'Pengajuan pinjaman ditolak oleh ' . $verificator->nama : '')) }}
                                    </h4>
                                    @if ($detail->status == 'Tolak')
                                        <p>
                                            {{$detail->alasan_penolakan}}
                                        </p>
                                    @endif
                                    <span class="vertical-timeline-element-date">
                                        {{$detail->status == 'Pending' ? '' : date('d/m/y', strtotime($detail->tanggal_diterima))}}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if ($detail->status == 'Terima' || $detail->status == 'Lunas')
                            <div class="vertical-timeline-item vertical-timeline-element mt-4">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"> <i
                                            class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content
                                                    bounce-in">
                                        <p>Proses Pencairan</p>
                                    </div>
                                </div>
                            </div>
                            @php
                                if ($detail->status_pencairan != 'Pending') {
                                    $verificatorPencairan = \App\Models\User::select('nama')->where('id',$detail->id_staff_pencairan)->first();
                                }
                            @endphp
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div> 
                                    <span class="vertical-timeline-element-icon
                                                    bounce-in"> <i class="badge badge-dot
                                                        badge-dot-xl badge-{{$detail->status_pencairan == 'Pending' ? 'warning' : ($detail->status_pencairan == 'Terima' || $detail->status_pencairan == 'Lunas' ? 'success' : ($detail->status_pencairan == 'Tolak' ? 'danger' : '')) }}"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content
                                                    bounce-in">
                                        <h4 class="timeline-title {{$detail->status_pencairan == 'Terima' || $detail->status_pencairan == 'Lunas' ? 'text-success' : ($detail->status_pencairan == 'Tolak' ? 'text-danger' : 'text-warning')}}" > 
                                            {{$detail->status_pencairan == 'Pending' ? 'Belum di cairkan' : ($detail->status_pencairan == 'Terima' || $detail->status_pencairan == 'Lunas' ? 'Pencairan pinjaman sukses.' : ($detail->status_pencairan == 'Tolak' ? 'Proses pencairan ditolak oleh ' . $verificator->nama : '')) }}
                                        </h4>
                                        @if ($detail->status_pencairan == 'Tolak')
                                            <p>
                                                {{$detail->alasan_penolakan_pencairan}}
                                            </p>
                                        @elseif ($detail->status_pencairan == 'Terima')
                                            <p>
                                                Pencairan pinjaman dilakukan di kantor cabang {{$detail->kecamatan}} oleh {{$verificatorPencairan->nama}}
                                            </p>
                                        @endif
                                        <span class="vertical-timeline-element-date">
                                            {{$detail->status_pencairan == 'Pending' ? '' : date('d/m/y', strtotime($detail->tanggal_pencairan))}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if ($detail->status_pencairan == 'Terima')
                                <div class="vertical-timeline-item vertical-timeline-element mt-1 mb-1">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in"> <i
                                                class="badge badge-dot badge-dot-xl badge-success"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content
                                                        bounce-in">
                                            <p>Pembayaran Pinjaman</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end timeline --}}

    <div class="table-responsive mt-3">
        <table class="table table-custom">
            <thead>
                <tr>
                    <td>Termin</td>
                    <td>Jatuh Tempo</td>
                    <td>Terbayar Pada</td>
                    <td>Jumlah Tagihan</td>
                    <td>Status</td>
                    <td>Keterlambatan</td>
                    <td>Denda Keterlambatan</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $date = date('Y-m-d');
                @endphp
                @foreach ($pelunasan as $item)
                    @php
                        //jika belum bayar dan terlambat dari jatuh tempo
                        if ($item->jatuh_tempo_cicilan < $date && $item->status == 'Belum') {
                            # code...
                            $keterlambatan = date_diff(date_create($date), date_create($item->jatuh_tempo_cicilan), true);
                            $keterlambatan = $keterlambatan->format('%a');
                            $denda = $keterlambatan * 1000;
                            // echo "<pre>";
                            // print_r ($keterlambatan->format("%a"));
                            // echo "</pre>";
                        }
                        // jika sudah terbayar dan terlambat
                        elseif ($item->jatuh_tempo_cicilan < $item->tanggal_pembayaran && $item->status == 'Lunas') {
                            $keterlambatan = date_diff(date_create($item->tanggal_pembayaran), date_create($item->jatuh_tempo_cicilan), true);
                            $keterlambatan = $keterlambatan->format('%a');
                            $denda = $keterlambatan * 1000;
                        } else {
                            $keterlambatan = 0;
                            $denda = 0;
                        }
                        
                    @endphp
                    <tr>
                        <td>{{ $item->cicilan_ke }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->jatuh_tempo_cicilan)) }}</td>
                        <td>{{ $item->tanggal_pembayaran ? date('d-m-Y', strtotime($item->tanggal_pembayaran)) : '-' }}
                        </td>
                        {{-- <td>{{number_format($item->nominal_pembayaran, 2, ',', '.')."<span class='fa ml-5 fa-lg fa-check-circle color-green'></span>" }}</td> --}}
                        <td>{{ 'Rp' . number_format($item->nominal_pembayaran + $item->bunga, 2, ',', '.') }}</td>
                        <td>{{ $item->status == 'Belum' ? $item->status . ' Terbayar' : $item->status }}</td>
                        <td>{{ $item->jatuh_tempo_cicilan < $date && $item->status == 'Belum' ? $keterlambatan->format('%R%a hari') : $keterlambatan . ' hari' }}
                        </td>
                        <td>{{ 'Rp' . number_format($denda, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('timeline-style')
    <style>
        /* .mt-70 {
                margin-top: 70px
            }

            .mb-70 {
                margin-bottom: 70px
            } */

        .card {
            box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
            border-width: 0;
            transition: all .2s
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(26, 54, 126, 0.125);
            border-radius: .25rem
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem
        }

        .vertical-timeline {
            width: 100%;
            position: relative;
            padding: 1.5rem 0 1.5rem;
        }

        .vertical-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 67px;
            height: 100%;
            width: 4px;
            background: #e9ecef;
            border-radius: .25rem
        }

        .vertical-timeline-element {
            position: relative;
            margin: 0 0 1rem
        }

        .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
            visibility: visible;
            animation: cd-bounce-1 .8s
        }

        .vertical-timeline-element-icon {
            position: absolute;
            top: 0;
            left: 60px
        }

        .vertical-timeline-element-icon .badge-dot-xl {
            box-shadow: 0 0 0 5px #fff
        }

        .badge-dot-xl {
            width: 18px;
            height: 18px;
            position: relative
        }

        .badge:empty {
            display: none
        }

        .badge-dot-xl::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: .25rem;
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -5px 0 0 -5px;
            background: #fff
        }

        .vertical-timeline-element-content {
            position: relative;
            margin-left: 90px;
            font-size: .8rem
        }

        .vertical-timeline-element-content .timeline-title {
            font-size: .8rem;
            text-transform: uppercase;
            margin: 0 0 .5rem;
            padding: 2px 0 0;
            font-weight: bold
        }

        .vertical-timeline-element-content .vertical-timeline-element-date {
            display: block;
            position: absolute;
            left: -90px;
            top: 0;
            padding-right: 10px;
            text-align: right;
            color: #adb5bd;
            font-size: .7619rem;
            white-space: nowrap
        }

        .vertical-timeline-element-content:after {
            content: "";
            display: table;
            clear: both
        }

    </style>
@endpush
