<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\KantorCabang;

class UserController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'List User';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('user.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $user = User::with(['kantorCabang.kecamatan'])->where('nama', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $user = User::with('kantorCabang.kecamatan')->paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }
                
        return \view('user.list-user', ['user' => $user], $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('user.index');
        $this->param['kantorCabang'] = KantorCabang::with('kecamatan')->get();
        return \view('user.tambah-user', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users',
            'level' => 'required',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar'
        ],
        [
            'nama' => 'Nama',
            'username' => 'Username',
            'email' => 'Alamat email',
            'level' => 'Level',
        ]);
        try{
            $newUser = new User;
    
            $newUser->nama = $request->get('nama');
            $newUser->username = $request->get('username');
            $newUser->email = $request->get('email');
            $newUser->level = $request->get('level');
            $newUser->id_kantor_cabang = $request->get('id_kantor_cabang');
            $newUser->password = \Hash::make($request->get('username'));

            $newUser->save();

            return redirect()->route('user.index')->withStatus('Data berhasil ditambahkan.');
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
            $this->param['pageInfo'] = 'Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('user.index');
            $this->param['user'] = User::find($id);
            $this->param['kantorCabang'] = KantorCabang::with('kecamatan')->get();

            return \view('user.edit-user', $this->param);
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
        $user = User::find($id);

        $isUnique = $user->email == $request->email ? '' : '|unique:users,email';
        $isUniqueUsername = $user->username == $request->username ? '' : '|unique:users,username';
        $validatedData = $request->validate([
            'nama' => 'required',
            'username' => 'required|'.$isUniqueUsername,
            'email' => 'required|email'.$isUnique,
        ],
        [
            'nama.required' => ':attribute tidak boleh kosong.',
            'username.required' => ':attribute tidak boleh kosong.',
            'email.required' => ':attribute tidak boleh kosong.'
        ],
        [
           'nama' => 'Nama',
           'username' => 'Username',
           'email' => 'Email' 
        ]);
        try{

            $user->nama = $request->get('nama');
            $user->email = $request->get('email');
            $user->username = $request->get('username');
            $user->level = $request->get('level');
            $user->id_kantor_cabang = $request->get('id_kantor_cabang');
            // $user->akses = $request->get('akses');
            $user->save();

            return redirect()->route('user.index')->withStatus('Data berhasil diperbarui.');
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
            $user = User::findOrFail($id);

            $user->delete();

            return redirect()->route('user.index')->withStatus('Data berhasil dihapus.');
        }
        catch(\Exception $e){
            return redirect()->route('user.index')->withError('Terjadi kesalahan : '. $e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('user.index')->withError('Terjadi kesalahan pada database : '. $e->getMessage());
        }
        
    }
}
