<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\H_beli, App\D_beli, App\Pbf, App\Obat, App\Kartu_stok, App\Penerimaan;
use Webpatser\Uuid\Uuid;

class MPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ckadmin');
    }

    public function index()
    {
        $dataPembelian = H_beli::orderBy('no_nota','desc')->get();
        return view('pembelian.index')->with('dataPembelian',$dataPembelian);
    }

    public function create()
    {
        $pbfData = Pbf::get();
        $obatData = Obat::orderBy('nama')->get();
        $nonota = DB::select(DB::raw('select autogenID_HBeli() as nota'))[0]->nota;
        return view('pembelian.create')->with(['pbfData'=>$pbfData,'obatData'=>$obatData, 'nonota'=>$nonota]);
    }

    public function rowdata(Request $request)
    {
        Session::forget('rowData');
        Session::put('rowData',$request->row);
    }

    public function store(Request $request)
    {
        $rowData = Session::get('rowData');
        Session::forget('rowData');

        if (sizeof($rowData)>0) {
            DB::beginTransaction();
            try {
                //h_beli
                $h_beli = new H_beli;
                $h_beli->no_nota = $request->no_nota;
                $h_beli->id_pbf = $request->id_pbf;
                $h_beli->id_pegawai = Auth::user()->id;
                $h_beli->tanggal_pesan = $request->tanggal_pesan;
                $h_beli->total = intval(str_replace(['.',','],'',$request->total));
                $h_beli->diskon = intval(str_replace(['.',','],'',$request->diskon));
                $h_beli->grand_total = intval(str_replace(['.',','],'',$request->grand_total));
                $h_beli->tanggal_pembayaran = null;
                $h_beli->tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
                $h_beli->keterangan = $request->keterangan;
                $h_beli->save();

                //d_beli
                foreach ($rowData as $data) {
                   $id_obat = $data[1];
                   $harga_beli = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[3])));
                   $jumlah = $data[4];
                   $subtotal = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[5])));
                   $diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[6])));
                   $subtotal_setelah_diskon = intval(str_replace(['.',','],'',preg_replace("/[^0-9]/","",$data[7])));

                   $d_beli = new D_beli;
                   $d_beli->no_nota = $request->no_nota;
                   $d_beli->id_obat = $id_obat;
                   $d_beli->jumlah = $jumlah;
                   $d_beli->harga_beli = $harga_beli;
                   $d_beli->subtotal = $subtotal;
                   $d_beli->diskon = $diskon;
                   $d_beli->subtotal_setelah_diskon = $subtotal_setelah_diskon;
                   $d_beli->jumlah_terima = 0;
                   $d_beli->id_pegawai_penerima = null;
                   $d_beli->keterangan = null;
                   $d_beli->save();
                }
                DB::commit();
                Session::flash('message', 'Data Pembelian berhasil ditambahkan');
                return Redirect::to('pembelian');
            } catch (Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }
        }
        else{
            Session::flash('message', 'Tidak ditemukan data obat yang ingin dibeli.');
            return Redirect::to('pembelian/create');
        }
    }

    public function listpembelian($id)
    {
       $h_beli = H_beli::where('no_nota',$id)->first();
       $d_beli = D_beli::where('no_nota',$id)->get();
       $penerimaan = Penerimaan::where('no_nota',$id)->get();
        // dd($d_beli);
       return view('pembelian.listpembelian')->with(['h_beli'=>$h_beli,'d_beli'=>$d_beli,'penerimaan'=>$penerimaan]);
    }

    public function destroy($id)
    {
       //hilangkan stok dulu
       $penerimaan = Penerimaan::where('no_nota',$id)->get();
       foreach ($penerimaan as $data) {
          $stok = Kartu_stok::where('id',$data->keterangan)->delete();
       }

       $penerimaan = Penerimaan::where('no_nota',$id)->delete();
       $d_beli= D_beli::where('no_nota',$id)->delete();
       $h_beli= H_beli::where('no_nota',$id)->delete();
       Session::flash('message', 'Data Pembelian telah berhasil dihapus.');
       return Redirect::to('pembelian');
    }

    public function penerimaan()
    {
        $penerimaanData = D_beli::whereColumn('jumlah_terima','<','jumlah')->get();
        // dd($penerimaanData);
        return view('penerimaan.index')->with(['penerimaanData'=>$penerimaanData]);
    }

    public function terima(Request $request)
    {
        $d_beli = D_beli::where('no_nota',$request->nonota)
                        ->where('id_obat',$request->id_obat)
                        ->increment('jumlah_terima',$request->jumlah_terima);

        //update stok
        $stok = new Kartu_stok;
        $stok->id = Uuid::generate()->string;
        $stok->id_obat = $request->id_obat;
        $stok->tanggal = $request->tanggal_terima;
        $stok->jenis = 'masuk';
        $stok->harga = intval(str_replace(['.',','],'',$request->harga_beli));
        $stok->expired_date = $request->tanggal_expired;
        $stok->jumlah = $request->jumlah_terima;
        $stok->keterangan = "Diperoleh dari nota pembelian ".$request->nonota;
        $stok->buatan = 0;
        $stok->save();

        //insert penerimaan
        $penerimaan = new Penerimaan;
        $penerimaan->id = Uuid::generate()->string;
        $penerimaan->no_nota = $request->nonota;
        $penerimaan->id_obat = $request->id_obat;
        $penerimaan->jumlah = $request->jumlah_terima;
        $penerimaan->tanggal_expired = $request->tanggal_expired;
        $penerimaan->tanggal_terima = $request->tanggal_terima;
        $penerimaan->keterangan = $stok->id;
        $penerimaan->save();

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

        $h_beli = H_beli::where('no_nota',$request->nonota)
                      ->update(['tanggal_pembayaran'=>$request->tanggal_pembayaran]);
        Session::flash('message', 'Pembelian dengan nomor nota '.$request->nonota.' telah dibayar pada tanggal '. date("d-m-Y",strtotime($request->tanggal_pembayaran)));
    }


}
