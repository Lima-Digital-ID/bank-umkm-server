<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\Nasabah;
use App\Models\Notification;

class PinjamanController extends Controller
{
    private $param;

    public function index(Request $request)
    {
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
                $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', $tipe)->whereHas('nasabah', function($query){
                    return $query->where('nama','LIKE', "%$_GET[keyword]%");
                });
            }
            else{
                $pinjaman = Pinjaman::with('nasabah','jenisPinjaman')->where('status', $tipe);
            }

            if ($tipe == 'Terima') {
                $pinjaman->where('status_pencairan', 'Terima');
            }

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
                $this->param['pinjaman'] = Pinjaman::with('nasabah','jenisPinjaman')->where('status', 'Terima')->where('status_pencairan', 'Pending')->whereHas('nasabah', function($query){
                    return $query->where('nama','LIKE', "%$_GET[keyword]%");
                })->paginate(10);
            }
            else{
                $this->param['pinjaman'] = Pinjaman::with('nasabah','jenisPinjaman')->where('status', 'Terima')->where('status_pencairan', 'Pending')->paginate(10);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan' . $e->getMessage());
        }

        return \view('pinjaman.list-pencairan', $this->param);
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
            $this->param['btnRight']['link'] = route('pinjaman.index');
            $this->param['pinjaman'] = Pinjaman::with('nasabah')->with('jenisPinjaman')->find($id);
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
            $pinjaman = Pinjaman::find($id);
            $setStatus = $status;
            $notifTitle = '';
            $notifMessage = '';
            if ($setStatus == 'Terima') {
                $notifTitle = 'Selamat pengajuan pinjaman Anda telah diterima.';
                $notifMessage = 'Selamat untuk anda. Pengajuan pinjaman Anda telah diterima, silahkan datang ke kantor cabang terdekat untuk pencairan pinjaman.';

                // $this->validate($request,[
                //     'nominal' => 'required',
                // ],
                // [
                //     'required' => ':atributte harus diisi.'
                // ],
                // [
                //     'nominal' => 'Nominal'
                // ]);
                $date = date('Y-m-d');
                $pinjaman->tanggal_diterima = $date;
                $pinjaman->id_user = auth()->user()->id;
                $pinjaman->jatuh_tempo =  date('Y-m-d', strtotime("+$pinjaman->jangka_waktu months", strtotime($date)));
                
                
            }
            if($setStatus=='Tolak'){
                $notifTitle = 'Maaf, pengajuan pinjaman anda ditolak.';
                $notifMessage = 'Harap bersabar ya. Mungkin Anda bisa melihat dibawah ini alasan dari pengajuan Anda ditolak. \n'.$request->get('alasan');

                $pinjaman->alasan_penolakan = $request->get('alasan');
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
                $notifTitle = 'Selamat pinjaman anda berhasil dicairkan.';
                $notifMessage = 'Selamat untuk anda. Pinjaman Anda berhasil dicairkan.';

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
                $pinjaman->id_user = auth()->user()->id;
                // $pinjaman->jatuh_tempo =  date('Y-m-d', strtotime("+$pinjaman->jangka_waktu months", strtotime($date)));
                // $nasabah = Nasabah::find($pinjaman->id_nasabah);
                // $hutang = $nasabah->hutang + $nasabah->limit_pinjaman;
                    // $nasabah->hutang -= $request->get('nominal_pembayaran');
                // $nasabah->hutang = $hutang;
                // $nasabah->limit_pinjaman = 0;
                // $nasabah->save();
                $nasabah = Nasabah::find($pinjaman->id_nasabah);
                $hutang = $nasabah->hutang + $nasabah->limit_pinjaman;
                    // $nasabah->hutang -= $request->get('nominal_pembayaran');
                $nasabah->hutang = $hutang;
                $nasabah->limit_pinjaman = 0;
                $nasabah->save();
            }
            if($setStatus=='Tolak'){
                $notifTitle = 'Maaf, proses pencairan gagal.';
                $notifMessage = 'Harap bersabar ya. Mungkin Anda bisa melihat dibawah ini alasan dari pengajuan Anda ditolak. \n'.$request->get('alasan_penolakan_pencairan');

                $pinjaman->alasan_penolakan_pencairan = $request->get('alasan_penolakan_pencairan');
                $pinjaman->status = $setStatus;

                $nasabah = Nasabah::find($pinjaman->id_nasabah);
                $nasabah->limit_pinjaman += $pinjaman->nominal;
                $nasabah->hutang -= $pinjaman->nominal;
                $nasabah->save();
            }
            $pinjaman->status_pencairan = $setStatus;
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
        $count = Pinjaman::select(\DB::raw("count('id') as ttl"))->where('view','0')->get();
        echo $count[0]->ttl;
    }
}
