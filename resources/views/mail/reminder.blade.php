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


     
    @if($status== 'r1_12')
    
    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal1}} </tr>
                   <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap1']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap1']}}. Pendaftaran tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>           
    
    @elseif($status== 'r1_6')

    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                      <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal1}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap1']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap1']}}. Pendaftaran anda tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>  



    @elseif($status== 'r2_12')
    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal2}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap2']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap2']}}. Pendaftaran anda tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>  


    @elseif($status== 'r2_6')
    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal2}} </tr>
                  <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap2']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap2']}}. Pendaftaran anda tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>  




    @elseif($status== 'r3_12')
    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                      <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal3}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap3']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap3']}}. Pendaftaran anda tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>  



    @elseif($status== 'r3_6')
    <h3 >SILAHKAN MENYELESAIKAN PEMBAYARAN ANDA :</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >Detail Order</th>
                    </tr>             
                              
                      <tr style="text-align:center; vertical-align: middle;"><b>Terimakasih untuk Order Anda dengan nomor registrasi: </b> {{$registrasi['no_registrasi']}} </tr>
                    <tr style="text-align:center; vertical-align: middle;">Namun sayangnya kami belum dapat melanjutkan proses sertifikasi, karena kami belum menerima pembayaran. </tr>
                     
                     
                        
                </table>
            </div>

           

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['mata_uang']}}  {{$nominal3}} </tr>
                   <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO (PERSERO) </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> : BNI Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> 2210195632 </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$pembayaran['dl_tahap3']}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$pembayaran['dl_tahap3']}}. Pendaftaran anda tidak akan dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>  


    @endif

    
            <p><b>Informasi</b></p>
            <p>Tahapan proses yang harus dilalui pelanggan dalam rangka mendapatkan Sertifikat Halal SUCOFINDO:</p>
            <ol>
                <li>Pembuatan akun email melalui aplikasi <a href="{{url('login')}}">{{url('login')}}</a></li>
                <li>Pendaftaran formulir sertifikasi halal</li>
                <li>Unggah dokumen persyaratan audit sertifikasi halal</li>
                <li>Verifikasi berkas persyaratan</li>
                <li>Akad</li>
                <li>Pembayaran akad</li>
                <li>Proses audit oleh Tim auditor halal SUCOFINDO</li>
                <li>Tinjauan hasil audit</li>
                <li>Rekomendasi hasil pemeriksaan halal</li>
                <li>Proses sertifikasi oleh BPJPH</li>
                <li>Penetapan keputusan kehalalan oleh Komisi Fatwa MUI</li>
                <li>Penertiban Sertifikat Halal oleh BPJPH</li> 
            </ol>
            <br/>

            <p>Terima kasih,</p>
            <br/>
            <p><b>Admin LPH PT.SUCOFINDO</b></p>
        </div>

         <footer style="text-align:center;">
            <div style="background-color:#00acac; color:white; height: 50px;">
                <a><b>Call Center:  021-7983666 ext 1324</b></a><br>
                <a><b>WhatsApp: 0812-8957-7157</b></a>
            </div>
        </footer>
</body>
</html>