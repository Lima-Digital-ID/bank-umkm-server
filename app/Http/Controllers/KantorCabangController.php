<?php

namespace App\Http\Controllers;

use App\Models\KantorCabang;
use App\Models\WilayahKecamatan;
use Illuminate\Http\Request;

class KantorCabangController extends Controller
{
    private $param;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List Kantor Cabang';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('kantor-cabang.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $this->param['kantorCabang'] = KantorCabang::select('kantor_cabang.*', 'wilayah_kecamatan.nama AS nama_kecamatan')->join('wilayah_kecamatan', 'wilayah_kecamatan.id', 'kantor_cabang.kecamatan_id')->where('kantor_cabang.nama', 'LIKE', "%$keyword%")->orWhere('kantor_cabang.alamat', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $this->param['kantorCabang'] = KantorCabang::select('kantor_cabang.*', 'wilayah_kecamatan.nama AS nama_kecamatan')->join('wilayah_kecamatan', 'wilayah_kecamatan.id', 'kantor_cabang.kecamatan_id')->paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi Kesalahan');
        }
                
        return \view('kantor-cabang.list-kantor-cabang', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageInfo'] = 'Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('kantor-cabang.index');
        $this->param['kecamatan'] = WilayahKecamatan::select('wilayah_kecamatan.*', 'wilayah_provinsi.nama AS nama_provinsi', 'wilayah_kabupaten.nama AS nama_kabupaten')
                                                        ->join('wilayah_kabupaten', 'wilayah_kabupaten.id', 'wilayah_kecamatan.kabupaten_id')
                                                        ->join('wilayah_provinsi', 'wilayah_provinsi.id', 'wilayah_kabupaten.provinsi_id')                                            
                                                        ->where('wilayah_provinsi.nama', 'Jawa Timur')
                                                        ->orderBy('wilayah_kecamatan.nama', 'ASC')->get();

        return \view('kantor-cabang.tambah-kantor-cabang', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'id_kecamatan' => 'required|not_in:0',
            'alamat' => 'required|min:10',
            'phone' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'not_in' => ':attribute belum dipilih.',
            'alamat.min' => 'Minimal jumlah karakter adalah 10.'
        ],
        [
            'nama' => 'Nama Kantor Cabang',
            'id_kecamatan' => 'Kecamatan',
            'alamat' => 'Alamat Kantor Cabang',
            'phone' => 'Nomor Telepon'
        ]);
        try{
            $newKantorCabang = new KantorCabang;
    
            $newKantorCabang->nama = $request->get('nama');
            $newKantorCabang->kecamatan_id = $request->get('id_kecamatan');
            $newKantorCabang->alamat = $request->get('alamat');
            $newKantorCabang->phone = $request->get('phone');

            $newKantorCabang->save();

            return redirect()->route('kantor-cabang.index')->withStatus('Data berhasil ditambahkan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->param['pageInfo'] = 'Edit Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('kantor-cabang.index');
        $this->param['kecamatan'] = WilayahKecamatan::select('wilayah_kecamatan.*', 'wilayah_provinsi.nama AS nama_provinsi', 'wilayah_kabupaten.nama AS nama_kabupaten')
                                                        ->join('wilayah_kabupaten', 'wilayah_kabupaten.id', 'wilayah_kecamatan.kabupaten_id')
                                                        ->join('wilayah_provinsi', 'wilayah_provinsi.id', 'wilayah_kabupaten.provinsi_id')                                            
                                                        ->where('wilayah_provinsi.nama', 'Jawa Timur')
                                                        ->orderBy('wilayah_kecamatan.nama', 'ASC')->get();
        $this->param['kantorCabang'] = KantorCabang::select('kantor_cabang.*', 'wilayah_kecamatan.nama AS nama_kecamatan')->join('wilayah_kecamatan', 'wilayah_kecamatan.id', 'kantor_cabang.kecamatan_id')->find($id);

        return \view('kantor-cabang.edit-kantor-cabang', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required|min:10',
            'phone' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'not_in' => ':attribute belum dipilih.',
            'alamat.min' => 'Minimal jumlah karakter adalah 10.'
        ],
        [
            'nama' => 'Nama Kantor Cabang',
            'alamat' => 'Alamat Kantor Cabang',
            'phone' => 'Nomor Telepon'
        ]);
        try{
            $updateKantorCabang = KantorCabang::find($id);
    
            $updateKantorCabang->nama = $request->get('nama');
            if ($request->get('id_kecamatan') != 0) {
                $updateKantorCabang->kecamatan_id = $request->get('id_kecamatan');
            }
            $updateKantorCabang->alamat = $request->get('alamat');
            $updateKantorCabang->phone = $request->get('phone');

            $updateKantorCabang->save();

            return redirect()->route('kantor-cabang.index')->withStatus('Data berhasil disimpan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan. : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $deleteKantorCabang = KantorCabang::findOrFail($id);

            $deleteKantorCabang->delete();

            return redirect()->route('kantor-cabang.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('kantor-cabang.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('kantor-cabang.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
    }
}
