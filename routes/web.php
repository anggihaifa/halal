<?php

Route::get('','HomeController@home')->name('home.index');
Route::get('home','HomeController@index')->name('home.index');


//user management
Route::get('login','Auth\LoginController@login')->name("login");
Route::get('register','Auth\RegisterController@registerUser')->name('registeruser');
Route::post('register_store','Auth\RegisterController@store')->name('register.store');
Route::get('user/verify/{id}','Auth\RegisterController@verifyUser')->name('register.verifyuser');


//reset password
Route::get('forgot_password','Auth\RegisterController@forgotPassword')->name('forgotpassword');
Route::post('send_reset_password','Auth\RegisterController@sendResetPassword')->name('sendresetpassword');
Route::get('reset_password/{token}','Auth\RegisterController@resetPassword');
Route::put('store_new_password/{id}','Auth\RegisterController@storeNewPassword')->name('storenewpassword');

Route::get('change_password','Auth\LoginController@change_password')->name('change_password');
Route::post('change_password','Auth\LoginController@store_change_password')->name('change_password.store');
Route::post('login','Auth\LoginController@authenticate')->name("authenticate");
Route::get('logout','Auth\LoginController@logout')->name("logout");


//registrasi
Route::resource('registrasiHalal','RegistrasiController');
Route::get('registrasiHalal_datatable','RegistrasiController@registrasiDatatable')->name('registrasi.datatable');
Route::get('detail_registrasi/{id}','RegistrasiController@detailRegistrasi');
Route::get('activate_registrasi/{token}','RegistrasiController@activeRegistrasi');

//list registrasi pelanggan
Route::get('list_registrasi_pelanggan','RegistrasiController@listRegistrasiPelanggan')->name('listregistrasipelanggan');
Route::get('data_registrasi_pelanggan','RegistrasiController@dataRegistrasiPelanggan')->name('dataregistrasipelanggan');
//list registrasi pelanggan aktif
Route::get('list_registrasi_pelanggan_aktif','RegistrasiController@listRegistrasiPelangganAktif')->name('listregistrasipelangganaktif');
Route::get('data_registrasi_pelanggan_aktif','RegistrasiController@dataRegistrasiPelangganAktif')->name('dataregistrasipelangganaktif');
//

Route::get('update_status_registrasi/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusRegistrasi');

Route::get('data_registrasi_pelanggan_bayar','RegistrasiController@dataRegistrasiPelangganBayar')->name('dataregistrasipelangganbayar');


//view email design
Route::get('view_email','RegistrasiController@viewEmail')->name('view.email');


//list konfirmasi pembayaran
Route::get('list_pembayaran_registrasi','RegistrasiController@listPembayaranRegistrasi')->name('listpembayaranregistrasi');
Route::get('data_pembayaran_registrasi','RegistrasiController@dataPembayaranRegistrasi')->name('datapembayaranregistrasi');
Route::get('konfirmasi_pembayaran_registrasi/{id}','RegistrasiController@konfirmasiPembayaranRegistrasi');


//pembayaran registrasi
Route::get('pembayaran_registrasi/{id}','RegistrasiController@pembayaranRegistrasi')->name('registrasi.pembayaranRegistrasi');
Route::put('konfirmasi_pembayaran/{id}','RegistrasiController@konfirmasiPembayaran')->name('registrasi.konfirmasipembayaran');
Route::get('download','RegistrasiController@download');


//unggah data sertifikasi - uds
Route::get('unggahDataSertifikasi','RegistrasiController@unggahDataSertifikasi')->name('registrasi.unggahDataSertifikasi');
Route::get('list_unggah_data_sertifikasi','RegistrasiController@listUnggahDataSertifikasi')->name('listunggahdatasertifikasi');
Route::get('get_data_registrasi','RegistrasiController@getDataRegistrasi')->name('getdataregistrasi');
Route::get('detail_unggah_data_sertifikasi/{id_registrasi}','RegistrasiController@detailUnggahDataSertifikasi')->name('detailunggahdatasertifikasi');

