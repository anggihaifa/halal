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
Route::resource('registrasiHalal','RegistrasiController')->middleware('role:1,2,3');
Route::get('registrasiHalal_datatable','RegistrasiController@registrasiDatatable')->name('registrasi.datatable')->middleware('role:1,2,3');
Route::get('detail_registrasi/{id}','RegistrasiController@detailRegistrasi')->middleware('role:1,2,3');
Route::get('activate_registrasi/{token}','RegistrasiController@activeRegistrasi')->middleware('role:1,2,3');

//list registrasi pelanggan
Route::get('list_registrasi_pelanggan','RegistrasiController@listRegistrasiPelanggan')->name('listregistrasipelanggan')->middleware('role:1,3');
Route::get('data_registrasi_pelanggan','RegistrasiController@dataRegistrasiPelanggan')->name('dataregistrasipelanggan')->middleware('role:1,3');
//list registrasi pelanggan aktif
Route::get('list_registrasi_pelanggan_aktif','RegistrasiController@listRegistrasiPelangganAktif')->name('listregistrasipelangganaktif')->middleware('role:1,3');
Route::get('data_registrasi_pelanggan_aktif','RegistrasiController@dataRegistrasiPelangganAktif')->name('dataregistrasipelangganaktif')->middleware('role:1,3');

//phpword
Route::post('download_auditplan','PHPWordController@downloadAuditPlan')->name('downloadauditplan')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('upload_auditplan','PHPWordController@uploadAuditPlan')->name('uploadauditplan')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('download_auditplan_fix','PHPWordController@downloadAuditPlanFix')->name('downloadauditplanfix')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('download_laporan_audit_sjph','PHPWordController@downloadLaporanAuditSJPH')->name('downloadlaporanauditsjph')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('download_laporan_audit_bahan','PHPWordController@downloadLaporanAuditBahan')->name('downloadlaporanauditbahan')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('download_laporan_audit_sjph_fix','PHPWordController@downloadLaporanAuditSJPHFix')->name('downloadlaporanauditsjphfix')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('download_laporan_audit_bahan_fix','PHPWordController@downloadLaporanAuditBahanFix')->name('downloadlaporanauditbahanfix')->middleware('role:1,3,6,9,10,11,12,13');

Route::post('download_data','PHPWordController@download')->name('downloaddata');
Route::post('download_laporan_audit_2','PHPWordController@downloadLaporanAudit2')->name('downloadlaporanaudit2');
Route::post('download_laporan_audit_tahap2_fix','PHPWordController@downloadLaporanAuditTahap2Fix')->name('downloadlaporanaudittahap2fix');
Route::post('download_laporan_audit_tahap2_fix2','PHPWordController@downloadLaporanAuditTahap2Fix2')->name('downloadlaporanaudittahap2fix2');
Route::post('download_laporan_audit_fasilitas_produksi','PHPWordController@downloadLaporanAuditFasilitasProduk')->name('downloadlaporanauditfasilitasproduksi');
Route::post('download_laporan_audit_fasilitas_produksi_fix','PHPWordController@downloadLaporanAuditFasilitasProdukFix')->name('downloadlaporanauditfasilitasproduksifix');
Route::post('download_laporan_produk','PHPWordController@downloadLaporanProduk')->name('downloadlaporanproduk');
Route::post('download_laporan_produk_fix','PHPWordController@downloadLaporanProdukFix')->name('downloadlaporanprodukfix');

//verifikator kebutuhan waktu audit
Route::get('review_kebutuhan_waktu_audit','PenjadwalanController@reviewKebutuhanWaktuAudit')->name('reviewkebutuhanwaktuaudit');
Route::get('data_review_kebutuhan_waktu_audit','PenjadwalanController@dataReviewKebutuhanWaktuAudit')->name('datareviewkebutuhanwaktuaudit');
Route::put('store_review_kebutuhan_waktu_audit', 'PenjadwalanController@storeReviewKebutuhanWaktuAudit')->name('storereviewkebutuhanwaktuaudit');
Route::get('perbaikan_kebutuhan_waktu_audit', 'PenjadwalanController@perbaikanKebutuhanWaktuAudit')->name('perbaikankebutuhanwaktuaudit');


