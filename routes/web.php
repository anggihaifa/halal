<?php

Route::get('','LandingPageController@index')->name('landingpage.index');
Route::get('home','HomeController@index')->name('home.index');
Route::get('main','LandingPageController@index')->name('landingpage.index');
Route::get('cari_produk','LandingPageController@cariProduk')->name('landingpage.cariproduk');
// Route::get('home','HomeController@landingPage')->name('home.landingpage');

Route::get('report','ReportController@index')->name('report.index');

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

//penjadwalan
Route::get('list_penjadwalan_admin','PenjadwalanController@listpenjadwalanAdmin')->name('listpenjadwalanadmin');
Route::get('data_penjadwalan_admin','PenjadwalanController@dataPenjadwalanAdmin')->name('datapenjadwalanadmin');

Route::post('detail_auditor', 'PenjadwalanController@detail')->name('detail_auditor.detail');
Route::post('dropdown1', 'PenjadwalanController@dataAuditor1')->name('dropdown1.dataauditor');
Route::post('jenis_akomodasi', 'PenjadwalanController@jenisAkomodasi')->name('jenis_akomodasi.data');
Route::post('opsi_akomodasi', 'PenjadwalanController@opsiAkomodasi')->name('opsi_akomodasi.data');
Route::post('dropdown2', 'PenjadwalanController@dataAuditor2')->name('dropdown2.dataauditor');
Route::post('auditor_dropdown', 'PenjadwalanController@dataRapatAuditor')->name('auditor_dropdown.datarapatauditor');
Route::post('komite_dropdown', 'PenjadwalanController@dataKomite')->name('komite_dropdown.datakomite');
Route::put('audit1', 'PenjadwalanController@audit1')->name('audit1');
Route::put('audit2', 'PenjadwalanController@audit2')->name('audit2');
Route::put('rapat', 'PenjadwalanController@rapat')->name('rapat');
Route::put('tinjauan', 'PenjadwalanController@tinjauan')->name('tinjauan');



Route::get('update_status_pembayaran/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPembayaran');

Route::put('update_status_lebih/{id}','RegistrasiController@updateStatusLebih')->name('registrasi.uploadlebih');

Route::put('update_status_kurang/{id}','RegistrasiController@updateStatusKurang')->name('registrasi.uploadkurang');

Route::get('update_status_pembayaran_tahap2/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPembayaranTahap2');

Route::get('update_status_akad/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusAkad');
Route::get('update_status_pelunasan/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPelunasan');
//
Route::get('update_status_akad_review/{id}/{id_user}/{status}/{id_akad}/{catatan}','ReviewerController@updateStatusAkad');
Route::get('konfirmasi_akad_reviewer/{id}/{id_akad}','ReviewerController@konfirmasiAkadReviewer');

Route::get('update_status_akad_approve/{id}/{id_user}/{status}/{id_akad}/{catatan}','ReviewerController@updateStatusAkad2');
Route::get('konfirmasi_akad_approver/{id}/{id_akad}','ReviewerController@konfirmasiAkadReviewer2');
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
Route::put('konfirmasi_pembayaran/{id}','RegistrasiController@konfirmasiPembayaranUser')->name('registrasi.konfirmasipembayaran');
Route::get('download','RegistrasiController@download');


//pembayaran tahap 2
Route::get('list_pembayaran_tahap2','RegistrasiController@listPembayaranTahap2')->name('listpembayarantahap2');
Route::get('data_pembayaran_Tahap2','RegistrasiController@dataPembayaranTahap2')->name('datapembayarantahap2');
Route::get('konfirmasi_pembayaran_tahap2/{id}','RegistrasiController@konfirmasiPembayaranTahap2');


//pembayaran tahap 2
Route::get('pembayaran_tahap2/{id}','RegistrasiController@pembayaranTahap2')->name('registrasi.pembayarantahap2');
Route::put('konfirmasi_pembayaran_user_tahap2/{id}','RegistrasiController@konfirmasiPembayaranUserTahap2')->name('registrasi.konfirmasipembayaranusertahap2');

//report
Route::get('report_audit/{id}','RegistrasiController@reportAudit')->name('registrasi.reportaudit');
Route::get('report_berita_acara/{id}','RegistrasiController@reportBeritaAcara')->name('registrasi.reportberitaacara');
// Route::get('upload_kontrak_akad_user/{id}','RegistrasiController@uploadAkadUser')->name('registrasi.uploadakaduser');

//list konfirmasi pelunasan
Route::get('list_pelunasan','RegistrasiController@listPelunasan')->name('listpelunasan');
Route::get('data_pelunasan','RegistrasiController@dataPelunasan')->name('datapelunasan');
Route::put('konfirmasi_pelunasan_admin/{id}','RegistrasiController@konfirmasiPelunasanInvoiceAdmin')->name('registrasi.konfirmasiinvoice');;

//pelunasan
Route::get('pelunasan/{id}','RegistrasiController@pelunasan')->name('registrasi.pelunasan');
Route::put('konfirmasi_pelunasan_user/{id}','RegistrasiController@konfirmasiPelunasanUser')->name('registrasi.konfirmasipelunasanuser');

Route::get('upload_invoice/{id}','RegistrasiController@uploadInvoice')->name('registrasi.uploadinvoice');

Route::get('lebih/{id}/{tahap}','RegistrasiController@lebih')->name('registrasi.lebih');
Route::get('kurang/{id}/{tahap}','RegistrasiController@kurang')->name('registrasi.kurang');


Route::put('upload_file_invoice/{id}','RegistrasiController@uploadFileInvoice')->name('registrasi.uploadfileinvoice');
//Route::get('download','RegistrasiController@download');
//Route::get('unduh_bukti_bayar/{id}','RegistrasiController@unduhBuktiBayar');


