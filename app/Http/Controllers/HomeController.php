<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\H_beli, App\D_beli, App\Pbf, App\Obat, App\Kartu_stok, App\Penerimaan;
use Webpatser\Uuid\Uuid;

class HomeController extends Controller
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
        $dataPembelian = H_beli::whereraw('DATEDIFF(tanggal_jatuh_tempo, CURDATE()) <= 7')->orderBy('tanggal_jatuh_tempo','asc')->get();
        $obatData = Obat::with('pamakologi')->get();
        $total_stok = array();
        for ($i=0; $i <sizeof($obatData) ; $i++) {
          $total_stok[] = Kartu_stok::where('id_obat',$obatData[$i]->id)->sum('jumlah');
        }
        return view('home')->with(['obatData'=>$obatData,'total_stok'=>$total_stok, 'dataPembelian'=>$dataPembelian]);
    }
}
