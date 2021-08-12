<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\KategoriKriteria;
use \App\Models\Kriteria;
use \App\Models\Option;
use \App\Models\Scoring;
use \App\Models\Nasabah;
use Illuminate\Support\Facades\DB;

class ScoringController extends Controller
{
    public function getKategoriKriteria(Request $request)
    {
        $status = '';
        $message = '';
        $data = null;

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
            $nasabah = Nasabah::find(auth()->user()->id);
            
            $data = json_encode($request->json()->all());
            $data = json_decode($data, true);
            // return $data['data'];
            $totalSkor = 0;
            $jenisKelamin = '';
            if($nasabah->skor > 0) {
                // jika sudah pernah skoring
                // $deleteSkor = Scoring::where('id_nasabah', auth()->user()->id);
                // $deleteSkor->destroy();
                $id_nasabah = auth()->user()->id;
                $deleteSkor = DB::unprepared("DELETE FROM scoring WHERE id_nasabah = $id_nasabah");
                if($deleteSkor) {
                     for($i=0; $i<count($data['score']); $i++){
                        $totalSkor += $data['score'][$i];
                        $newScore = new Scoring;
                        $newScore->id_option = $data['data'][$i];
                        $newScore->id_nasabah = auth()->user()->id;
                        
                        $newScore->save();

                        if($data['data'][$i] == 1) {
                            // jenis kelamin laki-laki
                            $jenisKelamin = 'Laki-laki';
                        }

                        if($data['data'][$i] == 2) {
                            // jenis kelamin perempuan
                            $jenisKelamin = 'Perempuan';
                        }

                        // $editScore = Scoring::find(auth()->user()->id);
                        // $editScore->id_option = $data['data'][$i];
                        // $editScore->id_nasabah = auth()->user()->id;
                        // $editScore->updated_at = time();
                        
                        // $editScore->save();
        
                        // DB::table('scoring')->insert([
                        //     'id_option' => $data['data'][$i],
                        //     'id_nasabah' => auth()->user()->id,
                        // ]);
                    }   
                }
            }
            else {
                // jika belum pernah skoring
                for($i=0; $i<count($data['score']); $i++){
                    $totalSkor += $data['score'][$i];
                    $newScore = new Scoring;
                    $newScore->id_option = $data['data'][$i];
                    $newScore->id_nasabah = auth()->user()->id;
                    
                    $newScore->save();
    
                    if($data['data'][$i] == 1) {
                        // jenis kelamin laki-laki
                        $jenisKelamin = 'Laki-laki';
                    }

                    if($data['data'][$i] == 2) {
                        // jenis kelamin perempuan
                        $jenisKelamin = 'Perempuan';
                    }
                    // DB::table('scoring')->insert([
                    //     'id_option' => $data['data'][$i],
                    //     'id_nasabah' => auth()->user()->id,
                    // ]);
                }    
            }

            DB::table('nasabah')
                ->where('id', auth()->user()->id)
                ->update([
                        'skor' => $totalSkor,
                        'limit_pinjaman' => $totalSkor / 100 * 1500000,
                        'jenis_kelamin' => $jenisKelamin,
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
            ], 200);
        }
    }

    public function getOptionByKriteria($id)
    {
        $status = 'success';
        $message = 'Berhasil';
        $data = '';
        try {
            $option = Option::where('id_kriteria', $id)->get();
            
            $status = 'success';
            $message = 'Berhasil';
            $data = $option;
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

    public function getScoringPerNasahabah()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $detailPinjaman = Scoring::with('option')->where('id_nasabah', auth()->user()->id)->get();

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
}
