<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InformasiBank;
use Illuminate\Http\Request;
use \App\Models\Nasabah;
use App\Models\Penjamin;
use Exception;

class ApiAuthController extends Controller
{

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $status = '';
        $message = '';
        $token = '';
        try {
            $nasabah = Nasabah::where('username', $request->get('username'))->first();

            if (!$nasabah || !(\Hash::check($request->get('password'), $nasabah->password))) {
                $status = 'Unauthorized';
                $message = 'Gagal login. password salah.';
                $nasabah = '';
                // return $this->error('Credentials not match', 401);
            }
            else{
                $token = $nasabah->createToken('token')->plainTextToken;
                $status = 'success';
                $message = 'Berhasil login.';
            }


        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal login ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'success';
            $message = 'Gagal login.' . $e->getMessage();
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

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            // 'tanggal_lahir' => 'required|date',
            // 'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'username' => 'required',
            'password' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar.'
        ]);

        $status = '';
        $message = '';

        try {
            $newNasabah = new Nasabah;
            $newNasabah->nama = $request->get('nama');
            // $newNasabah->tanggal_lahir = $request->get('tanggal_lahir');
            // $newNasabah->jenis_kelamin = $request->get('jenis_kelamin');
            $newNasabah->no_hp = $request->get('no_hp');
            $newNasabah->username = $request->get('username');
            $newNasabah->password = \Hash::make($request->get('password'));
            $newNasabah->limit_pinjaman = 5000000;
            $newNasabah->is_verified = 1;
            $newNasabah->alasan_penolakan = '';

            $newNasabah->save();

            $status = 'success';
            $message = 'Berhasil register';
        } catch(\Exception $e){
            // return response()->json([
            //     'error' => true,
            //     'message' => 'Terjadi kesalahan.' . $e->getMessage()
            // ], 500);
            $status = 'failed';
            $message = 'Gagal register' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal register' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 200);
        }
    }

    public function lengkapiData(Request $request)
    {
        $message = '';
        $sms = 'nonaktif';
        $id_nasabah = auth()->user()->id;
        $updateNasabah = Nasabah::find($id_nasabah);
        try{
            $updateNasabah->tanggal_lahir = $request->get('tgl_lahir');
            $updateNasabah->tempat_lahir = $request->get('tempat_lahir');
            $updateNasabah->nik = $request->get('nik');
            $updateNasabah->no_hp = $request->get('no_hp');
            $updateNasabah->alamat = $request->get('alamat');
            $updateNasabah->pekerjaan = $request->get('jenis_pekerjaan');
            $updateNasabah->is_verified = 2;

            $updateNasabah->save();

            if($updateNasabah->save()){
                $uploadImg = Nasabah::find($updateNasabah->id);
                $folder = 'upload/nasabah/'.$uploadImg->nik;
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder);
                }
                if($request->get('scan_ktp') != null || $request->get('scan_ktp') != ''){
                    $extension = explode('.', $request->get('ktp_filename'));
                    $ext = end($extension);
                    $filename = $folder.'/'.date('YmdHis').$updateNasabah->id.'_ktp.'.$ext;
                    $img = base64_decode($request->get('scan_ktp'));
                    file_put_contents($filename, $img);
                    $uploadImg->scan_ktp = $filename;
                }
                if($request->get('foto_dengan_ktp') != null || $request->get('foto_dengan_ktp') != ''){
                    $extension = explode('.', $request->get('with_ktp_filename'));
                    $ext = end($extension);
                    $filename = $folder.'/'.date('YmdHis').$updateNasabah->id.'_dengan_ktp.'.$ext;
                    $img = base64_decode($request->get('foto_dengan_ktp'));
                    file_put_contents($filename, $img);
                    $uploadImg->selfie_ktp = $filename;
                }
                $uploadImg->updated_at = time();
                $uploadImg->save();

                $newBank = new InformasiBank;
                $newBank->id_nasabah = $updateNasabah->id;
                $newBank->id_bank = $request->get('id_bank');
                $newBank->no_rekening = $request->get('norek');
                $newBank->nama_rekening = $request->get('nama_akun_bank');

                $newBank->save();

                $newPenjamin = new Penjamin;
                $newPenjamin->id_nasabah = $updateNasabah->id;
                $newPenjamin->nama = $request->get('nama_penjamin');
                $newPenjamin->nik = $request->get('nik_penjamin');
                $newPenjamin->no_hp = $request->get('no_hp_penjamin');
                $newPenjamin->alamat = $request->get('alamat_penjamin');

                $newPenjamin->save();
            }

            $message = "Success update data";

            // $basic  = new \Vonage\Client\Credentials\Basic("0e5ff442", "BMAdHGf1zVsPE3FB");
            // $client = new \Vonage\Client($basic);
            // $to = "62" . $request->get('no_hp');
            // $response = $client->sms()->send(
            //     new \Vonage\SMS\Message\SMS($to, "Greensoft", $request->get('verification_code').'  ')
            // );
            
            // $sms = $response->current();
            
            // if ($sms->getStatus() == 0) {
            //     $sms = "The message was sent successfully";
            // } else {
            //     $sms = "The message failed with status: " . $sms->getStatus() . "\n";
            // }
        }
        catch(Exception $e){
            $message = $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = $e->getMessage();
        }
        finally{
            $result = [
                'user_id' => strval($updateNasabah->id),
                'message' => $message,
                'sms_message' => $sms
            ];
            return response($result, 200);
        }
    }

    public function me(Request $request)
    {
        return auth()->user();
    }

    public function logout(Request $request)
    {
        $status = '';
        $message = '';
        try {
            $request->user()->currentAccessToken()->delete();       
            $status = 'success';
            $message = 'Berhasil logout.';
        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal logout. ' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'success';
            $message = 'Gagal logout.' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 200);
        }
    }
}