Route::get('list_kebutuhan_waktu_audit','PenjadwalanController@listKebutuhanWaktuAudit')->name('listkebutuhanwaktuaudit');
Route::get('data_kebutuhan_waktu_audit','PenjadwalanController@dataKebutuhanWaktuAudit')->name('datakebutuhanwaktuaudit');
Route::put('store_kebutuhan_waktu_audit', 'PenjadwalanController@storeKebutuhanWaktuAudit')->name('storekebutuhanwaktuaudit');
//penjadwalan
Route::get('list_penjadwalan_admin','PenjadwalanController@listpenjadwalanAdmin')->name('listpenjadwalanadmin')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('list_audit1','PenjadwalanController@listAudit1')->name('listaudit1')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('list_audit2','PenjadwalanController@listAudit2')->name('listaudit2')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('list_rapat','PenjadwalanController@listRapat')->name('listrapat')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('list_tinjauan','PenjadwalanController@listTinjauan')->name('listtinjauan')->middleware('role:1,3,6,9,10,11,12,13');

Route::get('list_log','PenjadwalanController@listLog')->name('listlog')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('data_log','PenjadwalanController@dataLog')->name('datalog')->middleware('role:1,3,6,9,10,11,12,13');

Route::get('data_penjadwalan_admin','PenjadwalanController@dataPenjadwalanAdmin')->name('datapenjadwalanadmin');
Route::get('data_audit1','PenjadwalanController@dataAudit1')->name('dataaudit1');
Route::get('data_audit2','PenjadwalanController@dataAudit2')->name('dataaudit2');
Route::get('data_rapat','PenjadwalanController@dataRapat')->name('datarapat');
Route::get('data_tinjauan','PenjadwalanController@dataTinjauan')->name('datatinjauan');


Route::get('audit_plan/{id}','PenjadwalanController@auditPlan')->name('auditplan')->middleware('role:1,3,6,9,10,11,12,13');
Route::get('laporan_audit/{id}','PenjadwalanController@laporanAudit')->name('laporanaudit')->middleware('role:1,3,6,9,10,11,12,13');

Route::post('detail_auditor', 'PenjadwalanController@detail')->name('detail_auditor.detail')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('dropdown1', 'PenjadwalanController@dataAuditor1')->name('dropdown1.dataauditor')->middleware('role:1,3,6,9,11');
Route::post('jenis_akomodasi', 'PenjadwalanController@jenisAkomodasi')->name('jenis_akomodasi.data')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('opsi_akomodasi', 'PenjadwalanController@opsiAkomodasi')->name('opsi_akomodasi.data')->middleware('role:1,3,6,9,10,11,12,13');
Route::post('dropdown2', 'PenjadwalanController@dataAuditor2')->name('dropdown2.dataauditor')->middleware('role:1,3,6,9,11');
Route::post('auditor_dropdown', 'PenjadwalanController@dataRapatAuditor')->name('auditor_dropdown.datarapatauditor')->middleware('role:1,3,6,9,11');
Route::post('komite_dropdown', 'PenjadwalanController@dataKomite')->name('komite_dropdown.datakomite')->middleware('role:1,3,6,9,11');
Route::put('audit1', 'PenjadwalanController@audit1')->name('audit1')->middleware('role:1,3,6,9,11');
Route::put('audit2', 'PenjadwalanController@audit2')->name('audit2')->middleware('role:1,3,6,9,11');
Route::put('rapat', 'PenjadwalanController@rapat')->name('rapat')->middleware('role:1,3,6,9,11');
Route::put('tinjauan', 'PenjadwalanController@tinjauan')->name('tinjauan')->middleware('role:1,3,6,9,11');

Route::get('penjadwalan_viewer/{id_regis}/{hpas}','PenjadwalanController@dokumenView')->name('penjadwalan.viewer')->middleware('role:1,3,6,9,10,11,12,13');

Route::get('penjadwalan_viewer_doc/{id_user}/{id_regis}/{hpas}','PenjadwalanController@view')->name('penjadwalan.view')->middleware('role:1,3,6,9,10,11,12,13');


////////////////End OF Penjadwalan

Route::get('update_status_pembayaran/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPembayaran')->middleware('role:1,3,5,7,9');

Route::put('update_status_lebih/{id}','RegistrasiController@updateStatusLebih')->name('registrasi.uploadlebih')->middleware('role:1,3,5,7,9');

Route::put('update_status_kurang/{id}','RegistrasiController@updateStatusKurang')->name('registrasi.uploadkurang')->middleware('role:1,3,5,7,9');

Route::get('update_status_pembayaran_tahap2/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPembayaranTahap2')->middleware('role:1,3,5,7,9');

