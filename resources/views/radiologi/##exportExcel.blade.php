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
          <th colspan="10">{!! $namaFile !!}</th>
        </tr>
        <tr>
          <th>No</th>
          <th>Tgl Ditindak</th>
          <th>Nomor RM</th>
          <th>Nama Pasien</th>
          <th>Alamat Pasien</th>
          <th>Telpon Pasien</th>
          <th>dr Pengirim</th>
          <th>dr Penindak</th>
          <th>Jenis Tindakan</th>
          <th>Petugas Radiologi</th>
        </tr>
      </thead>

      <tbody>
        {!! "";$no=0;!!}

        @foreach($reservasies as $reservasi)
            <tr>
              <td class="rataTengah">{!! ++$no !!}</td>
              <td class="rataTengah">{!! tanggal($reservasi->tgl_ditindak).' '.$reservasi->waktu_ditindak !!}</td>
              <td class="rataTengah">{!! ($reservasi->pasien?$reservasi->pasien->no_rm:'') !!}</td>
              <td class="rataTengah">{!! $reservasi->nama_pasien !!}</td>
              <td class="rataTengah">{!! $reservasi->alamat_pasien !!}</td>
              <td class="rataTengah">{!! $reservasi->tlp_pasien !!}</td>
              <td class="rataTengah">{!! $reservasi->dokter_pengirim !!}</td>
              <td class="rataTengah">{!! $reservasi->dokter_penindak !!}</td>
              <td class="rataTengah">{!! $reservasi->jenis_tindakan !!}</td>
              <td class="rataTengah">{!! $reservasi->petugas_radiologi !!}</td>
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
    $tanggalKita = explode(' ',$tgl);
    $tgl = explode('-',$tanggalKita[0]);
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
