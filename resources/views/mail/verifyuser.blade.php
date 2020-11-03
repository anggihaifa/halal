<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
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
            width: 75px;
        }
        .header{
            display: flex;
        }
        .keterangan{
            padding-left: 20px;
            font-size: 15px;
            font-weight: bold;
        }
    </style>
<body class="body">
    <div class="header">
        <div>
            <img src="{{asset('/assets/img/logo/sci-color.png')}}" alt="" />
        </div>
        <div class="keterangan">
            <div>LEMBAGA PEMERIKSA HALAL</div>
            <div>SUCOFINDO</div>
        </div>
    </div>
    <hr>
    <p>Kepada Bapak/ Ibu {{ucwords($user['name'])}} Yth,</p>
    <br>
    <p>Anda menerima email ini dikarenakan melakukan registrasi akun pada <b>LPH</b>SUCOFINDO. Selanjutnya, silahkan klik tautan berikut pada browser Anda untuk melengkapi proses pendaftaran akun Anda. Anda dapat menggunakan email dan password sesuai yang telah anda daftarkan sebelumnya. </p>

    <p>
        <button><a href="{{url('user/verify',$user['token'])}}"> Verifikasi Akun</a></button></p>
    <br/>

    <p><b>Informasi</b></p>
    <p>Tahapan proses yang harus dilalui pelanggan dalam rangka mendapatkan Sertifikat Halal SUCOFINDO:</p>
    <ol>
        <li>Pembuatan akun email melalui aplikasi <a href="{{url('login')}}">{{url('login')}}</a></li>
        <li>Pendaftaran formulir Sertifikasi Halal</li>
        <li>Unggah dokumen persyaratan audit Sertifikasi Halal</li>
        <li>Kaji ulang permohonan audit</li>
        <li>Pembayaran akad (Transfer)</li>
        <li>Proses Audit oleh tim Auditor Halal SUCOFINDO</li>
        <li>Tinjauan hasil audit</li>
        <li>Rekomendasi hasil pemeriksaan Halal</li>
        <li>Proses sertifikasi oleh BPJPH</li>
        <li>Penetapan keputusan kehalalan oleh komisi Fatwa MUI</li>
        <li>Penertiban Sertifikat Halal oleh BPJPH</li> 
    </ol>
    <br>

    <p>Terima kasih,</p>
    <br>
    <p>Admin <b>LPH</b>SUCOFINDO</p>
</body>
</html>