Route::get('update_status_akad/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusAkad')->middleware('role:1,3,5,7,9');
Route::get('update_status_pelunasan/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusPelunasan')->middleware('role:1,3,5,7,9');
//
Route::get('update_status_akad_review/{id}/{id_user}/{status}/{id_akad}/{catatan}','ReviewerController@updateStatusAkad')->middleware('role:1,3,5,7,9');

Route::put('update_cabang','RegistrasiController@updateCabang')->name('registrasi.updatecabang')->middleware('role:1,3');

Route::get('konfirmasi_akad_reviewer/{id}/{id_akad}','ReviewerController@konfirmasiAkadReviewer')->middleware('role:1,3');

Route::get('update_status_akad_approve/{id}/{id_user}/{status}/{id_akad}/{catatan}','ReviewerController@updateStatusAkad2')->middleware('role:1,3,9');
Route::get('konfirmasi_akad_approver/{id}/{id_akad}','ReviewerController@konfirmasiAkadReviewer2')->middleware('role:1,3,5,7,9');
//

Route::get('update_status_registrasi/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusRegistrasi')->middleware('role:1,3');

//Route::get('data_registrasi_pelanggan_bayar','RegistrasiController@dataRegistrasiPelangganBayar')->name('dataregistrasipelangganbayar');


//view email design
Route::get('view_email','RegistrasiController@viewEmail')->name('view.email');


//list konfirmasi pembayaran
Route::get('list_pembayaran_registrasi','RegistrasiController@listPembayaranRegistrasi')->name('listpembayaranregistrasi')->middleware('role:1,3,5,7,9');
Route::get('data_pembayaran_registrasi','RegistrasiController@dataPembayaranRegistrasi')->name('datapembayaranregistrasi')->middleware('role:1,3,5,7,9');
Route::get('konfirmasi_pembayaran_registrasi/{id}','RegistrasiController@konfirmasiPembayaranRegistrasi')->middleware('role:1,3');

//pembayaran registrasi
Route::get('pembayaran_registrasi/{id}','RegistrasiController@pembayaranRegistrasi')->name('registrasi.pembayaranRegistrasi')->middleware('role:1,2,3,5,7,9');
Route::put('konfirmasi_pembayaran/{id}','RegistrasiController@konfirmasiPembayaranUser')->name('registrasi.konfirmasipembayaran')->middleware('role:1,2,3,5,7,9');
Route::get('download','RegistrasiController@download');


//pembayaran tahap 2
Route::get('list_pembayaran_tahap2','RegistrasiController@listPembayaranTahap2')->name('listpembayarantahap2')->middleware('role:1,3,5,7,9');
Route::get('data_pembayaran_Tahap2','RegistrasiController@dataPembayaranTahap2')->name('datapembayarantahap2')->middleware('role:1,3,5,7,9');
Route::get('konfirmasi_pembayaran_tahap2/{id}','RegistrasiController@konfirmasiPembayaranTahap2')->middleware('role:1,3,5,7,9');


//pembayaran tahap 2
Route::get('pembayaran_tahap2/{id}','RegistrasiController@pembayaranTahap2')->name('registrasi.pembayarantahap2')->middleware('role:1,2,3,5,7,9');
Route::put('konfirmasi_pembayaran_user_tahap2/{id}','RegistrasiController@konfirmasiPembayaranUserTahap2')->name('registrasi.konfirmasipembayaranusertahap2')->middleware('role:1,2,3,5,7,9');

//report
//Route::get('report_audit/{id}','RegistrasiController@reportAudit')->name('registrasi.reportaudit');
//Route::get('report_berita_acara/{id}','RegistrasiController@reportBeritaAcara')->name('registrasi.reportberitaacara');
// Route::get('upload_kontrak_akad_user/{id}','RegistrasiController@uploadAkadUser')->name('registrasi.uploadakaduser');

//list konfirmasi pelunasan
Route::get('list_pelunasan','RegistrasiController@listPelunasan')->name('listpelunasan')->middleware('role:1,3,5,7,9');
Route::get('data_pelunasan','RegistrasiController@dataPelunasan')->name('datapelunasan')->middleware('role:1,3,5,7,9');
Route::put('konfirmasi_pelunasan_admin/{id}','RegistrasiController@konfirmasiPelunasanInvoiceAdmin')->name('registrasi.konfirmasiinvoice')->middleware('role:1,3,5,7,9');

//pelunasan
Route::get('pelunasan/{id}','RegistrasiController@pelunasan')->name('registrasi.pelunasan')->middleware('role:1,2,3,5,7,9');
Route::put('konfirmasi_pelunasan_user/{id}','RegistrasiController@konfirmasiPelunasanUser')->name('registrasi.konfirmasipelunasanuser')->middleware('role:1,2,3,5,7,9');

