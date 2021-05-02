<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\JenisPinjaman;

class JenisPinjamanController extends Controller
{
    public function index()
    {   
        $status = '';
        $message = '';
        $data = '';
        try {
            $jenisPinjaman = JenisPinjaman::select('id','jenis_pinjaman', 'limit_pinjaman')->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $jenisPinjaman;
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
