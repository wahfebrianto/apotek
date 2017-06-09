@extends('layouts.app')

@section('content')
<div class="container auto-width">
  <div class="row">
      <div class="col-md-12 divcol">
          <div class="panel panel-default" id="panel-generate">
            <div class="panel-heading">Generate Laporan</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="GET" action="{{ url('laporan/generate') }}">
                  <label class="col-md-2 control-label">Jenis Laporan : </label>
                  <div class="col-md-10">
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_penjualan" value="laporan_penjualan" checked> <i></i> Laporan Penjualan </label></div>
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_pembelian" value="laporan_pembelian"> <i></i> Laporan Pembelian </label></div>
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_laba_rugi_bersih" value="laporan_laba_rugi_bersih"> <i></i> Laporan Laba Rugi Bersih </label></div>
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_laba_rugi_kotor" value="laporan_laba_rugi_kotor"> <i></i> Laporan Laba Rugi Kotor </label></div>
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_obat" value="laporan_obat"> <i></i> Laporan Obat </label></div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <div class="col-md-10 col-md-offset-1" id="divharian">
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="rangelaporan" id="harian" value="harian" checked> <i></i> Harian </label></div>
                    <br>
                    <br>
                    <div class="col-md-3 col-md-offset-1">
                      <div class="input-group date form_datetime" id='datetimepicker-date-tanggalawal' data-link-field="tglawal">
                        <input type='text' class="form-control" id="txttglawal" value="<?php echo date("d F Y"); ?>" readonly>
                        <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                      <input type="hidden" name="tglawal" id="tglawal" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div style="width: 15px; float:left;">
                      <label class="control-label"><span class="glyphicon glyphicon-minus mx-auto"></span></label>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group date form_datetime" id='datetimepicker-date-tanggalakhir' data-link-field="tglakhir">
                        <input type='text' class="form-control" id="txttglakhir" value="<?php echo date("d F Y"); ?>" readonly>
                        <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                      <input type="hidden" name="tglakhir" id="tglakhir" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <div class="col-md-10 col-md-offset-1" id="divbulanan">
                    <div class="col-md-2 radio i-checks"><label> <input type="radio" name="rangelaporan" id="bulanan" value="bulanan"> <i></i> Bulanan </label></div>
                    <br>
                    <br>
                    <div class="col-md-3 col-md-offset-1">
                      <div class="input-group date form_datetime" id='datetimepicker-date-bulan' data-link-field="bulan">
                        <input type='text' class="form-control" id="txtbulan"  value="<?php echo date("F Y"); ?>" readonly>
                        <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                      <input type="hidden" name="bulan" id="bulan" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <div>
                    <button type="button" class="col-md-1 btn btn-lg btn-success pull-right" id="btnPrint" style="margin-left:10px">Print</button>
                    <button type="submit" class="col-md-1 btn btn-lg btn-primary pull-right" name="btnLihat">Lihat</button>
                  </div>
              </form>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" id="laporan-head">Laporan</div>
            <div class="panel-body animated fadeInRight" id="laporan">
              @yield('child')
              <table class="table invoice-total" id="tempat-ttd">
                  <tbody>
                      <tr>
                          <td class="text-center">Surabaya, {{date("d F Y")}}</td>
                      </tr>
                      <tr>
                          <td class="text-center">Apoteker</td>
                      </tr>
                      <tr>
                          <td class="text-center"></td>
                      </tr>
                      <tr>
                          <td class="text-center"></td>
                      </tr>
                      <tr>
                          <td class="text-center"></td>
                      </tr>
                      <tr>
                          <td class="text-center"></td>
                      </tr>
                      <tr>
                          <td class="text-center"><u>Dra. Lusiwati .T. M Farm-Klin Apt</u></td>
                      </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
      $(document).ready(function () {

          @if (isset($data["jenislaporan"]))
            $("#{{$data['jenislaporan']}}").attr("checked", true);
            $("#{{$data['rangelaporan']}}").attr("checked", true);
            $("#txttglawal").attr("value", "<?php echo date("d F Y",strtotime($data['tglawal'])); ?>");
            $("#tglawal").attr("value", "<?php echo date("Y-m-d",strtotime($data['tglawal'])); ?>");
            $("#txttglakhir").attr("value", "<?php echo date("d F Y",strtotime($data['tglakhir'])); ?>");
            $("#tglawal").attr("value", "<?php echo date("Y-m-d",strtotime($data['tglawal'])); ?>");
            $("#txtbulan").attr("value", "<?php echo date("M Y",strtotime($data['bulan'])); ?>");
            $("#bulan").attr("value", "<?php echo date("Y-m-d",strtotime($data['bulan'])); ?>");
          @endif

          $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
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
          $('#btnPrint').click(function(){
              window.print();
          });
      });

</script>
@endsection
