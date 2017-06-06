@extends('laporan.index')
<?php use App\Kartu_stok;?>

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
        <h4 class="text-navy"><b>LAPORAN OBAT</b></h4>
        <h4 class="text-navy"><b>{{$periode}}</b></h4>
    </div>
</div>
<br/>
<div class="table-responsive m-t">
    <table class="table invoice-table">
        <thead>
        </thead>
        <tbody>
        <?php $ind=0; $semua=0;?>
        @foreach ($hasil as $h)
            <?php $ind++; ?>
            <tr class='invoice-header'>
                <th>No</th>
                <th>Obat</th>
                <th>Pamakologi</th>
                <th>Bentuk Sediaan</th>
                <th class="text-right">Harga Jual</th>
                <th></th>
            </tr>
            <tr class='invoice-header'>
                <td>{{$ind}}</td>
                <td>{{$h->nama.' / '.$h->dosis.' '.$h->satuan_dosis}}</td>
                <td>{{$h->pamakologi->nama}}</td>
                <td>{{$h->bentuk_sediaan}}</td>
                <td class="text-right"><span class="pull-left">Rp.</span>{{number_format($h->harga_jual,2,',','.')}}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    Obat yang masuk :
                </td>
                <td class="text-right">
                    <?php
                        $kartustok1 = Kartu_stok::where('id_obat',$h->id)->whereIn('jenis',['masuk', 'MASUK'])->where('tanggal', '>=', $data["tglawal"])->where('tanggal', '<=', $data["tglakhir"])->sum('jumlah');
                        echo $kartustok1.' Unit';
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    Obat yang keluar :
                </td>
                <td class="text-right">
                    <?php
                        $kartustok2 = abs(Kartu_stok::where('id_obat',$h->id)->whereIn('jenis',['keluar', 'KELUAR'])->where('tanggal', '>=', $data["tglawal"])->where('tanggal', '<=', $data["tglakhir"])->sum('jumlah'));
                        echo $kartustok2.' Unit';
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                </td>
                <td class="text-right">
                    <?php
                      echo ($kartustok1-$kartustok2).' Unit';
                    ?>
                </td>
            </tr>
            <tr><td colspan='6'></td></tr>
        @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->
@endsection