Route::get('data_fasilitas/{id_registrasi}','RegistrasiController@dataFasilitas');
Route::get('data_produk/{id_registrasi}','RegistrasiController@dataProduk');
Route::get('data_kantor_pusat/{id_registrasi}','RegistrasiController@dataKantorPusat');
Route::get('data_menu_restoran/{id_registrasi}','RegistrasiController@dataMenuRestoran');
Route::get('data_jagal/{id_registrasi}','RegistrasiController@dataJagal');
Route::get('data_material/{id_registrasi}','RegistrasiController@dataMaterial');

//detail tiap list
Route::get('fasilitas_detail/{id_registrasi}/{id}','RegistrasiController@fasilitasDetail')->name('fasilitas.detail');
Route::get('kantor_pusat_detail/{id_registrasi}/{id}','RegistrasiController@kantorPusatDetail')->name('kantorpusat.detail');
Route::get('material_detail/{id_registrasi}/{id}','RegistrasiController@materialDetail')->name('material.detail');
Route::get('jagal_detail/{id_registrasi}/{id}','RegistrasiController@jagalDetail')->name('jagal.detail');


//fasilitas
Route::get('list_fasilitas','RegistrasiController@listFasilitas')->name('listfasilitas');
Route::get('tambah_fasilitas','RegistrasiController@createFasilitas')->name('tambahfasilitas');
Route::post('store_fasilitas','RegistrasiController@storeFasilitas')->name("storefasilitas");
Route::get('detail_fasilitas/{id}','RegistrasiController@detailFasilitas')->name('detailfasilitas');
Route::get('edit_fasilitas/{id}','RegistrasiController@editFasilitas')->name('editfasilitas');
Route::put('update_fasilitas/{id}','RegistrasiController@updateFasilitas')->name('updatefasilitas');


//kantor pusat
Route::get('list_kantor_pusat','RegistrasiController@listKantorPusat')->name('listkantorpusat');
Route::get('tambah_kantor_pusat','RegistrasiController@createKantorPusat')->name('tambahkantorpusat');
Route::post('store_kantor_pusat','RegistrasiController@storeKantorPusat')->name("storekantorpusat");
Route::get('detail_kantor_pusat/{id}','RegistrasiController@detailKantorPusat')->name('detailkantorpusat');
Route::get('edit_kantor_pusat/{id}','RegistrasiController@editKantorPusat')->name('editkantorpusat');
Route::put('update_kantor_pusat/{id}','RegistrasiController@updateKantorPusat')->name('updatekantorpusat');    


//menu restoran
Route::get('list_menu_restoran','RegistrasiController@listMenuRestoran')->name('listmenurestoran');
Route::get('tambah_menu_restoran','RegistrasiController@createMenuRestoran')->name('tambahmenurestoran');
Route::post('store_menu_restoran','RegistrasiController@storeMenuRestoran')->name("storemenurestoran");
Route::get('detail_menu_restoran/{id}','RegistrasiController@detailMenuRestoran')->name('detailmenurestoran');
Route::get('edit_menu_restoran/{id}','RegistrasiController@editMenuRestoran')->name('editmenurestoran');
Route::put('update_menu_restoran/{id}','RegistrasiController@updateMenuRestoran')->name('updatemenurestoran');


//jagal
Route::get('list_jagal','RegistrasiController@listJagal')->name('listjagal');
Route::get('tambah_jagal','RegistrasiController@createJagal')->name('tambahjagal');
Route::post('store_jagal','RegistrasiController@storeJagal')->name("storejagal");
Route::get('detail_jagal/{id}','RegistrasiController@detailJagal')->name('detailjagal');
Route::get('edit_jagal/{id}','RegistrasiController@editJagal')->name('editjagal');
Route::put('update_jagal/{id}','RegistrasiController@updateJagal')->name('updatejagal');


//produk
Route::get('list_produk','RegistrasiController@listProduk')->name('listproduk');
Route::get('tambah_produk','RegistrasiController@createProduk')->name('tambahproduk');
Route::post('store_produk','RegistrasiController@storeProduk')->name("storeproduk");
Route::get('edit_produk/{id}','RegistrasiController@editProduk')->name('editproduk');
Route::put('update_produk/{id}','RegistrasiController@updateProduk')->name('updateproduk');
//dokumen has
Route::post('store_dokumen_has','RegistrasiController@storeDokumenHas')->name("storedokumenhas");
Route::get('delete_dokumen_has/{id}','RegistrasiController@deleteDokumenHas')->name('deletedokumenhas');
Route::get('detail_dokumen_has_pelanggan/{id}','RegistrasiController@detailDokumenHasPelanggan')->name('detaildokumenhas.pelanggan');
//Route::get('update_status_has/{registrasi}/{id}/{name}/{status}','RegistrasiController@updateStatusHas');
Route::put('update_status_has/{id}','RegistrasiController@updateStatusHas')->name('updatestatushas');



