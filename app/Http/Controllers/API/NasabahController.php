<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataTambahanNasabah;
use Illuminate\Http\Request;
use \App\Models\Nasabah;
use App\Models\SyaratPinjamanUmroh;
use App\Models\Notification;
use App\Models\WilayahKecamatan;

class NasabahController extends Controller
{
    public function index()
    {
        $allNasabah = Nasabah::get();

        return response()->json([
            'data' => $allNasabah
        ]);
    }

    public function getNasabahById()
    {
        $status = '';
        $message = '';
        $token = '';
        $nasabah = '';
        $id_nasabah = auth()->user()->id;
        try {
            $nasabah = Nasabah::find($id_nasabah);
            if($nasabah == null) {
                $status = 'failed';
                $message = 'Akun tidak ditemukan';
                // $nasabah = '';
            }
            else {
                $status = 'success';
                $message = 'Berhasil';
            }


        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'success';
            $message = 'Gagal' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $nasabah,
                'token' => $token
            ], 200);
        }
    }

    public function updateProfile(Request $request)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $id = auth()->user()->id;
            $nasabah = Nasabah::find($id);
            
            $nasabah->nama = $request->get('nama');
            $nasabah->tanggal_lahir = $request->get('tgl_lahir');
            $nasabah->tempat_lahir = $request->get('tempat_lahir');
            $nasabah->alamat = $request->get('alamat');
            $nasabah->updated_at = time();

            $nasabah->save();
            
            if($nasabah->save()) {
                $status = 'success';
                $message = 'Berhasil';
                $data = $nasabah->id;
            }
            else {
                $status = 'failed';
                $message = 'Gagal merubah data';
                $data = $nasabah->id;
            }

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

    public function deletePhoto()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $id = auth()->user()->id;
            $nasabah = Nasabah::find($id);
            $nik = $nasabah->nik;

            $path = 'upload/nasabah/'.$nik.'/profile'.'/';

            $file = $nasabah->foto_profil; // added reference to filename

            $nasabah->foto_profil = NULL;
            $nasabah->updated_at = time();
            $nasabah->save();
            
            if($nasabah->save()) {
                // If the file in existing directory already exist, delete it
                if (file_exists($file)) {
                    if(unlink($file)) {
                        $status = 'success';
                        $message = 'Berhasil';
                        $data = $nasabah->id;
                    }
                    else {
                        $status = 'failed';
                        $message = 'Gagal menghapus foto profil';
                        $data = $nasabah->id;
                    }
                }
            }

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

    public function updatePhoto(Request $request)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $id = auth()->user()->id;
            $nasabah = Nasabah::find($id);
            $nik = $nasabah->nik;

            $path_delete = 'upload/nasabah/'.$nik.'/profile'.'/';

            $file_delete = $nasabah->foto_profil;

            // $folder = 'upload/nasabah/'.$nik;
            $folder = 'upload/nasabah/'.$nik.'/profile';
            // Get canonicalized absolute pathname
            $path = realpath($folder);
            // If it exist, check if it's a directory
            if(!($path !== true AND is_dir($path)))
            {
                // Path/folder does not exist then create a new folder
                mkdir($folder);
            }

            // upload new profile
            if($request->get('foto_profil') != null || $request->get('foto_profil_filename') != ''){
                if ($file_delete != null) {
                    if(unlink($file_delete)) {
                        $extension = explode('.', $request->get('foto_profil_filename'));
                        $ext = end($extension);
                        $filename = $folder.'/'.date('YmdHis').$id.'_foto_profil.'.$ext;
                        $img = base64_decode($request->get('foto_profil'));
                        file_put_contents($filename, $img);
                        $nasabah->foto_profil = $filename;
                        $nasabah->updated_at = time();
                    }
                }
                else {
                    $extension = explode('.', $request->get('foto_profil_filename'));
                    $ext = end($extension);
                    $filename = $folder.'/'.date('YmdHis').$id.'_foto_profil.'.$ext;
                    $img = base64_decode($request->get('foto_profil'));
                    file_put_contents($filename, $img);
                    $nasabah->foto_profil = $filename;
                    $nasabah->updated_at = time();
                }
            }
            
            if($nasabah->save()) {
                $status = 'success';
                $message = 'Berhasil';
                $data = $nasabah->foto_profil;
            }
            else {
                $status = 'failed';
                $message = 'Gagal memperbarui foto profil';
                $data = $nasabah->foto_profil;
            }

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

    public function getVerifData()
    {
        $status = '';
        $message = '';
        $verifData = '';
        $alamatData = '';
        $id_nasabah = auth()->user()->id;
        try {
            $verifData = Nasabah::with('informasiBank', 'penjamin')
            ->where('nasabah.id', $id_nasabah)
            ->first();
            
            if ($verifData->kecamatan_id != null) {
                $alamatData = WilayahKecamatan::where('wilayah_kecamatan.id', $verifData->kecamatan->id)
                ->join('wilayah_kabupaten as kabupaten', 'kabupaten.id', 'wilayah_kecamatan.kabupaten_id')
                ->first();
            }
            
            if($verifData == null) {
                $status = 'failed';
                $message = 'Nasabah tidak ditemukan';
            }
            else {
                $status = 'success';
                $message = 'Berhasil';
            }

        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'success';
            $message = 'Gagal' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $verifData,
                'alamat_data' => $alamatData
            ], 200);
        }
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

    public function getLimit()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            
            $saldo = Nasabah::select('limit_pinjaman')->find(auth()->user()->id);

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

    public function inputDataTambahan(Request $request)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $id = auth()->user()->id;
            $nasabah = Nasabah::find($id);
            $nik = $nasabah->nik;

            $folder = 'upload/nasabah/'.$nik.'/data-tambahan';
            // Get canonicalized absolute pathname
            $path = realpath($folder);
            // If it exist, check if it's a directory
            if(!($path !== true AND is_dir($path)))
            {
                // Path/folder does not exist then create a new folder
                mkdir($folder);
            }

            $newData = new DataTambahanNasabah;
            
            $newData->id_nasabah = $id;
            $newData->tempat_tinggal = $request->get('tempat_tinggal');

            // upload npwp
            if($request->get('scan_npwp') != null || $request->get('npwp_filename') != ''){
                $extension = explode('.', $request->get('npwp_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_npwp.'.$ext;
                $img = base64_decode($request->get('scan_npwp'));
                file_put_contents($filename, $img);
                $newData->scan_npwp = $filename;
            }
            // upload ktp suami
            if($request->get('ktp_suami') != null || $request->get('ktp_suami_filename') != ''){
                $extension = explode('.', $request->get('ktp_suami_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_ktp_suami.'.$ext;
                $img = base64_decode($request->get('ktp_suami'));
                file_put_contents($filename, $img);
                $newData->ktp_suami = $filename;
            }
            // upload ktp istri
            if($request->get('ktp_istri') != null || $request->get('ktp_istri_filename') != ''){
                $extension = explode('.', $request->get('ktp_istri_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_ktp_istri.'.$ext;
                $img = base64_decode($request->get('ktp_istri'));
                file_put_contents($filename, $img);
                $newData->ktp_istri = $filename;
            }
            // upload surat nikah
            if($request->get('surat_nikah') != null || $request->get('surat_nikah_filename') != ''){
                $extension = explode('.', $request->get('surat_nikah_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_surat_nikah.'.$ext;
                $img = base64_decode($request->get('surat_nikah'));
                file_put_contents($filename, $img);
                $newData->surat_nikah = $filename;
            }
            // upload bpkb
            if($request->get('bpkb') != null || $request->get('bpkb_filename') != ''){
                $extension = explode('.', $request->get('bpkb_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_bpkb.'.$ext;
                $img = base64_decode($request->get('bpkb'));
                file_put_contents($filename, $img);
                $newData->bpkb = $filename;
            }
            // upload surat domisili usaha
            if($request->get('domisili_usaha') != null || $request->get('domisili_usaha_filename') != ''){
                $extension = explode('.', $request->get('domisili_usaha_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_domisili_usaha.'.$ext;
                $img = base64_decode($request->get('domisili_usaha'));
                file_put_contents($filename, $img);
                $newData->domisili_usaha = $filename;
            }
            
            if($newData->save()) {
                $nasabah->kelengkapan_data = 2; // 2 = pending
                $nasabah->updated_at = time();

                $nasabah->save();
                    
                if($nasabah->save()) {
                    $status = 'success';
                    $message = 'Berhasil';
                    $data = $newData->id;
                }
                else {
                    $status = 'failed';
                    $message = 'Gagal';
                    $data = $newData->id;
                }
            }

            $status = 'success';
            $message = 'Berhasil';
            $data = $newData->id;
            
            $newNotification = new Notification;

            $newNotification->id_nasabah = $id;
            $newNotification->title = "Upload Data Tambahan";
            $newNotification->message = "Nasabah ".$nasabah->nama." baru saja mengunggah data tambahan";
            $newNotification->jenis = "Verifikasi";
            $newNotification->device = "web";

            $newNotification->save();
            

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

    public function inputSyaratPinjamanUmroh(Request $request)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $id = auth()->user()->id;
            $nasabah = Nasabah::find($id);
            $nik = $nasabah->nik;

            // $folder = 'upload/nasabah/'.$nik;
            $folder = 'upload/nasabah/'.$nik.'/syarat-pinjaman-umroh';
            // Get canonicalized absolute pathname
            $path = realpath($folder);
            // If it exist, check if it's a directory
            if(!($path !== true AND is_dir($path)))
            {
                // Path/folder does not exist then create a new folder
                mkdir($folder);
            }

            $newData = new SyaratPinjamanUmroh;
            
            $newData->id_nasabah = $id;

            // upload suket travel atau kbih
            if($request->get('suket_travel') != null || $request->get('suket_travel_filename') != ''){
                $extension = explode('.', $request->get('suket_travel_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_suket_travel.'.$ext;
                $img = base64_decode($request->get('suket_travel'));
                file_put_contents($filename, $img);
                $newData->suket_travel = $filename;
            }
            // upload selfie usaha terkini
            if($request->get('selfie_usaha') != null || $request->get('selfie_usaha_filename') != ''){
                $extension = explode('.', $request->get('selfie_usaha_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_selfie_usaha.'.$ext;
                $img = base64_decode($request->get('selfie_usaha'));
                file_put_contents($filename, $img);
                $newData->selfie_usaha = $filename;
            }
            // upload siup (suran izin usaha perusahaan)
            if($request->get('siup') != null || $request->get('siup_filename') != ''){
                $extension = explode('.', $request->get('siup_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_siup.'.$ext;
                $img = base64_decode($request->get('siup'));
                file_put_contents($filename, $img);
                $newData->siup = $filename;
            }
            // upload nib (nomor induk berusaha)
            if($request->get('nib') != null || $request->get('nib_filename') != ''){
                $extension = explode('.', $request->get('nib_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_nib.'.$ext;
                $img = base64_decode($request->get('nib'));
                file_put_contents($filename, $img);
                $newData->nib = $filename;
            }
            // upload scan jaminan
            if($request->get('scan_jaminan') != null || $request->get('scan_jaminan_filename') != ''){
                $extension = explode('.', $request->get('scan_jaminan_filename'));
                $ext = end($extension);
                $filename = $folder.'/'.date('YmdHis').$id.'_scan_jaminan.'.$ext;
                $img = base64_decode($request->get('scan_jaminan'));
                file_put_contents($filename, $img);
                $newData->scan_jaminan = $filename;
            }
            $newData->save();
            
            if($newData->save()) {
                $nasabah->syarat_pinjaman_umroh = 2; // 2 = pending
                $nasabah->updated_at = time();

                $nasabah->save();
                
                if($nasabah->save()) {
                    $status = 'success';
                    $message = 'Berhasil';
                    $data = $newData->id;
                }
                else {
                    $status = 'failed';
                    $message = 'Gagal';
                    $data = $newData->id;
                }
            }

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
