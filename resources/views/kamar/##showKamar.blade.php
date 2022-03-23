@extends('master.master')
@section('title','Data Kamar')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Kamar</h5>
    </div>

    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelKamar"></div>
    </div>

    <div class="card-footer">
      <a role="button" class="btn btn-primary" title="Tambah Data Kamar" data-toggle="modal" data-target="#modalTambahEditKamar"><span class="fa fa-plus"></span> Data Kamar</a>
    </div>
  </div>

  @include('kamar.modalDeleteDataKamar')
  @include('kamar.modalTambahEditKamar')
@endsection

@section('additionalJS')
<script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
<script type="text/javascript">
  function sweetTable(){
    $('#tabelKamar').DataTable({
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

  function showTableKamar(){
    $.ajax({
      type:'GET',
      url:'getKamar',
      success:function(data){
        var jsonData = data.msg;
        var data1 = '\
        <table class="table table-striped table-sm" id="tabelKamar" cellspacing="0" width="100%"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-left customTableResponsive">No</th>\
              <th class="col-xs-4 text-left customTableResponsive">Nama Kamar</th>\
              <th class="col-xs-5 text-left customTableResponsive">Deskripsi Kamar</th>\
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
              <td class="col-xs-4 text-left customTableResponsive">'+ jsonData[indeks].nama_kamar +'</td>\
              <td class="col-xs-5 text-left customTableResponsive">';
                if(jsonData[indeks].deskripsi_kamar == null){
                data2 += 'Tidak Ada Data Deskripsi';
                }else{
                data2 += jsonData[indeks].deskripsi_kamar;
                }
            data2 += '\
              </td> \
              <td class="col-xs-2 text-right customTableResponsive">\
                <a role="button" class="btn btn-warning" title="Ubah Data Kamar" data-toggle="modal" data-target="#modalTambahEditKamar" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_kamar+'&hobayu&'+jsonData[indeks].deskripsi_kamar+'"><span class="far fa-edit"></span></a>\
                <a role="button" class="btn btn-danger" title="Hapus Data Kamar" data-toggle="modal" data-target="#modalDeleteDataKamar" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].nama_kamar+'&hobayu&'+jsonData[indeks].deskripsi_kamar+'"><span class="far fa-trash-alt"></span></a>\
              </td>\
            </tr>'
          }
        data2 += '</tbody> \
        </table>';

        $('#dataTabelKamar').html(data1+data2);
        sweetTable();
      }
    });
  }

  $(document).ajaxStart(function(){
    document.getElementById("loader").style.display = "";
    document.getElementById("dataTabelKamar").style.display = "none";
  });
  $(document).ajaxStop(function(){
    document.getElementById("loader").style.display = "none";
    document.getElementById("dataTabelKamar").style.display = "";
  });

  $(document).ready(function(){
    showTableKamar();
    $('#modalDeleteDataKamar').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      recipient = recipient.split('&hobayu&')
      var modal = $(this)
      modal.find('.modal-body #nama_kamar_delete_modal').html('<b>Nama Kamar :</b><br/> '+recipient[1]+'<br/><br/>')
      modal.find('.modal-body #deskripsi_kamar_delete_modal').html('<b>Deskripsi Kamar :</b><br/> '+recipient[2])
      modal.find('.modal-footer a').attr('href',recipient[0])
    });

    $('#modalTambahEditKamar').on('show.bs.modal', function(event){
      $('#editTambahKamar').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
      var button = $(event.relatedTarget)
      var recipient = button.data('tambahan')
      var modal = $(this)
      if(recipient != null){
        recipient = recipient.split('&hobayu&')
        modal.find('.modal-body #slug').val(recipient[0])
        modal.find('.modal-body #nama_kamar').val(recipient[1])
        if(recipient[2] != "null"){
          modal.find('.modal-body #deskripsi_kamar').val(recipient[2])
        }else{
          modal.find('.modal-body #deskripsi_kamar').val('')
        }
      }else{
        modal.find('.modal-body #slug').val('')
        modal.find('.modal-body #nama_kamar').val('')
        modal.find('.modal-body #deskripsi_kamar').val('')
      }
      setTimeout(function (){
        modal.find('.modal-body #nama_kamar').focus()
      },500);
    });

    $('#editTambahKamar').on('submit',function(e){
      e.preventDefault();
      var nama_unit = $('#nama_kamar').val();
      var deskripsi_unit = $('#deskripsi_kamar').val();
      var slug = $('#slug').val();
      var url_dest = '';
      if(nama_unit.trim() != ""){
        if(slug == ''){
          //tambah Kamar
          url_dest = 'kamar/tambahKamar';
          $('#modalTambahEditKamar').modal('hide');
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
              $('#nama_kamar').val('');
              $('#deskripsi_kamar').val('');
              $('#slug').val('');
              showTableKamar();
            }
          });
        }else{
          //edit Kamar
          url_dest = 'kamar/'+slug+'/editKamar';
          $('#modalTambahEditKamar').modal('hide');
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
              $('#nama_kamar').val('');
              $('#deskripsi_kamar').val('');
              $('#slug').val('');
              showTableKamar();
            }
          });
        }
      }
    });

    $('#hapusDataKamar').on('click',function(e){
      e.preventDefault();
      var slug = $(this).attr('href');
      $('#modalDeleteDataKamar').modal('hide');
      $.ajax({
        type:'GET',
        url: 'kamar/'+slug+'/deleteKamar',
        success:function(data){
          var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                          data.msg +
                          '<button data-dismiss="alert" class="close" aria-label="Close">'+
                          '<span aria-hidden="true">&times;</span>'+
                          '</button>'+
                        '</div>';
          $("#statusMsg").html(alert);
          showTableKamar();
        }
      });
    })
  });
</script>
@endsection
