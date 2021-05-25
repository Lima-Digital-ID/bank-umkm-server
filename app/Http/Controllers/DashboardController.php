<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\Pinjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $param;
    
    public function index()
    {
        try {
            $this->param['nasabahBaru'] = Nasabah::where('is_verified', 0)->count();
            $this->param['nasabahVerified'] = Nasabah::where('is_verified', 1)->count();
            $this->param['pengajuanPinjaman'] = Pinjaman::where('status', 'Pending')->count();
            $this->param['pinjamanBerjalan'] = Pinjaman::where('status', 'Terima')->count();
            // chart pinjaman harian bulan ini
            $month = date('m');
            $getRekapBulanIni = Pinjaman::select(DB::raw('SUM(nominal) as nominal'), 'tanggal_diterima')->groupBy('tanggal_diterima')->where(DB::raw('MONTH(tanggal_diterima)'), $month)->whereIn('status', ['Terima', 'Lunas'])->get();

            $tanggal = [];
            $pinjamanHarian = [];
            
            foreach ($getRekapBulanIni as $key => $value) {
                array_push($tanggal, date('d-m-Y', strtotime($value->tanggal_diterima)));
                array_push($pinjamanHarian, $value->nominal);
            }

        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        return view('dashboard', $this->param)
                ->with('tanggal',json_encode($tanggal))
                ->with('nominalPinjamanHarian',json_encode($pinjamanHarian));
    }
    public function cekNotif()
    {
        $count = \DB::table('notification')->select(\DB::raw("count('id') as ttl"))->where('is_read','0')->where('device','web')->get();
        echo $count[0]->ttl;
    }
    public function cekDetailNotif()
    {
        $notif = \DB::table('notification')->where('is_read','0')->where('device','web')->get();
        foreach ($notif as $key => $value) {
            if($value->jenis=='Verifikasi'){
                $icon = "fa-exclamation-triangle";
            }
            else if($value->jenis=='Pinjaman'){
                $icon = "fa-donate";
            }
            if($value->jenis=='Pembayaran'){
                $icon = "fa-file-alt";
            }
            echo "<a class='dropdown-item d-flex align-items-center' href='#'>
            <div class='mr-3'>
                <div class='icon-circle bg-primary'>
                    <i class='fas $icon text-white'></i>
                </div>
            </div>
            <div>
                <div class='small text-gray-500'>".$value->title."</div>
                <span class='font-weight-bold'>".$value->message."</span>
            </div>
        </a>";
        }
    }
}
