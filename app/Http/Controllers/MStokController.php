<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\Obat, App\Kartu_stok, App\Log;
use Webpatser\Uuid\Uuid;

class MStokController extends Controller
{
    //
   public function __construct()
   {
       $this->middleware('auth');
       $this->middleware('ckadmin');
   }

   public function index($id_obat)
   {
      $obat = Obat::find($id_obat);
      $stokData = Kartu_stok::where('id_obat',$id_obat)->get();
      $overview["total_stok"] = DB::table('kartu_stok')
                                ->where('kartu_stok.id_obat',$id_obat)
                                ->whereNull('deleted_at')
                                ->sum('stok');
      $overview["expired"] = DB::table('kartu_stok')
                                ->where('kartu_stok.id_obat',$id_obat)
                                ->whereNull('deleted_at')
                                ->min('expired_date');
      $overview["harga_beli"] = DB::table('kartu_stok')
                                ->where('kartu_stok.id_obat',$id_obat)
                                ->whereNull('deleted_at')
                                ->avg('harga_beli');

      return view('stok.index')->with(['stokData'=>$stokData,'obat'=>$obat,'overview'=>$overview]);
   }

   public function create($id_obat)
   {
      $obat = Obat::find($id_obat);
      return view('stok.create')->with(array('obat'=>$obat));
   }

   public function store(Request $request){
       $this->validate($request, [
             'stok' => 'required',
             'harga_beli' => 'required',
       ]);

       $stok = new Kartu_stok;
       $stok->id = Uuid::generate()->string;
       $stok->id_obat = $request->id_obat;
       $stok->harga_beli = intval(str_replace(['.',','],'',$request->harga_beli));
       $stok->tanggal_beli = $request->tanggal_beli;
       $stok->expired_date = $request->tanggal_expired;
       $stok->stok = $request->stok;
       $stok->keterangan = $request->keterangan;

       $log = new Log;
       $log->id_obat = $stok->id_obat;
       $log->jenis = "Stok";
       $log->keterangan = "Penambahan stok obat seharga Rp ".number_format($stok->harga_beli,2,",",".")." sebanyak ".$stok->stok." biji.";
       $log->save();

       $stok->save();

       Session::flash('message', 'Stok baru telah ditambahkan.');
       return Redirect::to('stok/'.$request->id_obat);
   }

   public function edit($id_stok)
   {
       $stok = Kartu_stok::find($id_stok);
       return view('stok.edit')->with('stok',$stok);
   }

   public function update(Request $request, $id)
   {
     $stok = Kartu_stok::find($id);
     $this->validate($request, [
           'stok' => 'required',
           'harga_beli' => 'required',
     ]);

     $stok->harga_beli = intval(str_replace(['.',','],'',$request->harga_beli));
     $stok->tanggal_beli = $request->tanggal_beli;
     $stok->expired_date = $request->tanggal_expired;
     $old_stok = $stok->stok;
     $stok->stok = $request->stok;
     $stok->keterangan = $request->keterangan;

     if($old_stok != $stok->stok){
         $log = new Log;
         $log->id_obat = $stok->id_obat;
         $log->jenis = "Stok";
         $log->keterangan = "Penyesuaian stok obat untuk tanggal expired ".date("d-m-Y",strtotime($stok->expired_date))." dari ".$old_stok." menjadi ".$stok->stok.".";
         $log->save();
     }

     $stok->save();

     Session::flash('message', 'Stok baru telah diupdate.');
     return Redirect::to('stok/'.$request->id_obat);
   }

   public function destroy($id)
   {
    $stok = Kartu_stok::find($id);
    Session::flash('message', 'Stok telah berhasil dihapus.');

    $log = new Log;
    $log->id_obat = $stok->id_obat;
    $log->jenis = "Stok";
    $log->keterangan = "Penghapusan stok obat untuk tanggal expired ".date("d-m-Y",strtotime($stok->expired_date))." sejumlah ".$stok->stok.".";
    $log->save();

    $stok->delete();
    return Redirect::to('stok/'.$stok->id_obat);
   }







}
