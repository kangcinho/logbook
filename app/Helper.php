<?php
use App\Userlog;
use App\Pasien;
use Illuminate\Support\Facades\Auth;

if (!function_exists('saveLog')) {
  function saveLog($username, $namaUser, $aksi, $tabel, $dataAwal, $dataAkhir){
    $userLog = new Userlog([
      'user' => $username,
      'nama_user' => $namaUser,
      'aksi' => $aksi,
      'table_menu' => $tabel,
      'data_awal' => $dataAwal,
      'data_akhir' => $dataAkhir
    ]);
    $userLog->save();
  }
}

if (!function_exists('tambahPasien')) {
  function tambahPasien($request, $namaTabel){
    $pasien = '';
    //simpan Pasien
    if($request->get('slugPasien')){
      //Edit Data pasien Baru
      $pasien = Pasien::where('slug',$request->get('slugPasien'))->firstOrFail();
      $pasien_old = clone $pasien;
      $pasien->nama = $request->get('nama');
      $pasien->alamat = $request->get('alamat');
      $pasien->tgl_lahir = $request->get('tgl_lahir');
      $pasien->tlp = $request->get('tlp');
      $pasien->id_bpjs = $request->get('id_bpjs');
      $pasien->kelas_bpjs = $request->get('kelas_bpjs');
      $pasien->save();
      saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Pasien", $namaTabel, json_encode($pasien_old), json_encode($pasien));
    }else{
      //Tambah Data Pasien Baru

      // //Mencegah User nakal
      // if(Pasien::where('no_rm',$request->get('no_rm'))->count()){
      //     return redirect()->back()->with('msg','Jangan Nakal! Data Pasien Sudah ada');
      // }

      $slugPasien = uniqid(null,true);
      $pasien = new Pasien(array(
        'slug' => $slugPasien,
        'nama' => $request->get('nama'),
        'no_rm' => $request->get('no_rm'),
        'alamat' => $request->get('alamat'),
        'tgl_lahir' => $request->get('tgl_lahir'),
        'tlp' => $request->get('tlp'),
        'id_bpjs' => $request->get('id_bpjs'),
        'kelas_bpjs' => $request->get('kelas_bpjs'),
      ));
      $pasien->save();
      saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Pasien", $namaTabel, "", json_encode($pasien));
      // return redirect()->back()->with('msg', $pasien->id);
    }
    return $pasien;
  }
}
if (!function_exists('tanggal')) {
  function tanggal($tglData){
    if($tglData==""){
      return '';
    }
    $dataTgl = explode(' ',$tglData);
    $tgl = explode('-',$dataTgl[0]);
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
    return $tgl[2].' '.$bulan.' '.$tgl[0].' '. $dataTgl[1];
  }
}
