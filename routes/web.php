<?php
Auth::routes();

Route::get('logout',array(
  'uses' => 'Auth\LoginController@logout'
));

Route::get('/',function(){
  return redirect('logbook');
});

Route::get('getPasienIndividual/{nrm}', array(
  'uses' => 'PasienController@getPasienIndividual',
  'middleware' => 'auth'
));
Route::get('cekPukulReservasi/{pukul}', array(
  'uses' => 'GeneralController@cekPukul',
  'middleware' => 'auth'
));

Route::get('suggestTime/{tgl_reservasi}', array(
  'uses' => 'GeneralController@suggestTime',
  'middleware' => 'auth'
));

Route::get('suggestTime/{tgl_reservasi}', array(
  'uses' => 'GeneralController@suggestTime',
  'middleware' => 'auth'
));

Route::get('changePassword', [
  'uses' => 'GeneralController@formChangePassword',
  'middleware' => 'auth'
]);
Route::post('changePassword', [
  'uses' => 'GeneralController@changePassword',
  'middleware' => 'auth'
]);

//Section logbook
Route::get('logbook', array(
  'uses' => 'LogbookController@showLogbook',
  'middleware' => 'menu_logbook'
));

Route::get('logbookrj', array(
  'uses' => 'LogbookController@showLogbookRJ',
  'middleware' => 'menu_logbook'
));

Route::get('getLogbook/{tahun}', array(
  'uses' => 'LogbookController@getLogbook',
  'middleware' => 'menu_logbook'
));

Route::get('getLogbookrj/{tahun}', array(
  'uses' => 'LogbookController@getLogbookRJ',
  'middleware' => 'menu_logbook'
));
//Akhir Section Logbook

//Section Upadana
Route::get('upadana', array(
  'uses' => 'UpadanaController@showUpadana',
  'middleware' => 'menu_upadana'
));
// Route::get('upadana/report', array(
//   'uses' => 'UpadanaController@showReport',
//   'middleware' => 'menu_upadana'
// ));
Route::get('getUpadana', array(
  'uses' => 'UpadanaController@getUpadana',
  'middleware' => 'menu_upadana'
));
Route::post('upadana/tambahReservasi', array(
  'uses' => 'UpadanaController@tambahUpadana',
  'middleware' => 'menu_upadana'
));
Route::post('upadana/{slug}/editReservasi', array(
  'uses' => 'UpadanaController@editUpadana',
  'middleware' => 'menu_upadana'
));
Route::get('upadana/{slug}/deleteUpadana', array(
  'uses' => 'UpadanaController@deleteUpadana',
  'middleware' => 'menu_upadana'
));
// Route::get('upadana/exportToExcel/{data}', array(
//   'uses' => 'UpadanaController@exportToExcel',
//   'middleware' => 'menu_upadana'
// ));
// Route::get('upadana/exportToPdf/{data}', array(
//   'uses' => 'UpadanaController@exportToPdf',
//   'middleware' => 'menu_upadana'
// ));
Route::get('upadana/{tanggal}/getAntrean', array(
  'uses' => 'UpadanaController@getAntrean',
  'middleware' => 'menu_upadana'
));
//Akhir Section Upadana

//Section Baby SPA
Route::get('babySPA', array(
  'uses' => 'BabySPAController@showBabySPA',
  'middleware' => 'menu_babyspa'
));
// Route::get('babySPA/report', array(
//   'uses' => 'BabySPAController@showReport',
//   'middleware' => 'menu_babyspa'
// ));
Route::get('getBabySPA', array(
  'uses' => 'BabySPAController@getBabySPA',
  'middleware' => 'menu_babyspa'
));
Route::post('babySPA/tambahBabySPA', array(
  'uses' => 'BabySPAController@tambahBabySPA',
  'middleware' => 'menu_babyspa'
));
Route::post('babySPA/{slug}/editBabySPA', array(
  'uses' => 'BabySPAController@editBabySPA',
  'middleware' => 'menu_babyspa'
));
Route::get('babySPA/{slug}/deleteBabySPA', array(
  'uses' => 'BabySPAController@deleteBabySPA',
  'middleware' => 'menu_babyspa'
));
// Route::get('babySPA/exportToExcel/{data}', array(
//   'uses' => 'BabySPAController@exportToExcel',
//   'middleware' => 'menu_babyspa'
// ));
// Route::get('babySPA/exportToPdf/{data}', array(
//   'uses' => 'BabySPAController@exportToPdf',
//   'middleware' => 'menu_babyspa'
// ));
//Akhir Section Baby SPA

