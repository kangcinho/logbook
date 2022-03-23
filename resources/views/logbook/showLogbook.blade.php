@extends('master.master')
@section('title','Data Logbook Rawat Inap BPJS')
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
      <h5>Data Logbook Rawat Inap BPJS</h5>
    </div>
    <div class="card-body">
      <div class="ml-3">
        <form class="form-inline" id="formTahunShowLogbook">
          <div class="form-group mb-2">
            <label>Tampilkan Logbook Rawat Inap BPJS Tahun</label>
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
    function sweetTable(dataDokter, dataKamar){

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
                columns: [11,13,12,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29]
            },
            text: '<span class="fa fa-download"></span> Excel',
            className: 'btn btn-success'
          },
          {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
      toolbarTambahan += '<div class="form-inline my-1">\
      <label for="searchCheckOut">Tampilkan</label>\
      <select name="searchCheckOut" id="searchCheckOut" class="form-control form-control-sm mx-1">\
        <option value="" selected>Semua Data Pasien</option>\
        <option value="1">Pasien Sudah Check Out </option>\
        <option value="0">Pasien Belum Check Out </option>\
      </select>';

    toolbarTambahan += '<label for="kelasKamar">Nama Kamar</label>\
      <select name="kelasKamar" id="kelasKamar" class="form-control form-control-sm mx-1">\
        <option value="" selected></option>';
        for(indeks in dataKamar){
          if(dataKamar[indeks].NamaKelas == "XX"){
            continue;
          }
          toolbarTambahan += '<option value="'+dataKamar[indeks].NamaKelas+'">'+dataKamar[indeks].NamaKelas+'</option>';
        }
    toolbarTambahan += '</select>';

    toolbarTambahan += '<label for="paketKamar">Paket Kamar</label>\
      <select name="paketKamar" id="paketKamar" class="form-control form-control-sm mx-1">\
        <option value="" selected></option>\
        <option value="Silver">Silver</option>\
        <option value="Silver Top Up">Silver Top Up</option>\
        <option value="Silver Plus">Silver Plus</option>\
      </select>';

      toolbarTambahan += '\
      </div><div class="form-inline my-1">';

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
      toolbarTambahan += '\
      <div class="form-inline my-1">\
        <fieldset class="form-group border">\
          <legend class="col-form-legend">Check-in Sampai Check-in</legend>\
          <div class="form-inline my-1" >\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_search1" id="check_in_search1" />\
            <label for="check_in_search2">Sampai </label>\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_search2" id="check_in_search2" />\
          </div>\
        </fieldset>\
        <fieldset class="form-group border mx-2">\
          <legend class="col-form-legend">Check-out Sampai Check-out</legend>\
          <div class="form-inline my-1" >\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_out_search1" id="check_in_out_search1" />\
            <label for="check_in_out_search2">Sampai </label>\
            <input class="form-control form-control-sm mx-1" type="date" name="check_in_out_search2" id="check_in_out_search2" />\
          </div>\
        </fieldset>\
      </div>';

      $('div.toolbar').html(toolbarTambahan)
      $('div.toolbar').addClass('float-left')
      $('div.kumpulanButton').html(buttonConvert)
      $('div.kumpulanButton').addClass('float-left')
      $('div.toolbar #searchCheckOut').on('change', function(){
        dataTable.columns(10).search($(this).val()).draw();
      });

      $('div.toolbar #kelasKamar').on('change',function(){
        if($(this).val()){
          dataTable.columns(23).search("^" + $(this).val() + "$", true, false, true).draw();
        }else{
          dataTable.columns(23).search($(this).val()).draw();
        }
      });

      $('div.toolbar #paketKamar').on('change',function(){
        if($(this).val()){
          dataTable.columns(25).search("^" + $(this).val() + "$", true, false, true).draw();
        }else{
          dataTable.columns(25).search($(this).val()).draw();
        }
      });

      $('div.toolbar #check_in_search1').on('change', function(){
        dataTable.draw();
        if($('#check_in_search1').val() || $('#check_in_search2').val()){
          $('#check_in_out_search1').prop('disabled',true);
          $('#check_in_out_search2').prop('disabled',true);
        }else{
          $('#check_in_out_search1').prop('disabled',false);
          $('#check_in_out_search2').prop('disabled',false);
        }
      });

      $('div.toolbar #check_in_search2').on('change', function(){
        dataTable.draw();
        if($('#check_in_search1').val() || $('#check_in_search2').val()){
          $('#check_in_out_search1').prop('disabled',true);
          $('#check_in_out_search2').prop('disabled',true);
        }else{
          $('#check_in_out_search1').prop('disabled',false);
          $('#check_in_out_search2').prop('disabled',false);
        }
      });

      $('div.toolbar #check_in_out_search1').on('change', function(){
        dataTable.draw();
        if($('#check_in_out_search1').val() || $('#check_in_out_search2').val()){
          $('#check_in_search1').prop('disabled',true);
          $('#check_in_search2').prop('disabled',true);
        }else{
          $('#check_in_search1').prop('disabled',false);
          $('#check_in_search2').prop('disabled',false);
        }
      });

      $('div.toolbar #check_in_out_search2').on('change', function(){
        dataTable.draw();
        if($('#check_in_out_search1').val() || $('#check_in_out_search2').val()){
          $('#check_in_search1').prop('disabled',true);
          $('#check_in_search2').prop('disabled',true);
        }else{
          $('#check_in_search1').prop('disabled',false);
          $('#check_in_search2').prop('disabled',false);
        }
      });


      $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
          var check_in = $('#check_in_search1').val();
          var check_out = $('#check_in_search2').val();
          var check_in_out = $('#check_in_out_search1').val();
          var check_out_out = $('#check_in_out_search2').val();

          var kolomCheckIn = aData[11];
          var kolomCheckOut = aData[12];

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

          //Section Check-out Sampaai Check-out
          if(check_in_out == undefined){
            check_in_out = '';
          }
          if(check_out_out == undefined){
            check_out_out = '';
          }

          if(check_in_out && !check_out_out){
            if(check_in_out == kolomCheckOut){
              return true;
            }else{
              return false;
            }
          }

          if(check_in_out && check_out_out){
            if(check_in_out <= kolomCheckOut && check_out_out >= kolomCheckOut){
              return true;
            }
            return false;
          }
          //Akhir Section Check-out Sampai Check-Out

          if((!check_in && !check_out) || (!check_in_out && !check_out_out)){
            return true;
          }
          return false;
        }
      );

      $('div.toolbar #listNamaDokter').on('change',function(){
        dataTable.columns(8).search($(this).val()).draw();
      });

      $('div.toolbar #listNamaDokter').select2({
        theme : "bootstrap4",
        width : '54%',
      });

      $('div.kumpulanButton #excel').on('click',function(){
        var urlGoTo = $('div.toolbar #searchCheckOut').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val() + '&hobayu&' + $('div.toolbar #listNamaDokter').val() +'&hobayu&'+ $('#tahunShowLogbook').val();
        // window.location = 'exportToExcel/'+ urlGoTo;
      });

      $('div.kumpulanButton #pdf').on('click',function(){
        var urlGoTo = $('div.toolbar #searchCheckOut').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut1').val() + '&hobayu&' + $('div.toolbar #searchRangeCheckInCheckOut2').val() + '&hobayu&' + $('div.toolbar #listNamaDokter').val() +'&hobayu&'+ $('#tahunShowLogbook').val();
        // window.location = 'exportToPdf/'+ urlGoTo;
      });

    }

    $('#formTahunShowLogbook').on('submit',function(e){
      e.preventDefault();
      $.ajax({
        type:'GET',
        url:'getLogbook/'+$('#tahunShowLogbook').val(),
        success:function(data){
          // alert('showTabel');
          var jsonData = data.msg, jsonDataDokter = data.dokter, jsonDataKamar = data.kamar;
          var data1 = '\
          <table class="table table-striped table-sm table-bordered small" id="tabelLogbook" cellspacing="0" width="100%"> \
            <thead class="bg-light">\
              <tr>\
                <th class="col-xs-1 text-center customTableResponsive">No</th>\
                <th class="col-xs-1 text-center customTableResponsive">Tgl Masuk</th>\
                <th class="col-xs-3 text-center customTableResponsive">Identitas Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive">PPK I</th>\
                <th class="col-xs-1 text-center customTableResponsive">Dokter Perujuk</th>\
                <th class="col-xs-1 text-center customTableResponsive">Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive">ID BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive">Diagnosa</th>\
                <th class="col-xs-1 text-center customTableResponsive">Nama Dokter</th>\
                <th class="col-xs-1 text-center customTableResponsive">Ket/Tindakan</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Status Logbook</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Tanggal Check In</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Tanggal Check out</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Pukul Check In</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Pukul Check Out</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nomor RM</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Telpon Pasien</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">ID BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Paket BPJS</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nomor SEP</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">PPK I</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Dokter Perujuk</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nomor Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Paket Kamar</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Diagnosa</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Nama Dokter Penghandel</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Keterangan Tindakan</th>\
                <th class="col-xs-1 text-center customTableResponsive d-none">Keterangan System</th>\
              </tr>\
            </thead>\
            <tbody>';
          var no = 0;
          var data2 ='', namaKelas = '';
          var dataTambahan = '';
          var paketPilihan = '';
            for(indeks in jsonData){
              data2 += '\
              <tr>\
                <td class="col-xs-1 text-center customTableResponsive">'+ ++no +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ tanggal1(jsonData[indeks].JamReg);
                if(jsonData[indeks].JamKeluar != null){
                  data2 += "<br/>\n<div class='bg-success'><b><sup>c</sup>/<sub>o</sub> OK</b></div>"
                }
                data2 +='</td>\
                <td class="col-xs-3 text-left customTableResponsive">'+
                  '<b>Nama: </b><i>'+jsonData[indeks].NamaPasien +
                  '</i><br/>\n<b>No.RM : </b><i>'+jsonData[indeks].NRM +
                  '</i><br/>\n<b>No.SEP : </b><i>'+jsonData[indeks].NoSEP +
                  '</i><br/>\n<b>Telp : </b><i>'+jsonData[indeks].Phone +
                  '</i><br/>\n<b>Check-in : </b><i>'+ tanggal1(jsonData[indeks].JamReg) +
                  '</i><br/>\n<b>Check-out : </b><i>';
                  if(jsonData[indeks].JamKeluar == null){
                    data2 += "Belum Check Out"
                  }else{
                    data2 += tanggal1(jsonData[indeks].JamKeluar)
                  }
                  if(jsonData[indeks].TitipKelas == '1'){
                    namaKelas = jsonData[indeks].kelasAsal_;
                  }else if(jsonData[indeks].TitipKelas == '0'){
                    namaKelas = jsonData[indeks].kelasPelayanan_;
                  }
                data2 +='</i></td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].AsalRujukan==null?'':jsonData[indeks].AsalRujukan) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].Rujukan!='0'?jsonData[indeks].Rujukan:'-') +'</td>\
                <td class="col-xs-1 text-center customTableResponsive ">'+
                  namaKelas +
                  '<br/>\n'+jsonData[indeks].NoKamar;
                if(jsonData[indeks].NaikKelas == '0' && jsonData[indeks].SilverPlus == '0'){
                  paketPilihan = 'Silver';
                }else if(jsonData[indeks].NaikKelas == '1' && jsonData[indeks].SilverPlus == '0'){
                  paketPilihan = "Silver Top UP";
                }else if(jsonData[indeks].SilverPlus == '1'){
                  paketPilihan = "Silver Plus";
                }
                data2+= '<br/>\n('+ paketPilihan +')';
                data2+= '</td>\
                <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].NoAnggota +'<br/>\n('+jsonData[indeks].KelasBPJS +')</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].DiagnosaView == null?'':jsonData[indeks].DiagnosaView) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].NamaDokterRawatInap +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ (jsonData[indeks].Keterangan == null?'':jsonData[indeks].Keterangan) +'<br/>\n';
                if(jsonData[indeks].TitipKelas == '1'){
                  data2 += '<div class="text-info font-italic">System : titip kelas<br/>Kelas Pelayanan :</div>';
                  data2 += '<div class="text-info font-italic">'+'hello world'+'</div>';
                }else if(jsonData[indeks].TitipKelas == '0'){
                  //i don't know what should i do here!
                }
                data2 += '</td>\
                <td class="col-xs-1 text-right customTableResponsive d-none">'+(jsonData[indeks].JamKeluar == null?"0":"1")+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].JamReg.split(' ')[0]+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].JamKeluar != null?jsonData[indeks].JamKeluar.split(' ')[0]:'')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].JamReg != null?(jsonData[indeks].JamReg.split(' ')[1]).split('.')[0]:'')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].JamKeluar != null?(jsonData[indeks].JamKeluar.split(' ')[1]).split('.')[0]:'')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NRM+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NamaPasien+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].Phone+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NoAnggota+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].KelasBPJS+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NoSEP+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].AsalRujukan==null?'-':jsonData[indeks].AsalRujukan)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].Rujukan!='0'?jsonData[indeks].Rujukan:'-')+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+namaKelas+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NoKamar+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+paketPilihan+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].DiagnosaView == null?'':jsonData[indeks].DiagnosaView)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+jsonData[indeks].NamaDokterRawatInap+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">'+(jsonData[indeks].Keterangan == null?'':jsonData[indeks].Keterangan)+'</td>\
                <td class="col-xs-1 text-center customTableResponsive d-none">';
                  if(jsonData[indeks].TitipKelas == '1'){
                    data2 += '<div class="text-warning">System : titip kelas</div>';
                  }else if(jsonData[indeks].TitipKelas == '0'){
                    //i don't know what should i do here!
                  }
                data2 += '</td>\
              </tr>'
            }
          data2 += '</tbody> \
          </table>';

          $('#dataTabelLogbook').html(data1+data2);
          sweetTable(jsonDataDokter, jsonDataKamar);
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
