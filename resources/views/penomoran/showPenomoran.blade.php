@extends('master.master')
@section("title", "Penomoran Virtual Claim BPJS")
@section("content")
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Penomoran Virtual Claim BPJS</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelPenomoranBPJS"></div>
    </div>

    <div class="card-footer">
      @if(Auth::user()->can('create'))
        <a role="button" class="btn btn-primary" title="Tambah Data Penomoran" data-toggle="modal" data-target="#modalTambahEditPenomoran"><span class="fa fa-plus"></span> Data Penomoran BPJS</a>
      @endif
    </div>
  </div>

  @include('penomoran.modalTambahEditPenomoran')
  @include('penomoran.modalDeleteDataPenomoran')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{{ asset('js/penomoran/penomoran_clientToCRUD.js') }}"></script>
<script>
  $(document).ready(function(){
    showTablePenomoran();
  });

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelPenomoranBPJS").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelPenomoranBPJS").style.display = "";
  });

  function sweetTable(){
    var dataTable = $('#tabelPenomoranBPJS').DataTable({
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
      "order": [ 9, "desc" ],
      @if(Auth::user()->can('report'))
      'dom': '<"toolbar">frtlripB',
      buttons: [
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [1,2,3,4,5,6,7]
          },
          text: '<span class="fa fa-download"></span> Excel',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          exportOptions: {
              columns: [1,2,3,4,5,6,7],
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

  }
  function showTablePenomoran(){
    $.ajax({
      type:'GET',
      url:'getPenomoran',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-bordered table-striped table-sm small" id="tabelPenomoranBPJS" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-2 text-left customTableResponsive d-none">id</th>\
              <th class="col-xs-2 text-left customTableResponsive text-center">Nomor Rujukan</th>\
              <th class="col-xs-1 text-left customTableResponsive text-center">Nomor SPRI</th>\
              <th class="col-xs-2 text-left customTableResponsive text-center">Nomor Surat Kontrol</th>\
              <th class="col-xs-1 text-left customTableResponsive">NRM</th>\
              <th class="col-xs-2 text-left customTableResponsive">Nama</th>\
              <th class="col-xs-2 text-left customTableResponsive">Alamat</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Lahir</th>\
              <th class="col-xs-1 text-center customTableResponsive">Aksi</th>\
              <th class="col-xs-1 text-center customTableResponsive d-none">Created At</th>\
            </tr>\
          </thead>\
          <tbody>';
        var no = 0;
        var data2 ='';
          for(indeks in jsonData){
            data2 += '\
            <tr>\
              <td class="col-xs-2 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].id) +'</td>\
              <td class="col-xs-2 text-left customTableResponsive text-center">'+ htmlEncode(jsonData[indeks].nomor_rujukan) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive text-center">'+ htmlEncode(jsonData[indeks].nomor_spri) +'</td>\
              <td class="col-xs-2 text-left customTableResponsive text-center">'+ htmlEncode(jsonData[indeks].nomor_surat_kontrol) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].nrm) +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].nama) +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].alamat) +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].tgl_lahir) +'</td>\
              <td class="col-xs-1 text-right customTableResponsive">';
              @if(Auth::user()->can('update'))
                data2 += '<a role="button" class="btn btn-warning" title="Ubah Data Penomoran" data-toggle="modal" data-target="#modalTambahEditPenomoran" onclick="sendDataToForm(\'tabelPenomoranBPJS\', \'editTambahPenomoranBPJS\')" ><span class="far fa-edit"></span></a>';
              @endif
              @if(Auth::user()->can('delete'))
                data2 += '<a role="button" class="btn btn-danger" title="Hapus Data Penomoran" data-toggle="modal" data-target="#modalDeleteDataPenomoranBPJS" onclick="sendDataToDelete(\'tabelPenomoranBPJS\', \'tabelDeletePenomoranBPJS\')" ><span class="far fa-trash-alt"></span></a>';
              @endif
              data2 += '</td>\
              <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].created_at) +'</td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';
        $('#dataTabelPenomoranBPJS').html(data1+data2);
        sweetTable();
      }
    });
  }
</script>
@endsection
