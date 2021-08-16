<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\Pinjaman;
use \App\Models\Pelunasan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $param;
    
    public function index()
    {
        try {
            $date = date('Y-m-d');
            $this->param['nasabahBaru'] = Nasabah::where('is_verified', 2)->where('skor', '>', 0)->count();
            $this->param['nasabahVerified'] = Nasabah::where('is_verified', 1)->count();
            $this->param['pengajuanPinjaman'] = Pinjaman::where('status', 'Pending')->count();
            $this->param['pinjamanBerjalan'] = Pinjaman::where('status', 'Terima')->where('status_pencairan', 'Terima')->count();
            $this->param['cicilanTelat'] = Pelunasan::where('jatuh_tempo_cicilan', '<', $date)->where('status', 'Belum')->count();
            // chart pinjaman bulanan
            $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            $tahun = date('Y');
            $pinjamanBulanan = [];
            $pembayaranBulanan = [];
            $valuasi = [];

            foreach ($bulan as $key => $val) {
                $pinjaman = Pinjaman::select(DB::raw('SUM(nominal) as nominal'))->where(DB::raw('MONTH(tanggal_diterima)'), $val)->where(DB::raw('YEAR(tanggal_diterima)'), $tahun)->whereIn('status', ['Terima', 'Lunas'])->where('status_pencairan', 'Terima')->get();
                
                $pembayaran = Pelunasan::select(DB::raw('SUM(nominal_pembayaran) as nominal_pembayaran'))->where(DB::raw('MONTH(tanggal_pembayaran)'), $val)->where(DB::raw('YEAR(tanggal_pembayaran)'), $tahun)->where('status', 'Lunas')->get();

                if ($pembayaran) {
                    array_push($pembayaranBulanan, $pembayaran[0]->nominal_pembayaran);
                }
                else{
                    array_push($pembayaranBulanan, 0);
                }
                
                if ($pinjaman) {
                    array_push($pinjamanBulanan, $pinjaman[0]->nominal);
                }
                else{
                    array_push($pinjamanBulanan, 0);
                }

                if ($pinjaman[0]->nominal || $pembayaran[0]->nominal_pembayaran) {
                    array_push($valuasi, $pembayaran[0]->nominal_pembayaran - $pinjaman[0]->nominal);
                }
                else{
                    array_push($valuasi, null);
                }

            }

            // $getRekapBulanan = Pinjaman::select(DB::raw('SUM(nominal) as nominal'), 'tanggal_diterima')->groupBy('tanggal_diterima')->where(DB::raw('YEAR(tanggal_diterima)'), $year)->whereIn('status', ['Terima', 'Lunas'])->where('status_pencairan', 'Terima')->groupBy(DB::raw('MONTH(tanggal_diterima)'))->get();

            // $tanggal = [];
            // $pinjamanHarian = [];
            
            // foreach ($getRekapBulanan as $key => $value) {
            //     array_push($tanggal, date('d-m-Y', strtotime($value->tanggal_diterima))); //label grafik
            //     array_push($pinjamanHarian, $value->nominal); //data grafik
            // }

        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        return view('dashboard', $this->param)
                // ->with('all',json_encode($tanggal))
                ->with('nominalPinjamanBulanan',json_encode($pinjamanBulanan))
                ->with('nominalPembayaranBulanan',json_encode($pembayaranBulanan))
                ->with('valuasi',json_encode($valuasi))
                ->with('tahun',json_encode($tahun));
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
