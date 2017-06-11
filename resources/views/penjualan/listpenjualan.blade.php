@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Data Penjualan - {{$h_jual->no_nota}}</div>
              <div class="panel-body">
                <div class="overview">
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Pegawai</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$h_jual->user->nama}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Total</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_jual->total,2,",",".")}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Tanggal Transaksi</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{date("d-m-Y",strtotime($h_jual->tgl))}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Diskon</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_jual->diskon,2,",",".")}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Grand Total</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($h_jual->grand_total,2,",",".")}}</label>
                    </div>
                </div>
                <div class="overview">
                   <div class="col-md-offset-6 col-md-6 overview-line no-padding">
                     <a class="col-sm-offset-9 col-sm-3 btn btn-info btn-action" href="{{ URL::to('penjualan/copyresep/'.$h_jual->no_nota) }}">Copy Resep</a>
                  </div>
                </div>
				        <hr />
                <h4>Daftar Obat</h4>
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="table1" class="hover stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>Nama Obat</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Diskon</th>
                          <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($d_jual as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$data->obat->nama.' '.$data->obat->dosis.$data->obat->satuan_dosis.' ('.$data->obat->bentuk_sediaan.')'}}</td>
                            <td>Rp {{number_format($data->harga_jual,2,",",".")}}</td>
                            <td>{{$data->jumlah}}</td>
                            <td>Rp {{number_format($data->diskon,2,",",".")}}</td>
                            <td>Rp {{number_format($data->subtotal_jual_setelah_diskon,2,",",".")}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <hr />
                <h4>Daftar Resep</h4>
                <table id="table2" class="hover stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>Nama Racikan</th>
                          <th>Total</th>
                          <th>Jumlah</th>
                          <th>Biaya Kemasan</th>
                          <th>Diskon</th>
                          <th>Subtotal</th>
                          <th>Keterangan</th>
                          <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($h_resep as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$data->nama_racikan.'('.$data->bentuk_sediaan.')'}}</td>
                            <td>Rp {{number_format($data->total,2,",",".")}}</td>
                            <td>{{$data->jumlah}}</td>
                            <td>Rp {{number_format(($data->biaya_kemasan/$data->jumlah),2,",",".")}}</td>
                            <td>Rp {{number_format($data->diskon,2,",",".")}}</td>
                            <td>Rp {{number_format($data->grand_total,2,",",".")}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td></td>
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
<script>
        $(document).ready(function(){

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
          },
          {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": '',
            "targets": 8
          }
        ],
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

        function nestedTable(table,n){
            // `d` is the original data object for the row
            var result = '<table class="table-bordered" cellpadding="5" cellspacing="0" style="margin-left:6%;" width="94%">';
            result +=
            '<thead><tr><th>No</th><th>Nama Obat</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr></thead><tbody>';
            for (var i = 0; i < table.length; i++) {
              // alert(convertToInt(table[i][3]));
              result +=
                '<tr>'+
                    '<td>'+table[i][0]+'</td>'+
                    '<td>'+table[i][1]+'</td>'+
                    '<td>Rp '+$.number((table[i][2])*n)+'</td>'+
                    '<td>'+table[i][3]+'</td>'+
                    '<td>Rp '+$.number((table[i][4])*n)+'</td>'+
                '</tr>';
            }
            result += '</tbody></table>';

            return result;
        }

        // Add event listener for opening and closing details
        $('#table2 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = t2.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child.show();
                tr.addClass('shown');
            }
        } );

        var dataHResep = t2.rows().data();
        <?php $idx=0; ?>
        for (var i = 0; i < dataHResep.length; i++) {
          var rowResepData = [];
          <?php $i=0; ?>
          @if (sizeof($d_resep)>0)
          @foreach ($d_resep[$idx] as $data)
              rowResepData[{{$i}}] = [];
              rowResepData[{{$i}}][0] = ({{$i}}+1);
              rowResepData[{{$i}}][1] = "{{$data->obat->nama.' '.$data->obat->dosis.$data->obat->satuan_dosis.' ('.$data->obat->bentuk_sediaan.')'}}";
              rowResepData[{{$i}}][2] = {{$data->harga_jual}};
              rowResepData[{{$i}}][3] = {{$data->jumlah}};
              rowResepData[{{$i}}][4] = {{$data->subtotal_jual}};
              <?php $i=$i+1; ?>
          @endforeach
          @endif
          t2.row(i).child(nestedTable(rowResepData,1)).show();
          t2.row(i).child.hide();
          <?php $idx=$idx+1; ?>
        }
    });
</script>
@endsection