//material
Route::get('list_material','RegistrasiController@listMaterial')->name('listmaterial');
Route::get('tambah_material','RegistrasiController@createMaterial')->name('tambahmaterial');
Route::post('store_material','RegistrasiController@storeMaterial')->name("storematerial");
Route::get('edit_material/{id}','RegistrasiController@editMaterial')->name('editmaterial');
Route::put('update_material/{id}','RegistrasiController@updateMaterial')->name('updatematerial');
Route::get('detail_material/{id}','RegistrasiController@detailMaterial')->name('detailmaterial');


//dokumen matriks produk
Route::post('store_matriks_produk','RegistrasiController@storeMatriksProduk')->name("storematriksproduk");
Route::get('delete_matriks_produk/{id}','RegistrasiController@deleteMatriksProduk')->name('deletematriksproduk');
Route::get('list_matriks_pelanggan','RegistrasiController@listMatriksPelanggan')->name('listmatriks.pelanggan');
Route::get('data_matriks_pelanggan','RegistrasiController@dataMatriksPelanggan')->name('datamatriks.pelanggan');
Route::get('detail_matriks_pelanggan/{id}','RegistrasiController@detailmatriksPelanggan')->name('detailmatriks.pelanggan');


//kuisioner has
Route::post('store_kuisioner_has','RegistrasiController@storeKuisionerHas')->name("storekuisionerhas");
Route::get('delete_kuisioner_has/{id}','RegistrasiController@deleteKuisionerHas')->name('deletekuisionerhas');
Route::get('detail_kuisioner_pelanggan/{id}','RegistrasiController@detailKuisionerHasPelanggan')->name('detailkuisionerhas.pelanggan');

Route::get('detailRegistrasi','RegistrasiController@detailRegistrasi')->name('registrasi.detailRegistrasi');
Route::get('pembayaranAkad','RegistrasiController@pembayaranAkad')->name('registrasi.pembayaranAkad');
Route::get('penjadualanAudit','RegistrasiController@penjadualanAudit')->name('registrasi.penjadualanAudit');
Route::get('dokumenTravel','RegistrasiController@dokumenTravel')->name('registrasi.dokumenTravel');


//master
Route::prefix('master')->group(function (){

    Route::resource('jenis_registrasi','Master\JenisRegistrasiController');
    Route::get('jenis_registrasi_datatable','Master\JenisRegistrasiController@datatable')->name('master.jenisregistrasi.datatable');
    
    Route::resource('kelompok_produk','Master\KelompokProdukController');
    Route::get('kelompok_produk_datatable','Master\KelompokProdukController@datatable')->name('master.kelompokproduk.datatable');

    Route::resource('faq','Master\FaqController');
    Route::get('master/faq/faq_datatable','Master\FaqController@datatable')->name('master.faq.datatable');
});
Route::get('faq_detail/{id}','Master\FaqController@faqDetail')->name('master.faq.detail');


//user management
Route::prefix('system')->group(function(){

    Route::resource('user','System\UserController');
    Route::get('user_datatable','System\UserController@datatable')->name('system.user.datatable');
    Route::get('list_pelanggan','System\UserController@listPelanggan')->name('user.listpelanggan');
    Route::get('pelanggan_datatable','System\UserController@dataPelanggan')->name('system.pelanggan.datatable');

    Route::get('edit_profile/{id}','System\UserController@editProfile')->name('system.user.editprofile');
    Route::post('update_profile','System\UserController@updateProfile')->name('system.user.updateprofile');

    Route::get('change_password/{id}','System\UserController@change_Password')->name('system.user.change_password');
    Route::post('update_password','System\UserController@updatePassword')->name('system.user.updatepassword');


    Route::resource('usergroup','System\UserGroupController');
    Route::get('usergroup_datatable','System\UserGroupController@datatable')->name('system.usergroup.datatable');

    Route::resource('log','System\LogController');
    Route::get('log_datatable','System\LogController@datatable')->name('system.log.datatable');

});