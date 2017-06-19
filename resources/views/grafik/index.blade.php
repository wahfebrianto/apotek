@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">Grafik Penjualan</div>
              <div class="panel-body">
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <form  class="form-horizontal" role="form" action="#" method="get">
                    <div class="form-group">
                        <label for="tgl" class="col-md-3 control-label text-left">Masukkan Tahun</label>
                        <div class=" col-md-3">
                          <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tgl">
                            <input type='text' class="form-control" value="<?php echo date("Y"); ?>" readonly>
                            <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                          <input type="hidden" name="tgl" id="tgl" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                      <input type="submit" class="col-md-1 btn btn-small btn-success" name="btn-sumbit-grafik" value="Pilih">
                    </div>
                    <script type="text/javascript">
                        $('#datetimepicker-date-tanggal').datetimepicker({
                            todayBtn:  1,
                            autoclose: 1,
                            todayHighlight: 1,
                            startView: 4,
                            minView: 4,
                            forceParse: 0,
                            format: 'yyyy',
                            pickerPosition: "bottom-left"
                        });
		                    var curdate = '<?php echo date("Y-m-d"); ?>';
		            	      $('#datetimepicker-date-tanggal').datetimepicker('setEndDate', curdate);
                    </script>
                </form>
                <br>
                <div id="col-graph"></div>

              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        Highcharts.chart('col-graph', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Grafik Omset Tahunan Apotek Valentino"
            },
          subtitle: {
              text: "<?php echo $year; ?>",
              x: -20
          },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
            title: {
                text: 'Rupiah'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Pendapatan',
                data: [
                  @foreach ($hasil["pendapatan"] as $val)
                    {{$val.","}}
                  @endforeach

                ]
            }, {
                name: 'Pengeluaran',
                data: [
                  @foreach ($hasil["pengeluaran"] as $val)
                    {{$val.","}}
                  @endforeach
]
            }, {
                name: 'Keuntungan',
                data: [
                  @foreach ($hasil["keuntungan"] as $val)
                    {{$val.","}}
                  @endforeach
]
            }]
        });
        //
        // $('.btn-bayar').click( function () {
        //     var idx = $('.btn-bayar').index(this);
        //     var rowData = t.rows(idx).data();
        //     var nonota = rowData[0][1];
        //     var tgl = $('#tgl').val();
        //     var r = confirm("Apakah Anda yakin ingin membayar pembelian ini ?");
        //     if(r){
        //       $.ajax({
        //           type: 'POST',
        //           url: '/pembayaran',
        //           data: {
        //               '_token' : '{{ csrf_token() }}',
        //               'nonota' : nonota,
        //               'tanggal_pembayaran' : tgl
        //           },
        //           success:function(){
        //              window.location.href = "/pembayaran";
        //          }
        //       });
        //     }
        //  });
    });
</script>
@endsection
