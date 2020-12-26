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
        /*img{
            width: 40%;
        }*/
        
        .keterangan{
            
            font-size: 22px;
            font-weight: bold;
            text-align:center;
        }
        
    </style>


<body class="body">
    <div style="border-style: ridge;" >
        <div>
            <img src="{{asset('/assets/img/logo/sci-color.png')}}" alt="" />
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
    
    @if($registrasi['status']== '4')

    <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI KELENGKAPAN BERKAS</h3>
    
    <br/>
    
        <p>Anda menerima email ini dikarenakan berkas registrasi yang anda unggah memerlukan beberapa perbaikan setelah melalui tahapan verifikasi berkas oleh Admin <b>LPH </b>SUCOFINDO. <br\>

        <b>Periksa catatan pada halaman unggah data sertifikasi dan periksa kembali berkas sebelum anda mengunggah kembali.<b></p>

    
    

    @elseif($registrasi['status']== '5')

    <h3 style="text-align: center">SILAHKAN MELANJUTKAN PADA TAHAP SELANJUTNYA: AKAD</h3>
    
    <br/>
    
        <p>Anda menerima email ini dikarenakan berkas registrasi anda telah disetujui oleh kami <b>LPH </b>SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Akad pada menu registrasi halal. silahkan tunggu admin memasukkan kontrak akad lalu tanda tangani akad yang sudah disetuji dan upload kembali </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">Akad</a></button></p>
        <br/>
    @elseif($status== '7')

    <h3 style="text-align: center">SILAHKAN MENGUNGGAH KEMBALI FILE KONTRAK AKAD</h3>
    
    <br/>
    
        <p>Anda menerima email ini dikarenakan proses akad gagal dikarnakan file yang diupload oleh anda tidak benar/ rusak. Silahkan upload kembali file kontrak akad sertifikasi yang sudah anda tanda tangani. </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}"> Menu Akad</a></button></p>
        <br/>
     @elseif($registrasi['status']== '8')

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
        <table style="width:100%;  border: 1px solid black;">
             
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
                        <b>{{$pembayaran['tanggal_tahap1']}} </b>
                    </td>
                    
                </tr>

            
        </table>
       

    </div>
        <p>Anda menerima email ini dikarenakan berkas registrasi anda telah disetujui oleh kami <b>LPH </b>SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Akad pada menu registrasi halal. silahkan tunggu admin memasukkan kontrak akad lalu tanda tangani akad yang sudah disetuji dan upload kembali </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}">Pembayaran</a></button></p>
        <br/>
    @elseif($status== '31')

    <h3 style="text-align: center">SILAHKAN MENGUNGGAH FILE KONTRAK AKAD YANG SUDAH DITANDATANGANI</h3>
    
    <br/>
    
       <p>Anda menerima email ini dikarenakan berkas kontrak akad anda telah disetujui oleh kami <b>LPH </b>SUCOFINDO. Selanjutnya, silahkan lanjutkan pada tahapan selanjutnya yaitu Pembayaran pada menu registrasi halal. silahkan upload bukti transfer sesuai dengan nominal yang tertera </p>

        
        <p>
            <button class="btn btn-green"><a href="{{url('')}}"> Menu Akad</a></button>
        </p>
        <br/>
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
        <p><b>Admin LPH SUCOFINDO</b></p>
    </div>
</body>
</html>