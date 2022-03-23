@extends('master.master')
@section('title','Data Logbook')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Logbook</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelLogbook"></div>
    </div>
  </div>

@endsection
@section('additionalJS')
  <script type="text/javascript" src="{!! asset('js/tanggalConvert.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/dataTables.buttons.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.flash.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/jszip.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/pdfmake.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/vfs_fonts.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.html5.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.print.min.js') !!}"></script>
  <script>
    $(document).ready(function(){
      showTableLogbook();
    });

    function sweetTable(){
      var dataTable = $('#tabelLogbook').DataTable({
        "language": {
          "zeroRecords": "Tidak ada Data",
          "info": "Data Logbook yang ditampilkan adalah <b> _TOTAL_ </b> Jumlah Data",
          "infoEmpty": "Data Logbook yang ditampilkan adalah <b>0</b> Jumlah Data",
          "lengthMenu": "Tampilkan _MENU_ Jumlah Data",
          "search": "Cari ",
          "paginate": {
            "first":      "<<",
            "last":       ">>",
            "next":       ">",
            "previous":   "<"
          },
          "infoFiltered":   "(diambil dari <b> _MAX_ </b> jumlah seluruh data)",
        },
        'dom': '<"toolbar"><"pencarian"fr>tlrip<"kumpulanButton">B',
        "lengthMenu": [ 5, 10, 15, 20, 25 ],
        buttons: [{
          extend: 'print',
          text: '<span class="fas fa-print"></span> Print',
          className: 'btn btn-success mx-1',
          title: 'Data Logbook',
          title: function(){
            return 'Data Logbook '+ tanggal($('div.toolbar #searchRangeCheckInCheckOut1').val()) +"-"+ tanggal($('div.toolbar #searchRangeCheckInCheckOut2').val());
          },
          exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9],
            stripNewlines:true,
            stripHtml:false
          },
          customize: function ( win ) {
            $(win.document.body).find( 'table' ).addClass( 'table table-stripped table-sm' );
            $(win.document.body).find( 'table thead' ).addClass( 'text-center' );
            $(win.document.head).css( 'font-size','10px' );
          }
        }]
      });

      var toolbarTambahan = '';
      toolbarTambahan += '<div class="form-inline">\
      <label for="searchCheckOut">Tampilkan</label>\
      <select name="searchCheckOut" id="searchCheckOut" class="form-control form-control-sm mx-1">\
        <option value="" selected>Semua Data Pasien</option>\
        <option value="1">Pasien Sudah Check Out </option>\
        <option value="0">Pasien Belum Check Out </option>\
      </select>';

      toolbarTambahan += '\
      <input class="form-control form-control-sm mx-1" type="date" name="searchRangeCheckInCheckOut1" id="searchRangeCheckInCheckOut1" />\
      <label for="searchRangeCheckInCheckOut2">Sampai </label>\
      <input class="form-control form-control-sm  mx-1" type="date" name="searchRangeCheckInCheckOut2" id="searchRangeCheckInCheckOut2" />';

      toolbarTambahan += '\
      <select name="searchKamar" id="searchKamar" class="form-control form-control-sm mx-1">\
        <option value="" selected>Semua Data Kamar</option>';
        @foreach($kamars as $kamar)
          toolbarTambahan += '<option value="{!! $kamar->nama_kamar !!}">{!! $kamar->nama_kamar !!}</option>';
        @endforeach
      toolbarTambahan += '</select>';

      toolbarTambahan += '\
      <select name="searchPaket" id="searchPaket" class="form-control form-control-sm mx-1">\
        <option value="" selected>Semua Data Paket</option>';
        @foreach($pakets as $paket)
          toolbarTambahan += '<option value="{!! $paket->nama_paket !!}">{!! $paket->nama_paket !!}</option>';
        @endforeach
      toolbarTambahan += '</select></div>';

      var buttonConvert = '';
          buttonConvert += '\
          <button class="btn btn-success" id="excel"><span class="fa fa-download"></span> Excel</button>\
          <button class="btn btn-success" id="pdf"><span class="fa fa-download"></span> PDF</button>';

      $('div.toolbar').html(toolbarTambahan)
      $('div.toolbar').addClass('float-left')
      $('div.kumpulanButton').html(buttonConvert)
      $('div.kumpulanButton').addClass('float-left')
      $('div.toolbar #searchCheckOut').on('change', function(){
        dataTable.columns(10).search($(this).val()).draw();
      });
      $('div.toolbar #searchKamar').on('change', function(){
        dataTable.columns(12).search($(this).val()).draw();
      });
      $('div.toolbar #searchPaket').on('change', function(){
        dataTable.columns(13).search($(this).val()).draw();
      });

      $('div.toolbar #searchRangeCheckInCheckOut1').on('change', function(){
        dataTable.draw();
      });
      $('div.toolbar #searchRangeCheckInCheckOut2').on('change', function(){
        dataTable.draw();
      });

      $('div.kumpulanButton #excel').on('click',function(){
        var urlGoTo = $('div.toolbar #searchCheckOut').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val() + '&hobayu&' + $('div.pencarian').find('input').val() + '&hobayu&' + $('div.toolbar #searchKamar').val() + '&hobayu&' + $('div.toolbar #searchPaket').val();
        window.location = 'exportToExcel/'+ urlGoTo
      });

      $('div.kumpulanButton #pdf').on('click',function(){
        var urlGoTo = $('div.toolbar #searchCheckOut').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val() + '&hobayu&' + $('div.pencarian').find('input').val() + '&hobayu&' + $('div.toolbar #searchKamar').val() + '&hobayu&' + $('div.toolbar #searchPaket').val();
        window.location = 'exportToPdf/'+ urlGoTo
      });

      $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
          var check_in = $('#searchRangeCheckInCheckOut1').val();
          var check_out = $('#searchRangeCheckInCheckOut2').val();
          var kolomCheckIn = aData[11];
          if(check_in == '' && check_out == ''){
            return true;
          }
          if(check_in == ''){
            if(check_out >= kolomCheckIn){
              return true;
            }
          }
          if(check_out == ''){
            if(check_in <= kolomCheckIn){
              return true;
            }
          }

          if(check_in <= kolomCheckIn  && check_out >= kolomCheckIn){
            return true;
          }
          return false;
        }
      );
    }

    function showTableLogbook(){
      $.ajax({
        type:'GET',
        url:'getLogbook',
        success:function(data){

          var jsonData = data.msg;
          var data1 = '\
          <table class="table table-striped table-sm table-bordered small" id="tabelLogbook" cellspacing="0" width="100%"> \
            <thead class="bg-light">\
              <tr class="text-center">\
                <th class="col-xs-1 text-center customTableResponsive">No</th>\
                <th class="col-xs-1 text-center customTableResponsive">Tgl Masuk</th>\
                <th class="col-xs-2 text-center customTableResponsive">Identitas Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive">PPK I</th>\
                <th class="col-xs-1 text-center customTableResponsive">Dokter Perujuk</th>\
                <th class="col-xs-1 text-center customTableResponsive">Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive">ID BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive">Diagnosa</th>\
                <th class="col-xs-1 text-center customTableResponsive">Nama Dokter</th>\
                <th class="col-xs-2 text-center customTableResponsive">Ket/Tindakan</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Status Logbook</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">tgl Checkin</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Paket</th>\
              </tr>\
            </thead>\
            <tbody>';
          var no = 0;
          var data2 ='';
          var dataTambahan = '';
            for(indeks in jsonData){
              dataTambahan = jsonData[indeks].slug + '&hobayu&' + jsonData[indeks].check_in + '&hobayu&' + jsonData[indeks].check_out + '&hobayu&' + jsonData[indeks]["pasien"].slug + '&hobayu&' + jsonData[indeks]["pasien"].nama + '&hobayu&' + jsonData[indeks]["pasien"].no_rm + '&hobayu&' + jsonData[indeks].no_sep + '&hobayu&' + jsonData[indeks].ppk + '&hobayu&' + jsonData[indeks]['nokamar'].slug + '&hobayu&' + jsonData[indeks]['nokamar'].no_kamar + '&hobayu&' + jsonData[indeks]['paket'].slug + '&hobayu&' + jsonData[indeks].id_bpjs + '&hobayu&' + jsonData[indeks].diagnosa + '&hobayu&' + jsonData[indeks].nama_dokter + '&hobayu&' + jsonData[indeks].keterangan_tindakan + '&hobayu&' + jsonData[indeks].dokter_perujuk;
              data2 += '\
              <tr>\
                <td class="col-xs-1 text-center customTableResponsive">'+ ++no +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ tanggal(jsonData[indeks].check_in);
                if(jsonData[indeks].check_out != null){
                  data2 += "<br/><div class='bg-success'><b><sup>c</sup>/<sub>o</sub> OK</b></div>"
                }
                data2 +='</td>\
                <td class="col-xs-2 text-left customTableResponsive">'+
                  '<b>Nama:</b> <i>'+jsonData[indeks]['pasien'].nama +
                  '</i><br/><b>No.RM : </b><i>'+jsonData[indeks]['pasien'].no_rm +
                  '</i><br/><b>No.SEP: </b><i>'+jsonData[indeks].no_sep +
                  '</i><br/><b>Telp : </b><i>'+jsonData[indeks]['pasien'].tlp +
                  '</i><br/><b>Check-in : </b><i>'+ tanggal(jsonData[indeks].check_in) +
                  '</i><br/><b>Check-out : </b><i>';
                  if(jsonData[indeks].check_out == null){
                    data2 += "Belum Check Out"
                  }else{
                    data2 += tanggal(jsonData[indeks].check_out)
                  }
                data2 +='</i></td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].ppk +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].dokter_perujuk +'</td>\
                <td class="col-xs-1 text-center customTableResponsive text-center">'+
                  jsonData[indeks]['nokamar']['kamar'].nama_kamar +
                  '<br/>'+jsonData[indeks]['nokamar'].no_kamar +
                  '<br/>('+jsonData[indeks]['paket'].nama_paket +')' +
                '</td>\
                <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].id_bpjs_pasien +'<br/>('+jsonData[indeks].kelas_bpjs_pasien+')</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].diagnosa +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].nama_dokter +'</td>\
                <td class="col-xs-2 text-left customTableResponsive">'+ jsonData[indeks].keterangan_tindakan +'</td>\
                <td class="col-xs-1 text-right customTableResponsive d-none">'+jsonData[indeks].status_logbook+'</td>\
                <th class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].check_in+'</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks]['nokamar']['kamar'].nama_kamar +'</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks]['paket'].nama_paket+'</th>\
              </tr>'
            }
          data2 += '</tbody> \
          </table>';

          $('#dataTabelLogbook').html(data1+data2);
          sweetTable();
        }
      });
    }
    $(document).ajaxStart(function(){
      document.getElementById("loader").style.display = "";
      document.getElementById("dataTabelLogbook").style.display = "none";
    });

    $(document).ajaxStop(function(){
      document.getElementById("loader").style.display = "none";
      document.getElementById("dataTabelLogbook").style.display = "";
    });
  </script>
@endsection
