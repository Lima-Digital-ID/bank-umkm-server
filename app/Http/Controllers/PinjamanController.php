<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\Pelunasan;
use \App\Models\Nasabah;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\KantorCabang;
use App\Models\AsuransiPinjaman;
use App\Models\Pencairan;
use App\Models\User;
use App\Models\JenisPinjaman;

class PinjamanController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $idCabang = auth()->user()->id_kantor_cabang;   

        $this->param['pageInfo'] = 'List Pinjaman';
        // $this->param['btnRight']['text'] = 'Tambah Data';
        // $this->param['btnRight']['link'] = route('pinjaman.create');
        $tipe = 'Pending';
        if ($request->get('t')) {
            $tipe = $request->get('t');
        }

        try {
            
            $keyword = $request->get('keyword');
            if ($keyword) {
               if(auth()->user()->level == 'Administrator') {
                    $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', $tipe)->whereHas('nasabah', function($query){
                        return $query->where('nama','LIKE', "%$_GET[keyword]%");
                    });
               }
               else {
                    $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('pinjaman.id_kantor_cabang', $idCabang)->where('status', $tipe)->whereHas('nasabah', function($query){
                        return $query->where('nama','LIKE', "%$_GET[keyword]%");
                    });
               }
            }
            else{
                $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', $tipe);
            }

            if ($tipe == 'Terima') {
                $pinjaman->where('status_pencairan', 'Terima');
            }

            if (auth()->user()->level != 'Administrator') {
                $pinjaman->where('id_kantor_cabang', auth()->user()->id_kantor_cabang);
            }

            $this->param['jenis_pinjaman'] = JenisPinjaman::orderBy('jenis_pinjaman', 'ASC')->get();

            $this->param['pinjaman'] = $pinjaman->paginate(10);

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }

        if ($tipe == 'Pending') {
            return \view('pinjaman.list-pinjaman-pending', $this->param);
        }
        elseif($tipe == 'Terima'){
            return \view('pinjaman.list-pinjaman-diterima', $this->param);
        }
        elseif($tipe == 'Lunas'){
            return \view('pinjaman.list-pinjaman-lunas', $this->param);
        }
        elseif(($tipe == 'Tolak')){
            return \view('pinjaman.list-pinjaman-ditolak', $this->param);
        }
        else{
            return redirect()->back()->withError('Tipe tidak valid.');
        }
    }

    public function pencairanPinjaman(Request $request)
    {
        $this->param['pageInfo'] = 'List Pencairan Pinjaman';
        
        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', 'Terima')->where('status_pencairan', 'Pending')->whereHas('nasabah', function($query){
                    return $query->where('nama','LIKE', "%$_GET[keyword]%");
                });
            }
            else{
                $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', 'Terima')->where('status_pencairan', 'Pending');
            }

            if (auth()->user()->level != 'Administrator') {
                $pinjaman->where('id_kantor_cabang', auth()->user()->id_kantor_cabang);
            }

            $this->param['pinjaman'] = $pinjaman->paginate(10);

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }

        return \view('pinjaman.list-pencairan', $this->param);
    }

    public function pencairanSudah(Request $request)
    {
        $this->param['pageInfo'] = 'List Pinjaman yang sudah dicairkan ';
        
        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $pencairan = Pencairan::with('pinjaman');
            }
            else{
                $pencairan = Pencairan::with('pinjaman');
            }
            if ($pencairan->count() > 0 && auth()->user()->level != 'Administrator') {
                // $pencairan->where('pinjaman.id_kantor_cabang', auth()->user()->id_kantor_cabang);
                $pencairan->whereHas('pinjaman', function($query){
                    return $query->where('id_kantor_cabang', auth()->user()->id_kantor_cabang);
                });
            }
            $this->param['pencairan'] = $pencairan->paginate(10);

            // return $pencairan->paginate(10)
        } catch (\Illuminate\Database\QueryException $e) {
            // return $e;
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }

        return \view('pinjaman.list-sudah-pencairan', $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Manage Pinjaman / Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('pinjaman.index');

        return \view('pinjaman.tambah-nasabah', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'nik' => 'required|unique:nasabah',
            'no_hp' => 'required',
            'alamat' => 'required',
            'scan_ktp' => 'required',
            'foto_dengan_ktp' => 'required',
            'email' => 'required|email|unique:nasabah',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar'
        ]);
        try{
            $newPinjaman = new Pinjaman;

            $uploadPath = 'upload/nasabah/'.$request->get('nik');  

            // $profil = $request->file('profil');
            // $newProfil = time().'_'.$profil->getClientOriginalName();
            
            $scanKtp = $request->file('scan_ktp');
            $newScanKtp = time().'_'.$scanKtp->getClientOriginalName(); 
            
            $selfie = $request->file('foto_dengan_ktp');
            $newSelfie = time().'_'.$selfie->getClientOriginalName(); 
            
            $npwp = $request->file('npwp');
            $newNpwp = time().'_'.$npwp->getClientOriginalName(); 
            
            $suratNikah = $request->file('surat_nikah');
            $newSuratNikah = time().'_'.$suratNikah->getClientOriginalName(); 
            
            $suratDomisiliUsaha = $request->file('surat_domisili_usaha');
            $newSuratDomisiliUsaha = time().'_'.$suratDomisiliUsaha->getClientOriginalName(); 
            
            $newPinjaman->nama = $request->get('nama');
            $newPinjaman->tanggal_lahir = $request->get('tanggal_lahir');
            $newPinjaman->jenis_kelamin = $request->get('jenis_kelamin');
            $newPinjaman->nik = $request->get('nik');
            $newPinjaman->no_hp = $request->get('no_hp');
            $newPinjaman->alamat = $request->get('alamat');
            // $newPinjaman->profil = $newProfil;
            $newPinjaman->scan_ktp = $newScanKtp;
            $newPinjaman->foto_dengan_ktp = $newSelfie;
            $newPinjaman->npwp = $newNpwp;
            $newPinjaman->surat_nikah = $newSuratNikah;
            $newPinjaman->surat_domisili_usaha = $newSuratDomisiliUsaha;
            $newPinjaman->username = $request->get('nik');
            $newPinjaman->email = $request->get('email');
            $newPinjaman->password = \Hash::make($request->get('nik'));

            if($newPinjaman->save()){
                // $profil->move($uploadPath, $newProfil);
                $scanKtp->move($uploadPath, $newScanKtp);
                $selfie->move($uploadPath, $newSelfie);
                $npwp->move($uploadPath, $newNpwp);
                $suratNikah->move($uploadPath, $newSuratNikah);
                $suratDomisiliUsaha->move($uploadPath, $newSuratDomisiliUsaha);

                return redirect()->route('pinjaman.index')->withStatus('Data berhasil ditambahkan.');
            }

            return redirect()->route('pinjaman.index')->withStatus('Data berhasil ditambahkan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function show($id)
    {
        try{
            $this->param['pageInfo'] = 'Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('pinjaman.index');
            $this->param['pinjaman'] = Pinjaman::with('nasabah')->with('jenisPinjaman')->find($id);
            // return $this->param['pinjaman'];
            return \view('pinjaman.detail-pinjaman', $this->param);
            
            
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }
    
    public function prosesPencairan($id)
    {
        try{
            $this->param['pageInfo'] = 'Proses Pencairan';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = url('pinjaman/pencairan');
            // $this->param['btnRight']['link'] = 'asd';
            $this->param['pinjaman'] = Pinjaman::with('nasabah')->with('jenisPinjaman')->find($id);
            $this->param['asuransiPinjaman'] = AsuransiPinjaman::first();
            // return $this->param['pinjaman'];
            return \view('pinjaman.proses-pencairan', $this->param);
            
            
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function edit($id)
    {
        try{
            $this->param['pageInfo'] = 'Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('pinjaman.index');
            $this->param['nasabah'] = Pinjaman::find($id);

            return \view('pinjaman.edit-nasabah', $this->param);
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id, $status)
    {
        try{
            $pinjaman = Pinjaman::with('jenisPinjaman')->find($id);

            if($pinjaman->jenisPinjaman->jenis_pinjaman != 'Pinjaman Cepat') {
                $this->validate($request,[
                    'nominal' => 'required',
                ],
                [
                    'required' => ':atributte harus diisi.'
                ],
                [
                    'nominal' => 'Nominal'
                ]);

                if($pinjaman->nominal != $request->get('nominal')) {
                    $pinjaman->nominal = $request->get('nominal');
                }
            }

            $setStatus = $status;
            $notifTitle = '';
            $notifMessage = '';
            if ($setStatus == 'Terima') {
                $nasabah = Nasabah::find($pinjaman->id_nasabah);
                $admin = User::find(auth()->user()->id);
                $cabang = KantorCabang::where('id', $pinjaman->id_kantor_cabang)->get();
                $kantorCabang = '';
                
                if(count($cabang) == 0) {
                    $kantorCabang = 'Harap datang ke kantor terdekat di daerah anda.';
                }
                else {
                    $kantorCabang = 'Harap datang ke kantor cabang yang sudah tertera.'.$cabang[0]->alamat.'(Buka setiap Senin-Jumat 08.00-15.00)';
                }
                
                $notifTitle = 'Selamat pengajuan pinjaman Anda telah diterima.';
                $notifMessage = 'Selamat pengajuan pinjaman anda berhasil.'.$kantorCabang.'Diterima oleh '.$admin->nama.'.';

                $date = date('Y-m-d');
                $pinjaman->tanggal_diterima = $date;
                $pinjaman->id_user = auth()->user()->id;
                $pinjaman->jatuh_tempo =  date('Y-m-d', strtotime("+$pinjaman->jangka_waktu months", strtotime($date)));               
            }
            if($setStatus=='Tolak'){
                $notifTitle = 'Maaf, pengajuan pinjaman anda ditolak.';
                $notifMessage = 'Harap bersabar ya. Mungkin Anda bisa melihat dibawah ini alasan dari pengajuan Anda ditolak. \n'.'Anda belum memenuhi syarat.';
                $date = date('Y-m-d');
                $pinjaman->tanggal_diterima = $date;
                $pinjaman->alasan_penolakan = 'Anda belum memenuhi syarat.';
            }
            $pinjaman->status = $setStatus;
            $pinjaman->updated_at = time();
            $pinjaman->save();

            $newNotification = new Notification;

            $newNotification->id_nasabah = $pinjaman->id_nasabah;
            $newNotification->title = $notifTitle;
            $newNotification->message = $notifMessage;
            $newNotification->jenis = "Pinjaman";
            $newNotification->device = "mobile";

            $newNotification->save();

            return back()->withStatus('Data berhasil diperbarui.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function updateStatusPencairan(Request $request, $id, $status)
    {
        try{
            $pinjaman = Pinjaman::find($id);
            $setStatus = $status;
            $notifTitle = '';
            $notifMessage = '';
            if ($setStatus == 'Terima') {

                // get nominal asuransi pinjaman
                $asuransi = AsuransiPinjaman::first();

                // $this->validate($request,[
                //     'nominal' => 'required',
                // ],
                // [
                //     'required' => ':atributte harus diisi.'
                // ],
                // [
                //     'nominal' => 'Nominal'
                // ]);
                // $date = date('Y-m-d');
                // $pinjaman->tanggal_diterima = $date;
                
                $pinjaman->asuransi_pinjaman = $asuransi->jumlah_asuransi;
                // $pinjaman->jatuh_tempo =  date('Y-m-d', strtotime("+$pinjaman->jangka_waktu months", strtotime($date)));
                // $nasabah = Nasabah::find($pinjaman->id_nasabah);
                // $hutang = $nasabah->hutang + $nasabah->limit_pinjaman;
                    // $nasabah->hutang -= $request->get('nominal_pembayaran');
                // $nasabah->hutang = $hutang;
                // $nasabah->limit_pinjaman = 0;
                // $nasabah->save();
                $nasabah = Nasabah::find($pinjaman->id_nasabah);
                
                $tempLimit = $nasabah->limit_pinjaman;
                
                $hutang = $pinjaman->nominal; // tanggungan nasabah
                
                $nasabah->hutang = $hutang;
                $nasabah->limit_pinjaman = 0;
                $nasabah->temp_limit = $tempLimit;
                $nasabah->save();

                $bunga = $tempLimit * 9 / 100; // untuk mengetahui jml bunga
                $nominalPembayaran = round($pinjaman->nominal / $pinjaman->jangka_waktu); // untuk menentukan pembayaran tiap terminnya

                $noPelunasan = '00001';
                for ($i=1; $i <= $pinjaman->jangka_waktu ; $i++) { 
                    $countPelunasan = Pelunasan::select('kode_pelunasan')->count();
                    $getDate = date('Ymd');

                    if($countPelunasan > 0){
                        $lastPinjaman = Pelunasan::orderBy('id', 'DESC')
                                                ->first()
                                                ->kode_pelunasan;
        
                        $lastIncreament = substr($lastPinjaman, 11);
        
                        $noPelunasan = str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);
                    }
                    $cicilan = new Pelunasan;
                    $cicilan->id_pinjaman = $pinjaman->id;
                    $cicilan->kode_pelunasan = 'INV'.$getDate.$noPelunasan;
                    $cicilan->jatuh_tempo_cicilan = date('Y-m-d', strtotime("+$i months", strtotime(date('Y-m-d'))));
                    $cicilan->cicilan_ke = $i;
                    $cicilan->nominal_pembayaran = $nominalPembayaran;
                    $cicilan->bunga = $bunga / $pinjaman->jangka_waktu;
                    $cicilan->save();
                }

                $newPencairan = new Pencairan;
                $newPencairan->id_pinjaman = $pinjaman->id;
                $newPencairan->save();

                $notifTitle = 'Selamat pinjaman anda berhasil dicairkan.';
                $notifMessage = 'Selamat untuk anda. Pinjaman Anda berhasil dicairkan ('.auth()->user()->nama.').';

            }
            if($setStatus=='Tolak'){
                $notifTitle = 'Maaf, proses pencairan gagal.';
                $notifMessage = 'Harap bersabar ya. Mungkin Anda bisa melihat dibawah ini alasan dari pengajuan Anda ditolak. \n'.'Anda belum memenuhi syarat.';

                $pinjaman->alasan_penolakan_pencairan = 'Anda belum memenuhi syarat.';
                $pinjaman->status = $setStatus;

                // $nasabah = Nasabah::find($pinjaman->id_nasabah);
                // $nasabah->limit_pinjaman += $pinjaman->nominal;
                // $nasabah->hutang -= $pinjaman->nominal;
                // $nasabah->save();
            }
            
            $pinjaman->status_pencairan = $setStatus;
            $pinjaman->id_staff_pencairan = auth()->user()->id;
            $pinjaman->tanggal_pencairan = date('Y-m-d');
            $pinjaman->updated_at = time();
            $pinjaman->save();

            $newNotification = new Notification;

            $newNotification->id_nasabah = $pinjaman->id_nasabah;
            $newNotification->title = $notifTitle;
            $newNotification->message = $notifMessage;
            $newNotification->jenis = "Pinjaman";
            $newNotification->device = "mobile";

            $newNotification->save();

            return back()->withStatus('Data berhasil diperbarui.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $nasabah = Pinjaman::find($id);

        $isUnique = $nasabah->email == $request->email ? '' : '|unique:nasabah';
        $isUniqueNik = $nasabah->nik == $request->nik ? '' : '|unique:nasabah';
        $isUniqueUsername = $nasabah->username == $request->username ? '' : '|unique:nasabah';
        $validatedData = $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'nik' => 'required|'.$isUniqueNik,
            'no_hp' => 'required',
            'alamat' => 'required',
            'email' => 'required|email'.$isUnique,
            'username' => 'required'.$isUniqueUsername,
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute telah terdaftar.',
            'date' => ':attribute harus berupa tanggal.',
        ]);
        try{

            $nasabah->nama = $request->get('nama');
            $nasabah->tanggal_lahir = $request->get('tanggal_lahir');
            $nasabah->jenis_kelamin = $request->get('jenis_kelamin');
            $nasabah->nik = $request->get('nik');
            $nasabah->no_hp = $request->get('no_hp');
            $nasabah->alamat = $request->get('alamat');
            $nasabah->username = $request->get('username');
            $nasabah->email = $request->get('email');
            // $nasabah->akses = $request->get('akses');
            $nasabah->save();

            return redirect()->route('pinjaman.index')->withStatus('Data berhasil diperbarui.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $nasabah = Pinjaman::findOrFail($id);

            $nasabah->delete();

            return redirect()->route('pinjaman.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('pinjaman.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('pinjaman.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
    public function cekNotif()
    {
        $count = Pinjaman::select(DB::raw("count('id') as ttl"))->where('view','0')->get();
        echo $count[0]->ttl;
        
    }

    public function monitoringPinjaman(Request $request)
    {
        $this->param['pageInfo'] = 'Monitoring Pinjaman';

        try {

            $getAllPinjaman = DB::table('pinjaman as p')
                                ->select('p.id', 'p.kode_pinjaman', 'p.tanggal_pengajuan','n.nama', 'n.nik', 'p.jangka_waktu', 'p.jatuh_tempo','j.jenis_pinjaman', 'wk.nama as kecamatan')
                                ->join('nasabah as n', 'p.id_nasabah', 'n.id')
                                ->join('users as u', 'p.id_user', 'u.id')
                                ->join('kantor_cabang as k', 'k.id', 'p.id_kantor_cabang')
                                ->join('wilayah_kecamatan as wk', 'wk.id', 'k.kecamatan_id')
                                ->join('jenis_pinjaman as j', 'j.id', 'p.id_jenis_pinjaman')
                                ->orderBy('p.id', 'DESC');

            $idKantorCabang = $request->get('id_kantor_cabang');
            $idJenisPinjaman = $request->get('id_jenis_pinjaman');

            if ($idKantorCabang) {
                $getAllPinjaman->where('p.id_kantor_cabang', $idKantorCabang);
            
            }
            if ($idJenisPinjaman) {
                $getAllPinjaman->where('p.id_jenis_pinjaman', $idJenisPinjaman);
            }

            if(auth()->user()->level != 'Administrator') {
                $idCabang = auth()->user()->id_kantor_cabang;   
                $getAllPinjaman->where('p.id_kantor_cabang', $idCabang);
            }

            $this->param['jenisPinjaman'] = JenisPinjaman::orderBy('jenis_pinjaman', 'ASC')->get();

            if(auth()->user()->level == 'Administrator') {
                $this->param['kantorCabang'] = DB::table('kantor_cabang')
                                                ->select('kantor_cabang.id', 'wilayah_kecamatan.nama')
                                                ->join('wilayah_kecamatan', 'wilayah_kecamatan.id', 'kantor_cabang.kecamatan_id')
                                                ->orderBy('wilayah_kecamatan.nama', 'ASC')
                                                ->get();
            }
            $this->param['pinjaman'] = $getAllPinjaman->paginate(10);

            return \view('pinjaman.monitoring-pinjaman', $this->param);

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }
    }
    
    public function detailMonitoringPinjaman($id)
    {
        $this->param['pageInfo'] = 'Monitoring Pinjaman';

        try {
            $this->param['detail'] = DB::table('pinjaman as p')
                                        ->select('n.nama', 'n.nik', 'n.tanggal_lahir', 'n.jenis_kelamin', 'n.pekerjaan', 'n.alamat', 'n.no_hp', 'n.email' , 'p.id', 'p.kode_pinjaman', 'p.jangka_waktu', 'p.tanggal_pengajuan', 'p.status', 'p.status_pencairan', 'p.tanggal_pencairan', 'p.alasan_penolakan_pencairan', 'p.alasan_penolakan', 'p.tanggal_diterima', 'p.jatuh_tempo', 'p.tanggal_lunas', 'p.id_user', 'p.id_staff_pencairan', 'j.jenis_pinjaman', 'wk.nama as kecamatan', 'u.nama as nama_staff')
                                        ->join('nasabah as n', 'p.id_nasabah', 'n.id')
                                        ->join('users as u', 'p.id_user', 'u.id')
                                        // ->join('pencairan', 'p.id', 'pencairan.id_pinjaman')
                                        ->join('kantor_cabang as k', 'k.id', 'p.id_kantor_cabang')
                                        ->join('wilayah_kecamatan as wk', 'wk.id', 'k.kecamatan_id')
                                        ->join('jenis_pinjaman as j', 'j.id', 'p.id_jenis_pinjaman')
                                        ->where('p.id', $id)
                                        ->first();

            $this->param['pelunasan'] = DB::table('pelunasan')
                                        ->select('kode_pelunasan', 'jatuh_tempo_cicilan', 'nominal_pembayaran', 'bunga', 'tanggal_pembayaran', 'cicilan_ke', 'metode_pembayaran', 'status')
                                        ->where('id_pinjaman', $id)
                                        ->get();

            return \view('pinjaman.detail-monitoring', $this->param);

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }
    }
}
