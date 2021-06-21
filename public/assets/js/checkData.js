/*Tanah Bangunan*/
function checkStatus(data){
    var showData = (data==0)? "Non Aktif":"Aktif";
    return showData;
}

function checkStatusPembayaran(data){

     return  (data==0)? '<a  class="btn btn-xs"  style="background-color:black  ; color:white; ">Belum Bayar</a>'
        :(data==1)? '<a  class="btn btn-xs"  style="background-color:yellow  ; color:black;">Menunggu Konfirmasi Admin</a>'
        :(data==2)? '<a  class="btn btn-xs" class="btn btn-xs" style="background-color:red  ; color:white;">Pembayaran Gagal</a>'
        :(data==3)? '<a  class="btn btn-xs"    style="background-color:green  ; color:white;">Pembayaran Berhasil</a>'
        : '<a  class="btn btn-xs"   style="background-color:black  ; color:white;">Belum Bayar</a>';
            
}

function checkStatusPenerbitanOrderConfirmation(data){

    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload OC</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Konfirmasi Pelaku Usaha</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Konfirmasi Admin</a>'
    :(data==3)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Penerbitan OC Gagal</a>'
    :(data==4)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Penerbitan OC Terkonfirmasi</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload OC</a>';

  
           
}

function checkStatusPelunasan(data){

    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Bayar</a>'
        :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Konfirmasi Admin</a>'
        :(data==2)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Pembayaran Gagal</a>'
        :(data==3)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Pembayaran Berhasil</a>'
        : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Bayar</a>';
           
}

function checkStatusBerkas(data){

    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Berkas</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Admin Verfikasi Berkas</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Perbaikan Berkas</a>'
    :(data==3)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Berkas Terverifikasi</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Berkas</a>';
   
}

function checkStatusAuditTahap1(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Berkas</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Auditor Memverifikasi Berkas</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Perbaikan Berkas</a>'
    :(data==3)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Audit tahap 1 Selesai</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Berkas</a>';

    
}

function checkStatusAuditTahap2(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Laporan Audit</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Perbaikan Audit Tahap 2</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Audit Tahap 2 Selesai</a>'
   
   
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Audit Plan</a>';

    
            
}

function checkStatusTehnicalReview(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Tehnical Reviewer Belum Upload Review Laporan Audit</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:green; color:white;">Proses Tehnical Review Selesai</a>'
   
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Tehnical Reviewer Belum Upload Review Laporan Audit</a>';

    
            
}

function checkStatusKomite(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Proses Tehnical Review Selesai</a>'
   
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</a>';

    
            
}

function checkStatusPersiapanKomisiFatwa(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Proses Tehnical Review Selesai</a>'
   
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</a>';

    
            
}

            



function checkStatusKebutuhanAudit(data){

    return  (data==0)? '<a  class="btn btn-xs" style="word-wrap:break-word; background-color:black  ; color:white;">Kebutuhan Waktu Audit Belum Ditentukan</a>'
    :(data==1)? '<a  class="btn btn-xs" style="word-wrap:break-word; background-color:yellow  ; color:black;">Menunggu Reviewer Mengkonfirmasi Kebutuhan Waktu Audit</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Perbaikan Kebutuhan Waktu Audit</a>'
    :(data==3)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Kebutuhan Waktu Audit Terkonfirmasi</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Kebutuhan Waktu Audit Belum Ditentukan</a>';


    
            
}



function checkPenjadwalan(data){
    return  (data==0)? '<a  class="btn btn-xs " style="background-color:black  ; color:white;">Belum Dijadwalkan</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:yellow  ; color:black;">Menunggu Reviewer Mengkonfirmasi Jadwal</a>'
    :(data==2)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Perbaikan Penjadwalan</a>'
    :(data==3)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Penjadwalan Terkonfirmasi</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Dijadwalkan</a>';
  
}


// function checkStatusAkad(data){

