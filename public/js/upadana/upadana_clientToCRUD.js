$(document).ready(function(){
  $('#tgl_reservasi').on('change',function(){
    let nomorAntreanAwal = getNomorAntrean((new Date(this.value)).getDay());
    $('#editTambahResvdrup #no_antrian').val(nomorAntreanAwal);

    var timeSuggest = suggestTime($(this).val(), 'upadana');
    var waktuTampil = '';
    for(indeks in timeSuggest){
      waktuTampil += '['+timeSuggest[indeks].pukul_reservasi +'] ';
    }
    if(waktuTampil == ''){
      $('#suggestTime').text('Belum ada waktu ter-reservasi di tanggal '+tanggal($(this).val()));
    }else{
      $('#suggestTime').text('Reserved: '+waktuTampil);
    }
  })

  function getNomorAntrean(tglPilihan){
    let nomorAntrean = '';
    switch(tglPilihan){
      case 1: nomorAntrean = "UPF_"; break; // hari senin
      case 5: nomorAntrean = "UPS_"; break; // hari selasa
    }
    return nomorAntrean;
  }

  $('#pukul_reservasi').timepicker({
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false,
    // defaultTime: 'current',
  });

  $('#modalTambahEditResvdrup').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahResvdrup')
    $('#editTambahResvdrup').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#suggestTime').text('');
    $('#msgHasilPencarianRM').text('');
  });

  $('#modalTambahEditResvdrup').on('show.bs.modal', function(event){
    $('#editTambahResvdrup').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
  });

  $('#editTambahResvdrup').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahResvdrup #slugUP').val();
    if($('#editTambahResvdrup #no_antrian').val() == "UPF_" || $('#editTambahResvdrup #no_antrian').val() == "UPS_"){
      return false;
    }

    if(cekValidasi(this)){
      if(slug == '' ){
        sendToServer(this, 'POST', 'upadana/tambahReservasi', false, 'statusMsg', showTabelReservasiUP);
        $('#modalTambahEditResvdrup').modal('hide');
      }else{
        sendToServer(this, 'POST', 'upadana/'+slug+'/editReservasi', false, 'statusMsg', showTabelReservasiUP);
        $('#modalTambahEditResvdrup').modal('hide');
      }
    }
  });

  $('#hapusDataResvdrup').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'upadana/'+slug+'/deleteUpadana', false, 'statusMsg', showTabelReservasiUP);
    $('#modalDeleteDataResvdrup').modal('hide');
  })

  $('#btnSearchNomorAntrean').on('click',function(e){
    e.preventDefault();
    if($('#editTambahResvdrup #no_antrian').val() == "UPF_" || $('#editTambahResvdrup #no_antrian').val() == "UPS_"){
      // sendToServer('', 'GET', 'upadana/'+$('#editTambahResvdrup #tgl_reservasi').val()+'/getAntrean', false, );
      $.ajax({
        type: "GET",
        url: 'upadana/'+$('#editTambahResvdrup #tgl_reservasi').val()+'&hobayu&'+$('#editTambahResvdrup #slugUP').val()+'/getAntrean',
        success:function(data){
          if(data.msg){
            data.msg = data.msg.split('_');
            $('#editTambahResvdrup #no_antrian').val($('#editTambahResvdrup #no_antrian').val()+(parseInt(data.msg[1])+1));
          }else{
            $('#editTambahResvdrup #no_antrian').val($('#editTambahResvdrup #no_antrian').val()+1);
          }

        }
      });
    }
  });
});


function sendDataToForm(idTabel, idForm){
  if(document.getElementById(idTabel) != null){
    var table = document.getElementById(idTabel);
    var rows = table.getElementsByTagName('tr');
    var dataForm = "";
    for ( var i = 1; i < rows.length; i++) {
      rows[i].i = i;
      rows[i].onclick = function() {
        dataForm = {
          'slugUP': htmlDecode(table.rows[this.i].cells[0].innerHTML),
          'slugPasien': htmlDecode(table.rows[this.i].cells[1].innerHTML),
          'tgl_reservasi': htmlDecode(table.rows[this.i].cells[2].innerHTML),
          'pukul_reservasi': htmlDecode(table.rows[this.i].cells[3].innerHTML),
          'no_antrian': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[6].innerHTML),
          'tlp': htmlDecode(table.rows[this.i].cells[7].innerHTML),
          'tgl_lahir': htmlDecode(table.rows[this.i].cells[8].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[9].innerHTML),
          'confirm': htmlDecode(table.rows[this.i].cells[12].innerHTML),
        }
        setDataForm(document.forms[idForm], dataForm);
      };
    }
  }
}

function sendDataToDelete(idTabel, idDelete){
  if(document.getElementById(idTabel) != null){
    var table = document.getElementById(idTabel);
    var rows = table.getElementsByTagName('tr');
    var dataForm = "";
    for ( var i = 1; i < rows.length; i++) {
      rows[i].i = i;
      rows[i].onclick = function() {
        dataForm = {
          'slugUP': table.rows[this.i].cells[0].innerHTML,
          'slugPasien': table.rows[this.i].cells[1].innerHTML,
          'tgl_reservasi': table.rows[this.i].cells[2].innerHTML,
          'pukul_reservasi': table.rows[this.i].cells[3].innerHTML,
          'no_antrian': table.rows[this.i].cells[4].innerHTML,
          'no_rm': table.rows[this.i].cells[5].innerHTML,
          'nama': table.rows[this.i].cells[6].innerHTML,
          'tlp': table.rows[this.i].cells[7].innerHTML,
          'tgl_lahir': table.rows[this.i].cells[8].innerHTML,
          'alamat': table.rows[this.i].cells[9].innerHTML,
          'confirm': table.rows[this.i].cells[12].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
            <th class="col-xs-1 text-center customTableResponsive">Tgl Booking</th>\
            <th class="col-xs-1 text-center customTableResponsive">Waktu Booking</th>\
            <th class="col-xs-1 text-center customTableResponsive">Nomor Antrean</th>\
            <th class="col-xs-1 text-center customTableResponsive">Nomor RM</th>\
            <th class="col-xs-2 text-center customTableResponsive">Nama Pasien</th>\
            <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
            <th class="col-xs-1 text-center customTableResponsive">Tgl Lahir Pasien</th>\
            <th class="col-xs-2 text-center customTableResponsive">Alamat Pasien</th>\
            <th class="col-xs-2 text-center customTableResponsive">Konfirmasi</th>\
            </tr>\
          </thead>\
          <tbody>\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_reservasi +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.pukul_reservasi +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.no_antrian +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.no_rm +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.nama +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.tlp +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_lahir +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.alamat +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ (dataForm.confirm=="1"?"Sudah Konfirmasi":"Belum Konfirmasi") +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataResvdrup #tabelDeleteUpadana').html(data1);
        $('#modalDeleteDataResvdrup #hapusDataResvdrup').attr('href',dataForm.slugUP)
      };
    }
  }
}
