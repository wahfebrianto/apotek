@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Ubah Log</div>
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

                  <form class="form-horizontal" role="form" method="POST" action="{{ route('log.change') }}">

                  {{ csrf_field() }}

                  <input type="hidden" name="id" value="{{ $log->id }}">

                  <div class="form-group">
                      <label for="tgl" class="col-md-4 control-label">Tanggal</label>

                      <div class="col-md-6">
                          <input id="tgl" type="text" class="form-control" name="tgl" value="{{ date('d/m/Y', strtotime($log->created_at)) }}" readonly>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="obat" class="col-md-4 control-label">Obat</label>

                      <div class="col-md-6">
                        <select id="obat" class="selectpicker form-control" name="obat">
                            @foreach ($obat as $data)
                                <option>{{$data->nama}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="keterangan" class="col-md-4 control-label">Keterangan</label>

                      <div class="col-md-6">
                          <input id="keterangan" type="text" class="form-control" name="keterangan" value="{{ $log->keterangan }} "required>
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
<script>
$(document).ready(function(){
    $("#obat").val('{{ $log->obat->nama }}');
});
</script>
@endsection
