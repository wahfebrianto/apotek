@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">Log</div>
              <div class="panel-body">
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table class="table table-striped table-bordered" id="table-log">
                    <thead>
                      <tr>
                          <th></th>
                          <th>Tanggal</th>
                          <th>Nama Obat</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($log as $data)
                        <tr>
                            <td></td>
                            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
                            <td>{{$data->Obat->nama}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <a class="btn btn-small btn-info" href="{{ URL::to('log/edit/' . $data->id ) }}">Ubah</a>
                                <a class="btn btn-small btn-warning pull-right" href="{{ URL::to('log/delete/' . $data->id ) }}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <th></th>
                          <th>Tanggal</th>
                          <th>Nama Obat</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </tfoot>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var t = $('#table-log').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]]
        } );

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endsection
