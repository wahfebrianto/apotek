@extends('layouts.app')

@section('content')
<div class="container auto-width">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Laporan</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form" method="GET" action="{{ url('laporan') }}">
                    <label class="col-md-2 control-label">Jenis Laporan : </label>
                    <div class="col-md-10">
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" value="laporan penjualan" Checked> <i></i> Laporan Penjualan </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" value="laporan pembelian"> <i></i> Laporan Pembelian </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" value="laporan laba rugi"> <i></i> Laporan Laba Rugi </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" value="laporan keluar masuk"> <i></i> Laporan Keluar Masuk </label></div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-md-10 col-md-offset-1">
                      <div class="col-md-2 radio i-checks"><label> <input type="radio" name="rangelaporan" value="harian" checked> <i></i> Harian </label></div>
                      <br>
                      <br>
                      <div class="col-md-3 col-md-offset-1">
                        <div class="input-group date form_datetime" id='datetimepicker-date-tanggalawal' data-link-field="tglawal">
                          <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
                          <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" name="tglawal" id="tglawal" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                      <div style="width: 15px; float:left;">
                        <label class="control-label"><span class="glyphicon glyphicon-minus mx-auto"></span></label>
                      </div>
                      <div class="col-md-3">
                        <div class="input-group date form_datetime" id='datetimepicker-date-tanggalakhir' data-link-field="tglakhir">
                          <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
                          <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" name="tglakhir" id="tglakhir" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-md-10 col-md-offset-1">
                      <div class="col-md-2 radio i-checks"><label> <input type="radio" name="rangelaporan" value="bulanan"> <i></i> Bulanan </label></div>
                      <br>
                      <br>
                      <div class="col-md-3 col-md-offset-1">
                        <div class="input-group date form_datetime" id='datetimepicker-date-bulan' data-link-field="bulan">
                          <input type='text' class="form-control" value="<?php echo date("M Y"); ?>" readonly>
                          <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" name="bulan" id="bulan" value="<?php echo date("m Y"); ?>">
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div>
                      <button type="submit" class="col-md-1 btn btn-lg btn-primary pull-right">
                          Lihat
                      </button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
            });

        });
        $('#datetimepicker-date-tanggalawal').datetimepicker({
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            format: 'dd MM yyyy',
            pickerPosition: "bottom-right"
        });
        $('#datetimepicker-date-tanggalakhir').datetimepicker({
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            format: 'dd MM yyyy',
            pickerPosition: "bottom-right"
        });
        $('#datetimepicker-date-bulan').datetimepicker({
            startView: 3,
            minView: 3,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            forceParse: 0,
            format: 'MM yyyy',
            pickerPosition: "bottom-right"
        });
</script>
@yield($report)
@endsection
