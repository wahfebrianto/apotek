@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Ubah PBF</div>
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

                  <form class="form-horizontal" role="form" method="post" action="{{ url('pbf', [$pbf->id]) }}">
                      {{ csrf_field() }}
                      {{ method_field('PUT')}}
                      <div class="form-group">
                          <label for="nama" class="col-md-4 control-label">Nama</label>
                          <div class="col-md-6">
                              <input id="nama" type="text" class="form-control" name="nama" value="{{$pbf->nama}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="alamat" class="col-md-4 control-label">Alamat</label>
                          <div class="col-md-6">
                              <input id="alamat" type="text" class="form-control" name="alamat" value="{{$pbf->alamat}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="telepon" class="col-md-4 control-label">Telepon</label>
                          <div class="col-md-6">
                              <input id="telepon" type="text" class="form-control" name="telepon" value="{{$pbf->telepon}}" required autofocus pattern="[0-9]*">
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="nama_cp" class="col-md-4 control-label">Nama CP</label>
                          <div class="col-md-6">
                              <input id="nama_cp" type="text" class="form-control" name="nama_cp" value="{{$pbf->nama_cp}}" required autofocus>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="telp_cp" class="col-md-4 control-label">Telepon CP</label>
                          <div class="col-md-6">
                              <input id="telp_cp" type="text" class="form-control" name="telp_cp" value="{{$pbf->telp_cp}}" required autofocus pattern="[0-9]*">
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="tergolong_pajak" class="col-md-4 control-label">Tergolong Pajak</label>
                          <div class="col-md-6">
                              <input id="tergolong_pajak" type="checkbox" data-toggle="toggle" class="form-control" name="tergolong_pajak" {{($pbf->tergolong_pajak == 1) ? "checked" : ""}}>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="keterangan" class="col-md-4 control-label">Keterangan</label>
                          <div class="col-md-6">
                              <textarea id="keterangan" class="form-control" name="keterangan" cols="40" rows="5">{{$pbf->keterangan}}</textarea>
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
@endsection