//Section Klinik Laktasi
Route::get('klinikLaktasi', array(
  'uses' => 'KlinikLaktasiController@showKlinikLaktasi',
  'middleware' => 'menu_kliniklaktasi'
));
// Route::get('klinikLaktasi/report', array(
//   'uses' => 'KlinikLaktasiController@showReport',
//   'middleware' => 'menu_kliniklaktasi'
// ));
Route::get('getKlinikLaktasi', array(
  'uses' => 'KlinikLaktasiController@getKlinikLaktasi',
  'middleware' => 'menu_kliniklaktasi'
));
Route::post('klinikLaktasi/tambahKlinikLaktasi', array(
  'uses' => 'KlinikLaktasiController@tambahKlinikLaktasi',
  'middleware' => 'menu_kliniklaktasi'
));
Route::post('klinikLaktasi/{slug}/editKlinikLaktasi', array(
  'uses' => 'KlinikLaktasiController@editKlinikLaktasi',
  'middleware' => 'menu_kliniklaktasi'
));
Route::get('klinikLaktasi/{slug}/deleteKlinikLaktasi', array(
  'uses' => 'KlinikLaktasiController@deleteKlinikLaktasi',
  'middleware' => 'menu_kliniklaktasi'
));
// Route::get('klinikLaktasi/exportToExcel/{data}', array(
//   'uses' => 'KlinikLaktasiController@exportToExcel',
//   'middleware' => 'menu_kliniklaktasi'
// ));
// Route::get('klinikLaktasi/exportToPdf/{data}', array(
//   'uses' => 'KlinikLaktasiController@exportToPdf',
//   'middleware' => 'menu_kliniklaktasi'
// ));
//Akhir Section Klinik Laktasi

//Section Radiologi
Route::get('radiologi', array(
  'uses' => 'RadiologiController@showRadiologi',
  'middleware' => 'menu_radiologi'
));
// Route::get('radiologi/report', array(
//   'uses' => 'RadiologiController@showReport',
//   'middleware' => 'menu_radiologi'
// ));
Route::get('getRadiologi', array(
  'uses' => 'RadiologiController@getRadiologi',
  'middleware' => 'menu_radiologi'
));
Route::post('radiologi/tambahRadiologi', array(
  'uses' => 'RadiologiController@tambahRadiologi',
  'middleware' => 'menu_radiologi'
));
Route::post('radiologi/{slug}/editRadiologi', array(
  'uses' => 'RadiologiController@editRadiologi',
  'middleware' => 'menu_radiologi'
));
Route::get('radiologi/{slug}/deleteRadiologi', array(
  'uses' => 'RadiologiController@deleteRadiologi',
  'middleware' => 'menu_radiologi'
));
// Route::get('radiologi/exportToExcel/{data}', array(
//   'uses' => 'RadiologiController@exportToExcel',
//   'middleware' => 'menu_radiologi'
// ));
// Route::get('radiologi/exportToPdf/{data}', array(
//   'uses' => 'RadiologiController@exportToPdf',
//   'middleware' => 'menu_radiologi'
// ));
//Akhir Section Radiologi

