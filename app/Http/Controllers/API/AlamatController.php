<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WilayahKabupaten;
use App\Models\WilayahKecamatan;
use App\Models\WilayahProvinsi;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function getProvinsi()
    {
        $status = '';
        $message = '';
        $data = '';

        try {
            $listProvinsi = WilayahProvinsi::all();
            
            $data = $listProvinsi;

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

    public function getKabupaten($id_provinsi)
    {
        $status = '';
        $message = '';
        $data = '';

        try {
            $listKab = WilayahKabupaten::where('provinsi_id', $id_provinsi)->get();
            
            $data = $listKab;

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

    public function getKecamatan($id_kabupaten)
    {
        $status = '';
        $message = '';
        $data = '';

        try {
            $listKec = WilayahKecamatan::where('kabupaten_id', $id_kabupaten)->get();
            
            $data = $listKec;

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
