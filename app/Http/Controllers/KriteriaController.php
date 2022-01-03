<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KategoriKriteria;
use \App\Models\Kriteria;

class KriteriaController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        try {
            $this->param['pageInfo'] = ' List  Kriteria';
            $this->param['btnRight']['text'] = 'Tambah Data';
            $this->param['btnRight']['link'] = route('kriteria.create');

            $keyword = $request->get('keyword');

            if ($keyword) {
                $this->param['kriteria'] = Kriteria::with('kategoriKriteria')->where('nama_kriteria', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $this->param['kriteria'] = Kriteria::with('kategoriKriteria')->paginate(10);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }

        return \view('kriteria.list-kriteria', $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = ' Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('kriteria.index');
        $this->param['kategoriKriteria'] = KategoriKriteria::get();

        return \view('kriteria.tambah-kriteria', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kriteria' => 'required',
            'id_kategori' => 'required',
            // 'email' => 'required|email|unique:kriteria',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);
        try{
            $newKriteria = new Kriteria;
            
            $newKriteria->nama_kriteria = $request->get('nama_kriteria');
            $newKriteria->id_kategori = $request->get('id_kategori');
            $newKriteria->save();

            return redirect()->route('kriteria.index')->withStatus('Data berhasil ditambahkan.');
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
            $this->param['btnRight']['link'] = route('kriteria.index');
            $this->param['kategoriKriteria'] = KategoriKriteria::get();
            $this->param['kriteria'] = Kriteria::find($id);

            return \view('kriteria.edit-kriteria', $this->param);
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
        $kategoriKriteria = Kriteria::find($id);
        $isUnique = $kategoriKriteria->nama_kriteria == $request->get('nama_kriteria') ? '' : '|unique:kriteria';

        $validatedData = $request->validate([
            'nama_kriteria' => 'required'.$isUnique,
            'id_kategori' => 'required'
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
        ]);


        try{
            $kategoriKriteria->nama_kriteria = $request->get('nama_kriteria');
            $kategoriKriteria->id_kategori = $request->get('id_kategori');
            $kategoriKriteria->save();

            return redirect()->route('kriteria.index')->withStatus('Data berhasil diperbarui.');
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
            $kategoriKriteria = Kriteria::findOrFail($id);

            $kategoriKriteria->delete();

            return redirect()->route('kriteria.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('kriteria.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('kriteria.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
