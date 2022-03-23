<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nokamar;
use App\Kamar;
use App\Http\Requests\RequestNoKamarForm;
use Illuminate\Support\Facades\Auth;

class NoKamarController extends Controller
{
    public function showNoKamar()
    {
      return view('noKamar.showNoKamar');
    }
    public function tambahNoKamar(RequestNoKamarForm $request)
    {
      $kamar = Kamar::where('slug',$request->get('namaKamarInput'))->firstOrFail();
      $slug = uniqid(null,true);
      $noKamar = new Nokamar(array(
        'slug' => $slug,
        'no_kamar' => $request->get('nomor_kamar'),
        'deskripsi_no_kamar' => $request->get('deskripsi_nomor_kamar'),
        'id_kamar' => $kamar->id,
      ));
      $status = "Nomor Kamar: <b>".$request->get('nomor_kamar')."</b> berhasil disimpan.";
      $noKamar->save();
      return response()->json(array('msg' => $status));
    }

    public function editNoKamar(RequestNoKamarForm $request, $slug)
    {
      $noKamar = Nokamar::where('slug',$slug)->firstOrFail();
      $kamar = Kamar::where('slug', $request->get('namaKamarInput'))->firstOrFail();
      $noKamar->no_kamar = $request->get('nomor_kamar');
      $noKamar->deskripsi_no_kamar = $request->get('deskripsi_nomor_kamar');
      $noKamar->id_kamar = $kamar->id;
      $noKamar->save();
      $status = "Nomor Kamar: <b>".$noKamar->no_kamar."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function deleteNoKamar($slug)
    {
      $noKamar = Nokamar::where('slug',$slug)->firstOrFail();
      $nomorKamar = $noKamar->no_kamar;
      $noKamar->delete();
      $status = "Nomor Kamar: <b>".$nomorKamar."</b> berhasil dihapus.";
      return response()->json(array('msg'=> $status));
    }

    public function getNoKamar()
    {
      $noKamar = Nokamar::with('kamar')->orderBy('created_at','desc')->get();
      return response()->json(array('msg' => $noKamar));
    }
}
