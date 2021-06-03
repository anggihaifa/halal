<!DOCTYPE html>
<html>
<head>
    <title>Progres Status Sertifikasi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{asset('/assets/css/fonts/fontStyle.css')}}"/>
    <link href="{{asset('assets/css/default/app.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
    <style type="text/css">
        body{
            padding: 10px;
        }
        a{
            color:white !important;
        }
        button{
            border: none;
            border-radius: 3px;
            padding: 10px 15px;
            background: rgb(67, 172, 95);
            background: linear-gradient(135deg, rgb(97, 172, 120) 0%, rgb(34, 126, 84) 100%);
            color: white;
        }
        button a{
            text-decoration: none;
            color: white !important;
            font-weight: bold;
        }
        button a:hover{
            text-decoration: none;
            color: white !important;
            font-weight: bold;   
        }
        a{
            text-decoration: none;
        }
        img{
            width: 20%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
              
        }
        
        .keterangan{
            
            font-size: 22px;
            font-weight: bold;
            text-align:center;
        }
        
    </style>

@if(is_null($pembayaran)==0)
     @php

        $nominal1 = number_format($pembayaran['nominal_tahap1'],2,',','.');
        $nominal2 = number_format($pembayaran['nominal_tahap2'],2,',','.');
        $nominal3 = number_format($pembayaran['nominal_tahap3'],2,',','.');

        $nominal_kurang1 = number_format($pembayaran['kurang_tahap1'],2,',','.');
        $nominal_kurang2 = number_format($pembayaran['kurang_tahap2'],2,',','.');
        $nominal_kurang3 = number_format($pembayaran['kurang_tahap3'],2,',','.');

        $nominal_lebih1 = number_format($pembayaran['lebih_tahap1'],2,',','.');
        $nominal_lebih2 = number_format($pembayaran['lebih_tahap2'],2,',','.');
        $nominal_lebih3 = number_format($pembayaran['lebih_tahap3'],2,',','.');

    @endphp 
@endif                  

