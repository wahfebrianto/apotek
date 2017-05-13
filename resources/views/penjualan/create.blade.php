@extends('layouts.app')

@section('content')
<div class="container auto-width">
    @if (Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <div class="row trans-custom ">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('penjualan.store') }}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <div class="col-md-12">
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
                  <div class="col-md-8">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="no_nota" class="col-md-3 control-label">No. Nota</label>
                            <div class="col-md-9">
                                <input id="no_nota" type="text" class="form-control" value="{{$nonota}}" name="no_nota" readonly>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tanggal" class="col-md-3 control-label">Tanggal</label>
                            <div class=" col-md-9">
                              <div class="input-group date form_datetime" id='datetimepicker-date-tanggal' data-link-field="tanggal">
                                <input type='text' class="form-control" value="<?php echo date("d F Y"); ?>" readonly>
                                <span class="input-group-addon custom-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                              <input type="hidden" name="tanggal" id="tanggal" value="<?php echo date("Y-m-d"); ?>">
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
                    </script>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="total" class="col-md-3 control-label">Total</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="total" type="text" class="form-control" name="total" value=0 readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="diskon" class="col-md-3 control-label">Diskon</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="diskon" type="text" class="form-control" name="diskon" value=0>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-md-2 grand_total">
                      <h4>Grand Total</h4>
                      <h2><b>Rp</b> <b id="grand_total">0</b></h2>
                      <input type="hidden" id="grand_total_hidden" class="form-control" name="grand_total" value=0>
                  </div>

                  <div class="col-md-2">
                      <button type="submit" class="btn btn-primary auto-width full-height">Simpan</button>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-5">
              <div class="panel panel-default">
                  <div class="panel-heading font-size-doubled">Input Obat/Resep</div>
                  <div class="panel-body">
                      <div class="form-group">
                        <label for="jenis" class="col-md-2 control-label">Jenis</label>
                        <div class="col-md-10">
                          <select class="form-control" id="jenis" name="jenis" required>
                              <option value="obat">Obat</option>
                              <option value="resep">Resep</option>
                          </select>
                        </div>
                      </div>
                      <div class="jenis-obat active-jenis">
                        <div class="form-group">
                            <label for="nama_obat_obat" class="col-md-2 control-label">Nama Obat</label>
                            <div class="col-md-10" id="list_obat_obat">
                              <select class="form-control" id="nama_obat_obat" name="nama_obat_obat">
                                  @foreach ($obatData as $obat)
                                      <option value="{{$obat->id.';'.$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.');'.$obat->harga_jual.')'}}">{{$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.')'}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hargajual_obat_obat" class="col-md-2 control-label">Harga</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="hargajual_obat_obat" type="text" class="form-control" name="hargajual_obat_obat" value="0" readonly>
                                </div>
                            </div>
                            <label for="jumlah_obat_obat" class="col-md-1 control-label">Qty</label>
                            <div class="col-md-4">
                                <input id="jumlah_obat_obat" type="number" class="form-control" name="jumlah_obat_obat" value=1 min=1 autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtotal_obat_obat" class="col-md-2 control-label">Subtotal</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="subtotal_obat_obat" type="text" class="form-control" name="subtotal_obat_obat" value=0 readonly>
                                </div>
                            </div>
                            <label for="diskon_obat_obat" class="col-md-1 control-label">Diskon</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="diskon_obat_obat" type="text" class="form-control" name="diskon_obat_obat" value=0 autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subsubtotal_obat_obat" class="col-md-2 control-label">Subtotal Setelah Diskon</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="subsubtotal_obat_obat" type="text" class="form-control" name="subsubtotal_obat_obat" value=0 readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-9">
                                <input type="button" class="btn btn-primary auto-width" value="Tambah" id="btn-tambah-obat">
                            </div>
                        </div>
                      </div>
                      <div class="jenis-resep">
                        <div class="form-group">
                            <label for="nama_racikan_resep" class="col-md-2 control-label">Nama Racikan</label>
                            <div class="col-md-5">
                                <input id="nama_racikan_resep" type="text" class="form-control" name="nama_racikan_resep" autofocus>
                            </div>
                            <label for="bentuk_sediaan_resep" class="col-md-2 control-label">Bentuk Sediaan</label>
                            <div class="col-md-3">
                                <input id="bentuk_sediaan_resep" type="text" class="form-control" name="bentuk_sediaan_resep" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_resep" class="col-md-2 control-label">Total</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="total_resep" type="text" class="form-control" name="total_resep" readonly>
                                </div>
                            </div>
                            <label for="jumlah_resep" class="col-md-1 control-label">Qty</label>
                            <div class="col-md-4">
                                <input id="jumlah_resep" type="number" class="form-control" name="jumlah_resep" value=1 min=1 autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="biaya_kemasan_resep" class="col-md-2 control-label">Biaya Kemasan</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="biaya_kemasan_resep" type="text" class="form-control" name="biaya_kemasan_resep" value=0>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="diskon_total_resep" class="col-md-2 control-label">Diskon</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="diskon_total_resep" type="text" class="form-control" name="diskon_total_resep" value=0>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grand_total_resep" class="col-md-2 control-label">Grand Total</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="grand_total_resep" type="text" class="form-control" name="grand_total_resep" value=0 readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group divide">
                            <label for="keterangan_resep" class="col-md-2 control-label">Keterangan</label>
                            <div class="col-md-10">
                                <input id="keterangan_resep" type="text" class="form-control" name="keterangan_resep">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_obat_resep" class="col-md-2 control-label">Nama Obat</label>
                            <div class="col-md-10" id="list_obat_resep">
                              <select class="form-control" id="nama_obat_resep" name="nama_obat_resep">
                                  @foreach ($obatData as $obat)
                                      <option value="{{$obat->id.';'.$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.');'.$obat->harga_jual}}">{{$obat->nama.' '.$obat->dosis.'-'.$obat->satuan_dosis.' ('.$obat->bentuk_sediaan.')'}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hargajual_obat_resep" class="col-md-2 control-label">Harga</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                  <span class="input-group-addon">Rp</span>
                                  <input id="hargajual_obat_resep" type="text" class="form-control" name="hargajual_obat_resep" value=readonly>
                                </div>
                            </div>
                            <label for="jumlah_obat_resep" class="col-md-1 control-label">Qty</label>
                            <div class="col-md-3">
                                <input id="jumlah_obat_resep" type="number" class="form-control" name="jumlah_obat_resep" value=1 min=1 step=0.25 autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtotal_obat_resep" class="col-md-2 control-label">Subtotal</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="subtotal_obat_resep" type="text" class="form-control" name="subtotal_obat_resep" value=0 readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <input type="button" class="btn btn-primary auto-width" value="Hapus" id="btn-hapus-resep">
                            </div>
                            <div class="col-md-5">
                                <input type="button" class="btn btn-primary auto-width" value="Tambah ke Resep" id="btn-tambah-resep">
                            </div>
                        </div>
                        <table id="data-table-dresep" class="row-border hover striped" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                  <th>No</th>
                                  <th>id_obat</th>
                                  <th>Nama Obat</th>
                                  <th>Harga</th>
                                  <th>Jumlah</th>
                                  <th>Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <br>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <input type="button" class="btn btn-primary auto-width" value="Tambah ke Nota" id="btn-tambah-nota-resep">
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>

            <div class="col-md-7">
              <div class="panel panel-default">
                  <div class="panel-heading font-size-doubled">Daftar Obat</div>
                  <div class="panel-body">
                      <div class="form-group">
                          <div class="col-md-2 col-md-offset-10">
                              <input type="button" class="btn btn-primary auto-width" value="Hapus" id="btn-hapus-nota-obat">
                          </div>
                      </div>
                      <table id="data-table-obat" class="row-border hover striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>id_obat</th>
                                <th>Nama Obat</th>
                                <th>Harga</th>
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
              <div class="panel panel-default">
                  <div class="panel-heading font-size-doubled">Daftar Resep</div>
                  <div class="panel-body">
                      <div class="form-group">
                          <div class="col-md-2 col-md-offset-10">
                              <input type="button" class="btn btn-primary auto-width" value="Hapus" id="btn-hapus-nota-resep">
                          </div>
                      </div>
                      <table id="data-table-resep" class="row-border hover striped" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Resep</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Biaya Kemasan</th>
                                <th>Diskon</th>
                                <th>Subtotal</th>
                                <th>Keterangan</th>
                                <th></th>
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
<script src="{{asset('js/penjualan.js')}}"></script>
@endsection