//Akad
//reviewer dan approver
Route::get('list_akad_reviewer','ReviewerController@listAkadReviewer')->name('listakadreviewer');
Route::get('data_akad_reviewer','ReviewerController@dataAkadReviewer')->name('dataakadreviewer');
Route::get('list_penjadwalan_reviewer','ReviewerController@listPenjadwalanReviewer')->name('listpenjadwalanreviewer');
Route::get('list_pelunasan_reviewer','ReviewerController@listPelunasanReviewer')->name('listpelunasanreviewer');

Route::get('list_akad_approver','ReviewerController@listAkadApprover')->name('listakadapprover');
Route::get('data_akad_approver','ReviewerController@dataAkadApprover')->name('dataakadapprover');

//admin
Route::get('list_akad_admin','RegistrasiController@listAkadAdmin')->name('listakadadmin');
Route::get('data_akad_admin','RegistrasiController@dataAkadAdmin')->name('dataakadadmin');
Route::get('upload_kontrak_akad_admin/{id}','RegistrasiController@uploadAkadAdmin')->name('registrasi.uploadakadadmin');
Route::put('upload_file_akad_admin/{id}','RegistrasiController@uploadFileAkadAdmin')->name('registrasi.uploadfileakadadmin');
Route::get('konfirmasi_akad_admin/{id}/{status}','RegistrasiController@konfirmasiAkadAdmin');

Route::put('acc_audit_admin/{id}','RegistrasiController@accAuditAdmin')->name('registrasi.accauditadmin');
Route::put('acc_berita_acara_admin/{id}','RegistrasiController@accBeritaAcaraAdmin')->name('registrasi.accberitaacaraadmin');

Route::get('upload_report_admin/{id}','RegistrasiController@uploadReportAdmin')->name('registrasi.uploadreportadmin');
Route::put('upload_file_report_admin/{id}','RegistrasiController@uploadFileReportAdmin')->name('registrasi.uploadfilereportadmin');
Route::get('upload_berita_acara_admin/{id}','RegistrasiController@uploadBeritaAcaraAdmin')->name('registrasi.uploadberitaacaraadmin');
Route::put('upload_file_berita_acara_admin/{id}','RegistrasiController@uploadFileBeritaAcaraAdmin')->name('registrasi.uploadfileberitaacaraadmin');
Route::get('kirim_ke_mui/{id}','RegistrasiController@kirimKeMUI')->name('registrasi.kirimkemui');
Route::put('upload_file_mui/{id}','RegistrasiController@uploadFileMUI')->name('registrasi.uploadfilemui');

Route::get('list_berita_acara','RegistrasiController@listBeritaAcara')->name('listberitaacara');
Route::get('data_berita_acara_admin','RegistrasiController@dataBeritaAcaraAdmin')->name('databeritaacaraadmin');
// Route::get('list_berita_acara2','RegistrasiController@listBeritaAcara2')->name('listberitaacara2');
// Route::get('data_berita_acara_admin2','RegistrasiController@dataBeritaAcaraAdmin2')->name('databeritaacaraadmin2');

//user
Route::get('upload_kontrak_akad_user/{id}','RegistrasiController@uploadAkadUser')->name('registrasi.uploadakaduser');
Route::put('upload_file_akad_user/{id}','RegistrasiController@uploadFileAkadUser')->name('registrasi.uploadfileakaduser');


//akad registrasi
//Route::get('Akad_registrasi/{id}','RegistrasiController@akadRegistrasi')->name('registrasi.akadRegistrasi');




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


    Route::resource('akomodasi','\App\Http\Controllers\Master\AkomodasiController');
    Route::get('akomodasi_datatable','Master\AkomodasiController@datatable')->name('master.akomodasi.datatable');

    Route::get('akomodasi/delete/{id}/{jenis_akomodasi}', [
    'as' => 'destroy', 
    'uses' => 'Master\AkomodasiController@destroy'
    ]);

    Route::get('akomodasi/update/{id}', [
    'as' => 'update', 
    'uses' => 'Master\AkomodasiController@update'
    ]);

    Route::get('akomodasi/edit/{id}/{jenis_akomodasi}', [
    'as' => 'edit', 
    'uses' => 'Master\AkomodasiController@edit'
    ]);

    Route::get('faq_user','Master\FaqController@user')->name('faquser');

    Route::resource('guideline','Master\GuidelineController');

    Route::resource('berita','Master\BeritaController');
    Route::resource('editberita','Master\EditBeritaController');
    Route::get('data_berita','Master\BeritaController@dataBerita')->name('master.databerita');
    Route::post('upload_image','Master\BeritaController@uploadImage')->name('master.uploadimage');
        
    // Route::get('upload_kontrak_akad_admin/{id}','RegistrasiController@uploadAkadAdmin')->name('registrasi.uploadakadadmin');
});
Route::get('faq_detail/{id}','Master\FaqController@faqDetail')->name('master.faq.detail');
Route::get('detail_berita/{id}','Master\BeritaController@detailBerita')->name('master.berita.detailberita');
Route::get('detail_berita_user/{id}','Master\BeritaController@detailBeritaUser')->name('master.berita.detailberitauser');
Route::get('acc_berita/{id}','Master\BeritaController@accBerita')->name('master.berita.accberita');
Route::get('cari_berita','Master\BeritaController@cariBerita')->name('master.berita.cariberita');

Route::get('informasi_panduan','InformasiController@panduan')->name('informasipanduan');
Route::get('informasi_alur','InformasiController@alur')->name('informasialur');

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

    Route::get('dependent_dropdown', 'DependentDropdownController@index')->name('dependent_dropdown.index');
    Route::post('dependent_dropdown', 'DependentDropdownController@store')->name('dependent_dropdown.store');

});