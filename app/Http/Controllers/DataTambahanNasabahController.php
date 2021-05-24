<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\DataTambahanNasabah;

class DataTambahanNasabahController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List Pengajuan Data Tambahan Nasabah';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('data-tambahan-nasabah.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $dataTambahan = DataTambahanNasabah::with('nasabah')->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('kelengkapan_data', 2)->paginate(10);
            }
            else{
                $dataTambahan = DataTambahanNasabah::with('nasabah')->whereHas('nasabah', function ($query) {
                    return $query->where('kelengkapan_data', 2);
                })->paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan'. $e->getMessage());
        }
        
        // echo "<pre>";
        // print_r ($dataTambahan);
        // echo "</pre>";
        
        return \view('data-tambahan-nasabah.list-pengajuan', ['dataTambahan' => $dataTambahan], $this->param);
    }

    public function show($id)
    {
        try{
            $this->param['pageInfo'] = 'Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('data-tambahan-nasabah.index');
            $this->param['dataTambahan'] = DataTambahanNasabah::with('nasabah')->find($id);

            return \view('data-tambahan-nasabah.detail-data-tambahan-nasabah', $this->param);
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
            $dataTambahan = DataTambahanNasabah::find($id);
            $nasabah = Nasabah::find($dataTambahan->id_nasabah);

            if($request->status=="1"){
                $nasabah->kelengkapan_data = 1;
                $msg = "Kelengkapan data berhasil di ACC";
            }
            else if($request->status=="3"){
                $nasabah->kelengkapan_data = 3;
                $msg = "Kelengkapan data ditolak";
            }
            $nasabah->save();

            $newNotification = new Notification;

            $newNotification->id_nasabah = $dataTambahan->id_nasabah;
            $newNotification->title = "Verifikasi Kelengkapan Data";
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
