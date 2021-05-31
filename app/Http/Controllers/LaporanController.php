<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\Pelunasan;
use \App\Models\Nasabah;

class LaporanController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Laporan Transaksi';

        try {
            $dari = $request->get('dari');
            $sampai = $request->get('sampai');
            $nasabah = $request->get('nasabah');
            $this->param['laporan'] = '';

            $this->param['allNasabah'] = Nasabah::select('id', 'nama', 'nik')->get();

            if ($dari && $sampai) {
                $getLaporan = Pinjaman::with('nasabah', 'pelunasan')->whereBetween('tanggal_diterima', [$dari, $sampai])->whereIn('pinjaman.status', ['Terima', 'Lunas'])->where('pinjaman.status_pencairan', 'Terima');

                if ($nasabah) {
                    $getLaporan->where('id_nasabah', $nasabah);
                }
    
                $this->param['laporan'] = $getLaporan->get();
                $this->param['dari'] = $dari;
                $this->param['sampai'] = $sampai;
            }


        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch (\Exception $e) {
            return redirect()->back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }

        return \view('laporan.laporan', $this->param);
    }
}
