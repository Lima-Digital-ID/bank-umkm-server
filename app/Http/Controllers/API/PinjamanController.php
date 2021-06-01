<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\JenisPinjaman;
use App\Models\MasterBank;
use App\Models\Notification;
use App\Models\Nasabah;

class PinjamanController extends Controller
{
    // public function index()
    // {
    //     try {
    //         $jenisPinjaman = JenisPinjaman::select('id','jenis_pinjaman', 'limit_pinjaman')->get();
    //         return response()->json([
    //             'success' => true,
    //             'data' => $jenisPinjaman
    //         ], 200);
    //     } catch(\Exception $e){
    //         return response()->json([
    //             'error' => true,
    //             'message' => 'Terjadi kesalahan.' . $e->getMessage()
    //         ], 500);
    //     }
    //     catch(\Illuminate\Database\QueryException $e){
    //         return response()->json([
    //             'error' => true,
    //             'message' => 'Terjadi kesalahan.'. $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_jenis_pinjaman' => 'required',
            'jangka_waktu' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);

        $status = '';
        $message = '';
        $idPinjaman = '';

        try {

            if (auth()->user()->skor < 60) {
                $notifTitle = 'Pengajuan Pinjaman Gagal.';
                $notifMessage = 'Maaf pengajuan pinjaman anda gagal, anda belum memenuhi syarat untuk mengajukan pinjaman cepat.';

                $status = 'failed';
                $message = 'Maaf anda belum memenuhi syarat untuk mengajukan pinjaman cepat.';
            }
            else{                
                $kodePinjaman = '';
                $noPinjaman = '00001';
                $countPinjaman = Pinjaman::select('kode_pinjaman')->count();
                $getDate = date('Ymd');

                if($countPinjaman > 0){
                    $lastPinjaman = Pinjaman::orderBy('kode_pinjaman', 'desc')->first()->kode_pinjaman;
    
                    $lastIncreament = substr($lastPinjaman, 10);
    
                    $noPinjaman = str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);
    
                }

                $kodePinjaman = 'PC'.$getDate.$noPinjaman;

                $newPinjaman = new Pinjaman;
                $newPinjaman->id_nasabah = auth()->user()->id;
                $newPinjaman->kode_pinjaman = $kodePinjaman;
                $newPinjaman->id_jenis_pinjaman = $request->get('id_jenis_pinjaman');
                $newPinjaman->jangka_waktu = $request->get('jangka_waktu');
                $newPinjaman->nominal = auth()->user()->limit_pinjaman;
                $newPinjaman->tanggal_pengajuan = date('Y-m-d');
                $newPinjaman->alasan_penolakan = '-';
                if (auth()->user()->skor >= 80) {
                    $newPinjaman->status = 'Terima';
                    $date = date('Y-m-d');
                    $newPinjaman->tanggal_diterima = $date;
                    // $newPinjaman->id_user = auth()->user()->id;
                    $newPinjaman->jatuh_tempo =  date('Y-m-d', strtotime("+$newPinjaman->jangka_waktu months", strtotime($date)));

                    $notifTitle = 'Pengajuan Pinjaman Berhasil.';
                    $notifMessage = 'Selamat pengajuan pinjaman anda berhasil, silahkan datang ke kantor cabang terdekat untuk pencairan pinjaman.';
                }
                elseif (auth()->user()->skor < 80) {
                    $newPinjaman->status = 'Pending';

                    $notifTitle = 'Pengajuan Pinjaman Berhasil.';
                    $notifMessage = 'Selamat pengajuan pinjaman anda berhasil, mohon menunggu persetujuan dari admin.';
                }
    
                $newPinjaman->save();
                $idPinjaman = $newPinjaman->id;

                if (auth()->user()->skor >= 80) {
                    $nasabah = Nasabah::find(auth()->user()->id);
                    $hutang = $nasabah->hutang + $nasabah->limit_pinjaman;
                    // $nasabah->hutang -= $request->get('nominal_pembayaran');
                    $nasabah->hutang = $hutang;
                    $nasabah->limit_pinjaman = 0;
                    $nasabah->save();
                }
    
                $status = 'success';
                $message = 'Pengajuan pinjaman berhasil.';
            }

            $nasabah = Nasabah::select('nama')->find(auth()->user()->id);

            $newNotification = new Notification;

            $newNotification->id_nasabah = auth()->user()->id;
            $newNotification->title = $notifTitle;
            $newNotification->message = $notifMessage;
            $newNotification->jenis = "Pinjaman";
            $newNotification->device = "mobile";

            $newNotification->save();

        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Pengajuan pinjaman gagal ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Pengajuan pinjaman gagal ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $idPinjaman
            ]);
        }
    }

    public function getPinjamanByNasabah()
    {   
        try {
            $idNasabah = auth()->user()->id;
            // $pinjamanByNasabah = Pinjaman::with('jenisPinjaman', 'pelunasan', 'nasabah')->where('id_nasabah', $idNasabah)->get();
            $pinjamanByNasabah = Pinjaman::where('id_nasabah', $idNasabah)->where('status', 'Terima')->where('status_pencairan', 'Terima')->get();
            
            $status = 'success';
            $message = 'Berhasil';
            $data = $pinjamanByNasabah;
        }catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], 200);
        }
    }

    public function getPinjamanPendingByNasabah()
    {   
        try {
            $idNasabah = auth()->user()->id;
            // $pinjamanByNasabah = Pinjaman::with('jenisPinjaman', 'pelunasan', 'nasabah')->where('id_nasabah', $idNasabah)->get();
            // $pinjamanByNasabah = Pinjaman::where('id_nasabah', $idNasabah)
            // ->where('status', 'Pending')
            // ->orWhere('status', 'Terima')
            // ->where('status_pencairan', 'Pending')->get();
            $pinjamanByNasabah = Pinjaman::where('id_nasabah', $idNasabah)->orderBy('created_at', 'DESC')->get();
            
            $status = 'success';
            $message = 'Berhasil';
            $data = $pinjamanByNasabah;
        }catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], 200);
        }
    }

    public function show($id)
    {   
        $status = '';
        $message = '';
        $data = '';
        try {
            $detailPinjaman = Pinjaman::
            with('jenisPinjaman', 'pelunasan', 'nasabah')
            // ->select(
            //     'master_bank.nama_bank'
            // )
            ->join('informasi_bank', 'informasi_bank.id_nasabah', 'pinjaman.id_nasabah')
            ->join('master_bank', 'informasi_bank.id_bank', 'master_bank.id')
            ->where('pinjaman.id', $id)
            ->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $detailPinjaman;
        }catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], 200);
        }
    }

    public function getBank()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $getBank = MasterBank::get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $getBank;
        }catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], 200);
        }
    }
}
