<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ecnocardiography;
use App\Pasien;
use App\Http\Requests\EcnocardiographyRequestForm;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class EcnocardiographyController extends Controller
{
  public function showEcnocardiography(){
    return view('ecnocardiography.showEcnocardiography');
  }
  public function showReport(){
    return view('ecnocardiography.showReport');
  }
  public function getEcnocardiography(){
    $ecnocardiography = Ecnocardiography::with('pasien')->orderBy('konfirmasi','desc')->orderBy('tgl_ditindak','desc')->orderBy('waktu_ditindak','desc')->get();
    return response()->json(array('msg' => $ecnocardiography));
  }
  public function tambahEcnocardiography(EcnocardiographyRequestForm $request){
    if(!Auth::user()->can('create')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Echocardiography");
    }

    $namaFile = '';
    $suratRujukan = $request->file('surat_rujukan');
    if($suratRujukan){
      $sumberFile = $this->buatFolder($request, 'DataEcnocardiography');
      $namaFile = date('YmdHis').'_'.$suratRujukan->getClientOriginalName();
      $this->simpanGambar($suratRujukan, $sumberFile, $namaFile);
    }

    $slugEcnocardiography = uniqid(null,true);
    $reservasi = new Ecnocardiography(array(
      'slug' => $slugEcnocardiography,
      'tgl_ditindak' => $request->get('tgl_ditindak'),
      'waktu_ditindak' => $request->get('waktu_ditindak'),
      'id_pasien' => ($pasien?$pasien->id:null),
      'surat_rujukan' => $namaFile,
      'keterangan' => $request->get('keterangan'),
      'petugas_poli' => $request->get('petugas_poli'),
      'petugas_fo' => $request->get('petugas_fo'),
      'konfirmasi' => $request->get('confirm')?"1":"0",
      'nama_pasien' => $request->get('nama'),
      'tlp_pasien' => $request->get('tlp'),
      'alamat_pasien' => $request->get('alamat'),
      'tgl_lahir_pasien' => $request->get('tgl_lahir'),
      'id_bpjs_pasien' => $request->get('id_bpjs'),
      'kelas_bpjs_pasien' => $request->get('kelas_bpjs')
    ));

    $reservasi->save();
    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil disimpan pada Pendaftaran Ecnocardiography";
    saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Echocardiography", "Tabel Echocardiography", "", json_encode($reservasi));
    return response()->json(array('msg' => $status));
  }

  public function editEcnocardiography(EcnocardiographyRequestForm $request, $slugEcnocardiography){
    if(!Auth::user()->can('update')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
    }
    $pasien = '';
    if($request->get('no_rm')){
      $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Echocardiography");
    }

    $reservasi = Ecnocardiography::where('slug', $slugEcnocardiography)->firstOrFail();
    $reservasi_old = clone $reservasi;
    $namaFile = '';
    $suratRujukan = $request->file('surat_rujukan');

    if($suratRujukan){
      $sumberFile = public_path().DIRECTORY_SEPARATOR.'DataEcnocardiography'.DIRECTORY_SEPARATOR.$reservasi->pasien->no_rm.DIRECTORY_SEPARATOR.$reservasi->tgl_ditindak.DIRECTORY_SEPARATOR.$reservasi->surat_rujukan;
      if(File::exists($sumberFile)){
          File::delete($sumberFile);
      }
      $sumberFile = $this->buatFolder($request, 'DataEcnocardiography');
      $namaFile = date('YmdHis').'_'.$suratRujukan->getClientOriginalName();
      $this->simpanGambar($suratRujukan, $sumberFile, $namaFile);
    }else{
      if($reservasi->surat_rujukan){
        $sumberFile = $this->buatFolder($request, 'DataEcnocardiography');
        $sumberFileBefore = public_path().DIRECTORY_SEPARATOR.'DataEcnocardiography'.DIRECTORY_SEPARATOR.$reservasi->pasien->no_rm.DIRECTORY_SEPARATOR.$reservasi->tgl_ditindak.DIRECTORY_SEPARATOR.$reservasi->surat_rujukan;
        $sumberFileAfter =public_path().DIRECTORY_SEPARATOR.'DataEcnocardiography'.DIRECTORY_SEPARATOR.$request->get('no_rm').DIRECTORY_SEPARATOR.$request->get('tgl_ditindak').DIRECTORY_SEPARATOR.$reservasi->surat_rujukan;
        File::move($sumberFileBefore,$sumberFileAfter);
      }
      $namaFile = $reservasi->surat_rujukan;
    }
    $reservasi->tgl_ditindak = $request->get('tgl_ditindak');
    $reservasi->waktu_ditindak = $request->get('waktu_ditindak');
    $reservasi->id_pasien = ($pasien?$pasien->id:null);
    $reservasi->surat_rujukan = $namaFile;
    $reservasi->keterangan = $request->get('keterangan');
    $reservasi->petugas_poli = $request->get('petugas_poli');
    $reservasi->petugas_fo = $request->get('petugas_fo');
    $reservasi->konfirmasi = $request->get('confirm')?"1":"0";
    $reservasi->nama_pasien = $request->get('nama');
    $reservasi->tlp_pasien = $request->get('tlp');
    $reservasi->alamat_pasien = $request->get('alamat');
    $reservasi->tgl_lahir_pasien = $request->get('tgl_lahir');
    $reservasi->id_bpjs_pasien = $request->get('id_bpjs');
    $reservasi->kelas_bpjs_pasien = $request->get('kelas_bpjs');
    $reservasi->save();

    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil disimpan pada Pendaftaran Ecnocardiography";
    saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Echocardiography", "Tabel Echocardiography", json_encode($reservasi_old), json_encode($reservasi));
    return response()->json(array('msg' => $status));
  }

  public function deleteEcnocardiography($slugEcnocardiography){
    if(!Auth::user()->can('delete')){
      return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
    }
    $reservasi = Ecnocardiography::where('slug', $slugEcnocardiography)->firstOrFail();
    $reservasi_old = clone $reservasi;
    $sumberFile = public_path().DIRECTORY_SEPARATOR.'DataEcnocardiography'.DIRECTORY_SEPARATOR.($reservasi->pasien?$reservasi->pasien->no_rm:'').DIRECTORY_SEPARATOR.$reservasi->tgl_ditindak.DIRECTORY_SEPARATOR.$reservasi->surat_rujukan;
    if(File::exists($sumberFile)){
        File::delete($sumberFile);
    }
    $status = "Data Pasien: <b>".$reservasi->nama_pasien."</b> berhasil dihapus.";
    $reservasi->delete();
    saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Echocardiography", "Tabel Echocardiography", json_encode($reservasi_old), json_encode($reservasi));
    return response()->json(array('msg'=>$status));
  }

  private function buatFolder($request, $namaFolder){
    $sumberFile = public_path();
    if(!File::exists($sumberFile.DIRECTORY_SEPARATOR.$namaFolder)){
      File::makeDirectory($sumberFile.DIRECTORY_SEPARATOR.$namaFolder);
    }
    $sumberFile = public_path().DIRECTORY_SEPARATOR.$namaFolder;

    if(!File::exists($sumberFile.DIRECTORY_SEPARATOR.$request->get('no_rm'))){
      File::makeDirectory($sumberFile.DIRECTORY_SEPARATOR.$request->get('no_rm'));
    }
    $sumberFile = $sumberFile.DIRECTORY_SEPARATOR.$request->get('no_rm');

    if(!File::exists($sumberFile.DIRECTORY_SEPARATOR.$request->get('tgl_ditindak'))){
      File::makeDirectory($sumberFile.DIRECTORY_SEPARATOR.$request->get('tgl_ditindak'));
    }
    $sumberFile = $sumberFile.DIRECTORY_SEPARATOR.$request->get('tgl_ditindak');
    return $sumberFile;
  }

  private function simpanGambar($suratRujukan, $sumberFile, $fileName ){
    $gambarOlah = Image::make($suratRujukan->getRealPath());
    $gambarOlahWidth = $gambarOlah->width();
    $gambarOlahHeight = $gambarOlah->height();
    if($gambarOlahWidth >= $gambarOlahHeight){
      //Landscape
      $gambarOlah->resize(625, null, function ($constraint){
                            $constraint->aspectRatio();
                          })->save($sumberFile.DIRECTORY_SEPARATOR.$fileName);
    }else{
      //Potrait
      $gambarOlah->resize(null, 625, function ($constraint){
                            $constraint->aspectRatio();
                          })->save($sumberFile.DIRECTORY_SEPARATOR.$fileName);
    }
  }
}
