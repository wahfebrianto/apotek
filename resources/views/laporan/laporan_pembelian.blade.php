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
        <h4 class="text-navy"><b>LAPORAN PEMBELIAN</b></h4>
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
                <th>Tanggal Pemesanan</th>
                <th>No Nota</th>
                <th>PBF</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Status Pembayaran</th>
            </tr>
            <tr class='invoice-header'>
                <td>{{$ind}}</td>
                <td>{{$h->tanggal_pesan}}</td>
                <td>{{$h->no_nota}}</td>
                <td>{{$h->pbf->nama}}</td>
                <td>{{$h->tanggal_jatuh_tempo}}</td>
                <td>{{($h->tanggal_pembayaran!=NULL)?'LUNAS':'BELUM LUNAS'}}</td>
            </tr>
            <tr>
                <td colspan="6">
                  <table class='table mini-table'>
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Bentuk Sediaan</th>
                            <th class='text-right'>Jumlah</th>
                            <th class='text-right'>Harga Beli</th>
                            <th class='text-right'>Disc</th>
                            <th class='text-right'>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $total=0; ?>
                    @foreach ($h->d_beli as $d)
                      <tr>
                          <td>{{$d->obat->nama.' / '.$d->obat->dosis.' '.$d->obat->satuan_dosis}}</td>
                          <td>{{$d->obat->bentuk_sediaan}}</td>
                          <td class='text-right'>{{number_format($d->jumlah,2,',','.')}}</td>
                          <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($d->harga_beli,2,',','.')}}</td>
                          <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($d->diskon,2,',','.')}}</td>
                          <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($d->subtotal_setelah_diskon,2,',','.')}}</td>
                          <?php $total+=$d->subtotal_setelah_diskon; ?>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </td>
            </tr>
            <tr class='invoice-header'>
              <th></th>
              <th></th>
              <th></th>
              <th class='text-right'>Total</th>
              <th class='text-right'>Diskon</th>
              <th class='text-right'>Grand Total</th>
            </tr>
            <tr class='invoice-header'>
              <td></td>
              <td></td>
              <td></td>
              <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($total,2,',','.')}}</td>
              <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($h->diskon,2,',','.')}}</td>
              <td class='text-right'><span class="pull-left">Rp.</span>{{number_format($total - $h->diskon,2,',','.')}}</td>
            </tr>
            <tr><td colspan='6'></td></tr>
            <?php $semua+=($total - $h->diskon);?>
        @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->

<table class="table invoice-total">
    <tbody>
        <tr>
            <td><strong>TOTAL : Rp </strong></td>
            <td>{{number_format($semua,2,',','.')}}</td>
        </tr>
    </tbody>
</table>
@endsection
