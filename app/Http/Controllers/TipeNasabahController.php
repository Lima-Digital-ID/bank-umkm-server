<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TipeNasabah;
class TipeNasabahController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Tipe Nasabah / List Tipe Nasabah';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('tipe-nasabah.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $tipeNasabah = TipeNasabah::where('nama', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $tipeNasabah = TipeNasabah::paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }
                
        return \view('tipe-nasabah.list-tipe-nasabah', ['tipeNasabah' => $tipeNasabah], $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Tipe Nasabah / Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('tipe-nasabah.index');

        return \view('tipe-nasabah.tambah-tipe-nasabah', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipe' => 'required|unique:tipe_nasabah',
            'limit_pinjaman' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute telah terdaftar.'
        ]);
        try{
            $newTipeNasabah = new TipeNasabah;
    
            $newTipeNasabah->tipe = $request->get('tipe');
            $newTipeNasabah->limit_pinjaman = $request->get('limit_pinjaman');

            $newTipeNasabah->save();

            return redirect()->route('tipe-nasabah.index')->withStatus('Data berhasil ditambahkan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    public function edit($id)
    {
        try{
            $this->param['pageInfo'] = 'Tipe Nasabah / Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('tipe-nasabah.index');
            $this->param['tipeNasabah'] = TipeNasabah::find($id);

            return \view('tipe-nasabah.edit-tipe-nasabah', $this->param);
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
        $tipeNasabah = TipeNasabah::find($id);

        $isUnique = $tipeNasabah->tipe == $request->tipe ? '' : '|unique:tipe_nasabah';
        $validatedData = $request->validate([
            'tipe' => 'required'.$isUnique,
            'limit_pinjaman' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute telah terdaftar.'
        ]);
        try{

            $tipeNasabah->tipe = $request->get('tipe');
            $tipeNasabah->limit_pinjaman = $request->get('limit_pinjaman');
            $tipeNasabah->save();

            return redirect()->route('tipe-nasabah.index')->withStatus('Data berhasil diperbarui.');
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
            $tipeNasabah = TipeNasabah::findOrFail($id);

            $tipeNasabah->delete();

            return redirect()->route('tipe-nasabah.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('tipe-nasabah.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('tipe-nasabah.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
