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
        $this->middleware('ckadmin');
    }

    public function index()
    {
        $dataPenjualan = H_jual::get();
        return view('penjualan.index')->with('dataPenjualan',$dataPenjualan);
    }

    public function create()
    {
        $obatData = Obat::orderBy('nama')->get();
        $nonota = DB::select(DB::raw('select autogenID_HJual() as nota'))[0]->nota;
        return view('penjualan.create')->with(['obatData'=>$obatData, 'nonota'=>$nonota]);
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
                      $jumlah = $data[4];
                      $total_stok = Kartu_stok::where('id_obat',$id_obat)->sum('jumlah');

                      if($total_stok>=$jumlah){
                          //  $expired = DB::table('kartu_stok')
                          //            ->where('kartu_stok.id_obat',$id_obat)
                          //            ->whereNull('deleted_at')
                          //            ->min('expired_date');
                           //
                          //  $harga_beli = DB::table('kartu_stok')
                          //                ->where('id_obat',$id_obat)
                          //                ->where('expired_date',$expired)
                          //                ->where('jenis','masuk')
                          //                ->max('harga');
                          //  $stok_yang_dipakai = DB::table('kartu_stok')
                          //                ->select(DB::raw('tanggal, expired_date, sum(jumlah) as jumlah, harga'))
                          //                ->where('id_obat',$id_obat)
                          //                ->where('expired_date',$expired)
                          //                ->whereNull('deleted_at')
                          //                ->groupBy('expired_date')
                          //                ->orderBy('expired_date')
                          //                ->first();
                          //  dd($stok_yang_dipakai);




                           $harga_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
                           $subtotal_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));
                           $diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[6])));
                           $subtotal_jual_setelah_diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[7])));

                           $d_jual = new D_jual;
                           $d_jual->no_nota = $request->no_nota;
                           $d_jual->id_obat = $id_obat;
                           $d_jual->jumlah = $jumlah;
                           $d_jual->harga_jual = $harga_jual;
                           $d_jual->harga_beli = 9;
                           $d_jual->subtotal_beli = 99;
                           $d_jual->subtotal_jual = $subtotal_jual;
                           $d_jual->diskon = $diskon;
                           $d_jual->subtotal_jual_setelah_diskon = $subtotal_jual_setelah_diskon;
                           $d_jual->keterangan = null;
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
                       $jumlah_resep = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
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
                       $h_resep->biaya_kemasan = $biaya_kemasan;
                       $h_resep->diskon = $diskon;
                       $h_resep->grand_total = $grand_total;
                       $h_resep->total_harga_beli = 9;
                       $h_resep->keterangan = $request->keterangan_resep;
                       $h_resep->save();

                       //d_resep
                       foreach ($dresepData[$idx] as $data) {
                          $id_obat = $data[1];
                          $jumlah = intval($data[4]);
                          $harga_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
                          $subtotal_jual = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));

                          $d_resep = new D_resep;
                          $d_resep->no_nota = $request->no_nota;
                          $d_resep->id_racikan = $h_resep->id_racikan;
                          $d_resep->id_obat = $id_obat;
                          $d_resep->jumlah = $jumlah*$jumlah_resep;
                          $d_resep->harga_jual = $harga_jual;
                          $d_resep->harga_beli = 1;
                          $d_resep->subtotal_jual = ($jumlah*$jumlah_resep)*$harga_jual;
                          $d_resep->subtotal_beli = 11;
                          $d_resep->keterangan = null;
                          $d_resep->save();
                       }

                       $idx = $idx+1;
                    }
                }

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

    public function listpembelian($id)
    {
       $h_jual = H_beli::where('no_nota',$id)->first();
       $d_jual = D_beli::where('no_nota',$id)->get();
        // dd($d_jual);
       return view('pembelian.listpembelian')->with(['h_beli'=>$h_jual,'d_beli'=>$d_jual]);
    }

    public function destroy($id)
    {
       $d_jual= D_beli::where('no_nota',$id)->delete();
       $h_jual= H_beli::where('no_nota',$id)->delete();
       Session::flash('message', 'Data Pembelian telah berhasil dihapus.');
       return Redirect::to('pembelian');
    }

    public function penerimaan()
    {
        $penerimaanData = D_beli::whereNull('tanggal_terima')->get();
        // dd($penerimaanData);
        return view('penerimaan.index')->with(['penerimaanData'=>$penerimaanData]);
    }

    public function terima(Request $request)
    {
        $d_jual = D_beli::where('no_nota',$request->nonota)
                        ->where('id_obat',$request->id_obat)
                        ->update(['tanggal_terima'=>$request->tanggal_terima]);

        //update stok
        $stok = new Kartu_stok;
        $stok->id = Uuid::generate()->string;
        $stok->id_obat = $request->id_obat;
        $stok->tanggal = $request->tanggal_terima;
        $stok->jenis = 'masuk';
        $stok->harga = intval(str_replace(['.',','],'',$request->harga_beli));

        $stok->expired_date = $request->tanggal_expired;
        $stok->jumlah = $request->jumlah;

        //sisa
        $total_stok = Kartu_stok::where('id_obat',$request->id_obat)->sum('jumlah');
        $total_stok = (!empty($total_stok))? $total_stok : 0;
        $total_stok = $total_stok + $stok->jumlah;

        $stok->keterangan = "Diperoleh dari nota pembelian ".$request->nonota;
        $stok->save();

        Session::flash('message', 'Pembelian obat '.$request->nama_obat.' dengan nomor nota '.$request->nonota.' telah diterima pada tanggal '. date("d-m-Y",strtotime($request->tanggal_terima)));
    }

    public function pembayaran()
    {
        $pembayaranData = H_beli::whereNull('tanggal_pembayaran')->get();
        // dd($penerimaanData);
        return view('pembayaran.index')->with(['pembayaranData'=>$pembayaranData]);
    }

    public function bayar(Request $request)
    {

        $h_jual = H_beli::where('no_nota',$request->nonota)
                      ->update(['tanggal_pembayaran'=>$request->tanggal_pembayaran]);
        Session::flash('message', 'Pembelian dengan nomor nota '.$request->nonota.' telah dibayar pada tanggal '. date("d-m-Y",strtotime($request->tanggal_pembayaran)));
    }


}
