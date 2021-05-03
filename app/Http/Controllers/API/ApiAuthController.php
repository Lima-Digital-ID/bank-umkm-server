<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Nasabah;

class ApiAuthController extends Controller
{

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $status = '';
        $message = '';
        $token = '';
        try {
            $nasabah = Nasabah::where('email', $request->get('email'))->firstOrFail();

            if (!$nasabah || !\Hash::check($request->get('password'), $nasabah->password)) {
                $message = 'Unauthorized';
                $status = 'Gagal login. Email atau password salah.';
                return $this->error('Credentials not match', 401);
            }
            else{
                $token = $nasabah->createToken('token')->plainTextToken;
                $status = 'success';
                $message = 'Berhasil login.';
                $data = $nasabah;
            }


        } catch(\Exception $e){
            $status = 'failed';
            $message = 'Gagal login. ' . $e->getMessage();
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
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:nasabah',
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
            $newNasabah->tanggal_lahir = $request->get('tanggal_lahir');
            $newNasabah->jenis_kelamin = $request->get('jenis_kelamin');
            $newNasabah->no_hp = $request->get('no_hp');
            $newNasabah->email = $request->get('email');
            $newNasabah->password = \Hash::make($request->get('password'));

            $newNasabah->save();

            $status = 'success';
            $message = 'Berhasil register.';
        } catch(\Exception $e){
            // return response()->json([
            //     'error' => true,
            //     'message' => 'Terjadi kesalahan.' . $e->getMessage()
            // ], 500);
            $status = 'failed';
            $message = 'Gagal register.' . $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 'failed';
            $message = 'Gagal register.' . $e->getMessage();
        }
        finally{
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 200);
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
