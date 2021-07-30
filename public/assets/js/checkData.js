/*Tanah Bangunan*/
function checkStatus(data){
    var showData = (data==0)? "Non Aktif":"Aktif"
    return showData;
}

function checkStatusPembayaran(data){

     return  (data==0)? '<a    style=" color:red "><strong>Belum Bayar</strong></a>'
        :(data==1)? '<a    style="   color:#fcba03"><strong>Menunggu Konfirmasi Admin</strong></a>'
        :(data==2)? '<a    style="   color:red"><strong>Pembayaran Gagal</strong></a>'
        :(data==3)? '<a      style="   color:green"><strong>Pembayaran Berhasil</strong></a>'
        : '<a     style=" color:red"><strong>Belum Bayar</strong></a>';
            
}

function checkStatusPenerbitanOrderConfirmation(data){

    return  (data==0)? '<a   style=" color:red"><strong>Belum Upload OC</strong></a>'
    :(data==1)? '<a   style="  color:#fcba03"><strong>Menunggu Konfirmasi Pelaku Usaha</strong></a>'
    :(data==2)? '<a   style="  color:#fcba03"><strong>Menunggu Konfirmasi Admin</strong></a>'
    :(data==3)? '<a   style="  color:red"><strong>Penerbitan OC Gagal</strong></a>'
    :(data==4)? '<a   style="color:green"><strong>Penerbitan OC Terkonfirmasi</strong></a>'
    : '<a   style=" color:red"><strong>Belum Upload OC</strong></a>';

  
           
}

function checkStatusPelunasan(data){

    return  (data==0)? '<a   style=" color:red"><strong>Belum Bayar</strong></a>'
        :(data==1)? '<a   style="   color:#fcba03"><strong>Menunggu Konfirmasi Admin</strong></a>'
        :(data==2)? '<a   style="   color:red"><strong>Pembayaran Gagal</strong></a>'
        :(data==3)? '<a   style="   color:green"><strong>Pembayaran Berhasil</strong></a>'
        : '<a   style=" color:red"><strong>Belum Bayar</strong></a>';
           
}

function checkStatusBerkas(data){

    return  (data==0)? '<a   style=" color:black"><strong>Belum Upload Berkas</strong></a>'
    :(data==1)? '<a   style="   color:#fcba03"><strong>Menunggu Admin Verfikasi Berkas</strong></a>'
    :(data==2)? '<a   style="   color:red"><strong>Perbaikan Berkas</strong></a>'
    :(data==3)? '<a   style="   color:green"><strong>Berkas Terverifikasi</strong></a>'
    : '<a   style=" color:black"><strong>Belum Upload Berkas</strong></a>';
   
}

function checkStatusAuditTahap1(data){
    return  (data==0)? '<a   style=" color:black"><strong>Belum Upload Berkas</strong></a>'
    :(data==1)? '<a   style="   color:#fcba03"><strong>Menunggu Auditor Memverifikasi Berkas</strong></a>'
    :(data==2)? '<a   style="   color:red"><strong>Perbaikan Berkas</strong></a>'
    :(data==3)? '<a   style="   color:green"><strong>Audit tahap 1 Selesai</strong></a>'
    : '<a   style=" color:black"><strong>Belum Upload Berkas</strong></a>';

    
}

function checkStatusAuditTahap2(data){
    return  (data==0)? '<a   style=" color:black"><strong>Belum Upload Laporan Audit</strong></a>'
    :(data==1)? '<a   style="   color:red"><strong>Perbaikan Audit Tahap 2</strong></a>'
    :(data==2)? '<a   style="   color:green"><strong>Audit Tahap 2 Selesai</strong></a>'
   
   
    : '<a   style=" color:black"><strong>Belum Upload Audit Plan</strong></a>';

    
            
}

function checkStatusTehnicalReview(data){
    return  (data==0)? '<a   style=" color:green"><strong>Technical Reviewer Belum Upload Review Laporan Audit</strong></a>'
    :(data==1)? '<a   style=" color:green"><strong>Proses Technical Review Selesai</strong></a>'
   
    : '<a   style=" color:green"><strong>Technical Reviewer Belum Upload Review Laporan Audit</strong></a>';

    
            
}

