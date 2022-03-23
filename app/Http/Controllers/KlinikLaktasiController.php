<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KlinikLaktasi;
use App\Http\Requests\KlinikLaktasiFormRequest;
use App\Pasien;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class KlinikLaktasiController extends Controller
{
  public function showKlinikLaktasi(){
    return view('kliniklaktasi.showKlinikLaktasi');
  }

  public function showReport(){
    return view('kliniklaktasi.showReport');
  }

  public function getKlinikLaktasi(){
    $klinikLaktasi = KlinikLaktasi::with('pasien')->orderBy('tgl_reservasi','asc')->orderBy('pukul_reservasi_awal', 'asc')->get();
    return response()->json(array('msg' => $klinikLaktasi));
  }

  public function tambahKlinikLaktasi(KlinikLaktasiFormRequest $request){
    if(!Auth::user()->can('create')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Klinik Laktasi");
    }

    $pukul_akhir = date ("H:i:s", strtotime ($request->get('pukul_reservasi_awal') ."+59 minutes"));
    $slugKlinikLaktasi = uniqid(null, true);
    $klinikLaktasi = new KlinikLaktasi(array(
      'slug' => $slugKlinikLaktasi,
      'id_pasien' => ($pasien?$pasien->id:null),
      'tgl_reservasi' => $request->get('tgl_reservasi'),
      'pukul_reservasi_awal' => $request->get('pukul_reservasi_awal'),
      'pukul_reservasi_akhir' => $pukul_akhir,
      'keterangan' => $request->get('keterangan'),
      'konfirmasi' => $request->get('confirm')?"1":"0",
      'nama_pasien' => ($pasien?$pasien->nama:$request->get('nama')),
      'tlp_pasien' => ($pasien?$pasien->tlp:$request->get('tlp')),
      'alamat_pasien' => ($pasien?$pasien->alamat:$request->get('alamat')),
      'tgl_lahir_pasien' => ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir')),
      'id_bpjs_pasien' => ($pasien?$pasien->id_bpjs:$request->get('id_bpjs')),
      'kelas_bpjs_pasien' => ($pasien?$pasien->kelas_bpjs:$request->get('kelas_bpjs'))
    ));
    $klinikLaktasi->save();
    $status = "Data Pasien: <b>".$klinikLaktasi->nama_pasien."</b> berhasil disimpan pada Reservasi Klinik Laktasi";
    saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Klinik Laktasi", "Tabel Klinik Laktasi", "", json_encode($klinikLaktasi));
    return response()->json(array('msg' => $status));
  }

  public function editKlinikLaktasi(KlinikLaktasiFormRequest $request, $slugKlinikLaktasi){
    if(!Auth::user()->can('update')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Klinik Laktasi");
    }
    $pukul_akhir = date ("H:i:s", strtotime ($request->get('pukul_reservasi_awal') ."+59 minutes"));

    $klinikLaktasi = KlinikLaktasi::where('slug',$slugKlinikLaktasi)->firstOrFail();
    $klinikLaktasi_old = clone $klinikLaktasi;
    $klinikLaktasi->id_pasien = ($pasien?$pasien->id:null);
    $klinikLaktasi->tgl_reservasi = $request->get('tgl_reservasi');
    $klinikLaktasi->pukul_reservasi_awal = $request->get('pukul_reservasi_awal');
    $klinikLaktasi->pukul_reservasi_akhir = $pukul_akhir;
    $klinikLaktasi->keterangan = $request->get('keterangan');
    $klinikLaktasi->konfirmasi = $request->get('confirm')?"1":"0";
    $klinikLaktasi->nama_pasien = ($pasien?$pasien->nama:$request->get('nama'));
    $klinikLaktasi->tlp_pasien = ($pasien?$pasien->tlp:$request->get('tlp'));
    $klinikLaktasi->alamat_pasien = ($pasien?$pasien->alamat:$request->get('alamat'));
    $klinikLaktasi->tgl_lahir_pasien = ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir'));
    $klinikLaktasi->id_bpjs_pasien = ($pasien?$pasien->id_bpjs:$request->get('id_bpjs'));
    $klinikLaktasi->kelas_bpjs_pasien = ($pasien?$pasien->kelas_bpjs:$request->get('kelas_bpjs'));
    $klinikLaktasi->save();

    $status = "Data Pasien: <b>".$klinikLaktasi->nama_pasien."</b> berhasil disimpan pada Reservasi Klinik Laktasi";
    saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Klinik Laktasi", "Tabel Klinik Laktasi", json_encode($klinikLaktasi_old), json_encode($klinikLaktasi));
    return response()->json(array('msg' => $status));
  }

  public function deleteKlinikLaktasi($slugKlinikLaktasi){
    if(!Auth::user()->can('delete')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
    }
    $klinikLaktasi = KlinikLaktasi::where('slug', $slugKlinikLaktasi)->firstOrFail();
    $klinikLaktasi_old = clone $klinikLaktasi;
    $status = "Data Pasien: <b>".$klinikLaktasi->nama_pasien."</b> berhasil dihapus.";
    $klinikLaktasi->delete();
    saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Klinik Laktasi", "Tabel Klinik Laktasi", json_encode($klinikLaktasi_old), "");
    return response()->json(array('msg'=>$status));
  }
}
