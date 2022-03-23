@extends('master.master')
@section('title','Data Nomor Kamar')
@section('content')
  <div id="statusMsg"></div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Nomor Kamar</h5>
    </div>
    <div class="card-body">
      <div id="loader" ></div>
      <div class="table-responsive" id="dataTabelNomorKamar"></div>
    </div>
    <div class="card-footer">
      <button class="btn btn-primary" title="Tambah Data Nomor Kamar" data-toggle="modal" data-target="#modalTambahEditDataNomorKamar"><span class="fa fa-plus"></span> Data Nomor Kamar</button>
    </div>
  </div>

  @include('noKamar.modalDeleteDataNomorKamar')
  @include('noKamar.modalTambahEditDataNomorKamar')
@endsection

@section('additionalJS')
  <script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
  <script type="text/javascript">
    function sweetTable(){
      $('#tabelNomorKamar').DataTable({
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

    function showTableNomorKamar(){
      $.ajax({
        type:'GET',
        url:'getNoKamar',
        success:function(data){
          var jsonData = data.msg;
          var data1 = '\
          <table class="table table-striped table-sm" id="tabelNomorKamar" cellspacing="0" width="100%"> \
            <thead class="bg-light">\
              <tr>\
                <th class="col-xs-1 text-left customTableResponsive">No</th>\
                <th class="col-xs-1 text-left customTableResponsive sr-only">No</th>\
                <th class="col-xs-4 text-left customTableResponsive">Nama Kamar</th>\
                <th class="col-xs-1 text-left customTableResponsive">Nomor Kamar</th>\
                <th class="col-xs-4 text-left customTableResponsive">Deskripsi Nomor Kamar</th>\
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
                <td class="col-xs-1 text-left customTableResponsive sr-only">'+ jsonData[indeks]['kamar'].slug +'</td>\
                <td class="col-xs-4 text-left customTableResponsive">'+ jsonData[indeks]['kamar'].nama_kamar +'</td>\
                <td class="col-xs-1 text-left customTableResponsive">'+ jsonData[indeks].no_kamar +'</td>\
                <td class="col-xs-4 text-left customTableResponsive">';
                  if(jsonData[indeks].deskripsi_no_kamar == null){
                  data2 += 'Tidak Ada Data Deskripsi';
                  }else{
                  data2 += jsonData[indeks].deskripsi_no_kamar;
                  }
              data2 += '\
                </td> \
                <td class="col-xs-2 text-right customTableResponsive">\
                  <a role="button" class="btn btn-warning" title="Ubah Data Nomor Kamar" data-toggle="modal" data-target="#modalTambahEditDataNomorKamar" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].no_kamar+'&hobayu&'+jsonData[indeks].deskripsi_no_kamar+'&hobayu&'+jsonData[indeks]['kamar'].slug+'"><span class="far fa-edit"></span></a>\
                  <a role="button" class="btn btn-danger" title="Hapus Data Nomor Kamar" data-toggle="modal" data-target="#modalDeleteDataNomorKamar" data-tambahan="'+jsonData[indeks].slug+'&hobayu&'+jsonData[indeks].no_kamar+'&hobayu&'+jsonData[indeks].deskripsi_no_kamar+'&hobayu&'+jsonData[indeks]['kamar'].nama_kamar+'"><span class="far fa-trash-alt"></span></a>\
                </td>\
              </tr>'
            }
          data2 += '</tbody> \
          </table>';

          $('#dataTabelNomorKamar').html(data1+data2);
          sweetTable();
        }
      });
    }

    $(document).ajaxStart(function(){
      document.getElementById("loader").style.display = "";
      document.getElementById("dataTabelNomorKamar").style.display = "none";
    });
    $(document).ajaxStop(function(){
      document.getElementById("loader").style.display = "none";
      document.getElementById("dataTabelNomorKamar").style.display = "";
    });

    function getNamaKamar(){
      var dataKamar = '';
      $.ajax({
        type:'GET',
        url: 'getKamar',
        success:function(data){
          var jsonData = data.msg;
          dataKamar += '\
          <label for="namaKamarInput">Nama Kamar</label> \
          <select class="form-control" name="namaKamarInput" id="namaKamarInput" required>\
             <option value="" selected></option>';
            for(indeks in jsonData){
              dataKamar += '<option value="'+ jsonData[indeks].slug +'">'+ jsonData[indeks].nama_kamar +'</option>';
            }
          dataKamar += '</select>\
          <div class="invalid-feedback">\
            Nama Kamar Tidak Boleh Kosong\
          </div>';
          $('#editTambahNomorKamar #namaKamar').html(dataKamar);
        }
      });
    }

    $(document).ready(function(){
      showTableNomorKamar();
      getNamaKamar();

      $('#modalDeleteDataNomorKamar').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var recipient = button.data('tambahan')
        recipient = recipient.split('&hobayu&')
        var modal = $(this)
        modal.find('.modal-body #nama_kamar_delete_modal').html('<b>Nama Kamar :</b><br/> '+recipient[3])
        modal.find('.modal-body #nomor_kamar_delete_modal').html('<b>Nomor Kamar :</b><br/> '+recipient[1]+'<br/>')
        modal.find('.modal-body #deskripsi_nomor_kamar_delete_modal').html('<b>Deskripsi Nomor Kamar :</b><br/> '+recipient[2]+'<br/>')
        modal.find('.modal-footer a').attr('href',recipient[0])
      });

      $('#hapusNomorKamar').on('click',function(e){
        e.preventDefault();
        var slug = $(this).attr('href');
        $('#modalDeleteDataNomorKamar').modal('hide');
        $.ajax({
          type:'GET',
          url: 'nokamar/'+slug+'/deleteNoKamar',
          success:function(data){
            var alert = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                            data.msg +
                            '<button data-dismiss="alert" class="close" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                          '</div>';
            $("#statusMsg").html(alert);
            showTableNomorKamar();
          }
        });
      });

      $('#modalTambahEditDataNomorKamar').on('show.bs.modal', function(event){
        $('#editTambahNomorKamar').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
        var button = $(event.relatedTarget)
        var recipient = button.data('tambahan')
        var modal = $(this)
        if(recipient != null){
          recipient = recipient.split('&hobayu&')
          modal.find('.modal-body #slug').val(recipient[0])
          modal.find('.modal-body #nomor_kamar').val(recipient[1])
          if(recipient[2] != "null"){
            modal.find('.modal-body #deskripsi_nomor_kamar').val(recipient[2])
          }else{
            modal.find('.modal-body #deskripsi_nomor_kamar').val('')
          }
          modal.find('.modal-body #namaKamarInput').val(recipient[3]);
        }else{
          modal.find('.modal-body #slug').val('')
          modal.find('.modal-body #namaKamarInput').val('')
          modal.find('.modal-body #nomor_kamar').val('')
          modal.find('.modal-body #deskripsi_nomor_kamar').val('')
        }
        setTimeout(function (){
          modal.find('.modal-body #namaKamarInput').focus()
        },500);
      });

      $('#editTambahNomorKamar').on('submit',function(e){
        e.preventDefault();
        var namaKamar = $('#namaKamarInput').val();
        var nomorKamar = $('#nomor_kamar').val();
        var deskripsi_nomor_kamar = $('#deskripsi_nomor_kamar').val();
        var slug = $('#slug').val();
        var url_dest = '';
        if(namaKamar.trim() != "" && nomorKamar.trim() != ""){
          if(slug == ''){
            //tambah nomor Kamar
            url_dest = 'nokamar/tambahNoKamar';
            $('#modalTambahEditDataNomorKamar').modal('hide');
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
                $('#nomor_kamar').val('');
                $('#deskripsi_nomor_kamar').val('');
                $('#namaKamarInput').val('');
                $('#slug').val('');
                showTableNomorKamar();
              }
            });
          }else{
            // edit nomor kamar
            url_dest = 'nokamar/'+slug+'/editNoKamar';
            $('#modalTambahEditDataNomorKamar').modal('hide');
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
                $('#nomor_kamar').val('');
                $('#deskripsi_nomor_kamar').val('');
                $('#namaKamarInput').val('');
                $('#slug').val('');
                showTableNomorKamar();
              }
            });
          }
        }
      });
    });
  </script>
@endsection
