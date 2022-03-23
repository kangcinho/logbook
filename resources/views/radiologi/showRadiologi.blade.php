@extends('master.master')
@section('title','Data Reservasi Radiologi')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Reservasi Radiologi</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataReservasiRadiologi"></div>
    </div>

    <div class="card-footer">
      @if(Auth::user()->can('create'))
        <a role="button" class="btn btn-primary" title="Tambah Data Reservasi Radiologi" data-toggle="modal" data-target="#modalTambahEditReservasiRadiologi"><span class="fa fa-plus"></span> Data Reservasi Radiologi</a>
      @endif
    </div>
  </div>

  @include('radiologi.modalDeleteDataReservasiRadiologi')
  @include('radiologi.modalTambahEditReservasiRadiologi')
  @include('radiologi.modalShowImage')

@endsection

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/radiologi/radiologi_clientToCRUD.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    showTabeldataReservasiRadiologi();
  });

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataReservasiRadiologi").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataReservasiRadiologi").style.display = "";
  });

  function sweetTable(){
    var dataTable = $('#tabelReservasiRadiologi').DataTable({
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
      "order": [[ 15, "asc" ], [ 2, "asc" ], [ 3, "asc" ] ],
      @if(Auth::user()->can('report'))
      'dom': '<"toolbar">frtlripB',
      buttons: [
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [2,3,4,5,6,7,8,10,11,12,15]
          },
          text: '<span class="fa fa-download"></span> Excel',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          exportOptions: {
              columns: [2,3,4,5,6,7,8,10,11,12,15],
              stripHtml: true,
              stripNewlines: false
          },
          className: 'btn btn-success',
          text: '<span class="fa fa-download"></span> PDF',
          customize: function(doc) {
            doc.defaultStyle.fontSize = 11;
            doc.styles.tableHeader.fontSize = 12;
          }
        },
      ]
      @endif
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

    $('div.toolbar').html(toolbarTambahan)
    $('div.toolbar').addClass('float-left')
    $('div.toolbar #searchKonfirmasi').on('change', function(){
      dataTable.columns(15).search($(this).val()).draw();
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
        var kolomCheckIn = aData[2];
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
  }

  function showTabeldataReservasiRadiologi(){
    $.ajax({
      type:'GET',
      url:'getRadiologi',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-bordered table-sm small" id="tabelReservasiRadiologi" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Slug</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Slug Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Ditindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Ditindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">dr Pengirim</th>\
              <th class="col-xs-1 text-center customTableResponsive">Surat Rujukan</th>\
              <th class="col-xs-1 text-center customTableResponsive">dr Penindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">Jenis Tindakan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Ptgs Radiologi</th>\
              <th class="col-xs-1 text-center customTableResponsive">Aksi</th>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Tgl diambil</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Konfirmasi</td>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
        var dataTambahan = '';
          for(indeks in jsonData){
            data2 += '\
            <tr '+(htmlEncode(jsonData[indeks].konfirmasi)=="1"?" class='bg-success'":"") +'>\
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].slug) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ (jsonData[indeks]['pasien']?htmlEncode(jsonData[indeks]['pasien'].slug):'') +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].tgl_ditindak) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].waktu_ditindak) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ (jsonData[indeks]['pasien']?htmlEncode(jsonData[indeks]['pasien'].no_rm):'')+'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].nama_pasien) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].alamat_pasien) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].tlp_pasien) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].dokter_pengirim) +'</td>';
              if(htmlEncode(jsonData[indeks].surat_rujukan) != ''){
                data2 += '<td class="col-xs-1 text-center customTableResponsive"><a role="button" data-toggle="modal" data-target="#modalShowImage" class="btn btn-outline-info btn-sm" data-tambahan="{!! asset('DataRadiologi') !!}'+ '/' +(jsonData[indeks]['pasien']?htmlEncode(jsonData[indeks]['pasien'].no_rm):'') + '/' + htmlEncode(jsonData[indeks].tgl_ditindak)+ '/' + htmlEncode(jsonData[indeks].surat_rujukan) + '"><span class="fa fa-search"></span></a></td>';
              }else{
                data2 += '<td></td>';
              }
              data2 += '<td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].dokter_penindak) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].jenis_tindakan) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].petugas_radiologi) +'</td>\
              <td class="col-xs-1 text-right customTableResponsive">';
              @if(Auth::user()->can('update'))
                data2 += '<a role="button" class="btn btn-sm btn-warning" title="Ubah Data Pendaftaran dr.Upadana" data-toggle="modal" data-target="#modalTambahEditReservasiRadiologi" onclick="sendDataToForm(\'tabelReservasiRadiologi\', \'editTambahReservasiRadiologi\')" ><span class="far fa-edit"></span></a>';
              @endif
              @if(Auth::user()->can('delete'))
                data2 += '<a role="button" class="btn btn-sm btn-danger" title="Hapus Data Pendaftaran dr.Upadana" data-toggle="modal" data-target="#modalDeleteDataReservasiRadiologi" onclick="sendDataToDelete(\'tabelReservasiRadiologi\', \'tabelDeleteRadiologi\')"><span class="far fa-trash-alt"></span></a>';
              @endif
              data2 += '</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].tgl_ditindak) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].konfirmasi) +'</td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataReservasiRadiologi').html(data1+data2);
        sweetTable();
      }
    });
  }


</script>
@endsection