function checkStatusKomite(data){
    return  (data==0)? '<a   style=" color:green"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></a>'
    :(data==1)? '<a   style="   color:black"><strong>Proses Technical Review Selesai</strong></a>'
   
    : '<a   style=" color:green"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></a>';

    
            
}

function checkStatusPersiapanKomisiFatwa(data){
    return  (data==0)? '<a   style=" color:green"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></a>'
    :(data==1)? '<a   style="   color:black"><strong>Proses Technical Review Selesai</strong></a>'
   
    : '<a   style=" color:green"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></a>';

    
            
}

            



function checkStatusKebutuhanAudit(data){

    return  (data==0)? '<a style="color:black"><strong>Kebutuhan Waktu Audit Belum Ditentukan</strong></a>'
    :(data==1)? '<a   style="color:#fcba03"><strong>Menunggu Reviewer Mengkonfirmasi Kebutuhan Waktu Audit</strong></a>'
    :(data==2)? '<a   style="   color:red"><strong>Perbaikan Kebutuhan Waktu Audit</strong></a>'
    :(data==3)? '<a   style="   color:green"><strong>Kebutuhan Waktu Audit Terkonfirmasi</strong></a>'
    : '<a   style=" color:black"><strong>Kebutuhan Waktu Audit Belum Ditentukan</strong></a>';


    
            
}



function checkPenjadwalan(data){
    return  (data==0)? '<a  class="btn btn-xs " style=" color:black"><strong>Belum Dijadwalkan</strong></a>'
    :(data==1)? '<a   style="  color:#fcba03"><strong>Menunggu Reviewer Mengkonfirmasi Jadwal</strong></a>'
    :(data==2)? '<a   style="   color:red"><strong>Perbaikan Penjadwalan</strong></a>'
    :(data==3)? '<a   style="   color:green"><strong>Penjadwalan Terkonfirmasi</strong></a>'
    : '<a   style=" color:black"><strong>Belum Dijadwalkan</strong></a>';
  
}


// function checkStatusAkad(data){

//      return  (data==0)? '<a   class="ion-ios-clipboard" title="Belum Akad" style="font-size: 200%"><strong></strong></a>'
//             :(data==1)? '<a    class="ion-ios-clipboard " style="font-size: 200%color:#fcba03 " title="Menunggu Konfirmasi"><strong></strong></a>'
//             :(data==2)? '<a    class="ion-ios-clipboard " style="font-size: 200%color:#e32636 " title="Perbaikan"><strong></strong></a>'
//             :(data==3)? '<a    class="ion-ios-clipboard " style="font-size: 200%color:#32cd32 " title="Penawaran Terkonfirmasi"><strong></strong></a>'
//             :(data==4)? '<a    class="ion-ios-clipboard " style="font-size: 200%color:#fcba03 " title="Menunggu Pelaku Usaha Megupload Ulang Kontrak"><strong></strong></a>'
//             :(data==5)? '<a    class="ion-ios-clipboard  " style="font-size: 200% align-center color: #e32636"title="Pelaku Usaha Menolak Penawaran"><strong></strong></a>'
//             :(data==6)? '<a    class="ion-ios-clipboard " style="align-center font-size: 200% color:#fcba03 " title="Pelaku Usaha Sudah Upload Ulang dan Menunggu Konfirmasi Sales"><strong></strong></a>'
//             :(data==7)? '<a    class="ion-ios-clipboard  " style="font-size: 200% align-center color: #e32636"title="Penawaran Gagal"><strong></strong></a>'
//             :(data==8)? '<a    class="ion-ios-clipboard  " style="font-size: 200% align-center color:#32cd32 "title="Penawaran Terkonfirmasi"><strong></strong></a>'
//             :'<a    class="ion-ios-clipboard " style="font-size: 200%" title="Belum Akad"><strong></strong></a>'
            
