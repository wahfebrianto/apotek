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
       if ($request->jenis == 'masuk') {
           if($request->harga > 0){
               $stok = new Kartu_stok;
               $stok->id = Uuid::generate()->string;
               $stok->id_obat = $request->id_obat;
               $stok->tanggal = $request->tanggal;
               $stok->jenis = "masuk";
               $stok->harga = intval(str_replace(['.',','],'',$request->harga));
               $stok->buatan = 1;
               $stok->expired_date = $request->tanggal_expired;
               $stok->jumlah = $request->jumlah;
               $stok->terpakai = 0;
               $stok->keterangan = $request->keterangan;
               if ($request->jumlah > 0) {
                 $stok->save();
                 Session::flash('message', 'Sukses menambahkan pada Kartu Stok.');
                 return Redirect::to('stok/'.$request->id_obat);
               }
               else{
                 Session::flash('message', 'Inputan tidak valid, total stok kurang dari 0.');
                 return Redirect::to('stok/'.$request->id_obat.'/create');
               }
           }
           else{
               Session::flash('message', 'Inputan harga tidak valid.');
               return Redirect::to('stok/'.$request->id_obat.'/create');
           }
      }
      else{
          $total_stok = Kartu_stok::where('id_obat',$request->id_obat)->sum('jumlah');
          $total_stok = (!empty($total_stok))? $total_stok : 0;
          $total_stok = $total_stok - $request->jumlah;
          if ($total_stok > 0) {
            $total_harga_beli = 0;
            $ket_stok = "";
            $idx = 0;
            $jumlah_total = $request->jumlah;
            $id_obat = $request->id_obat;
            while($jumlah_total>0){
               $expired = DB::table('kartu_stok')
                         ->where('kartu_stok.id_obat',$id_obat)
                         ->where('jenis','masuk')
                         ->whereColumn('terpakai','<','jumlah')
                         ->whereNull('deleted_at')
                         ->min('expired_date');

               $harga_beli = DB::table('kartu_stok')
                             ->where('id_obat',$id_obat)
                             ->where('expired_date',$expired)
                             ->where('jenis','masuk')
                             ->whereColumn('terpakai','<','jumlah')
                             ->whereNull('deleted_at')
                             ->max('harga');
              //  dd(DB::getQueryLog());

               $stok_yang_dipakai = DB::table('kartu_stok')
                             ->select(DB::raw('(jumlah-terpakai) as jumlah'))
                             ->where('id_obat',$id_obat)
                             ->where('expired_date',$expired)
                             ->where('jenis','masuk')
                             ->whereColumn('terpakai','<','jumlah')
                             ->where('harga',$harga_beli)
                             ->whereNull('deleted_at')
                             ->groupBy('expired_date')
                             ->orderBy('expired_date')
                             ->first()->jumlah;

               if($jumlah_total<=$stok_yang_dipakai){
                 $jumlah = $jumlah_total;
               }
               else{
                 $jumlah = $stok_yang_dipakai;
               }
               //update terpakai
               $kartu_stok = Kartu_stok::where('id_obat',$id_obat)
                            ->where('expired_date',$expired)
                            ->where('harga',$harga_beli)
                            ->whereColumn('terpakai','<','jumlah')
                            ->first();
               $kartu_stok->increment('terpakai',$jumlah);

               if($idx!=0) $ket_stok .= ";";
               $ket_stok .= $kartu_stok->id."/".$jumlah;
               $idx++;

               $total_harga_beli = $total_harga_beli + ($harga_beli*$jumlah);
               $jumlah_total = $jumlah_total-$jumlah;
             }

            $jumlah_total = $request->jumlah;
            //insert kartu_stok
            $stok_kurang = new Kartu_stok;
            $stok_kurang->id = Uuid::generate()->string;
            $stok_kurang->id_obat = $id_obat;
            $stok_kurang->tanggal = $request->tanggal;
            $stok_kurang->jenis = "keluar";
            $stok_kurang->jumlah = 0-$jumlah_total;
            //untuk harga akan menampilkan total modal harga_beli untuk memudahkan dalam perhitungan laba rugi
            $stok_kurang->harga = $total_harga_beli;
            $stok_kurang->expired_date = $expired;
            $stok_kurang->terpakai = 0;
            $stok_kurang->ket_stok = $ket_stok;
            $stok_kurang->buatan = 1;
            $stok_kurang->save();

            Session::flash('message', 'Sukses menambahkan pada Kartu Stok.');
            return Redirect::to('stok/'.$request->id_obat);
          }
          else{
            Session::flash('message', 'Inputan tidak valid, total stok kurang dari 0.');
            return Redirect::to('stok/'.$request->id_obat.'/create');
          }
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
    if($stok->jenis=="keluar"){
        $tempStok = explode(";",$stok->ket_stok);
        foreach ($tempStok as $value) {
           $value = explode("/",$value);
           $id_stok = $value[0];
           $jumlah = floatval($value[1]);

           //cari stok
           $stok_recovery = Kartu_stok::where('id',$id_stok)->first()->decrement('terpakai',$jumlah);
        }
    }
    $stok->delete();
    Session::flash('message', 'Stok telah berhasil dihapus.');
    return Redirect::to('stok/'.$stok->id_obat);
   }







}
