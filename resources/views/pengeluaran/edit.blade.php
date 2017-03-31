@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ubah Pengeluaran</div>
                <div class="panel-body">
                  @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif

                  <form class="form-horizontal" role="form" method="POST" action="{{ url('pengeluaran', [$pengeluaran->id]) }}">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="form-group">
                      <label for="tgl" class="col-md-4 control-label">Tanggal</label>
                      <div class=" col-md-6">
                        <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tgl">
                          <input type='text' class="form-control" value="<?php echo date("d F Y",strtotime($pengeluaran->tgl)); ?>" readonly>
                          <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" name="tgl" id="tgl" value="<?php echo date("Y-m-d",strtotime($pengeluaran->tgl)); ?>">
                    </div>
                  </div>
                  <script type="text/javascript">
                      $('#datetimepicker-date-tanggal').datetimepicker({
                          todayBtn:  1,
                          autoclose: 1,
                          todayHighlight: 1,
                          startView: 2,
                          minView: 2,
                          forceParse: 0,
                          format: 'dd MM yyyy',
                          pickerPosition: "bottom-left"
                      });
                  </script>

                  <div class="form-group">
                      <label for="nama" class="col-md-4 control-label">Nama</label>

                      <div class="col-md-6">
                        <select id="nama" class="selectpicker form-control" name="nama">
                            @foreach ($users as $user)
                                <option>{{$user->nama}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="harga" class="col-md-4 control-label">Harga</label>
                      <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input id="harga" type="number" class="form-control" name="harga" value="{{ $pengeluaran->harga }}" autofocus>
                            <span class="input-group-addon">.00</span>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="keterangan" class="col-md-4 control-label">Keterangan</label>

                      <div class="col-md-6">
                          <input id="keterangan" type="text" class="form-control" name="keterangan" value="{{ $pengeluaran->keterangan }} "required>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">
                              Simpan
                          </button>
                      </div>
                  </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#nama").val('{{ $pengeluaran->nama }}');
    $('#harga').number(true,0,',','.');
});
</script>
@endsection
