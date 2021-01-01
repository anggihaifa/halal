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


     
    @if($status== 'berkas')
    
    <h3 >ORDER ANDA DENGAN NOMOR REGISTRASI {{$registrasi['no_registrasi']}} - DIBATALKAN</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - ORDER DIBATALKAN</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Order Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} telah dibatalkan karna anda melewati batas waktu pengisian berkas pada hari dan pukul {{$pembayaran['dl_berkas']}}.</tr>
                   
                     
                        
                </table>
            </div>

           
                <p><b>Notes :</b> Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.</p>           
    
   @elseif($status== 'akad')
    
    <h3 >ORDER ANDA DENGAN NOMOR REGISTRASI {{$registrasi['no_registrasi']}} - DIBATALKAN</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - ORDER DIBATALKAN</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Order Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} telah dibatalkan karna anda melewati batas waktu pengisian kontrak akad pada hari dan pukul {{$pembayaran['dl_akad']}}.</tr>
                   
                     
                        
                </table>
            </div>

           
                <p><b>Notes :</b> Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.</p>      

    @elseif($status== 'tahap1')
    
    <h3 >ORDER ANDA DENGAN NOMOR REGISTRASI {{$registrasi['no_registrasi']}} - DIBATALKAN</h3>
            
            <br/>
            <div >
                <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >
                   
                    <tr>
                        <th  >ORDER {{$registrasi['no_registrasi']}} - ORDER DIBATALKAN</th>
                    </tr>             
                              
                     <tr style="text-align:center; vertical-align: middle;"><b>Order Anda dengan nomor registrasi {{$registrasi['no_registrasi']}} telah dibatalkan karna anda melewati batas waktu pembayaran pada hari dan pukul {{$pembayaran['dl_tahap1']}}.</tr>
                   
                     
                        
                </table>
            </div>

           
                <p><b>Notes :</b> Untuk informasi lebih lanjut, silahkan menghubungi Customer Care kami.</p>                  


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