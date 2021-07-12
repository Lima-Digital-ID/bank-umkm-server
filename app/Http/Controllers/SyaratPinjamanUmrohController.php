<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\SyaratPinjamanUmroh;
use \App\Models\Notification;

class SyaratPinjamanUmrohController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List Pengajuan Syarat Pinjaman Umroh';
        $this->param['btnRight']['text'] = 'Tambah Data';

        try {
            $idCabang = auth()->user()->id_kantor_cabang;

            $keyword = $request->get('keyword');
            if ($keyword) {
                if(auth()->user()->level == 'Administrator') {
                    // $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->whereHas('nasabah', function ($query) {
                    //     return $query->where('syarat_pinjaman_umroh', 2);
                    // })->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('syarat_pinjaman_umroh', 2)->paginate(10);
                    $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('syarat_pinjaman_umroh', 2)->orderBy('nasabah.syarat_pinjaman_umroh', 'ASC')->paginate(10);
                }
                else {
                    // $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->whereHas('nasabah', function ($query) {
                    //     return $query->where('syarat_pinjaman_umroh', 2);
                    // })->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('syarat_pinjaman_umroh', 2)->where('nasabah.id_kantor_cabang', $idCabang)->paginate(10);
                    $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->whereHas('nasabah', function ($query) {
                        return $query->where('syarat_pinjaman_umroh', 2);
                    })->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('syarat_pinjaman_umroh', 2)->where('nasabah.id_kantor_cabang', $idCabang)->orderBy('nasabah.syarat_pinjaman_umroh', 'ASC')->paginate(10);
                }
            }
            else{
                if(auth()->user()->level == 'Administrator') {
                    // $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->whereHas('nasabah', function ($query) {
                    //     return $query->where('syarat_pinjaman_umroh', 2);
                    // })->paginate(10);
                    $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->orderBy('nasabah.syarat_pinjaman_umroh', 'ASC')->paginate(10);
                }
                else {
                    $syaratPinjamanUmroh = SyaratPinjamanUmroh::with('nasabah')->where('nasabah.id_kantor_cabang', $idCabang)->orderBy('nasabah.syarat_pinjaman_umroh', 'ASC')->paginate(10);
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan'. $e->getMessage());
        }
        
        // echo "<pre>";
        // print_r ($syaratPinjamanUmroh);
        // echo "</pre>";
        
        return \view('syarat-pinjaman-umroh.list-pengajuan', ['syaratPinjamanUmroh' => $syaratPinjamanUmroh], $this->param);
    }

    public function show($id)
    {
        try{
            $this->param['pageInfo'] = 'Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('syarat-pinjaman-umroh.index');
            $this->param['syaratPinjamanUmroh'] = SyaratPinjamanUmroh::with('nasabah')->find($id);

            return \view('syarat-pinjaman-umroh.detail-syarat-pinjaman-umroh', $this->param);
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try{
            $syaratPinjamanUmroh = SyaratPinjamanUmroh::find($id);
            $nasabah = Nasabah::find($syaratPinjamanUmroh->id_nasabah);

            if($request->status=="1"){
                $nasabah->syarat_pinjaman_umroh = 1;
                $msg = "Verifikasi Syarat Pinjaman Umroh/Haji berhasil diterima.";
            }
            else if($request->status=="3"){
                $nasabah->syarat_pinjaman_umroh = 3;
                $msg = "Verifikasi Syarat Pinjaman Umroh/Haji ditolak.";
            }
            $nasabah->save();

            $newNotification = new Notification;

            $newNotification->id_nasabah = $syaratPinjamanUmroh->id_nasabah;
            $newNotification->title = "Verifikasi Syarat Pinjaman Pinjaman Umroh/Haji";
            $newNotification->message = $msg;
            $newNotification->jenis = "Verifikasi";
            $newNotification->device = "mobile";

            $newNotification->save();

            return back()->withStatus('Status Berhasil Diperbarui');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }
}