// }

function checkStatusAkad(data){
    return  (data==0)? '<a   style=" color:red"><strong>Belum Upload Akad</strong></a>'
    :(data==1)? '<a   style="   color:green"><strong>Sudah Upload Bukti  Akad</strong></a>'
    : '<a   style=" color:red"><strong>Belum Upload Akad</strong></a>';
    
            
}

// function checkStatusBeritaAcara(data){

//      return  (data==0)? '<a   class="ion-ios-clipboard" title="Berita Acara Belum Diupload" style="font-size: 200%"><strong></strong></a><br>Admin'
//             :(data==1)? '<a    class="ion-ios-clipboard " style="font-size: 200%color:#fcba03 " title="Menunggu Pelaku Usaha Megupload Ulang Berita Acara"><strong></strong></a><br>Pelaku Usaha'
//             :(data==2)? '<a    class="ion-ios-clipboard " style="align-center font-size: 200% color:#32cd32 " title="Pelaku Usaha Sudah Upload Ulang Berita Acara"><strong></strong></a>'
//             :'<a    class="ion-ios-clipboard " style="zoom:2.0" title="Berita Acara Belum Diupload"><strong></strong></a>'
            
// }

function checkStatusFaq(data){
    return  (data=='nonaktif')? 'Non Aktif'
        :(data=='aktif')? 'Aktif'
        :(data=='transfer')? 'Transfer'
        :(data=='tunai')? 'Tunai'
        :'-';
            
}
                                   
function checkWilayah(data){
    return  (data=='119')? 'Kantor Pusat'
            :(data=='115')? 'Cabang Balikpapan'
            :(data=='125')? 'Cabang Bandar Lampung'
            :(data=='107')? 'Cabang Bandung'
            :(data=='117')? 'Cabang Banjarmasin'
            :(data=='123')? 'Cabang Batam'
            :(data=='104')? 'Cabang Batu Licin'
            :(data=='103')? 'Cabang Bekasi'
            :(data=='129')? 'Cabang Bengkulu'
            :(data=='121')? 'Cabang Bontang'
            :(data=='113')? 'Cabang Cilacap'
            :(data=='131')? 'Cabang Cilegon'
            :(data=='105')? 'Cabang Cirebon'
            :(data=='114')? 'Cabang Denpasar'
            :(data=='127')? 'Cabang Dumai'
            :(data=='130')? 'Cabang Jakarta'
            :(data=='128')? 'Cabang Jambi'
            :(data=='111')? 'Cabang Makassar'
            :(data=='116')? 'Cabang Manado'
            :(data=='101')? 'Cabang Medan'
            :(data=='126')? 'Cabang Padang'
            :(data=='124')? 'Cabang Palembang'
            :(data=='109')? 'Cabang Pekanbaru'
            :(data=='122')? 'Cabang Pontianak'
            :(data=='120')? 'Cabang Samarinda'
            :(data=='102')? 'Cabang Sangatta'
            :(data=='110')? 'Cabang Semarang'
            :(data=='108')? 'Cabang Surabaya'
            :(data=='106')? 'Cabang Tarakan'
            :(data=='112')? 'Cabang Timika'
            :(data=='118')? 'SBU Kantor Pusat'
            :(data=='132')? 'SBU Laboratorium Cibitung'
            :'-';
                
}


