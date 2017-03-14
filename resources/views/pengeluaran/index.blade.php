@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Pengeluaran</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('pengeluaran/create') }}">Pengeluaran Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border stripe" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th></th>
                          <th>Tgl</th>
                          <th>Nama</th>
                          <th>Harga</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($pengeluaran as $data)
                        <tr>
                            <td></td>
                            <td>{{date('d/m/Y', strtotime($data->tgl))}}</td>
                            <td>{{$data->nama}}</td>
                            <td>Rp {{number_format($data->harga,2,",",".")}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <a class="col-sm-11 col-lg-5 btn btn-small btn-info" href="{{ URL::to('pengeluaran/'.$data->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-11 col-lg-5 btn btn-small btn-warning pull-right" href="{{ url('pengeluaran', [$data->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
