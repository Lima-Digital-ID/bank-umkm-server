<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pelunasan;
use \App\Models\Pinjaman;
use Illuminate\Support\Facades\DB;

class PelunasanController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List Pelunasan';
        // $this->param['btnRight']['text'] = 'Tambah Data';
        // $this->param['btnRight']['link'] = route('pelunasan.create');

        try {
            $keyword = $request->get('keyword');
            // if ($keyword) {
            //     $pelunasan = Pelunasan::where('nama', 'LIKE', "%$keyword%")->orWhere('nik', 'LIKE', "%$keyword%")->paginate(10);
            // }
            // else{
                $pelunasan = Pelunasan::select('pelunasan.id','pelunasan.id_pinjaman','pelunasan.tanggal_pembayaran', 'pelunasan.nominal_pembayaran', 'pelunasan.cicilan_ke', 'nasabah.nama')->join('pinjaman', 'pinjaman.id', '=', 'pelunasan.id_pinjaman')->join('nasabah', 'nasabah.id', '=', 'pinjaman.id_nasabah')->where('pelunasan.status', 'Lunas');

                if (auth()->user()->level != 'Administrator') {
                    $pelunasan->where('pinjaman.id_kantor_cabang', auth()->user()->id_kantor_cabang);
                }

                $this->param['pelunasan'] = $pelunasan->paginate(10);
            // }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan'. $e->getMessage());
        }
                
        return \view('pelunasan.list-pelunasan', $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('pelunasan.index');

        return \view('pelunasan.tambah-pelunasan', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pinjaman' => 'required',
            'tanggal_pembayaran' => 'required|date',
            'nominal' => 'required',
            'cicilan_ke' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);
        try{
            $newPelunasan = new Pelunasan;

            $newPelunasan->id_pinjaman = $request->get('id_pinjaman');
            $newPelunasan->tanggal_pembayaran = $request->get('tanggal_pembayaran');
            $newPelunasan->nominal = $request->get('nominal');
            $newPelunasan->cicilan_ke = $request->get('cicilan_ke');

            return redirect()->route('pelunasan.index')->withStatus('Data berhasil ditambahkan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function show($idPinjaman)
    {
        try{
            $this->param['pageInfo'] = 'Detail';
            // $this->param['btnRight']['text'] = 'Lihat Data';
            // $this->param['btnRight']['link'] = route('pelunasan.index');
            $this->param['pinjaman'] = Pinjaman::with('nasabah', 'pelunasan')->find($idPinjaman);
            // $this->param['pelunasan'] = Pelunasan::where('id_pinjaman', $idPinjaman)->orderBy('tanggal_pembayaran')->get();
         return \view('pelunasan.detail-pelunasan', $this->param);
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
            $this->param['btnRight']['link'] = route('pelunasan.index');
            $this->param['pelunasan'] = Pelunasan::find($id);

            return \view('pelunasan.edit-pelunasan', $this->param);
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
        $validatedData = $request->validate([
            'id_pinjaman' => 'required',
            'tanggal_pembayaran' => 'required|date',
            'nominal' => 'required',
            'cicilan_ke' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);
        try{
            $pelunasan = Pelunasan::find($id);

            $pelunasan->id_pinjaman = $request->get('id_pinjaman');
            $pelunasan->tanggal_pembayaran = $request->get('tanggal_pembayaran');
            $pelunasan->nominal = $request->get('nominal');
            $pelunasan->cicilan_ke = $request->get('cicilan_ke');

            return redirect()->route('pelunasan.index')->withStatus('Data berhasil diperbarui.');
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
            $pelunasan = Pelunasan::findOrFail($id);

            // update terbayar
            $pinjaman = Pinjaman::find($pelunasan->id_pinjaman);
            $pinjaman->terbayar -= $pelunasan->nominal;
            $pinjaman->save();

            // delete pelunasan
            $pelunasan->delete();

            return redirect()->route('pelunasan.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('pelunasan.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('pelunasan.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }

    public function latePayment(Request $request)
    {
        
        $this->param['pageInfo'] = 'List Pembayaran Terlambat';
        // $this->param['btnRight']['text'] = 'Tambah Data';
        // $this->param['btnRight']['link'] = route('pelunasan.create');

        try {
            $date = date('Y-m-d');
            $keyword = $request->get('keyword');
            $latePayment= Pelunasan::with('pinjaman.nasabah')
                                                        ->where('jatuh_tempo_cicilan', '<', $date)
                                                        ->where('pelunasan.status', 'Belum');
            if ($keyword) {
                $latePayment->whereHas('pinjaman.nasabah', function ($query) use ($keyword) {
                    return $query->where('nama', 'LIKE', "$keyword");
                });
            }

            if (auth()->user()->level != 'Administrator') {
                $latePayment->where('pinjaman.id_kantor_cabang', auth()->user()->id_kantor_cabang);
            }

            $this->param['latePayment'] = $latePayment->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan'. $e->getMessage());
        }
                
        return \view('pelunasan.list-late-payment', $this->param);
        

        // echo "<pre>";
        // print_r ($this->param['latePayment']);
        // echo "</pre>";
        
    }
}
