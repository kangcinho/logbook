<html>
  <head>
    <title></title>
    <style >
    .textBesar{
      font-size: 20px;
    }
    .textKecil{
      font-size:12px;
    }
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
          <th class="textBesar" colspan="10">{!! $namaFile !!}</th>
        </tr>
        <tr class="textKecil">
          <th>No</th>
          <th>Tgl Masuk</th>
          <th>Identitas Pasien</th>
          <th>PPK I</th>
          <th>Dokter Perujuk</th>
          <th>Kamar</th>
          <th>ID BPJS</th>
          <th>Diagnosa</th>
          <th>Nama Dokter Handel</th>
          <th>Keterangan / Tindakan</th>
        </tr>
      </thead>

      <tbody class="textKecil">
        {!! "";$no=0;!!}
        @foreach($logbooks as $logbook)
          <tr>
            <td class="rataTengah">{!! ++$no !!}</td>
            <td >{!! tanggal($logbook->JamReg) !!}</td>
            <td>{!! "Nama : ".$logbook->NamaPasien."<br>No.RM : ".$logbook->NRM."<br>No.SEP : ".$logbook->NoSEP."<br>Telp : ".$logbook->Phone."<br>Check-in : ".tanggal($logbook->JamReg)."<br>Check-out : ".tanggal($logbook->JamKeluar) !!}</td>
            <td>{!! ($logbook->AsalRujukan=='-'?'':$logbook->AsalRujukan) !!}</td>
            <td>{!! ($logbook->Rujukan=='0'?'':$logbook->Rujukan) !!}</td>
            <td class="rataTengah">{!! $logbook->NamaKelas."<br>".$logbook->NoKamar."<br>"!!}
              @if($logbook->NaikKelas == '0' && $logbook->SilverPlus == '0')
                {{'(Silver)'}}
              @elseif($logbook->NaikKelas == '1' && $logbook->SilverPlus == '0')
                {{"(Silver Top UP)"}}
              @elseif($logbook->SilverPlus == '1')
                {{"(Silver Plus)"}}
              @endif
            </td>
            <td class="rataTengah">{!! $logbook->NoAnggota !!}</td>
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
  function tanggal($tgl){
    if($tgl==""){
      return '';
    }
    $tgl = explode('-',$tgl);
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
?>
