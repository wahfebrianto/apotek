<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use App\H_beli, App\D_beli, App\Pbf, App\Obat;
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
        $dataPembelian = H_beli::get();
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
                $h_beli->status_lunas = false;
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
                   $d_beli->tanggal_terima = null;
                   $d_beli->id_pegawai_penerima = null;
                   $d_beli->keterangan = null;
                   $d_beli->save();
                }
                DB::commit();
                Session::flash('message', 'Tidak ditemukan data obat yang ingin dibeli.');
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

    public function list($id)
    {
       $h_beli = H_beli::where('no_nota',$id)->first();
       $d_beli = D_beli::where('no_nota',$id)->get();
        // dd($d_beli);
       return view('pembelian.list')->with(['h_beli'=>$h_beli,'d_beli'=>$d_beli]);
    }

    public function destroy($id)
    {
       $d_beli= D_beli::where('no_nota',$id)->delete();
       $h_beli= H_beli::where('no_nota',$id)->delete();
       Session::flash('message', 'Data Pembelian telah berhasil dihapus.');
       return Redirect::to('pembelian');
    }
}
