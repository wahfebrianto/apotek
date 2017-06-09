@extends('laporan.index')

@section('child')
<div class="row">
    <div class="col-sm-12 text-center">
        <img src="/assets/logo.png" width="5%">
        <h4 class="text-navy"><b>APOTEK VALENTINO</b></h4>
        <p>
            <span>Jl. Pandugo Timur 97B/99 Surabaya</span><br/>
            <span>Telp. (031) 8783730</span><br/>
            <span>Apoteker Dra. Lusiwati .T. M Farm-Klin Apt</span><br/>
            <span><strong>SIPA : </strong>19511113/SIPA-35.78/2016/2106</span>
        </p>
        <h4 class="text-navy"><b>LAPORAN LABA RUGI KOTOR</b></h4>
        <h4 class="text-navy"><b>{{$periode}}</b></h4>
    </div>
</div>
<br/>
<div class="table-responsive m-t">
    <table class="table invoice-table">
        <thead>
        </thead>
        <tbody>
            <tr class='invoice-header'>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                  Penjualan pada bulan ini :
                </td>
                <td class="text-right">
                  <span class="pull-left">Rp.</span>{{number_format(floatval($hasil['penjualan']),2,',','.')}}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                  Pembelian pada bulan ini :
                </td>
                <td class="text-right">
                  <span class="pull-left">Rp.</span>-{{number_format(floatval($hasil['pembelian']),2,',','.')}}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                  Penggajian pada bulan ini :
                </td>
                <td class="text-right">
                  <span class="pull-left">Rp.</span>-{{number_format(floatval($hasil['gaji']),2,',','.')}}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                  Pengeluaran lainnya pada bulan ini :
                </td>
                <td class="text-right">
                  <span class="pull-left">Rp.</span>-{{number_format(floatval($hasil['pengeluaran']),2,',','.')}}
                </td>
            </tr>
            <tr><td colspan='6'></td></tr>
            <tr class='invoice-header'>
                <td colspan="6"></td>
            </tr>
        </tbody>
    </table>
</div><!-- /table-responsive -->

<table class="table invoice-total">
    <tbody>
        <tr>
            <td><strong>TOTAL : Rp </strong></td>
            <td>{{number_format((floatval($hasil['penjualan']) - floatval($hasil['pembelian']) - floatval($hasil['gaji']) - floatval($hasil['pengeluaran'])),2,',','.')}}</td>
        </tr>
    </tbody>
</table>
@endsection
