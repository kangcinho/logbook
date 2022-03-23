@extends('master.master')
@section('title','Data Role')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Role</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelRole"></div>
    </div>

    <div class="card-footer">
      <a role="button" class="btn btn-primary" title="Tambah Data Role" href="tambah/role"><span class="fa fa-plus"></span> Data Role</a>
    </div>
  </div>
@endsection

@section('additionalJS')
<script type="text/javascript">
  function sweetTable(){
    $('#tabelRole').DataTable({
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

  function showTableRole(){
    $.ajax({
      type:'GET',
      url:'getRole',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-sm" id="tabelRole" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-left customTableResponsive">No</th>\
              <th class="col-xs-3 text-left customTableResponsive">Nama Role</th>\
              <th class="col-xs-3 text-left customTableResponsive">Deskripsi Role</th>\
              <th class="col-xs-3 text-left customTableResponsive">List Permission</th>\
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
              <td class="col-xs-4 text-left customTableResponsive">'+ jsonData[indeks].name +'</td>\
              <td class="col-xs-5 text-left customTableResponsive">'+ jsonData[indeks].description +'</td>\
              <td class="col-xs-5 text-left customTableResponsive">';
                for( indek in jsonData[indeks]['permission']){
                  data2 += jsonData[indeks]['permission'][indek].name + ', ';
                }
              data2 += '</td>\
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" href="edit/role/'+jsonData[indeks].id+'" class="btn btn-warning" title="Ubah Data Role" ><span class="far fa-edit"></span></a>\
                <a role="button" href="delete/role/'+jsonData[indeks].id+'" class="btn btn-danger" title="Hapus Data Role" ><span class="far fa-trash-alt"></span></a>\
              </td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelRole').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelRole").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelRole").style.display = "";
  });

  $(document).ready(function(){
    showTableRole();
  });
</script>
@endsection
