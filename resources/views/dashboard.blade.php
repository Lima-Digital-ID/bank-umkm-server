@extends('template')

@section('container')
<div class="alert alert-success custom-alert">
    <span class="fa fa-exclamation-triangle sticky"></span>
    <label>Selamat datang di Bank UMKM</label>
    <br>
    <label class="font-weight-normal">{{date('d-M-Y H:m:s')}}</label>
</div>
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2 {{$nasabahBaru > 0 ? 'has-notif' : ''}}">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$nasabahBaru}}</h2>
                        Peminjam Perlu Diverifikasi
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-clock fa-4x"></span>
                    </div>
                </div>
                <hr>
                @if (auth()->user()->level == 'Verificator' || auth()->user()->level == 'Administrator')
                    <a href="{{url('nasabah?verified=2')}}">Lihat Detail</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$nasabahVerified}}</h2>
                        Peminjam Terverifikasi
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-check fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('nasabah')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2 {{$pengajuanPinjaman > 0 ? 'has-notif' : ''}}">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$pengajuanPinjaman}}</h2>
                        Pengajuan Pinjaman
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-hand-holding-usd fa-4x"></span>
                    </div>
                </div>
                <hr>
                @if (auth()->user()->level == 'Verificator' || auth()->user()->level == 'Administrator')
                    <a href="{{url('pinjaman?t=Pending')}}">Lihat Detail</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2 {{$pinjamanBelumDicairkan > 0 ? 'has-notif' : ''}}">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$pinjamanBelumDicairkan}}</h2>
                        Pinjaman Belum Dicairkan
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-money-check fa-4x"></span>
                    </div>
                </div>
                <hr>
                @if (auth()->user()->level == 'Verificator' || auth()->user()->level == 'Administrator')
                    <a href="{{url('pinjaman/pencairan')}}">Lihat Detail</a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$pinjamanBerjalan}}</h2>
                        Pinjaman Berjalan
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-money-check-alt fa-4x"></span>
                    </div>
                </div>
                <hr>
                @if (auth()->user()->level == 'Verificator' || auth()->user()->level == 'Administrator')
                    <a href="{{url('pinjaman?t=Terima')}}">Lihat Detail</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$cicilanTelat}}</h2>
                        Pembayaran Terlambat
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-clock fa-4x"></span>
                    </div>
                </div>
                <hr>
                @if (auth()->user()->level == 'Administrator')
                    <a href="{{url('pelunasan/late-payment')}}">Lihat Detail</a>
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="row"> --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <canvas id="rekapBulanIni"></canvas>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    
    var nominalPinjamanBulanan = <?php echo $nominalPinjamanBulanan; ?>;
    var nominalPembayaranBulanan = <?php echo $nominalPembayaranBulanan; ?>;
    var valuasi = <?php echo $valuasi; ?>;
    var tahun = <?php echo $tahun; ?>;
    console.log(nominalPinjamanBulanan)
    console.log(nominalPembayaranBulanan)
    console.log(valuasi)
    // var nominalPembayaranHarian = 2000;
    var chartBulanIni = {
        // labels: tanggal,
        // datasets: [
        //     {
        //         label: 'Nominal Pinjaman Harian',
        //         backgroundColor: "transparent",
        //         data: nominalPinjamanHarian,
        //         borderColor: '#3c4099',
        //         pointBackgroundColor: '#3c4099',
        //         // tension: 1,
        //         bezierCurve: true
        //     },
        //     {
        //         label: 'Nominal Pembayaran Harian',
        //         backgroundColor: "transparent",
        //         data: nominalPinjamanHarian,
        //         borderColor: '##2ed8b6',
        //         pointBackgroundColor: '##2ed8b6',
        //         // tension: 1,
        //         bezierCurve: true
        //     }
        // ]
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
  datasets: [{
      label: "Pinjaman Bulanan",
      fill: false,
    //   lineTension: 0.1,
      backgroundColor: "#3c4099",
      borderColor: "#3c4099", // The main line color
      borderCapStyle: 'butt',
      borderDash: [], // try [5, 15] for instance
      borderDashOffset: 0.0,
      borderJoinStyle: 'miter',
      pointBorderColor: "#3c4099",
      pointBackgroundColor: "white",
      pointBorderWidth: 2,
      pointHoverRadius: 8,
      pointHoverBackgroundColor: "#3c4099",
      pointHoverBorderColor: "#3c4099",
      pointHoverBorderWidth: 3,
      pointRadius: 4,
      pointHitRadius: 10,
      // notice the gap in the data and the spanGaps: true
      data: nominalPinjamanBulanan,
      spanGaps: true,
      bezierCurve: true,
    }, {
      label: "Pembayaran",
      fill: false,
    //   lineTension: 0.1,
      backgroundColor: "#2ed8b6",
      borderColor: "#2ed8b6",
      borderCapStyle: 'butt',
      borderDash: [],
      borderDashOffset: 0.0,
      borderJoinStyle: 'miter',
      pointBorderColor: "#2ed8b6",
      pointBackgroundColor: "white",
      pointBorderWidth: 2,
      pointHoverRadius: 8,
      pointHoverBackgroundColor: "#2ed8b6",
      pointHoverBorderColor: "#2ed8b6",
      pointHoverBorderWidth: 3,
      pointRadius: 4,
      pointHitRadius: 10,
      // notice the gap in the data and the spanGaps: false
      data: nominalPembayaranBulanan,
      spanGaps: true,
      bezierCurve: true,
    }, {
      label: "Valuasi",
      fill: false,
    //   lineTension: 0.1,
      backgroundColor: "#4099ff",
      borderColor: "#4099ff",
      borderCapStyle: 'butt',
      borderDash: [],
      borderDashOffset: 0.0,
      borderJoinStyle: 'miter',
      pointBorderColor: "#4099ff",
      pointBackgroundColor: "white",
      pointBorderWidth: 2,
      pointHoverRadius: 8,
      pointHoverBackgroundColor: "#4099ff",
      pointHoverBorderColor: "#4099ff",
      pointHoverBorderWidth: 3,
      pointRadius: 4,
      pointHitRadius: 10,
      // notice the gap in the data and the spanGaps: false
      data: valuasi,
      spanGaps: true,
      bezierCurve: true,
    }

  ]
// };
    };
    
    window.onload = function() {

        var chrt = document.getElementById("rekapBulanIni").getContext("2d");
        window.myBar = new Chart(chrt, {
            type: 'line',
            data: chartBulanIni,
            options: {
                elements: {
                    // rectangle: {
                    //     borderWidth: 1,
                    //     borderColor: 'white',
                    //     borderSkipped: 'bottom'
                    // }
                },
                responsive: true,
                title: {
                  display: true,
                  position: "top",
                  text: 'Rekapitulasi Transaksi Bulanan Tahun ' + tahun,
                  fontSize: 16,
                  fontColor: "#3c4099",
                  fontFamily: 'Poppins'
                },
                legend: {
                  display: true,
                  position: "top",
                  labels: {
                    fontColor: "#3c4099",
                    fontSize: 13,
                    fontFamily: 'Poppins'
                  }
                },
                scales: {
                  yAxes: [{
                      display: true,
                      ticks: {
                          beginAtZero: true,
                          fontColor: "#3c4099",
                          fontFamily: 'Poppins'
                      }
                  }],
                  xAxes: [{
                      display: true,
                      ticks: {
                          fontColor: "#3c4099",
                          fontFamily: 'Poppins'
                      }
                  }]
                },
            }
        });
    };
    
    
  </script>
@endsection