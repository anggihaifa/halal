/*Tanah Bangunan*/
function checkStatus(data){
    var showData = (data==0)? "Non Aktif":"Aktif";
    return showData;
}

function checkStatusPembayaran(data){

     return  (data==0)? '<a class=" ion-ios-clipboard" title="Belum Bayar" style="font-size: 200%;"></a> <br>Pelaku Usaha'
        :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow  ;" title="Pelaku Usaha Sudah Upload dan Menunggu Konfirmasi"></a> <br>Sales'
        :(data==2)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #e32636;;"title="Pembayaran Gagal"></a>'
        :(data==3)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #32cd32;"title="Pembayaran Terkonfirmasi"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Bayar"></a><br>Pelaku Usaha';
            
}

function checkStatusPenerbitanOrderConfirmation(data){

    return  (data==0)? '<a class=" ion-ios-clipboard" title="Belum diupload" style="font-size: 200%;"></a> <br>Admin'
       :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow  ;" title="Menunggu Pelaku Usaha Upload Ulang OC"></a> <br>Pelaku Usaha'
       :(data==2)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow  ;" title="Menunggu Konfirmasi Admin"></a> <br>Admin'
       :(data==3)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #e32636;;"title="Penerbitan OC Gagal"></a>'
       :(data==4)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #32cd32;"title="Penerbitan OC Terkonfirmasi"></a>'
       :'<a  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Bayar"></a><br>Admin';
           
}

function checkStatusPelunasan(data){

    return  (data==0)? '<a class=" ion-ios-clipboard" title="Belum Bayar Pelunasan" style="font-size: 200%;"></a><br>Pelaku Usaha'
       :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow  ;" title="Pelaku Usaha Sudah Upload dan Menunggu Konfirmasi"></a> <br>Sales'
       :(data==2)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #e32636;;"title="Pembayaran Gagal"></a>'
       :(data==3)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center; color: #32cd32;"title="Pembayaran Terkonfirmasi"></a>'
       :'<a  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Bayar"></a><br>Pelaku Usaha';
           
}

function checkStatusBerkas(data){
    return  (data==0)? '<a class="ion-ios-clipboard " style="font-size: 200%;" 0.73em; title="Belum Upload"></a><br>Pelaku Usaha'
        :(data==1)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Admin Memverifikasi Berkas"></a> <br>Admin'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center;color:#e32636; font-size: 200%;" title="Perbaikan"></a><br>Pelaku Usaha'
        :(data==3)? '<a  class="ion-ios-clipboard " style=" align-center; color: #32cd32; font-size: 200%;"title="Berkas Terkonfirmasi"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%;"  title="Belum Upload"></a><br>Pelaku Usaha';
            
}

function checkStatusBerkasAuditTahap1(data){
    return  (data==0)? '<a class="ion-ios-clipboard " style="font-size: 200%;" 0.73em; title="Belum Upload"></a><br>Pelaku Usaha'
        :(data==1)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Auditor Memverifikasi Berkas"></a> <br>Auditor'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center;color:#e32636; font-size: 200%;" title="Perbaikan"></a><br>Pelaku Usaha'
        :(data==3)? '<a  class="ion-ios-clipboard " style=" align-center; color: #32cd32; font-size: 200%;"title="Audit Tahap 1 Selesai"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%;"  title="Belum Upload"></a><br>Pelaku Usaha';
            
}

function checkStatusBerkasAuditTahap2(data){
    return  (data==0)? '<a class="ion-ios-clipboard " style="font-size: 200%;" 0.73em; title="Belum Upload Audit Plan"></a><br>Auditor'
        :(data==1)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Konfirmasi Audit Plan Pelaku Usaha"></a><br>Pelaku Usaha'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center;color:#e32636; font-size: 200%;" title="Pelaku Usaha Menolak Audit Plan"></a>'
        :(data==3)? '<a  class="ion-ios-clipboard " style=" align-center; color: #32cd32; font-size: 200%;"title="Audit Plan Terkonfirmasi"></a>'
        :(data==4)? '<a  class="ion-ios-clipboard " style="color:yellow font-size: 200%;" title="Menunggu Konfirmasi Tehnical Reviewer"></a><br>Tehnical Reviewer'
        :(data==5)? '<a  class="ion-ios-clipboard " style="align-center;color:#e32636; font-size: 200%;" title="Perbaikan Audit Tahap 2"></a><br>Auditor'
        :(data==6)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Konfirmasi Komite Sertifikasi"></a><br>Komite Sertifikasi'
        :(data==7)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Konfirmasi Reviewer Operasi"><br>Reviewer Operasi</a>'
        :(data==8)? '<a  class="ion-ios-clipboard " style=" align-center; color: #32cd32; font-size: 200%;"title="Laporan Audit Tahap 2 Terkonfirmasi"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%;"  title="Belum Upload Audit Plan"></a><br>Auditor';
            
}


