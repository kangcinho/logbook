$(document).ready(function(){
  $('#tgl_reservasi').on('change',function(){
    var timeSuggest = suggestTime($(this).val(), 'babyspa');
    var waktuTampil = '';
    for(indeks in timeSuggest){
      waktuTampil += '['+timeSuggest[indeks].pukul_reservasi_awal+'-'+timeSuggest[indeks].pukul_reservasi_akhir+'] ';
    }
    if(waktuTampil == ''){
      $('#suggestTime').text('Belum ada waktu ter-reservasi di tanggal '+tanggal($(this).val()));
    }else{
      $('#suggestTime').text('Reserved: '+waktuTampil);
    }
  });

  $('#pukul_reservasi_awal').timepicker({
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false,
    // defaultTime: 'current',
  });

  $('#modalTambahEditReservasiBabySPA').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahReservasiBabySPA')
    $('#editTambahReservasiBabySPA').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#suggestTime').text('');
    $('#msgHasilPencarianRM').text('');
    // setTimeout(function (){
    //   modal.find('.modal-body #no_rm').focus()
    // },500);
  });

  $('#modalTambahEditReservasiBabySPA').on('show.bs.modal', function(event){
    $('#editTambahReservasiBabySPA').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
  });

  $('#editTambahReservasiBabySPA').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahReservasiBabySPA #slugBabySPA').val()
    if(cekValidasi(this)){
      if(slug == '' ){
        if(cekPukulReservasi($('#editTambahReservasiBabySPA #pukul_reservasi_awal').val(),$('#editTambahReservasiBabySPA #tgl_reservasi').val(), 'babyspa',0)){
          sendToServer(this, 'POST', 'babySPA/tambahBabySPA', false, 'statusMsg', showTabeldataReservasiBabySPA);
          $('#modalTambahEditReservasiBabySPA').modal('hide');
        }else{
          alertSuccess("Waktu Reservasi Sudah diBooking. Silahkan Pilih Waktu Lainnya", 'msgHasilPencarianRM');
        }
      }else{
        if(cekPukulReservasi($('#editTambahReservasiBabySPA #pukul_reservasi_awal').val(),$('#editTambahReservasiBabySPA #tgl_reservasi').val(), 'babyspa', 1, slug)){
          sendToServer(this, 'POST', 'babySPA/'+slug+'/editBabySPA', false, 'statusMsg', showTabeldataReservasiBabySPA);
          $('#modalTambahEditReservasiBabySPA').modal('hide');
        }else{
          alertSuccess("Waktu Reservasi Sudah diBooking. Silahkan Pilih Waktu Lainnya", 'msgHasilPencarianRM');
        }
      }
    }
  });

  $('#hapusDataReservasiBabySPA').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'babySPA/'+slug+'/deleteBabySPA', false, 'statusMsg', showTabeldataReservasiBabySPA);
    $('#modalDeleteDataReservasiBabySPA').modal('hide');
  })
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
          'slugBabySPA': htmlDecode(table.rows[this.i].cells[0].innerHTML),
          'slugPasien': htmlDecode(table.rows[this.i].cells[1].innerHTML),
          'tgl_reservasi': htmlDecode(table.rows[this.i].cells[2].innerHTML),
          'pukul_reservasi_awal': htmlDecode(table.rows[this.i].cells[3].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[6].innerHTML),
          'tlp': htmlDecode(table.rows[this.i].cells[7].innerHTML),
          'tgl_lahir': htmlDecode(table.rows[this.i].cells[8].innerHTML),
          'keterangan': htmlDecode(table.rows[this.i].cells[9].innerHTML),
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
          'slugBabySPA': table.rows[this.i].cells[0].innerHTML,
          'slugPasien': table.rows[this.i].cells[1].innerHTML,
          'tgl_reservasi': table.rows[this.i].cells[2].innerHTML,
          'pukul_reservasi_awal': table.rows[this.i].cells[3].innerHTML,
          'no_rm': table.rows[this.i].cells[4].innerHTML,
          'nama': table.rows[this.i].cells[5].innerHTML,
          'alamat': table.rows[this.i].cells[6].innerHTML,
          'tlp': table.rows[this.i].cells[7].innerHTML,
          'tgl_lahir': table.rows[this.i].cells[8].innerHTML,
          'keterangan': table.rows[this.i].cells[9].innerHTML,
          'confirm': table.rows[this.i].cells[12].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-2 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-2 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Lahir Pasien</th>\
              <th class="col-xs-2 text-center customTableResponsive">Keterangan/Request</th>\
              <th class="col-xs-2 text-center customTableResponsive">Konfirmasi</th>\
            </tr>\
          </thead>\
          <tbody>\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_reservasi +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.pukul_reservasi_awal +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.no_rm +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.nama +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.alamat +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.tlp +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_lahir +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.keterangan +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ (dataForm.confirm=="1"?"Sudah Konfirmasi":"Belum Konfirmasi") +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataReservasiBabySPA #tabelDeleteBabySPA').html(data1);
        $('#modalDeleteDataReservasiBabySPA #hapusDataReservasiBabySPA').attr('href',dataForm.slugBabySPA)
      };
    }
  }
}
