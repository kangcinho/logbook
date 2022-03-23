@extends('master.master')
@section('title','Data Reservasi Ecnocardiography')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Reservasi Ecnocardiography</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataReservasiEcnocardiography"></div>
    </div>
  </div>

@endsection

@section('additionalJS')
  <script type="text/javascript" src="{!! asset('js/dataTables.buttons.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.flash.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/jszip.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/pdfmake.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/vfs_fonts.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.html5.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/buttons.print.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/tanggalConvert.js') !!}"></script>
<script type="text/javascript">
  function sweetTable(){
    var dataTable = $('#tabelReservasiEcnocardiography').DataTable({
      "language": {
        "zeroRecords": "Tidak ada Data",
        "info": "Tampil Data _START_ sampai _END_ dari _TOTAL_ Jumlah Data",
        "infoEmpty": "Tampil 0 sampai 0 dari 0 Jumlah Data",
        "lengthMenu": "Tampilkan _MENU_ Jumlah Data",
        "search": "Cari ",
        "paginate": {
          "first":      "<<",
          "last":       ">>",
          "next":       ">",
          "previous":   "<"
        },
        "infoFiltered":   "(diambil dari _MAX_ jumlah seluruh data)",
      },
      'dom': '<"toolbar"><"pencarian"fr>tlrip<"kumpulanButton">B',
      buttons: [{
        extend: 'print',
        text: '<span class="fas fa-print"></span> Print',
        className: 'btn btn-success mx-1',
        title: function(){
          return '<small>Data Reservasi Ecnocardiography '+ tanggal($('div.toolbar #searchRangeCheckInCheckOut1').val()) +"-"+ tanggal($('div.toolbar #searchRangeCheckInCheckOut2').val())+'</small>';
        },
        exportOptions: {
          columns: [0,1,2,3,5,6,7,8,9,10],
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
    <label for="searchKonfirmasi">Tampilkan</label>\
    <select name="searchKonfirmasi" id="searchKonfirmasi" class="form-control form-control-sm mx-1">\
      <option value="" selected>Semua Data Pasien</option>\
      <option value="1">Pasien Sudah Konfirmasi </option>\
      <option value="0">Pasien Belum Konfirmasi </option>\
    </select>';

    toolbarTambahan += '\
    <input class="form-control form-control-sm mx-1" type="date" name="searchRangeCheckInCheckOut1" id="searchRangeCheckInCheckOut1" value=""/>\
    <label for="searchRangeCheckInCheckOut2">Sampai </label>\
    <input class="form-control form-control-sm mx-1" type="date" name="searchRangeCheckInCheckOut2" id="searchRangeCheckInCheckOut2" value=""/>\
    </div>';

    var buttonConvert = '';
        buttonConvert += '\
        <button class="btn btn-success" id="excel"><span class="fa fa-download"></span> Excel</button>\
        <button class="btn btn-success" id="pdf"><span class="fa fa-download"></span> PDF</button>';


    $('div.toolbar').html(toolbarTambahan)
    $('div.toolbar').addClass('float-left')
    $('div.kumpulanButton').html(buttonConvert)
    $('div.kumpulanButton').addClass('float-left')
    $('div.toolbar #searchKonfirmasi').on('change', function(){
      dataTable.columns(11).search($(this).val()).draw();
    });

    $('div.toolbar #searchRangeCheckInCheckOut1').on('change', function(){
      dataTable.draw();
    });

    $('div.toolbar #searchRangeCheckInCheckOut2').on('change', function(){
      dataTable.draw();
    });

    $.fn.dataTableExt.afnFiltering.push(
      function( oSettings, aData, iDataIndex ) {
        var check_in = $('#searchRangeCheckInCheckOut1').val();
        var check_out = $('#searchRangeCheckInCheckOut2').val();
        var kolomCheckIn = aData[10];
        if(check_in == undefined){
          check_in = '';
        }
        if(check_out == undefined){
          check_out = '';
        }
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
    )

    $('div.kumpulanButton #excel').on('click',function(){
      var urlGoTo = $('div.toolbar #searchKonfirmasi').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val();
      window.location = 'exportToExcel/'+ urlGoTo
    });

    $('div.kumpulanButton #pdf').on('click',function(){
      var urlGoTo = $('div.toolbar #searchKonfirmasi').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val();
      window.location = 'exportToPdf/'+ urlGoTo
    });

  }

  function showTabeldataReservasiEcnocardiography(){
    $.ajax({
      type:'GET',
      url:'../getEcnocardiography',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-bordered table-sm small" id="tabelReservasiEcnocardiography" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-2 text-center customTableResponsive">Tgl Ditindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Surat Rujukan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Petugas FO</th>\
              <th class="col-xs-1 text-center customTableResponsive">Petugas Poli</th>\
              <th class="col-xs-2 text-center customTableResponsive">Keterangan</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none"></th>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Tgl Ditindak</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Konfirmasi</td>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
        var dataTambahan = '';
          for(indeks in jsonData){
            dataTambahan = ''+'&hobayu&'+jsonData[indeks].slug +'&hobayu&'+ (jsonData[indeks]['pasien']?jsonData[indeks]['pasien'].slug:'') +'&hobayu&'+ jsonData[indeks].tgl_ditindak +'&hobayu&'+ jsonData[indeks].waktu_ditindak +'&hobayu&'+ (jsonData[indeks]['pasien']?jsonData[indeks]['pasien'].no_rm:'') + '&hobayu&' + '' + '&hobayu&'+ jsonData[indeks].nama_pasien +'&hobayu&'+ jsonData[indeks].tlp_pasien +'&hobayu&'+ jsonData[indeks].tgl_lahir_pasien +'&hobayu&'+jsonData[indeks].alamat_pasien +'&hobayu&' + jsonData[indeks].petugas_poli + '&hobayu&' + jsonData[indeks].petugas_fo +'&hobayu&'+ jsonData[indeks].keterangan+'&hobayu&'+ '' +'&hobayu&'+ jsonData[indeks].konfirmasi+'&hobayu&'+ jsonData[indeks].id_bpjs_pasien+'&hobayu&'+ jsonData[indeks].kelas_bpjs_pasien;
            data2 += '\
            <tr>\
              <td class="col-xs-2 text-center customTableResponsive">'+ tanggal(jsonData[indeks].tgl_ditindak) +' '+ jsonData[indeks].waktu_ditindak +' '+ (jsonData[indeks].konfirmasi=="1"?'<i class="fas fa-check"></i>':"") +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ (jsonData[indeks]['pasien']?jsonData[indeks]['pasien'].no_rm:'') +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].nama_pasien +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].alamat_pasien +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].tlp_pasien +'</td>';
              if(jsonData[indeks].surat_rujukan != ''){
                data2 += '<td class="col-xs-1 text-center customTableResponsive"><a role="button" data-toggle="modal" data-target="#modalShowImage" class="btn btn-outline-info btn-sm" data-tambahan="{!! asset('DataEcnocardiography') !!}'+ '/' +(jsonData[indeks]['pasien']?jsonData[indeks]['pasien'].no_rm:'') + '/' + jsonData[indeks].tgl_ditindak+ '/' + jsonData[indeks].surat_rujukan + '"><span class="fa fa-search"></span></a></td>';
              }else{
                data2 += '<td></td>';
              }
              data2 += '<td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].petugas_fo +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].petugas_poli +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ jsonData[indeks].keterangan +'</td>\
              <td class="col-xs-1 text-right customTableResponsive d-none"></td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ jsonData[indeks].tgl_ditindak+'</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ jsonData[indeks].konfirmasi +'</td>\
            </tr>'
          }
        data2 += '</tbody>\
        </table>';

        $('#dataReservasiEcnocardiography').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataReservasiEcnocardiography").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataReservasiEcnocardiography").style.display = "";
  });

  $(document).ready(function(){
    showTabeldataReservasiEcnocardiography();
  });
</script>
@endsection
