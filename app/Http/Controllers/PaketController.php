<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paket;
use App\Http\Requests\PaketRequestForm;\
use Illuminate\Support\Facades\Auth;

class PaketController extends Controller
{
    public function showPaket()
    {
      return view('paket.showPaket');
    }

    public function tambahPaket(PaketRequestForm $request)
    {
      $slug = uniqid(null,true);
      $paket = new Paket(array(
        'slug' => $slug,
        'nama_paket' => $request->get('nama_paket'),
        'deskripsi_paket' => $request->get('deskripsi_paket'),
      ));
      $paket->save();
      $status = "Data Paket: <b>".$request->get('nama_paket')."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function editPaket(PaketRequestForm $request, $slug)
    {
      $paket = Paket::where('slug',$slug)->firstOrFail();
      $paket->nama_paket = $request->get('nama_paket');
      $paket->deskripsi_paket = $request->get('deskripsi_paket');
      $paket->save();
      $status = "Data Paket: <b>".$request->get('nama_paket')."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function deletePaket($slug)
    {
      $paket = Paket::where('slug',$slug)->firstOrFail();
      $namaPaket = $paket->nama_paket;
      $paket->delete();
      $status = "Data Paket: <b>".$namaPaket."</b> berhasil dihapus.";
      return response()->json(array('msg' => $status));
    }

    public function getPaket()
    {
      $paket = Paket::orderBy('created_at','desc')->get();
      return response()->json(array('msg' => $paket));
    }
}