//      return  (data==0)? '<a  class="btn btn-xs" class="ion-ios-clipboard" title="Belum Akad" style="font-size: 200%;"></a>'
//             :(data==1)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Konfirmasi"></a>'
//             :(data==2)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;color:#e32636 ;" title="Perbaikan"></a>'
//             :(data==3)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;color:#32cd32 ;" title="Penawaran Terkonfirmasi"></a>'
//             :(data==4)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Pelaku Usaha Megupload Ulang Kontrak"></a>'
//             :(data==5)? '<a  class="btn btn-xs"  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color: #e32636;"title="Pelaku Usaha Menolak Penawaran"></a>'
//             :(data==6)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="align-center; font-size: 200%; color:yellow; " title="Pelaku Usaha Sudah Upload Ulang dan Menunggu Konfirmasi Sales"></a>'
//             :(data==7)? '<a  class="btn btn-xs"  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color: #e32636;"title="Penawaran Gagal"></a>'
//             :(data==8)? '<a  class="btn btn-xs"  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color:#32cd32 ;"title="Penawaran Terkonfirmasi"></a>'
//             :'<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Akad"></a>';
            
// }

function checkStatusAkad(data){
    return  (data==0)? '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Akad</a>'
    :(data==1)? '<a  class="btn btn-xs" style="background-color:green  ; color:white;">Sudah Upload Bukti Penawaran dan Akad</a>'
    : '<a  class="btn btn-xs" style="background-color:black  ; color:white;">Belum Upload Dokumen Penawaran dan Akad</a>';
    
            
}

// function checkStatusBeritaAcara(data){

//      return  (data==0)? '<a  class="btn btn-xs" class="ion-ios-clipboard" title="Berita Acara Belum Diupload" style="font-size: 200%;"></a><br>Admin'
//             :(data==1)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Pelaku Usaha Megupload Ulang Berita Acara"></a><br>Pelaku Usaha'
//             :(data==2)? '<a  class="btn btn-xs"  class="ion-ios-clipboard " style="align-center; font-size: 200%; color:#32cd32; " title="Pelaku Usaha Sudah Upload Ulang Berita Acara"></a>'
//             :'<a  class="btn btn-xs"  class="ion-ios-clipboard " style="zoom:2.0;" title="Berita Acara Belum Diupload"></a>';
            
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
            :(data==7)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Persiapan Audit Tahap1</a>'
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
            :(data==9)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Persiapan Audit Tahap2</a>'
            :(data.trim()=='9_0')? 'Belum Dijadwalkan'
            :(data.trim()=='9_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='9_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='9_3')? 'Penjadwalan Terkonfirmasi'
            //Proses Audit Tahap 2
            :(data==10)? 'Proses Audit Tahap 2'
            :(data.trim()=='10_1')? 'Perbaikan Audit Tahap 2'
            :(data.trim()=='10_2')? 'Audit Tahap 2 Selesai'

            :(data==11)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Persiapan Tehnical Review</a>'
            :(data.trim()=='11_0')? 'Belum Dijadwalkan'
            :(data.trim()=='11_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='11_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='11_3')? 'Penjadwalan Terkonfirmasi'

            :(data==12)? 'Proses Tehnical Review'
            :(data.trim()=='12_0')? 'Reviewer Belum Upload Review Laporan Audit'
            :(data.trim()=='12_1')? 'Proses Tehnical Review Selesai'

            :(data==13)? '<a  class="btn btn-xs" style="background-color:red  ; color:white;">Persiapan Komite Sertifikasi</a>'
            :(data.trim()=='13_0')? 'Belum Dijadwalkan'
            :(data.trim()=='13_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='13_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='13_3')? 'Penjadwalan Terkonfirmasi'

            :(data==14)? 'Proses Komite Sertifikasi'
            :(data.trim()=='14_0')? 'Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit'
            :(data.trim()=='14_1')? 'Proses Komite Sertifkasi Selesai'

            :(data==15)? 'Proses Persiapan Sidang Penetapan Kehalalan Produk'
            :(data.trim()=='15_0')? 'Reviewer Belum Mereview Laporan Hasil Akhir Audit'
            :(data.trim()=='15_1')? 'Laporan Akhir Audit Terkonfirmasi'
            
            :(data==16)? 'Proses Sidang Penetapan Kehalalan Produk'
            :(data==17)? 'Ketetapan Halal'
            :'_';
}

