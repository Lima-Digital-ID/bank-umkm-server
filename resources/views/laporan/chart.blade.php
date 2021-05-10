@extends('template')
@section('container')
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <canvas id="rekapBulanan"></canvas>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <canvas id="rekapHarian"></canvas>
              </div>
            </div>
          </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <script>
          var periode = <?php echo $periode; ?>;
          var nominal = <?php echo $nominal; ?>;
          var chartRekapBulananData = {
              labels: periode,
              datasets: [{
                  label: 'Nominal',
                  backgroundColor: "transparent",
                  data: nominal,
                  borderColor: '#3c4099',
                  pointBackgroundColor: '#3c4099',
                  // tension: 0,
                  bezierCurve: true
              }]
          };

          var tanggal = <?php echo $tanggal; ?>;
          var nominalPinjamanHarian = <?php echo $nominalPinjamanHarian; ?>;
          var chartHarian = {
              labels: tanggal,
              datasets: [{
                  label: 'Nominal Pinjaman Harian',
                  backgroundColor: "transparent",
                  data: nominalPinjamanHarian,
                  borderColor: '#3c4099',
                  pointBackgroundColor: '#3c4099',
                  // tension: 0,
                  bezierCurve: true
              }]
          };
      
          window.onload = function() {

              var ctx = document.getElementById("rekapBulanan").getContext("2d");
              window.myBar = new Chart(ctx, {
                  type: 'line',
                  data: chartRekapBulananData,
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
                        text: 'Rekap Jumlah Pinjaman Bulanan',
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

              var crh = document.getElementById("rekapHarian").getContext("2d");
              window.myBar = new Chart(crh, {
                  type: 'line',
                  data: chartHarian,
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
                        text: 'Rekap Jumlah Pinjaman Harian',
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
