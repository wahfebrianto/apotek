<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\H_jual, App\D_jual, App\H_resep, App\D_resep, App\Pbf, App\Obat, App\Kartu_stok;
use Webpatser\Uuid\Uuid;

class MPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dataPenjualan = H_jual::orderBy('no_nota', 'desc')->get();
        return view('penjualan.index')->with('dataPenjualan',$dataPenjualan);
    }

    public function create()
    {
        $obatData = Obat::orderBy('nama')->get();
        $nonota = DB::select(DB::raw('select autogenID_HJual() as nota'))[0]->nota;
        for ($i=0; $i <sizeof($obatData) ; $i++) {
          $total_stok[] = Kartu_stok::where('id_obat',$obatData[$i]->id)->sum('jumlah');
        }
        return view('penjualan.create')->with(['obatData'=>$obatData, 'nonota'=>$nonota,'total_stok'=>$total_stok]);
    }

    public function rowdata(Request $request)
    {
        Session::forget('djual');
        Session::put('djual',$request->djual);
        Session::forget('hresep');
        Session::put('hresep',$request->hresep);
        Session::forget('dresep');
        Session::put('dresep',$request->dresep);
    }

    public function store(Request $request)
    {
        $djualData = Session::get('djual');
        Session::forget('djual');
        $hresepData = Session::get('hresep');
        Session::forget('hresep');
        $dresepData = Session::get('dresep');
        Session::forget('dresep');
        // dd($dresepData);

        if (sizeof($djualData)>0 || sizeof($hresepData)>0) {
            DB::beginTransaction();
            try {
                //h_jual
                $h_jual = new H_jual;
                $h_jual->no_nota = $request->no_nota;
                $h_jual->tgl = $request->tanggal;
                $h_jual->id_pegawai = Auth::user()->id;
                $h_jual->total = intval(str_replace(['.',','],'',$request->total));
                $h_jual->diskon = intval(str_replace(['.',','],'',$request->diskon));
                $h_jual->grand_total = intval(str_replace(['.',','],'',$request->grand_total));
                $h_jual->keterangan = null;
                $h_jual->save();

                //d_jual
                if(sizeof($djualData)>0){
                    foreach ($djualData as $data) {
                      $id_obat = $data[1];
                      $jumlah_total = intval($data[4]);
                      $total_stok = Kartu_stok::where('id_obat',$id_obat)->sum('jumlah');
                      $harga_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));

                      if($total_stok>=$jumlah_total){
                        $total_harga_beli = 0;
                        $ket_stok = "";
                        $idx = 0;
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
                           //dd($kartu_stok);

                          //  echo($harga_beli."-".$jumlah."<br>");
                           $total_harga_beli = $total_harga_beli + ($harga_beli*$jumlah);
                           $jumlah_total = $jumlah_total-$jumlah;
                         }

                          $jumlah_total = intval($data[4]);
                          //insert kartu_stok
                          $stok_kurang = new Kartu_stok;
                          $stok_kurang->id = Uuid::generate()->string;
                          $stok_kurang->id_obat = $id_obat;
                          $stok_kurang->tanggal = date("Y-m-d");
                          $stok_kurang->jenis = "keluar";
                          $stok_kurang->jumlah = 0-$jumlah_total;
                          //untuk harga akan menampilkan total modal harga_beli untuk memudahkan dalam perhitungan laba rugi
                          $stok_kurang->harga = $total_harga_beli;
                          $stok_kurang->expired_date = $expired;
                          $stok_kurang->terpakai = 0;
                          $stok_kurang->ket_stok = $ket_stok;
                          $stok_kurang->buatan = 0;
                          $stok_kurang->save();

                          $subtotal_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));
                          $diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[6])));
                          $subtotal_jual_setelah_diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[7])));

                           $d_jual = new D_jual;
                           $d_jual->no_nota = $request->no_nota;
                           $d_jual->id_obat = $id_obat;
                           $d_jual->jumlah = $jumlah_total;
                           $d_jual->harga_jual = $harga_jual;
                           $d_jual->subtotal_jual = $subtotal_jual;
                           $d_jual->diskon = $diskon;
                           $d_jual->subtotal_jual_setelah_diskon = $subtotal_jual_setelah_diskon;
                           $d_jual->keterangan = $stok_kurang->id;
                           $d_jual->save();
                       }
                       else{
                           Session::flash('message', 'Insert Data Penjualan Gagal, Stok tidak mencukupi');
                           return Redirect::to('penjualan/create');
                       }
                    }
                }

                //h_resep
                if(sizeof($hresepData)>0){
                    $idx = 0;
                    foreach ($hresepData as $data) {
                       $nama_racikan = explode("-",$data[1])[0];
                       $bentuk_sediaan = explode("-",$data[1])[1];
                       $total = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[2])));
                       $jumlah_resep = floatval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
                       $biaya_kemasan = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[4])));
                       $diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));
                       $grand_total = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[6])));

                       $h_resep = new H_resep;
                       $h_resep->no_nota = $request->no_nota;
                       $h_resep->id_racikan = Uuid::generate()->string;
                       $h_resep->nama_racikan = $nama_racikan;
                       $h_resep->bentuk_sediaan = $bentuk_sediaan;
                       $h_resep->total = $total;
                       $h_resep->jumlah = $jumlah_resep;
                       $h_resep->biaya_kemasan = ($biaya_kemasan*$jumlah_resep);
                       $h_resep->diskon = $diskon;
                       $h_resep->grand_total = $grand_total;
                       $h_resep->keterangan = $request->keterangan_resep;
                       $h_resep->save();

                       //d_resep
                       foreach ($dresepData[$idx] as $data) {
                          $id_obat = $data[1];
                          $jumlah_total = floatval($data[4]);
                          $total_stok = Kartu_stok::where('id_obat',$id_obat)->sum('jumlah');
                          $harga_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
                          $subtotal_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));

                          //pengurangan stok
                          if($total_stok>=$jumlah_total){
                            $total_harga_beli = 0;
                            $ket_stok = "";
                            $idxx = 0;
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

                               if($idxx!=0) $ket_stok .= ";";
                               $ket_stok .= $kartu_stok->id."/".$jumlah;
                               $idxx++;

                              // dd(DB::getQueryLog());
                               //dd($kartu_stok);

                              //  echo($harga_beli."-".$jumlah."<br>");
                               $total_harga_beli = $total_harga_beli + ($harga_beli*$jumlah);
                               $jumlah_total = $jumlah_total-$jumlah;
                             }

                             $jumlah_total = floatval($data[4]);

                             //insert kartu_stok
                             $stok_kurang = new Kartu_stok;
                             $stok_kurang->id = Uuid::generate()->string;
                             $stok_kurang->id_obat = $id_obat;
                             $stok_kurang->tanggal = date("Y-m-d");
                             $stok_kurang->jenis = "keluar";
                             $stok_kurang->jumlah = 0-$jumlah_total;
                             $stok_kurang->harga = $total_harga_beli;
                             $stok_kurang->expired_date = $expired;
                             $stok_kurang->terpakai = 0;
                             $stok_kurang->ket_stok = $ket_stok;
                             $stok_kurang->buatan = 0;
                             $stok_kurang->save();

                             $d_resep = new D_resep;
                             $d_resep->no_nota = $request->no_nota;
                             $d_resep->id_racikan = $h_resep->id_racikan;
                             $d_resep->id_obat = $id_obat;
                             $d_resep->jumlah = $jumlah_total;
                             $d_resep->harga_jual = $harga_jual;
                             $d_resep->subtotal_jual = $subtotal_jual;
                             $d_resep->keterangan = $stok_kurang->id;
                             $d_resep->save();
                          }
                          else{
                              Session::flash('message', 'Insert Data Penjualan Gagal, Stok tidak mencukupi');
                              return Redirect::to('penjualan/create');
                          }
                       }

                       $idx = $idx+1;
                    }
                }

                // dd("");
                DB::commit();
                Session::flash('message', 'Data Penjualan berhasil ditambahkan');
                return Redirect::to('penjualan');
            } catch (Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }
        }
        else{
            Session::flash('message', 'Insert Data Penjualan Gagal');
            return Redirect::to('penjualan/create');
        }
    }

    public function listpenjualan($id)
    {
       $h_jual = H_jual::where('no_nota',$id)->first();
       $d_jual = D_jual::where('no_nota',$id)->get();
       $h_resep = H_resep::where('no_nota',$id)->get();
       $d_resep = array();
       for ($i=0; $i < sizeof($h_resep); $i++) {
         $d_resep[$i] = D_resep::where('no_nota',$id)->where('id_racikan',$h_resep[$i]->id_racikan)->get();
       }
      // dd($d_resep);
       return view('penjualan.listpenjualan')->with(['h_jual'=>$h_jual,'d_jual'=>$d_jual,'h_resep'=>$h_resep,'d_resep'=>$d_resep]);
    }

    public function copy_resep($id){
      $h_jual = H_jual::where('no_nota',$id)->first();
      $d_jual = array();
      $idx_djual = 0;
      foreach ($h_jual->d_jual as $d_jual_data) {
        $obat = $d_jual_data->obat;
        $d_jual[$idx_djual]['body'] = $obat->nama.' '.$obat->dosis.$obat->satuan_dosis.'('.$obat->bentuk_sediaan.')   NO '.$d_jual_data->jumlah;
        $d_jual[$idx_djual]['keterangan'] = $d_jual_data->keterangan;
        $idx_djual++;
      }

      $h_resep = array();
      $idx_hresep = 0;
      foreach ($h_jual->h_resep as $data) {
        $idx_dresep = 0;
        foreach ($data->d_resep as $d_resep) {
            $obat = $d_resep->obat;
            $dosis = ($d_resep->jumlah/$data->jumlah)*$obat->dosis;
            $h_resep[$idx_hresep]['body'][$idx_dresep] = $obat->nama.' '.$dosis.$obat->satuan_dosis.'('.$obat->bentuk_sediaan.')';
            $idx_dresep++;
        }
        $h_resep[$idx_hresep]['jumlah'] = $data->jumlah;
        $idx_hresep++;
      }
      $printcss = asset('css/copyresep.css');
      return view('penjualan.copy_resep')->with(['d_jual'=>$d_jual,'h_resep'=>$h_resep,'print' => $printcss]);
    }

    public function destroy($id)
    {
       //buang stok
       $d_resep = D_resep::where('no_nota',$id)->get();
       $d_jual= D_Jual::where('no_nota',$id)->get();

       foreach ($d_resep as $data) {
           $stok = Kartu_stok::where('id',$data->keterangan)->first();
           $tempStok = explode(";",$stok->ket_stok);
           foreach ($tempStok as $value) {
              $value = explode("/",$value);
              $id_stok = $value[0];
              $jumlah = floatval($value[1]);

              //cari stok
              $stok_recovery = Kartu_stok::where('id',$id_stok)->first()->decrement('terpakai',$jumlah);
           }
           $stok = Kartu_stok::where('id',$data->keterangan)->delete();
       }

       foreach ($d_jual as $data) {
           $stok = Kartu_stok::where('id',$data->keterangan)->first();
           $tempStok = explode(";",$stok->ket_stok);
           foreach ($tempStok as $value) {
              $value = explode("/",$value);
              $id_stok = $value[0];
              $jumlah = floatval($value[1]);

              //cari stok
              $stok_recovery = Kartu_stok::where('id',$id_stok)->first()->decrement('terpakai',$jumlah);
           }
           $stok = Kartu_stok::where('id',$data->keterangan)->delete();
       }

       $d_resep= D_resep::where('no_nota',$id)->delete();
       $h_resep= H_resep::where('no_nota',$id)->delete();
       $d_jual= D_jual::where('no_nota',$id)->delete();
       $h_jual= H_jual::where('no_nota',$id)->delete();
       Session::flash('message', 'Data Penjualan telah berhasil dihapus.');
       return Redirect::to('penjualan');
    }

}