function checkProgress(data){
    return  (data==1)? 'Pengajuan Baru'
            //verifikasi data sertifikasi
            :(data==2)? 'Verifikasi Berkas'
            :(data.trim()=='2_0')? 'Belum Upload Berkas'
            :(data.trim()=='2_1')? 'Menunggu Verifikasi Admin'
            :(data.trim()=='2_2')? 'Perbaikan Berkas'
            :(data.trim()=='2_3')? 'Berkas Terkonfirmasi'
            //menentukan waktu audit
            :(data==3)? 'Menentukan Kebutuhan Audit'
            :(data.trim()=='3_0')? 'Belum Ditentukan'
            :(data.trim()=='3_1')? 'Menunggu Reviewer Mengkonfirmasi Kebutuhan Audit'
            :(data.trim()=='3_2')? 'Perbaikan Kebutuhan Audit'
            :(data.trim()=='3_3')? 'Kebutuhan Waktu Audit Terkonfirmasi'
            //penawaran harga dan akad
            :(data==4)? 'Penawaran Harga dan Akad'
            :(data.trim()=='4_0')? 'Belum Upload Bukti Penawaran dan Akad'
            :(data.trim()=='4_1')? 'Sudah Upload Bukti Penawaran dan Akad'
           
            //penerbitan OC
            :(data==5)? 'Penerbitan Order Confirmation'
            :(data.trim()=='5_0')? 'Belum Upload OC'
            :(data.trim()=='5_1')? 'Menunggu Pelaku Usaha Upload Ulang OC'
            :(data.trim()=='5_2')? 'Menunggu Konfirmasi Admin'
            :(data.trim()=='5_3')? 'Penerbitan OC Gagal'
            :(data.trim()=='5_4')? 'Penerbitan OC Terkonfirmasi'
             //pembayaran tahap 1
             :(data==6)? 'Pembayaran'

             :(data.trim()=='6_0')? 'Belum Upload Bukti Bayar'
             :(data.trim()=='6_1')? 'Menunggu Sales Officer Mengkonfirmasi Pembayaran'
             :(data.trim()=='6_2')? 'Pembayaran Gagal'
             :(data.trim()=='6_3')? 'Pembayaran Terkonfirmasi'
            //Penjadwalan
            :(data==7)? '<a   style="   color:red"><strong>Persiapan Audit Tahap1</strong></a>'
            :(data.trim()=='7_0')? 'Belum Dijadwalkan'
            :(data.trim()=='7_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='7_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='7_3')? 'Penjadwalan Terkonfirmasi'
            //Proses Audit Tahap 1
            :(data==8)? 'Proses Audit Tahap 1'
            :(data.trim()=='8_1')? 'Menunggu Auditor Membuat Laporan Audit'
            :(data.trim()=='8_2')? 'Perbaikan Berkas Audit Tahap 1'
            :(data.trim()=='8_3')? 'Audit Tahap 1 Selesai'
            //Pembayaran Tahap 2
            :(data==9)? '<a   style="   color:red"><strong>Persiapan Audit Tahap2</strong></a>'
            :(data.trim()=='9_0')? 'Belum Dijadwalkan'
            :(data.trim()=='9_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='9_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='9_3')? 'Penjadwalan Terkonfirmasi'
            //Proses Audit Tahap 2
            :(data==10)? 'Proses Audit Tahap 2'
            :(data.trim()=='10_1')? 'Perbaikan Audit Tahap 2'
            :(data.trim()=='10_2')? 'Audit Tahap 2 Selesai'

            :(data==11)? '<a   style="   color:red"><strong>Persiapan Technical Review</strong></a>'
            :(data.trim()=='11_0')? 'Belum Dijadwalkan'
            :(data.trim()=='11_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='11_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='11_3')? 'Penjadwalan Terkonfirmasi'

            :(data==12)? 'Proses Technical Review'
            :(data.trim()=='12_0')? 'Reviewer Belum Upload Review Laporan Audit'
            :(data.trim()=='12_1')? 'Proses Technical Review Selesai'

            :(data==13)? '<a   style="   color:red"><strong>Persiapan Komite Sertifikasi</strong></a>'
            :(data.trim()=='13_0')? 'Belum Dijadwalkan'
            :(data.trim()=='13_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='13_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='13_3')? 'Penjadwalan Terkonfirmasi'

            :(data==14)? 'Proses Komite Sertifikasi'
            :(data.trim()=='14_0')? 'Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit'
            :(data.trim()=='14_1')? 'Proses Komite Sertifkasi Selesai'

            :(data==15)? 'Proses Persiapan Sidang Fatwa Halal'
            :(data.trim()=='15_0')? 'Reviewer Belum Mereview Laporan Hasil Akhir Audit'
            :(data.trim()=='15_1')? 'Laporan Akhir Audit Terkonfirmasi'
            
            :(data==16)? 'Proses Sidang Fatwa Halal'
            :(data==17)? 'Ketetapan Halal'
            :'_';
}

