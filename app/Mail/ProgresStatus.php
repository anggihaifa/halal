<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProgresStatus extends Mailable
{
    use Queueable, SerializesModels;

   
    public $registrasi;
    public $user;
    public $pembayaran;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registrasi, $user, $pembayaran, $status)
    {        
       
        $this->registrasi = $registrasi;
        $this->user = $user;
        $this->pembayaran = $pembayaran;
        $this->status = $status;
         //dd( $this);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd( $this);
        // if($this->status == 2){
        //     $this->subject('Melengkapi Berkas - No registrasi '.$this->registrasi['no_registrasi']);
        // }elseif($this->status == '2_2'){

        //     $this->subject('Verifikasi Berkas Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Perbaikan');

        // }elseif($this->status == '2_3'){

        //     $this->subject('Verifikasi Berkas '.$this->registrasi['no_registrasi'].'- Terkonfirmasi ');                

        // }elseif($this->status == '4_1'){

        //     $this->subject('Kontrak Akad '.$this->registrasi['no_registrasi'].'- Berkas Penawaran dan Akad Sudah Tersedia');
        // }elseif($this->status == 6){

        //     $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Menyelesaikan Pembayaran');

        // }elseif($this->status == '6_2'){

        //     $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -GAGAL');

        // }elseif($this->status == '6_3'){

        //      $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Terkonfirmasi');

        //      $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap1']),[
        //             'as' => $this->pembayaran['bt_tahap1'],
        //             'mime' => 'application/pdf',

        //      ]);

        

        // }elseif($this->status == '5_1'){

        //      $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Silahkan Upload Ulang Order Confirmation Yang Sudah Di Tanda Tangani');      

        // }elseif($this->status == '5_3'){

        //     $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Penerbitan OC Gagal');      

        // }elseif($this->status == '5_4'){

        //     $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Penerbita OC Terkonfirmasi');      
        
        // }elseif($this->status == 8){

        //     $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Audit Tahap 1');  

        // }elseif($this->status == '8_2'){

        //     $this->subject('Verifikasi Berkas Audit Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Perbaikan');

        // }elseif($this->status == '8_3'){

        //     $this->subject('Verifikasi Berkas Audit Tahap 1 Dengan Nomor Registrasi '.$this->registrasi['no_registrasi'].'- Terkonfirmasi ');                
        // }elseif($this->status == 9){

        //     $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Menyelesaikan Pembayaran Tahap 2');

        // }elseif($this->status == '9_2'){

        //     $this->subject('Pembayaran Tahap 2 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -GAGAL');

        // }elseif($this->status == '9_3'){

        //         $this->subject('Pembayaran Tahap 2 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Terkonfirmasi');

        //         $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap2']),[
        //             'as' => $this->pembayaran['bt_tahap2'],
        //             'mime' => 'application/pdf',

        //         ]);
        // }elseif($this->status == 10){

        //     $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Audit Tahap 2');  

        // }elseif($this->status == '10_1'){

        //     $this->subject('Proses Audit Tahap 2'.$this->registrasi['no_registrasi'].' - Silahkan Menyetujui Audit Plan');

        // }elseif($this->status == '10_3'){

        //     $this->subject('Proses Audit Tahap 2'.$this->registrasi['no_registrasi'].' - Audit Plan Terkonfirmasi');      

        // }elseif($this->status == '11_1'){
        //     //
        //     $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Silahkan Upload Ulang Berita Acara Yang Sudah Ditandatangani');      

        //     $this->attach(public_path('storage/beritaacara/'.$this->registrasi['id_user'].'/'.$this->registrasi['file_berita_acara']),[
        //     'as' => $this->pembayaran['file_berita_acara'],
        //     'mime' => 'application/pdf',

        //     ]); 
        // }elseif($this->status == 12){

        //     $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Menyelesaikan Pelunasan');

        // }elseif($this->status == '12_2'){

        //     $this->subject('Pelunasan Dengan No registrasi'.$this->registrasi['no_registrasi'].' -GAGAL');

        // }elseif($this->status == '12_3'){

        //     $this->subject('Pelunasan Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Terkonfirmasi');

        //     $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap3']),[
        //         'as' => $this->pembayaran['bt_tahap3'],
        //         'mime' => 'application/pdf',

        //     ]);

        // }elseif($this->status == 13){
           
        //     $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Proses Sidang Fatwa'); 

           
            
      
        // }else{

        //     $this->subject('Progres Status');

        // }

        if($this->status == '2_2'){

            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Perbaikan Berkas');  

        }if($this->status == '2_3'){

            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Berkas Sertifikasi Selesai Diverifikasi');  

        }if($this->status == 7){

            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Persiapan Audit Tahap 1');  

        }elseif($this->status == 9){

            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Persiapan Audit Tahap 2');  

        }elseif($this->status == 11){
            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Persiapan Technical Review');  

        }elseif($this->status == 13){
            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Persiapan Tinjauan Komite Sertifikasi');  

        }
        elseif($this->status == 17){
            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Ketetapan Halal Sudah Keluar');  

        }

        return $this->view('mail.progresstatus');

        //alert("disini");
    }

    
}
