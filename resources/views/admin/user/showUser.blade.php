@extends('master.master')
@section('title','Data User')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data User</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelUser"></div>
    </div>

    <div class="card-footer">
      <a role="button" class="btn btn-primary" title="Tambah Data User" href="tambah/user"><span class="fa fa-plus"></span> Data Role</a>
    </div>
  </div>
@endsection

@section('additionalJS')
<script type="text/javascript">
  function sweetTable(){
    $('#tabelUser').DataTable({
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

  function showTableUser(){
    $.ajax({
      type:'GET',
      url:'getUser',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-sm" id="tabelUser" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-left customTableResponsive">No</th>\
              <th class="col-xs-3 text-left customTableResponsive">Nama User</th>\
              <th class="col-xs-3 text-left customTableResponsive">Username</th>\
              <th class="col-xs-3 text-left customTableResponsive">List Role</th>\
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
              <td class="col-xs-3 text-left customTableResponsive">'+ jsonData[indeks].name +'</td>\
              <td class="col-xs-3 text-left customTableResponsive">'+ jsonData[indeks].username +'</td>\
              <td class="col-xs-3 text-left customTableResponsive">';
                for( indek in jsonData[indeks]['roles']){
                  data2 += jsonData[indeks]['roles'][indek].name + ', ';
                }
              data2 += '</td>\
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" href="edit/user/'+jsonData[indeks].id+'" class="btn btn-warning" title="Ubah Data Role" ><span class="far fa-edit"></span></a>\
                <a role="button" href="delete/user/'+jsonData[indeks].id+'" class="btn btn-danger" title="Hapus Data Role" ><span class="far fa-trash-alt"></span></a>\
              </td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelUser').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelUser").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelUser").style.display = "";
  });

  $(document).ready(function(){
    showTableUser();
  });
</script>
@endsection
