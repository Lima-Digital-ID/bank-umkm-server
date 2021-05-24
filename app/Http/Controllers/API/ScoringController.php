<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\KategoriKriteria;
use \App\Models\Kriteria;
use \App\Models\Option;
use \App\Models\Scoring;
use Illuminate\Support\Facades\DB;

class ScoringController extends Controller
{
    public function getKategoriKriteria(Request $request)
    {
        

        try {
            $kategori = KategoriKriteria::with('kriteria', 'kriteria.option')->get();
            
            $status = 'success';
            $message = 'Berhasil';
            $data = $kategori;
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

    public function processScoring(Request $request)
    {
        // $data = $request->getContent();

        
        // return $data['data'][0]['skor'];
        // return $totalSkor ;
        try {
            $data = json_encode($request->json()->all());
            $data = json_decode($data, true);
            $totalSkor = array_sum(array_column($data['data'],'skor'));

            foreach ($data['data'] as $key => $value) {
                DB::table('scoring')->insert([
                    'id_option' => $value['id_option'],
                    'id_nasabah' => auth()->user()->id
                ]);
            }

            DB::table('nasabah')
                ->where('id', auth()->user()->id)
                ->update([
                        'skor' => $totalSkor,
                        'limit_pinjaman' => $totalSkor / 100 * 1500000,
                        ]);

            $status = 'success';
            $message = 'Berhasil';
            // $data = $kategori;
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
