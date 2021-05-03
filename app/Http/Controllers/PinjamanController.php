<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pinjaman;
use \App\Models\Nasabah;

class PinjamanController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Manage Pinjaman / List Pinjaman';
        // $this->param['btnRight']['text'] = 'Tambah Data';
        // $this->param['btnRight']['link'] = route('pinjaman.create');
        $tipe = 'Pending';
        if ($request->get('t')) {
            $tipe = $request->get('t');
        }

        try {
            $this->param['pinjaman'] = Pinjaman::with('nasabah')->where('status', $tipe)->paginate(10);
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
            $this->param['pageInfo'] = 'Manage Pinjaman / Detail';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('pinjaman.index');
            $this->param['pinjaman'] = Pinjaman::with('nasabah')->find($id);

            return \view('pinjaman.detail-pinjaman', $this->param);
            
            
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
            $this->param['pageInfo'] = 'Manage Pinjaman / Edit Data';
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

    public function updateStatus(Request $request, $id)
    {
        try{
            $pinjaman = Pinjaman::find($id);
            $setStatus = $request->get('status');
            if ($setStatus == 'Terima') {
                $date = date('Y-m-d');
                $pinjaman->tanggal_diterima = $date;
                $pinjaman->id_user = auth()->user()->id;
                $pinjaman->tanggal_batas_pelunasan =  date('Y-m-d', strtotime("+$pinjaman->jangka_waktu months", strtotime($date)));
            }
            $pinjaman->status = $setStatus;
            $pinjaman->save();

            $nasabah = Nasabah::find($pinjaman->id_nasabah);
            $nasabah->saldo += $pinjaman->nominal;
            $nasabah->hutang += $pinjaman->nominal;
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
}
