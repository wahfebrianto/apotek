@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pegawai Baru</div>
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

                  <form class="form-horizontal" role="form" method="POST" action="{{ route('pegawai.store') }}">

                  {{ csrf_field() }}

                  <div class="form-group">
                      <label for="nama" class="col-md-4 control-label">Nama</label>

                      <div class="col-md-6">
                          <input id="nama" type="text" class="form-control" name="nama" required autofocus>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="alamat" class="col-md-4 control-label">Alamat</label>

                      <div class="col-md-6">
                          <input id="alamat" type="text" class="form-control" name="alamat" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="telepon" class="col-md-4 control-label">Telepon</label>

                      <div class="col-md-6">
                          <input id="telepon" type="text" class="form-control" name="telepon" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="gaji" class="col-md-4 control-label">Gaji</label>
                      <div class="col-md-6">
                          <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input id="gaji" type="text" class="form-control" name="gaji">
                          </div>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                      <label for="username" class="col-md-4 control-label">Username</label>

                      <div class="col-md-6">
                          <input id="username" type="text" class="form-control" name="username" required>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="password" class="col-md-4 control-label">Password</label>

                      <div class="col-md-6">
                          <input id="password" type="password" class="form-control" name="password" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                      <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
    <script>
      $(document).ready(function(){
          $('#gaji').number(true,0,',','.');
      });
    </script>
</div>
@endsection
