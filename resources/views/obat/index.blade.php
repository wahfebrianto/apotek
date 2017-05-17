@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Obat</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('obat/create') }}">Obat Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>Nama</th>
                          <th>Jenis Pamakologi</th>
                          <th>Dosis</th>
                          <th>Satuan Dosis</th>
                          <th>Bentuk Sediaan</th>
                          <th>Harga Jual</th>
                          <th class="number-td">Stok</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $idx = 0; ?>
                    @foreach ($obatData as $obat)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$obat->nama}}</td>
                            <td>{{$obat->pamakologi->nama}}</td>
                            <td>{{$obat->dosis}}</td>
                            <td>{{$obat->satuan_dosis}}</td>
                            <td>{{$obat->bentuk_sediaan}}</td>
                            <td>Rp {{number_format($obat->harga_jual,2,",",".")}}</td>
                            <td class="number-td">{{$total_stok[$idx]}}</td>
                            <td>{{$obat->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 col-lg-12 btn btn-primary btn-action" href="{{ URL::to('stok/'.$obat->id) }}">Stok</a>
                                <a class="col-sm-12 col-lg-6 btn btn-info btn-action" href="{{ URL::to('obat/'.$obat->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-12 col-lg-6 btn btn-warning btn-action" href="{{ url('obat', [$obat->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
                            </td>
                        </tr>
                        <?php $idx=$idx+1; ?>
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
