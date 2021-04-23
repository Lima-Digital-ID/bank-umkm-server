<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;

class UserController extends Controller
{
    private $param;

    public function index(Request $request)
    {
        $this->param['pageInfo'] = 'Manage User / List User';
        $this->param['btnRight']['text'] = 'Tambah Data';
        $this->param['btnRight']['link'] = route('user.create');

        try {
            $keyword = $request->get('keyword');
            if ($keyword) {
                $user = User::where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")->paginate(10);
            }
            else{
                $user = User::paginate(10);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withStatus('Terjadi Kesalahan');
        }
                
        return \view('user.list-user', ['user' => $user], $this->param);
    }

    public function create()
    {
        $this->param['pageInfo'] = 'Manage User / Tambah Data';
        $this->param['btnRight']['text'] = 'Lihat Data';
        $this->param['btnRight']['link'] = route('user.index');

        return \view('user.tambah-user', $this->param);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users',
        ],
        [
            'required' => ':attribute tidak boleh kosong.',
            'email' => 'Masukan email yang valid.',
            'unique' => ':attribute telah terdaftar'
        ],
        [
            'name' => 'name',
            'username' => 'Username',
            'email' => 'Alamat email',
        ]);
        try{
            $newUser = new User;
    
            $newUser->name = $request->get('name');
            $newUser->username = $request->get('username');
            $newUser->email = $request->get('email');
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
            $this->param['pageInfo'] = 'Manage User / Edit Data';
            $this->param['btnRight']['text'] = 'Lihat Data';
            $this->param['btnRight']['link'] = route('user.index');
            $this->param['user'] = User::find($id);

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
            'name' => 'required',
            'username' => 'required|'.$isUniqueUsername,
            'email' => 'required|email'.$isUnique,
        ],
        [
            'name.required' => ':attribute tidak boleh kosong.',
            'username.required' => ':attribute tidak boleh kosong.',
            'email.required' => ':attribute tidak boleh kosong.'
        ],
        [
           'name' => 'name',
           'username' => 'Username',
           'email' => 'Email' 
        ]);
        try{

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->username = $request->get('username');
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
