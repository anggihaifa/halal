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
            :(data==3)? 'Kaji Ulang Permohonan'
                :(data==4)? 'Pembayaran Akad'
                    :(data==5)? 'Proses Audit'
                        :(data==6)? 'Tinjauan Hasil Audit'
                            :(data==7)? 'Rekomendasi Hasil Pemeriksaan'
                                :(data==8)? 'Proses Sertifikasi'
                                    :(data==9)? 'Keputusan Halal/ Haram'
                                        :(data==10)? 'Sertifikat Halal'
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