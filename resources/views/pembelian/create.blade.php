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
<script src="{{asset('js/pembelian.js')}}"></script>
@endsection
