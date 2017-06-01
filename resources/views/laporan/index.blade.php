@extends('layouts.app')

@section('content')
<div class="container auto-width">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Generate Laporan</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form" method="GET" action="{{ url('laporan/generate') }}">
                    <label class="col-md-2 control-label">Jenis Laporan : </label>
                    <div class="col-md-10">
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_penjualan" value="laporan_penjualan" checked> <i></i> Laporan Penjualan </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_pembelian" value="laporan_pembelian"> <i></i> Laporan Pembelian </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_laba_rugi" value="laporan_laba_rugi"> <i></i> Laporan Laba Rugi </label></div>
                      <div class="col-md-3 radio i-checks"><label> <input type="radio" name="jenislaporan" id="laporan_keluar_masuk" value="laporan_keluar_masuk"> <i></i> Laporan Barang </label></div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-md-10 col-md-offset-1">
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
                    <div class="col-md-10 col-md-offset-1">
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
                      <button type="submit" class="col-md-1 btn btn-lg btn-success pull-right" name="btnPrint" style="margin-left:10px">Print</button>
                      <button type="submit" class="col-md-1 btn btn-lg btn-primary pull-right" name="btnLihat">Lihat</button>
                    </div>
                </form>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">Laporan</div>
              <div class="panel-body animated fadeInRight" id="laporan">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img src="/assets/logo.png" width="5%">
                        <h4 class="text-navy"><b>APOTEK VALENTINO</b></h4>
                        <p>
                            <span><strong>No Ijin : </strong>11111.111.111.1.1</span><br/>
                            <span>Jl. blablablablabla</span><br/>
                            <span>Telp. (031) 635-1234</span>
                        </p>
                        <h4 class="text-navy"><b>LAPORAN PENJUALAN</b></h4>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>Item List</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div><strong>Admin Theme with psd project layouts</strong></div>
                                    <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                                </td>
                                <td>1</td>
                                <td>$26.00</td>
                                <td>$5.98</td>
                                <td>$31,98</td>
                            </tr>
                            <tr>
                                <td>
                                    <div><strong>Wodpress Them customization</strong></div>
                                    <small>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        Eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </small>
                                </td>
                                <td>2</td>
                                <td>$80.00</td>
                                <td>$36.80</td>
                                <td>$196.80</td>
                            </tr>
                            <tr>
                                <td>
                                    <div><strong>Angular JS & Node JS Application</strong></div>
                                    <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                                </td>
                                <td>3</td>
                                <td>$420.00</td>
                                <td>$193.20</td>
                                <td>$1033.20</td>
                            </tr>

                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td><strong>Sub Total :</strong></td>
                            <td>$1026.00</td>
                        </tr>
                        <tr>
                            <td><strong>TAX :</strong></td>
                            <td>$235.98</td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td>$1261.98</td>
                        </tr>
                    </tbody>
                </table>
              </div>
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
      });

</script>
@yield($report)
@endsection