Route::get('upload_invoice/{id}','RegistrasiController@uploadInvoice')->name('registrasi.uploadinvoice')->middleware('role:1,3,5,7,9');

//Route::get('lebih/{id}/{tahap}','RegistrasiController@lebih')->name('registrasi.lebih')->middleware('role:1,3,5,7,9');
//Route::get('kurang/{id}/{tahap}','RegistrasiController@kurang')->name('registrasi.kurang')->middleware('role:1,3,5,7,9');


Route::put('upload_file_invoice/{id}','RegistrasiController@uploadFileInvoice')->name('registrasi.uploadfileinvoice')->middleware('role:1,3,5,7,9');
//Route::get('download','RegistrasiController@download');
//Route::get('unduh_bukti_bayar/{id}','RegistrasiController@unduhBuktiBayar');


//Akad
//reviewer dan approver
Route::get('list_akad_reviewer','ReviewerController@listAkadReviewer')->name('listakadreviewer')->middleware('role:1,3,5,7,9');
Route::get('data_akad_reviewer','ReviewerController@dataAkadReviewer')->name('dataakadreviewer')->middleware('role:1,3,5,7,9');
Route::get('list_penjadwalan_reviewer','ReviewerController@listPenjadwalanReviewer')->name('listpenjadwalanreviewer')->middleware('role:1,3,6,9');
Route::get('list_pelunasan_reviewer','ReviewerController@listPelunasanReviewer')->name('listpelunasanreviewer')->middleware('role:1,3,5,7,9');

Route::get('list_akad_approver','ReviewerController@listAkadApprover')->name('listakadapprover')->middleware('role:1,3,9');
Route::get('data_akad_approver','ReviewerController@dataAkadApprover')->name('dataakadapprover')->middleware('role:1,3,9');

//admin
Route::get('list_akad_admin','RegistrasiController@listAkadAdmin')->name('listakadadmin')->middleware('role:1,3,5,7,9');
Route::get('data_akad_admin','RegistrasiController@dataAkadAdmin')->name('dataakadadmin')->middleware('role:1,3,5,7,9');
Route::get('upload_kontrak_akad_admin/{id}','RegistrasiController@uploadAkadAdmin')->name('registrasi.uploadakadadmin')->middleware('role:1,3,5,7,9');
Route::put('upload_file_akad_admin/{id}','RegistrasiController@uploadFileAkadAdmin')->name('registrasi.uploadfileakadadmin')->middleware('role:1,3,5,7,9');
Route::get('konfirmasi_akad_admin/{id}/{status}','RegistrasiController@konfirmasiAkadAdmin')->middleware('role:1,3,5,7,9');

//sales account officer
Route::get('list_penawaran_harga_kontrak_akad','RegistrasiController@listPenawaranHarga')->name('listpenawaranharga')->middleware('role:1,3,4,5,6');
Route::get('list_penerbitan_order_confirmation','RegistrasiController@listPenerbitanOC')->name('listpenerbitanoc')->middleware('role:1,3,5');
Route::get('data_penerbitan_oc','RegistrasiController@dataPenerbitanOC')->name('datapenerbitanoc')->middleware('role:1,3,5');
Route::get('upload_oc_admin/{id}','RegistrasiController@uploadOCAdmin')->name('registrasi.uploadocadmin')->middleware('role:1,3,5');
Route::get('upload_oc_user/{id}','RegistrasiController@uploadOCUser')->name('registrasi.uploadocuser')->middleware('role:1,2,3,5');
Route::put('upload_file_oc_admin/{id}','RegistrasiController@uploadFileOCAdmin')->name('registrasi.uploadfileocadmin')->middleware('role:1,3,5');
Route::put('upload_file_oc_user/{id}','RegistrasiController@uploadFileOCUser')->name('registrasi.uploadfileocuser')->middleware('role:1,2,3,5');
Route::get('update_status_oc/{id}/{no_registrasi}/{id_user}/{status}','RegistrasiController@updateStatusOC')->middleware('role:1,3,5,7,9');
Route::get('konfirmasi_oc_admin/{id}/{status}','RegistrasiController@konfirmasiOCAdmin')->middleware('role:1,3,5');

//Route::put('acc_audit_admin/{id}','RegistrasiController@accAuditAdmin')->name('registrasi.accauditadmin');
//Route::put('acc_berita_acara_admin/{id}','RegistrasiController@accBeritaAcaraAdmin')->name('registrasi.accberitaacaraadmin');