function notifProgress(data){
    console.log(data);
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

            :(data==11)? 'Persiapan Tehnical Review'
            :(data.trim()=='11_0')? 'Belum Dijadwalkan'
            :(data.trim()=='11_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='11_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='11_3')? 'Penjadwalan Terkonfirmasi'

            :(data==12)? 'Proses Tehnical Review'
            :(data.trim()=='12_0')? 'Reviewer Belum Upload Review Laporan Audit'
            :(data.trim()=='12_1')? 'Proses Tehnical Review Selesai'

            :(data==13)? 'Persiapan Komite Sertifikasi'
            :(data.trim()=='13_0')? 'Belum Dijadwalkan'
            :(data.trim()=='13_1')? 'Menunggu Reviewer Mengkonfirmasi Penjadwalan'
            :(data.trim()=='13_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='13_3')? 'Penjadwalan Terkonfirmasi'

            :(data==14_0)? 'Proses Komite Sertifikasi'
            :(data.trim()=='14_0')? 'Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit'
            :(data.trim()=='14_1')? 'Proses Komite Sertifkasi Selesai'

            :(data==15)? 'Proses Persiapan Sidang Penetapan Kehalalan Produk'
            :(data.trim()=='15_0')? 'Reviewer Belum Mereview Laporan Hasil Akhir Audit'
            :(data.trim()=='15_1')? 'Laporan Akhir Audit Terkonfirmasi'
            
            :(data==16)? 'Proses Sidang Penetapan Kehalalan Produk'
            :(data==17)? 'Ketetapan Halal'
            :'_';
           
}
/*
function checkIcon(data){
    var showData = (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":"<i class='ion-md-checkmark fa-lg color-green'></i>";
    return showData;
}
function checkRutr(data){
    var xdata = (data==1)? "Investasi":((data==2) ? "Perumahan" : (data==3) ? "Perkebunan" :  "<i class='ion-md-remove fa-lg color-grey'></i>");
    return xdata;
}
function checkFisik(data){
    return (data==0)? "Rusak":((data==1) ? "Baik" : "<i class='ion-md-remove fa-lg color-grey'></i>") ;
}
function checkFisikDetail(data){
    return  (data==1)? "Perlu perbaikan"
        :(data==2)? "Siap digunakan"
            :(data==3)? "Masih bisa digunakan"
                :(data==4)? "Tidak bisa digunakan"
                : "<i class='ion-md-remove fa-lg color-grey'></i>";
}

function checkUtility(data){
    return (data==0)? "Idle":((data==1) ? "Terpakai" : "<i class='ion-md-remove fa-lg color-grey'></i>");
}
function checkAir(data){
    return (data==0)? "Air Tanah":((data==1) ? "PAM" : "<i class='ion-md-remove fa-lg color-grey'></i>");
}
function checkListrik(data){
    return  (data==1)? "PLN"
        :(data==2)? "Genset"
            :(data==3)? "Solar Cell"
            : "<i class='ion-md-remove fa-lg color-grey'></i>";
}
function checkStatus(data){
    return (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":"<i class='ion-md-checkmark fa-lg color-green'></i>";
}
function checkTelekomunikasi(data){
    return (data==0)? "Fixed":((data==1) ? "Cellular" : "<i class='ion-md-remove fa-lg color-grey'></i>");
}
function checkSpekMobilitas(data){
    return (data==0)? "Portable":((data==1) ? "Fixed" : "<i class='ion-md-remove fa-lg color-grey'></i>");
}
function checkSpekSDK(data){
    return (data==0)? "<i class='ion-md-remove fa-lg color-grey'></i>":((data==1) ? "<i class='ion-md-checkmark fa-lg color-green'></i>" : "<i class='ion-md-remove fa-lg color-grey'></i>");
}
function currencyFormat(num) {
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}*/