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
        <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-custom">
                      <thead>
                        <tr>
                          <td>Kode Pinjaman</td>
                          <td>:</td>
                          <td>{{$pinjaman->kode_pinjaman}}</td>
                        </tr>
                        <tr>
                          <td>Peminjam</td>
                          <td>:</td>
                          <td>{{$pinjaman->nasabah->nama}}</td>
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
                          <td>Jumlah Pinjaman</td>
                          <td>:</td>
                          <td>Rp.{{number_format($pinjaman->nominal, 2, ',', '.')}}</td>
                        </tr>
                        <tr>
                          <td>Terbayar</td>
                          <td>:</td>
                          <td>Rp.{{number_format($pinjaman->terbayar, 2, ',', '.')}}</td>
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
                      <td>Termin</td>
                      <td>Kode Pelunasan</td>
                      <td>Jatuh Tempo</td>
                      <td>Jumlah Tagihan</td>
                      <td>Pembayaran</td>
                    </tr>
                </thead>
                <tbody>
                  @php
                      $date = date('Y-m-d');
                  @endphp
                @foreach ($pinjaman->pelunasan as $item)
                @php         
                      //jika belum bayar dan terlambat dari jatuh tempo           
                      if ($item->jatuh_tempo_cicilan < $date && $item->status == 'Belum') {
                        # code...
                        $keterlambatan = date_diff(date_create($date),date_create($item->jatuh_tempo_cicilan), true);
                        $keterlambatan = $keterlambatan->format("%a");
                        $denda = $keterlambatan * 1000;
                      }
                      // jika sudah terbayar dan terlambat
                      elseif($item->jatuh_tempo_cicilan < $item->tanggal_pembayaran && $item->status == 'Lunas'){
                        $keterlambatan = date_diff(date_create($item->tanggal_pembayaran),date_create($item->jatuh_tempo_cicilan), true);
                        $keterlambatan = $keterlambatan->format("%a");
                        $denda = $keterlambatan * 1000;
                      }
                      else{
                        $keterlambatan = 0;
                        $denda = 0;
                      }
                  @endphp
                  <tr>
                    <td>{{$item->cicilan_ke}}</td>
                    <td>{{$item->kode_pelunasan}}</td>
                    <td>{{date('d-m-Y', strtotime($item->jatuh_tempo_cicilan))}}</td>
                    <td>{{'Rp' . number_format(($item->nominal_pembayaran + $item->bunga), 2, ',', '.')}}</td>
                    <td>
                        {{--  {{$item->status == 'Belum' ? $item->status . ' Terbayar' : $item->status}}  --}}
                        {{--  {{ $item->status   }}  --}}
                        @if($item->status == 'Belum')
                        {{--  <a href="{{ url('pembayaran-pinjaman/bayar/'.$item->kode_pelunasan) }}" class="btn btn-success mr-2" title="Detail Pembayaran" data-toggle="tooltip">  --}}
                        <a href="#" class="btn btn-success mr-2" data-toggle="modal" data-target="#payModal">
                            Bayar
                        </a>
                        @include('pelunasan.modal-pembayaran')
                        @else
                        {{$item->status}}
                        @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection

@push('scripts')
    <script>
        $("a[href^='http://']").attr("target","_blank");

        $('#paid').on("click", function(){

            $('#modal').modal('hide');
            window.location.reload();

            window.open(url, '_blank');

        })
    </script>
@endpush
