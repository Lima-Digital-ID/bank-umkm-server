<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
  .center {
    text-align: center;
  }
  .right {
    text-align: right;
  }
</style>
<body>
  <table width="100%" cellspacing="0" cellpadding="5" border="1px">
    <thead>
      <tr style="color: #ffffff;background-color: #3c4099;">
          <td class="center">NO</td>
          <td class="center">Peminjam</td>
          <td class="center">Tanggal Pinjaman</td>
          <td class="center">Jangka Waktu</td>
          <td class="center">Jatuh Tempo</td>
          <td class="center">Jumlah Pinjaman</td>
          <td class="center">Terbayar</td>
          <td class="center">Status</td>
      </tr>
    </thead>
    <tbody>
      @php
          $totalPinjaman = 0;
          $totalPelunasan = 0;
      @endphp
      @foreach ($laporan as $value)
        @php
          $totalPinjaman += $value->nominal;
          $totalPelunasan += $value->terbayar;
        @endphp
        <tr>
          <td class="center">{{$loop->iteration}}</td>
          <td class="center">{{$value->nasabah->nama}}</td>
          <td class="center">{{date('d-m-Y', strtotime($value->tanggal_diterima))}}</td>
          <td class="center">{{$value->jangka_waktu}} bulan</td>
          <td class="center">{{date('d-m-Y', strtotime($value->jatuh_tempo))}}</td>
          <td class="right">Rp.{{number_format($value->nominal, 2, ',', '.')}}</td>
          <td class="right">Rp.{{number_format($value->terbayar, 2, ',', '.')}}</td>
          <td class="center"><span>{{$value->status == 'Lunas' ? 'Lunas' : 'Berjalan'}}</span></td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr style="color: #ffffff;background-color: #2a2e7a;">
        <th colspan="5" class="center">Total</th>
        <th class="right">Rp.{{number_format($totalPinjaman, 2, ',', '.')}}</th>
        <th class="right">Rp.{{number_format($totalPelunasan, 2, ',', '.')}}</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
@php
    $name = 'Laporan Transaksi ' . date('d-m-Y', strtotime($_GET['dari'])).' s/d '.date('d-m-Y', strtotime($_GET['sampai'])).'.xls';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$name");
@endphp