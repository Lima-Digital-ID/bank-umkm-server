<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\JenisPinjaman;
use App\Models\MasterBank;

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
            'nominal' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);

        $status = '';
        $message = '';

        try {
            $newPinjaman = new Pinjaman;
            $newPinjaman->id_nasabah = auth()->user()->id;
            $newPinjaman->id_jenis_pinjaman = $request->get('id_jenis_pinjaman');
            $newPinjaman->jangka_waktu = $request->get('jangka_waktu');
            $newPinjaman->nominal = 0;
            $newPinjaman->tanggal_pengajuan = date('Y-m-d');
            $newPinjaman->alasan_penolakan = '-';
            $newPinjaman->status = 'Pending';

            $newPinjaman->save();

            $status = 'success';
            $message = 'Pengajuan pinjaman berhasil.';

            $nasabah = Nasabah::select('nama')->find(auth()->user()->id);

            $newNotification = new Notification;

            $newNotification->id_nasabah = auth()->user()->id;
            $newNotification->title = "Pengajuan Pinjaman";
            $newNotification->message = "Nasabah ".$nasabah->nama." mengajukan pinjaman baru";
            $newNotification->jenis = "Pinjaman";
            $newNotification->device = "web";

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
                'message' => $message
            ]);
        }
    }

    public function getPinjamanByNasabah()
    {   
        try {
            $idNasabah = auth()->user()->id;
            // $pinjamanByNasabah = Pinjaman::with('jenisPinjaman', 'pelunasan', 'nasabah')->where('id_nasabah', $idNasabah)->get();
            $pinjamanByNasabah = Pinjaman::where('id_nasabah', $idNasabah)->get();
            
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
            $detailPinjaman = Pinjaman::with('jenisPinjaman', 'pelunasan', 'nasabah')->where('id', $id)->get();

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
