$(document).ready(function(){
    //h_jual
    $('#total').number(true,0,',','.');
    $('#diskon').number(true,0,',','.');
    $('#grand_total').number(true,0,',','.');

    //d_jual
    $("#nama_obat_obat").combobox();
    $("#list_obat_obat input").attr("id","click_obat_obat");
    $("#click_obat_obat").val('');
    $('#hargajual_obat_obat').number(true,0,',','.');
    $('#subtotal_obat_obat').number(true,0,',','.');
    $('#diskon_obat_obat').number(true,0,',','.');
    $('#subsubtotal_obat_obat').number(true,0,',','.');

    //h_resep
    var rowResepData;
    var tdresep = [];
    var idx = -1;
    $('#total_resep').number(true,0,',','.');
    $('#diskon_total_resep').number(true,0,',','.');
    $('#biaya_kemasan_resep').number(true,0,',','.');
    $('#grand_total_resep').number(true,0,',','.');

    //d_resep
    $("#nama_obat_resep").combobox();
    $("#list_obat_resep input").attr("id","click_obat_resep");
    $("#click_obat_resep").val('');
    $("#nama_obat_resep").val('');
    $('#hargajual_obat_resep').number(true,0,',','.');
    $('#subtotal_obat_resep').number(true,0,',','.');

    var t_nota_obat = $('#data-table-obat').DataTable( {
        "columnDefs": [ {
              "searchable": false,
              "orderable": false,
              "targets": 0
            },
            {
              "targets": [ 1 ],
              "visible": false
            }
        ],
        "ordering" : false,
        "paging": false,
        "info": false,
        "searching": false,
        "responsive": true,
        "autoWidth": true,
        "scrollY": 250,
        "scroller":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
        }
    });
    var t_nota_resep = $('#data-table-resep').DataTable( {
        "columnDefs": [ {
              "searchable": false,
              "orderable": false,
              "targets": 0
            },
            {
              "className":      'details-control',
              "orderable":      false,
              "data":           null,
              "defaultContent": '',
              "targets": 8
            }
        ],
        "ordering" : false,
        "paging": false,
        "info": false,
        "searching": false,
        "autoWidth": true,
        "scrollY": 410,
        "scroller":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
        }
    });

    var tresep = $('#data-table-dresep').DataTable( {
        "columnDefs": [
            {
              "searchable": false,
              "orderable": false,
              "targets": 0
            },
            {
              "targets": [ 1 ],
              "visible": false
            }
        ],
        "ordering" : false,
        "paging": false,
        "info": false,
        "searching": false,
        "responsive": true,
        "autoWidth": true,
        "scrollY": 218,
        "scroller":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
        }
    });

    function initDataTable(d){
        var tempTable = $(d).DataTable( {
            "columnDefs": [
                {
                  "targets": [ 1 ],
                  "visible": false
                }
            ],
            "order": [[ 1, 'asc' ]],
            "paging": false,
            "info": false,
            "searching": false,
            "autoWidth": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Indonesian.json"
            }
        });
        tdresep.push(tempTable);
      }

    $('#jenis').on('click',function(){
        if($('#jenis').val()=="resep"){
          $('.jenis-obat').removeClass('active-jenis');
          $('.jenis-resep').addClass('active-jenis');
          tresep.draw();
        }
        else{
          $('.jenis-resep').removeClass('active-jenis');
          $('.jenis-obat').addClass('active-jenis');
          tresep.draw();
        }
    });

    function autoSumObat(){
          var jumlah = ($('#jumlah_obat_obat').val()=="")? 0 : parseInt($('#jumlah_obat_obat').val());
          var harga_jual = parseInt($('#hargajual_obat_obat').val());
          var diskon = ($('#diskon_obat_obat').val()=="")? 0 : parseInt($('#diskon_obat_obat').val());
          var subtotal = jumlah*harga_jual;
          var subsubtotal = subtotal-diskon;
          subsubtotal = (subsubtotal<0)? 0 : subsubtotal;
          $('#subtotal_obat_obat').val(subtotal);
          $('#subsubtotal_obat_obat').val(subsubtotal);
    }

    function autoSumResep(){
          var dosis_asli = parseInt($('#nama_obat_resep').val().split(";")[3]);
          var dosis_pakai = ($('#dosis_obat_resep').val()=="")? 0 : parseInt($('#dosis_obat_resep').val());
          var jumlah = ($('#jumlah_obat_resep').val()=="")? 0 : parseInt($('#jumlah_obat_resep').val());
          var harga_jual = parseInt($('#hargajual_obat_resep').val());
          var subtotal = (dosis_pakai/dosis_asli)*jumlah*harga_jual;
          $('#subtotal_obat_resep').val(subtotal);
    }

    function autoSumHeader(){
          var grandtotal = 0;
          var datatable_nota_row = t_nota_obat.rows().data();
          for (var i = 0; i < datatable_nota_row.length; i++) {
            var currentPrice =  parseInt(datatable_nota_row[i][7].replace(/\D/g,''));
            grandtotal = grandtotal + currentPrice;
          }
          var datatable_resep_row = t_nota_resep.rows().data();
          //console.log(datatable_resep_row);
          // console.log(tdresep[tdresep.length-1].rows().data());
          for (var i = 0; i < datatable_resep_row.length; i++) {
            var currentPrice =  parseInt(datatable_resep_row[i][6].replace(/\D/g,''));
            grandtotal = grandtotal + currentPrice;
          }
          var diskon = ($('#diskon').val()=="")? 0 : parseInt($('#diskon').val());
          var grandgrandtotal = grandtotal - diskon;
          grandgrandtotal = (grandgrandtotal<0)? 0 : grandgrandtotal;
          $('#total').val(grandtotal);
          $('#grand_total').html(grandgrandtotal);
          $('#grand_total_hidden').val(grandgrandtotal);
          $('#grand_total').number(true,0,',','.');

    }

    function autoSumHeaderResep(){
          var grandtotal = 0;
          var datatable_row = tresep.rows().data();
          var jumlah = ($('#jumlah_resep').val()=="")? 0 : parseInt($('#jumlah_resep').val());
          for (var i = 0; i < datatable_row.length; i++) {
            var currentQty = Math.ceil(parseFloat(datatable_row[i][4])*jumlah);
            var currentPrice =  parseInt(datatable_row[i][3].replace(/\D/g,''));
            var currentSubtotal = currentPrice*currentQty;
            grandtotal = grandtotal + currentSubtotal;
          }
          var diskon = ($('#diskon_total_resep').val()=="")? 0 : parseInt($('#diskon_total_resep').val());
          var kemasan = ($('#biaya_kemasan_resep').val()=="")? 0 : parseInt($('#biaya_kemasan_resep').val());
          var grandgrandtotal = grandtotal - diskon + (kemasan*jumlah);
          grandgrandtotal = (grandgrandtotal<0)? 0 : grandgrandtotal;
          $('#total_resep').val(grandtotal);
          $('#grand_total_resep').val(grandgrandtotal);
    }

    function refreshObat(){
        $("#click_obat_obat").val('');
        $('#hargajual_obat_obat').val("0");
        $('#jumlah_obat_obat').val("1");
        $('#diskon_obat_obat').val("0");
        $('#subtotal_obat_obat').val("0");
        $('#subsubtotal_obat_obat').val("0");
    }

    function refreshResep(){
        $("#click_obat_resep").val('');
        $('#jumlah_obat_resep').val("1");
        $('#dosis_obat_resep').val("1");
        $('#satuan_dosis_obat_resep').html("");
        $('#hargajual_obat_resep').val("0");
        $('#subtotal_obat_resep').val("0");
    }

    function refreshHResep(){
      $('#nama_racikan_resep').val("");
      $('#bentuk_sediaan_resep').val("");
      $('#total_resep').val("0");
      $('#jumlah_resep').val("1");
      $('#grand_total_resep').val("0");
      $('#keterangan_resep').val("");
      tresep.clear().draw();;
      refreshResep();
    }

    //h_jual
    $('#diskon').bind('keyup mouseup',function(){
      autoSumHeader();
    });

    //d_jual
    $('#nama_obat_obat').on('change',function(){
        var harga = parseInt($('#nama_obat_obat').val().split(";")[2]);
        $('#hargajual_obat_obat').val(harga);
        autoSumObat();
    });

    $('#ui-id-1').on('click',function(){
        var harga = parseInt($('#nama_obat_obat').val().split(";")[2]);
        $('#hargajual_obat_obat').val(harga);
        autoSumObat();
    });

    $('#jumlah_obat_obat').bind('keyup mouseup',function(){
      autoSumObat();
    });

    $('#diskon_obat_obat').bind('keyup mouseup',function(){
      autoSumObat();
    });

    //h_resep
    $('#biaya_kemasan_resep').bind('keyup mouseup',function(){
      autoSumHeaderResep();
    });
    $('#diskon_total_resep').bind('keyup mouseup',function(){
      autoSumHeaderResep();
    });
    $('#jumlah_resep').bind('keyup mouseup',function(){
      //ubah jumlah juga
      autoSumHeaderResep();
    });

    //d_resep
    $('#nama_obat_resep').on('change',function(){
        var harga = parseInt($('#nama_obat_resep').val().split(";")[2]);
        var dosis = parseInt($('#nama_obat_resep').val().split(";")[3]);
        var satuan_dosis = $('#nama_obat_resep').val().split(";")[4];
        $('#hargajual_obat_resep').val(harga);
        $('#dosis_obat_resep').val(dosis);
        $('#satuan_dosis_obat_resep').html(satuan_dosis);
        autoSumResep();
    });

    $('#ui-id-2').on('click',function(){
        var harga = parseInt($('#nama_obat_resep').val().split(";")[2]);
        $('#hargajual_obat_resep').val(harga);
        autoSumResep();
    });

    $('#dosis_obat_resep').bind('keyup mouseup',function(){
      autoSumResep();
    });

    $('#jumlah_obat_resep').bind('keyup mouseup',function(){
      autoSumResep();
    });

    $('#btn-tambah-obat').on('click',function(){
        var row_obat_nota_data = t_nota_obat.rows().data();
        var flag = true;

        var jumlah = ($('#jumlah_obat_obat').val()=="")? 0 : parseInt($('#jumlah_obat_obat').val());
        var harga_jual = parseInt($('#hargajual_obat_obat').val());
        var diskon = ($('#diskon_obat_obat').val()=="")? 0 : parseInt($('#diskon_obat_obat').val());
        var subtotal = ($('#subtotal_obat_obat').val()=="")? 0 : parseInt($('#subtotal_obat_obat').val());
        var subsubtotal = ($('#subsubtotal_obat_obat').val()=="")? 0 : parseInt($('#subsubtotal_obat_obat').val());
        var id_obat = $('#nama_obat_obat').val().split(";")[0];
        var nama_obat = $('#nama_obat_obat').val().split(";")[1];
        //alert(harga_jual);
        for (var i = 0; i <row_obat_nota_data.length; i++) {
            var namaObat = row_obat_nota_data[i][2];
            if(namaObat == nama_obat){
               flag = false;
               break;
            }
        }

        if(flag){
            if (harga_jual != 0 && nama_obat != "") {
              t_nota_obat.row.add( [
                  ' ',
                  id_obat,
                  nama_obat,
                  "Rp " + $.number(harga_jual),
                  jumlah,
                  "Rp " + $.number(subtotal),
                  "Rp " + $.number(diskon),
                  "Rp " + $.number(subsubtotal)
              ] ).draw( false );

              refreshObat();

              t_nota_obat.on( 'order.dt search.dt', function () {
                  t_nota_obat.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                      cell.innerHTML = i+1;
                  } );
              } ).draw();
              autoSumHeader();
              saveRowData();
            }
            else{
              alert('Inputan tidak valid.');
            }
        }
        else{
            alert('Inputan tidak valid. Data sudah pernah diinputkan.');
        }
    });

    $('#btn-tambah-resep').on('click',function(){
        var row_resep_data = tresep.rows().data();
        var flag = true;
        var dosis_asli = parseInt($('#nama_obat_resep').val().split(";")[3]);
        var dosis_pakai = ($('#dosis_obat_resep').val()=="")? 0 : parseInt($('#dosis_obat_resep').val());
        var jumlah = ($('#jumlah_obat_resep').val()=="")? 0 : parseFloat($('#jumlah_obat_resep').val());
        jumlah = (dosis_pakai/dosis_asli)*jumlah;
        var harga_jual = parseInt($('#hargajual_obat_resep').val());
        var subtotal = ($('#subtotal_obat_resep').val()=="")? 0 : parseInt($('#subtotal_obat_resep').val());
        var id_obat = $('#nama_obat_resep').val().split(";")[0];
        var nama_obat = $('#nama_obat_resep').val().split(";")[1];
        //alert(harga_jual);
        for (var i = 0; i <row_resep_data.length; i++) {
            var namaObat = row_resep_data[i][2];
            if(namaObat == nama_obat){
               flag = false;
               break;
            }
        }

        if(flag){
            if (subtotal != 0 && nama_obat != "") {
              tresep.row.add( [
                  ' ',
                  id_obat,
                  nama_obat,
                  "Rp " + $.number(harga_jual),
                  jumlah,
                  "Rp " + $.number(subtotal)
              ] ).draw( false );

              refreshResep();

              tresep.on( 'order.dt search.dt', function () {
                  tresep.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                      cell.innerHTML = i+1;
                  } );
              } ).draw();
              autoSumHeaderResep();
              rowResepData = tresep.rows().data();
              saveRowData();
            }
            else{
              alert('Inputan tidak valid.');
            }
        }
        else{
            alert('Inputan tidak valid. Data sudah pernah diinputkan.');
        }
    });

    function nestedTable(table,n){
        // `d` is the original data object for the row
        var result = '<table class="data-table-nota-dresep" cellpadding="5" cellspacing="0" style="margin-left:5%;" width="90%">';
        result +=
        '<thead><tr><th>No</th><th>id_obat</th><th>Nama Obat</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr></thead><tbody>';
        for (var i = 0; i < table.length; i++) {
          var harga = convertToNumber(table[i][3]);
          var jumlah = parseFloat(table[i][4])*n;
          var subtotal = harga*Math.ceil(jumlah);
          // alert(convertToInt(table[i][3]));
          result +=
            '<tr>'+
                '<td>'+(i+1)+'</td>'+
                '<td>'+table[i][1]+'</td>'+
                '<td>'+table[i][2]+'</td>'+
                '<td>Rp '+$.number(harga)+'</td>'+
                '<td>'+jumlah+'</td>'+
                '<td>Rp '+$.number(subtotal)+'</td>'+
            '</tr>';
        }
        result += '</tbody></table>';

        return result;
    }

    // Add event listener for opening and closing details
    $('#data-table-resep tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = t_nota_resep.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child.show();
            tr.addClass('shown');
        }
    } );

    $('#btn-tambah-nota-resep').on('click',function(){
        var nama_racikan = $('#nama_racikan_resep').val();
        var bentuk_sediaan = $('#bentuk_sediaan_resep').val();
        var total = parseInt($('#total_resep').val());
        var jumlah = parseInt($('#jumlah_resep').val());
        var biaya_kemasan = parseInt($('#biaya_kemasan_resep').val());
        var diskon = parseInt($('#diskon_total_resep').val());
        var grand_total = parseInt($('#grand_total_resep').val());
        var keterangan = $('#keterangan_resep').val();

        if (nama_racikan != "" && bentuk_sediaan != "" && grand_total != 0) {
          rowResepData = tresep.rows().data();
          t_nota_resep.row.add( [
              ' ',
              nama_racikan+'-'+bentuk_sediaan,
              "Rp " + $.number(total),
              jumlah,
              "Rp " + $.number(biaya_kemasan),
              "Rp " + $.number(diskon),
              "Rp " + $.number(grand_total),
              keterangan
          ] ).draw( false );

          t_nota_resep.on( 'order.dt search.dt', function () {
              t_nota_resep.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                  cell.innerHTML = i+1;
              } );
          } ).draw();
          t_nota_resep.row(':last').child(nestedTable(rowResepData,jumlah)).show();
          initDataTable(".data-table-nota-dresep:last");
          t_nota_resep.row(':last').child.hide();
          refreshHResep();
          autoSumHeader();
          saveRowData();
        }
        else{
          alert('Inputan tidak valid.');
        }
    });

    $('#btn-hapus-nota-obat').click( function () {
        t_nota_obat.row('.selected').remove().draw( false );
        t_nota_obat.on( 'order.dt search.dt', function () {
            t_nota_obat.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        autoSumHeader();
        saveRowData();
    });

    $('#btn-hapus-resep').click( function () {
        tresep.row('.selected').remove().draw( false );
        tresep.on( 'order.dt search.dt', function () {
            tresep.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        autoSumHeaderResep();
        saveRowData();
    });

    $('#btn-hapus-nota-resep').click( function () {
        t_nota_resep.row('.selected').remove().draw( false );
        t_nota_resep.on( 'order.dt search.dt', function () {
            t_nota_resep.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        tdresep.splice(idx,1);
        idx = -1;
        autoSumHeader();
        saveRowData();
    });

    $('#data-table-obat tbody').on( 'click','tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            t_nota_obat.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#data-table-dresep tbody').on( 'click','tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            tresep.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#data-table-resep tbody').on( 'click','tr', function () {
        if ($(this).hasClass('selected')) {
            idx =  -1;
            $(this).removeClass('selected');
        }
        else {
            idx = t_nota_resep.row(this).index();
            //console.log(t_nota_resep.row(this).index());
            t_nota_resep.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    function saveRowData(){
      var djual = t_nota_obat.rows().data();
      var data_djual = [];
      for (var i = 0; i < djual.length; i++) {
        data_djual[i] = djual[i];
      }
      var hresep = t_nota_resep.rows().data();
      var data_hresep = [];
      for (var i = 0; i < hresep.length; i++) {
        data_hresep[i] = hresep[i];
      }
      var data_dresep = [];
      for (var i = 0; i < tdresep.length; i++) {
        var temp = [];
        var data = tdresep[i].rows().data();
        for (var j = 0; j < data.length; j++) {
          temp[j] = data[j];
        }
        data_dresep[i] = temp;
      }
      // console.log(data_djual);
      // console.log(data_hresep);
      //  console.log(data_dresep);
      $.ajax({
          type: 'POST',
          url: '/penjualan/rowdata',
          data: {
              // '_token' : '{{ csrf_token() }}'
              '_token': $('meta[name="csrf-token"]').attr('content'),
              'djual' : data_djual,
              'hresep' : data_hresep,
              'dresep' : data_dresep
          },
          success:function(){
            //  alert("a");
         }
      });
    }

    function convertToNumber(input){
       var temp = input.match(/(\d+)/g);
       var result = "";
       for (var i = 0; i < temp.length; i++) {
         result += temp[i];
       }
      //  console.log(result);
       return parseInt(result);
    }
});
