@extends('master.master')
@section('title','Data Logbook Rawat Jalan BPJS')
@section('content')
  <div id="statusMsg">
    @if(session('msg'))
      <div class="alert alert-info alert-dissmisible fade show" role="alert" >
        {!! session('msg') !!}
        <button data-dismiss="alert" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
  </div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Logbook Rawat Jalan BPJS</h5>
    </div>
    <div class="card-body">
      <div class="ml-3">
        <form class="form-inline" id="formTahunShowLogbook">
          <div class="form-group mb-2">
            <label>Tampilkan Logbook Rawat Jalan BPJS Tahun</label>
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <select class="form-control form-control-sm" name="tahunShowLogbook" id="tahunShowLogbook">
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
            </select>
          </div>
          <button type="submit" class="btn btn-sm btn-primary mb-2">Tampilkan Logbook</button>
        </form>
      </div>

      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelLogbook"></div>
    </div>
  </div>

  @include('logbook.modalDeleteDataLogbook')

@endsection
@section('additionalJS')
  <script>
    function sweetTable(dataDokter){
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
        @if(Auth::user()->can('report'))
        'dom': '<"toolbar">frtlripB',
        buttons: [
          {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [9,10,11,13,12,14,15,16,17,18,19,20,21,22]
            },
            text: '<span class="fa fa-download"></span> Excel',
            className: 'btn btn-success'
          },
          {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8,22],
                stripHtml: true,
                stripNewlines: false
            },
            className: 'btn btn-success',
            text: '<span class="fa fa-download"></span> PDF',
            customize: function(doc) {
              doc.defaultStyle.fontSize = 8;
              doc.styles.tableHeader.fontSize = 10;
            }
          },
        ]
        @endif
      });

      var buttonConvert = '';
          buttonConvert += '\
          <button class="btn btn-success" id="excel"><span class="fa fa-download"></span> Excel</button>\
          <button class="btn btn-success" id="pdf"><span class="fa fa-download"></span> PDF</button>';

      var toolbarTambahan = '';

      toolbarTambahan += '\
      <div class="form-inline my-1">\
        <label for="searchRawatJalan">Tampilkan</label>\
        <select name="searchRawatJalan" id="searchRawatJalan" class="form-control form-control-sm mx-1">\
          <option value="" selected>Semua Data Pasien Rawat Jalan</option>\
          <option value="0">Pasien Rawat Jalan </option>\
          <option value="1">Pasien Rawat Jalan Darurat </option>\
        </select>\
        <fieldset class="form-group border">\
          <legend class="col-form-legend">Tanggal Berobat</legend>\
          <div class="form-inline my-1" >\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_search1" id="check_in_search1" />\
            <label for="check_in_search2">Sampai </label>\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_search2" id="check_in_search2" />\
          </div>\
        </fieldset>\
      </div>';

      toolbarTambahan += '\
      <div class="form-inline my-1">';

      toolbarTambahan += '<label for="listNamaDokter" class="mr-4 pr-1">Dokter</label><select id="listNamaDokter" class="form-control form-control-sm mx-1">';
        toolbarTambahan += '<option value="" selected=true></option>';
        for(indeks in dataDokter){
          if(dataDokter[indeks].NamaDokterRawatInap == '' || dataDokter[indeks].NamaDokterRawatInap == null){
            continue;
          }
          if(dataDokter[indeks].NamaDokterRawatInap.includes('#')){
            continue;
          }
          toolbarTambahan += '<option value="'+dataDokter[indeks].NamaDokterRawatInap+'">'+dataDokter[indeks].NamaDokterRawatInap+'</option>';
        }
      toolbarTambahan += '</select></div>';

      $('div.toolbar').html(toolbarTambahan)
      $('div.toolbar').addClass('float-left')

      $('div.toolbar #check_in_search1').on('change', function(){
        dataTable.draw();
      });

      $('div.toolbar #check_in_search2').on('change', function(){
        dataTable.draw();
      });

      $('div.toolbar #searchRawatJalan').on('change', function(){
        dataTable.columns(22).search($(this).val()).draw();
      });

      $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
          var check_in = $('#check_in_search1').val();
          var check_out = $('#check_in_search2').val();

          var kolomCheckIn = aData[9];

          //Section Check-in Sampai Check-in
          if(check_in == undefined){
            check_in = '';
          }
          if(check_out == undefined){
            check_out = '';
          }
          // if((check_out == '' || check_out == undefined) && (check_in != '' || check_in != undefined)){
            if(check_in && !check_out){
              console.log(check_in);
              if(check_in == kolomCheckIn){
                return true;
              }else{
                return false;
              }
            }
          // }


            if(check_in && check_out){
              // console.log('ayee');
              if(check_in <= kolomCheckIn  && check_out >= kolomCheckIn){
                return true;
              }else{
                return false;
              }
            }
          //Akhir Section Check-in Sampai Check-in

          // //Section Check-in Sampaai Check-out
          // if(check_in_out == undefined){
          //   check_in_out = '';
          // }
          // if(check_out_out == undefined){
          //   check_out_out = '';
          // }
          //
          // if(check_in_out && !check_out_out){
          //   if(check_in_out == kolomCheckIn){
          //     return true;
          //   }else{
          //     return false;
          //   }
          // }
          //
          // if(check_in_out && check_out_out){
          //   if(check_in_out <= kolomCheckIn && check_out_out >= kolomCheckOut){
          //     return true;
          //   }
          //   return false;
          // }
          // //Akhir Section Check-in Sampai Check-Out

          if((!check_in && !check_out)){
            return true;
          }
          return false;
        }
      );

      $('div.toolbar #listNamaDokter').on('change',function(){
        dataTable.columns(7).search($(this).val()).draw();
      });

      $('div.toolbar #listNamaDokter').select2({
        theme : "bootstrap4",
        width : '100%',
      });
    }

    $('#formTahunShowLogbook').on('submit',function(e){
      e.preventDefault();
      $.ajax({
        type:'GET',
        url:'getLogbookrj/'+$('#tahunShowLogbook').val(),
        success:function(data){
          // alert('showTabel');
          var jsonData = data.msg, jsonDataDokter = data.dokter;
          var data1 = '\
          <table class="table table-striped table-sm table-bordered small" id="tabelLogbook" cellspacing="0" width="100%"> \
            <thead class="bg-light">\
              <tr>\
                <th class="col-xs-1 text-center customTableResponsive">No</th>\
                <th class="col-xs-1 text-center customTableResponsive">Tgl Berobat</th>\
                <th class="col-xs-3 text-center customTableResponsive">Identitas Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive">PPK I</th>\
                <th class="col-xs-1 text-center customTableResponsive">Dokter Perujuk</th>\
                <th class="col-xs-1 text-center customTableResponsive">ID BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive">Diagnosa</th>\
                <th class="col-xs-1 text-center customTableResponsive">Nama Dokter</th>\
                <th class="col-xs-1 text-center customTableResponsive">Ket/Tindakan</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Tanggal Berobat</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Pukul Berobat</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nomor RM</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Telpon Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">ID BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Paket BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nomor SEP</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">PPK I</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Dokter Perujuk</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Diagnosa</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Dokter Penghandel</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Keterangan Tindakan</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">UGD</th>\
              </tr>\
            </thead>\
            <tbody>';
          var no = 0;
          var data2 ='';
          var dataTambahan = '';
            for(indeks in jsonData){
              data2 += '\
              <tr>\
                <td class="col-xs-1 text-center customTableResponsive">'+ ++no +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ tanggal1(jsonData[indeks].JamReg) + '</td>\
                <td class="col-xs-3 text-left customTableResponsive">'+
                  '<b>Nama: </b><i>'+jsonData[indeks].NamaPasien +
                  '</i><br/>\n<b>No.RM : </b><i>'+jsonData[indeks].NRM +
                  '</i><br/>\n<b>No.SEP : </b><i>'+jsonData[indeks].NoSEP +
                  '</i><br/>\n<b>Telp : </b><i>'+jsonData[indeks].Phone + '</i></td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].AsalRujukan==null?'':jsonData[indeks].AsalRujukan) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].Rujukan!='0'?jsonData[indeks].Rujukan:'-') +'</td>\
                <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].NoAnggota +'<br/>\n('+jsonData[indeks].KelasBPJS +')</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].DiagnosaView == null?'':jsonData[indeks].DiagnosaView) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].NamaDokter +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].Keterangan == null?'':jsonData[indeks].Keterangan) +'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].JamReg.split(' ')[0]+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].JamReg != null?(jsonData[indeks].JamReg.split(' ')[1]).split('.')[0]:'')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NRM+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NamaPasien+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].Phone+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NoAnggota+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].KelasBPJS+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NoSEP+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].AsalRujukan==null?'-':jsonData[indeks].AsalRujukan)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].Rujukan!='0'?jsonData[indeks].Rujukan:'-')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].DiagnosaView == null?'':jsonData[indeks].DiagnosaView)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NamaDokter+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].Keterangan == null?'':jsonData[indeks].Keterangan)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].UGD+'</td>\
              </tr>';
            }
          data2 += '</tbody> \
          </table>';

          $('#dataTabelLogbook').html(data1+data2);
          sweetTable(jsonDataDokter);
        }
      });
    });

    $(document).ajaxStart(function(){
      document.getElementById("loader").style.display = "";
      document.getElementById("dataTabelLogbook").style.display = "none";
    });

    $(document).ajaxStop(function(){
      document.getElementById("loader").style.display = "none";
      document.getElementById("dataTabelLogbook").style.display = "";
    });

    $(document).ready(function(){
      document.getElementById("loader").style.display = "none";
    })
  </script>
@endsection
