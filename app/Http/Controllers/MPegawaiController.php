<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use \Auth, \Redirect, \Validator, \Input, \Session;

class MPegawaiController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('ckadmin');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $users = \App\User::get();
      return view('pegawai.index')->with('users', $users);
  }

  public function create()
  {
      return view('pegawai.create');
  }

  public function store(Request $request)
  {
      $this->validate($request, [
        'nama' => 'required',
        'alamat' => 'required',
        'telepon' => 'required',
        'gaji' => 'required|numeric',
        'username' => 'required|alpha_dash',
        'password' => 'required|min:6|confirmed',
      ]);

      $user = new User();
      $user->nama = $request->input('nama');
      $user->alamat = $request->input('alamat');
      $user->telepon = $request->input('telepon');
      $user->gaji = $request->input('gaji');
      $user->username = $request->input('username');
      $user->password = bcrypt($request->input('password'));
      $user->save();

      Session::flash('message', 'Pegawai baru telah ditambahkan.');
      return Redirect::to('pegawai');
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'nama' => 'required',
      'alamat' => 'required',
      'telepon' => 'required',
      'gaji' => 'required|numeric',
      'username' => 'required|alpha_dash',
      'password' => 'required|min:6|confirmed',
    ]);

    $dataUbah = [
        'nama' => $request->input('nama'),
        'alamat' => $request->input('alamat'),
        'telepon' => $request->input('telepon'),
        'gaji' => $request->input('gaji'),
        'username' => $request->input('username'),
        'password' => $request->input('password')
    ];
    User::where('id',$id)->update($dataUbah);
    Session::flash('message', 'Pegawai berhasil diubah.');
    return Redirect::to('pegawai');
  }

  public function destroy($id)
  {
      if($id == 1)
      {
        Session::flash('message', 'Anda tidak dapat menghapus admin.');
        Session::flash('alert-class', 'alert-danger');
                return Redirect::to('pegawai');
      }
      else
      {
        $user = User::find($id);
        $user->delete();
        Session::flash('message', 'Pegawai berhasil dihapus.');
        return Redirect::to('pegawai');
      }
  }

  public function edit($id)
  {
      $pegawai = User::find($id);
      return view('pegawai.edit')
          ->with('pegawai', $pegawai);
  }
}
