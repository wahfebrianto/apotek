@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Data Pembelian - {{$h_beli->no_nota}}</div>
              <div class="panel-body">
                <div class="overview">
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">PBF</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$h_beli->pbf->nama}}</label>
                    </div>
                    <div class="col-md-6 overview-line no-padding">
                        <label class="col-xs-5 no-padding">Status</label>
                        <label class="col-xs-1 no-padding">:</label>
                        <label class="col-xs-6 no-padding">{{($h_beli->tanggal_pembayaran==0)? 'BELUM LUNAS' : 'LUNAS'}}</label>
                    </div>
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Pegawai</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$h_beli->user->nama}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Total</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_beli->total,2,",",".")}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Tanggal Pemesanan</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{date("d-m-Y",strtotime($h_beli->tanggal_pesan))}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Diskon</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_beli->diskon,2,",",".")}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Tanggal Jatuh Tempo</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{date("d-m-Y",strtotime($h_beli->tanggal_jatuh_tempo))}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Grand Total</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_beli->grand_total,2,",",".")}}</label>
                    </div>
                </div>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#tab-table1">Daftar Obat</a></li>
                  <li><a data-toggle="tab" href="#tab-table2">Penerimaan</a></li>
                </ul>

                <div class="tab-content">
                  <div id="tab-table1" class="tab-pane fade in active">
                    <br>
                    <table id="table1" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                              <th class="number-td">No</th>
                              <th>Nama Obat</th>
                              <th>Harga Beli</th>
                              <th>Jumlah</th>
                              <th>Diterima</th>
                              <th>Diskon</th>
                              <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($d_beli as $data)
                            <tr>
                                <td class="number-td"></td>
                                <td>{{$data->obat->nama.' '.$data->obat->dosis.$data->obat->satuan_dosis.' ('.$data->obat->bentuk_sediaan.')'}}</td>
                                <td>Rp {{number_format($data->harga_beli,2,",",".")}}</td>
                                <td>{{$data->jumlah}}</td>
                                <td>{{$data->jumlah_terima}}</td>
                                <td>Rp {{number_format($data->diskon,2,",",".")}}</td>
                                <td>Rp {{number_format($data->subtotal_setelah_diskon,2,",",".")}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                  <div id="tab-table2" class="tab-pane fade">
                    <br>
                    <table id="table2" class="data-table row-border hover stripe table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                              <th class="number-td"></th>
                              <th>Nama Obat</th>
                              <th>Jumlah</th>
                              <th>Tanggal Terima</th>
                              <th>Tanggal Expired</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($penerimaan as $data)
                            <tr>
                              <td class="number-td"></td>
                              <td>{{$data->obat->nama.' '.$data->obat->dosis.$data->obat->satuan_dosis.' ('.$data->obat->bentuk_sediaan.')'}}</td>
                              <td>{{$data->jumlah}}</td>
                              <td>{{date("d-m-Y",strtotime($data->tanggal_terima))}}</td>
                              <td>{{date("d-m-Y",strtotime($data->tanggal_expired))}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function(){
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
         $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        });

        var t = $('#table1').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "ordering" : false,
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

        var t2 = $('#table2').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "ordering" : false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
        }
        } );

        t2.on( 'order.dt search.dt', function () {
            t2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endsection