Route::get('upload_report_admin/{id}','RegistrasiController@uploadReportAdmin')->name('registrasi.uploadreportadmin')->middleware('role:1,3');
Route::put('upload_file_report_admin/{id}','RegistrasiController@uploadFileReportAdmin')->name('registrasi.uploadfilereportadmin')->middleware('role:1,3');
Route::get('upload_berita_acara_admin/{id}','RegistrasiController@uploadBeritaAcaraAdmin')->name('registrasi.uploadberitaacaraadmin')->middleware('role:1,3');
Route::put('upload_file_berita_acara_admin/{id}','RegistrasiController@uploadFileBeritaAcaraAdmin')->name('registrasi.uploadfileberitaacaraadmin')->middleware('role:1,3');
//Route::get('kirim_ke_mui/{id}','RegistrasiController@kirimKeMUI')->name('registrasi.kirimkemui');
//Route::put('upload_file_mui/{id}','RegistrasiController@uploadFileMUI')->name('registrasi.uploadfilemui');

Route::get('list_berita_acara','RegistrasiController@listBeritaAcara')->name('listberitaacara')->middleware('role:1,3');
Route::get('data_berita_acara_admin','RegistrasiController@dataBeritaAcaraAdmin')->name('databeritaacaraadmin')->middleware('role:1,3');
// Route::get('list_berita_acara2','RegistrasiController@listBeritaAcara2')->name('listberitaacara2');
// Route::get('data_berita_acara_admin2','RegistrasiController@dataBeritaAcaraAdmin2')->name('databeritaacaraadmin2');

//user
Route::get('upload_kontrak_akad_user/{id}','RegistrasiController@uploadAkadUser')->name('registrasi.uploadakaduser')->middleware('role:1,2,3,5,7,9');
Route::put('upload_file_akad_user/{id}','RegistrasiController@uploadFileAkadUser')->name('registrasi.uploadfileakaduser')->middleware('role:1,2,3,5,7,9');


//akad registrasi
//Route::get('Akad_registrasi/{id}','RegistrasiController@akadRegistrasi')->name('registrasi.akadRegistrasi');




Route::get('download','RegistrasiController@download');





//unggah data sertifikasi - uds
//pelanggan
Route::get('unggah_dokumen_sertifikasi','RegistrasiController@unggahDokumenSertifikasi')->name('registrasi.unggahDokumenSertifikasi')->middleware('role:1,2,3,6,9,10,11,12,13');
Route::get('get_data_registrasi','RegistrasiController@getDataRegistrasi')->name('getdataregistrasi')->middleware('role:1,2,3,6,9,10,11,12,13');
Route::post('store_dokumen_sertifikasi','RegistrasiController@storeDokumenSertifikasi')->name("storedokumensertifikasi")->middleware('role:1,2,3,6,9,10,11,12,13');
Route::get('delete_dokumen_sertifikasi/{id}','RegistrasiController@deleteDokumenSeritfikasi')->name('deletedokumensertifikasi')->middleware('role:1,2,3,6,9,10,11,12,13');
//admin
Route::get('verifikasi_dokumen_sertifikasi/{id_registrasi}','RegistrasiController@verifikasiDokumenSertifikasi')->name('verifikasidokumensertifikasi')->middleware('role:1,2,3,6,9,10,11,12,13');
Route::put('update_status_verifikasi_dokumen/{id}','RegistrasiController@updateStatusVerifikasiDokumen')->name('updatestatusverifikasidokumen')->middleware('role:1,2,3,6,9,10,11,12,13');

//audit tahap 1
//pelanggan
Route::get('unggah_dokumen_audit_tahap1','RegistrasiController@unggahDokumenAuditTahap1')->name('registrasi.unggahDokumenAuditTahap1')->middleware('role:1,2,3,6,9,10,11,12,13');
//auditor
Route::get('audit_tahap1/{id_registrasi}','RegistrasiController@auditTahap1')->name('audittahap1')->middleware('role:1,2,3,6,9,10,11,12,13');
Route::put('update_status_audit_tahap1/{id}','RegistrasiController@updateStatusAuditTahap1')->name('updatestatusaudittahap1')->middleware('role:1,2,3,6,9,10,11,12,13');

// Route::get('data_fasilitas/{id_registrasi}','RegistrasiController@dataFasilitas');
// Route::get('data_produk/{id_registrasi}','RegistrasiController@dataProduk');
// Route::get('data_kantor_pusat/{id_registrasi}','RegistrasiController@dataKantorPusat');
// Route::get('data_menu_restoran/{id_registrasi}','RegistrasiController@dataMenuRestoran');
// Route::get('data_jagal/{id_registrasi}','RegistrasiController@dataJagal');
// Route::get('data_material/{id_registrasi}','RegistrasiController@dataMaterial');

