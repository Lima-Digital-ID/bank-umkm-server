<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifPerNasabah()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $notif = Notification::where('id_nasabah', auth()->user()->id)->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $notif;
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

    public function getNotifPerNasabahNotSeen()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $notif = Notification::where('id_nasabah', auth()->user()->id)->where('is_read', 0)->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $notif;
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

    public function getDetailNotif($id)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $notif = Notification::where('id_nasabah', auth()->user()->id)->where('id', $id)->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = $notif;
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

    public function updateSended(Request $request)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $jsonreq = json_encode($request->json()->all());
            $json = json_decode($jsonreq, true);
            $arr = [];
            foreach($json['data'] as $i => $v)
            {
                $notif = Notification::where('id_nasabah', auth()->user()->id)->where('id', $v['id'])->first();
                $notif->sended = 1;
                $notif->updated_at = time();
                $notif->save();
            }

            $status = 'success';
            $message = 'Berhasil';
            $data = $notif;
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

    public function isRead($id)
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $notif = Notification::where('id_nasabah', auth()->user()->id)->where('id', $id)->first();
            $notif->is_read = 1;
            $notif->updated_at = time();
            $notif->save();

            $status = 'success';
            $message = 'Berhasil';
            $data = $notif;
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
