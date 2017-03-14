<?php

namespace App\Http\Controllers;

use App\Log;
use App\Obat;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use \Auth, \Redirect, \Validator, \Input, \Session;

class MLogController extends Controller
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
      $log = Log::get();
      return view('log.index', compact('log'));
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'obat' => 'required',
      'keterangan' => 'required',
    ]);
    $dataUbah = [
        'id_obat' => $request->input('obat'),
        'keterangan' => $request->input('keterangan')
    ];
    Log::where('id',$id)->update($dataUbah);
    Session::flash('message', 'Log berhasil diubah');
    return Redirect::to('log');
  }

  public function destroy($id)
  {
      $log = Log::find($id);
      $log->delete();
      Session::flash('message', 'Log berhasil dihapus');
      return Redirect::to('log');
  }

  public function edit($id)
  {
      $obat = Obat::get();
      $log = Log::find($id);
      return view('log.edit')->with(['log' => $log, 'obat' => $obat]);
  }
}