//Section Ecnocardiography
Route::get('ecnocardiography', array(
  'uses' => 'EcnocardiographyController@showEcnocardiography',
  'middleware' => 'menu_echocardiography'
));
// Route::get('ecnocardiography/report', array(
//   'uses' => 'EcnocardiographyController@showReport',
//   'middleware' => 'menu_echocardiography'
// ));
Route::get('getEcnocardiography', array(
  'uses' => 'EcnocardiographyController@getEcnocardiography',
  'middleware' => 'menu_echocardiography'
));
Route::post('ecnocardiography/tambahEcnocardiography', array(
  'uses' => 'EcnocardiographyController@tambahEcnocardiography',
  'middleware' => 'menu_echocardiography'
));
Route::post('ecnocardiography/{slug}/editEcnocardiography', array(
  'uses' => 'EcnocardiographyController@editEcnocardiography',
  'middleware' => 'menu_echocardiography'
));
Route::get('ecnocardiography/{slug}/deleteEcnocardiography', array(
  'uses' => 'EcnocardiographyController@deleteEcnocardiography',
  'middleware' => 'menu_echocardiography'
));
// Route::get('ecnocardiography/exportToExcel/{data?}', array(
//   'uses' => 'EcnocardiographyController@exportToExcel',
//   'middleware' => 'menu_echocardiography'
// ));
// Route::get('ecnocardiography/exportToPdf/{data}', array(
//   'uses' => 'EcnocardiographyController@exportToPdf',
//   'middleware' => 'menu_echocardiography'
// ));
//Akhir Section Ecnocardiography

//Panel Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function(){

  Route::get('userlogs', [
    'uses' => 'UserRegistrasi@userlog',
  ]);

  Route::get('user', [
    'uses' => 'UserRegistrasi@showUser',
  ]);
  Route::get('tambah/user', [
    'uses' => 'UserRegistrasi@formTambahUser',
  ]);
  Route::post('tambah/user', [
    'uses' => 'UserRegistrasi@tambahUser',
  ]);
  Route::get('edit/user/{id}', [
    'uses' => 'UserRegistrasi@formEditUser',
  ]);
  Route::post('edit/user/{id}', [
    'uses' => 'UserRegistrasi@editUser',
  ]);
  Route::get('delete/user/{id}', [
    'uses' => 'UserRegistrasi@deleteUser',
  ]);
  Route::get('getUser', [
    'uses' => 'UserRegistrasi@getUser',
  ]);

  Route::get('permission', [
    'uses' => 'PermissionController@showPermission',
  ]);
  Route::post('tambah/permission', [
    'uses' => 'PermissionController@tambahPermission',
  ]);
  Route::get('getPermission', [
    'uses' => 'PermissionController@getPermission',
  ]);

  Route::get('role', [
    'uses' => 'RoleController@showRole',
  ]);

  Route::get('tambah/role', [
    'uses' => 'RoleController@formTambahRole',
  ]);
  Route::get('edit/role/{id}', [
    'uses' => 'RoleController@formEditRole',
  ]);

  Route::post('tambah/role', [
    'uses' => 'RoleController@tambahRole',
  ]);
  Route::post('edit/role/{id}', [
    'uses' => 'RoleController@editRole',
  ]);
  Route::get('delete/role/{id}', [
    'uses' => 'RoleController@deleteRole',
  ]);
  Route::get('getRole', [
    'uses' => 'RoleController@getRole',
  ]);
});

// Section Pasien
Route::get('pasien',array(
  'uses' => 'PasienController@showPasien',
  'middleware' => 'menu_master'
));
Route::post('pasien/tambahPasien',array(
  'uses' => 'PasienController@tambahPasien',
  'middleware' => 'menu_master'
));
Route::post('pasien/{slug?}/editPasien',array(
  'uses' => 'PasienController@editPasien',
  'middleware' => 'menu_master'
));
Route::get('pasien/{slug?}/deletePasien',array(
  'uses' => 'PasienController@deletePasien',
  'middleware' => 'menu_master'
));
Route::get('getPasien',array(
  'uses' => 'PasienController@getPasien',
  'middleware' => 'menu_master'
));
// Akhir Section Pasien


