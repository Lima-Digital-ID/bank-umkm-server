<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\DataTambahanNasabah;
use \App\Models\Notification;
use \App\Models\Pinjaman;
use \App\Models\KantorCabang;

class DataTambahanNasabahController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List Pengajuan Syarat Pinjaman Modal';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('data-tambahan-peminjam.create');

        try {
            $idCabang = auth()->user()->id_kantor_cabang;

            $keyword = $request->get('keyword');
            if ($keyword) {
                if(auth()->user()->level == 'Administrator') {
                    $dataTambahan = DataTambahanNasabah::with('nasabah')->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('kelengkapan_data', 2)->paginate(10);
                }
                else {
                    $dataTambahan = DataTambahanNasabah::with('nasabah')->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->where('kelengkapan_data', 2)->where('nasabah.id_kantor_cabang', $idCabang)->paginate(10);
                }
            }
            else{
                if(auth()->user()->level == 'Administrator') {
                    // $dataTambahan = DataTambahanNasabah::with('nasabah')->whereHas('nasabah', function ($query) {
                    //     return $query->where('kelengkapan_data', 2);
                    // })->paginate(10);
                    $dataTambahan = DataTambahanNasabah::with('nasabah')->paginate(10);
                }
                else {
                    // $dataTambahan = DataTambahanNasabah::with('nasabah')->whereHas('nasabah', function ($query) {
                    //     return $query->where('kelengkapan_data', 2);
                    // })->where('nasabah.id_kantor_cabang', $idCabang)->paginate(10);
                    $dataTambahan = DataTambahanNasabah::with('nasabah')->where('nasabah.id_kantor_cabang', $idCabang)->paginate(10);
                }
            }
        }
        catch (\Exception $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan'. $e->getMessage());
        }
        catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan pada Database'. $e->getMessage());
        }
        
        // echo "<pre>";
        // print_r ($dataTambahan);
        // echo "</pre>";
        
        return \view('data-tambahan-nasabah.list-pengajuan', ['dataTambahan' => $dataTambahan], $this->param);
    }

    public function create()
    {
        # code...
    }

    public function show($id)
    {
        try{
            $this->param['pageInfo'] = 'Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('data-tambahan-peminjam.index');
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
        // if($request->get('status') == "1") {
        //     $this->validate($request, 
        //         [
        //             'nominal' => 'required',
        //         ],
        //         [
        //             'required' => ':attribute tidak boleh kosong.',
        //         ],
        //         [
        //             'nominal' => 'Nominal'
        //         ]
        //     );
        // }
        try{
            $dataTambahan = DataTambahanNasabah::find($id);
            $nasabah = Nasabah::find($dataTambahan->id_nasabah);

            if($request->status=="1"){
                $nasabah->kelengkapan_data = 1;
                $msg = "Verifikasi Syarat Pinjaman Modal Data berhasil diterima.";
            }
            else if($request->status=="3"){
                $nasabah->kelengkapan_data = 3;
                $msg = "Verifikasi Syarat Pinjaman Modal Data ditolak.";
            }
            $nasabah->save();

            // $kodePinjaman = '';
            // $noPinjaman = '00001';
            // $countPinjaman = Pinjaman::select('kode_pinjaman')->count();
            // $getDate = date('Ymd');

            // if($countPinjaman > 0){
            //     $lastPinjaman = Pinjaman::orderBy('kode_pinjaman', 'desc')->first()->kode_pinjaman;

            //     $lastIncreament = substr($lastPinjaman, 10);

            //     $noPinjaman = str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);

            // }

            // $kodePinjaman = 'PM'.$getDate.$noPinjaman;

            // $date = date('Y-m-d');

            // $newPinmo = new Pinjaman;
            // $newPinmo->kode_pinjaman = $kodePinjaman;
            // $newPinmo->id_nasabah = $nasabah->id;
            // $newPinmo->id_user = auth()->user()->id;
            // $newPinmo->id_jenis_pinjaman = 3;
            // $newPinmo->nominal = $request->get('nominal');
            // $newPinmo->jangka_waktu = $request->get('jangka_waktu');
            // $newPinmo->tanggal_pengajuan = $date;
            // $newPinmo->tanggal_diterima = $date;
            // $newPinmo->jatuh_tempo =  date('Y-m-d', strtotime("+$request->get('jangka_waktu') months", strtotime($date)));
            // $newPinmo->id_kantor_cabang = $nasabah->id_kantor_cabang;

            // $newPinmo->save();

            // $cabang = KantorCabang::where('id', $nasabah->id_kantor_cabang)->get();
            // $kantorCabang = '';
            
            // if(count($cabang) == 0) {
            //     $kantorCabang = 'Harap datang ke kantor terdekat di daerah anda untuk mencairkan dana.';
            // }
            // else {
            //     $kantorCabang = 'Harap datang ke kantor cabang yang sudah tertera untuk mencairkan dana.'.$cabang[0]->alamat.'(Buka setiap Senin-Jumat 08.00-15.00)';
            // }

            $newNotification = new Notification;

            $newNotification->id_nasabah = $dataTambahan->id_nasabah;
            $newNotification->title = "Verifikasi Syarat Pinjaman Modal";
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