// //detail tiap list
// Route::get('fasilitas_detail/{id_registrasi}/{id}','RegistrasiController@fasilitasDetail')->name('fasilitas.detail');
// Route::get('kantor_pusat_detail/{id_registrasi}/{id}','RegistrasiController@kantorPusatDetail')->name('kantorpusat.detail');
// Route::get('material_detail/{id_registrasi}/{id}','RegistrasiController@materialDetail')->name('material.detail');
// Route::get('jagal_detail/{id_registrasi}/{id}','RegistrasiController@jagalDetail')->name('jagal.detail');


// //fasilitas
// Route::get('list_fasilitas','RegistrasiController@listFasilitas')->name('listfasilitas');
// Route::get('tambah_fasilitas','RegistrasiController@createFasilitas')->name('tambahfasilitas');
// Route::post('store_fasilitas','RegistrasiController@storeFasilitas')->name("storefasilitas");
// Route::get('detail_fasilitas/{id}','RegistrasiController@detailFasilitas')->name('detailfasilitas');
// Route::get('edit_fasilitas/{id}','RegistrasiController@editFasilitas')->name('editfasilitas');
// Route::put('update_fasilitas/{id}','RegistrasiController@updateFasilitas')->name('updatefasilitas');


// //kantor pusat
// Route::get('list_kantor_pusat','RegistrasiController@listKantorPusat')->name('listkantorpusat');
// Route::get('tambah_kantor_pusat','RegistrasiController@createKantorPusat')->name('tambahkantorpusat');
// Route::post('store_kantor_pusat','RegistrasiController@storeKantorPusat')->name("storekantorpusat");
// Route::get('detail_kantor_pusat/{id}','RegistrasiController@detailKantorPusat')->name('detailkantorpusat');
// Route::get('edit_kantor_pusat/{id}','RegistrasiController@editKantorPusat')->name('editkantorpusat');
// Route::put('update_kantor_pusat/{id}','RegistrasiController@updateKantorPusat')->name('updatekantorpusat');    


// //menu restoran
// Route::get('list_menu_restoran','RegistrasiController@listMenuRestoran')->name('listmenurestoran');
// Route::get('tambah_menu_restoran','RegistrasiController@createMenuRestoran')->name('tambahmenurestoran');
// Route::post('store_menu_restoran','RegistrasiController@storeMenuRestoran')->name("storemenurestoran");
// Route::get('detail_menu_restoran/{id}','RegistrasiController@detailMenuRestoran')->name('detailmenurestoran');
// Route::get('edit_menu_restoran/{id}','RegistrasiController@editMenuRestoran')->name('editmenurestoran');
// Route::put('update_menu_restoran/{id}','RegistrasiController@updateMenuRestoran')->name('updatemenurestoran');


// //jagal
// Route::get('list_jagal','RegistrasiController@listJagal')->name('listjagal');
// Route::get('tambah_jagal','RegistrasiController@createJagal')->name('tambahjagal');
// Route::post('store_jagal','RegistrasiController@storeJagal')->name("storejagal");
// Route::get('detail_jagal/{id}','RegistrasiController@detailJagal')->name('detailjagal');
// Route::get('edit_jagal/{id}','RegistrasiController@editJagal')->name('editjagal');
// Route::put('update_jagal/{id}','RegistrasiController@updateJagal')->name('updatejagal');


// //produk
// Route::get('list_produk','RegistrasiController@listProduk')->name('listproduk');
// Route::get('tambah_produk','RegistrasiController@createProduk')->name('tambahproduk');
// Route::post('store_produk','RegistrasiController@storeProduk')->name("storeproduk");
// Route::get('edit_produk/{id}','RegistrasiController@editProduk')->name('editproduk');
// Route::put('update_produk/{id}','RegistrasiController@updateProduk')->name('updateproduk');
//dokumen has

// //material
// Route::get('list_material','RegistrasiController@listMaterial')->name('listmaterial');
// Route::get('tambah_material','RegistrasiController@createMaterial')->name('tambahmaterial');
// Route::post('store_material','RegistrasiController@storeMaterial')->name("storematerial");
// Route::get('edit_material/{id}','RegistrasiController@editMaterial')->name('editmaterial');
// Route::put('update_material/{id}','RegistrasiController@updateMaterial')->name('updatematerial');
// Route::get('detail_material/{id}','RegistrasiController@detailMaterial')->name('detailmaterial');


