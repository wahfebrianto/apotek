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
                            <td>{{$data->obat->nama}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <a class="col-sm-11 col-lg-5 btn btn-small btn-info" href="{{ URL::to('log/' . $data->id ."/edit") }}">Ubah</a>
                                <a class="col-sm-11 col-lg-5 btn btn-small btn-warning pull-right" href="{{ url('log', [$data->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
        "order": [[ 1, 'asc' ]],
        "responsive": true
        } );

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endsection
