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
      $stokData = Kartu_stok::where('id_obat',$id_obat)->orderby('created_at','desc')->get();
      $descStok = DB::table('kartu_stok')
                  ->select(DB::raw('tanggal, expired_date, sum(jumlah) as total, harga'))
                  ->where('id_obat',$id_obat)
                  // ->where('total','>',0)
                  ->whereNull('deleted_at')
                  ->groupBy('expired_date')
                  ->orderBy('expired_date')
                  ->get();
      $overview["total_stok"] = Kartu_stok::where('id_obat',$id_obat)->sum('jumlah');
      $overview["expired"] = DB::table('kartu_stok')
                                ->where('kartu_stok.id_obat',$id_obat)
                                ->whereNull('deleted_at')
                                ->min('expired_date');
      $overview["harga_beli"] = DB::table('kartu_stok')
                                ->where('kartu_stok.id_obat',$id_obat)
                                ->where('kartu_stok.jenis','masuk')
                                ->whereNull('deleted_at')
                                ->avg('harga');

      return view('stok.index')->with(['stokData'=>$stokData,'descStok'=>$descStok,'obat'=>$obat,'overview'=>$overview]);
   }

   public function create($id_obat)
   {
      $obat = Obat::find($id_obat);
      return view('stok.create')->with(array('obat'=>$obat));
   }

   public function store(Request $request){
       $this->validate($request, [
             'jumlah' => 'required',
             'harga' => 'required',
       ]);

       $stok = new Kartu_stok;
       $stok->id = Uuid::generate()->string;
       $stok->id_obat = $request->id_obat;
       $stok->tanggal = $request->tanggal;
       $stok->jenis = $request->jenis;
       $stok->harga = intval(str_replace(['.',','],'',$request->harga));

       $stok->expired_date = $request->tanggal_expired;
       if ($request->jenis == 'keluar') {
          $stok->jumlah = 0 - $request->jumlah;
       }
       else {
          $stok->jumlah = $request->jumlah;
       }
       $stok->terpakai = 0;

       //sisa
       $total_stok = Kartu_stok::where('id_obat',$request->id_obat)->sum('jumlah');
       $total_stok = (!empty($total_stok))? $total_stok : 0;
       $total_stok = $total_stok + $stok->jumlah;

       $stok->keterangan = $request->keterangan;

      //  $log = new Log;
      //  $log->id_obat = $stok->id_obat;
      //  $log->jenis = "Stok";
      //  $log->keterangan = "Penambahan stok obat seharga Rp ".number_format($stok->harga,2,",",".")." sebanyak ".$stok->stok." biji.";
      //  $log->save();

       if ($total_stok > 0) {
         $stok->save();
         Session::flash('message', 'Sukses menambahkan pada Kartu Stok.');
         return Redirect::to('stok/'.$request->id_obat);
       }
       else{
         Session::flash('message', 'Inputan tidak valid, total stok kurang dari 0.');
         return Redirect::to('stok/'.$request->id_obat.'/create');
       }

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
             'jumlah' => 'required',
             'harga' => 'required',
       ]);

       $stok->harga = intval(str_replace(['.',','],'',$request->harga));
       $stok->tanggal = $request->tanggal;
       $stok->jenis = strtolower($request->jenis);
       $stok->expired_date = $request->tanggal_expired;
       $old_stok = $stok->jumlah;
       if (strtolower($request->jenis) == 'keluar') $stok->jumlah = 0 - $request->jumlah;
       else $stok->jumlah = $request->jumlah;
      //  $stok->terpakai = 0;
       $stok->keterangan = $request->keterangan;

      //  if($old_stok != $stok->stok){
      //      $log = new Log;
      //      $log->id_obat = $stok->id_obat;
      //      $log->jenis = "Stok";
      //      $log->keterangan = "Penyesuaian stok obat untuk tanggal expired ".date("d-m-Y",strtotime($stok->expired_date))." dari ".$old_stok." menjadi ".$stok->stok.".";
      //      $log->save();
      //  }
       $total_stok = Kartu_stok::where('id_obat',$request->id_obat)->sum('jumlah');
       $total_stok = (!empty($total_stok))? $total_stok : 0;
       $total_stok = $total_stok + $stok->jumlah;

       if ($total_stok > 0) {
         $stok->save();
         Session::flash('message', 'Sukses mengupdate Kartu Stok.');
         return Redirect::to('stok/'.$request->id_obat);
       }
       else{
         Session::flash('message', 'Inputan tidak valid, total stok kurang dari 0.');
         return Redirect::to('stok/'.$request->id_obat.'/edit');
       }
   }

   public function destroy($id)
   {
    $stok = Kartu_stok::find($id);
    Session::flash('message', 'Stok telah berhasil dihapus.');

    // $log = new Log;
    // $log->id_obat = $stok->id_obat;
    // $log->jenis = "Stok";
    // $log->keterangan = "Penghapusan stok obat untuk tanggal expired ".date("d-m-Y",strtotime($stok->expired_date))." sejumlah ".$stok->stok.".";
    // $log->save();

    $stok->delete();
    return Redirect::to('stok/'.$stok->id_obat);
   }







}
