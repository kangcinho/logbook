<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GeneralController extends Controller
{
    function suggestTime($tgl_reservasi){
      $tgl = explode("&hobayu&", $tgl_reservasi)[0];
      $namaTable = explode("&hobayu&", $tgl_reservasi)[1];
      $sql = '';
      if($namaTable == "upadana"){
        $sql = "SELECT pukul_reservasi FROM $namaTable WHERE tgl_reservasi = '$tgl'";
      }else if($namaTable == "radiologi" || $namaTable == "ecnocardiography"){
        $sql = "SELECT waktu_ditindak FROM $namaTable WHERE tgl_ditindak = '$tgl'";
      }else{
        $sql = "SELECT pukul_reservasi_awal, pukul_reservasi_akhir FROM $namaTable WHERE tgl_reservasi = '$tgl'";
      }
      $suggestTime = \DB::select(\DB::raw($sql));
      return response()->json(array('msg'=>$suggestTime));
    }

    function cekPukul($pukul){
      $waktu = explode("&hobayu&", $pukul)[0];
      $waktu1 = date ("H:i:s", strtotime ($waktu ."+59 minutes"));
      $tgl_reservasi = explode("&hobayu&", $pukul)[1];
      $namaTabel = explode("&hobayu&", $pukul)[2];
      $marginError = explode("&hobayu&", $pukul)[3];
      $slug = explode("&hobayu&", $pukul)[4];

      if($marginError == "0"){
        $sql = "SELECT COUNT(*) AS waktu FROM $namaTabel WHERE CAST('$waktu' AS TIME) BETWEEN pukul_reservasi_awal AND pukul_reservasi_akhir AND tgl_reservasi ='$tgl_reservasi'";
        $sql1 = "SELECT COUNT(*) AS waktu FROM $namaTabel WHERE CAST('$waktu1' AS TIME) BETWEEN pukul_reservasi_awal AND pukul_reservasi_akhir AND tgl_reservasi ='$tgl_reservasi'";
      }else{
        $sql = "SELECT COUNT(*) AS waktu FROM $namaTabel WHERE CAST('$waktu' AS TIME) BETWEEN pukul_reservasi_awal AND pukul_reservasi_akhir AND tgl_reservasi ='$tgl_reservasi' AND slug != '$slug'";
        $sql1 = "SELECT COUNT(*) AS waktu FROM $namaTabel WHERE CAST('$waktu1' AS TIME) BETWEEN pukul_reservasi_awal AND pukul_reservasi_akhir AND tgl_reservasi ='$tgl_reservasi' AND slug != '$slug'";
      }
      $status_waktu = \DB::select(\DB::raw($sql));
      $status_waktu1 = \DB::select(\DB::raw($sql1));
      return response()->json(array('msg'=>$status_waktu, 'msg1' => $status_waktu1));
    }

    function formChangePassword(){
      return view('user.formchangepassword');
    }

    function changePassword(Request $request){
      if(!(Hash::check($request->password, Auth::user()->password))){
        return redirect()->back()->with('status','Password Lama Salah');
      }
      $user = Auth::user();
      $user->password = bcrypt($request->password_new);
      $user->save();
      return redirect()->back()->with('status','Password Berhasil diubah');
    }
}
