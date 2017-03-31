@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Stok Baru</div>
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

                  <form class="form-horizontal" role="form" method="POST" action="{{ route('stok.store') }}">
                      {{ csrf_field() }}
                      <input type="hidden" name="id_obat" value="{{$obat->id}}">
                      <div class="form-group">
                          <label for="nama" class="col-md-4 control-label">Nama</label>
                          <div class="col-md-6">
                              <input id="nama" type="text" class="form-control" name="nama" value="{{$obat->nama}}" readonly>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="tanggal_beli" class="col-md-4 control-label">Tanggal Beli</label>
                          <div class=" col-md-6">
                            <div class="input-group date form_datetime" id='datetimepicker-date-tanggal-beli' data-link-field="tanggal_beli">
      		                    <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
      		                    <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <input type="hidden" name="tanggal_beli" id="tanggal_beli" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                      </div>

                      <div class="form-group">
                          <label for="tanggal_expired" class="col-md-4 control-label">Tanggal Expired</label>
                          <div class=" col-md-6">
                            <div class="input-group date form_datetime" id='datetimepicker-date-tanggal-expired' data-link-field="tanggal_expired">
      		                    <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
      		                    <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <input type="hidden" name="tanggal_expired" id="tanggal_expired" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                      </div>
                      <script type="text/javascript">
            					    $('#datetimepicker-date-tanggal-beli').datetimepicker({
            					        todayBtn:  1,
                							autoclose: 1,
                							todayHighlight: 1,
                							startView: 2,
                							minView: 2,
                							forceParse: 0,
            					        format: 'dd MM yyyy',
                						  pickerPosition: "bottom-left"
            					    });
            					    var curdate = '<?php echo date("Y-m-d"); ?>';
        		            	//$('#datetimepicker-date-tanggal-beli').datetimepicker('setEndDate', curdate);

            					    $('#datetimepicker-date-tanggal-expired').datetimepicker({
            					        todayBtn:  1,
                							autoclose: 1,
                							todayHighlight: 1,
                							startView: 2,
                							minView: 2,
                							forceParse: 0,
            					        format: 'dd MM yyyy',
                						  pickerPosition: "bottom-left"
            					    });

                          $('#datetimepicker-date-tanggal-expired').datetimepicker('setStartDate', curdate);
                          $('#datetimepicker-date-tanggal-beli')
              						.datetimepicker()
              						.on('changeDate', function(ev){
              			            	var curdate = $('#tanggal_beli').val();
              			            	$('#datetimepicker-date-tanggal-expired').datetimepicker('setStartDate', curdate);
              						});
            					</script>

                      <div class="form-group">
                          <label for="stok" class="col-md-4 control-label">Stok</label>
                          <div class="col-md-6">
                                <input id="stok" type="number" class="form-control" name="stok" value=1 min=1 required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="harga_beli" class="col-md-4 control-label">Harga Beli</label>
                          <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="harga_beli" type="text" class="form-control" name="harga_beli" required>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="keterangan" class="col-md-4 control-label">Keterangan</label>
                          <div class="col-md-6">
                              <textarea id="keterangan" class="form-control" name="keterangan" cols="40" rows="5"></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary">Simpan</button>
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
      $('#harga_beli').number(true,0,',','.');
  });
</script>
@endsection