<body class="body">
    <div style="border-style: ridge;" >
        <div>
            <img src="{{asset('/assets/img/logo/sci-color.png')}}"  alt="" />
        </div>
        <div class="keterangan">
            <div>LEMBAGA PEMERIKSA HALAL</div>
            <div>SUCOFINDO</div>
        </div>

            <h3 style="text-align: center">Yth Bapak/ Ibu {{ucwords($user['name'])}}</h3>
            <h3 style="text-align: center">{{ucwords($user['perusahaan'])}}</h3>
            <h3 style="text-align: center">No. Registrasi : {{ucwords($registrasi['no_registrasi'])}}</h3>
            <h3 style="text-align: center">TERIMAKASIH SUDAH MELAKUKAN PENDAFTARAN SERTIFIKASI HALAL DI LPH PT. SUCOFINDO</h3>
    </div>
    
    <div style="border-style: ridge; padding:10px 10px 10px 10px;">


     @if($status== '2')

        

        <h3 style="text-align: center">SILAHKAN MENGUNGGAH BERKAS KELENGKAPAN SERTIFIKASI</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan pendaftaran sertifikasi halal anda sudah diterima oleh Admin <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan unggah berkas kelengkapan sertifikasi pada menu unggah data berkas, lengkapi data selengkap mungkin lalu tunggu verifikasi dokumen oleh admin.  batas waktu pengunggahan kelengkapan dokumen adalah 1 x 24 jam yaitu sampai hari dan jam {{$registrasi['dl_berkas']}} WIB/GMT+7 </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
        </p>
        <br/>  

      @php
       // dd($status);
      @endphp
    
    @elseif($status== '2_2')

        <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI KELENGKAPAN BERKAS</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan berkas registrasi yang anda unggah memerlukan beberapa perbaikan setelah melalui tahapan verifikasi berkas oleh Admin <b>LPH </b>PT.SUCOFINDO. <br\>
        <b>Periksa catatan pada halaman unggah data sertifikasi dan periksa kembali berkas sebelum anda mengunggah kembali. batas waktu pengunggahan kelengkapan dokumen adalah 1 x 24 jam yaitu sampai hari dan jam {{$registrasi['dl_berkas']}} WIB/GMT+7.<b>
        </p>

    @elseif($status== '2_3')

        <h3 style="text-align: center">Berkas Sertfikasi Terkonfirmasi</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan berkas registrasi anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Silahkan lanjutkan pada tahapan berikutnya yaitu Akad pada menu registrasi halal. silahkan tunggu admin mengunggah kontrak akad, kemudian unggah kembali kontrak akad yang sudah anda tanda tangani.</p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
        </p>
        <br/>

    @elseif($status== '4_1')

  

        <h3 style="text-align: center">Berkas Penawaran dan Akad Sudah Tersedia</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan file kontrak akad telah diunggah oleh Admin <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan berikutnya yaitu proses pembayaran tahap 1</p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
        </p>
        <br/>    

    
            
    @elseif($status== '6')
    
    <h3 style="text-align: center">SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div style="border:solid; ">
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Order: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Payment: </b> Transfer</tr>
                     
                        
                </table>
            </div>

            <div style="border:solid; ">
                <table style="width:100%; margin-top:10px;  border: 1px solid black;">
                     
                        <tr>
                            <th><b>Deskripsi</b></th>
                            <th><b>Total Biaya</b></th>
                            <th><b>Batas Waktu</b></th>
                        </tr>
                         
                    

                   
                        
                        <tr style="text-align: center; vertical-align: middle;">
                            <td>
                                <b>Pembayaran Sertfikasi Halal dengan no. registrasi {{$registrasi['no_registrasi']}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['mata_uang']}} {{$nominal1}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['dl_tahap1']}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
               

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal1}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap1']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Silahkan melanjutkan pada tahapan berikutnya yaitu Pembayaran. Silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara login di akun Anda,kemudian masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap1']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>

   

    @elseif($status== '6_2')

            <h3 style="text-align: center">PROSES PEMBAYARAN GAGAL</h3>
            
            <br/>
            

           <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN GAGAL </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan bukti transfer tidak sesuai atau file rusak. silahkan upload kembali bukti transfer yang benar
                    </tr>
                  
                     
                        
                </table>
            </div>
            <p>Silahkan melakukan pembayaran ulang sesuai nominal agar dapat dilanjutkan ke tahap selanjutnya.</p>

             <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

                   
                   
                    <tr>
                        <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN  </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['mata_uang']}} {{$nominal1}} </tr>
                     
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap1']}}</tr>
                        
                </table>
            </div>

            <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

            <h3><b>PERHTIAN</b></h3>

            <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap1']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
            </p>

            <p><b>Notes :</b> Silahkan lakukan transfer sejumlah nominal yang kurang lalu unggah kembali bukti transfer pada menu pembayaran.</p>
            
    @elseif($status== '6_3')

            <h3 style="text-align: center">PEMBAYARAN TERKONFIRMASI</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TELAH DITERIMA </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal1}} </tr>
                    <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
                  
                     
                        
                </table>
            </div>
           <!--  <p>
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/buktipembayaran/'.$user['id'].'/'.$pembayaran['bt_tahap1']) }}">Unduh Bukti Pembayaran Tahap 1</a></button>
            </p> -->

             <p>Anda dapat meninjau order dan mengunduh bukti pembayaran tahap 1 anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pembayaran tahap 1. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami melalui email lph@sucofindo.co.id atau whatsapp ke 0812-8957-7157 an. Visi Hardiani (Bagian Pemasaran).
             </p> 

    @elseif($status== '5_1')
            <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI BERKAS Order Confirmation YANG SUDA DITANDATANGANI</h3>
                
            <br/>
            
            <p>Anda menerima email ini dikarenakan pendaftaran anda memasuki tahapan penerbitan order confirmation. Selanjutnya, silahkan unggah berkas order confirmation yang sudah ditandatangani. </p>

            
            <p>
                <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
            </p>
            <br/>  

    @elseif($status== '5_3')
            <h3 style="text-align: center">PENERBITAN ORDER CONFIRMATION GAGAL</h3>
                
            <br/>
            
            <p>Anda menerima email ini dikarenakan berkas order confirmation tidak dapat dikonfirmasi oleh Admin kami. Selanjutnya, silahkan unggah berkas order confirmation yang sudah ditandatangani dan pastikan file tidak rusak.</p>

            
            <p>
                <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
            </p>
            <br/>  
    @elseif($status== '5_4')
        <h3 style="text-align: center">PENERBITAN ORDER CONFIRMATION TERKONFIRMASI</h3>
            
        <br/>
        
        <p>Anda menerima email ini dikarenakan order confirmation telah berhasil diterbitkan. Selanjutnya silahkan melakukan pembayaran sesuai akad.</p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">WEBSITE LPH SUCOFINDO</a></button>
        </p>
        <br/>  

    @elseif($status== '8')

            <h3 style="text-align: center">AUDIT TAHAP 1: DALAM PROSES</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PROSES AUDIT TAHAP 1 </th>
                        <th  >Audit tahap 1 sedang berlangsung silahkan menunggu 1 x 24 jam.</th>
                    </tr>             
                     
                        
                </table>
            </div>

    @elseif($status== '8_2')

            <h3 style="text-align: center">VERIFIKASI BERKAS AUDIT TAHAP 1 - PERBAIKAN</h3>

            <br/>


            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PERBAIKAN AUDIT TAHAP 1 </th>
                        <th  >Silahkan lakukan perbaikan berkas kelengkapan audit tahap 1 sesuai dengan catatan pada halaman audit tahap 1</th>
                    </tr>             
                    
                        
                </table>
            </div>
    
    @elseif($status== '8_3')

            <h3 style="text-align: center">VERIFIKASI BERKAS AUDIT TAHAP 1 - TERKONFIRMASI</h3>

            <br/>


            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - BERKAS TERKONFIRMASI </th>
                        <th  >Silahkan melanjutkan ke tahapan berikutnya, apabila nominal pembayaran anda melebihi Rp.50.000.000 silahkan melanjutkan ke tahapan pembayaran tahap2. Apabila nominal total pembayaran kurang dari Rp.50.000.000 anda dapat melanjutkan ke tahapan Audit Tahap 2</th>
                    </tr>             
                    
                        
                </table>
            </div>

    @elseif($status== '9')
    
        <h3 style="text-align: center">SILAHKAN MENYELESAIKAN PEMBAYARAN TAHAP 2 ANDA :</h3>
            
            <br/>
            <div style="border:solid; ">
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Order: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Payment: </b> Transfer</tr>
                     
                        
                </table>
            </div>

            <div style="border:solid; ">
                <table style="width:100%; margin-top:10px;  border: 1px solid black;">
                     
                        <tr>
                            <th><b>Deskripsi</b></th>
                            <th><b>Total Biaya</b></th>
                            <th><b>Batas Waktu</b></th>
                        </tr>
                         
                    

                   
                        
                        <tr style="text-align: center; vertical-align: middle;">
                            <td>
                                <b>Pembayaran Sertfikasi Halal dengan no. registrasi {{$registrasi['no_registrasi']}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['mata_uang']}} {{$nominal2}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['dl_tahap2']}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
               

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal2}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap2']}}</tr>
                     
                        
                </table>
            </div>



                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara login di akun Anda,kemudian masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap2']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>

   

    @elseif($status== '9_2')

            <h3 style="text-align: center">PROSES PEMBAYARAN TAHAP 2 GAGAL</h3>
            
            <br/>
            

           <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TAHAP 2 GAGAL </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan bukti transfer tidak sesuai atau file rusak. silahkan upload kembali bukti transfer yang benar
                    </tr>
                  
                     
                        
                </table>
            </div>
            <p>Silahkan melakukan pembayaran ulang sesuai nominal agar dapat dilanjutkan ke tahap selanjutnya.</p>

             <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

                   
                   
                    <tr>
                        <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN  </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['mata_uang']}} {{$nominal2}} </tr>
                     
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap2']}}</tr>
                        
                </table>
            </div>

            <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

            <h3><b>PERHTIAN</b></h3>

            <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap2']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
            </p>
            
    @elseif($status== '9_3')

            <h3 style="text-align: center">PEMBAYARAN TAHAP 2 TERKONFIRMASI</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TELAH DITERIMA </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal2}} </tr>
                    <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
                  
                     
                        
                </table>
            </div>

             <p>Anda dapat meninjau order dan mengunduh bukti pembayaran tahap 1 anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pembayaran tahap 2. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami melalui email lph@sucofindo.co.id.
             </p> 
    @elseif($status== '10')

            <h3 style="text-align: center">AUDIT TAHAP 2: DALAM PROSES</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PROSES AUDIT TAHAP 2 </th>
                       
                    </tr>             
                     
                        
                </table>
            </div>
    
    @elseif($status== '10_1')

            <h3 style="text-align: center">AUDIT TAHAP 2: SILAHKAN MENYETUJUI AUDIT PLAN</h3>

            <br/>


            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - Silahkan menyetujui audit plan pada menu audit tahap 2 </th>
                    
                    </tr>             
                    
                        
                </table>
            </div>

    @elseif($status== '10_3')

        <h3 style="text-align: center">AUDIT TAHAP 2: AUDIT PLAN TERKONFIRMASI</h3>

        <br/>


        <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
            
                <tr>
                    <th  >ORDER {{$registrasi['no_registrasi']}} - Audit Plan sudah terkonfirmasi.</th>
                
                </tr>             
                
                    
            </table>
        </div>

    


    @elseif($status== '11_1')
            <h3 style="text-align: center">BERITA ACARA - SILAHKAN UPLOAD ULANG BERITA ACARA</h3>                
            <br/>
        
            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th>ORDER {{$registrasi['no_registrasi']}} - BERITA ACARA SUDAH DIUPLOAD OLEH ADMIN </th>
                    </tr>             
                              
                                
                     <tr style="text-align: center; vertical-align: middle;">Berita acara dengan nomor registrasi {{$registrasi['no_registrasi']}} sudah diupload. Silahkan cek Pada Menu Pelaporan dan Unduh File Berita Acara, lalu unggah kembali file yang sudah anda tandatangani.</tr>
                    
                  
                     
                        
                </table>
            </div>
         
    
    @elseif($status== '12')
    
        <h3 style="text-align: center">SILAHKAN MENYELESAIKAN PELUNASAN ANDA :</h3>
            
            <br/>
            <div style="border:solid; ">
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                            
                    <tr style="text-align: center; vertical-align: middle;"><b>Order: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Payment: </b> Transfer</tr>
                    
                        
                </table>
            </div>

            <div style="border:solid; ">
                <table style="width:100%; margin-top:10px;  border: 1px solid black;">
                    
                        <tr>
                            <th><b>Deskripsi</b></th>
                            <th><b>Total Biaya</b></th>
                            <th><b>Batas Waktu</b></th>
                        </tr>
                        
                    

                
                        
                        <tr style="text-align: center; vertical-align: middle;">
                            <td>
                                <b>Pembayaran Sertfikasi Halal dengan no. registrasi {{$registrasi['no_registrasi']}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['mata_uang']}} {{$nominal3}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['dl_tahap3']}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
            

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                            
                    <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal3}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap3']}}</tr>
                    
                        
                </table>
            </div>



                <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara login di akun Anda,kemudian masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                <h3><b>PERHATIAN</b></h3>

                <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap3']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>



    @elseif($status== '12_2')    

        <h3 style="text-align: center">PROSES PELUNASAN GAGAL</h3>
        
        <br/>
        

       <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
               
                <tr>
                    <th  >ORDER {{$registrasi['no_registrasi']}} - PELUNASAN GAGAL </th>
                </tr>             
                <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan bukti transfer tidak sesuai atau file rusak. silahkan upload kembali bukti transfer yang benar
                </tr>
              
                 
                    
            </table>
        </div>
        <p>Silahkan melakukan pembayaran ulang sesuai nominal agar dapat dilanjutkan ke tahap selanjutnya.</p>

         <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

               
               
                <tr>
                    <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN  </th>
                </tr>             
                          
                 <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['mata_uang']}} {{$nominal3}} </tr>
                 
                <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO </tr>
                <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> BNI Syariah</tr>
                <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap3']}}</tr>
                    
            </table>
        </div>

        <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

        <h3><b>PERHTIAN</b></h3>

        <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap3']}}. Pendaftaran anda tidak akan dapat dilanjutkan ke tahap selanjutnya jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
        </p>
        
    @elseif($status== '12_3')

        <h3 style="text-align: center">PELUNASAN TERKONFIRMASI</h3>
        
        <br/>
        

        <div>
            <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
               
                <tr>
                    <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TELAH DITERIMA </th>
                </tr>             
                          
                 <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}} {{$nominal3}} </tr>
                <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
              
                 
                    
            </table>
        </div>

         <p>Anda dapat meninjau order dan mengunduh bukti pelunasan anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pelunasan. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami melalui email lph@sucofindo.co.id.
         </p> 
        
    @elseif($status== '13')
            <h3 style="text-align: center">SIDANG FATWA: DALAM PROSES</h3>
            
                <br/>
                

                <div>
                    <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                       
                        <tr>
                            <th  >ORDER {{$registrasi['no_registrasi']}} - PROSES SIDANG FATWA </th>
                           
                        </tr>             
                         
                            
                    </table>
                </div>
           

             <p>silahkan menghubungi Customer Care kami melalui email lph@sucofindo.co.id atau whatsapp ke 0812-8957-7157 an. Visi Hardiani (Bagian Pemasaran). untuk informasi lebih lanjut.
             </p>


    

     
               
     
    @endif

    
           
            <p><b>Admin LPH PT.SUCOFINDO</b></p>
        </div>

        <footer style="text-align:center;">
            <div style="background-color:#00acac; color:white; height: 50px;">
                <a><b>Call Center:  021-7983666 ext 1324</b></a><br>
                <a><b>WhatsApp: 0857-7420-7966</b></a>
            </div>
        </footer>
</body>
</html>