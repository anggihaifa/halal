<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	body{
		border:solid 1px #c9c9c9;
		border-radius: 5px;
		padding: 15px;
		font-family: Arial, Helvetica, sans-serif;
	}

	.body-bg{
		position: absolute;
		z-index: -1;
		margin: auto;
		top: 45%;
		left: 30%;
		opacity: 0.075;
	}

	.forHeader{
		background: #ededed;
		width: 100%;
		padding: 15px 5px;
		height: 65px;
		border-radius: 5px;
		margin-bottom: 20px;
	}
	.forHeader .inHeader{
		display: flex;
		color: #117391;
	}
	.logo-sucofindo{
		margin-top: 5px;
		margin-left: 15px;
		width: 100px;
	}
	.text-header{
		margin-left: 130px;
		font-size: 22px;
	}

	.text-header > div{
		margin-bottom: 7px;
	}

	.forNoReg{
		margin-bottom: 15px;
		padding: 10px 15px;
		background: #cbedf7;
		border-radius: 5px;
	}
	.forNoReg > div{
		margin-bottom: 5px;
	}

	.forTitle{
		padding: 10px;
		background: #a5e8b9;
		font-weight: bold;
		font-size: 15px;
		text-align: center;
		border-radius: 5px;
		margin-bottom: 10px;
		color: #454545;
	}
	td{
		padding: 5px;
	}
	.forData{
		font-size: 15px;
	}
	.forData b{
		color:#2b2b2b;
	}
</style>

@if(is_null($pembayaranData)==0)
     @php

        $nominal1 = number_format($pembayaranData['nominal_tahap1'],2,',','.');
        $nominal2 = number_format($pembayaranData['nominal_tahap2'],2,',','.');
        $nominal3 = number_format($pembayaranData['nominal_tahap3'],2,',','.');

    @endphp 
@endif     

<body>
	<img class="body-bg" src="{{ public_path('/assets/img/logo/sci-color.png') }}" alt="" >
	<div class="forHeader">
		<div class="inHeader">
			<img class="logo-sucofindo" src="{{ public_path('/assets/img/logo/sci-color.png') }}" alt="" >	
			<div class="text-header">
				<div>LEMBAGA PEMERIKSA HALAL</div>
				<div>PT.SUCOFINDO</div>
			</div>	
		</div>
	</div>
	@if($registrasiData['status']=='13')
		<div class="forTitle">
			<span>TANDA BUKTI PEMBAYARAN TAHAP 1 SERTIFIKASI PRODUK HALAL</span>
		</div>	
	@elseif($registrasiData['status']=='l')
		<div class="forTitle">
			<span>TANDA BUKTI PEMBAYARAN TAHAP 2 SERTIFIKASI PRODUK HALAL</span>
		</div>
	@elseif($registrasiData['status']=='25')
		<div class="forTitle">
			<span>TANDA BUKTI PEMBAYARAN PELUNASAN SERTIFIKASI PRODUK HALAL</span>
		</div>

	@endif	


	</div>
	<div>
		<table class="forData">
			<tr>
				<td>Nomor Registrasi</td>
				<td>:</td>
				<td width="65%"><b>{{$registrasiData['no_registrasi']}}</b></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td><b>{{$userData['name']}}</b></td>
			</tr>
			<tr>
				<td>Nama Perusahaan</td>
				<td>:</td>
				<td><b>{{$userData['perusahaan']}}</b></td>
			</tr>
			<tr>
				<td>{{strtoupper($registrasiData['tipe'])}}</td>
				<td>:</td>
				<td><b>{{$registrasiData['no_tipe']}}</b></td>
			</tr>
			<tr>
				<td>Tanggal Registrasi</td>
				<td>:</td>
				<td><b>{{ date("d/m/Y",strtotime($registrasiData['tgl_registrasi']))}}</b></td>
			</tr>
			<tr>
				<td>Jenis Registrasi</td>
				<td>:</td>
				<td><b>{{$registrasiData['jenis_registrasi']['jenis_registrasi']}}</b></td>
			</tr>
			<tr>
				<td>Status Registrasi</td>
				<td>:</td>
				<td><b>{{$registrasiData['status_registrasi']}}</b></td>
			</tr>
		
			<tr>
				<td>Jenis Produk</td>
				<td>:</td>
				<td><b>{{$registrasiData['jenis_produk']}}</b></td>
			</tr>
			<tr>
				<td>Skala Usaha</td>
				<td>:</td>
				<td><b>{{$registrasiData['skala_usaha']}}</b></td>
			</tr>

	@if($registrasiData['status']=='13')
			<tr>
				<td>Nominal Pembayaran Tahap 1</td>
				<td>:</td>
				
				<td><b>{{$pembayaranData['mata_uang']}} {{$nominal1}}</b></td>
			
			</tr>

			</table>
	</div>

	<div>
		<p>Bukti pembayaran ini harap disimpan baik-baik sebagai bukti pembayaran yang sah.</p>
		<br>
		<p>{{$userData['kota']}}, {{$pembayaranData['tanggal_tahap1']}}</p>
	</div>
	@elseif($registrasiData['status']=='l')
			<tr>
				<td>Nominal Pembayaran Tahap 2</td>
				<td>:</td>
				
				<td><b>{{$pembayaranData['mata_uang']}} {{$nominal2}}</b></td>
			
			</tr>
			</table>
	</div>

	<div>
		<p>Bukti pembayaran ini harap disimpan baik-baik sebagai bukti pembayaran yang sah.</p>
		<br>
		<p>{{$userData['kota']}}, {{$pembayaranData['tanggal_tahap2']}}</p>
	</div>
	@elseif($registrasiData['status']=='25')
			<tr>
				<td>Nominal Pembayaran Pelunasan</td>
				<td>:</td>
				
			<td><b>{{$pembayaranData['mata_uang']}} {{$nominal3}}</b></td>
			
			</tr>
			</table>
	</div>

	<div>
		<p>Bukti pembayaran ini harap disimpan baik-baik sebagai bukti pembayaran yang sah.</p>
		<br>
		<p>{{$userData['kota']}}, {{$pembayaranData['tanggal_tahap3']}}</p>
	</div>

		@endif	
			
		
</body>
</html>
