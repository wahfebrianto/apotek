@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ubah Obat</div>
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

                  <form class="form-horizontal" role="form" method="post" action="{{ url('obat', [$obat->id]) }}">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="form-group">
                          <label for="nama" class="col-md-4 control-label">Nama</label>
                          <div class="col-md-6">
                              <input id="nama" type="text" class="form-control" name="nama" value="{{$obat->nama}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="id_pamakologi" class="col-md-4 control-label">Jenis Pamakologi</label>
                          <div class="col-md-6">
                              <select class="form-control" id="id_pamakologi" name="id_pamakologi" required>
                                  @foreach ($pamakologiData as $pamakologi)
                                      <option value="{{$pamakologi->id}}" {{($obat->id_pamakologi == $pamakologi->id) ? "selected" : ""}}>{{$pamakologi->nama}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="dosis" class="col-md-4 control-label">Dosis</label>
                          <div class="col-md-6">
                              <input id="dosis" type="text" class="form-control" name="dosis" value="{{$obat->dosis}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="satuan_dosis" class="col-md-4 control-label">Dosis</label>
                          <div class="col-md-6">
                              <input id="satuan_dosis" type="text" class="form-control" name="satuan_dosis" value="{{$obat->satuan_dosis}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="bentuk_sediaan" class="col-md-4 control-label">Bentuk Sediaan</label>
                          <div class="col-md-6">
                              <input id="bentuk_sediaan" type="text" class="form-control" name="bentuk_sediaan" value="{{$obat->bentuk_sediaan}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="harga_jual" class="col-md-4 control-label">Harga Jual</label>
                          <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input id="harga_jual" type="text" class="form-control" name="harga_jual" value="{{$obat->harga_jual}}" required autofocus>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="keterangan" class="col-md-4 control-label">Keterangan</label>
                          <div class="col-md-6">
                              <textarea id="keterangan" class="form-control" name="keterangan" cols="40" rows="5">{{$obat->keterangan}}</textarea>
                              {{-- <input id="alamat" type="text" class="form-control" name="alamat" required> --}}
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
      $('#harga_jual').number(true,0,',','.');
  });
</script>
@endsection
