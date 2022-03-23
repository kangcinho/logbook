<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\KamarRequestForm;
use App\Kamar;
use Illuminate\Support\Facades\Auth;
class KamarController extends Controller
{
    public function showKamar()
    {
      return view('kamar.showKamar');
    }

    public function tambahKamar(KamarRequestForm $request)
    {
      if(!Auth::user()->can('create')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menambahkan Data'));
      }
      $slug = uniqid(null,true);
      $kamar = new Kamar(array(
        'slug' => $slug,
        'nama_kamar' => $request->get('nama_kamar'),
        'deskripsi_kamar' => $request->get('deskripsi_kamar'),
      ));
      $kamar->save();
      $status = "Data Kamar: <b>".$request->get('nama_kamar')."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function editKamar(KamarRequestForm $request, $slug)
    {
      if(!Auth::user()->can('update')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Mengubah Data'));
      }
      $kamar = Kamar::where('slug',$slug)->firstOrFail();
      $kamar->nama_kamar = $request->get('nama_kamar');
      $kamar->deskripsi_kamar = $request->get('deskripsi_kamar');
      $kamar->save();
      $status = "Data Kamar: <b>".$request->get('nama_kamar')."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function deleteKamar($slug)
    {
      if(!Auth::user()->can('delete')){
        return response()->json(array('msg' => 'Anda tidak memiliki Akses Untuk Menghapus Data'));
      }
      $kamar = Kamar::where('slug',$slug)->firstOrFail();
      $namaKamar = $kamar->nama_kamar;
      $kamar->delete();
      $status = "Data Kamar: <b>".$namaKamar."</b> berhasil dihapus.";
      return response()->json(array('msg' => $status));
    }

    public function getKamar()
    {
      $kamar = Kamar::orderBy('created_at','desc')->get();
      return response()->json(array('msg' => $kamar));
    }

    public function getKamarDanNomorKamar(){
      $kamar = Kamar::with('no_kamar')->orderBy('nama_kamar','asc')->get();
      return response()->json(array('msg' => $kamar));
    }
}