// //dokumen matriks produk
// Route::post('store_matriks_produk','RegistrasiController@storeMatriksProduk')->name("storematriksproduk");
// Route::get('delete_matriks_produk/{id}','RegistrasiController@deleteMatriksProduk')->name('deletematriksproduk');
// Route::get('list_matriks_pelanggan','RegistrasiController@listMatriksPelanggan')->name('listmatriks.pelanggan');
// Route::get('data_matriks_pelanggan','RegistrasiController@dataMatriksPelanggan')->name('datamatriks.pelanggan');
// Route::get('detail_matriks_pelanggan/{id}','RegistrasiController@detailmatriksPelanggan')->name('detailmatriks.pelanggan');


// //kuisioner has
// Route::post('store_kuisioner_has','RegistrasiController@storeKuisionerHas')->name("storekuisionerhas");
// Route::get('delete_kuisioner_has/{id}','RegistrasiController@deleteKuisionerHas')->name('deletekuisionerhas');
// Route::get('detail_kuisioner_pelanggan/{id}','RegistrasiController@detailKuisionerHasPelanggan')->name('detailkuisionerhas.pelanggan');

//Route::get('detailRegistrasi','RegistrasiController@detailRegistrasi')->name('registrasi.detailRegistrasi');
//Route::get('pembayaranAkad','RegistrasiController@pembayaranAkad')->name('registrasi.pembayaranAkad');
//Route::get('penjadualanAudit','RegistrasiController@penjadualanAudit')->name('registrasi.penjadualanAudit');
//Route::get('dokumenTravel','RegistrasiController@dokumenTravel')->name('registrasi.dokumenTravel');

Route::resource('dokumen','DokumenController')->middleware('role:1,2,3,6,9,10,11,12,13');;
Route::get('dokumen_user','DokumenController@indexUser')->name('dokumen.indexuser')->middleware('role:1,2,3');
Route::get('dokumen_pelanggan','DokumenController@indexpelanggan')->name('dokumen.indexpelanggan')->middleware('role:1,2,3');
Route::get('dokumen_view/{id}','DokumenController@dokumenView')->name('dokumen.view');
Route::get('dokumen_datatable','DokumenController@datatable')->name('dokumen.datatable');
Route::get('dokumen_datatable_pelanggan','DokumenController@datatablePelanggan')->name('dokumen.datatable_pelanggan')->middleware('role:1,2,3');
Route::get('dokumen_datatable_user','DokumenController@datatableUser')->name('dokumen.datatable_user')->middleware('role:1,3,4,5,6,7,8,9,10,11,12,13');
//master
Route::prefix('master')->group(function (){

    Route::resource('detailpelaksana','Master\PelaksanaController')->middleware('role:1,3,6,9,10,11,12,13');
    Route::get('detailpelaksana_datatable','Master\PelaksanaController@datatable')->name('master.detailpelaksana.datatable')->middleware('role:1,3,6,9,10,11,12,13');

    Route::resource('jenis_registrasi','Master\JenisRegistrasiController')->middleware('role:1,3,6,9,10,11,12,13');
    Route::get('jenis_registrasi_datatable','Master\JenisRegistrasiController@datatable')->name('master.jenisregistrasi.datatable')->middleware('role:1,3,6,9');
    
    Route::resource('kelompok_produk','Master\KelompokProdukController')->middleware('role:1,3,6,9');
    Route::get('kelompok_produk_datatable','Master\KelompokProdukController@datatable')->name('master.kelompokproduk.datatable')->middleware('role:1,3,6,9');

    

    Route::resource('faq','Master\FaqController')->middleware('role:1,3,6,9');
    Route::get('master/faq/faq_datatable','Master\FaqController@datatable')->name('master.faq.datatable')->middleware('role:1,3,6,9');


    Route::resource('akomodasi','Master\AkomodasiController')->middleware('role:1,3,6,9');
    Route::get('akomodasi_datatable','Master\AkomodasiController@datatable')->name('master.akomodasi.datatable')->middleware('role:1,3,6,9');

   

    Route::get('akomodasi/delete/{id}/{jenis_akomodasi}', [
    'as' => 'destroy', 
    'uses' => 'Master\AkomodasiController@destroy'
    ])->middleware('role:1,3,6,9');

  

    Route::get('akomodasi/update/{id}', [
    'as' => 'update', 
    'uses' => 'Master\AkomodasiController@update'
    ])->middleware('role:1,3,6,9');

    Route::get('akomodasi/edit/{id}/{jenis_akomodasi}', [
    'as' => 'edit', 
    'uses' => 'Master\AkomodasiController@edit'
    ])->middleware('role:1,3,6,9');

 
    Route::get('faq_user','Master\FaqController@user')->name('faquser');
    Route::get('pelanggan_kami','Master\PelangganController@user')->name('pelanggankami');

    Route::resource('guideline','Master\GuidelineController');

    Route::resource('berita','Master\BeritaController')->middleware('role:1,3,4,7,9');
    Route::resource('editberita','Master\EditBeritaController')->middleware('role:1,3,4,7,9');
    Route::get('data_berita','Master\BeritaController@dataBerita')->name('master.databerita')->middleware('role:1,3,4,7,9');
    Route::post('upload_image','Master\BeritaController@uploadImage')->name('master.uploadimage')->middleware('role:1,3,4,7,9');

    Route::resource('pelatihan','Master\PelatihanController')->middleware('role:1,3,14,8,9');
    Route::resource('editpelatihan','Master\EditPelatihanController')->middleware('role:1,3,14,8,9');
    Route::post('upload_image_pelatihan','Master\PelatihanController@uploadImagePelatihan')->name('master.uploadimagepelatihan')->middleware('role:1,3,14,8,9');
    Route::get('data_pelatihan','Master\PelatihanController@dataPelatihan')->name('master.datapelatihan')->middleware('role:1,3,14,8,9');
        
    // Route::get('upload_kontrak_akad_admin/{id}','RegistrasiController@uploadAkadAdmin')->name('registrasi.uploadakadadmin');
});
Route::get('faq_detail/{id}','Master\FaqController@faqDetail')->name('master.faq.detail');
Route::get('detail_berita/{id}','Master\BeritaController@detailBerita')->name('master.berita.detailberita');
Route::get('detail_pelatihan/{id}','Master\PelatihanController@detailPelatihan')->name('master.pelatihan.detailpelatihan');
Route::get('detail_berita_user/{id}','Master\BeritaController@detailBeritaUser')->name('master.berita.detailberitauser');
Route::get('detail_pelatihan_user/{id}','Master\PelatihanController@detailPelatihanUser')->name('master.pelatihan.detailpelatihanuser');
Route::get('acc_berita/{id}','Master\BeritaController@accBerita')->name('master.berita.accberita');
Route::get('acc_pelatihan/{id}','Master\PelatihanController@accPelatihan')->name('master.pelatihan.accpelatihan');
Route::get('cari_berita','Master\BeritaController@cariBerita')->name('master.berita.cariberita');

