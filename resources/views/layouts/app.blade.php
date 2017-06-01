<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('datetimepicker/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('datatables/DataTables-1.10.13/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('datatables/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{ asset('jqueryui/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{ asset('jqueryui/jquery-ui.structure.min.css')}}" rel="stylesheet">
    <link href="{{ asset('jqueryui/jquery-ui.theme.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/combobox.css')}}" rel="stylesheet">
    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/penjualan.css')}}" rel="stylesheet">
    <link href="{{ asset('css/laporan.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/logo.ico')}}">
    <link href="{{ asset('icheck/square/blue.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <!--<script src="/js/app.js"></script>-->
    <script src="{{ asset('datatables/datatables.js')}}"></script>
    <script src="{{ asset('js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{ asset('js/jquery.number.min.js')}}"></script>
    <script src="{{ asset('jqueryui/jquery-ui.min.js')}}"></script>
    {{-- <script src="{{asset('js/require.js')}}"></script> --}}
    {{-- <script src="{{asset('js/bootstrap.js')}}" data-modules="tooltip button"></script> --}}
    <script src="{{asset('js/combobox.js')}}"></script>
    <script src="{{ asset('datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('datetimepicker/bootstrap-datetimepicker.id.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('icheck/icheck.js')}}" charset="UTF-8"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="padding-top:7px;padding-right:5px;">
                        <img src="/assets/logo.png" width="35px" height="35px">
                    </a>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                      @if (!Auth::guest() && Auth::user()->username == "admin")
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Master<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('pegawai.index') }}">Pegawai</a>
                                </li>
                                <li>
                                    <a href="{{ route('obat.index') }}">Obat</a>
                                </li>
                                <li>
                                    <a href="{{ route('pamakologi.index') }}">Pamakologi</a>
                                </li>
                                </li>
                                <li>
                                    <a href="{{ route('pbf.index') }}">PBF</a>
                                </li>
                                <li>
                                    <a href="{{ route('pengeluaran.index') }}">Pengeluaran</a>
                                </li>
                                <li>
                                    <a href="{{ route('log.index') }}">Log</a>
                                </li>
                            </ul>
                        </li>
                      @endif

                      @if (!Auth::guest())
                      <li class="dropdown">
                        <a href="{{ route('pembelian.index') }}">Pembelian</a>
                      </li>
                      <li class="dropdown">
                        <a href="{{ route('penerimaan.index') }}">Penerimaan Obat</a>
                      </li>
                      </li>
                      <li class="dropdown">
                        <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
                      </li>
                      <li class="dropdown">
                        <a href="{{ route('penjualan.index') }}">Penjualan</a>
                      </li>
                      <li class="dropdown">
                        <a href="{{ route('laporan.index') }}">Laporan</a>
                      </li>
                      @endif
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        <!-- Delete Mehod -->
        <script src="{{asset('js/laravel.js')}}"></script>
    </div>
    <?php
      $debugbar = App::make('debugbar');
      $debugbar->addCollector(new DebugBar\DataCollector\MessagesCollector('my_messages'));
    ?>
</body>
</html>
