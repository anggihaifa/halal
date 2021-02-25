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
    
  

<body class="body" style="text-align: center;">
    <div style="border-style: ridge;" >
        <div>
            <img src="{{asset('/assets/img/logo/sci-color.png')}}"  alt="" />
        </div>
        <div class="keterangan">
            <div>LEMBAGA PEMERIKSA HALAL</div>
            <div>SUCOFINDO</div>
        </div>

            <h3 style="text-align: center">Yth Bapak/ Ibu {{ucwords($user['name'])}} Auditor Sertifikasi Halal LPH PT SUCOFINDO</h3>
          
    </div>
    
    <div style="border-style: ridge; padding:10px 10px 10px 10px;">


    @if($status== 'audit1')

        

        <h3 style="text-align: center">Yth Bapak/ Ibu Auditor Sertifikasi Halal LPH PT SUCOFINDO (PERSERO)</h3>
            
        <h4 style="text-align: center">Berikut ini adalah jadwal Audit tahap 1 yang sudah dijadwalkan</h4>
        <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >                  
            <tr>
                <th  >Nama Perusahaan</th>
                <th  >Waktu Mulai</th>
                <th  >Waktu Selesai</th>
                <th  >Auditor 1 </th>
                <th  >Auditor 2 </th>
                <th  >Kategori Audit</th>
            </tr>       
            
            <tr>
                <td  >{{$registrasi['nama_perusahaan']}}</td>
                <td  >{{$penjadwalan['mulai_audit1']}}</td>
                <td  >{{$penjadwalan['selesai_audit1']}}</td>
                <td  >{{$penjadwalan['pelaksana1_audit1']}}</td>
                <td  >{{$penjadwalan['pelaksan2_audit1']}}</td>
                <td  >Remote Audit</td>
            </tr>       
                
        </table>
        
    
    @elseif($status== 'audit2')

        <h3 style="text-align: center">Yth Bapak/ Ibu Auditor Sertifikasi Halal LPH PT SUCOFINDO (PERSERO)</h3>
            
        <h4 style="text-align: center">Berikut ini adalah jadwal Audit tahap 2 yang sudah dijadwalkan</h4>
        <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >                  
            <tr>
                <th  >Nama Perusahaan</th>
                <th  >Waktu Mulai</th>
                <th  >Waktu Selesai</th>
                <th  >Auditor 1 </th>
                <th  >Auditor 2 </th>
                <th  >Kategori Audit</th>
                <th  >Akomodasi</th>
            </tr>       
            
            <tr>
                <td  >{{$registrasi['nama_perusahaan']}}</td>
                <td  >{{$penjadwalan['mulai_audit2']}}</td>
                <td  >{{$penjadwalan['selesai_audit2']}}</td>
                <td  >{{$penjadwalan['pelaksana1_audit2']}}</td>
                <td  >{{$penjadwalan['pelaksan2_audit2']}}</td>
                <td  >{{$penjadwalan['ktg_audit2']}}</td>
                <td  >{{$penjadwalan['akomodasi_audit2']}}</td>
            </tr>       
                
        </table>

    @elseif($status== 'rapat')
        <h4 style="text-align: center">Berikut ini adalah jadwal Rapat Auditor yang sudah dijadwalkan</h4>
        <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >                  
            <tr>
                <th  >Nama Perusahaan</th>
                <th  >Waktu Mulai</th>
                <th  >Waktu Selesai</th>
                <th  >Auditor 1 </th>
                <th  >Auditor 2 </th>
                <th  >Auditor 3 </th>
                <th  >Kategori Audit</th>
               
            </tr>       
            
            <tr>
                <td  >{{$registrasi['nama_perusahaan']}}</td>
                <td  >{{$penjadwalan['mulai_rapat']}}</td>
                <td  >{{$penjadwalan['selesai_rapat']}}</td>
                <td  >{{$penjadwalan['pelaksana1_rapat']}}</td>
                <td  >{{$penjadwalan['pelaksan2_rapat']}}</td>
                <td  >{{$penjadwalan['pelaksan3_rapat']}}</td>
                <td  >Remote Audit</td>
               
            </tr>       
                
        </table>
    @elseif($status== 'tinjauan')
         <h4 style="text-align: center">Berikut ini adalah jadwal Tinjauan Hasil Audit yang sudah dijadwalkan</h4>
        <table style="width:100%; border: 1px solid black;  border-collapse: collapse;" >                  
            <tr>
                <th  >Nama Perusahaan</th>
                <th  >Waktu Mulai</th>
                <th  >Waktu Selesai</th>
                <th  >Komite 1 </th>
                <th  >Komite 2 </th>
                <th  >Komite 3 </th>
                <th  >Kategori Tinjauan</th>
               
            </tr>       
            
            <tr>
                <td  >{{$registrasi['nama_perusahaan']}}</td>
                <td  >{{$penjadwalan['mulai_tinjauan']}}</td>
                <td  >{{$penjadwalan['selesai_tinjauan']}}</td>
                <td  >{{$penjadwalan['pelaksana1_tinjauan']}}</td>
                <td  >{{$penjadwalan['pelaksan2_tinjauan']}}</td>
                <td  >{{$penjadwalan['pelaksan3_tinjauan']}}</td>
                <td  >Remote</td>
               
            </tr>       
                
        </table>
    @endif

    
           
    </div>

    <br><br>

    <<footer style="text-align:center;">
        <div style="background-color:#00acac; color:white; height: 50px;">
            <a><b>Call Center:  021-7983666 ext 1324</b></a><br>
            <a><b>WhatsApp: 0812-8957-7157</b></a>
        </div>
    </footer>
</body>
</html>