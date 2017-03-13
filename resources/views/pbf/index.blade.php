@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">PBF</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('pbf/create') }}">PBF Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border stripe" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th></th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                          <th>Nama CP</th>
                          <th>Telepon CP</th>
                          <th>Tergolong Pajak</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($pbfData as $pbf)
                        <tr>
                            <td></td>
                            <td>{{$pbf->nama}}</td>
                            <td>{{$pbf->alamat}}</td>
                            <td>{{$pbf->telepon}}</td>
                            <td>{{$pbf->nama_cp}}</td>
                            <td>{{$pbf->telp_cp}}</td>
                            <td>{{($pbf->tergolong_pajak) == 0 ? "Tidak" : "Ya"}}</td>
                            <td>{{$pbf->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 btn btn-small btn-info" href="{{ URL::to('pbf/'.$pbf->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-12 btn btn-small btn-warning" href="{{ url('pbf', [$pbf->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
