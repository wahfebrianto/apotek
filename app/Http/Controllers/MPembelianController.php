<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\H_beli, App\Pbf;
use Webpatser\Uuid\Uuid;

class MPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dataPembelian = H_beli::get();
        return view('pembelian.index')->with('dataPembelian',$dataPembelian);
    }

    public function create()
    {
        $pbfData = Pbf::get();
        return view('pembelian.create')->with(['pbfData'=>$pbfData]);
    }
}
