<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BabySPA;
use App\Http\Requests\BabySPAFormRequest;
use App\Pasien;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
class BabySPAController extends Controller
{
  public function showBabySPA(){
    return view('babyspa.showBabySPA');
  }

  public function showReport(){
    return view('babyspa.showReport');
  }

  public function getBabySPA(){
    $babySPA = BabySPA::with('pasien')->orderBy('konfirmasi','asc')->orderBy('tgl_reservasi','asc')->orderBy('pukul_reservasi_awal', 'asc')->get();
    return response()->json(array('msg' => $babySPA));
  }

  public function tambahBabySPA(BabySPAFormRequest $request){
    if(!Auth::user()->can('create')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Baby SPA");
    }
    $pukul_akhir = date ("H:i:s", strtotime ($request->get('pukul_reservasi_awal') ."+59 minutes"));
    $slugBabySPA = uniqid(null, true);
    $babySPA = new BabySPA(array(
      'slug' => $slugBabySPA,
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
    $babySPA->save();
    $status = "Data Pasien: <b>".$babySPA->nama_pasien."</b> berhasil disimpan pada Reservasi Baby SPA";
    saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Baby SPA", "Tabel Baby SPA", "", json_encode($babySPA));
    return response()->json(array('msg' => $status));
  }

  public function editBabySPA(BabySPAFormRequest $request, $slugBabySPA){
    if(!Auth::user()->can('update')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request,"Tabel Pasien, Melalui Tabel Baby SPA");
    }

    $pukul_akhir = date ("H:i:s", strtotime ($request->get('pukul_reservasi_awal') ."+59 minutes"));
    $babySPA = BabySPA::where('slug',$slugBabySPA)->firstOrFail();
    $babySPA_old = clone $babySPA;
    $babySPA->id_pasien = ($pasien?$pasien->id:null);
    $babySPA->tgl_reservasi = $request->get('tgl_reservasi');
    $babySPA->pukul_reservasi_awal = $request->get('pukul_reservasi_awal');
    $babySPA->pukul_reservasi_akhir = $pukul_akhir;
    $babySPA->keterangan = $request->get('keterangan');
    $babySPA->konfirmasi = $request->get('confirm')?"1":"0";
    $babySPA->nama_pasien = ($pasien?$pasien->nama:$request->get('nama'));
    $babySPA->tlp_pasien = ($pasien?$pasien->tlp:$request->get('tlp'));
    $babySPA->alamat_pasien = ($pasien?$pasien->alamat:$request->get('alamat'));
    $babySPA->tgl_lahir_pasien = ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir'));
    $babySPA->id_bpjs_pasien = ($pasien?$pasien->id_bpjs:$request->get('id_bpjs'));
    $babySPA->kelas_bpjs_pasien = ($pasien?$pasien->kelas_bpjs:$request->get('kelas_bpjs'));

    $babySPA->save();

    $status = "Data Pasien: <b>".$babySPA->nama_pasien."</b> berhasil disimpan pada Reservasi Baby SPA";
    saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Baby SPA", "Tabel Baby SPA", json_encode($babySPA_old), json_encode($babySPA));
    return response()->json(array('msg' => $status));
  }

  public function deleteBabySPA($slugBabySPA){
    if(!Auth::user()->can('delete')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
    }
    $babySPA = BabySPA::where('slug', $slugBabySPA)->firstOrFail();
    $babySPA_old = clone $babySPA;
    $status = "Data Pasien: <b>".$babySPA->nama_pasien."</b> berhasil dihapus.";
    $babySPA->delete();
    saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Baby SPA", "Tabel Baby SPA", json_encode($babySPA_old), "");
    return response()->json(array('msg'=>$status));
  }
}
