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

    public function getNotifPerNasabahNotRead()
    {
        $status = '';
        $message = '';
        $data = '';
        try {
            $notif = Notification::where('id_nasabah', auth()->user()->id)->where('is_read', 0)->get();

            $status = 'success';
            $message = 'Berhasil';
            $data = count($notif);
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