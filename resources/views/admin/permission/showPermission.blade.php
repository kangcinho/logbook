@extends('master.master')
@section('title','Data Permission')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Permission</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataPermission"></div>
    </div>

    <div class="card-footer">
      <a role="button" class="btn btn-primary" title="Tambah Data Permission" data-toggle="modal" data-target="#modalTambahEditPermission"><span class="fa fa-plus"></span> Data Permission</a>
    </div>
  </div>

  @include('admin.permission.modalTambahEditPermission')
@endsection

@section('additionalJS')
<script type="text/javascript">
  function sweetTable(){
    var dataTable = $('#tabelPermission').DataTable({
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
      'dom': 'frtlrip',
    });
  }

  function showTablePermission(){
    $.ajax({
      type:'GET',
      url:'getPermission',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-bordered table-sm small" id="tabelPermission" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive">No</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama Publish</th>\
              <th class="col-xs-2 text-center customTableResponsive">Deskripsi</th>\
            </tr>\
          </thead>\
          <tbody>';
        let no = 0;
        let data2 ='';
          for(indeks in jsonData){
            data2 += '\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ ++no +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].name +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ jsonData[indeks].display_name +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ jsonData[indeks].description +'</td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataPermission').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataPermission").style.display = "none";
  });

  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataPermission").style.display = "";
  });

  $(document).ready(function(){
    showTablePermission();

    $('#tambahPermission').on('submit',function(e){
      e.preventDefault();
      if(cekValidasi(this)){
        $('#modalTambahEditPermission').modal('hide');
        sendToServer(this, 'POST', 'tambah/permission', false, 'statusMsg', showTablePermission);
      }
    });

    $('#modalTambahEditPermission').on('show.bs.modal', function(event){
      $('#tambahPermission').removeClass('was-validated');
    });

  });
</script>
@endsection
