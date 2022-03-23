<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Http\Requests\PasienRequestForm;
use Illuminate\Support\Facades\Auth;
use App\Userlog;
class PasienController extends Controller
{
    public function showPasien()
    {
      return view('pasien.showPasien');
    }

    public function getPasien()
    {
      $pasien = Pasien::orderBy('updated_at', 'desc')->get();
      return response()->json(array('msg' => $pasien));
    }

    public function getPasienIndividual($nrm)
    {
      $pasien = Pasien::where('no_rm',$nrm)->first();
      if($pasien){
        //Jika ada, Tampilkan
        return response()->json(array('data' => $pasien, 'flag' => "mysql"));
      }else{
        //Jika Tidak ada Cek di sql sever
        $pasien = \DB::connection('sqlsrv')->table('mPasien')->where('NRM', $nrm)->first();
        if($pasien){
          return response()->json(array('data' => $pasien, 'flag' => "sqlserver"));
        }else{
          return response()->json(array('msg'=> "No RM <b>".$nrm."</b> Belum Terdaftar pada Sistem Sanata"));
        }
      }
    }

    public function tambahPasien(PasienRequestForm $request)
    {
      if(!Auth::user()->can('create')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
      }
      $slug = uniqid(null,true);
      $pasien = new Pasien(array(
        'slug' => $slug,
        'nama' => $request->get('nama'),
        'no_rm' => $request->get('no_rm'),
        'tlp' => $request->get('tlp'),
        'alamat' => $request->get('alamat'),
        'tgl_lahir' => $request->get('tgl_lahir').' 00:00:00',
      ));
      $pasien->save();
      saveLog(Auth::user()->username, Auth::user()->name, "Tambah Data Pasien", "Tabel Pasien", "", json_encode($pasien));
      $status = "Data Pasien: <b>".$request->get('nama')."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function editPasien(PasienRequestForm $request, $slug)
    {
      if(!Auth::user()->can('update')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
      }
      $pasien = Pasien::where('slug',$slug)->firstOrFail();
      $pasien_old = clone $pasien;
      $pasien->nama = $request->nama;
      $pasien->no_rm = $request->no_rm;
      $pasien->tlp = $request->tlp;
      $pasien->alamat = $request->alamat;
      $pasien->tgl_lahir = $request->tgl_lahir;
      $pasien->save();
      $status = "Data Pasien: <b>".$request->get('nama')."</b> berhasil disimpan.";
      saveLog(Auth::user()->username, Auth::user()->name, "Edit Data Pasien", "Tabel Pasien", json_encode($pasien_old), json_encode($pasien));
      return response()->json(array('msg' => $status));
    }

    public function deletePasien($slug)
    {
      if(!Auth::user()->can('delete')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
      }
      $pasien = Pasien::where('slug',$slug)->firstOrFail();
      $pasien_old = clone $pasien;
      $nama = $pasien->nama;
      $pasien->delete();
      $status = "Data Pasien: <b>".$nama."</b> berhasil dihapus.";
      saveLog(Auth::user()->username, Auth::user()->name, "Delete Data Pasien", "Tabel Pasien", json_encode($pasien_old),"");
      return response()->json(array('msg' => $status));
    }
}
