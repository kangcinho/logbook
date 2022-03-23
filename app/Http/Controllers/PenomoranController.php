<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penomoran;
use App\Http\Requests\PenomoranFormRequest;
use Illuminate\Support\Facades\Auth;

class PenomoranController extends Controller
{
    function showPenomoran(){
      return view('penomoran.showPenomoran');
    }
    function getPenomoran(){
      $penomoran = Penomoran::orderBy('created_at','asc')->get();
      return response()->json(array('msg' => $penomoran));
    }

    public function tambahPenomoran(PenomoranFormRequest $request){
      if(!Auth::user()->can('create')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
      }
      $pasien = '';
      if($request->get('no_rm')){
        $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Penomoran");
      }

      $nomorRujukan = $this->getNomorRujukan();
      $nomorSPRI = $this->getNomorSPRI();
      $nomorSuratKontrol = $this->getSuratKontrol();
      $penomoran = new Penomoran(array(
        'nomor_rujukan' => $nomorRujukan,
        'nomor_spri' => $nomorSPRI,
        'nomor_surat_kontrol' => $nomorSuratKontrol,
        'nrm' => ($pasien?$pasien->no_rm:$request->get('no_rm')),
        'nama' => ($pasien?$pasien->nama:$request->get('nama')),
        'alamat' => ($pasien?$pasien->alamat:$request->get('alamat')),
        'tgl_lahir' => ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir'))
      ));

      $penomoran->save();
      $status = "Data Pasien: <b>".$penomoran->nama."</b> berhasil disimpan pada Penomoran BPJS";
      saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Penomoran BPJS", "Tabel Penomoran", "", json_encode($penomoran));
      return response()->json(array('msg' => $status));
    }

    public function editPenomoran(PenomoranFormRequest $request, $id){
      if(!Auth::user()->can('update')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
      }

      $pasien = '';
      if($request->get('no_rm')){
        $pasien = tambahPasien($request, "Tabel Pasien, Melalui Tabel Penomoran");
      }

      $penomoran = Penomoran::where('id',$id)->firstOrFail();
      $penomoran_old = clone $penomoran;
      $penomoran->nrm = ($pasien?$pasien->no_rm:$request->get('no_rm'));
      $penomoran->nama = ($pasien?$pasien->nama:$request->get('nama'));
      $penomoran->alamat = ($pasien?$pasien->alamat:$request->get('alamat'));
      $penomoran->tgl_lahir = ($pasien?$pasien->tgl_lahir:$request->get('tgl_lahir'));
      $penomoran->save();

      $status = "Data Pasien: <b>".$penomoran->nama."</b> berhasil disimpan pada Penomoran BPJS";
      saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Penomoran", "Tabel Penomoran", json_encode($penomoran_old), json_encode($penomoran));
      return response()->json(array('msg' => $status));
    }

    public function deletePenomoran($id){
      if(!Auth::user()->can('delete')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
      }

      $penomoran = Penomoran::where('id', $id)->firstOrFail();
      $penomoran_old = clone $penomoran;
      $status = "Data Pasien: <b>".$penomoran->nama."</b> berhasil dihapus.";
      $penomoran->delete();
      saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Penomoran", "Tabel Penomoran", json_encode($penomoran_old), "");
      return response()->json(array('msg'=>$status));
    }

    function getNomorRujukan(){
      // PB-DPS/R/0818/00000
      $bulan = date('m');
      $tahun = date('y');

      $nomor = Penomoran::whereMonth('created_at','=',$bulan)->whereYear('created_at','=',date('Y'))->count('id') + 1;
      $angkaDepan = '';
      for($i = 0 ; $i < (5 - (int)(strlen($nomor))); $i++){
        $angkaDepan .= '0';
      }

      $nomorRujukan = "PB-DPS/R/".$bulan.$tahun."/".$angkaDepan.$nomor;
      // echo $nomorRujukan;
      return $nomorRujukan;
    }

    function getNomorSPRI(){
      $nomor = Penomoran::count('id') + 1;
      // echo $nomor;
      $angkaDepan = '';
      for($i = 0 ; $i < (6 - (int)(strlen($nomor))); $i++){
        $angkaDepan .= '0';
      }
      $nomorSPRI = $angkaDepan.$nomor;
      // echo $nomorSPRI;
      return $nomorSPRI;
    }

    function getSuratKontrol(){
      $hari = date('d');
      $bulan = date('m');
      $angkaDepan = '';
      $nomor = Penomoran::whereMonth('created_at','=',$bulan)->whereDay('created_at','=',$hari)->count() + 1;
      for($i = 0 ; $i < (2 - (int)(strlen($nomor))); $i++){
        $angkaDepan .= '0';
      }
      $nomorSuratKontrol = $hari.$bulan.$angkaDepan.$nomor;
      return $nomorSuratKontrol;
    }
}
