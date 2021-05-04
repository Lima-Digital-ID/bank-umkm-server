<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\JenisPinjaman;
use \App\Models\Pelunasan;

class ApiPembayaran extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pinjaman' => 'required',
            'nominal_pembayaran' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);

        $status = '';
        $message = '';

        
        try {
            $newPembayaran = new Pelunasan; 
            $newPembayaran->id_pinjaman = $request->get('id_pinjaman');
            $newPembayaran->nominal_pembayaran = $request->get('nominal_pembayaran');
            $newPembayaran->metode_pembayaran = $request->get('metode_pembayaran');
            $newPembayaran->tanggal_pembayaran = date("Y-m-d");
            $getCicilan = Pelunasan::select('cicilan_ke')->where('id_pinjaman',$request->get('id_pinjaman'))->orderBy('cicilan_ke','desc')->get();
            $newPembayaran->cicilan_ke = count($getCicilan) > 0 ? $getCicilan[0]->cicilan_ke + 1 : 1;

            $newPembayaran->save();

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
                'message' => $message
            ]);
        }

    }

    public function getStatusCicilan($id_pinjaman, $cicilan_ke)
    {
        $status = '';
        $message = '';
        $data = null;

        try {
            $statusCicilan = Pelunasan::where('id_pinjaman', $id_pinjaman)->where('cicilan_ke', $cicilan_ke)->get();
            
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