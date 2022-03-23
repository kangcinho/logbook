$(document).ready(function(){
  $('#modalTambahEditPasien').on('hide.bs.modal', function(event){
    clearDataFormId('#editTambahPasien')
    $('#editTambahPasien').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
    $('#msgHasilPencarianRM').text('');
  });

  $('#modalTambahEditPasien').on('show.bs.modal', function(event){
    $('#editTambahPasien').removeClass('was-validated'); //agar tidak ada pesan error ketika isi form di kosongkan.
  });

  $('#editTambahPasien').on('submit',function(e){
    e.preventDefault();
    var slug = $('#editTambahPasien #slug').val()
    if(cekValidasi(this)){
      if(slug == '' ){
        sendToServer(this, 'POST', 'pasien/tambahPasien', false, 'statusMsg', showTablePasien);
        $('#modalTambahEditPasien').modal('hide');
      }else{
        sendToServer(this, 'POST', 'pasien/'+slug+'/editPasien', false, 'statusMsg', showTablePasien);
        $('#modalTambahEditPasien').modal('hide');
      }
    }
  });

  $('#hapusDataPasien').on('click',function(e){
    e.preventDefault();
    var slug = $(this).attr('href');
    sendToServer('', 'GET', 'pasien/'+slug+'/deletePasien', false, 'statusMsg', showTablePasien);
    $('#modalDeleteDataPasien').modal('hide');
  })
})

function sendDataToForm(idTabel, idForm){
  if(document.getElementById(idTabel) != null){
    var table = document.getElementById(idTabel);
    var rows = table.getElementsByTagName('tr');
    var dataForm = "";
    for ( var i = 1; i < rows.length; i++) {
      rows[i].i = i;
      rows[i].onclick = function() {
        dataForm = {
          'slug': htmlDecode(table.rows[this.i].cells[1].innerHTML),
          'no_rm': htmlDecode(table.rows[this.i].cells[3].innerHTML),
          'nama': htmlDecode(table.rows[this.i].cells[2].innerHTML),
          'tlp': htmlDecode(table.rows[this.i].cells[4].innerHTML),
          'tgl_lahir': htmlDecode(table.rows[this.i].cells[5].innerHTML),
          'alamat': htmlDecode(table.rows[this.i].cells[6].innerHTML),
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
          'slug': table.rows[this.i].cells[1].innerHTML,
          'no_rm': table.rows[this.i].cells[3].innerHTML,
          'nama': table.rows[this.i].cells[2].innerHTML,
          'tlp': table.rows[this.i].cells[4].innerHTML,
          'tgl_lahir': table.rows[this.i].cells[5].innerHTML,
          'alamat': table.rows[this.i].cells[6].innerHTML,
        }
        var data1 = '\
        <table class="table table-bordered table-sm" cellspacing="0" width="100%" style="font-size:10px"> \
          <thead class="bg-light">\
            <tr>\
              <th class="col-xs-3 text-left customTableResponsive">Nama Pasien</th>\
              <th class="col-xs-1 text-left customTableResponsive">No RM</th>\
              <th class="col-xs-2 text-left customTableResponsive">Telpon</th>\
              <th class="col-xs-1 text-left customTableResponsive">Tgl lahir</th>\
              <th class="col-xs-2 text-left customTableResponsive">Alamat</th>\
            </tr>\
          </thead>\
          <tbody>\
            <tr>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.nama +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.no_rm +'</td>\
              <td class="col-xs-1 text-center customTableResponsive">'+ dataForm.tlp +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.tgl_lahir +'</td>\
              <td class="col-xs-2 text-left customTableResponsive">'+ dataForm.alamat +'</td>\
            </tr>'
        data1 += '</tbody> \
        </table>';

        $('#modalDeleteDataPasien #tabelDeletePasien').html(data1);
        $('#modalDeleteDataPasien #hapusDataPasien').attr('href',dataForm.slug)
      };
    }
  }
}
