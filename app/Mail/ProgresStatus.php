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
        if($this->status == 2){
            $this->subject('Melengkapi Berkas - No registrasi '.$this->registrasi['no_registrasi']);
        }elseif($this->status == 4){

            $this->subject('Verifikasi Berkas Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Ditolak');

        }elseif($this->status == 5){

            $this->subject('Verifikasi Berkas '.$this->registrasi['no_registrasi'].'- Disetujui ');                

        }elseif($this->status == 6){

            $this->subject('Kontrak Akad '.$this->registrasi['no_registrasi'].'- Silahkan Upload Kontrak Akad ');

        }elseif($this->status == 7){

            $this->subject('Kontrak Akad Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Ditolak');

        }elseif($this->status == 8){

            //dd("masuk");

            $this->subject('Kontrak Akad Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Disetujui');


        }elseif($this->status == 9){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Menyelesaikan Pembayaran');

        }elseif($this->status == 10){

            $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Ditolak Nominal Kurang');

        }elseif($this->status == 11){
            //dd("masuk");

            $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Disetujui Nominal Lebih');

        }elseif($this->status == 12){

            $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Ditolak');

        }elseif($this->status == 13){

             $this->subject('Pembayaran Tahap 1 Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Disetujui');

             $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap1']),[
                    'as' => $this->pembayaran['bt_tahap1'],
                    'mime' => 'application/pdf',

             ]);

        }elseif($this->status == 14){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Proses Audit Tahap 1');

        }elseif($this->status == 15){

             $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Proses Audit Tahap 2');      

        }elseif($this->status == 16){
            //
            $this->subject('Registrasi Dengan No registrasi '.$this->registrasi['no_registrasi'].' - Pelaporan Audit dan Berita Acara');      
            if($this->registrasi['status_report']== 1 && $this->registrasi['status_berita_acara']== 1){

                 $this->attach(public_path('storage/buktireport/'.$this->registrasi['id_user'].'/'.$this->registrasi['file_report']),[
                    'as' => $this->pembayaran['file_report'],
                    'mime' => 'application/pdf',

                ]);

                 $this->attach(public_path('storage/beritaacara/'.$this->registrasi['id_user'].'/'.$this->registrasi['file_berita_acara']),[
                    'as' => $this->pembayaran['file_berita_acara'],
                    'mime' => 'application/pdf',

                ]);


            }else{

                $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Proses Pelaporan Audit Dan Berita Acara');  
            }

               

        }elseif($this->status == 20){
           
            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Proses Sidang Fatwa'); 

           
            
            //$this->email('')//email MUI

        }elseif($this->status == 21){

            if($this->pembayaran['nominal_tahap3'] == 0){

                 $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Pelunasan Disetujui Silahkan Menunggu Invoice'); 

            }else{

                $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Melakukan Pembayaran Pelunasan');   
            }

        }elseif($this->status == 22){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pelunasan Ditolak Nominal Kurang');

        }elseif($this->status == 23){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pelunasan Disetujui Nominal lebih'); 

        }elseif($this->status == 24){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pelunasan Ditolak');

        }elseif($this->status == 25){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pelunasan Disetujui');

            $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap3']),[
                    'as' => $this->pembayaran['bt_tahap3'],
                    'mime' => 'application/pdf',

                ]);

             $this->attach(public_path( 'storage/INV/'.$this->registrasi['id_user'].'/'.$this->registrasi['inv_pembayaran']),[
                'as' => $this->registrasi['inv_pembayaran'],
                    'mime' => 'application/pdf',

            ]);

          

        }elseif($this->status == 26){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Telah Selesai');

        }
        elseif($this->status == 'c'){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Menunggu Pelanggan Upload Kontrak');

        }elseif($this->status == 'd'){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Bukti Transfer Sudah Diterima');

        }elseif($this->status ==  'g'){

            if($this->pembayaran['nominal_tahap2'] == 0){

                 $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Tahap 2 Disetujui'); 

            }else{

                $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' - Silahkan Melakukan Pembayaran Tahap 2');   
            }
            
            

        }elseif($this->status == 'h'){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Tahap 2 Ditolak Nominal Kurang');

        }elseif($this->status == 'i'){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Tahap 2 Nominal lebih'); 

        }elseif($this->status == 'j'){

             $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Tahap 2 Ditolak');

        }elseif($this->status == 'l'){

            $this->subject('Registrasi Dengan No registrasi'.$this->registrasi['no_registrasi'].' -Pembayaran Tahap 2 Disetujui');

            $this->attach(public_path('storage/buktipembayaran/'.$this->registrasi['id_user'].'/'.$this->pembayaran['bt_tahap2']),[
                    'as' => $this->pembayaran['bt_tahap2'],
                    'mime' => 'application/pdf',

             ]);

        }else{

            $this->subject('Progres Status');

        }

        return $this->view('mail.progresstatus');

        //alert("disini");
    }

    
}
