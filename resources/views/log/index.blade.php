@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Log</div>
              <div class="panel-body">
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <form class="form" style="margin-bottom:50px;" role="form" action="">
                    <div class="col-md-12 form-group">
                        <label for="nama_obat" class="col-md-2 control-label">Nama Obat</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="nama_obat" name="nama_obat">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="jenis" class="col-md-2 control-label">Jenis</label>
                        <div class="col-md-6">
                            <select class="form-control" id="jenis" name="jenis">
                              <option value="">Semua</option>
                              <option value="Stok">Stok</option>
                              <option value="Harga Jual">Harga Jual</option>
                            </select>
                        </div>
                    </div>
                </form>

                <table id="data-table" class="row-border stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>Tanggal</th>
                          <th>Nama Obat</th>
                          <th>Jenis</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($log as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
                            <td>{{$data->obat->nama." - ".$data->obat->dosis." (".$data->obat->bentuk_sediaan.")"}}</td>
                            <td>{{$data->jenis}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 col-lg-12 btn btn-small btn-info" href="{{ URL::to('log/' . $data->id ."/edit") }}">Ubah</a>
                                {{-- <a class="col-sm-12 col-lg-6 btn btn-small btn-warning" href="{{ url('log', [$data->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a> --}}
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
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var select = $('#jenis').val();
            var jenis = data[3];
            if(select==jenis || select=="")
              return true;
            return false;
        }
    );
    $(document).ready(function(){
        var t = $('#data-table').DataTable( {
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

        $('#jenis').change( function() {
          t.draw();
        });

        $('#nama_obat').on( 'keyup', function () {
            t
                .columns( 2 )
                .search( this.value )
                .draw();
        });
    });
</script>
@endsection
