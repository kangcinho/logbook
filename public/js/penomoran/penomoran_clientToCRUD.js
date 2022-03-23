$(document).ready(function(){
  $('#modalTambahEditPenomoran').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahPenomoranBPJS')
    $('#editTambahPenomoranBPJS').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#suggestTime').text('');
    $('#msgHasilPencarianRM').text('');

    // setTimeout(function (){
    //   modal.find('.modal-body #no_rm').focus()
    // },500);
  });

  $('#modalTambahEditPenomoran').on('show.bs.modal', function(event){
    $('#editTambahPenomoranBPJS').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
  });

  $('#editTambahPenomoranBPJS').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahPenomoranBPJS #id').val()
    if(cekValidasi(this)){
      if(slug == '' ){
        sendToServer(this, 'POST', 'penomoran/tambahPenomoran', true, 'statusMsg', showTablePenomoran);
        $('#modalTambahEditPenomoran').modal('hide');
      }else{
        sendToServer(this, 'POST', 'penomoran/'+slug+'/editPenomoran', true, 'statusMsg', showTablePenomoran);
        $('#modalTambahEditPenomoran').modal('hide');
      }
    }
  });

  $('#hapusDataPenomoranBPJS').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'penomoran/'+slug+'/deletePenomoran', false, 'statusMsg', showTablePenomoran);
    $('#modalDeleteDataPenomoranBPJS').modal('hide');
  })
});


function sendDataToForm(idTabel, idForm){
  if(document.getElementById(idTabel) != null){
    // alert('test')
    var table = document.getElementById(idTabel);
    var rows = table.getElementsByTagName('tr');
    var dataForm = "";
    for ( var i = 1; i < rows.length; i++) {
      rows[i].i = i;
      rows[i].onclick = function() {
        dataForm = {
          'id': htmlDecode(table.rows[this.i].cells[0].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[6].innerHTML),
          'tgl_lahir': htmlDecode(table.rows[this.i].cells[7].innerHTML),
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
          'id': table.rows[this.i].cells[0].innerHTML,
          'nomor_rujukan': table.rows[this.i].cells[1].innerHTML,
          'nomor_spri': table.rows[this.i].cells[2].innerHTML,
          'nomor_surat_kontrol': table.rows[this.i].cells[3].innerHTML,
          'no_rm': table.rows[this.i].cells[4].innerHTML,
          'nama': table.rows[this.i].cells[5].innerHTML,
          'alamat': table.rows[this.i].cells[6].innerHTML,
          'tgl_lahir': table.rows[this.i].cells[7].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-2 text-left customTableResponsive">Nomor Rujukan</th>\
              <th class="col-xs-1 text-left customTableResponsive">Nomor SPRI</th>\
              <th class="col-xs-2 text-left customTableResponsive">Nomor Surat Kontrol</th>\
              <th class="col-xs-1 text-left customTableResponsive">NRM</th>\
              <th class="col-xs-2 text-left customTableResponsive">Nama</th>\
              <th class="col-xs-2 text-left customTableResponsive">Alamat</th>\
              <th class="col-xs-1 text-center customTableResponsive">Tgl Lahir</th>\
            </tr>\
          </thead>\
          <tbody>\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.nomor_rujukan +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.nomor_spri +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.nomor_surat_kontrol +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.no_rm +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.nama +'</td>\
              <td class="col-xs-1 text-left customTableResponsive">'+ dataForm.alamat +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tgl_lahir +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataPenomoranBPJS #tabelDeletePenomoranBPJS').html(data1);
        $('#modalDeleteDataPenomoranBPJS #hapusDataPenomoranBPJS').attr('href',dataForm.id)
      };
    }
  }
}
