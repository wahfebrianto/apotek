<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\Obat, App\Pamakologi;
use Webpatser\Uuid\Uuid;

class MObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ckadmin');
    }

    public function index()
    {
        $obatData = Obat::with('pamakologi')->get();
        return view('obat.index')->with('obatData',$obatData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pamakologiData = Pamakologi::get();
        return view('obat.create')->with('pamakologiData',$pamakologiData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
              'nama' => 'required',
              'dosis' => 'required',
              'bentuk_sediaan' => 'required',
              'harga_jual' => 'required',
        ]);

        $obat = new Obat;
        $obat->id = Uuid::generate()->string;
        $obat->nama = $request->nama;
        $obat->id_pamakologi = $request->id_pamakologi;
        $obat->dosis = $request->dosis;
        $obat->bentuk_sediaan = $request->bentuk_sediaan;
        $obat->harga_jual = $request->harga_jual;
        $obat->keterangan = $request->keterangan;
        $obat->save();

        Session::flash('message', 'Obat baru telah ditambahkan.');
        return Redirect::to('obat');
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
        $pamakologiData = Pamakologi::get();
        $obat = Obat::find($id);
        return view('obat.edit')->with(['pamakologiData'=>$pamakologiData,'obat'=>$obat]);
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
        $obat = Obat::find($id);
        $this->validate($request, [
              'nama' => 'required',
              'dosis' => 'required',
              'bentuk_sediaan' => 'required',
              'harga_jual' => 'required',
        ]);

        $obat->nama = $request->nama;
        $obat->id_pamakologi = $request->id_pamakologi;
        $obat->dosis = $request->dosis;
        $obat->bentuk_sediaan = $request->bentuk_sediaan;
        $obat->harga_jual = $request->harga_jual;
        $obat->keterangan = $request->keterangan;
        $obat->save();

        Session::flash('message', 'Obat baru telah diupdate.');
        return Redirect::to('obat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $obat = Obat::find($id);
      Session::flash('message', 'Obat '.$obat->nama.' telah berhasil dihapus.');
      $obat->delete();
      return Redirect::to('obat');
    }
}
