<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AsuransiPinjaman;
use App\Models\Nasabah;
use App\Models\Pelunasan;
use App\Models\Pinjaman;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback()
    {
        $status = '';
        $message = '';
        try {
            //setConfig
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            //Notification Midtrans
            $notification = new Notification();
            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;
            $order_id = explode('-', $notification->order_id);
            $kode_pelunasan = $order_id[0];
            $gross_amount = $notification->gross_amount;

            //getTransaction
            $pelunasan = Pelunasan::where('kode_pelunasan', $kode_pelunasan)->first();

            if($status == 'capture'){
                if($type == 'credit_card'){
                    if($fraud == 'challenge'){
                        $pelunasan->status = 'Belum';
                        $pelunasan->metode_pembayaran = $type;
                    } else {
                        $pelunasan->status = 'Lunas';
                    }
                }
            } else if($status == 'settlement') {
                $pelunasan->status = 'Lunas';
                $pelunasan->metode_pembayaran = $type;
                // $asuransi = AsuransiPinjaman::first()->jumlah_asuransi;

                // $pelunasan->tanggal_pembayaran = date('Y-m-d');
                // $pelunasan->metode_pembayaran = $type;
                // $pelunasan->status = 'Lunas';

                // $nasabah = Nasabah::find($order_id[1]);
                // $hutang = $nasabah->hutang - $gross_amount;
                // $limitPinjaman = $nasabah->temp_limit;

                // $nasabah->hutang = $hutang;

                // $pinjaman = Pinjaman::with('jenisPinjaman')->find($pelunasan->id_pinjaman);
                // $terbayar = $pinjaman->terbayar + $gross_amount;
                // $newNotification = new \App\Models\Notification;
                
                // $countLunas = Pelunasan::where('id_pinjaman', $pelunasan->id_pinjaman)->where('status', 'Belum')->count();
                
                // if($countLunas == 0) {
                //     $terbayar += $asuransi;
                //     $pinjaman->status = 'Lunas';
                //     $pinjaman->tanggal_lunas = date("Y-m-d");

                //     if($pinjaman->jenisPinjaman->jenis_pinjaman == 'Pinjaman Cepat') {
                //         $nasabah->limit_pinjaman = $limitPinjaman;
                //         $nasabah->temp_limit = 0;
                //     }

                //     $newNotification->id_nasabah = auth()->user()->id;
                //     $newNotification->title = "Pelunasan";
                //     $newNotification->message = $nasabah->nama." melakukan pelunasan";
                //     // $newNotification->message = "Nasabah melakukan pembayaran";
                //     $newNotification->jenis = "Pembayaran";
                //     $newNotification->device = "web";
                // }
                // else {
                //     $newNotification->id_nasabah = auth()->user()->id;
                //     $newNotification->title = "Pembayaran";
                //     $newNotification->message = $nasabah->nama." melakukan pembayaran";
                //     // $newNotification->message = "Nasabah melakukan pembayaran";
                //     $newNotification->jenis = "Pembayaran";
                //     $newNotification->device = "web";
                // }
                
                // $nasabah->save();
                
                // $pinjaman->terbayar = $terbayar;

                // $pinjaman->save();

                // $newNotification->save();

                // $status = 'success';
                // $message = 'pembayaran berhasil.';
            } else if($status == 'pending') {
                $pelunasan->status = 'Pending';
            } else if($status == 'expire') {
                $pelunasan->status = 'Belum';
            } else if($status == 'cancel') {
                $pelunasan->status = 'Belum';
            } else if($status == 'deny') {
                $pelunasan->status = 'Gagal';
            }

            $pelunasan->save();
        } catch (\Exception $e) {
            $status = 'failed';
            $message = $e->getMessage();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = 'failed';
            $message = $e->getMessage();
        } finally {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);        }
    }
}
