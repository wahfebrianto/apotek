<?php

namespace App\Http\Controllers;

use App\Pengeluaran;
use App\User;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use \Auth, \Redirect, \Validator, \Input, \Session;

class MPengeluaranController extends Controller
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
      $pengeluaran = Pengeluaran::get();
      $users = User::get();
      return view('pengeluaran.index')->with(['pengeluaran' => $pengeluaran, 'users' => $users]);
  }

  public function create()
  {
      $users = User::get();
      return view('pengeluaran.create')->with(['users' => $users]);
  }

  public function store(Request $request)
  {
      $this->validate($request, [
        'tgl' => 'required',
        'nama' => 'required',
        'harga' => 'required',
        'keterangan' => 'required',
      ]);

      $pengeluaran = new Pengeluaran();
      $pengeluaran->id = Uuid::generate()->string;
      $pengeluaran->tgl = $request->input('tgl');
      $pengeluaran->nama = $request->input('nama');
      $pengeluaran->harga = intval(str_replace(['.',','],'',$request->input('harga')));
      $pengeluaran->keterangan = $request->input('keterangan');
      $pengeluaran->save();

      Session::flash('message', 'Pengeluaran baru telah ditambahkan');
      return Redirect::to('pengeluaran');
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'tgl' => 'required',
      'nama' => 'required',
      'harga' => 'required',
      'keterangan' => 'required',
    ]);

    $dataUbah = [
        'tgl' => $request->input('tgl'),
        'nama' => $request->input('nama'),
        'harga' => intval(str_replace(['.',','],'',$request->input('harga'))),
        'keterangan' => $request->input('keterangan')
    ];
    Pengeluaran::where('id',$id)->update($dataUbah);
    Session::flash('message', 'Pengeluaran berhasil diubah');
    return Redirect::to('pengeluaran');
  }

  public function destroy($id)
  {
      $pengeluaran = Pengeluaran::find($id);
      $pengeluaran->delete();
      Session::flash('message', 'Pengeluaran berhasil dihapus');
      return Redirect::to('pengeluaran');
  }

  public function edit($id)
  {
      $users = User::get();
      $pengeluaran = Pengeluaran::find($id);
      return view('pengeluaran.edit')->with(['pengeluaran' => $pengeluaran, 'users' => $users]);
  }
}
