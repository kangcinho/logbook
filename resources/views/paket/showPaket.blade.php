@extends('master.master')
@section('title','Data Paket')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Paket</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelPaket"></div>
    </div>

    <div class="card-footer">
      <button class="btn btn-primary" title="Tambah Data Paket" data-toggle="modal" data-target="#modalTambahEditPaket"><span class="fa fa-plus"></span> Data Paket</button>
    </div>
  </div>

  @include('paket.modalDeleteDataPaket')
  @include('paket.modalTambahEditPaket')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
<script type="text/javascript">
  function sweetTable(){
    $('#tabelPaket').DataTable({
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

  function showTablePaket(){
    $.ajax({
      type:'GET',
      url:'getPaket',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-sm" id="tabelPaket" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-left customTableResponsive">No</th>\
              <th class="col-xs-4 text-left customTableResponsive">Nama Paket</th>\
              <th class="col-xs-5 text-left customTableResponsive">Deskripsi Paket</th>\
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
              <td class="col-xs-4 text-left customTableResponsive">'+ jsonData[indeks].nama_paket +'</td>\
              <td class="col-xs-5 text-left customTableResponsive">';
                if(jsonData[indeks].deskripsi_paket == null){
                data2 += 'Tidak Ada Data Deskripsi';
                }else{
                data2 += jsonData[indeks].deskripsi_paket;
                }
            data2 += '\
              </td> \
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" class="btn btn-warning" title="Ubah Data Paket" data-toggle="modal" data-target="#modalTambahEditPaket" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_paket+'&hobayu&'+jsonData[indeks].deskripsi_paket+'"><span class="far fa-edit"></span></a>\
                <a role="button" class="btn btn-danger" title="Hapus Data Paket" data-toggle="modal" data-target="#modalDeleteDataPaket" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_paket+'&hobayu&'+jsonData[indeks].deskripsi_paket+'"><span class="far fa-trash-alt"></span></a>\
              </td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelPaket').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelPaket").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelPaket").style.display = "";
  });

  $(document).ready(function(){
    showTablePaket();
    $('#modalDeleteDataPaket').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      recipient = recipient.split('&hobayu&')
      var modal = $(this)
      modal.find('.modal-body #nama_paket_delete_modal').html('<b>Nama Paket :</b><br/> '+recipient[1]+'<br/><br/>')
      modal.find('.modal-body #deskripsi_paket_delete_modal').html('<b>Deskripsi Paket :</b><br/> '+recipient[2])
      modal.find('.modal-footer a').attr('href',recipient[0])
    });

    $('#modalTambahEditPaket').on('show.bs.modal', function(event){
      $('#editTambahPaket').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      var modal = $(this)
      if(recipient != null){
        recipient = recipient.split('&hobayu&')
        modal.find('.modal-body #slug').val(recipient[0])
        modal.find('.modal-body #nama_paket').val(recipient[1])
        if(recipient[2] != "null"){
          modal.find('.modal-body #deskripsi_paket').val(recipient[2])
        }else{
          modal.find('.modal-body #deskripsi_paket').val('')
        }
      }else{
        modal.find('.modal-body #slug').val('')
        modal.find('.modal-body #nama_paket').val('')
        modal.find('.modal-body #deskripsi_paket').val('')
      }
      setTimeout(function (){
        modal.find('.modal-body #nama_paket').focus()
      },500);
    });

    $('#editTambahPaket').on('submit',function(e){
      e.preventDefault();
      var nama_unit = $('#nama_paket').val();
      var deskripsi_unit = $('#deskripsi_paket').val();
      var slug = $('#slug').val();
      var url_dest = '';
      if(nama_unit.trim() != ""){
        if(slug == ''){
          //tambah Paket
          url_dest = 'paket/tambahPaket';
          $('#modalTambahEditPaket').modal('hide');
          $.ajax({
            type:'POST',
            url:url_dest,
            data:$(this).serializeArray(),
            success:function(data){
              var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                              data.msg +
                              '<button data-dismiss="alert" class="close" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                              '</button>'+
                            '</div>';
              $("#statusMsg").html(alert);
              $('#nama_paket').val('');
              $('#deskripsi_paket').val('');
              $('#slug').val('');
              showTablePaket();
            }
          });
        }else{
          //edit Paket
          url_dest = 'paket/'+slug+'/editPaket';
          $('#modalTambahEditPaket').modal('hide');
          $.ajax({
            type:'POST',
            url:url_dest,
            data:$(this).serializeArray(),
            success:function(data){
              var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                              data.msg +
                              '<button data-dismiss="alert" class="close" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                              '</button>'+
                            '</div>';
              $("#statusMsg").html(alert);
              $('#nama_paket').val('');
              $('#deskripsi_paket').val('');
              $('#slug').val('');
              showTablePaket();
            }
          });
        }
      }
    });

    $('#hapusDataPaket').on('click',function(e){
      e.preventDefault();
      var slug = $(this).attr('href');
      $('#modalDeleteDataPaket').modal('hide');
      $.ajax({
        type:'GET',
        url: 'paket/'+slug+'/deletePaket',
        success:function(data){
          var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                          data.msg +
                          '<button data-dismiss="alert" class="close" aria-label="Close">'+
                          '<span aria-hidden="true">&times;</span>'+
                          '</button>'+
                        '</div>';
          $("#statusMsg").html(alert);
          showTablePaket();
        }
      });
    })
  });
</script>
@endsection
