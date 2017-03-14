@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">Obat</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('obat/create') }}">Obat Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border stripe" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th></th>
                          <th>Nama</th>
                          <th>Jenis Pamakologi</th>
                          <th>Dosis</th>
                          <th>Bentuk Sediaan</th>
                          <th>Harga Jual</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($obatData as $obat)
                        <tr>
                            <td></td>
                            <td>{{(string)$obat->id}}</td>
                            <td>{{$obat->Pamakologi->nama}}</td>
                            <td>{{$obat->dosis}}</td>
                            <td>{{$obat->bentuk_sediaan}}</td>
                            <td>Rp {{number_format($obat->harga_jual,2,",",".")}}</td>
                            <td>{{$obat->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 col-lg-6 btn btn-small btn-info" href="{{ URL::to('obat/'.$obat->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-12 col-lg-6 btn btn-small btn-warning" href="{{ url('obat', [$obat->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
