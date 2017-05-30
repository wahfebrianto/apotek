@extends('layouts.app')

@section('content')
<div class="container auto-width">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Pembelian</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('pembelian/create') }}">Pembelian Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table id="data-table" class="row-border hover stripe table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th class="number-td">No</th>
                          <th>No. Nota</th>
                          <th>PBF</th>
                          <th>Tanggal Pemesanan</th>
                          <th>Tanggal Jatuh Tempo</th>
                          {{-- <th>Total</th>
                          <th>Diskon</th> --}}
                          <th>Grand Total</th>
                          <th>Pegawai</th>
                          <th>Status Pembayaran</th>
                          <th>Keterangan</th>
                          <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($dataPembelian as $data)
                        <tr>
                            <td class="number-td"></td>
                            <td>{{$data->no_nota}}</td>
                            <td>{{$data->pbf->nama}}</td>
                            <td>{{date("d-m-Y",strtotime($data->tanggal_pesan))}}</td>
                            <td>{{date("d-m-Y",strtotime($data->tanggal_jatuh_tempo))}}</td>
                            {{-- <td>Rp {{number_format($data->total,2,",",".")}}</td>
                            <td>Rp {{number_format($data->diskon,2,",",".")}}</td> --}}
                            <td>Rp {{number_format($data->grand_total,2,",",".")}}</td>
                            <td>{{$data->user->nama}}</td>
                            <td>{{($data->tanggal_pembayaran==0)? 'BELUM LUNAS' : 'LUNAS'}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <a class="col-sm-12 btn btn-info btn-action" href="{{ URL::to('pembelian/list/'.$data->no_nota) }}">Lihat</a>
                                <a class="col-sm-12 btn btn-warning btn-action" href="{{ url('pembelian', [$data->no_nota]) }}" data-method="delete" data-token="{{csrf_token()}}">Hapus</a>
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
