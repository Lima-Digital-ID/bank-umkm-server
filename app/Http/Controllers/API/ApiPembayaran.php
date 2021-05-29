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
            $newPembayaran = new Pelunasan; 
            $newPembayaran->id_pinjaman = $request->get('id_pinjaman');
            $newPembayaran->nominal_pembayaran = $request->get('nominal_pembayaran');
            $newPembayaran->metode_pembayaran = $request->get('metode_pembayaran');
            $newPembayaran->tanggal_pembayaran = date("Y-m-d");
            $getCicilan = Pelunasan::select('cicilan_ke')->where('id_pinjaman',$request->get('id_pinjaman'))->orderBy('cicilan_ke','desc')->get();
            $newPembayaran->cicilan_ke = count($getCicilan) > 0 ? $getCicilan[0]->cicilan_ke + 1 : 1;

            $newPembayaran->save();

            $nasabah = Nasabah::find(auth()->user()->id);
            $hutang = $nasabah->hutang - $request->get('nominal_pembayaran');

            // $nasabah->hutang -= $request->get('nominal_pembayaran');
            $nasabah->hutang = $hutang;
            $nasabah->save();

            $pinjaman = Pinjaman::find($request->get('id_pinjaman'));
            $terbayar = $pinjaman->terbayar + $request->get('nominal_pembayaran');
            $newNotification = new Notification;

            if($terbayar == $pinjaman->nominal) {
                $pinjaman->status = 'Lunas';
                $pinjaman->tanggal_lunas = date("Y-m-d");

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
            $statusCicilan = Pelunasan::where('id_pinjaman', $id_pinjaman)->get();
            
            $data = count($statusCicilan);

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