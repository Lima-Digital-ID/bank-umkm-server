<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\JenisPinjaman;
use App\Models\Nasabah;
use App\Models\Notification;
use \App\Models\Pelunasan;

class ApiPembayaran extends Controller
{
    public function store(Request $request)
    {
        // proses pembayaran cicilan
        // $validatedData = $request->validate([
        //     'id_pinjaman' => 'required',
        //     'nominal_pembayaran' => 'required',
        // ],
        // [
        //     'required' => ':attribute tidak boleh kosong.',
        // ]);

        $status = '';
        $message = '';
        $hutang = '';
        
        try {
            $pelunasan = Pelunasan::find($request->get('id'));
            $pelunasan->tanggal_pembayaran = date('Y-m-d');
            $pelunasan->metode_pembayaran = $request->get('metode_pembayaran');
            $pelunasan->status = 'Lunas';
            // $pelunasan->save();

            $nasabah = Nasabah::find(auth()->user()->id);
            $hutang = $nasabah->hutang - $request->get('nominal_pembayaran');
            $limitPinjaman = $nasabah->temp_limit;

            // $nasabah->hutang -= $request->get('nominal_pembayaran');
            $nasabah->hutang = $hutang;

            $pinjaman = Pinjaman::find($request->get('id_pinjaman'));
            $terbayar = $pinjaman->terbayar + $request->get('nominal_pembayaran');
            $newNotification = new Notification;
            
            $countLunas = Pelunasan::where('id_pinjaman', $request->get('id_pinjaman'))->where('status', 'Belum')->count();
            // jika variabel countLunas hasilnya adalah 0 maka, pinjaman tersebut sudah lunas
            // if($countLunas == 0) {
            //     $pinjaman->status = 'Lunas';
            //     $pinjaman->tanggal_lunas = date("Y-m-d");

            //     $nasabah->limit_pinjaman = $limitPinjaman;
            //     $nasabah->temp_limit = 0;

            //     $newNotification->id_nasabah = auth()->user()->id;
            //     $newNotification->title = "Pelunasan";
            //     $newNotification->message = "Nasabah ".$nasabah->nama." melakukan pelunasan";
            //     // $newNotification->message = "Nasabah melakukan pembayaran";
            //     $newNotification->jenis = "Pembayaran";
            //     $newNotification->device = "web";
            // }
            // else {
            //     $newNotification->id_nasabah = auth()->user()->id;
            //     $newNotification->title = "Pembayaran";
            //     $newNotification->message = "Nasabah ".$nasabah->nama." melakukan pembayaran";
            //     // $newNotification->message = "Nasabah melakukan pembayaran";
            //     $newNotification->jenis = "Pembayaran";
            //     $newNotification->device = "web";
            // }
            
            if($terbayar > $pinjaman->nominal || $terbayar == $pinjaman->nominal) {
                $pinjaman->status = 'Lunas';
                $pinjaman->tanggal_lunas = date("Y-m-d");

                $nasabah->limit_pinjaman = $limitPinjaman;
                $nasabah->temp_limit = 0;

                $newNotification->id_nasabah = auth()->user()->id;
                $newNotification->title = "Pelunasan";
                $newNotification->message = "Nasabah ".$nasabah->nama." melakukan pelunasan";
                // $newNotification->message = "Nasabah melakukan pembayaran";
                $newNotification->jenis = "Pembayaran";
                $newNotification->device = "web";
            }
            else {
                $newNotification->id_nasabah = auth()->user()->id;
                $newNotification->title = "Pembayaran";
                $newNotification->message = "Nasabah ".$nasabah->nama." melakukan pembayaran";
                // $newNotification->message = "Nasabah melakukan pembayaran";
                $newNotification->jenis = "Pembayaran";
                $newNotification->device = "web";
            }
            
            $pelunasan->save();
            
            $nasabah->save();
            
            $pinjaman->terbayar = $terbayar;

            $pinjaman->save();

            $newNotification->save();


            $status = 'success';
            $message = 'pembayaran berhasil.';
        } catch(\Exception $e){
            $status = 'failed';
            $message = 'pembayaran gagal. ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'pembayaran gagal. ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'hutang' => $hutang
            ]);
        }

    }

    public function getCicilan($id_pinjaman)
    {
        $status = '';
        $message = '';
        $data = '';

        try {
            $cicilan = Pelunasan::where('id_pinjaman', $id_pinjaman)->get();
            
            $data = $cicilan;

            $status = 'success';
            $message = 'berhasil.';
        } catch(\Exception $e){
            $status = 'failed';
            $message = 'gagal. ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'gagal. ' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]);
        }

    }
}