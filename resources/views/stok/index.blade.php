@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Kartu Stok</div>
              <div class="panel-body">

                <div class="overview">
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Nama Obat</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$obat->nama}}</label>
                    </div>
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Dosis</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$obat->dosis}}</label>
                    </div>
                    <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Bentuk Sediaan</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$obat->bentuk_sediaan}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Total Stok</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{$overview["total_stok"]}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Tanggal Expired Terdekat</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">{{date("d-m-Y",strtotime($overview["expired"]))}}</label>
                    </div>
                   <div class="col-md-6 overview-line no-padding">
                      <label class="col-xs-5 no-padding">Rata-rata Harga Beli</label>
                      <label class="col-xs-1 no-padding">:</label>
                      <label class="col-xs-6 no-padding">Rp {{number_format($overview["harga_beli"],2,",",".")}}</label>
                    </div>
                </div>
                <a class="btn btn-small btn-success" href="{{ URL::to('stok/'.$obat->id.'/create') }}">Stok Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <table id="data-table" class="row-border hover stripe" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th></th>
                          <th>Tanggal Beli</th>
                          <th>Tanggal Expired</th>
                          <th>Stok</th>
                          <th>Harga Beli</th>
                          <th>Keterangan</th>
                          <th>Penyesuaian Stok</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($stokData as $stok)
                        <tr>
                            <td></td>
                            <td>{{date("d-m-Y",strtotime($stok->tanggal_beli))}}</td>
                            <td>{{date("d-m-Y",strtotime($stok->expired_date))}}</td>
                            <td>{{$stok->stok}}</td>
                            <td>Rp {{number_format($stok->harga_beli,2,",",".")}}</td>
                            <td>{{$stok->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 col-lg-6 btn btn-info btn-action" href="{{ URL::to('stok/'.$stok->id.'/edit') }}">Ubah</a>
                                <a class="col-sm-12 col-lg-6 btn btn-warning btn-action" href="{{ url('stok', [$stok->id]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
