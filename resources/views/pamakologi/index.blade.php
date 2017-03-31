@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Pamakologi</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('pamakologi/create') }}">Pamakologi Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>Nama</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($pamakologiData as $pamakologi)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$pamakologi->nama}}</td>
                            <td>{{$pamakologi->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 col-lg-5 btn btn-small btn-info less-margin" href="{{ URL::to('pamakologi/'.$pamakologi->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-12 col-lg-5 btn btn-small btn-warning less-margin" href="{{ url('pamakologi', [$pamakologi->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
    });
</script>
@endsection
