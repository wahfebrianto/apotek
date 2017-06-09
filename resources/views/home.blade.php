@extends('layouts.app')

@section('content')
@if (!Auth::guest() && Auth::user()->username == "admin")
<div class="container auto-width">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading text-center">Daftar Kredit Belum Lunas (Kurang dari 7 Hari)</div>
                <div class="panel-body">
                  <table id="data-table1" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th class="number-td">No</th>
                            <th>No. Nota</th>
                            <th>PBF</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Tanggal Jatuh Tempo</th>
                            {{-- <th>Total</th>
                            <th>Diskon</th> --}}
                            <th>Grand Total</th>
                            <th>Pegawai</th>
                            <th>Status Pembayaran</th>
                            <th>Keterangan</th>
                            <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($dataPembelian as $data)
                          <tr>
                              <td class="number-td"></td>
                              <td>{{$data->no_nota}}</td>
                              <td>{{$data->pbf->nama}}</td>
                              <td>{{date("d-m-Y",strtotime($data->tanggal_pesan))}}</td>
                              <td>{{date("d-m-Y",strtotime($data->tanggal_jatuh_tempo))}}</td>
                              {{-- <td>Rp {{number_format($data->total,2,",",".")}}</td>
                              <td>Rp {{number_format($data->diskon,2,",",".")}}</td> --}}
                              <td>Rp {{number_format($data->grand_total,2,",",".")}}</td>
                              <td>{{$data->user->nama}}</td>
                              <td>{{($data->tanggal_pembayaran==0)? 'BELUM LUNAS' : 'LUNAS'}}</td>
                              <td>{{$data->keterangan}}</td>
                              <td>
                                  <a class="col-sm-12 btn btn-info btn-action" href="{{ URL::to('pembelian/list/'.$data->no_nota) }}">Lihat</a>
                                  {{-- <a class="col-sm-12 btn btn-warning btn-action" href="{{ url('pembelian', [$data->no_nota]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a> --}}
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading text-center">Daftar Stok Barang yang Menipis (Kurang dari 25 Item)</div>
                <div class="panel-body">
                  <table id="data-table2" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th class="number-td">No</th>
                            <th>Nama</th>
                            <th>Jenis Pamakologi</th>
                            <th>Dosis</th>
                            <th>Satuan Dosis</th>
                            <th>Bentuk Sediaan</th>
                            <th>Harga Jual</th>
                            <th class="number-td">Stok</th>
                            <th>Keterangan</th>
                            <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $idx = 0; ?>
                      @foreach ($obatData as $obat)
                          @if ($total_stok[$idx] <= 25)
                              <tr>
                                  <td class="number-td"></td>
                                  <td>{{$obat->nama}}</td>
                                  <td>{{$obat->pamakologi->nama}}</td>
                                  <td>{{$obat->dosis}}</td>
                                  <td>{{$obat->satuan_dosis}}</td>
                                  <td>{{$obat->bentuk_sediaan}}</td>
                                  <td>Rp {{number_format($obat->harga_jual,2,",",".")}}</td>
                                  <td class="number-td">{{$total_stok[$idx]}}</td>
                                  <td>{{$obat->keterangan}}</td>
                                  <td>
                                      <a class="col-sm-12 col-lg-12 btn btn-primary btn-action" href="{{ URL::to('stok/'.$obat->id) }}">Stok</a>
                                      <a class="col-sm-12 col-lg-6 btn btn-info btn-action" href="{{ URL::to('obat/'.$obat->id.'/edit') }}">Ubah</a>
                                      <a class="col-sm-12 col-lg-6 btn btn-warning btn-action" href="{{ url('obat', [$obat->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
                                  </td>
                              </tr>
                          @endif
                          <?php $idx=$idx+1; ?>
                      @endforeach
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    $(document).ready(function(){
        var t = $('#data-table1').DataTable( {
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
            }
        } );
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        var tt = $('#data-table2').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
        }
        } );

        tt.on( 'order.dt search.dt', function () {
            tt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endsection
