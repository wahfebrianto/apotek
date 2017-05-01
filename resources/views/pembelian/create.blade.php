@extends('layouts.app')

@section('content')
<div class="container auto-width">
    @if (Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <div class="row trans-custom ">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('pembelian.store') }}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <div class="col-md-5">
              <div class="panel panel-default">
                  <div class="panel-heading font-size-doubled">Data Transaksi</div>
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

                        <div class="form-group">
                            <label for="no_nota" class="col-md-3 control-label">No. Nota</label>
                            <div class="col-md-9">
                                <input id="no_nota" type="text" class="form-control" value="{{$nonota}}" name="no_nota" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_pbf" class="col-md-3 control-label">PBF</label>
                            <div class="col-md-9">
                                <select class="form-control" id="id_pbf" name="id_pbf">
                                    @foreach ($pbfData as $pbf)
                                        <option value="{{$pbf->id}}">{{$pbf->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pesan" class="col-md-3 control-label">Tanggal Pemesanan</label>
                            <div class=" col-md-9">
                              <div class="input-group date form_datetime" id='datetimepicker-date-tanggal-pesan' data-link-field="tanggal_pesan">
        		                    <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
        		                    <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                              <input type="hidden" name="tanggal_pesan" id="tanggal_pesan" value="<?php echo date("Y-m-d"); ?>">
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_jatuh_tempo" class="col-md-3 control-label">Tanggal Jatuh Tempo</label>
                            <div class=" col-md-9">
                              <div class="input-group date form_datetime" id='datetimepicker-date-tanggal-jatuh-tempo' data-link-field="tanggal_jatuh_tempo">
        		                    <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
        		                    <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                              <input type="hidden" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="<?php echo date("Y-m-d"); ?>">
                          </div>
                        </div>

                        <script type="text/javascript">
              					    $('#datetimepicker-date-tanggal-pesan').datetimepicker({
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
          		            	//$('#datetimepicker-date-tanggal-pesan').datetimepicker('setEndDate', curdate);

              					    $('#datetimepicker-date-tanggal-jatuh-tempo').datetimepicker({
              					        todayBtn:  1,
                  							autoclose: 1,
                  							todayHighlight: 1,
                  							startView: 2,
                  							minView: 2,
                  							forceParse: 0,
              					        format: 'dd MM yyyy',
                  						  pickerPosition: "bottom-left"
              					    });

                            $('#datetimepicker-date-tanggal-jatuh-tempo').datetimepicker('setStartDate', curdate);
                            $('#datetimepicker-date-tanggal-pesan')
                						.datetimepicker()
                						.on('changeDate', function(ev){
                			            	var curdate = $('#tanggal_pesan').val();
                			            	$('#datetimepicker-date-tanggal-jatuh-tempo').datetimepicker('setStartDate', curdate);
                						});
              					</script>

                        <div class="form-group">
                            <label for="total" class="col-md-3 control-label">Total</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="total" type="text" class="form-control" name="total" value=0 readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="diskon" class="col-md-3 control-label">Diskon</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="diskon" type="text" class="form-control" name="diskon" value=0>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="grand_total" class="col-md-3 control-label">Grand Total</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="grand_total" type="text" class="form-control" name="grand_total" value=0 readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="col-md-3 control-label">Keterangan</label>
                            <div class="col-md-9">
                                <textarea id="keterangan" class="form-control" name="keterangan" cols="40" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-9">
                                <button type="submit" class="btn btn-primary auto-width">Simpan</button>
                            </div>
                        </div>
                  </div>
              </div>
            </div>

            <div class="col-md-7">
              <div class="panel panel-default">
                  <div class="panel-heading font-size-doubled">Input Obat</div>
                  <div class="panel-body">
                      <div class="form-group">
                          <label for="nama_obat" class="col-md-2 control-label">Nama Obat</label>
                          <div class="col-md-10">
                            <select class="form-control" id="nama_obat" name="nama_obat" required>
                                @foreach ($obatData as $obat)
                                    <option value="{{$obat->id.';'.$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.')'}}">{{$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.')'}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="harga_beli" class="col-md-2 control-label">Harga Beli</label>
                          <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="harga_beli" type="text" class="form-control" name="harga_beli" autofocus>
                              </div>
                          </div>
                          <label for="jumlah" class="col-md-1 control-label">Qty</label>
                          <div class="col-md-3">
                              <input id="jumlah" type="number" class="form-control" name="jumlah" value=1 min=1 autofocus>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="subtotal" class="col-md-2 control-label">Subtotal</label>
                          <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="subtotal" type="text" class="form-control" name="subtotal" value=0 readonly>
                              </div>
                          </div>
                          <label for="diskonobat" class="col-md-1 control-label">Diskon</label>
                          <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="diskonobat" type="text" class="form-control" name="diskonobat" value=0 autofocus>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="subsubtotal" class="col-md-2 control-label">Subtotal Setelah Diskon</label>
                          <div class="col-md-10">
                              <div class="input-group">
                              <span class="input-group-addon">Rp</span>
                              <input id="subsubtotal" type="text" class="form-control" name="subsubtotal" value=0 readonly>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-2 col-md-offset-8">
                              <input type="button" class="btn btn-primary auto-width" value="Hapus" id="btn-hapus-obat">
                          </div>
                          <div class="col-md-2">
                              <input type="button" class="btn btn-primary auto-width" value="Tambah" id="btn-tambah-obat">
                          </div>
                      </div>
                      <table id="data-table" class="row-border hover striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>id_obat</th>
                                <th>Nama Obat</th>
                                <th>Harga Beli</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Subtotal Setelah Diskon</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $( "#nama_obat" ).combobox();

        $('#total').number(true,0,',','.');
        $('#diskon').number(true,0,',','.');
        $('#grand_total').number(true,0,',','.');

        $('#harga_beli').number(true,0,',','.');
        $('#subtotal').number(true,0,',','.');
        $('#diskonobat').number(true,0,',','.');
        $('#subsubtotal').number(true,0,',','.');

        var t = $('#data-table').DataTable( {
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
                },
                {
                "targets": [ 1 ],
                "visible": false
                }
            ],
            "order": [[ 1, 'asc' ]],
            "paging": false,
            "info": false,
            "searching": false,
            "responsive": true,
            "autoWidth": true,
            "scrollY": 218,
            "scroller":true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
            }
        });

        function autoSum(){
              var jumlah = ($('#jumlah').val()=="")? 0 : parseInt($('#jumlah').val());
              var harga_beli = ($('#harga_beli').val()=="")? 0 : parseInt($('#harga_beli').val());
              var diskon = ($('#diskonobat').val()=="")? 0 : parseInt($('#diskonobat').val());
              var subtotal = jumlah*harga_beli;
              var subsubtotal = subtotal-diskon;
              subsubtotal = (subsubtotal<0)? 0 : subsubtotal;
              $('#subtotal').val(subtotal);
              $('#subsubtotal').val(subsubtotal);
        }

        function autoSumHeader(){
              var grandtotal = 0;
              var datatable_row = t.rows().data();
              for (var i = 0; i < datatable_row.length; i++) {
                var currentPrice =  parseInt(datatable_row[i][7].replace(/\D/g,''));
                grandtotal = grandtotal + currentPrice;
              }
              var diskon = ($('#diskon').val()=="")? 0 : parseInt($('#diskon').val());
              var grandgrandtotal = grandtotal - diskon;
              grandgrandtotal = (grandgrandtotal<0)? 0 : grandgrandtotal;
              $('#total').val(grandtotal);
              $('#grand_total').val(grandgrandtotal);
        }

        function refresh(){
            //$('#nama_obat').val("");
            $('#harga_beli').val("0");
            $('#jumlah').val("1");
            $('#diskonobat').val("0");
            $('#subtotal').val("0");
            $('#subsubtotal').val("0");
        }

        function convertInt(currencyString){
          var number = Number(currencyString.replace(/[^0-9\.]+/g,""));
          return number;
        }

        $('#harga_beli').bind('keyup mouseup',function(){
          autoSum();
        });
        $('#jumlah').bind('keyup mouseup',function(){
          autoSum();
        });
        $('#diskonobat').bind('keyup mouseup',function(){
          autoSum();
        });

        $('#diskon').bind('keyup mouseup',function(){
          autoSumHeader();
        });

        $('#btn-tambah-obat').on('click',function(){
            var jumlah = ($('#jumlah').val()=="")? 0 : parseInt($('#jumlah').val());
            var harga_beli = ($('#harga_beli').val()=="")? 0 : parseInt($('#harga_beli').val());
            var diskon = ($('#diskonobat').val()=="")? 0 : parseInt($('#diskonobat').val());
            var subtotal = ($('#subtotal').val()=="")? 0 : parseInt($('#subtotal').val());
            var subsubtotal = ($('#subsubtotal').val()=="")? 0 : parseInt($('#subsubtotal').val());
            var id_obat = $('#nama_obat').val().split(";")[0];
            var nama_obat = $('#nama_obat').val().split(";")[1];
            //alert(harga_beli);
            if (harga_beli != 0 && nama_obat != "") {
              t.row.add( [
                  ' ',
                  id_obat,
                  nama_obat,
                  "Rp " + $.number(harga_beli),
                  jumlah,
                  "Rp " + $.number(subtotal),
                  "Rp " + $.number(diskon),
                  "Rp " + $.number(subsubtotal)
              ] ).draw( false );

              refresh();

              t.on( 'order.dt search.dt', function () {
                  t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                      cell.innerHTML = i+1;
                  } );
              } ).draw();
              autoSumHeader();
              saveRowData();
            }
            else{
              alert('Inputan tidak valid.');
            }
        });


        $('#data-table tbody').on( 'click','tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                t.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#btn-hapus-obat').click( function () {
            t.row('.selected').remove().draw( false );
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            autoSumHeader();
            saveRowData();
        });

        function saveRowData(){
          var datatable_row = t.rows().data();
          var dataRow = [];
          for (var i = 0; i < datatable_row.length; i++) {
            dataRow[i] = datatable_row[i];
          }
          // console.log(dataRow);
          $.ajax({
              type: 'POST',
              url: '/pembelian/rowdata',
              data: {
                  '_token' : '{{ csrf_token() }}',
                  'row' : dataRow
              },
              success:function(){
                 //alert("a");
             }
          });
        }
    });
</script>
@endsection
