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
            color: white;
            font-weight: bold;
        }
        button a:hover{
            text-decoration: none;
            color: white;
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
    <br>
    <p>Terima kasih kepada {{$user['perusahaan']}} atas pendaftaran yang dilakukan, berikut ini adalah user dan password yang dapat digunakan untuk mengakses aplikasi <b>LPH</b>SUCOFINDO</p>

    <p>User : {{$user['username']}}</p>
    <p>Password : {{ $user['password']}}</p>


    <p><b>Informasi</b></p>
    <p>Tahapan proses yang harus dilalui pelanggan dalam rangka mendapatkan Sertifikat Halal SUCOFINDO:</p>
    <ol>
        <li>Pembuatan akun email melalui aplikasi <a href="{{url('login')}}">{{url('login')}}</a>  *abaikan jika sudah mendaftar</li>
        <li>Pendaftaran registrasi</li>
        <li>Pebayaran registrasi (Tunai/Transfer)</li>
        <li>Unggah dokumen persyaratan audit Sertifikasi Halal</li>
        <li>Proses Pre-Audit oleh tim Halal SUCOFINDO</li>
        <li>Pembayaran akad</li>
        <li>Penjadwalan audit</li>
        <li>Proses audit</li>
        <li>Pengajuan Halal ke Fatma MUI dan Sertifikat Halal ke BPJPH</li>
        <li>Terbit Sertifikat Halal</li> 
    </ol>
    <br>

    <p>Terima kasih,</p>
    <br>
    <p>Admin LPH SUCOFINDO</p>
</body>
</html>