<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KategoriKriteria;

class KategoriKriteriaController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        try {
            $this->param['pageInfo'] = ' List Kategori Kriteria';
            $this->param['btnRight']['text'] = 'Tambah Data';
            $this->param['btnRight']['link'] = route('kategori-kriteria.create');

            $keyword = $request->get('keyword');

            if ($keyword) {
                $this->param['kategoriKriteria'] = KategoriKriteria::where('nama_kategori', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $this->param['kategoriKriteria'] = KategoriKriteria::paginate(10);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }

        return \view('kategori-kriteria.list-kategori-kriteria', $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = ' Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('kategori-kriteria.index');

        return \view('kategori-kriteria.tambah-kategori-kriteria', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required',
            // 'email' => 'required|email|unique:kategori-kriteria',
            // 'id_tipe' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute telah terdaftar'
        ]);
        try{
            $newKategoriKriteria = new KategoriKriteria;
            
            $newKategoriKriteria->nama_kategori = $request->get('nama_kategori');
            $newKategoriKriteria->save();

            return redirect()->route('kategori-kriteria.index')->withStatus('Data berhasil ditambahkan.');
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
            $this->param['pageInfo'] = ' Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('kategori-kriteria.index');
            $this->param['kategoriKriteria'] = KategoriKriteria::find($id);

            return \view('kategori-kriteria.edit-kategori-kriteria', $this->param);
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
        $kategoriKriteria = KategoriKriteria::find($id);
        $isUnique = $kategoriKriteria->nama_kategori == $request->get('nama_kategori') ? '' : '|unique:kategori_kriteria';

        $validatedData = $request->validate([
            'nama_kategori' => 'required'.$isUnique,
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute telah terdaftar'
        ]);


        try{
            $kategoriKriteria->nama_kategori = $request->get('nama_kategori');
            $kategoriKriteria->save();

            return redirect()->route('kategori-kriteria.index')->withStatus('Data berhasil diperbarui.');
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
            $kategoriKriteria = KategoriKriteria::findOrFail($id);

            $kategoriKriteria->delete();

            return redirect()->route('kategori-kriteria.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('kategori-kriteria.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('kategori-kriteria.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
