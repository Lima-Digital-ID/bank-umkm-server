<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\AsuransiPinjaman;

class AsuransiPinjamanController extends Controller
{
    private $param;

    public function index()
    {
        $this->param['pageInfo'] = 'Jumlah Asuransi Pinjaman';
        try {
            $this->param['asuransiPinjaman'] = AsuransiPinjaman::first();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }

        return view('asuransi.edit-asuransi', $this->param);
    }

    public function update(Request $request, $id)
    {
        try {
            $asuransiPinjaman = AsuransiPinjaman::find($id);
            $asuransiPinjaman->jumlah_asuransi = $request->get('jumlah_asuransi');
            $asuransiPinjaman->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }

        return back()->withStatus('Berhasil di Update.');
    }
}
