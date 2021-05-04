<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Nasabah;
class NasabahController extends Controller
{
    public function index()
    {
        $allNasabah = Nasabah::get();

        return response()->json([
            'data' => $allNasabah
        ]);
    }

    public function getHutangPerNasabah(Request $request)
    {
        
    }
    
    public function getSaldoAndHutangPerNasabah()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            
            $saldo = Nasabah::select('saldo', 'hutang')->find(auth()->user()->id);

            $status = 'success';
            $message = 'Berhasil';
            $data = $saldo;
        }catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal. ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal. ' . $e->getMessage();
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