//Section Penomoran
Route::get('nomorbpjs', array(
  'uses' => 'PenomoranController@showPenomoran',
  'middleware' => 'menu_penomoran'
));
Route::get('getPenomoran', array(
  'uses' => 'PenomoranController@getPenomoran',
  'middleware' => 'menu_penomoran'
));
Route::post('penomoran/tambahPenomoran', array(
  'uses' => 'PenomoranController@tambahPenomoran',
  'middleware' => 'menu_penomoran'
));
Route::post('penomoran/{id}/editPenomoran', array(
  'uses' => 'PenomoranController@editPenomoran',
  'middleware' => 'menu_penomoran'
));
Route::get('penomoran/{id}/deletePenomoran', array(
  'uses' => 'PenomoranController@deletePenomoran',
  'middleware' => 'menu_penomoran'
));
//Akhir Section Penomoran

//Section Kamar
// Route::get('kamar',array(
//   'uses' => 'KamarController@showKamar',
// ));
// Route::post('kamar/tambahKamar', array(
//   'uses' => 'KamarController@tambahKamar',
// ));
// Route::post('kamar/{slug?}/editKamar',array(
//   'uses' => 'KamarController@editKamar',
// ));
// Route::get('kamar/{slug?}/deleteKamar',array(
//   'uses' => 'KamarController@deleteKamar',
// ));
// Route::get('getKamar', array(
//   'uses' => 'KamarController@getKamar',
// ));
// Route::get('getKamarDanNomorKamar', array(
//   'uses' => 'KamarController@getKamarDanNomorKamar',
// ));
//Akhir Section Kamar

//Section Paket
// Route::get('paket', array(
//   'uses' => 'PaketController@showPaket',
// ));
// Route::post('paket/tambahPaket', array(
//   'uses' => 'PaketController@tambahPaket',
// ));
// Route::post('paket/{slug?}/editPaket',array(
//   'uses' => 'PaketController@editPaket',
// ));
// Route::get('paket/{slug?}/deletePaket', array(
//   'uses' => 'PaketController@deletePaket',
// ));
// Route::get('getPaket', array(
//   'uses' => 'PaketController@getPaket',
// ));
//Akhir Section Paket

//Section No Kamar
// Route::get('nokamar', array(
//   'uses' => 'NoKamarController@showNoKamar',
// ));
// Route::post('nokamar/tambahNoKamar',array(
//   'uses' => 'NoKamarController@tambahNoKamar',
// ));
// Route::post('nokamar/{slug?}/editNoKamar', array(
//   'uses' => 'NoKamarController@editNoKamar',
// ));
// Route::get('nokamar/{slug?}/deleteNoKamar', array(
//   'uses' => 'NoKamarController@deleteNoKamar',
// ));
// Route::get('getNoKamar', array(
//   'uses' => 'NoKamarController@getNoKamar',
// ));
//Akhir section No Kamar
// Route::get('logbook/tambahLogbook', array(
//   'uses' => 'LogbookController@tambahLogbookForm'
// ));
// Route::post('logbook/tambahLogbook', array(
//   'uses' => 'LogbookController@tambahLogbook',
// ));
// Route::get('logbook/{slug}/editLogbook', array(
//   'uses' => 'LogbookController@editLogbookForm'
// ));
// Route::post('logbook/{slug}/editLogbook', array(
//   'uses' => 'LogbookController@editLogbook'
// ));
// Route::get('logbook/{slug?}/deleteLogbook', array(
//   'uses' => 'LogbookController@deleteLogbook',
// ));
// Route::get('reportlogbook', array(
//   'uses' => 'LogbookController@showReport',
// ));
// Route::get('exportToExcel/{searchCheckOut?}', array(
//   'uses' => 'LogbookController@exportToExcel',
// ));
//
// Route::get('exportToPdf/{searchCheckOut?}', array(
//   'uses' => 'LogbookController@exportToPdf',
// ));
//Akhir Section logbook

// Route::get('test', array(
//   'uses' => 'PenomoranController@getNomorRujukan'
// ));
