<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.index')->with(["report"=>""]);
    }

    public function generate(Request $request)
    {
        $data["jenislaporan"] = $request->jenislaporan;
        $data["rangelaporan"] = $request->rangelaporan;
        $data["tglawal"] = $request->tglawal;
        $data["tglakhir"] = $request->tglakhir;
        $data["bulan"] = $request->bulan;
        return view('laporan.index')->with(["report"=>"", "data" => $data]);
    }
}
