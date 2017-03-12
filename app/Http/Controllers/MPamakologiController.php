<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\Pamakologi;

class MPamakologiController extends Controller
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
        $pamakologiData = Pamakologi::get();
        return view('pamakologi.index')->with('pamakologiData',$pamakologiData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pamakologi.create');
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
              'nama' => 'required|unique:pamakologi|max:255',
        ]);

        $pamakologi = new Pamakologi;
        $pamakologi->nama = $request->nama;
        $pamakologi->keterangan = $request->keterangan;
        $pamakologi->save();

        Session::flash('message', 'Pamakologi baru telah ditambahkan.');
        return Redirect::to('pamakologi');
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
        $pamakologi = Pamakologi::find($id);
        return view('pamakologi.edit')->with('pamakologi', $pamakologi);
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
      $pamakologi = Pamakologi::find($id);

      $this->validate($request, [
            'nama' =>  ['required',Rule::unique('pamakologi')->ignore($pamakologi->id),],
      ]);
      $pamakologi->nama = $request->nama;
      $pamakologi->keterangan = $request->keterangan;
      $pamakologi->save();

      Session::flash('message', 'Pamakologi baru telah diupdate.');
      return Redirect::to('pamakologi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $pamakologi = Pamakologi::find($id);
      Session::flash('message', 'Pamakologi '.$pamakologi->nama.' telah berhasil dihapus.');
      $pamakologi->delete();
      return Redirect::to('pamakologi');
    }
}
