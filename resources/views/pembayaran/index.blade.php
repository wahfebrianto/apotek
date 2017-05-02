@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">List Pembelian yang Belum Dibayar</div>
              <div class="panel-body">
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <form  class="form-horizontal" role="form" action="#" method="get">
                    <div class="form-group">
                        <label for="tgl" class="col-md-3 control-label text-left">Masukkan Tanggal Pembayaran</label>
                        <div class=" col-md-3">
                          <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tgl">
                            <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
                            <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                          <input type="hidden" name="tgl" id="tgl" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>
                    <script type="text/javascript">
                        $('#datetimepicker-date-tanggal').datetimepicker({
                            todayBtn:  1,
                            autoclose: 1,
                            todayHighlight: 1,
                            startView: 2,
                            minView: 2,
                            forceParse: 0,
                            format: 'dd MM yyyy',
                            pickerPosition: "bottom-left"
                        });
                    </script>
                </form>

                <table id="data-table" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>No Nota</th>
                          <th>Tanggal Pemesanan</th>
                          <th>Tanggal Jatuh Tempo</th>
                          <th>Grand Total</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($pembayaranData as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$data->no_nota}}</td>
                            <td>{{date("d-m-Y",strtotime($data->tanggal_pesan))}}</td>
                            <td>{{date("d-m-Y",strtotime($data->tanggal_jatuh_tempo))}}</td>
                            <td>Rp {{number_format($data->grand_total,2,",",".")}}</td>
                            <td>
                              <button class="col-sm-12 btn btn-info btn-action btn-bayar">Bayar</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var t = $('#data-table').DataTable( {
        "columnDefs": [
           {
            "searchable": false,
            "orderable": false,
            "targets": 0
          }
        ],
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

        $('.btn-bayar').click( function () {
            var idx = $('.btn-bayar').index(this);
            var rowData = t.rows(idx).data();
            var nonota = rowData[0][1];
            var tgl = $('#tgl').val();
            var r = confirm("Apakah Anda yakin ingin membayar pembelian ini ?");
            if(r){
              $.ajax({
                  type: 'POST',
                  url: '/pembayaran',
                  data: {
                      '_token' : '{{ csrf_token() }}',
                      'nonota' : nonota,
                      'tanggal_pembayaran' : tgl
                  },
                  success:function(){
                     window.location.href = "/pembayaran";
                 }
              });
            }
        });
    });
</script>
@endsection
