<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logbook;
use App\Pasien;
use App\Nokamar;
use App\Paket;
use App\Kamar;
use App\Http\Requests\LogbookRequestForm;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
  /****** Script for SelectTopNRows command from SSMS  ******/
  // SELECT Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, NoKamar, NoBed, JamKeluar, Rujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, kelasA.NamaKelas as kelas, KdKelasAsal, kelasB.NamaKelas as kelas_asal, NoSEP, NaikKelas, SilverPlus, TitipKelas, mSupplier.Nama_Supplier AS AsalRujukan
  // FROM SIMtrRegistrasi
  // INNER JOIN Vw_Pasien  ON Vw_Pasien.NRM = SIMtrRegistrasi.NRM
  // INNER JOIN SIMmKelas kelasA ON kelasA.KelasID = SIMtrRegistrasi.KdKelas
  // INNER JOIN SIMmKelas kelasB ON kelasB.KelasID = SIMtrRegistrasi.KdKelasAsal
  // LEFT JOIN mSupplier ON mSupplier.Kode_Supplier = SIMtrRegistrasi.VendorID_Referensi
  // WHERE RawatInap='1' AND Year(JamReg) = '2018' AND  SIMtrRegistrasi.JenisKerjasamaID = '9'

    private function getDataLogbookFromSanata($tahun){
      $db_ext = \DB::connection('sqlsrv');
      $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
      ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, NoKamar, NoBed, JamKeluar, Rujukan, mSupplier.Nama_Supplier AS AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, kelasPelayanan.NamaKelas as kelasPelayanan_, KdKelasAsal, kelasAsal.NamaKelas as kelasAsal_,  NoSEP, NaikKelas, SilverPlus, TitipKelas')
      ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
      ->join('SIMmKelas as kelasPelayanan','kelasPelayanan.KelasID','=','SIMtrRegistrasi.KdKelas')
      ->join('SIMmKelas as kelasAsal','kelasAsal.KelasID','=','SIMtrRegistrasi.KdKelasAsal')
      ->leftjoin('mSupplier','mSupplier.Kode_Supplier','=','SIMtrRegistrasi.VendorID_Referensi')
      ->whereYear('JamReg',$tahun)
      ->where('SIMtrRegistrasi.RawatInap','1')
      ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
      ->orderBy('JamReg','desc')
      ->get();
      return $simTrRegistrasi;
    }

    private function getDataLogbookRJFromSanata($tahun){
      // $db_ext = \DB::connection('sqlsrv');
      // $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
      // ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, Rujukan, rujukan.Nama_Supplier AS AsalRujukan, DiagnosaAwal, DokterRawatID, dokter.Nama_Supplier as NamaDokter, DiagnosaView, NoSEP, UGD')
      // ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
      // ->join('mSupplier as dokter','dokter.Kode_Supplier','=','SIMtrRegistrasi.DokterRawatID')
      // ->leftjoin('mSupplier as rujukan','rujukan.Kode_Supplier','=','SIMtrRegistrasi.VendorID_Referensi')
      // ->whereYear('JamReg',$tahun)
      // ->where('SIMtrRegistrasi.RawatInap','0')
      // ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
      // ->where('SIMtrRegistrasi.Batal','0')
      // ->orderBy('JamReg','desc')
      // ->get();
      //
      // return $simTrRegistrasi;

      $dataRegistrasiRJ = collect();
      $db_ext = \DB::connection('sqlsrv');
      foreach($db_ext->table('SIMtrRegistrasi')
              ->selectRaw('NoReg, Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, Rujukan, rujukan.Nama_Supplier AS AsalRujukan, DiagnosaAwal, DokterRawatID, dokter.Nama_Supplier as NamaDokter, DiagnosaView, NoSEP, UGD')
              ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
              ->join('mSupplier as dokter','dokter.Kode_Supplier','=','SIMtrRegistrasi.DokterRawatID')
              ->leftjoin('mSupplier as rujukan','rujukan.Kode_Supplier','=','SIMtrRegistrasi.VendorID_Referensi')
              ->whereYear('JamReg',$tahun)
              ->where('SIMtrRegistrasi.RawatInap','0')
              ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
              ->where('SIMtrRegistrasi.Batal','0')
              ->orderBy('JamReg','desc')
              ->cursor() as $registrasi){
                foreach($db_ext->table('SIMtrRJ')
                          ->select('NoBukti')
                          ->where('SIMtrRJ.RegNo','=',$registrasi->NoReg)
                          ->get() as $registrasiNoBukti ){
                            $noBukti = $db_ext->table('SIMtrRJDiagnosaAwal')
                            ->select('mICD.Descriptions')
                            ->join('mICD','mICD.KodeICD','=','SIMtrRJDiagnosaAwal.KodeICD')
                            ->where('SIMtrRJDiagnosaAwal.NOBukti', $registrasiNoBukti->NoBukti)
                            ->get();
                            foreach($noBukti as $bukti){
                              $registrasi->DiagnosaView .= $bukti->Descriptions.',# ';
                            }
                }
        $dataRegistrasiRJ->push($registrasi);
      }
      return $dataRegistrasiRJ;

      // $db_ext = \DB::connection('sqlsrv');
      // $simTrRegistrasi = $db_ext->statement('EXEC ho_cursorICD ?',[$tahun]);
      // return $simTrRegistrasi;
    }

    private function getDataDoctorFromSanata(){
      $db_ext = \DB::connection('sqlsrv');
      $simTrRegistrasiNamaDokter = $db_ext->table('SIMtrRegistrasi')
      ->distinct()
      ->select('NamaDokterRawatInap')
      ->where('RawatInap','1')
      ->get();
      return $simTrRegistrasiNamaDokter;
    }

    private function getDataDoctorRJFromSanata($tahun){
      $db_ext = \DB::connection('sqlsrv');
      $simTrRegistrasiNamaDokter = $db_ext->table('SIMtrRegistrasi')
      ->selectRaw('DokterRawatID, mSupplier.Nama_Supplier as NamaDokterRawatInap')
      ->join('mSupplier','mSupplier.Kode_Supplier','=','SIMtrRegistrasi.DokterRawatID')
      ->where('JenisKerjasamaID','9')
      ->whereYear('JamReg',$tahun)
      ->groupBy('DokterRawatID','mSupplier.Nama_Supplier')
      ->get();
      return $simTrRegistrasiNamaDokter;
    }

    private function getDataKamarFromSanata(){
      $db_ext = \DB::connection('sqlsrv');
      $simMKelas = $db_ext->table('SIMmKelas')
      ->select('NamaKelas')
      ->get();
      return $simMKelas;
    }

    public function showLogbook(){
      // $simTrRegistrasi = $this->getDataLogbookFromSanata('2018');
      // dd($simTrRegistrasi);
      return view('logbook.showLogbook');
    }

    public function showLogbookRJ(){
      // $db_ext = \DB::connection('sqlsrv');
      // $dataRegistrasiRJ = $db_ext->statement('exec ho_cursorICD 2018');
      // dd($dataRegistrasiRJ);
      // $dataRegistrasiRJ = collect();
      // $db_ext = \DB::connection('sqlsrv');
      // $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
      // ->selectRaw('NoReg, Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, Rujukan, rujukan.Nama_Supplier AS AsalRujukan, DiagnosaAwal, DokterRawatID, dokter.Nama_Supplier as NamaDokter, DiagnosaView, NoSEP, UGD')
      // ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
      // ->join('mSupplier as dokter','dokter.Kode_Supplier','=','SIMtrRegistrasi.DokterRawatID')
      // ->leftjoin('mSupplier as rujukan','rujukan.Kode_Supplier','=','SIMtrRegistrasi.VendorID_Referensi')
      // ->whereYear('JamReg','2018')
      // ->where('SIMtrRegistrasi.RawatInap','0')
      // ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
      // ->where('SIMtrRegistrasi.Batal','0')
      // ->orderBy('JamReg','desc')
      // ->cursor();

      // $db_ext->table('SIMtrRegistrasi')
      // ->selectRaw('NoReg, Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, Rujukan, rujukan.Nama_Supplier AS AsalRujukan, DiagnosaAwal, DokterRawatID, dokter.Nama_Supplier as NamaDokter, DiagnosaView, NoSEP, UGD')
      // ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
      // ->join('mSupplier as dokter','dokter.Kode_Supplier','=','SIMtrRegistrasi.DokterRawatID')
      // ->leftjoin('mSupplier as rujukan','rujukan.Kode_Supplier','=','SIMtrRegistrasi.VendorID_Referensi')
      // ->whereYear('JamReg','2018')
      // ->where('SIMtrRegistrasi.RawatInap','0')
      // ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
      // ->where('SIMtrRegistrasi.Batal','0')
      // ->orderBy('JamReg','desc')
      // ->chunk(100, function($registrasis) use ($db_ext,$dataRegistrasiRJ){
      //   foreach($registrasis as $registrasi){
      //     foreach( $db_ext->table('SIMtrRJ')
      //     ->select('NoBukti')
      //     ->where('SIMtrRJ.RegNo','=',$registrasi->NoReg)
      //     ->cursor() as $registrasiNoBukti ){
      //       $noBukti = $db_ext->table('SIMtrRJDiagnosaAwal')
      //       ->select('mICD.Descriptions')
      //       ->join('mICD','mICD.KodeICD','=','SIMtrRJDiagnosaAwal.KodeICD')
      //       ->where('SIMtrRJDiagnosaAwal.NOBukti', $registrasiNoBukti->NoBukti)
      //       ->get();
      //       foreach($noBukti as $bukti){
      //         $registrasi->DiagnosaView .= $bukti->Descriptions.', ';
      //       }
      //     }
      //     $dataRegistrasiRJ->push($registrasi);
      //   }
      // });
      // dd($dataRegistrasiRJ);
      return view('logbook.showLogbookrj');
    }

    public function getLogbook($tahun){
      // $logbook = Logbook::with('nokamar','nokamar.kamar','paket','pasien')->orderBy('updated_at','desc')->get();
      $logbook = $this->getDataLogbookFromSanata($tahun);
      $namaDokter = $this->getDataDoctorFromSanata();
      $namaKamar = $this->getDataKamarFromSanata();
      return response()->json(array('msg' => $logbook, 'dokter' => $namaDokter, 'kamar' => $namaKamar));
    }

    public function getLogbookRJ($tahun){
      $logbook = $this->getDataLogbookRJFromSanata($tahun);
      $namaDokter = $this->getDataDoctorRJFromSanata($tahun);
      return response()->json(array('msg' => $logbook, 'dokter' => $namaDokter));
    }

    // public function showReport(){
    //   $kamars = Kamar::orderBy('nama_kamar','asc')->get();
    //   $pakets = Paket::orderBy('nama_paket', 'asc')->get();
    //   return view('logbook.showReport',compact('kamars', 'pakets'));
    // }

    // public function tambahLogbook(LogbookRequestForm $request){
    //   $pasien = '';
    //   if($request->get('no_rm')){
    //     $pasien = $this->tambahPasien($request);
    //   }
    //
    //   $slug = uniqid(null,true);
    //   $nokamar = Nokamar::where('slug',$request->get('kamar_logbook'))->firstOrFail();
    //   $paket = Paket::where('slug',$request->get('paket_logbook'))->firstOrFail();
    //   $checkout = null;
    //   $statusLogBook = 0;
    //   if($request->get('check_out') != null){
    //     $statusLogBook =1;
    //     $checkout = $request->get('check_out');
    //   }
    //   $logbook = new Logbook(array(
    //     'slug' => $slug,
    //     'id_pasien' => $pasien->id,
    //     'ppk' => $request->get('ppk'),
    //     'dokter_perujuk' => $request->get('dokter_perujuk'),
    //     'id_no_kamar' => $nokamar->id,
    //     'id_paket_kamar' => $paket->id,
    //     'diagnosa' => $request->get('diagnosa'),
    //     'nama_dokter' => $request->get('nama_dokter'),
    //     'keterangan_tindakan' => $request->get('keterangan_tindakan'),
    //     'check_in' => $request->get('check_in'),
    //     'check_out' => $checkout,
    //     'status_logbook' => $statusLogBook,
    //     'no_sep' => $request->get('no_sep'),
    //     'nama_pasien' => $request->get('nama'),
    //     'tlp_pasien' => $request->get('tlp'),
    //     'alamat_pasien' => $request->get('alamat'),
    //     'tgl_lahir_pasien' => $request->get('tgl_lahir'),
    //     'id_bpjs_pasien' => $request->get('id_bpjs'),
    //     'kelas_bpjs_pasien' => $request->get('kelas_bpjs')
    //   ));
    //   $logbook->save();
    //   $status = "Pasien bernama <b>".$logbook->nama_pasien."</b> dengan Nomor Kamar <b>".$nokamar->no_kamar."</b> dan Paket <b>".$paket->nama_paket."</b> Berhasil disimpan.<a href='".url('logbook')."' class='alert-link'> Lihat Semua Data Logbook </a>";
    //   return redirect()->back()->with('msg',$status);
    // }
    //
    // public function tambahLogbookForm(){
    //   $paket = Paket::pluck('nama_paket','slug')->toArray();
    //   $kamars = Kamar::with('no_kamar')->get();
    //   return view('logbook.tambahLogbookForm', compact('paket','kamars'));
    // }
    //
    // public function editLogbookForm($slug){
    //   $logbook = Logbook::with('nokamar','paket','pasien')->where('slug',$slug)->firstOrFail();
    //   $paket = Paket::pluck('nama_paket','slug')->toArray();
    //   $kamars = Kamar::with('no_kamar')->get();
    //   return view('logbook.editLogbookForm', compact('paket','kamars', 'logbook'));
    // }
    //
    // public function editLogbook(LogbookRequestForm $request, $slug){
    //   $pasien = '';
    //   if($request->get('no_rm')){
    //     $pasien = $this->tambahPasien($request);
    //   }
    //
    //   $logbook = Logbook::where('slug',$slug)->firstOrFail();
    //   $nokamar = Nokamar::where('slug',$request->get('kamar_logbook'))->firstOrFail();
    //   $paket = Paket::where('slug',$request->get('paket_logbook'))->firstOrFail();
    //   $checkout = null;
    //   $statusLogBook = 0;
    //   if($request->get('check_out') != null){
    //     $statusLogBook =1;
    //     $checkout = $request->get('check_out');
    //   }
    //
    //   $logbook->id_pasien = $pasien->id;
    //   $logbook->ppk = $request->get('ppk');
    //   $logbook->dokter_perujuk = $request->get('dokter_perujuk');
    //   $logbook->no_sep = $request->get('no_sep');
    //   $logbook->id_no_kamar = $nokamar->id;
    //   $logbook->id_paket_kamar = $paket->id;
    //   $logbook->diagnosa = $request->get('diagnosa');
    //   $logbook->nama_dokter = $request->get('nama_dokter');
    //   $logbook->keterangan_tindakan = $request->get('keterangan_tindakan');
    //   $logbook->check_in = $request->get('check_in');
    //   $logbook->check_out = $checkout;
    //   $logbook->status_logbook = $statusLogBook;
    //   $logbook->nama_pasien = $request->get('nama');
    //   $logbook->tlp_pasien = $request->get('tlp');
    //   $logbook->alamat_pasien = $request->get('alamat');
    //   $logbook->tgl_lahir_pasien = $request->get('tgl_lahir');
    //   $logbook->id_bpjs_pasien = $request->get('id_bpjs');
    //   $logbook->kelas_bpjs_pasien = $request->get('kelas_bpjs');
    //   $logbook->save();
    //
    //   $status = "Pasien bernama <b>".$pasien->nama."</b> dengan Nomor Kamar <b>".$nokamar->no_kamar."</b> dan Paket <b>".$paket->nama_paket."</b> Berhasil disimpan.<a href='".url('logbook')."' class='alert-link'> Lihat Semua Data Logbook </a>";
    //   return redirect('logbook')->with('msg',$status);
    // }
    //
    // public function deleteLogbook($slug){
    //   $logbook = Logbook::where('slug',$slug)->firstOrFail();
    //   $status = "Pasien bernama <b>".$logbook->pasien()->get()->first()->nama."</b> dengan Nomor Kamar <b>".$logbook->nokamar()->get()->first()->no_kamar."</b> dan Paket <b>".$logbook->paket()->get()->first()->nama_paket."</b> Berhasil dihapus";
    //   $logbook->delete();
    //   return redirect()->back()->with('msg',$status);
    // }


    // public function optionExport($search){
    //   $db_ext = \DB::connection('sqlsrv');
    //   $simTrRegistrasi = '';
    //   $dataSearch = explode("&hobayu&", $search);
    //   if($dataSearch[0] == ""){ //Tampilkan semua data
    //     if($dataSearch[1] != '' && $dataSearch[2] != ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','>=',$dataSearch[1].' '.'00:00:00.000')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[1] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->whereDate('SIMtrRegistrasi.JamReg','=',$dataSearch[1])
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //     if($dataSearch[1] == '' && $dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //   }else if($dataSearch[0] == "0"){
    //     if($dataSearch[1] != '' && $dataSearch[2] != ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','>=',$dataSearch[1].' '.'00:00:00.000')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->whereNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[1] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->whereNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->whereDate('SIMtrRegistrasi.JamReg','=',$dataSearch[1])
    //       ->whereNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //     if($dataSearch[1] == '' && $dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->whereNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //   }else if($dataSearch[0] == "1"){
    //     if($dataSearch[1] != '' && $dataSearch[2] != ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','>=',$dataSearch[1].' '.'00:00:00.000')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->whereNotNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[1] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->where('SIMtrRegistrasi.JamReg','<=',$dataSearch[2].' '.'23:59:59.000')
    //       ->whereNotNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }else if($dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->whereDate('SIMtrRegistrasi.JamReg','=',$dataSearch[1])
    //       ->whereNotNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //     if($dataSearch[1] == '' && $dataSearch[2] == ''){
    //       $simTrRegistrasi = $db_ext->table('SIMtrRegistrasi')
    //       ->selectRaw('Vw_Pasien.NRM, Vw_Pasien.NamaPasien, Vw_Pasien.Phone, Vw_Pasien.NoKartu, SIMtrRegistrasi.NoAnggota, Vw_Pasien.NamaKelas as KelasBPJS, JamReg, SIMtrRegistrasi.Keterangan, KdKelas, NoKamar, NoBed, JamKeluar, Rujukan, AsalRujukan, DiagnosaAwal, NamaDokterRawatInap, DiagnosaView, KdKelas, SIMmKelas.NamaKelas, NoSEP, NaikKelas, SilverPlus')
    //       ->join('Vw_Pasien','Vw_Pasien.NRM','=','SIMtrRegistrasi.NRM')
    //       ->join('SIMmKelas','SIMmKelas.KelasID','=','SIMtrRegistrasi.KdKelas')
    //       ->whereYear('JamReg',$dataSearch[4])
    //       ->where('SIMtrRegistrasi.RawatInap','1')
    //       ->where('SIMtrRegistrasi.JenisKerjasamaID','9')
    //       ->where('SIMtrRegistrasi.NamaDokterRawatInap','like','%'.$dataSearch[3].'%')
    //       ->whereNotNull('SIMtrRegistrasi.JamKeluar')
    //       ->orderBy('SIMtrRegistrasi.JamReg','asc')
    //       ->get();
    //     }
    //   }
    //   return $simTrRegistrasi;
    // }

    // public function exportToExcel($search){
    //   $dataSearch = explode("&hobayu&", $search);
    //   $logbooks = $this->optionExport($search);
    //
    //   $namaFile = 'Logbook Tanggal '.$this->tanggal($dataSearch[1]).' - '.$this->tanggal($dataSearch[2]);
    //
    //   Excel::create('Logbook', function($excel) use ($logbooks, $namaFile) {
    //     $excel->setTitle($namaFile);
    //     $excel->setDescription($namaFile);
    //     $excel->setCreator('Agus Setiawan dan Putu Bayu Negara')
    //       ->setCompany('Puri Bunda');
    //     $excel->sheet('Logbook_sheet1', function($sheet) use ($logbooks, $namaFile) {
    //       $sheet->setOrientation('landscape');
    //       $sheet->freezeFirstRow();
    //       $sheet->getStyle('C')->getAlignment()->setWrapText(true);
    //       $sheet->getStyle('F')->getAlignment()->setWrapText(true);
    //       $sheet->loadView('logbook.exportExcel', array('logbooks' => $logbooks, 'namaFile' => $namaFile));
    //     });
    //   })->export('xls');
    // }
    //
    // public function exportToPdf($search){
    //   $dataSearch = explode("&hobayu&", $search);
    //   $logbooks = $this->optionExport($search);
    //
    //   $namaFile = 'Logbook Tanggal '.$this->tanggal($dataSearch[1]).' - '.$this->tanggal($dataSearch[2]);
    //
    //   $pdf = \PDF::loadView('logbook.exportPdf', array('logbooks'=>$logbooks, 'namaFile'=>$namaFile))->setPaper('a4', 'landscape');
    //   return $pdf->download($namaFile.'.pdf');
    // }
    //
    // private function tanggal($tgl){
    //   if($tgl==""){
    //     return '';
    //   }
    //   $tgl = explode('-',$tgl);
    //   $bulan = '';
    //   switch($tgl[1]){
    //     case "01" : $bulan = "Januari"; break;
    //     case "02" : $bulan = "Februari"; break;
    //     case "03" : $bulan = "Maret"; break;
    //     case "04" : $bulan = "April"; break;
    //     case "05" : $bulan = "Mei"; break;
    //     case "06" : $bulan = "Juni"; break;
    //     case "07" : $bulan = "Juli"; break;
    //     case "08" : $bulan = "Agustus"; break;
    //     case "09" : $bulan = "September"; break;
    //     case "10" : $bulan = "Oktober"; break;
    //     case "11" : $bulan = "November"; break;
    //     case "12" : $bulan = "Desember"; break;
    //   }
    //   return $tgl[2].' '.$bulan.' '.$tgl[0];
    // }
    // private function tambahPasien($request){
    //   $pasien = '';
    //   //simpan Pasien
    //   if($request->get('slugPasien')){
    //     //Edit Data pasien Baru
    //     $pasien = Pasien::where('slug',$request->get('slugPasien'))->firstOrFail();
    //     $pasien->nama = $request->get('nama');
    //     $pasien->alamat = $request->get('alamat');
    //     $pasien->tgl_lahir = $request->get('tgl_lahir');
    //     $pasien->tlp = $request->get('tlp');
    //     $pasien->id_bpjs = $request->get('id_bpjs');
    //     $pasien->kelas_bpjs = $request->get('kelas_bpjs');
    //     $pasien->save();
    //   }else{
    //     //Tambah Data Pasien Baru
    //
    //     // //Mencegah User nakal
    //     // if(Pasien::where('no_rm',$request->get('no_rm'))->count()){
    //     //     return redirect()->back()->with('msg','Jangan Nakal! Data Pasien Sudah ada');
    //     // }
    //
    //     $slugPasien = uniqid(null,true);
    //     $pasien = new Pasien(array(
    //       'slug' => $slugPasien,
    //       'nama' => $request->get('nama'),
    //       'no_rm' => $request->get('no_rm'),
    //       'alamat' => $request->get('alamat'),
    //       'tgl_lahir' => $request->get('tgl_lahir'),
    //       'tlp' => $request->get('tlp'),
    //       'id_bpjs' => $request->get('id_bpjs'),
    //       'kelas_bpjs' => $request->get('kelas_bpjs'),
    //     ));
    //     $pasien->save();
    //     // return redirect()->back()->with('msg', $pasien->id);
    //   }
    //   return $pasien;
    // }
}


// $db_ext = \DB::connection('sqlsrv');
// $jabatanCount = $db_ext->table('mPasien')->count();
// $limitJabatan = 80534;
// while($limitJabatan <= 103060){
//   $jabatan = $db_ext->table('mPasien')->offset($limitJabatan)->limit(10000)->get();
//   foreach($jabatan as $jab){
//     $slug = uniqid(null,true);
//     $pasien = new Pasien(array(
//       'slug' => $slug,
//       'nama' => $jab->NamaPasien,
//       'no_rm' => $jab->NRM,
//       'alamat' => $jab->Alamat,
//       'tgl_lahir' => $jab->TglLahir,
//       'tlp' => $jab->Phone,
//     ));
//     $pasien->save();
//   }
//   $limitJabatan += 10000;
// }
