<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Option;
use \App\Models\Kriteria;
class OptionController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        try {
            $this->param['pageInfo'] = ' List  Option';
            $this->param['btnRight']['text'] = 'Tambah Data';
            $this->param['btnRight']['link'] = route('option.create');

            $keyword = $request->get('keyword');

            if ($keyword) {
                $this->param['option'] = Option::with('kriteria')->where('option', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $this->param['option'] = Option::with('kriteria')->paginate(10);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }

        return \view('option.list-option', $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = ' Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('option.index');
        $this->param['kriteria'] = Kriteria::get();

        return \view('option.tambah-option', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'option' => 'required',
            'id_kriteria' => 'required',
            'skor' => 'required|numeric|gt:0',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'numeric' => ':attribute harus berupa angka.',
            'gt' => ':attribute harus diatas 0.',
        ]);
        try{
            $newOption = new Option;
            
            $newOption->option = $request->get('option');
            $newOption->id_kriteria = $request->get('id_kriteria');
            $newOption->skor = $request->get('skor');
            $newOption->save();

            return redirect()->route('option.index')->withStatus('Data berhasil ditambahkan.');
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
            $this->param['btnRight']['link'] = route('option.index');
            $this->param['kriteria'] = Kriteria::get();
            $this->param['option'] = Option::find($id);

            return \view('option.edit-option', $this->param);
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
        $option = Option::find($id);
        $isUnique = $option->option == $request->get('option') ? '' : '|unique:option';

        $validatedData = $request->validate([
            'option' => 'required'.$isUnique,
            'id_kriteria' => 'required',
            'skor' => 'required|numeric|gt:0',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'numeric' => ':attribute harus berupa angka.',
            'gt' => ':attribute harus diatas 0.',
        ]);


        try{
            $option->option = $request->get('option');
            $option->id_kriteria = $request->get('id_kriteria');
            $option->skor = $request->get('skor');
            $option->save();

            return redirect()->route('option.index')->withStatus('Data berhasil diperbarui.');
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
            $option = Option::findOrFail($id);

            $option->delete();

            return redirect()->route('option.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('option.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('option.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
