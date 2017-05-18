@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message'))
            	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
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
                          <label for="nama" class="col-md-4 control-label">Nama Obat</label>
                          <div class="col-md-6">
                              <input id="nama" type="text" class="form-control" name="nama" value="{{$obat->nama.' '.$obat->dosis.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.')'}}" readonly>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="jenis" class="col-md-4 control-label">Jenis</label>
                          <div class="col-md-6">
                                <select class="form-control" id="jenis_stok" name="jenis">
                                    <option value="masuk">Masuk</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="tanggal" class="col-md-4 control-label">Tanggal</label>
                          <div class=" col-md-6">
                            <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tanggal">
      		                    <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" disabled>
      		                    <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <input type="hidden" name="tanggal" id="tanggal" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                      </div>

                      <div class="form-group" id="tanggal_expiredd">
                          <label for="tanggal_expired" class="col-md-4 control-label">Tanggal Expired</label>
                          <div class=" col-md-6">
                            <div class="input-group date form_datetime" id='datetimepicker-date-tanggal-expired' data-link-field="tanggal_expired">
      		                    <input type='text' class="form-control" value="<?php echo date("d F Y", strtotime('+1 years')); ?>" readonly>
                              <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" name="tanggal_expired" id="tanggal_expired" value="<?php echo date("Y-m-d", strtotime('+1 years')); ?>">
                          </div>
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
                          $('#datetimepicker-date-tanggal')
              						.datetimepicker()
              						.on('changeDate', function(ev){
              			            	var curdate = $('#tanggal').val();
              			            	$('#datetimepicker-date-tanggal-expired').datetimepicker('setStartDate', curdate);
              						});
            					</script>

                      <div class="form-group">
                          <label for="jumlah" class="col-md-4 control-label">Jumlah</label>
                          <div class="col-md-6">
                                <input id="jumlah" type="number" class="form-control" name="jumlah" value=1 min=1 required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="harga" class="col-md-4 control-label">Harga</label>
                          <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="harga" type="text" class="form-control" name="harga" required>
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
      $('#harga').number(true,0,',','.');

      // $('#jenis_stok').on('click',function(){
      //     if ($(this).val() == 'keluar') {
      //       $('#tanggal_expiredd').addClass('invis');
      //     }
      //     else if ($(this).val() == 'masuk') {
      //       $('#tanggal_expiredd').removeClass('invis');
      //     }
      // });
  });
</script>
@endsection