Route::get('informasi_panduan','InformasiController@panduan')->name('informasipanduan');
Route::get('informasi_alur','InformasiController@alur')->name('informasialur');

//user management
Route::prefix('system')->group(function(){

    Route::resource('user','System\UserController');
    Route::get('user_datatable','System\UserController@datatable')->name('system.user.datatable')->middleware('role:1,3,9');
    Route::get('list_pelanggan','System\UserController@listPelanggan')->name('user.listpelanggan')->middleware('role:1,3,9');
    Route::get('pelanggan_datatable','System\UserController@dataPelanggan')->name('system.pelanggan.datatable')->middleware('role:1,3,9');


    Route::get('edit_profile/{id}','System\UserController@editProfile')->name('system.user.editprofile');

    //Route::get('edit_profile/{id}','System\UserController@editProfile')->name('system.user.editprofile');
    Route::post('update_profile','System\UserController@updateProfile')->name('system.user.updateprofile');

    Route::get('change_password/{id}','System\UserController@change_Password')->name('system.user.change_password');
    Route::post('update_password','System\UserController@updatePassword')->name('system.user.updatepassword');


    Route::resource('usergroup','System\UserGroupController');
    Route::get('usergroup_datatable','System\UserGroupController@datatable')->name('system.usergroup.datatable');

    Route::resource('log','System\LogController');
    Route::get('log_datatable','System\LogController@datatable')->name('system.log.datatable');

    Route::get('dependent_dropdown', 'DependentDropdownController@index')->name('dependent_dropdown.index');
    Route::post('dependent_dropdown', 'DependentDropdownController@store')->name('dependent_dropdown.store');

    Route::get('dependent_dropdown_rincian', 'DependentDropdownRincianController@index')->name('dependent_dropdown_rincian.index');
    Route::post('dependent_dropdown_rincian', 'DependentDropdownRincianController@store')->name('dependent_dropdown_rincian.store');

});