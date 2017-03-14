@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pengeluaran Baru</div>
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

                  <form class="form-horizontal" role="form" method="POST" action="{{ route('pengeluaran.store') }}">

                  {{ csrf_field() }}

                  <div class="form-group">
                      <label for="tgl" class="col-md-4 control-label">Tanggal</label>

                      <div class="col-md-6">
                          <input id="tgl" type="date" class="form-control" name="tgl" value="{{ date("Y-m-d") }}" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="nama" class="col-md-4 control-label">Nama</label>

                      <div class="col-md-6">
                          <select id="nama" class="selectpicker form-control" name="nama" value="{{ Auth::user()->nama }}">
                            @foreach ($users as $user)
                                <option>{{$user->nama}}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="harga" class="col-md-4 control-label">Harga</label>
                      <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input id="harga" type="number" class="form-control" name="harga" autofocus>
                            <span class="input-group-addon">.00</span>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="keterangan" class="col-md-4 control-label">Keterangan</label>

                      <div class="col-md-6">
                          <input id="keterangan" type="text" class="form-control" name="keterangan" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">
                              Simpan
                          </button>
                      </div>
                  </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
