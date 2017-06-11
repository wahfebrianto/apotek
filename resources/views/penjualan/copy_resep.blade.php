@extends('layouts.app')

@section('content')
<div class="container copy-resep-width">
  <div class="row">
      <div class="col-md-12 divcol">
          <div class="panel panel-default">
            <div class="panel-heading" id="laporan-head">Copy Resep</div>
            <div class="panel-body animated fadeInRight" id="copy-resep">
              <div class="row">
                  <div class="col-sm-12 text-center">
                      <img src="/assets/logo.png" width="5%">
                      <h4 class="text-navy"><b>APOTEK VALENTINO</b></h4>
                      <p>
                          <span>Jl. Pandugo Timur 97B/99 Surabaya</span><br/>
                          <span>Telp. (031) 8783730</span><br/>
                          <span>Apoteker Dra. Lusiwati .T. M Farm-Klin Apt</span><br/>
                          <span><strong>SIPA : </strong>19511113/SIPA-35.78/2016/2106</span>
                      </p>
                      <hr>
                      <h4 class="text-navy"><b>Copy Resep</b></h4>
                  </div>
              </div>
              <br/>
              <div class="body-resep" id="body-resep">
                    @foreach ($d_jual as $d_jual_data)
                        <div>
                            <h4 class="text-navy text-header-resep"><b>R/</b></h4>
                            <h5 class="text-navy text-body-resep">{{$d_jual_data['body']}}</h5>
                        </div>
                        <br>
                    @endforeach
                    @foreach ($h_resep as $h_resep_data)
                        <div>
                            <h4 class="text-navy text-header-resep"><b>R/</b></h4>
                            @foreach ($h_resep_data['body'] as $d_resep)
                              <div>
                                <h5 class="text-navy text-body-resep">{{$d_resep}}</h5>
                              </div>
                            @endforeach
                            <div class="line-resep text-body-resep"></div>
                            <div><h5 class="text-navy text-body-resep">Dibuat {{$h_resep_data['jumlah']}} Buah</h5></div>
                        </div>
                        <br>
                    @endforeach
              </div>
            </div>
          </div>
        </div>
    </div>
    <button type="button" class="col-md-2 btn btn-success pull-right" id="btnPrint">Print</button>
</div>

<script type="text/javascript">
      $(document).ready(function () {
          $('#btnPrint').click(function(){
              PrintElem("copy-resep");
          });
      });

      function PrintElem(elem)
      {
          var mywindow = window.open('', 'PRINT', 'left=0,top=0,width=600,height=400,toolbar=1,scrollbars=1,status=0');


          mywindow.document.write('<html><head><title>' + document.title  + '</title>');
          mywindow.document.write('<link href="{{ asset('css/custom.css')}}" rel="stylesheet">');
          mywindow.document.write('<link href="{{ asset('css/combobox.css')}}" rel="stylesheet">');
          mywindow.document.write('<link href="{{ asset('css/animate.css')}}" rel="stylesheet">');
          mywindow.document.write('<link href="{{ asset('css/penjualan.css')}}" rel="stylesheet">');
          mywindow.document.write('<link href="{{ asset('css/laporan.css')}}" rel="stylesheet">');
          mywindow.document.write('</head><body class="print-resep">');
          mywindow.document.write(document.getElementById(elem).innerHTML);
          mywindow.document.write('</body></html>');
          //
          // mywindow.document.close(); // necessary for IE >= 10
          // mywindow.focus(); // necessary for IE >= 10*/

          //mywindow.print();
          //mywindow.close();

          return true;
      }

</script>
@endsection