function checkStatusWaktuKebutuhanAudit(data){
    return  (data==0)? '<a class="ion-ios-clipboard " style="font-size: 200%;" 0.73em; title="Belum ditentukan"></a><br>Verifikator'
        :(data==1)? '<a  class="ion-ios-clipboard " style="color:yellow; font-size: 200%;" title="Menunggu Konfirmasi"></a><br>Reviewer Operasi'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center;color:#e32636; font-size: 200%;" title="Perbaikan"></a><br>Verifikator'
        :(data==3)? '<a  class="ion-ios-clipboard " style=" align-center; color: #32cd32; font-size: 200%;"title="Formulir Perhitungan Waktu Audit Terkonfirmasi"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%;"  title="Belum ditentukan"></a><br>Verifikator';
            
}



function checkPenjadwalan(data){
    return  (data==0)? '<a  class="ion-ios-clipboard " style="font-size: 200%; color:black;" title="Belum Dijadwalkan"></a><br>Admin'
        :(data==1)? '<a   class="ion-ios-clipboard " style="font-size: 200%;color:yellow;" title="Menunggu Konfirmasi Reviewer"></a> <br>Reviewer Operasi'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%;color:#e32636;  title="Perbaikan"></a><br>Admin'
        :(data==3)? '<a  class="ion-ios-clipboard " style="font-size: 200%; align-center;color:#32cd32;"title="Perjadwalan Terkonfirmasi"></a>'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%; color:black;" title="Belum Dijadwalkan"></a><br>Admin';
            
}

function checkOC(data){
    return  (data==0)? '<a  class="ion-ios-clipboard " style="font-size: 200%; color:black;" title="Belum Upload OC"></a><br>Sales Account Officer'
        :(data==1)? '<a   class="ion-ios-clipboard " style="font-size: 200%;color:yellow;" title="Menunggu Konfirmasi Pelaku Usaha"></a> <br>Pelaku Usaha'
        :(data==2)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%;color:#32cd32;  title="OC Telah Di Upload dan Dikonfirmasi Oleh Pelaku Usaha"></a><br>Pelaku Usaha'
        :(data==3)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%;color:#e32636;  title="OC Gagal"></a><br>Pelaku Usaha'
        :(data==4)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%;color:#32cd32;  title="OC Berhasil"></a><br>Pelaku Usaha'
        :'<a  class="ion-ios-clipboard " style="font-size: 200%; color:black;" title="Belum Upload OC"></a><br>Admin';
            
}

// function checkStatusAkad(data){

//      return  (data==0)? '<a class="ion-ios-clipboard" title="Belum Akad" style="font-size: 200%;"></a>'
//             :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Konfirmasi"></a>'
//             :(data==2)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:#e32636 ;" title="Perbaikan"></a>'
//             :(data==3)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:#32cd32 ;" title="Penawaran Terkonfirmasi"></a>'
//             :(data==4)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Pelaku Usaha Megupload Ulang Kontrak"></a>'
//             :(data==5)? '<a  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color: #e32636;"title="Pelaku Usaha Menolak Penawaran"></a>'
//             :(data==6)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%; color:yellow; " title="Pelaku Usaha Sudah Upload Ulang dan Menunggu Konfirmasi Sales"></a>'
//             :(data==7)? '<a  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color: #e32636;"title="Penawaran Gagal"></a>'
//             :(data==8)? '<a  class="ion-ios-clipboard  " style="font-size: 200%; align-center; color:#32cd32 ;"title="Penawaran Terkonfirmasi"></a>'
//             :'<a  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Akad"></a>';
            
// }

function checkStatusAkad(data){

     return  (data==0)? '<a class="ion-ios-clipboard" title="Belum Upload Bukti Akad" style="font-size: 200%;"></a><br>Sales Account Officer'
            :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:#32cd32; ;" title="Sudah Upload Bukti Penawaran dan Akad"></a><br>Sales Account Officer'
            :'<a  class="ion-ios-clipboard " style="font-size: 200%;" title="Belum Penawaran dan Akad"></a>';
            
}

