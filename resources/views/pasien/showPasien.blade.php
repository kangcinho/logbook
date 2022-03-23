@extends('master.master')
@section('title','Data Pasien Log Book')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Pasien</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelPasien"></div>
    </div>

    <div class="card-footer">
      <a role="button" class="btn btn-primary" title="Tambah Data Pasien" data-toggle="modal" data-target="#modalTambahEditPasien"><span class="fa fa-plus"></span> Data Pasien</a>
    </div>
  </div>

  @include('pasien.modalTambahEditPasien')
  @include('pasien.modalDeleteDataPasien')

@endsection

@section('additionalJS')
  <script type="text/javascript" src="{{ asset('js/pasien/pasien_clientToCRUD.js') }}"></script>
  <script type="text/javascript">

  $(document).ready(function(){
    showTablePasien();
  });

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelPasien").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelPasien").style.display = "";
  });
    function sweetTable(){
      $('#tabelPasien').DataTable({
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
        }
      });
    }
    function showTablePasien(){
      $.ajax({
        type:'GET',
        url:'getPasien',
        success:function(data){
          var jsonData = data.msg;
          var data1 = '\
          <table class="table table-bordered table-striped table-sm small" id="tabelPasien" cellspacing="0" width="100%"> \
            <thead class="bg-light">\
              <tr>\
                <th class="col-xs-1 text-left customTableResponsive">No</th>\
                <th class="col-xs-1 text-left customTableResponsive d-none">slug</th>\
                <th class="col-xs-3 text-left customTableResponsive">Nama Pasien</th>\
                <th class="col-xs-1 text-left customTableResponsive">No RM</th>\
                <th class="col-xs-2 text-left customTableResponsive">Telpon</th>\
                <th class="col-xs-1 text-left customTableResponsive">Tgl lahir</th>\
                <th class="col-xs-2 text-left customTableResponsive">Alamat</th>\
                <th class="col-xs-2 text-center customTableResponsive">Aksi</th>\
              </tr>\
            </thead>\
            <tbody>';
          var no = 0;
          var data2 ='';
            for(indeks in jsonData){
              data2 += '\
              <tr>\
                <td class="col-xs-1 text-left customTableResponsive">'+ ++no +'</td>\
                <td class="col-xs-1 text-left customTableResponsive d-none">'+ htmlEncode(jsonData[indeks].slug) +'</td>\
                <td class="col-xs-3 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].nama) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].no_rm) +'</td>\
                <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].tlp) +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].tgl_lahir) +'</td>\
                <td class="col-xs-2 text-left customTableResponsive">'+ htmlEncode(jsonData[indeks].alamat) +'</td>\
                <td class="col-xs-2 text-right customTableResponsive">\
                  <a role="button" class="btn btn-warning" title="Ubah Data Pasien" data-toggle="modal" data-target="#modalTambahEditPasien" onclick="sendDataToForm(\'tabelPasien\', \'editTambahPasien\')" ><span class="far fa-edit"></span></a>\
                  <a role="button" class="btn btn-danger" title="Hapus Data Pasien" data-toggle="modal" data-target="#modalDeleteDataPasien" onclick="sendDataToDelete(\'tabelPasien\', \'tabelDeletePasien\')" ><span class="far fa-trash-alt"></span></a>\
                </td>\
              </tr>'
            }
          data2 += '</tbody> \
          </table>';
          $('#dataTabelPasien').html(data1+data2);
          sweetTable();
        }
      });
    }
  </script>

@endsection
