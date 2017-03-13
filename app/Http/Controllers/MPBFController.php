<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\Pbf;

class MPBFController extends Controller
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
        $pbfData = Pbf::get();
        return view('pbf.index')->with('pbfData',$pbfData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pbf.create');
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
              'nama' => 'required|unique:pbf|max:255',
              'alamat' => 'required|max:255',
              'telepon' => 'required|numeric',
              'nama_cp' => 'required|max:255',
              'telp_cp' => 'required|numeric',
        ]);

        $pbf = new Pbf;
        $pbf->nama = $request->nama;
        $pbf->alamat  = $request->alamat;
        $pbf->telepon = $request->telepon;
        $pbf->nama_cp = $request->nama_cp;
        $pbf->telp_cp = $request->telp_cp;
        $pbf->tergolong_pajak = is_null($request->tergolong_pajak) ? 0 : 1;
        $pbf->keterangan = $request->keterangan;
        $pbf->save();

        Session::flash('message', 'PBF baru telah ditambahkan.');
        return Redirect::to('pbf');
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
        $pbf = Pbf::find($id);
        return view('pbf.edit')->with('pbf', $pbf);
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
        $pbf = Pbf::find($id);

        $this->validate($request, [
              'nama' =>  ['required',Rule::unique('pbf')->ignore($pbf->id),],
              'alamat' => 'required|max:255',
              'telepon' => 'required|numeric',
              'nama_cp' => 'required|max:255',
              'telp_cp' => 'required|numeric',
        ]);

        $pbf->nama = $request->nama;
        $pbf->alamat  = $request->alamat;
        $pbf->telepon = $request->telepon;
        $pbf->nama_cp = $request->nama_cp;
        $pbf->telp_cp = $request->telp_cp;
        $pbf->tergolong_pajak = is_null($request->tergolong_pajak) ? 0 : 1;
        $pbf->keterangan = $request->keterangan;
        $pbf->save();

        Session::flash('message', 'PBF baru telah diupdate.');
        return Redirect::to('pbf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pbf = Pbf::find($id);
        Session::flash('message', 'PBF '.$pbf->nama.' telah berhasil dihapus.');
        $pbf->delete();
        return Redirect::to('pbf');
    }
}
