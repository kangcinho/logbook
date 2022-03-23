@extends('master.master')
@section('title','Data User Log')
@section('content')
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data User Log</h5>
    </div>

    <div class="card-body small">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm" id="tabelUserLog" cellspacing="0" width="100%">
          <thead class="bg-light">
            <tr>
              <th class="col-xs-1 text-left customTableResponsive">Username</th>
              <th class="col-xs-1 text-left customTableResponsive">Nama User</th>
              <th class="col-xs-1 text-left customTableResponsive">Aksi</th>
              <th class="col-xs-1 text-left customTableResponsive">Tabel</th>
              <th class="col-xs-3 text-left customTableResponsive">Data Awal</th>
              <th class="col-xs-3 text-left customTableResponsive">Data Akhir</th>
              <th class="col-xs-2 text-center customTableResponsive">Tanggal</th>
              <th class="col-xs-2 text-center customTableResponsive d-none">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($userlogs as $userlog)
              <tr>
                <td class="col-xs-1 text-left customTableResponsive">{{ $userlog->user }}</td>
                <td class="col-xs-1 text-left customTableResponsive">{{ $userlog->nama_user }}</td>
                <td class="col-xs-1 text-left customTableResponsive">{{ $userlog->aksi }}</td>
                <td class="col-xs-1 text-left customTableResponsive">{{ $userlog->table_menu }}</td>
                <td class="col-xs-3 text-left customTableResponsive">{{ $userlog->data_awal }}</td>
                <td class="col-xs-3 text-left customTableResponsive">{{ $userlog->data_akhir }}</td>
                <td class="col-xs-2 text-center customTableResponsive">{{ tanggal($userlog->created_at) }}</td>
                <td class="col-xs-2 text-center customTableResponsive d-none">{{ explode(' ',$userlog->created_at)[0] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('additionalJS')
<script type="text/javascript">
$(document).ready(function(){
  var dataTable = $('#tabelUserLog').DataTable({
    "language": {
      "zeroRecords": "Tidak ada Data",
      "info": "Tampil Data _START_ sampai _END_ dari _TOTAL_ Jumlah Data",
      "infoEmpty": "Tampil 0 sampai 0 dari 0 Jumlah Data",
      "lengthMenu": "Tampilkan _MENU_",
      "search": "Cari ",
      "paginate": {
        "first":      "<<",
        "last":       ">>",
        "next":       ">",
        "previous":   "<"
      },
      "infoFiltered":   "(diambil dari _MAX_ jumlah seluruh data)",
    },
    'dom': '<"length"lr><"toolbar">tipB',
    buttons: [
      {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [0,1,2,3,4,5,6]
        },
        text: '<span class="fa fa-download"></span> Excel',
        className: 'btn btn-success'
      },
      {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0,1,2,3,4,5,6],
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
  });

  var toolbarTambahan = '<div class="form-inline mx-5">\
  <label for="tanggalPertama">Tampilkan </label>\
  <input class="form-control form-control-sm mx-1" type="date" name="tanggalPertama" id="tanggalPertama" />\
  <label for="tanggalKedua">Sampai </label>\
  <input class="form-control form-control-sm  mx-1" type="date" name="tanggalKedua" id="tanggalKedua" />\
  <input class="form-control form-control-sm  mx-1" type="text" name="searchUsername" id="searchUsername" placeholder="Cari Username" />\
  <input class="form-control form-control-sm  mx-1" type="text" name="searchNamaUser" id="searchNamaUser" placeholder="Cari Nama User" />\
  <input class="form-control form-control-sm  mx-1" type="text" name="searchTable" id="searchTable" placeholder="Cari Tabel" />\
  </div>';

  $('div.toolbar').html(toolbarTambahan)
  $('div.toolbar').addClass('float-left')
  $('div.length').addClass('float-left')

  $('div.toolbar #tanggalPertama').on('change', function(){
    dataTable.draw();
  });

  $('div.toolbar #tanggalKedua').on('change', function(){
    dataTable.draw();
  });

  $('div.toolbar #searchUsername').on('keyup',function(){
    dataTable.columns(0).search($(this).val()).draw();
  });

  $('div.toolbar #searchNamaUser').on('keyup',function(){
    dataTable.columns(1).search($(this).val()).draw();
  });

  $('div.toolbar #searchTable').on('keyup',function(){
    dataTable.columns(3).search($(this).val()).draw();
  });

  $.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ){
      var tanggalPertama = $('#tanggalPertama').val();
      var tanggalKedua = $('#tanggalKedua').val();
      var kolomTargetSearch = aData[7];

      if(tanggalPertama == undefined){
        check_in = '';
      }
      if(tanggalKedua == undefined){
        check_out = '';
      }
      if(tanggalPertama == '' && tanggalKedua == ''){
        return true;
      }
      if(tanggalPertama == ''){
        if(tanggalKedua >= kolomTargetSearch){
          return true;
        }
      }
      if(tanggalKedua == ''){
        if(tanggalPertama <= kolomTargetSearch){
          return true;
        }
      }
      if(tanggalPertama <= kolomTargetSearch  && tanggalKedua >= kolomTargetSearch){
        return true;
      }
      return false;
    }
  );
})
</script>
@endsection
