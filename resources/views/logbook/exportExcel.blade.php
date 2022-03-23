<html>
  <head>
    <title></title>
    <style >
      table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
        vertical-align: middle;
      }
      .rataTengah{
        text-align: center;
      }
      table tr:nth-child(even){
        background-color: #f2f2f2;
      }
      table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
      }
    </style>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th>Tanggal Check in</th>
          <th>Waktu Check In</th>
          <th>Tanggal Check Out </th>
          <th>Waktu Check Out</th>
          <th>ID BPJS</th>
          <th>Kelas BPJS</th>
          <th>Nomor SEP</th>
          <th>Nama Kamar</th>
          <th>Nomor Kamar</th>
          <th>Paket Kamar</th>
          <th>Nomor RM</th>
          <th>Nama Pasien</th>
          <th>Telpon Pasien</th>
          <th>PPK I</th>
          <th>Dokter Perujuk</th>
          <th>Diagnosa</th>
          <th>Dokter Pengurus</th>
          <th>Keterangan</th>
        </tr>
      </thead>

      <tbody>
        @foreach($logbooks as $logbook)
            <tr>
              <td >{!! tanggal($logbook->JamReg) !!}</td>
              <td >{!! waktu($logbook->JamReg) !!}</td>
              <td >{!! tanggal($logbook->JamKeluar) !!}</td>
              <td >{!! waktu($logbook->JamKeluar) !!}</td>
              <td >{!! $logbook->NoAnggota !!}</td>
              <td class="rataTengah">{!! $logbook->KelasBPJS !!}</td>
              <td class="rataTengah">{!! ($logbook->NoSEP=='-'?'':$logbook->NoSEP) !!}</td>
              <td class="rataTengah">{!! $logbook->NamaKelas !!}</td>
              <td class="rataTengah">{!! $logbook->NoKamar !!}</td>
              <td class="rataTengah">
                @if($logbook->NaikKelas == '0' && $logbook->SilverPlus == '0')
                  {{'Silver'}}
                @elseif($logbook->NaikKelas == '1' && $logbook->SilverPlus == '0')
                  {{"Silver Top UP"}}
                @elseif($logbook->SilverPlus == '1')
                  {{"Silver Plus"}}
                @endif
              </td>
              <td class="rataTengah">{!! $logbook->NRM !!}</td>
              <td>{!! $logbook->NamaPasien !!}</td>
              <td>{!! $logbook->Phone !!}</td>
              <td>{!! ($logbook->AsalRujukan=='-'?'':$logbook->AsalRujukan) !!}</td>
              <td>{!! ($logbook->Rujukan=='0'?'':$logbook->Rujukan) !!}</td>
              <td>{!! ($logbook->DiagnosaView==null?'':$logbook->DiagnosaView) !!}</td>
              <td>{!! $logbook->NamaDokterRawatInap !!}</td>
              <td>{!! ($logbook->Keterangan==null?'':$logbook->Keterangan) !!}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>

<?php
  function tanggal($tgl1){
    if($tgl1==""){
      return '';
    }
    $tgl1 = explode(' ',$tgl1);
    $tgl = explode('-',$tgl1[0]);
    $bulan = '';
    switch($tgl[1]){
      case "01" : $bulan = "Januari"; break;
      case "02" : $bulan = "Februari"; break;
      case "03" : $bulan = "Maret"; break;
      case "04" : $bulan = "April"; break;
      case "05" : $bulan = "Mei"; break;
      case "06" : $bulan = "Juni"; break;
      case "07" : $bulan = "Juli"; break;
      case "08" : $bulan = "Agustus"; break;
      case "09" : $bulan = "September"; break;
      case "10" : $bulan = "Oktober"; break;
      case "11" : $bulan = "November"; break;
      case "12" : $bulan = "Desember"; break;
    }
    return $tgl[2].' '.$bulan.' '.$tgl[0];
  }

  function waktu($tgl){
    if($tgl==""){
      return '';
    }
    $pukul = explode(' ',$tgl);
    return explode('.',$pukul[1])[0];
  }
?>
