$(document).ready(function(){
  $('#waktu_ditindak').timepicker({
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false,
    // defaultTime: 'current',
  });

  $('#tgl_ditindak').on('change',function(){
    var timeSuggest = suggestTime($(this).val(), 'ecnocardiography');
    var waktuTampil = '';
    for(indeks in timeSuggest){
      waktuTampil += '['+ timeSuggest[indeks].waktu_ditindak +'] ';
    }
    if(waktuTampil == ''){
      $('#suggestTime').text('Belum ada waktu ter-reservasi di tanggal '+tanggal($(this).val()));
    }else{
      $('#suggestTime').text('Reserved: '+waktuTampil);
    }
  });

  $('#modalTambahEditReservasiEcnocardiography').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahReservasiEcnocardiography')
    $('#editTambahReservasiEcnocardiography').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#suggestTime').text('');
    $('#msgHasilPencarianRM').text('');
    //
    // setTimeout(function (){
    //   modal.find('.modal-body #tgl_ditindak').focus()
    // },500);
  });

  $('#modalTambahEditReservasiEcnocardiography').on('show.bs.modal', function(event){
    $('#editTambahReservasiEcnocardiography').removeClass('was-validated');
  });

  $('#editTambahReservasiEcnocardiography').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahReservasiEcnocardiography #slugEcnocardiography').val()
    if(cekValidasi(this)){
      if(slug == '' ){
        sendToServer(this, 'POST', 'ecnocardiography/tambahEcnocardiography', true, 'statusMsg', showTabeldataReservasiEcnocardiography);
        $('#modalTambahEditReservasiEcnocardiography').modal('hide');
      }else{
        sendToServer(this, 'POST', 'ecnocardiography/'+slug+'/editEcnocardiography', true, 'statusMsg', showTabeldataReservasiEcnocardiography);
        $('#modalTambahEditReservasiEcnocardiography').modal('hide');
      }
    }
  });

  $('#hapusDataReservasiEcnocardiography').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'ecnocardiography/'+slug+'/deleteEcnocardiography', false, 'statusMsg', showTabeldataReservasiEcnocardiography);
    $('#modalDeleteDataReservasiEcnocardiography').modal('hide');
  })

  $('#modalShowImage').on('show.bs.modal',function(event){
    var button = $(event.relatedTarget)
    var recipient = button.data('tambahan')
    var modal = $(this)
    modal.find('.modal-body #surat_rujukan_gambar').attr('src', recipient);
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
          'slugEcnocardiography': htmlDecode(table.rows[this.i].cells[0].innerHTML),
          'slugPasien': htmlDecode(table.rows[this.i].cells[1].innerHTML),
          'tgl_ditindak': htmlDecode(table.rows[this.i].cells[2].innerHTML),
          'waktu_ditindak': htmlDecode(table.rows[this.i].cells[3].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[6].innerHTML),
          'tlp': htmlDecode(table.rows[this.i].cells[7].innerHTML),
          'petugas_fo': htmlDecode(table.rows[this.i].cells[9].innerHTML),
          'petugas_poli': htmlDecode(table.rows[this.i].cells[10].innerHTML),
          'keterangan': htmlDecode(table.rows[this.i].cells[11].innerHTML),
          'confirm': htmlDecode(table.rows[this.i].cells[14].innerHTML),
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
          'slugEcnocardiography': table.rows[this.i].cells[0].innerHTML,
          'slugPasien': table.rows[this.i].cells[1].innerHTML,
          'tgl_ditindak': table.rows[this.i].cells[2].innerHTML,
          'waktu_ditindak': table.rows[this.i].cells[3].innerHTML,
          'no_rm': table.rows[this.i].cells[4].innerHTML,
          'nama': table.rows[this.i].cells[5].innerHTML,
          'alamat': table.rows[this.i].cells[6].innerHTML,
          'tlp': table.rows[this.i].cells[7].innerHTML,
          'petugas_fo': table.rows[this.i].cells[9].innerHTML,
          'petugas_poli': table.rows[this.i].cells[10].innerHTML,
          'keterangan': table.rows[this.i].cells[11].innerHTML,
          'confirm': table.rows[this.i].cells[14].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Booking</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Petugas Fo</th>\
              <th class="col-xs-1 text-center customTableResponsive">Petugas Poli</th>\
              <th class="col-xs-2 text-center customTableResponsive">Keterangan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Konfirmasi</th>\
            </tr>\
          </thead>\
          <tbody>\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_ditindak +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.waktu_ditindak +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.no_rm +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.nama +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.alamat +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.tlp +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.petugas_fo +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.petugas_poli +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.keterangan +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ (dataForm.confirm=="1"?"Sudah Konfirmasi":"Belum Konfirmasi") +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataReservasiEcnocardiography #tabelDeleteEcnocardiography').html(data1);
        $('#modalDeleteDataReservasiEcnocardiography #hapusDataReservasiEcnocardiography').attr('href',dataForm.slugEcnocardiography)
      };
    }
  }
}
