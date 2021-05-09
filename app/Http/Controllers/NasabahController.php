<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Nasabah;
use \App\Models\TipeNasabah;

class NasabahController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Manage Nasabah / List Nasabah';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('nasabah.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $nasabah = Nasabah::with('tipe')->with('dataTambahan')->where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $nasabah = Nasabah::with('tipe')->with('dataTambahan')->select('id', 'nama', 'jenis_kelamin', 'nik','email', 'is_verified')->paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }
        
        // echo "<pre>";
        // print_r ($nasabah);
        // echo "</pre>";
        
        return \view('nasabah.list-nasabah', ['nasabah' => $nasabah], $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Manage Nasabah / Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('nasabah.index');
        $this->param['tipeNasabah'] = TipeNasabah::get();

        return \view('nasabah.tambah-nasabah', $this->param);
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
            // 'email' => 'required|email|unique:nasabah',
            // 'id_tipe' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar'
        ]);
        try{
            $newNasabah = new Nasabah;

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
            
            $newNasabah->nama = $request->get('nama');
            $newNasabah->tanggal_lahir = $request->get('tanggal_lahir');
            $newNasabah->jenis_kelamin = $request->get('jenis_kelamin');
            $newNasabah->nik = $request->get('nik');
            $newNasabah->no_hp = $request->get('no_hp');
            $newNasabah->alamat = $request->get('alamat');
            $newNasabah->id_tipe = $request->get('id_tipe');
            // $newNasabah->profil = $newProfil;
            $newNasabah->scan_ktp = $newScanKtp;
            $newNasabah->foto_dengan_ktp = $newSelfie;
            $newNasabah->npwp = $newNpwp;
            $newNasabah->surat_nikah = $newSuratNikah;
            $newNasabah->surat_domisili_usaha = $newSuratDomisiliUsaha;
            $newNasabah->username = $request->get('nik');
            $newNasabah->email = $request->get('email');
            $newNasabah->password = \Hash::make($request->get('nik'));

            if($newNasabah->save()){
                // $profil->move($uploadPath, $newProfil);
                $scanKtp->move($uploadPath, $newScanKtp);
                $selfie->move($uploadPath, $newSelfie);
                $npwp->move($uploadPath, $newNpwp);
                $suratNikah->move($uploadPath, $newSuratNikah);
                $suratDomisiliUsaha->move($uploadPath, $newSuratDomisiliUsaha);

                return redirect()->route('nasabah.index')->withStatus('Data berhasil ditambahkan.');
            }

            return redirect()->route('nasabah.index')->withStatus('Data berhasil ditambahkan.');
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
            $this->param['pageInfo'] = 'Manage Nasabah / Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('nasabah.index');
            $this->param['nasabah'] = Nasabah::with('tipe')->find($id);

            return \view('nasabah.detail-nasabah', $this->param);
            
            // echo "<pre>";
            // print_r ($this->param['nasabah']);
            // echo "</pre>";
            
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
            $this->param['pageInfo'] = 'Manage Nasabah / Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('nasabah.index');
            $this->param['tipeNasabah'] = TipeNasabah::get();
            $this->param['nasabah'] = Nasabah::find($id);

            return \view('nasabah.edit-nasabah', $this->param);
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try{
            $nasabah = Nasabah::find($id);
            if($request->tipe=="acc"){
                $nasabah->limit_pinjaman = $request->get('limit');
                $nasabah->alasan_penolakan = "";
                $nasabah->is_verified = 1;
            }
            else if($request->tipe=="tolak"){
                $nasabah->alasan_penolakan = $request->get('alasan');
                $nasabah->is_verified = 3;
            }
            $nasabah->save();

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
        $nasabah = Nasabah::find($id);

        $isUnique = $nasabah->email == $request->email ? '' : '|unique:nasabah';
        $isUniqueNik = $nasabah->nik == $request->nik ? '' : '|unique:nasabah';
        // $isUniqueUsername = $nasabah->username == $request->username ? '' : '|unique:nasabah';
        $validatedData = $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'nik' => 'required'.$isUniqueNik,
            'no_hp' => 'required',
            'alamat' => 'required',
            // 'email' => 'required|email'.$isUnique,
            // 'id_tipe' => 'required',
            'status' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar.'
        ]);
        try{

            $uploadPath = 'upload/nasabah/'.$nasabah->nik;

            if ($request->file('scan_ktp')) {
                $scanKtp = $request->file('scan_ktp');
                $newScanKtp = time().'_'.$scanKtp->getClientOriginalName(); 
            }

            if ($request->file('foto_dengan_ktp')) {
                $selfie = $request->file('foto_dengan_ktp');
                $newSelfie = time().'_'.$selfie->getClientOriginalName(); 
            }

            if ($request->file('npwp')) {
                $npwp = $request->file('npwp');
                $newNpwp = time().'_'.$npwp->getClientOriginalName(); 
            }

            if ($request->file('surat_nikah')) {
                $suratNikah = $request->file('surat_nikah');
                $newSuratNikah = time().'_'.$suratNikah->getClientOriginalName(); 
            }

            if ($request->file('surat_domisili_usaha')) {
                $suratDomisiliUsaha = $request->file('surat_domisili_usaha');
                $newSuratDomisiliUsaha = time().'_'.$suratDomisiliUsaha->getClientOriginalName();
            }
            
            $nasabah->nama = $request->get('nama');
            $nasabah->tanggal_lahir = $request->get('tanggal_lahir');
            $nasabah->jenis_kelamin = $request->get('jenis_kelamin');
            $nasabah->nik = $request->get('nik');
            $nasabah->no_hp = $request->get('no_hp');
            $nasabah->alamat = $request->get('alamat');
            // $nasabah->id_tipe = $request->get('id_tipe');
            // $nasabah->profil = $newProfil;
            if ($request->file('scan_ktp') || $request->file('foto_dengan_ktp') || $request->file('npwp') || $request->file('surat_nikah') || $request->file('surat_domisili_usaha') ) {
                $nasabah->scan_ktp = $newScanKtp;
                $nasabah->foto_dengan_ktp = $newSelfie;
                $nasabah->npwp = $newNpwp;
                $nasabah->surat_nikah = $newSuratNikah;
                $nasabah->surat_domisili_usaha = $newSuratDomisiliUsaha;
            }
            $nasabah->username = $request->get('username');
            // $nasabah->email = $request->get('email');
            $nasabah->is_verified = $request->get('status');

            if($nasabah->save()){
                if ($request->file('scan_ktp') || $request->file('foto_dengan_ktp') || $request->file('npwp') || $request->file('surat_nikah') || $request->file('surat_domisili_usaha') ) {
                    $scanKtp->move($uploadPath, $newScanKtp);
                    $selfie->move($uploadPath, $newSelfie);
                    $npwp->move($uploadPath, $newNpwp);
                    $suratNikah->move($uploadPath, $newSuratNikah);
                    $suratDomisiliUsaha->move($uploadPath, $newSuratDomisiliUsaha);
                }
            }

            return redirect()->route('nasabah.index')->withStatus('Data berhasil diperbarui.');
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
            $nasabah = Nasabah::findOrFail($id);

            $nasabah->delete();

            return redirect()->route('nasabah.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('nasabah.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('nasabah.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
