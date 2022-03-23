$(document).ready(function(){

  $('#tgl_ditindak').on('change',function(){
    var timeSuggest = suggestTime($(this).val(), 'radiologi');
    var waktuTampil = '';
    for(indeks in timeSuggest){
      waktuTampil += '['+timeSuggest[indeks].waktu_ditindak +'] ';
    }
    if(waktuTampil == ''){
      $('#suggestTime').text('Belum ada waktu ter-reservasi di tanggal '+tanggal($(this).val()));
    }else{
      $('#suggestTime').text('Reserved: '+waktuTampil);
    }
  });

  $('#waktu_ditindak').timepicker({
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false,
    // defaultTime: 'current',
  });

  $('#modalTambahEditReservasiRadiologi').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahReservasiRadiologi')
    $('#editTambahReservasiRadiologi').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#suggestTime').text('');
    $('#msgHasilPencarianRM').text('');
    // setTimeout(function (){
    //   modal.find('.modal-body #tgl_reservasi').focus()
    // },500);
  });

  $('#modalTambahEditReservasiRadiologi').on('show.bs.modal', function(event){
    $('#editTambahReservasiRadiologi').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
  });

  $('#editTambahReservasiRadiologi').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahReservasiRadiologi #slugRadiologi').val()
    if(cekValidasi(this)){
      if(slug == '' ){
        sendToServer(this, 'POST', 'radiologi/tambahRadiologi', true, 'statusMsg', showTabeldataReservasiRadiologi);
        $('#modalTambahEditReservasiRadiologi').modal('hide');
      }else{
        sendToServer(this, 'POST', 'radiologi/'+slug+'/editRadiologi', true, 'statusMsg', showTabeldataReservasiRadiologi);
        $('#modalTambahEditReservasiRadiologi').modal('hide');
      }
    }
  });

  $('#hapusDataReservasiRadiologi').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'radiologi/'+slug+'/deleteRadiologi', false, 'statusMsg', showTabeldataReservasiRadiologi);
    $('#modalDeleteDataReservasiRadiologi').modal('hide');
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
          'slugRadiologi': htmlDecode(table.rows[this.i].cells[0].innerHTML),
          'slugPasien': htmlDecode(table.rows[this.i].cells[1].innerHTML),
          'tgl_ditindak': htmlDecode(table.rows[this.i].cells[2].innerHTML),
          'waktu_ditindak': htmlDecode(table.rows[this.i].cells[3].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[6].innerHTML),
          'tlp': htmlDecode(table.rows[this.i].cells[7].innerHTML),
          'dokter_pengirim': htmlDecode(table.rows[this.i].cells[8].innerHTML),
          'dokter_penindak': htmlDecode(table.rows[this.i].cells[10].innerHTML),
          'jenis_tindakan': htmlDecode(table.rows[this.i].cells[11].innerHTML),
          'petugas_radiologi': htmlDecode(table.rows[this.i].cells[12].innerHTML),
          'confirm': htmlDecode(table.rows[this.i].cells[15].innerHTML),
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
          'slugRadiologi': table.rows[this.i].cells[0].innerHTML,
          'slugPasien': table.rows[this.i].cells[1].innerHTML,
          'tgl_ditindak': table.rows[this.i].cells[2].innerHTML,
          'waktu_ditindak': table.rows[this.i].cells[3].innerHTML,
          'no_rm': table.rows[this.i].cells[4].innerHTML,
          'nama': table.rows[this.i].cells[5].innerHTML,
          'alamat': table.rows[this.i].cells[6].innerHTML,
          'tlp': table.rows[this.i].cells[7].innerHTML,
          'dokter_pengirim': table.rows[this.i].cells[8].innerHTML,
          'dokter_penindak': table.rows[this.i].cells[10].innerHTML,
          'jenis_tindakan': table.rows[this.i].cells[11].innerHTML,
          'petugas_radiologi': table.rows[this.i].cells[12].innerHTML,
          'confirm': table.rows[this.i].cells[15].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Ditindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">Waktu Ditindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">No RM</th>\
              <th class="col-xs-1 text-center customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Alamat Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tlp Pasien</th>\
              <th class="col-xs-1 text-center customTableResponsive">dr Pengirim</th>\
              <th class="col-xs-1 text-center customTableResponsive">dr Penindak</th>\
              <th class="col-xs-1 text-center customTableResponsive">Jenis Tindakan</th>\
              <th class="col-xs-1 text-center customTableResponsive">Ptgs Radiologi</th>\
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
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.dokter_pengirim +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.dokter_penindak +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.jenis_tindakan +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.petugas_radiologi +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ (dataForm.confirm=="1"?"Sudah Konfirmasi":"Belum Konfirmasi") +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataReservasiRadiologi #tabelDeleteRadiologi').html(data1);
        $('#modalDeleteDataReservasiRadiologi #hapusDataReservasiRadiologi').attr('href',dataForm.slugRadiologi)
      };
    }
  }
}
