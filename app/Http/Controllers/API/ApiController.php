<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\VerificationCode;
use Exception;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function registerUser(Request $request)
    {
        $message = '';
        $sms = 'nonaktif';
        $newNasabah = new Nasabah;
        try{
            $newNasabah->nama = $request->get('nama');
            $newNasabah->tanggal_lahir = $request->get('tgl_lahir');
            $newNasabah->tempat_lahir = $request->get('tempat_lahir');
            $newNasabah->nik = $request->get('nik');
            $newNasabah->no_hp = $request->get('no_hp');
            $newNasabah->alamat = $request->get('alamat');
            $newNasabah->jenis_pekerjaan = $request->get('jenis_pekerjaan');
            $newNasabah->nama_penjamin = $request->get('nama_penjamin');
            $newNasabah->nik_penjamin = $request->get('nik_penjamin');
            $newNasabah->no_hp_penjamin = $request->get('no_hp_penjamin');
            $newNasabah->alamat_penjamin = $request->get('alamat_penjamin');
            $newNasabah->nama_akun_bank = $request->get('nama_akun_bank');
            $newNasabah->bank = $request->get('bank');
            $newNasabah->norek = $request->get('norek');

            $newNasabah->save();

            if($newNasabah->save()){
                $uploadImg = Nasabah::find($newNasabah->id);
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
                    $filename = $folder.'/'.date('YmdHis').$newNasabah->id.'_ktp.'.$ext;
                    $img = base64_decode($request->get('scan_ktp'));
                    file_put_contents($filename, $img);
                    $uploadImg->scan_ktp = $filename;
                }
                if($request->get('foto_dengan_ktp') != null || $request->get('foto_dengan_ktp') != ''){
                    $extension = explode('.', $request->get('with_ktp_filename'));
                    $ext = end($extension);
                    $filename = $folder.'/'.date('YmdHis').$newNasabah->id.'_dengan_ktp.'.$ext;
                    $img = base64_decode($request->get('foto_dengan_ktp'));
                    file_put_contents($filename, $img);
                    $uploadImg->foto_dengan_ktp = $filename;
                }
                $uploadImg->updated_at = time();
                $uploadImg->save();
            }

            $newVerificationCode = new VerificationCode;
            $newVerificationCode->nasabah_id = $newNasabah->id;
            $newVerificationCode->code = $request->get('verification_code');

            $newVerificationCode->save();

            $message = "Data success inserted";

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
                'user_id' => strval($newNasabah->id),
                'body' => $request->get('verification_code'),
                'message' => $message,
                'sms_message' => $sms
            ];
            return response($result, 200);
        }
    }
    
    public function sendVerificationCode($no, $code)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("0e5ff442", "BMAdHGf1zVsPE3FB");
        $client = new \Vonage\Client($basic);
        $to = "62" . $no;
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($to, "Greensoft", $code.'  ')
        );
        
        $sms = $response->current();
        
        if ($sms->getStatus() == 0) {
            $sms = "The message was sent successfully";
        } else {
            $sms = "The message failed with status: " . $sms->getStatus() . "\n";
        }
    }

    function generateRandomString() {
        $length = 60;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function resendEmail(Request $request)
    {
        $status = '';
        $message = '';
        try{
            $new_time = date("Y-m-d H:i:s", strtotime('+5 minutes'));

            $key = $this->generateRandomString();
            $newEmailVerification = new EmailVerification();
            $newEmailVerification->id_nasabah = $request->get('id');
            $newEmailVerification->verification_key = $key;
            $newEmailVerification->expired_at = $new_time;
            $newEmailVerification->save();

            Mail::to($request->get('email'))->send(new \App\Mail\EmailVerification($key));

            $status = 'success';
            $message = 'Silahkan cek email anda.';
        }
        catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal mengirim email' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 200);
        }
    }

    public function resendVerificationCode(Request $request)
    {
        $message = '';
        try{
            \DB::update('UPDATE verification_code SET is_active = 0, updated_at = ? where nasabah_id = ? AND is_active = 1', [date('Y-m-d H:i:s'),$request->get('nasabah_id')]);

            $newVerificationCode = new VerificationCode;
            $newVerificationCode->nasabah_id = $request->get('nasabah_id');
            $newVerificationCode->code = $request->get('verification_code');

            $newVerificationCode->save();

            // $user = Nasabah::find($request->get('nasabah_id'));

            // sendVerificationCode($user->no_hp, $request->get('verification_code'));

            $message = "The verification code was sent successfully";
        }
        catch(Exception $e){
            $message = $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = $e->getMessage();
        }
        finally{
            $result = [
                'message' => $message,
            ];
            return response($result, 200);
        }
    }

    public function checkVerificationCode(Request $request)
    {
        $message = '';
        $code = null;
        try{
            $user = Nasabah::find($request->get('nasabah_id'));
            if($user != null){
                if($user->status == 'Aktif'){
                    $message = "The user already verification";
                }
                else{
                    $code = VerificationCode::where('nasabah_id', $request->get('nasabah_id'))->where('code', $request->get('code'))->first();
                    if($code != null){
                        if($code->is_active == 0) {
                            $message = "Code expired";
                        }
                        else {
                            // Activating User
                            $user->status = 'Aktif';
                            $user->updated_at = time();
                            $user->save();
            
                            // Deactivate Verification Code
                            $code->is_active = 0;
                            $code->updated_at = time();
                            $code->save();
            
                            $message = "Successful verification";
                        }
                    }
                    else{
                        $message = "Please resend the verification code";
                    }
                }
            }
            else {
                $message = "The user is not registered yet";
            }
        }
        catch(Exception $e){
            $message = $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $message = $e->getMessage();
        }
        finally{
            $result = [
                'body' => $code,
                'message' => $message,
            ];
            return response($result, 200);
        }
    }
}