function checkStatusBeritaAcara(data){

     return  (data==0)? '<a class="ion-ios-clipboard" title="Berita Acara Belum Diupload" style="font-size: 200%;"></a><br>Admin'
            :(data==1)? '<a  class="ion-ios-clipboard " style="font-size: 200%;color:yellow ;" title="Menunggu Pelaku Usaha Megupload Ulang Berita Acara"></a><br>Pelaku Usaha'
            :(data==2)? '<a  class="ion-ios-clipboard " style="align-center; font-size: 200%; color:#32cd32; " title="Pelaku Usaha Sudah Upload Ulang Berita Acara"></a>'
            :'<a  class="ion-ios-clipboard " style="zoom:2.0;" title="Berita Acara Belum Diupload"></a>';
            
}

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
            :(data==7)? 'Penjadwalan'
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
            :(data==9)? 'Pembayaran Tahap 2'
            :(data.trim()=='9_0')? 'Belum Upload Bukti Bayar'
            :(data.trim()=='9_1')? 'Menunggu Sales Officer Mengkonfirmasi Pembayaran Tahap 2'
            :(data.trim()=='9_2')? 'Pembayaran Tahap 2 Gagal'
            :(data.trim()=='9_3')? 'Pembayaran Tahap 2 Terkonfirmasi'
            //Proses Audit Tahap 2
            :(data==10)? 'Proses Audit Tahap 2'
            :(data.trim()=='10_0')? 'Belum Upload Audit Plan'
            :(data.trim()=='10_1')? 'Menunggu Pelaku Usaha Mwngkonfirmasi Audit Plan'
            :(data.trim()=='10_2')? 'Pelaku Usaha Menolak Audit Plan'
            :(data.trim()=='10_3')? 'Audit Plan Terkonfirmasi'
            :(data.trim()=='10_4')? 'Menunggu Tehnical Reviewer Mengkonfirmasi Laporan Audit'
            :(data.trim()=='10_5')? 'Perbaikan Laporan Audit Tahap 2'
            :(data.trim()=='10_6')? 'Menunggu Komite Sertifikasi Mengkonfirmasi Laporan Audit'
            :(data.trim()=='10_7')? 'Menunggu Reviewer Operasi Mengkonfirmasi Laporan Audit'
            :(data.trim()=='10_8')? 'Laporan Audit Tahap 2 Terkonfirmasi'
            //Berita Acara
            :(data==11)? 'Penyampaian Berita Acara'
            :(data.trim()=='11_0')? 'Belum Upload Berita Acara'
            :(data.trim()=='11_1')? 'Menunggu Pelaku Usaha Upload Ulang Berita Acara'
            :(data.trim()=='11_2')? 'Berita Acara Terkonfirmasi'
            //Pelunasan
            :(data==12)? 'Pelunasan'
            :(data.trim()=='12_0')? 'Belum Upload Bukti Bayar'
            :(data.trim()=='12_1')? 'Menunggu Sales Officer Mengkonfirmasi Pelunasan'
            :(data.trim()=='12_2')? 'Pelunasan Gagal'
            :(data.trim()=='12_3')? 'Pelunasan Terkonfirmasi'
            //Proses Sidang Fatwa
            :(data==13)? 'Proses Sidang Fatwa'
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
            //pembayaran tahap 1
            :(data==6)? 'Silahkan Melakukan Pembayaran Sesuai dengan Akad'
            :(data.trim()=='6_0')? 'Silahkan Melakukan Pembayaran Sesuai dengan Akad'
            :(data.trim()=='6_1')? 'Silahkan Menunggu Berkas Bukti Transfer Dikonfirmasi oleh Sales Admin'
            :(data.trim()=='6_2')? 'Pembayaran Gagal Silahkan Upload Ulang Bukti Transfer Uang Muka Pastikan Foto Terlihat Jelas'
            :(data.trim()=='6_3')? 'Pembayaran  Sesuai dan Akan Dilanjutkan Pada Proses Selanjutnya Yaiut Proses Audit'
            //penerbitan OC
            :(data==5)? 'Penerbitan OC'
            :(data.trim()=='5_0')? 'Penerbitan OC'
            :(data.trim()=='5_1')? 'Silahkan mengupload Order Confirmation yang Sudah Ditandatangani'
            :(data.trim()=='5_2')? 'Silahkan Menunggu Admin Memverifikasi Order Confirmation'
            :(data.trim()=='5_3')? 'Order Confirmation Tidak Sesuai, Gagal Diterbitkan. Silahkan Upload Ulang dan Pastikan Dokumen Sudah Ditandatangani'
            :(data.trim()=='5_4')? 'Order COnfirmation Sudah Terkonfirmasi Silahkan Melanjutkan Ke Tahapan Selanjutnya Penjadwalan'
            //Penjadwalan
            :(data==7)? 'Penjadwalan'
            :(data.trim()=='7_0')? 'Belum Dijadwalkan'
            :(data.trim()=='7_1')? 'Silahkan Menunggu Reviewer Menyetujui Penjadwalan'
            :(data.trim()=='7_2')? 'Perbaikan Penjadwalan'
            :(data.trim()=='7_3')? 'Penjadwalan Terkonfirmasi Silahkan Melanjutkan ke Tahapan Selanjutnya : Proses Audit Tahap 1 Audit Tahap 1'
            //Proses Audit Tahap 1
            :(data==8)? 'Proses Audit Tahap 1: Silahkan Lengkapi Berkas'
            :(data.trim()=='8_1')? 'Silahkan Menunggu Auditor Untuk Memeriksa Kesesuaian Berkas'
            :(data.trim()=='8_2')? 'Berkas Tidak Sesuai, Silahkan Cek Kembali Catatan Ketidaksesuaian Pada Halaman Laporan Audit Tahap 1'
            :(data.trim()=='8_3')? 'Audit Tahap 1 Selesai, Silahkan Melanjutkan ke Tahapan Selanjutnya Pembayaran Tahap 2. (Apabila Nominal diatas 50 Jt)'
            //Pembayaran Tahap 2
            :(data==9)? 'Silahkan Melakukan Pembayaran Tahap 2 Sesuai dengan Akad'
            :(data.trim()=='9_0')? 'Silahkan Melakukan Pembayaran Tahap 2 Sesuai dengan Akad'
            :(data.trim()=='9_1')? 'Silahkan  Menunggu Berkas Bukti Transfer Pembayaran Tahap 2 Dikonfirmasi oleh Sales Admin'
            :(data.trim()=='9_2')? 'Pembayaran Gagal Silahkan Upload Ulang Bukti Transfer Pembayaran Tahap 2 Pastikan Foto Terlihat Jelas'
            :(data.trim()=='9_3')? 'Pembayaran Tahap 2 Sesuai dan Akan Dilanjutkan Pada Proses Selanjutnya Yaiut Proses Audit'
            //Proses Audit Tahap 2
            :(data==10)? 'Proses Audit Tahap 2 : Silahkan Kontak CS Kami Untuk Infromasi Lebih Lengkap Terkait Audit Lapangan'
            :(data.trim()=='10_0')? 'Belum Upload Audit Plan'
            :(data.trim()=='10_1')? 'Menunggu Konfirmasi Pelaku Usaha'
            :(data.trim()=='10_2')? 'Audit Plan Ditolak'
            :(data.trim()=='10_3')? 'Audit Plan Terkonfirmasi'
            :(data.trim()=='10_4')? 'Menunggu Konfirmasi Tehnical Review'
            :(data.trim()=='10_5')? 'Perbaikan Laporan Audit Tahap 2'
            :(data.trim()=='10_6')? 'Menunggu Konfirmasi Komite Sertifikasi'
            :(data.trim()=='10_7')? 'Menunggu Konfirmasi Reviewer Operasi (Pak Juli)'
            :(data.trim()=='10_8')? 'Laporan Audit Tahap 2 Terkonfirmasi'
            //Berita Acara
            :(data==11)? 'Berita Acara'
            :(data.trim()=='11_0')? 'Belum Upload Berita Acara'
            :(data.trim()=='11_1')? 'Silahkan Upload Ulang Berita Acara Yang Sudah Ditandatangani'
            :(data.trim()=='11_2')? 'Berita Acara Terkonfirmasi Silahkan Lanjutkan Tahapan Berikutnya : Pelunasan dan Penerbitan Invoice'
            //Pelunasan
            :(data==12)? 'Silahkan Melakukan Pelunasan Sesuai Dengan Akad'
            :(data.trim()=='12_0')? 'Silahkan Upload Bukti Pelunasan'
            :(data.trim()=='12_1')? 'Silahkan Menunggu Konfirmasi Sales'
            :(data.trim()=='12_2')? 'Pelunasan Gagal Silahkan Upload Ulang Bukti Pelunasan'
            :(data.trim()=='12_3')? 'Pelunasan Sesuai dan Akan Dilanjutkan Pada Proses Selanjutnya Yaitu Penerbitan Invoice'
            //Proses Sidang Fatwa
            :(data==13)? 'Proses Sidang Fatwa'
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