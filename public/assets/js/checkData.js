/*Tanah Bangunan*/
function checkStatus(data){
    var showData = (data==0)? "Non Aktif":"Aktif";
    return showData;
}

function checkStatusPembayaran(data){
    return  (data==0)? '<a href="#" class="btn btn-grey btn-xs text-nowrap valign-middle">Belum Bayar</a>'
        :(data==1)? '<a href="#" class="btn btn-warning btn-xs text-nowrap valign-middle">Menunggu Konfirmasi</a>'
            :(data==2)? '<a href="#" class="btn btn-success btn-xs text-nowrap valign-middle">Sudah Dikonfirmasi</a>'
                :'<a href="#" class="btn btn-grey btn-xs text-nowrap valign-middle">Belum Bayar</a>';
            
}
function checkStatusFaq(data){
    return  (data=='nonaktif')? 'Non Aktif'
        :(data=='aktif')? 'Aktif'
            :(data=='transfer')? 'Transfer'
                :(data=='tunai')? 'Tunai'
                    :'-';
            
}
function checkProgress(data){
    return  (data==1)? 'Pengajuan Baru'
                :(data==2)? 'Melengkapi Berkas'
                    :(data==3)? 'Verifikasi Data'
                        :(data==4)? 'Perbaiki Data Berkas'
                            :(data==5)? 'Konfirmasi Data Berkas'
                                :(data==6)? 'Akad'
                                    :(data==7)? 'Akad Gagal'
                                         :(data==8)? 'Konfirmasi Akad'
                                            :(data==9)? 'Pembayaran'
                                                :(data==10)? 'Nominal Pembayaran Kurang'
                                                     :(data==11)? 'Nominal Pembayaran Lebih'
                                                        :(data==12)? 'Pembayaran Gagal'
                                                            :(data==13)? 'Konfirmasi Pembayaran'
                                                                :(data==14)? 'Proses Audit Tahap 1'
                                                                    :(data==15)? 'Proses Audit Tahap 2'
                                                                        :(data==16)? 'Pelaporan Audit tahap 2'
                                                                            :(data==17)? 'Konfirmasi Berita Acara'
                                                                                :(data==18)? 'Tinjauan Hasil Audit'
                                                                                    :(data==19)? 'Rekomendasi Hasil Pemeriksaan'
                                                                                         :(data==20)? 'Hasil Dikirim ke MUI'
                                                                                             :(data==21)? 'Pelunasan'
                                                                                                :(data==22)? 'Nominal Pelunasan Kurang'
                                                                                                    :(data==23)? 'Nominal Pelunasan Lebih'
                                                                                                        :(data==24)? 'Pelunasan Gagal'
                                                                                                            :(data==25)? 'Konfirmasi Pelunasan'
                                                                                                                :(data==26)? 'Proses Sertifikasi'
                                                                                                                    :(data==27)? 'Keputusan Halal/ Haram'
                                                                                                                        :(data==28)? 'Sertifikat Halal'
                                                                                                                            :'-';
                                                                                     

}

