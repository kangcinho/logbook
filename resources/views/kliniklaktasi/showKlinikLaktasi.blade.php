@extends('master.master')
@section('title','Data Reservasi Klinik Laktasi')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Reservasi Klinik Laktasi</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataReservasiKlinikLaktasi"></div>
    </div>

    <div class="card-footer">
      @if(Auth::user()->can('create'))
        <a role="button" class="btn btn-primary" title="Tambah Data Reservasi Klinik Laktasi" data-toggle="modal" data-target="#modalTambahEditReservasiKlinikLaktasi"><span class="fa fa-plus"></span> Data Reservasi Klinik Laktasi</a>
      @endif
    </div>
  </div>

  @include('kliniklaktasi.modalDeleteDataReservasiKlinikLaktasi')
  @include('kliniklaktasi.modalTambahEditReservasiKlinikLaktasi')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/kliniklaktasi/kliniklaktasi_clientToCRUD.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    showTabeldataReservasiKlinikLaktasi();
  })

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataReservasiKlinikLaktasi").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataReservasiKlinikLaktasi").style.display = "";
  });

  function sweetTable(){
    var dataTable = $('#tabelReservasiKlinikLaktasi').DataTable({
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
      "order": [[ 12, "asc" ], [ 11, "asc" ], [ 3, "asc" ] ],
      @if(Auth::user()->can('report'))
      'dom': '<"toolbar">frtlripB',
      buttons: [
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [2,3,4,5,6,7,8,9,12]
          },
          text: '<span class="fa fa-download"></span> Excel',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          exportOptions: {
              columns: [2,3,4,5,6,7,8,9,12],
              stripHtml: true,
              stripNewlines: false
          },
          className: 'btn btn-success',
          text: '<span class="fa fa-download"></span> PDF',
          customize: function(doc) {
            doc.defaultStyle.fontSize = 12;
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
      dataTable.columns(12).search($(this).val()).draw();
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
        var kolomCheckIn = aData[11];
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

  function showTabeldataReservasiKlinikLaktasi(){
    $.ajax({
      type:'GET',
      url:'getKlinikLaktasi',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-hover table-bordered table-sm small" id="tabelReservasiKlinikLaktasi" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Slug</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Slug Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-2 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Lahir Pasien</th>\
              <th class="col-xs-2 text-center customTableResponsive">Keterangan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Aksi</th>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Tgl Reservasi</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Konfirmasi</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">Tgl Lahir Pasien</td>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
        var dataTambahan = '';
          for(indeks in jsonData){
            data2 += '\
            <tr '+(htmlEncode(jsonData[indeks].konfirmasi)=="1"?" class='bg-success'":"")+' id="rowKe"'+ ++no +'>\
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].slug) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive d-none">'+ (jsonData[indeks]['pasien']?htmlEncode(jsonData[indeks]['pasien'].slug):'') +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].tgl_reservasi) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].pukul_reservasi_awal) +' - '+ htmlEncode(jsonData[indeks].pukul_reservasi_akhir) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ (jsonData[indeks]['pasien']?htmlEncode(jsonData[indeks]['pasien'].no_rm):'') +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].nama_pasien) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].alamat_pasien) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].tlp_pasien) +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ htmlEncode(jsonData[indeks].tgl_lahir_pasien) +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].keterangan) +'</td>\
              <td class="col-xs-1 text-right customTableResponsive">';
              @if(Auth::user()->can('update'))
                data2 += '<a role="button" class="btn btn-sm btn-warning" title="Ubah Data Pendaftaran dr.Upadana" data-toggle="modal" data-target="#modalTambahEditReservasiKlinikLaktasi" onclick="sendDataToForm(\'tabelReservasiKlinikLaktasi\', \'editTambahReservasiKlinikLaktasi\')"><span class="far fa-edit"></span></a>';
              @endif
              @if(Auth::user()->can('delete'))
                data2 += '<a role="button" class="btn btn-sm btn-danger" title="Hapus Data Pendaftaran dr.Upadana" data-toggle="modal" data-target="#modalDeleteDataReservasiKlinikLaktasi" onclick="sendDataToDelete(\'tabelReservasiKlinikLaktasi\', \'tabelDeleteKlinikLaktasi\')"><span class="far fa-trash-alt"></span></a>';
              @endif
              data2 += '</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].tgl_reservasi)+'</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].konfirmasi) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].tgl_lahir_pasien) +'</td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataReservasiKlinikLaktasi').html(data1+data2);
        sweetTable();
      }
    });
  }
</script>
@endsection
