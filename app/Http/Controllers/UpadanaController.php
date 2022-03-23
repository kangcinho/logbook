<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upadana;
use App\Pasien;
use App\Http\Requests\UpadanaRequestForm;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class UpadanaController extends Controller
{
  public function showUpadana(){
    return view('upadana.showresvdrup');
  }

  public function showReport(){
    return view('upadana.showReport');
  }

  public function getUpadana(){
    $upadana = Upadana::with('pasien')->orderBy('konfirmasi','asc')->orderBy('tgl_reservasi','asc')->orderBy('pukul_reservasi','asc')->get();
    return response()->json(array('msg'=> $upadana));
  }

  public function tambahUpadana(UpadanaRequestForm $request){
    if(!Auth::user()->can('create')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Upadana");
    }
    $nomorUrutan = $request->get('no_antrian');

    $slugReservasi = uniqid(null,true);
    $reservasi = new Upadana(array(
      'slug' => $slugReservasi,
      'tgl_reservasi' => $request->get('tgl_reservasi'),
      'pukul_reservasi' => $request->get('pukul_reservasi'),
      'id_pasien' => ($pasien?$pasien->id:null),
      'nomor_antrian' => $nomorUrutan,
      'konfirmasi' => $request->get('confirm')?"1":"0",
      'nama_pasien' => ($pasien?$pasien->nama:$request->get('nama')),
      'tlp_pasien' => ($pasien?$pasien->tlp:$request->get('tlp')),
      'alamat_pasien' => ($pasien?$pasien->alamat:$request->get('alamat')),
      'tgl_lahir_pasien' => ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir')),
      'id_bpjs_pasien' => ($pasien?$pasien->id_bpjs:$request->get('id_bpjs')),
      'kelas_bpjs_pasien' => ($pasien?$pasien->kelas_bpjs:$request->get('kelas_bpjs'))
    ));
    $reservasi->save();
    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil disimpan pada Pendaftaran dr.Upadana.";
    saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Upadana", "Tabel Upadana", "", json_encode($reservasi));
    return response()->json(array('msg' => $status));
  }

  public function editUpadana(UpadanaRequestForm $request, $slugUP){
    if(!Auth::user()->can('update')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Upadana");
    }
    $nomorUrutan = $request->get('no_antrian');

    $reservasi = Upadana::where('slug', $slugUP)->firstOrFail();
    $reservasi_old = clone $reservasi;
    $reservasi->tgl_reservasi = $request->get('tgl_reservasi');
    $reservasi->pukul_reservasi = $request->get('pukul_reservasi');
    $reservasi->id_pasien = ($pasien?$pasien->id:null);
    $reservasi->nomor_antrian = $nomorUrutan;
    $reservasi->konfirmasi = $request->get('confirm')?"1":"0";
    $reservasi->nama_pasien = ($pasien?$pasien->nama:$request->get('nama'));
    $reservasi->tlp_pasien = ($pasien?$pasien->tlp:$request->get('tlp'));
    $reservasi->alamat_pasien = ($pasien?$pasien->alamat:$request->get('alamat'));
    $reservasi->tgl_lahir_pasien = ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir'));
    $reservasi->id_bpjs_pasien = ($pasien?$pasien->id_bpjs:$request->get('id_bpjs'));
    $reservasi->kelas_bpjs_pasien = ($pasien?$pasien->kelas_bpjs:$request->get('kelas_bpjs'));
    $reservasi->save();
    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil disimpan pada Pendaftaran dr.Upadana.";
    saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Upadana", "Tabel Upadana", json_encode($reservasi_old), json_encode($reservasi));
    return response()->json(array('msg' => $status));
  }

  public function deleteUpadana($slug){
    if(!Auth::user()->can('delete')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
    }
    $reservasi = Upadana::with('pasien')->where('slug',$slug)->firstOrFail();
    $reservasi_old = clone $reservasi;
    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil dihapus.";
    $reservasi->delete();
    saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Upadana", "Tabel Upadana", json_encode($reservasi_old), "");
    return response()->json(array('msg'=>$status));
  }

  public function getAntrean($tgl){
    $nomor = Upadana::where('tgl_reservasi',explode('&hobayu&',$tgl)[0])->max('nomor_antrian');
    return response()->json(array('msg' => $nomor));
  }

}
