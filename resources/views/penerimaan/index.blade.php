@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">List Barang yang Belum Diterima</div>
              <div class="panel-body">
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <form  class="form-horizontal" role="form" action="#" method="get">
                    <div class="form-group">
                        <label for="tgl" class="col-md-3 control-label text-left">Masukkan Tanggal Terima</label>
                        <div class=" col-md-3">
                          <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tgl">
                            <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
                            <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                          <input type="hidden" name="tgl" id="tgl" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_expired" class="col-md-3 control-label text-left">Masukkan Tanggal Expired</label>
                        <div class=" col-md-3">
                          <div class="input-group date form_datetime" id='datetimepicker-date-tanggal_expired' data-link-field="tanggal_expired">
                            <input type='text' class="form-control" value="<?php echo date("d F Y", strtotime('+1 years')); ?>" readonly>
                            <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                          <input type="hidden" name="tanggal_expired" id="tanggal_expired" value="<?php echo date("Y-m-d", strtotime('+1 years')); ?>">
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
                        $('#datetimepicker-date-tanggal_expired').datetimepicker({
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
                          <th>id_obat</th>
                          <th>Nama Obat</th>
                          <th>Harga Beli</th>
                          <th>Jumlah</th>
                          <th>Tanggal Pemesanan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($penerimaanData as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$data->no_nota}}</td>
                            <td>{{$data->id_obat}}</td>
                            <td>{{$data->obat->nama.' '.$data->obat->dosis.'-'.$data->obat->satuan_dosis.' ('.$data->obat->bentuk_sediaan.')'}}</td>
                            <td>{{$data->harga_beli}}</td>
                            <td>{{$data->jumlah}}</td>
                            <td>{{date("d-m-Y",strtotime($data->h_beli->tanggal_pesan))}}</td>
                            <td>
                              <button class="col-sm-12 btn btn-info btn-action btn-terima">Terima</button>
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
          },
          {
            "targets": [2],
            "visible": false
          },
          {
            "targets": [4],
            "visible": false
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

        $('.btn-terima').click( function () {
            var idx = $('.btn-terima').index(this);
            var rowData = t.rows(idx).data();
            var nonota = rowData[0][1];
            var id_obat = rowData[0][2];
            var nama_obat = rowData[0][3];
            var harga_beli = rowData[0][4];
            var jumlah = rowData[0][5];
            var tgl = $('#tgl').val();
            var tgl_expired = $('#tanggal_expired').val();
            var r = confirm("Apakah Anda yakin dengan penerimaan obat ini ?");
            if(r){
              $.ajax({
                  type: 'POST',
                  url: '/penerimaan',
                  data: {
                      '_token' : '{{ csrf_token() }}',
                      'nonota' : nonota,
                      'id_obat' : id_obat,
                      'nama_obat' : nama_obat,
                      'harga_beli' : harga_beli,
                      'jumlah' : jumlah,
                      'tanggal_terima' : tgl,
                      'tanggal_expired' : tgl_expired
                  },
                  success:function(){
                     window.location.href = "/penerimaan";
                 }
              });
            }
        });
    });
</script>
@endsection
