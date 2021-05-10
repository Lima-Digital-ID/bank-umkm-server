<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pinjaman;

class ChartLaporanController extends Controller
{
    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Chart';
        try {
            $dari = $request->get('dari');
            $sampai = $request->get('sampai');

            $year = date('Y');

            $getRekapHarian = Pinjaman::select(\DB::raw('SUM(nominal) as nominal'), 'tanggal_diterima')->groupBy('tanggal_diterima')->whereBetween('tanggal_diterima', [$dari, $sampai])->get();

            $rekapBulanan = Pinjaman::select(\DB::raw('YEAR(tanggal_diterima) as tahun'), \DB::raw('MONTH(tanggal_diterima) as bulan'), \DB::raw('SUM(nominal) as nominal'))->groupBy(\DB::raw('YEAR(tanggal_diterima)'), \DB::raw('MONTH(tanggal_diterima)'))->where(\DB::raw('YEAR(tanggal_diterima)'), $year)->get();
            
            $tanggal = [];
            $pinjamanHarian = [];
            
            foreach ($getRekapHarian as $key => $value) {
                array_push($tanggal, date('d-m-Y', strtotime($value->tanggal_diterima)));
                array_push($pinjamanHarian, $value->nominal);
            }
            
            $periode = [];
            $nominalPinjaman = [];

            foreach ($rekapBulanan as $key => $value) {
                array_push($periode, $value->bulan . '-' . $value->tahun);
                array_push($nominalPinjaman, $value->nominal);
            }
        } catch (\Exception $e) {
            return back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }
        
        return view('laporan.chart', $this->param)
                ->with('periode',json_encode($periode))
                ->with('nominal',json_encode($nominalPinjaman))
                ->with('tanggal',json_encode($tanggal))
                ->with('nominalPinjamanHarian',json_encode($pinjamanHarian));
    }
}
