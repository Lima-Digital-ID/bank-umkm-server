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
                        User Perlu Diverifikasi
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-clock fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('nasabah?verified=2')}}">Lihat Detail</a>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-3 mb-4">
        <div class="card card-dashboard py-2">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-8 pr-0">
                        <h2 class="color-primary font-weight-bold">{{$nasabahVerified}}</h2>
                        Nasabah Aktif
                    </div>
                    <div class="col-md-4 pl-0 text-center">
                        <span class="fas fa-fw fa-user-check fa-4x"></span>
                    </div>
                </div>
                <hr>
                <a href="{{url('nasabah')}}">Lihat Detail</a>
            </div>
        </div>
    </div> --}}
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
                <a href="{{url('pinjaman?t=Pending')}}">Lihat Detail</a>
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
                <a href="{{url('pinjaman?t=Terima')}}">Lihat Detail</a>
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
    var tanggal = <?php echo $tanggal; ?>;
    var nominalPinjamanHarian = <?php echo $nominalPinjamanHarian; ?>;
    var chartBulanIni = {
        labels: tanggal,
        datasets: [{
            label: 'Nominal Pinjaman Harian',
            backgroundColor: "transparent",
            data: nominalPinjamanHarian,
            borderColor: '#3c4099',
            pointBackgroundColor: '#3c4099',
            // tension: 1,
            bezierCurve: true
        }]
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
                  text: 'Rekap Jumlah Pinjaman Bulan Ini',
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