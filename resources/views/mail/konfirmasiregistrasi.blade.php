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
    <p>Kepada Bapak/Ibu,  {{$user['name']}} Yth</p>
    <br/>
    <p>Terima kasih atas pendaftaran yang telah dilakukan melalui aplikasi <b>LPH</b>SUCOFINDO selanjutnya pelanggan dapat melakukan pembayaran melalui kasir SUCOFINDO cabang {{$user['kota']}}</p> di alamat {{$user['alamat']}}

    <p>Dengan membawa Tanda Bayar Registrasi berikut.</p>

    <p>Demikian kami sampaikan, atas perhatian dan kerja samanya diucapkan terima kasih</p>
    <br/>

    <p>Terima kasih,</p>
    <br>
    <p>Admin LPH SUCOFINDO</p>
</body>
</html>