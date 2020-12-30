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

    @php

        $input1 = $pembayaran['tanggal_tahap1']; 
        $date1 = strtotime($input1); 
        $dl_tahap1= date("Y-m-d H:i:s", strtotime('+24 hours', $date1));

        $input2 = $pembayaran['tanggal_tahap2']; 
        $date2 = strtotime($input2); 
        $dl_tahap2= date("Y-m-d H:i:s", strtotime('+24 hours', $date2));

        $input3 = $pembayaran['tanggal_tahap3']; 
        $date3 = strtotime($input3); 
        $dl_tahap3= date("Y-m-d H:i:s", strtotime('+24 hours', $date3));


    @endphp    
    
    @if($status== '4')

        <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI KELENGKAPAN BERKAS</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan berkas registrasi yang anda unggah memerlukan beberapa perbaikan setelah melalui tahapan verifikasi berkas oleh Admin <b>LPH </b>PT.SUCOFINDO. <br\>
        <b>Periksa catatan pada halaman unggah data sertifikasi dan periksa kembali berkas sebelum anda mengunggah kembali.<b>
        </p>

    @elseif($status== '5')

        <h3 style="text-align: center">SILAHKAN MELANJUTKAN PADA TAHAP SELANJUTNYA: AKAD</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan berkas registrasi anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Akad pada menu registrasi halal. silahkan tunggu admin memasukkan kontrak akad lalu tanda tangani akad yang sudah disetuji dan upload kembali </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">Akad</a></button>
        </p>
        <br/>

    @elseif($status== '7')

        <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI FILE KONTRAK AKAD</h3>
        
        <br/>
        
        <p>Anda menerima email ini dikarenakan proses akad gagal dikarnakan file yang diupload oleh anda tidak benar/ rusak. Silahkan upload kembali file kontrak akad sertifikasi yang sudah anda tanda tangani. </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}"> Menu Akad</a></button></p>
        <br/>

    @elseif($status== '8')

           
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
                                <b>{{$pembayaran['mata_uang']}} {{$pembayaran['nominal_tahap1']}} </b>
                            </td>
                            <td>
                                <b>{{$dl_tahap1}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
               

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap1']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> Mandiri Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> XXXXXXXXXX</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b> {{$dl_tahap1}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHATIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap1}}. Pendaftaran anda akan dibatalkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>

     @elseif($status== '10')

            <h3 style="text-align: center">PEMBAYARAN GAGAL</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN GAGAL NOMINAL KURANG  </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan nominal pembayaran tidak sesuai. Harap melkukan transfer kekurangan nominal.
                    </tr>
                  
                     
                        
                </table>
            </div>
            <p>Silahkan melakukan pembayaran ulang sesuai nominal agar tidak terjadi pembatalan.</p>

             <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

                   
                   
                    <tr>
                        <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN  </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['nominal_tahap1']}} </tr>
                     <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b>PT SUCOFINDO</tr>
                     <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b>Bank Mandii Syariah</tr>
                     <tr style="text-align: center; vertical-align: middle;"><b>No Rekening: </b>XXXXXXXXXXXXXXXX</tr>
                     <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran: </b>{{$dl_tahap1}}</tr>
                    
                        
                </table>
            </div>

            <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

            <h3><b>PERHTIAN</b></h3>

            <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap1}}. Pendaftaran anda akan dibatalkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
            </p>

            <p><b>Notes :</b> Silahkan lakukan transfer sejumlah nominal yang kurang lalu unggah kembali bukti transfer pada menu pembayaran.</p>

    @elseif($status== '11')

            <h3 style="text-align: center">PEMBAYARAN BERHASIL - NOMINAL BERLEBIH</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN BERHASIL NOMINAL LEBIH  </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;"> Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} berhasil namun ada kelebihan nominal yang ditransfer. Dalam waktu 1 x 24 jam kami akan proses pengembalian dana yang lebih. 
                    </tr>
                  
                     
                        
                </table>
            </div>

            <p><b>Notes :</b> Proses sertifikasi akan segera diproses. Silahkan tunggu 1 x 24 jam untuk pengembalian dana.</p>
    @elseif($status== '12')

            <h3 style="text-align: center">PROSES PEMBAYARAN GAGAL</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - DIBATALKAN </th>
                    </tr>             
                              
                     
                    <tr style="text-align: center; vertical-align: middle;">Order Anda dengan nomor registrasi  {{$registrasi['no_registrasi']}} dari LPH Sucofindo telah dibatalkan. </tr>
                  
                     
                        
                </table>
            </div>


             <p>Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>        
            
    @elseif($status== '13')

            <h3 style="text-align: center">PEMBAYARAN BERHASIL:</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TELAH DITERIMA </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap1']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
                  
                     
                        
                </table>
            </div>
            <p>
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/pembayaran/'.$pembayaran['bt_tahap1']) }}">Unduh Bukti Pembayaran Tahap 1</a></button>
            </p>

             <p>Anda dapat meninjau order dan mengunduh bukti pembayaran tahap 1 anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pembayaran tahap 1. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p> 

     @elseif($status== '14')

            <h3 style="text-align: center">AUDIT TAHAP 1: DALAM PROSES</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PROSES AUDIT TAHAP 1 </th>
                        <th  >Audit tahap 1 sedang berlangsung silahkan tunggu 1 x 24 jam. setelah proses audit selesai silahkan lanjutkan pembayaran tahap 2 </th>
                    </tr>             
                     
                        
                </table>
            </div>


             <p><b>Note: </b>Silahkan melakukan pembayaran tahap 2 pada menu registrasi halal tombol aksi lalu pilih menu pembayaran tahap 2 apabila total nominal pada kontrak anda lebih dari <b>Rp.50.000.000,00 (Lima Puluh Juta Rupiah)</b>. Apabila total nominal <b>kurang dari Rp.50.000.000,00 (Lima Puluh Juta Rupiah) </b> Anda dapat melewati proses pembayaran tahap 2 dan silahkan melakukan pembayaran tahap 3 (Pelunasan) apabila pembayaran anda <b>lebih besar dari Rp.10.000.000,00 (Sepuluh Juta Rupiah)</b> pada saat proses Audit tahap 2 telah selesai. Apabila nominal total <b>kurang dari Rp.10.000.000,00 (Sepuluh Juta Rupiah)</b> maka pembayaran anda <b>sudah selesai</b> dan silahkan <b>unduh Invoice pelunasan pada menu pelunasan</b> apabila seluruh proses Audit sudah Selesai.
             </p> 
                      



    @elseif($status== '16')
    <h3 style="text-align: center">LAPORAN AUDIT TAHAP 2:</h3>                
            <br/>
            {{-- @if($registrasi['status_report']== '1' && $registrasi['status_berita_acara']== '1') --}}
            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th>ORDER {{$registrasi['no_registrasi']}} - LAPORAN AUDIT TAHAP 2 BERHASIL DIUPLOAD </th>
                    </tr>             
                              
                     {{-- <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap1']}} </tr> --}}                     
                     <tr style="text-align: center; vertical-align: middle;">Laporan audit tahap 2 dan berita acara audit tahap 2 dengan nomor referensi {{$registrasi['no_registrasi']}} sudah diupload. Silahkan cek Pada Menu Pelaporan dan Unduh File Laporan Audit dan Berita Acara Tahap 2, lalu Klik Konfirmasi.</tr>
                    {{-- <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr> --}}
                  
                     
                        
                </table>
            </div>
            <p>
                
                @if($registrasi['status_report']== '1')
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/beritaacara/'.Auth::user()->id.'/'.$registrasi['file_berita_acara']) }}" download>{{$registrasi['file_berita_acara']}}Unduh Laporan Audit Tahap 2</a></button>
                @endif

                @if($registrasi['status_berita_acara']== '1')
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/beritaacara/'.Auth::user()->id.'/'.$registrasi['file_berita_acara']) }}" download>{{$registrasi['file_berita_acara']}}Unduh Berita Acara Tahap 2</a></button>
                @endif
            </p>

             <p>Anda dapat meninjau order dan mengunduh bukti laporan audit tahap 2 dan berita acara tahap 2 anda di menu pelaporan pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu report audit dan report berita acara. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>        
             {{-- @php dd($status) @endphp       --}}
    @elseif($status== '20')
            <h3 style="text-align: center">KEPADA MUI:</h3>                
            <br/>
            {{-- @if($registrasi['status_report']== '1' && $registrasi['status_berita_acara']== '1') --}}
            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th>ORDER {{$registrasi['no_registrasi']}} - LAPORAN AUDIT TAHAP 2 BERHASIL DIUPLOAD </th>
                    </tr>             
                              
                     {{-- <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap1']}} </tr> --}}                     
                     <tr style="text-align: center; vertical-align: middle;">Laporan audit tahap 2 dan berita acara audit tahap 2 dengan nomor referensi {{$registrasi['no_registrasi']}} sudah diupload. Silahkan cek Pada Menu Pelaporan dan Unduh File Laporan Audit dan Berita Acara Tahap 2, lalu Klik Konfirmasi.</tr>
                    {{-- <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr> --}}
                  
                     
                        
                </table>
            </div>
            <p>
                
                @if($registrasi['status_report']== '1')
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/beritaacara/'.Auth::user()->id.'/'.$registrasi['file_berita_acara']) }}" download>{{$registrasi['file_berita_acara']}}Unduh Laporan Audit Tahap 2</a></button>
                @endif

                @if($registrasi['status_berita_acara']== '1')
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/beritaacara/'.Auth::user()->id.'/'.$registrasi['file_berita_acara']) }}" download>{{$registrasi['file_berita_acara']}}Unduh Berita Acara Tahap 2</a></button>
                @endif
            </p>

             <p>Anda dapat meninjau order dan mengunduh bukti laporan audit tahap 2 dan berita acara tahap 2 anda di menu pelaporan pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu report audit dan report berita acara. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>


    @elseif($status== 'g')

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
                                <b>Pembayaran Tahap 2 Sertfikasi Halal dengan no. registrasi {{$registrasi['no_registrasi']}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['mata_uang']}} {{$pembayaran['nominal_tahap2']}} </b>
                            </td>
                            <td>
                                <b>{{$dl_tahap2}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
               

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN TAHAP 2</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap2']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> Mandiri Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> XXXXXXXXXX</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran Tahap 2: </b> {{$dl_tahap2}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHTIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap2}}. Pendaftaran anda akan dibatalkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera diproses setelah Anda melakukan pembayaran</p>
                 

     @elseif($status== 'h')
   
        <h3 style="text-align: center">PEMBAYARAN TAHAP 2 GAGAL</h3>      
        <br/>
        <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
               
                <tr>
                    <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TAHAP 2 GAGAL - NOMINAL KURANG  </th>
                </tr>             
                <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Tahap 2 Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan nominal pembayaran tidak sesuai. Harap melakukan transfer kekurangan nominal.
                </tr>          
            </table>
        </div>
        <p>Silahkan melakukan pembayaran ulang sesuai nominal agar tidak terjadi pembatalan.</p>

         <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

               
                <tr>
                    <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN TAHAP 2  </th>
                </tr>             
                          
                 <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['nominal_tahap2']}} </tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b>PT SUCOFINDO</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b>Bank Mandii Syariah</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>No Rekening: </b>XXXXXXXXXXXXXXXX</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran TAHAP 2: </b>{{$dl_tahap2}}</tr>
                
                    
            </table>
        </div>

        <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

        <h3><b>PERHTIAN</b></h3>

        <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap2}}. Proses sertifikasi tidak dapat dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
        </p>

        <p><b>Notes :</b> Silahkan lakukan transfer sejumlah nominal yang kurang lalu unggah kembali bukti transfer pada menu pembayaran.</p>

    @elseif($status== 'i')

            <h3 style="text-align: center">PEMBAYARAN TAHAP 2 BERHASIL - NOMINAL BERLEBIH</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TAHAP 2 BERHASIL - NOMINAL LEBIH  </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;"> Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} berhasil namun ada kelebihan nominal yang ditransfer. Dalam waktu 1 x 24 jam kami akan proses pengembalian dana yang lebih. 
                    </tr>
                  
                     
                        
                </table>
            </div>

            <p><b>Notes :</b> Proses sertifikasi akan segera dilanjutkan. Silahkan tunggu 1 x 24 jam untuk pengembalian dana.</p>
    @elseif($status== 'j')

            <h3 style="text-align: center">PROSES PEMBAYARAN TAHAP 2 GAGAL</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - DIBATALKAN </th>
                    </tr>             
                              
                     
                    <tr style="text-align: center; vertical-align: middle;">Order Anda dengan nomor registrasi  {{$registrasi['no_registrasi']}} dari LPH Sucofindo telah dibatalkan. </tr>
                  
                     
                        
                </table>
            </div>


             <p>Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>        
            
    @elseif($status== 'l')

            <h3 style="text-align: center">PEMBAYARAN TAHAP 2 BERHASIL:</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN TAHAP 2 TELAH DITERIMA </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap2']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;">Pembayaran Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
                  
                     
                        
                </table>
            </div>
            <p>
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/pembayaran/'.$pembayaran['bt_tahap2']) }}">Unduh Bukti Pembayaran Tahap 2</a></button>
            </p>

             <p>Anda dapat meninjau order dan mengunduh bukti pembayaran tahap 2 anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pembayaran tahap 2. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>          
   
      
    @elseif($status== 'c')

            <h3 style="text-align: center">SILAHKAN MENGUNGGAH FILE KONTRAK AKAD YANG SUDAH DITANDATANGANI</h3>
            
            <br/>
            
               <p>Anda menerima email ini dikarenakan berkas kontrak akad telah diupload pada website LPH PT.SUCOIFNDO silahkan unduh file kontrak akad lalu tanda tangani setelah nya silahkan upload kembali file kontrak akad yang sudah anda tanda tangani. Order anda akan otomais cancel apabila tidak ditanda tangani dalam waktu 1 x 24 jam pada hari dan pukul <b> {{$tomorrow}} WIB/GMT+7  </b>
               </p>

                
            <p>
                <button class="btn btn-green"><a href="{{url('')}}"> Menu Akad</a></button>
            </p>
            <br/>
    @elseif($status== 'd')

            <h3 style="text-align: center">FILE BUKTI TRANSFER SUDAH DITERIMA. MENUNGGU KONFIRMASI ADMIN</h3>
            
            
            <br/>
            
               <p>Anda menerima email ini dikarenakan bukti transfer pembayaran tahap 1 telah diterima dan sedang menunggu konfirmasi dari Admin LPH PT.SUCOFINDO. Silahkan tunggu konfirmasi dari Admin LPH PT.SUCOFINDO paling lama dalam waktu 1 x 24 jam.</b>
               </p>
               
     @elseif($status== '21')

            <h3 style="text-align: center">SILAHKAN MENYELESAIKAN PEMBAYARAN PELUNASAN ANDA :</h3>
            
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
                                <b>Pembayaran Tahap 2 Sertfikasi Halal dengan no. registrasi {{$registrasi['no_registrasi']}} </b>
                            </td>
                            <td>
                                <b>{{$pembayaran['mata_uang']}} {{$pembayaran['nominal_tahap3']}} </b>
                            </td>
                            <td>
                                <b>{{$dl_tahap3}} </b>
                            </td>
                            
                        </tr>

                    
                </table>
               

            </div>

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >HARAP MELAKUKAN TRANSFER PEMBAYARAN PELUNASAN</th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap3']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b> PT SUCOFINDO</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b> Mandiri Syariah</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Nomor Rekening: </b> XXXXXXXXXX</tr>
                    <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran Tahap 2: </b> {{$dl_tahap3}}</tr>
                     
                        
                </table>
            </div>


                 <p>Anda menerima email ini dikarenakan proses tinjauan audit telah selesai oleh <b>LPH </b>PT.SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran Pelunasan pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

                 <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

                 <h3><b>PERHTIAN</b></h3>

                 <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap3}}. Proses tidak akan dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
                </p>

                 <p><b>Notes :</b> Proses Sertifikasi akan segera dilanjutkan setelah Anda melakukan pembayaran</p>


    @elseif($status== '22')
   
        <h3 style="text-align: center">PEMBAYARAN PELUNASAN GAGAL</h3>      
        <br/>
        <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
               
                <tr>
                    <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN PELUNASAN GAGAL - NOMINAL KURANG  </th>
                </tr>             
                <tr style="text-align: center; vertical-align: middle;">Mohon maaf, Pembayaran Pelunasan Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} gagal dikarenakan nominal pembayaran tidak sesuai. Harap melakukan transfer kekurangan nominal.
                </tr>          
            </table>
        </div>
        <p>Silahkan melakukan pembayaran ulang sesuai nominal agar tidak terjadi pembatalan.</p>

         <div>
            <table style="width:100%; border: 1px solid black; margin-bottom: 10px;margin-top: 10px;  border-collapse: collapse;" >

               
                <tr>
                    <th>HARAP MELAKUKAN TRANSFER PEMBAYARAN PELUNASAN </th>
                </tr>             
                          
                 <tr style="text-align: center; vertical-align: middle;"><b>Jumlah Nominal yang Benar: </b> {{$pembayaran['nominal_tahap3']}} </tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Nama Akun: </b>PT SUCOFINDO</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Akun Bank: </b>Bank Mandii Syariah</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>No Rekening: </b>XXXXXXXXXXXXXXXX</tr>
                 <tr style="text-align: center; vertical-align: middle;"><b>Batas Waktu Pembayaran Pelunasan: </b>{{$dl_tahap3}}</tr>
                
                    
            </table>
        </div>

        <p> Setelah Anda melakukan transfer pembayaran, Tolong konfirmasi pembayaran Anda, dengan cara log in di akun Anda, dan masuk pada menu registrasi halal dan klik tombol aksi lalu klik menu pembayaran.</p>

        <h3><b>PERHTIAN</b></h3>

        <p>Mohon pembayaran diselesaikan sebelum {{$dl_tahap3}}. Proses sertifikasi tidak akan dilanjutkan jika anda tidak membayar sesuai nominal dan melakukan konfirmasi pembayaran hingga batas waktu yang ditentukan.
        </p>

        <p><b>Notes :</b> Silahkan lakukan transfer sejumlah nominal yang kurang lalu unggah kembali bukti transfer pada menu pelunasan.</p>           
                          
    
     @elseif($status== '23')

            <h3 style="text-align: center">PEMBAYARAN PELUNASAN BERHASIL - NOMINAL BERLEBIH</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black; margin-bottom: 10px;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN PELUNASAN BERHASIL - NOMINAL LEBIH  </th>
                    </tr>             
                    <tr style="text-align: center; vertical-align: middle;"> Pembayaran Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} berhasil namun ada kelebihan nominal yang ditransfer. Dalam waktu 1 x 24 jam kami akan proses pengembalian dana yang lebih. 
                    </tr>
                  
                     
                        
                </table>
            </div>

            <p><b>Notes :</b> Proses sertifikasi akan segera dilanjutkan. Silahkan tunggu 1 x 24 jam untuk pengembalian dana.</p>
     
            
    @elseif($status== '25')

            <h3 style="text-align: center">PEMBAYARAN PELUNASAN BERHASIL:</h3>
            
            <br/>
            

            <div>
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - PEMBAYARAN PELUNASN TELAH DITERIMA </th>
                    </tr>             
                              
                     <tr style="text-align: center; vertical-align: middle;"><b>Jumlah: </b> {{$pembayaran['nominal_tahap3']}} </tr>
                    <tr style="text-align: center; vertical-align: middle;">Pembayaran Pelunasan Anda untuk Order dengan nomor referensi {{$registrasi['no_registrasi']}} berhasil diproses.</tr>
                  
                     
                        
                </table>
            </div>
            <p>
                <button class="btn btn-green" style="margin-right: 10px;"><a href="{{url('') .Storage::url('public/pembayaran/'.$pembayaran['bt_tahap23']) }}">Unduh Bukti Pembayaran Pelunasan</a></button>
            </p>

            <p>
                <button class="btn btn-green"><a href="{{url('') .Storage::url('public/INV/'.$registrasi['inv_pembayaran']) }}">Unduh Invoice Pelunasan</a></button>
            </p>

             <p>Anda dapat meninjau order dan mengunduh bukti pembayaran pelunasan anda di menu pembayaran pada menu navigasi registrasi halal tekan tombol aksi lalu pilih menu pembayaran pada kolom bukti pembayaran pelunasan. Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.
             </p>    
    @else

       
             <p>Tes Pindah Tahapan </p>

            
            <p>
                <button class="btn btn-green"><a href="{{url('')}}"> Testing</a></button></p>
            <br/>

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
</body>
</html>