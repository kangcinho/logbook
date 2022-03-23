$(document).ready(function(){
  $('#btnSearchNRM').on('click', function(e){
    e.preventDefault();
    var nrm = $("#no_rm").val();
    $.ajax({
      type:'GET',
      url: 'getPasienIndividual/'+nrm,
      success:function(data){
        if(data.flag == "mysql"){
          $("#slugPasien").val(data.data.slug);
          $("#nama").val(data.data.nama);
          $("#tlp").val(data.data.tlp);
          if(data.data.tgl_lahir == null){
            $('#tgl_lahir').val('')
          }else{
            $('#tgl_lahir').val(data.data.tgl_lahir.split(' ')[0])
          }

          $("#alamat").val(data.data.alamat);
          $("#id_bpjs").val('');
          $('#kelas_bpjs').val('');
        }else if(data.flag == 'sqlserver'){
          //data SQL SERVER
          $("#slugPasien").val('');
          $("#nama").val(data.data.NamaPasien);
          $("#tlp").val(data.data.Phone);
          if(data.data.TglLahir == null){
            $('#tgl_lahir').val('')
          }else{
            $('#tgl_lahir').val(data.data.TglLahir.split(' ')[0])
          }
          $("#alamat").val(data.data.Alamat);
          $("#id_bpjs").val('');
          $('#kelas_bpjs').val('');
        }

        if(data.msg){
          alertSuccess(data.msg, 'msgHasilPencarianRM');
          $("#slugPasien").val('');
          $("#nama").val('');
          $("#tlp").val('');
          $('#tgl_lahir').val('');
          $("#alamat").val('');
        }
      }
    });
  })

  $("#no_rm").on('keypress',function(e){
    if(e.which == 13){
      $(this).click();
    }
  })
})
