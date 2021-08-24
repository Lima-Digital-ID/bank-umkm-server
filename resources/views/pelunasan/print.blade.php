<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Pelunasan</title>
  </head>
  <body onload="printStruk();">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <img src=" {{asset('img/icon.jpg')}} " alt="" width="70px" class="mb-2">
                <address>
                    Jl. Ciliwung No.11, Darmo, Kec. Wonokromo, Kota SBY, Jawa Timur 60241
                    <br>
                    (031) 5677844
                </address>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td>
                                    Kode Pelunasan
                                </td>
                                <td>
                                    : {{$pelunasan->kode_pelunasan}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nama Nasabah
                                </td>
                                <td>
                                    : {{$nasabah->nama}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nominal Pembayaran
                                </td>
                                <td>
                                    : Rp {{number_format($pelunasan->nominal_pembayaran, 2, ',', '.')}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nama Admin
                                </td>
                                <td>
                                    : {{$pelunasan->nama}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tanggal Pembayaran:
                                </td>
                                <td>
                                    : {{$pelunasan->tanggal_pembayaran}}
                                </td>
                            </tr>
                        </table>
                        <br> <br>
                        <b>Terima kasih</b>
                        <p>
                            Mohon disimpan, struk ini adalah bukti pembayaran yang sah
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->

    <script>
        function printStruk() {
            window.print();
        }
    </script>

  </body>
</html>