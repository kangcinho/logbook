function tanggal(tgl){
  if(tgl==null || tgl==''){
    return '';
  }
  var dataFull = tgl.split(' ');

  var data = dataFull[0].split('-');
  var dataBulan = '';
  switch(data[1]){
    case "01" : dataBulan = "Januari"; break;
    case "02" : dataBulan = "Februari"; break;
    case "03" : dataBulan = "Maret"; break;
    case "04" : dataBulan = "April"; break;
    case "05" : dataBulan = "Mei"; break;
    case "06" : dataBulan = "Juni"; break;
    case "07" : dataBulan = "Juli"; break;
    case "08" : dataBulan = "Agustus"; break;
    case "09" : dataBulan = "September"; break;
    case "10" : dataBulan = "Oktober"; break;
    case "11" : dataBulan = "Nopember"; break;
    case "12" : dataBulan = "Desember"; break;
  }
  return data[2]+' '+dataBulan+' '+data[0]
}

function tanggal1(tgl){
  if(tgl==null || tgl==''){
    return '';
  }
  var dataFull = tgl.split(' ');

  var data = dataFull[0].split('-');
  var dataBulan = '';
  switch(data[1]){
    case "01" : dataBulan = "Januari"; break;
    case "02" : dataBulan = "Februari"; break;
    case "03" : dataBulan = "Maret"; break;
    case "04" : dataBulan = "April"; break;
    case "05" : dataBulan = "Mei"; break;
    case "06" : dataBulan = "Juni"; break;
    case "07" : dataBulan = "Juli"; break;
    case "08" : dataBulan = "Agustus"; break;
    case "09" : dataBulan = "September"; break;
    case "10" : dataBulan = "Oktober"; break;
    case "11" : dataBulan = "Nopember"; break;
    case "12" : dataBulan = "Desember"; break;
  }
  return data[2]+' '+dataBulan+' '+data[0] + ' '+ dataFull[1].split('.')[0];
}
