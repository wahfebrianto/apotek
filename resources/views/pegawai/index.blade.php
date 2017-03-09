@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">Pegawai</div>
              <div class="panel-body">
                <a class="btn btn-small btn-success" href="{{ URL::to('pegawai/create') }}">Pegawai Baru</a>
				        <hr />
                @if (Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Gaji</th>
                        <th>Username</th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td scope='row'>{{$user->nama}}</td>
                            <td>{{$user->alamat}}</td>
                            <td>{{$user->telepon}}</td>
                            <td>{{$user->gaji}}</td>
                            <td>{{$user->username}}</td>
                            <td>
                                <a class="btn btn-small btn-info" href="{{ URL::to('pegawai/edit/' . $user->id ) }}">Ubah</a>
                                <a class="btn btn-small btn-warning pull-right" href="{{ URL::to('pegawai/delete/' . $user->id ) }}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
