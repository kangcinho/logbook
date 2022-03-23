function htmlEncode ( html )
{
    html = $.trim(html);
    return html.replace(/[&"'\<\>]/g, function(c)
    {
      switch (c)
      {
          case "&":
            return "&amp;";
          case "'":
            return "&#39;";
          case '"':
            return "&quot;";
          case "<":
            return "&lt;";
          default:
            return "&gt;";
      }
    });
};

function htmlDecode(html){
  html = $.trim(html);
  html = html.replace(/&amp;/g, "&")
  html = html.replace(/&#39;/g, "'")
  html = html.replace(/&quot;/g, '"')
  html = html.replace(/&lt;/g, '<')
  html = html.replace(/&gt;/g, '>')
  return html;
}

function cekValidasi(dataForm){
  var indek, dataLength = dataForm.length;
  for(indek = 0 ; indek < dataLength ; indek++){
    if(dataForm[indek].hasAttribute('required')==true){
      if(dataForm[indek].type == "text"){
        if(dataForm[indek].value.trim() == ''){
          return false;
        }
      }else if(dataForm[indek].type == "checkbox"){
        if(dataForm[indek].checked == false){
          return false;
        }
      }else if(dataForm[indek].type == "radio"){
        if(dataForm[indek].checked == false){
          return false;
        }
      }else{
        if(dataForm[indek].value == ''){
          return false;
        }
      }
    }
  }
  return true;
}

function clearDataForm(dataForm){
  var indek, dataLength = dataForm.length;
  for(indek = 0 ; indek < dataLength ; indek++){
    if(dataForm[indek].name == "_token"){
      //Tidak boleh dihapus jika menggunakan laravel
    }else if(dataForm[indek].type == "checkbox" || dataForm[indek].type == "radio"){
      dataForm[indek].checked = false;
    }else{
      dataForm[indek].value = '';
    }
  }
}

function clearDataFormId(dataForm){
  var $input = $(''+ dataForm+' :input')
  $input.each(function (index)
   {
      if($(this).attr('name') == '_token'){

      }else if($(this).attr('type') == "checkbox" || $(this).attr('type') == "radio"){
        $(this).prop('checked',false)
      }else{
        $(this).val('')
      }
   });
}

function setDataForm(destForm, dataForm){
  var indek, dataLength = destForm.length;
  // alert(dataLength)
  for(indek = 1 ; indek < dataLength ; indek++){
    // alert('index')
    if(destForm[indek].type == "checkbox" || destForm[indek].type == "radio"){
      if(dataForm[destForm[indek].getAttribute('id')] != undefined){
        if(dataForm[destForm[indek].getAttribute('id')] == '0'){
          destForm[indek].checked = false;
        }else{
          destForm[indek].checked = true;
        }
      }

    }else if(destForm[indek].type == "submit" || destForm[indek].tagName == "BUTTON"){
      //Tidak melakukan apapun terhadap button
    }else if(destForm[indek].type == "select-one"){
      if(dataForm[destForm[indek].getAttribute('id')] != undefined){
        destForm[indek].value = dataForm[destForm[indek].getAttribute('id')].slug;
        var event = new Event('change');
        destForm[indek].dispatchEvent(event);
      }
    }else{
      // if(dataForm[indek].includes('00:00:00')){
      //   dataForm[indek] = dataForm[indek].replace('00:00:00', '');
      // }
      if(dataForm[destForm[indek].getAttribute('id')] != undefined){
        // alert(dataForm[destForm[indek].getAttribute('id')])
        if(destForm[indek].getAttribute('id') == 'pukul_reservasi_awal'){
          dataForm[destForm[indek].getAttribute('id')] = dataForm[destForm[indek].getAttribute('id')].split('-')
          destForm[indek].value = dataForm[destForm[indek].getAttribute('id')][0].trim()
        }else{
          destForm[indek].value = (dataForm[destForm[indek].getAttribute('id')]==null?'':dataForm[destForm[indek].getAttribute('id')]);
        }
      }
    }
  }
}

function sendToServer(dataForm, typeSender, urlDest, senderFile = false, idNotif, tampilTabel){
  var dataSender;

  if(dataForm == ''){
    dataSender = '';
  }else{
    dataSender = $(dataForm).serializeArray();
  }

  //untuk upload File
  if(senderFile){
    dataSender = new FormData(dataForm);
    $.ajax({
      type : typeSender,
      url  : urlDest,
      data : dataSender,
      contentType : false,
      cache : false,
      processData : false,
      success:function(data){
        alertSuccess(data.msg, idNotif);
        clearDataForm(dataForm);
        tampilTabel();
      }
    });
  }else{
    $.ajax({
      type : typeSender,
      url  : urlDest,
      data : dataSender,
      success:function(data){
        alertSuccess(data.msg, idNotif);
        clearDataForm(dataForm);
        tampilTabel();
      }
    });
  }
}

function alertSuccess(dataMessage, idNotif){
  var notification = '<div class="alert alert-info alert-dissmisible fade show" role="alert" >'+
                  dataMessage +
                  '<button data-dismiss="alert" class="close" aria-label="Close">'+
                  '<span aria-hidden="true">&times;</span>'+
                  '</button>'+
                '</div>';
  $("#"+idNotif).html(notification);
}

function cekPukulReservasi(pukul, tgl_reservasi, table, marginError, slug = ''){
  var hasil = false;
  $.ajax({
    type : 'GET',
    url  : 'cekPukulReservasi/'+pukul+'&hobayu&'+tgl_reservasi+'&hobayu&'+table+'&hobayu&'+marginError+'&hobayu&'+slug,
    async: false,
    success:function(data){
      if(data.msg[0].waktu == 0 && data.msg1[0].waktu == 0){
        hasil = true;
      }
    }
  })
  return hasil;
}

function suggestTime(tgl_reservasi, table){
  var hasil = '';
  $.ajax({
    type : 'GET',
    url  : 'suggestTime/'+tgl_reservasi+'&hobayu&'+table,
    async: false,
    success:function(data){
      hasil = data.msg;
    }
  })
  return hasil;
}

// function setDataForm(destForm, dataForm){
//   var indek, dataLength = destForm.length;
//   for(indek = 1 ; indek < dataLength ; indek++){
//     if(destForm[indek].type == "checkbox" || destForm[indek].type == "radio"){
//       if(dataForm[indek] == '0'){
//         destForm[indek].checked = false;
//       }else{
//         destForm[indek].checked = true;
//       }
//     }else if(destForm[indek].type == "submit" || destForm[indek].tagName == "BUTTON"){
//       //Tidak melakukan apapun terhadap button
//     }else{
//       if(dataForm[indek].includes('00:00:00')){
//         dataForm[indek] = dataForm[indek].replace('00:00:00', '');
//       }
//       destForm[indek].value = (dataForm[indek].trim()=='null'?'':dataForm[indek].trim());
//     }
//   }
// }
