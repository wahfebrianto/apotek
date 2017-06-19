<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\H_beli;
use App\D_beli;
use App\H_jual;
use Datetime;
use Illuminate\Support\Facades\DB;
use App\Pengeluaran;
use App\Obat;
use App\User;
use App\Kartu_stok;

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
        $printcss = asset('css/laporan.css');
        return view('laporan.index')->with(["report"=>"", "print" => $printcss]);
    }

    public function generate(Request $request)
    {
        $data["jenislaporan"] = $request->jenislaporan;
        $data["rangelaporan"] = $request->rangelaporan;
        $data["tglawal"] = explode(' ', $request->tglawal)[0];
        $data["tglakhir"] = explode(' ', $request->tglakhir)[0];
        $data["bulan"] = explode(' ', $request->bulan)[0];
        $periode = ($request->rangelaporan=='harian')?"Periode ".date("d F Y",strtotime($data['tglawal'])).' - '.date("d F Y",strtotime($data['tglakhir'])):"Periode ".date("F Y",strtotime($data['bulan']));
        $hasil='';
        if($request->rangelaporan!='harian')
        {
           $pecah = explode('-', $data["bulan"]);
           $data["tglawal"] = $pecah[0].'-'.$pecah[1].'-01';
           $data["tglakhir"] = (new DateTime($data["bulan"]))->format( 'Y-m-t' );
        }
        if($data["jenislaporan"] === 'laporan_pembelian')
        {
          $hasil = H_beli::where('tanggal_pesan', '>=', $data["tglawal"])->where('tanggal_pesan', '<=', $data["tglakhir"])->with('pbf')->with('d_beli.obat')->orderBy('tanggal_pesan', 'asc')->get();
        }
        else if($data["jenislaporan"] === 'laporan_penjualan')
        {
          $hasil = H_jual::where('tgl', '>=', $data["tglawal"])->where('tgl', '<=', $data["tglakhir"])->with('h_resep.d_resep.obat')->with('d_jual.obat')->orderBy('tgl', 'asc')->get();
        }
        else if($data["jenislaporan"] === 'laporan_obat')
        {
          $hasil = Obat::with('pamakologi')->get();
        }
        else if($data["jenislaporan"] === 'laporan_laba_rugi_bersih')
        {
          $pecah = explode('-', $data["tglawal"]);
          $data["tglawal"] = $pecah[0].'-'.$pecah[1].'-01';
          $data["tglakhir"] = (new DateTime($data["tglawal"]))->format( 'Y-m-t' );
          $hasil["penjualan"] = H_jual::where('tgl', '>=', $data["tglawal"])->where('tgl', '<=', $data["tglakhir"])->sum("grand_total");
          $hasil["modal"] = Kartu_stok::whereIn('jenis',['keluar', 'KELUAR'])->where('tanggal', '>=', $data["tglawal"])->where('tanggal', '<=', $data["tglakhir"])->sum('harga');
          $hasil["pengeluaran"] = Pengeluaran::where('tgl', '>=', $data["tglawal"])->where('tgl', '<=', $data["tglakhir"])->sum('harga');
          $hasil["gaji"] = User::sum("gaji");
        }
        else if($data["jenislaporan"] === 'laporan_laba_rugi_kotor')
        {
          $pecah = explode('-', $data["tglawal"]);
          $data["tglawal"] = $pecah[0].'-'.$pecah[1].'-01';
          $data["tglakhir"] = (new DateTime($data["tglawal"]))->format( 'Y-m-t' );
          $hasil["penjualan"] = H_jual::where('tgl', '>=', $data["tglawal"])->where('tgl', '<=', $data["tglakhir"])->sum("grand_total");
          $hasil["pembelian"] = H_beli::where('tanggal_pesan', '>=', $data["tglawal"])->where('tanggal_pesan', '<=', $data["tglakhir"])->sum("grand_total");
          $hasil["pengeluaran"] = Pengeluaran::where('tgl', '>=', $data["tglawal"])->where('tgl', '<=', $data["tglakhir"])->sum('harga');
          $hasil["gaji"] = User::sum("gaji");
        }
        $printcss = asset('css/laporan.css');
        return view('laporan.'.$data["jenislaporan"])->with(["periode" => $periode, "data" => $data, "hasil" => $hasil, "print" => $printcss]);
    }
}
