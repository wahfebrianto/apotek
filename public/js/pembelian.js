
    $(document).ready(function(){
        $( "#nama_obat" ).combobox();

        $('#total').number(true,0,',','.');
        $('#diskon').number(true,0,',','.');
        $('#grand_total').number(true,0,',','.');

        $('#harga_beli').number(true,0,',','.');
        $('#subtotal').number(true,0,',','.');
        $('#diskonobat').number(true,0,',','.');
        $('#subsubtotal').number(true,0,',','.');

        var t = $('#data-table').DataTable( {
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
            "order": [[ 1, 'asc' ]],
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

        function autoSum(){
              var jumlah = ($('#jumlah').val()=="")? 0 : parseInt($('#jumlah').val());
              var harga_beli = ($('#harga_beli').val()=="")? 0 : parseInt($('#harga_beli').val());
              var diskon = ($('#diskonobat').val()=="")? 0 : parseInt($('#diskonobat').val());
              var subtotal = jumlah*harga_beli;
              var subsubtotal = subtotal-diskon;
              subsubtotal = (subsubtotal<0)? 0 : subsubtotal;
              $('#subtotal').val(subtotal);
              $('#subsubtotal').val(subsubtotal);
        }

        function autoSumHeader(){
              var grandtotal = 0;
              var datatable_row = t.rows().data();
              for (var i = 0; i < datatable_row.length; i++) {
                var currentPrice =  parseInt(datatable_row[i][7].replace(/\D/g,''));
                grandtotal = grandtotal + currentPrice;
              }
              var diskon = ($('#diskon').val()=="")? 0 : parseInt($('#diskon').val());
              var grandgrandtotal = grandtotal - diskon;
              grandgrandtotal = (grandgrandtotal<0)? 0 : grandgrandtotal;
              $('#total').val(grandtotal);
              $('#grand_total').val(grandgrandtotal);
        }

        function refresh(){
            //$('#nama_obat').val("");
            $('#harga_beli').val("0");
            $('#jumlah').val("1");
            $('#diskonobat').val("0");
            $('#subtotal').val("0");
            $('#subsubtotal').val("0");
        }

        function convertInt(currencyString){
          var number = Number(currencyString.replace(/[^0-9\.]+/g,""));
          return number;
        }

        $('#harga_beli').bind('keyup mouseup',function(){
          autoSum();
        });
        $('#jumlah').bind('keyup mouseup',function(){
          autoSum();
        });
        $('#diskonobat').bind('keyup mouseup',function(){
          autoSum();
        });

        $('#diskon').bind('keyup mouseup',function(){
          autoSumHeader();
        });

        $('#btn-tambah-obat').on('click',function(){
            var row_obat_data = t.rows().data();
            var flag = true;

            var jumlah = ($('#jumlah').val()=="")? 0 : parseInt($('#jumlah').val());
            var harga_beli = ($('#harga_beli').val()=="")? 0 : parseInt($('#harga_beli').val());
            var diskon = ($('#diskonobat').val()=="")? 0 : parseInt($('#diskonobat').val());
            var subtotal = ($('#subtotal').val()=="")? 0 : parseInt($('#subtotal').val());
            var subsubtotal = ($('#subsubtotal').val()=="")? 0 : parseInt($('#subsubtotal').val());
            var id_obat = $('#nama_obat').val().split(";")[0];
            var nama_obat = $('#nama_obat').val().split(";")[1];
            //alert(harga_beli);
            for (var i = 0; i <row_obat_data.length; i++) {
                var namaObat = row_obat_data[i][2];
                if(namaObat == nama_obat){
                   flag = false;
                   break;
                }
            }

            if(flag){
                if (harga_beli != 0 && nama_obat != "") {
                  t.row.add( [
                      ' ',
                      id_obat,
                      nama_obat,
                      "Rp " + $.number(harga_beli),
                      jumlah,
                      "Rp " + $.number(subtotal),
                      "Rp " + $.number(diskon),
                      "Rp " + $.number(subsubtotal)
                  ] ).draw( false );

                  refresh();

                  t.on( 'order.dt search.dt', function () {
                      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
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


        $('#data-table tbody').on( 'click','tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                t.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#btn-hapus-obat').click( function () {
            t.row('.selected').remove().draw( false );
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            autoSumHeader();
            saveRowData();
        });

        function saveRowData(){
          var datatable_row = t.rows().data();
          var dataRow = [];
          for (var i = 0; i < datatable_row.length; i++) {
            dataRow[i] = datatable_row[i];
          }
          // console.log(dataRow);
          $.ajax({
              type: 'POST',
              url: '/pembelian/rowdata',
              data: {
                  // '_token' : '{{ csrf_token() }}', untuk di blade
                  '_token': $('meta[name="csrf-token"]').attr('content'),
                  'row' : dataRow
              },
              success:function(){
                 //alert("a");
             }
          });
        }
    });
