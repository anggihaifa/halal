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
    <p>Pembayaran dengan nomor registrasi <b> {{$registrasi['no_registrasi']}} </b> sudah dikonfirmasi oleh admin lph sucofindo</p>
    <p>Silahkan <a class="link" href="{{url('user/verify',$user['token'])}}">buka aplikasi</a> untuk menguduh invoice pembayaran, atau klik tombol di bawah ini </p>    
    <p>
        <button><a href="{{url('').Storage::url('public/pembayaran/'.$registrasi['inv_pembayaran']) }}" download> Unduh Invoice Pembayaran</a></button>
    </p>
    <br/>

    <p>Terima kasih,</p>
    <br>
    <p>Admin LPH SUCOFINDO</p>
</body>
</html>