function notifProgress(data){
    return  (data==1)? 'Pengajuan Baru Berhasil Silahkan Lanjutkan Upload Berkas Pada Menu Unggah Data'
                :(data==2)? 'Tolong Lengkapi Berkas Pada Menu Unggah Data Sertifikasi'
                    :(data==3)? 'Berkas Berhasil diunggah dan Sedang Dilakukan Verivikasi Data, Mohon Tunggu 1 Hari Kerja'
                        :(data==4)? 'Berkas Sertifikasi Perlu Diperbaiki, Silahkan Cek Menu Unggah Data Sertifikasi Pada Kolom Catatan'
                            :(data==5)? 'Berkas Sertifikasi Sudah Berhasil Terverivikasi Silahkan Melakukan Kontrak Akad'
                                :(data==6)? 'Silahkan Melakukan Kontrak Akad Pada Menu Akad dengan Cara Mengunduh Berkas Kontrak Lalu Mengupload Kembali Berkas Yang Sudah Disetujui (Tanda Tangan)'
                                    :(data==7)? 'File Kontrak Yang Diupload Tidak Benar/ Rusak Tolong Upload Ulang File Kontrak Akad Yang Benar'
                                         :(data==8)? 'Kontrak Akad Telah Diterima Silahkan Lanjutkan Pembayaran Pada Menu Pembayaran Dengan Cara Melakukan Upload Bukti Trasnfer Uang Muka Sesuai Kesepakatan Pada Kontrak Akad'
                                            :(data==9)? 'Silahkan Upload Bukti Trasnfer Uang Muka Pada Menu Pembayaran Sesuai dengan Kontrak Akad'
                                                :(data==10)? 'Nominal Pembayaran Uang Muka Pada Bukti Transfer Kurang Silahkan Upload Lagi Sejumlah Nominal Yang Kurang'
                                                     :(data==11)? 'Nominal Pembayaran Uang Muka Pada Bukti Transfer Lebih Kami Akan Mengembalikan Kelebihan Uang Dalam 1 Hari Kerja'
                                                        :(data==12)? 'Pembayaran Gagal Silahkan Upload Ulang Bukti Transfer Uang Muka Pastikan Foto Terlihat Jelas'
                                                            :(data==13)? 'Nominal Pembayaran Uang Muka Sesuai dan Akan Dilanjutkan Pada Proses Selanjutnya Yaiut Proses Audit'
                                                                :(data==14)? 'Proses Audit Tahhap 1 Sedang Berlangsung Harap Tunggu 1 Hari Kerja'
                                                                    :(data==15)? 'Proses Audit Tahap 2 Sedang Dijadwalkan Harap Bersiap Untuk Kunjungan Lapangan'
                                                                        :(data==16)? 'Laporan Audit Tahap 2 Dan Berita Acara Audit Tahap 2 Sudah Diupload Silahkan cek Pada Menu Pelaporan dan Unduh File Laporan Audit Tahap 2 Dan Berita Acara Lalu Klik Konfirmasi Berita Acara'
                                                                            :(data==17)? 'Berita Acara Berhasil Dikonfirmasi '
                                                                                :(data==18)? 'Tinjauan Hasil Audit Sedang Berlangsung Silahkan Tunggu 1 Hari Kerja'
                                                                                    :(data==19)? 'Rekomendasi Hasil Pemeriksaan Oleh Komite Ahli Sedang Berlangsung Silahkan Tunggu 1 Hari Kerja'
                                                                                         :(data==20)? 'Hasil Rekomendasi Tinjauan Komite Ahli Sudah Dikirmkan Ke EMAIL MUI untuk Proses FATWA yang akan Berlangsung Selama 3 Hari Kerja. Silahkan Lakukan Pelunasan Dengan Nominal Sesuai Kontrak Akad'
                                                                                             :(data==21)? 'Silahkan Upload Bukti Pelunasan Pada Menu Pelunasan'
                                                                                                :(data==22)? 'Nominal Pelunasan Pada Bukti Transfer Kurang Silahkan Upload Lagi Sejumlah Nominal Yang Kurang'
                                                                                                    :(data==23)? 'Nominal Pelunasan Pada Bukti Transfer Lebih Kami Akan Mengembalikan Kelebihan Uang Dalam 1 Hari Kerja'
                                                                                                        :(data==24)? 'Pelunasan Gagal Silahkan Upload Ulang Bukti Transfer Uang Muka Pastikan Foto Terlihat Jelas'
                                                                                                            :(data==25)? 'Nominal Pelunasan Sesuai'
                                                                                                                :(data==26)? 'Proses Sertifikasi'
                                                                                                                    :(data==27)? 'Keputusan Halal/ Haram'
                                                                                                                        :(data==28)? 'Sertifikat Halal'
                                                                                                                            :'-';
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