function notifProgress(data){
    console.log(data)
    return  (data==1)? 'Pengajuan Baru Berhasil Silahkan Lanjutkan Upload Berkas Pada Menu Unggah Data'
            //verifikasi data sertifikasi
            :(data==2)? 'Silahkan Lengkapi Berkas'
            :(data.trim()=='2_0')? 'Silahkan Lengkapi Berkas'
            :(data.trim()=='2_1')? 'Berkas Berhasil diunggah dan Sedang Dilakukan Verivikasi Data, Mohon Tunggu 1 Hari Kerja'
            :(data.trim()=='2_2')? 'Berkas Sertifikasi Perlu Diperbaiki, Silahkan Cek Menu Unggah Data Sertifikasi Pada Kolom Catatan'
            :(data.trim()=='2_3')? 'Berkas Sertifikasi Sudah Berhasil Terverifikasi'
            //menentukan waktu audit
            :(data==3)? 'Menentukan Kebutuhan Audit'
            :(data.trim()=='3_0')? 'Menentukan Kebutuhan Waktu Audit'

            :(data.trim()=='3_1')? 'Silahkan Menunggu Reviewer Mengkonfirmasi Kebutuhan Audit'
            :(data.trim()=='3_2')? 'Perbaikan Kebutuhan Audit'
            :(data.trim()=='3_3')? 'Kebutuhan Waktu Audit Terkonfirmasi'
            //penawaran harga dan akad
            :(data==4)? 'Penawaran Harga dan Akad'
         
             //penerbitan OC
            :(data==5)? 'Penerbitan OC'
            :(data.trim()=='5_0')? 'Penerbitan OC'
            :(data.trim()=='5_1')? 'Silahkan mengupload Order Confirmation yang Sudah Ditandatangani'
            :(data.trim()=='5_2')? 'Silahkan Menunggu Admin Memverifikasi Order Confirmation'
            :(data.trim()=='5_3')? 'Order Confirmation Tidak Sesuai, Gagal Diterbitkan. Silahkan Upload Ulang dan Pastikan Dokumen Sudah Ditandatangani'
            :(data.trim()=='5_4')? 'Order COnfirmation Sudah Terkonfirmasi Silahkan Melanjutkan Ke Tahapan Selanjutnya Penjadwalan'
               //pembayaran tahap 1
            :(data==6)? 'Silahkan Melakukan Pembayaran Sesuai dengan Akad'
            :(data.trim()=='6_0')? 'Silahkan Melakukan Pembayaran Sesuai dengan Akad'
            :(data.trim()=='6_1')? 'Silahkan Menunggu Berkas Bukti Transfer Dikonfirmasi oleh Sales Admin'
            :(data.trim()=='6_2')? 'Pembayaran Gagal Silahkan Upload Ulang Bukti Transfer Uang Muka Pastikan Foto Terlihat Jelas'
            :(data.trim()=='6_3')? 'Pembayaran  Sesuai dan Akan Dilanjutkan Pada Proses Selanjutnya Yaiut Proses Audit'
           
            
            //Penjadwalan
            :(data==7)? 'Persiapan Audit Tahap1'
            :(data.trim()=='7_0')? 'Belum Dijadwalkan'
            :(data.trim()=='7_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='7_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='7_3')? 'Penjadwalan Terkonfirmasi'
            //Proses Audit Tahap 1
            :(data==8)? 'Proses Audit Tahap 1'
            :(data.trim()=='8_1')? 'Menunggu Auditor Memverifikasi berkas'
            :(data.trim()=='8_2')? 'Perbaikan Berkas Audit Tahap 1'
            :(data.trim()=='8_3')? 'Audit Tahap 1 Selesai'
            //Pembayaran Tahap 2
            :(data==9)? 'Persiapan Audit Tahap2'
            :(data.trim()=='9_0')? 'Belum Dijadwalkan'
            :(data.trim()=='9_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='9_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='9_3')? 'Penjadwalan Terkonfirmasi'
            //Proses Audit Tahap 2
            :(data==10)? 'Proses Audit Tahap 2'
            :(data.trim()=='10_1')? 'Perbaikan Audit Tahap 2'
            :(data.trim()=='10_2')? 'Audit Tahap 2 Selesai'

            :(data==11)? 'Persiapan Technical Review'
            :(data.trim()=='11_0')? 'Belum Dijadwalkan'
            :(data.trim()=='11_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='11_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='11_3')? 'Penjadwalan Terkonfirmasi'

            :(data==12)? 'Proses Technical Review'
            :(data.trim()=='12_0')? 'Reviewer Belum Upload Review Laporan Audit'
            :(data.trim()=='12_1')? 'Proses Technical Review Selesai'

            :(data==13)? 'Persiapan Komite Sertifikasi'
            :(data.trim()=='13_0')? 'Belum Dijadwalkan'
            :(data.trim()=='13_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='13_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='13_3')? 'Penjadwalan Terkonfirmasi'

            :(data==14_0)? 'Proses Komite Sertifikasi'
            :(data.trim()=='14_0')? 'Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit'
            :(data.trim()=='14_1')? 'Proses Komite Sertifkasi Selesai'

            :(data==15)? 'Proses Persiapan Sidang Fatwa Halal'
            :(data.trim()=='15_0')? 'Reviewer Belum Mereview Laporan Hasil Akhir Audit'
            :(data.trim()=='15_1')? 'Laporan Akhir Audit Terkonfirmasi'
            
            :(data==16)? 'Proses Sidang Fatwa Halal'
            :(data==17)? 'Ketetapan Halal'
            :'_';
           
}
/*
function checkIcon(data){
    var showData = (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":"<i class='ion-md-checkmark fa-lg color-green'></i>"
    return showData
}
function checkRutr(data){
    var xdata = (data==1)? "Investasi":((data==2) ? "Perumahan" : (data==3) ? "Perkebunan" :  "<i class='ion-md-remove fa-lg color-grey'></i>")
    return xdata
}
function checkFisik(data){
    return (data==0)? "Rusak":((data==1) ? "Baik" : "<i class='ion-md-remove fa-lg color-grey'></i>") 
}
function checkFisikDetail(data){
    return  (data==1)? "Perlu perbaikan"
        :(data==2)? "Siap digunakan"
            :(data==3)? "Masih bisa digunakan"
                :(data==4)? "Tidak bisa digunakan"
                : "<i class='ion-md-remove fa-lg color-grey'></i>"
}

function checkUtility(data){
    return (data==0)? "Idle":((data==1) ? "Terpakai" : "<i class='ion-md-remove fa-lg color-grey'></i>")
}
function checkAir(data){
    return (data==0)? "Air Tanah":((data==1) ? "PAM" : "<i class='ion-md-remove fa-lg color-grey'></i>")
}
function checkListrik(data){
    return  (data==1)? "PLN"
        :(data==2)? "Genset"
            :(data==3)? "Solar Cell"
            : "<i class='ion-md-remove fa-lg color-grey'></i>"
}
function checkStatus(data){
    return (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":"<i class='ion-md-checkmark fa-lg color-green'></i>"
}
function checkTelekomunikasi(data){
    return (data==0)? "Fixed":((data==1) ? "Cellular" : "<i class='ion-md-remove fa-lg color-grey'></i>")
}
function checkSpekMobilitas(data){
    return (data==0)? "Portable":((data==1) ? "Fixed" : "<i class='ion-md-remove fa-lg color-grey'></i>")
}
function checkSpekSDK(data){
    return (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":((data==1) ? "<i class='ion-md-checkmark fa-lg color-green'></i>" : "<i class='ion-md-remove fa-lg color-grey'></i>")
}
function currencyFormat(num) {
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}*/