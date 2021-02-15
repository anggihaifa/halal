<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	body{				
		font-family: Arial, Helvetica, sans-serif;
	}

    td p{
        font-size: 12px;
    }
</style>

{{-- @if(is_null($pembayaranData)==0)
     @php

        $nominal1 = number_format($pembayaranData['nominal_tahap1'],2,',','.');
        $nominal2 = number_format($pembayaranData['nominal_tahap2'],2,',','.');
        $nominal3 = number_format($pembayaranData['nominal_tahap3'],2,',','.');

    @endphp 
@endif      --}}
@php
    $sh = $registrasiData['status_registrasi'] ? $registrasiData['status_registrasi'] : '-';
    $shb = $registrasiData['sh_berlaku'] ? $registrasiData['sh_berlaku'] : '-';
@endphp

<body>	
	<div class="forHeader">
		<div class="inHeader">			
			<div class="text-header">
				<h3>Detail Registrasi</h3>
			</div>
            <table cellpadding="10" border="0">
                <tr>                    
                    <td colspan="4"><h4><b>{{$registrasiData['nama']}}</b> ({{$registrasiData['perusahaan']}})</h4></td>
                </tr>
                <tr>
                    <td><p><b>No. Surat Permohonan Sertifikasi : </b> {{$registrasiData['no_surat_sertif']}}</p></td>
				    <td><p><b>No. Registrasi : </b> {{$registrasiData['no_registrasi']}}</p></td>
                    <td><p><b>Tanggal Registrasi : </b> {{$registrasiData['tgl_registrasi']}}</p></td>
                    <td><p><b>Jenis Registrasi : </b> {{$registrasiData['jenis_registrasi']}}</p></td>
				</tr>
                <tr>											
                    <td><p><b>Status Registrasi : </b>{{$registrasiData['status_registrasi']}}</p></td>
				    <td><p><b>Status Halal Sebelumnya : </b>{{$sh}}</p></td>
                    <td><p><b>SH Berlaku s/d : </b>{{$shb}}</p></td>											
				</tr>
				<tr>																						
					<td><p><b>No Sertifikat SJPH : </b>{{$registrasiData['sertifikat_sjph']}}</p></td>
					<td><p><b>SJPH Berlaku s/d : </b>{{$registrasiData['sh_berlaku']}}</p></td>
				</tr>
                <tr>																						
					<td><p><b>Jenis Produk : </b>{{$registrasiData['jenis_produk']}}</p></td>
					<td><p><b>Jenis Badan Usaha : </b>{{$registrasiData['jenis_badan_usaha']}}</p></td>
					<td><p><b>Kepemilikan : </b>{{$registrasiData['kepemilikan']}}</p></td>
				    <td><p><b>Skala Usaha : </b>{{$registrasiData['skala_usaha']}}</p></td>											
				</tr>
                <tr>																						
					<td><p><b>No KTP : </b>{{$registrasiData['no_ktp']}}</p></td>
					<td><p><b>Jenis Izin Usaha : </b>{{$registrasiData['jenis_izin_usaha']}}</p></td>
					<td><p><b>No NPWP : </b>{{$registrasiData['no_npwp']}}</p></td>
					<td><p><b>Jumlah Karyawan : </b>{{$registrasiData['jml_karyawan']}}</p></td>
				</tr>
				<tr>																						
					<td><p><b>Kapasitas Produksi : </b>{{$registrasiData['kapasitas_produk']}}</p></td>
					<td colspan="3"><p><b>Jenis Produk : </b>{{$registrasiData['kelompok_produk']}}</p></td>											
				</tr>
                <tr>
					<td><p><b>Sertifikat Perusahaan : </b>{{$registrasiData['sertif_perusahaan']}}</p></td>
					<td><p><b>Nomor Induk Berusaha (NIB) : </b>{{$registrasiData['nib']}}</p></td>
					@if ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")
						<td><p><b>Nomor Kontrol Veteriner (NKV) : </b>{{$registrasiData['nkv']}}</p></td>
						{{-- @component('components.fordetail',['label' => 'Nomor Kontrol Veteriner','value'=>$value['nkv']])@endcomponent --}}											
					@endif
				</tr>
				<tr>
					<span id="stat_val" style="display:none;">{{$registrasiData['statusnya']}}</span>
					<td><p id="notif_user"></p></td>											
				</tr>
                @if ($registrasiData['jenis_registrasi'] == "Industri Pengolahan")
					<tr>
						<td colspan="4">
							<table border="0" cellpadding="10">
								<tr>
									<td colspan="2"><h4 style="color: #2980b9">Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll) :</h4></td>
								</tr>
								<tr>														
									<td><p><b>Jenis Surat : </b>{{$registrasiData['jenis_surat']}}</p></td>
									<td><p><b>Nomor Surat : </b>{{$registrasiData['no_surat_aspeklegal']}}</p></td>
								</tr>
							</table>																																						
						</td>
					</tr>
				@endif
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								@if ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")									
									<td colspan="6"><h4 style="color: #196a5b">Alamat Utama</h4></td>
								@elseif ($registrasiData['jenis_registrasi'] == "Industri Pengolahan")
									<td colspan="6"><h4 style="color: #196a5b">Alamat Kantor</h4></td>
								@else
									<td colspan="6"><h4 style="color: #196a5b">Alamat Kantor</h4></td>
								@endif																						
							</tr>
							<tr>
								<td colspan="2"><p><b>Alamat : </b><br>{{$registrasiData['alamat_kantor']}}</p></td>
																		
								<td><p><b>Negara : </b><br>{{$registrasiData['negara']}}</p></td>
								
								@if ($registrasiData['negara'] == 'Indonesia')
									<td><p><b>Provinsi : </b><br>{{$registrasiData['provinsi_domestik']}}</p></td>
									<td><p><b>Kota : </b><br>{{$registrasiData['kota_domestik']}}</p></td>									
								@else
									<td><p><b>Provinsi : </b><br>{{$registrasiData['provinsi']}}</p></td>
									<td><p><b>Kota : </b><br>{{$registrasiData['kota']}}</p></td>									
								@endif																			
								<td><p><b>Telepon : </b><br>{{$registrasiData['telepon_kantor']}}</p></td>
								<td><p><b>Kode Pos : </b><br>{{$registrasiData['kode_pos_kantor']}}</p></td>
								<td><p><b>Email : </b><br>{{$registrasiData['email_kantor']}}</p></td>
							</tr>													
						</table>
					</td>
				</tr>
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								@if ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")									
									<td colspan="6"><h4 style="color: #2980b9">Alamat RPH/U Lainnya</h4></td>
								@elseif ($registrasiData['jenis_registrasi'] == "Industri Pengolahan")
									<td colspan="6"><h4 style="color: #2980b9">Alamat Pabrik</h4></td>
								@else
									<td colspan="6"><h4 style="color: #2980b9">Alamat Pabrik</h4></td>
								@endif																	
							</tr>
							<tr>
								<td colspan="2"><p><b>Alamat : </b><br>{{$registrasiData['alamat_pabrik']}}</p></td>
																			
								<td><p><b>Negara : </b><br>{{$registrasiData['negara']}}</p></td>
								
								@if ($registrasiData['negara'] == 'Indonesia')
									<td><p><b>Provinsi : </b><br>{{$registrasiData['provinsi_domestik']}}</p></td>
									<td><p><b>Kota : </b><br>{{$registrasiData['kota_domestik']}}</p></td>									
								@else
									<td><p><b>Provinsi : </b><br>{{$registrasiData['provinsi']}}</p></td>
									<td><p><b>Kota : </b><br>{{$registrasiData['kota']}}</p></td>									
								@endif																			
								<td><p><b>Telepon : </b><br>{{$registrasiData['telepon_pabrik']}}</p></td>
								<td><p><b>Kode Pos : </b><br>{{$registrasiData['kodepos_pabrik']}}</p></td>
								<td><p><b>Email : </b><br>{{$registrasiData['email_pabrik']}}</p></td>
							</tr>							
							<tr>														
								@if ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")
									<td><p><b>Status RPH/U : </b>{{$registrasiData['status_rphu']}}</p></td>
								@elseif ($registrasiData['jenis_registrasi'] == "Industri Pengolahan")															
									<td><p><b>Status Pabrik : </b>{{$registrasiData['status_rphu']}}</p></td>
								@endif			
								<td colspan="5"><p><b>Jenis Fasilitas Produksi : </b>{{$registrasiData['jenis_fasilitas_produksi']}}</p></td>
								{{-- @component('components.fordetail',['label' => 'Jenis Fasilitas Poduksi','value'=>$value3['jenis_fasilitas_produksi']])@endcomponent --}}
							</tr>
						</table>
					</td>										
				</tr>
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Pemilik Perusahaan</h4></td>
							</tr>
							<tr>
								<td><p><b>Nama : </b>{{$registrasiData['nama_pemilik']}}</p></td>
								<td colspan="2"><p><b>Jabatan : </b>{{$registrasiData['jabatan_pemilik']}}</p></td>							
								<td><p><b>Telepon : </b>{{$registrasiData['telepon_pemilik']}}</p></td>
								<td><p><b>Fax : </b>{{$registrasiData['fax_pemilik']}}</p></td>
								<td><p><b>Email : </b>{{$registrasiData['email_pemilik']}}</p></td>
							</tr>
						</table>
					</td>
				</tr>
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								<td colspan="6"><h4 style="color: #2980b9">Penanggung Jawab</h4></td>
							</tr>
							<tr>
								<td><p><b>Nama : </b>{{$registrasiData['nama_pj']}}</p></td>
								<td colspan="2"><p><b>Jabatan : </b>{{$registrasiData['jabatan_pj']}}</p></td>							
								<td><p><b>Telepon : </b>{{$registrasiData['telepon_pj']}}</p></td>
								<td><p><b>Fax : </b>{{$registrasiData['fax_pj']}}</p></td>
								<td><p><b>Email : </b>{{$registrasiData['email_pj']}}</p></td>
							</tr>														
						</table>
					</td>
				</tr>
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
						@if ($registrasiData['jenis_registrasi'] == "Industri Pengolahan" || $registrasiData['jenis_registrasi'] == "Barang Gunaan")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
							</tr>
							@php $no5=1; @endphp
							{{-- @foreach($dataPenyeliaHalal as $index10 => $value10) --}}
                            @for($x=1;$x<=$registrasiData['jml_dph'];$x++)								
								<tr>									
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>{{$x}} ) </b></p></td>												
												<td colspan="2"><p><b>Nama : </b>{{$registrasiData['nama_dph_'.$x.'']}}</p></td>
												<td><p><b>No KTP : </b>{{$registrasiData['ktp_dph_'.$x.'']}}</p></td>											
												<td><p><b>No Sertifikat : </b>{{$registrasiData['sertif_dph_'.$x.'']}}</p></td>
												<td><p><b>No dan Tanggal SK : </b>{{$registrasiData['no_tglsk_dph_'.$x.'']}}</p></td>
												<td><p><b>No Kontak : </b>{{$registrasiData['no_kontrak_dph_'.$x.'']}}</p></td>
											</tr>
										</table>
									</td>
								</tr>														
								@php $no5+=1; @endphp
							{{-- @endforeach --}}
                            @endfor
							
						@elseif ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Data Sumber Daya Manusia</h4></td>
							</tr>
							@php $no=1; @endphp
							@for($x=1;$x<=$registrasiData['jml_sdm'];$x++)								
								<tr>
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>{{$x}} ) </b></p></td>
												<td><p><b>Jenis Data SDM : </b>{{$registrasiData['jenis_data_sdm_'.$x.'']}}</p></td>
												<td><p><b>Nama : </b>{{$registrasiData['nama_sdm_'.$x.'']}}</p></td>
												<td><p><b>No KTP : </b>{{$registrasiData['no_ktp_sdm_'.$x.'']}}</p></td>											
												<td><p><b>No Sertifikat : </b>{{$registrasiData['no_sertif_sdm_'.$x.'']}}</p></td>
												<td><p><b>No dan Tanggal SK : </b>{{$registrasiData['no_tglsk_sdm_'.$x.'']}}</p></td>
												<td><p><b>No Kontak : </b>{{$registrasiData['no_kontrak_sdm_'.$x.'']}}</p></td>
											</tr>
										</table>
									</td>
								</tr>														
								@php $no+=1; @endphp
							@endfor												
						@elseif ($registrasiData['jenis_registrasi'] == "Restoran / Katering")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
							</tr>
							@php $no5=1; @endphp
							@for($x=1;$x<=$registrasiData['jml_dph'];$x++)								
								<tr>									
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>{{$x}} ) </b></p></td>												
												<td colspan="2"><p><b>Nama : </b>{{$registrasiData['nama_dph_'.$x.'']}}</p></td>
												<td><p><b>No KTP : </b>{{$registrasiData['ktp_dph_'.$x.'']}}</p></td>											
												<td><p><b>No Sertifikat : </b>{{$registrasiData['sertif_dph_'.$x.'']}}</p></td>
												<td><p><b>No dan Tanggal SK : </b>{{$registrasiData['no_tglsk_dph_'.$x.'']}}</p></td>
												<td><p><b>No Kontak : </b>{{$registrasiData['no_kontrak_dph_'.$x.'']}}</p></td>
											</tr>
										</table>
									</td>
								</tr>														
								@php $no5+=1; @endphp
							{{-- @endforeach --}}
                            @endfor
						@elseif ($registrasiData['jenis_registrasi'] == "Jasa")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
							</tr>
							@php $no5=1; @endphp
							@for($x=1;$x<=$registrasiData['jml_dph'];$x++)								
								<tr>									
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>{{$x}} ) </b></p></td>												
												<td colspan="2"><p><b>Nama : </b>{{$registrasiData['nama_dph_'.$x.'']}}</p></td>
												<td><p><b>No KTP : </b>{{$registrasiData['ktp_dph_'.$x.'']}}</p></td>											
												<td><p><b>No Sertifikat : </b>{{$registrasiData['sertif_dph_'.$x.'']}}</p></td>
												<td><p><b>No dan Tanggal SK : </b>{{$registrasiData['no_tglsk_dph_'.$x.'']}}</p></td>
												<td><p><b>No Kontak : </b>{{$registrasiData['no_kontrak_dph_'.$x.'']}}</p></td>
											</tr>
										</table>
									</td>
								</tr>														
								@php $no5+=1; @endphp
							{{-- @endforeach --}}
                            @endfor
						@endif													
						</table>
					</td>
				</tr>
                <tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
						@if ($registrasiData['jenis_registrasi'] == "Industri Pengolahan" || $registrasiData['jenis_registrasi'] == "Barang Gunaan")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Data Produk</h4></td>
							</tr>
							{{-- @foreach($dataProduk as $index11 => $value11) --}}
								<tr>
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>Klasifikasi Jenis Produk : </b>{{$registrasiData['klasifikasi_jenis_produk']}}</p></td>
												<td><p><b>Area Pemasaran : </b>{{$registrasiData['area_pemasaran']}}</p></td>
												<td><p><b>Izin Edar : </b>{{$registrasiData['izin_edar']}}</p></td>
																					
												<td colspan="3"><p style="width: 500px;"><b>Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada) : </b>{{$registrasiData['izin_edar']}}</p></td>
											</tr>
											@php $no6=1; @endphp
                                            @for($x=1;$x<=$registrasiData['jml_detail_produk'];$x++)
											{{-- @foreach($detailDataProduk as $index12 => $value12) --}}
												<tr>
													<td><p><b>{{$no6}} ) Merk/Brand : </b>{{$registrasiData['merk_'.$x.'']}}</p></td>
												</tr>
												@php $no6+=1; @endphp
											@endfor
										</table>
									</td>
								</tr>																												
							{{-- @endforeach																										 --}}
						@elseif ($registrasiData['jenis_registrasi'] == "Rumah Potong Hewan")													
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Jumlah Produksi</h4></td>
							</tr>
							@php $no2=1; @endphp
							{{-- @foreach($dataJmlProduksi as $index6 => $value6) --}}
                            @for($x=1;$x<=$registrasiData['jml_produksi'];$x++)								
								<tr>
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>{{$no2}} ) </b></p></td>
												<td><p><b>Jenis Hewan : </b>{{$registrasiData['jenis_hewan_'.$x.'']}}</p></td>
												<td><p><b>Jumlah Produksi Perhari : </b>{{$registrasiData['jumlah_produksi_perhari_'.$x.'']}}</p></td>
												<td><p><b>Jumlah Produksi Perbulan : </b>{{$registrasiData['jumlah_produksi_perbulan_'.$x.'']}}</p></td>
											</tr>																	
										</table>
									</td>
								</tr>														
								@php $no2+=1; @endphp
							@endfor												
						@elseif ($registrasiData['jenis_registrasi'] == "Restoran / Katering")
							<tr>
								<td colspan="6"><h4 style="color: #196a5b">Kelompok Usaha</h4></td>
							</tr>
							{{-- @foreach($dataKelompokUsaha as $index13 => $value13) --}}
								<tr>
									<td>
										<table border="0" cellpadding="10">
											<tr>
												<td><p><b>Kelompok Usaha : </b>{{$registrasiData['kelompok_usaha']}}</p></td>
												<td><p><b>Kategori Usaha : </b>{{$registrasiData['kategori_usaha']}}</p></td>
												<td><p><b>Jumlah Cabang Usaha : </b>{{$registrasiData['jumlah_cabang_usaha']}}</p></td>
											</tr>
											<tr>
												<td><p><b>Alamat Cabang Usaha : </b>{{$registrasiData['alamat_cabang_usaha']}}</p></td>
												<td><p><b>Area Pemasaran Usaha : </b>{{$registrasiData['area_pemasaran_usaha']}}</p></td>
												<td><p><b>Izin Edar Usaha : </b>{{$registrasiData['izin_edar_usaha']}}</p></td>
											</tr>
											<tr>																		
												<td colspan="3"><p><b>Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada) : </b>{{$registrasiData['produklain_usaha']}}</p></td>
											</tr>
											{{-- @endforeach --}}
											@php $no7=1; @endphp
											{{-- @foreach($detailRegisKelompok as $index14 => $value14) --}}
                                            @for($x=1;$x<=$registrasiData['jml_detail_regis_kel'];$x++)
												<tr>
													<td><p><b>Sertifikat Lainnya-{{$no7}} : </b>{{$registrasiData['sertif_lainnya_'.$x.'']}}</p></td>
												</tr>														
												@php $no7+=1; @endphp
											@endfor
										</table>
									</td>
								</tr>													
						@elseif ($registrasiData['jenis_registrasi'] == "Jasa")
								<tr>
									<td colspan="3"><h4 style="color: #196a5b">Jasa</h4></td>
								</tr>
								{{-- @for($x=1;$x<=$registrasiData['jml_detail_regis_kel'];$x++)	 --}}
									<tr>
										<td><p><b>Klasifikasi Jenis Jasa : </b>{{$registrasiData['klasifikasi_jenis_jasa']}}</p></td>																																			
										<td><p><b>Area Pemasaran Jasa : </b>{{$registrasiData['area_pemasaran_jasa']}}</p></td>																									
										<td><p><b>Produk Lain Jasa : </b>{{$registrasiData['produk_lain_jasa']}}</p></td>
									</tr>																	
								{{-- @endfor --}}
						@endif		                        
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								<td colspan="6"><h4 style="color: #2980b9">Data Sistem Manajemen</h4></td>
							</tr>
							{{-- Data DSM --}}
								@php $no3=1; @endphp						
								@for($x=1;$x<=$registrasiData['jml_dsm'];$x++)
									<tr>
										<td>
											<table border="0" cellpadding="5">
												<tr>													
													<td><p><b>{{$no3}} ) </b></p></td>			
													<td><p><b>Sistem manajemen perusahaan yang relevan : </b>{{$registrasiData['sistem_manajemen_'.$no3.'']}}</p></td>																								
													<td><p><b>Sertifikasi : </b>{{$registrasiData['sertifikasi_manajemen_'.$no3.'']}}</p></td>
												</tr>
											</table>
										</td>
									</tr>														
									
									@php $no3+=1; @endphp
								@endfor										
							<tr>																
								<td colspan="3"><p><b>Proses yang di subkontrakkan (outsourcing), jika ada : </b>{{$registrasiData['outsourcing']}}</p></td>
							</tr>
							<tr>																
								<td colspan="3"><p><b>Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) : </b>{{$registrasiData['konsultan']}}</p></td>
							</tr>
							<tr>																
								<td colspan="3"><p><b>Total jumlah karyawan dalam organisasi : </b>{{$registrasiData['jumlah_karyawan_organisasi']}}</p></td>
							</tr>
							<tr>																
								<td><p><b>Jumlah karyawan (penuh waktu) dalam lingkup sertifikasi</b></p></td>
								<td><p><b>Shift 1 : </b>{{$registrasiData['shift1']}}</p></td>
								<td><p><b>Shift 2 : </b>{{$registrasiData['shift2']}}</p></td>
								<td><p><b>Shift 3 : </b>{{$registrasiData['shift3']}}</p></td>
							</tr>							
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<table border="0" cellpadding="10">
							<tr>
								<td colspan="6"><h4 style="color: #2980b9">Data Lokasi Lainnya</h4></td>
							</tr>
							@php $no4=1; @endphp
							@for($x=1;$x<=$registrasiData['jml_lokasilain'];$x++)
								<tr>															
									<td>
										<table border="0" cellpadding="5">
											<tr>
												<td><p><b>{{$no4}} ) </b></p></td>
												<td><p><b>Nama Lokasi : </b>{{$registrasiData['nama_lokasi_lainnya_'.$x.'']}}</p></td>																																																					
												<td><p><b>Kota : </b>{{$registrasiData['kota_lainnya_'.$x.'']}}</p></td>
												<td><p><b>Alamat : </b>{{$registrasiData['alamat_lainnya_'.$x.'']}}</p></td>																																																																	
												<td><p><b>Telepon : </b>{{$registrasiData['telepon_lainnya_'.$x.'']}}</p></td>
												<td><p><b>Kode Pos : </b>{{$registrasiData['kodepos_lainnya_'.$x.'']}}</p></td>
												<td><p><b>Fax : </b>{{$registrasiData['fax_lainnya_'.$x.'']}}</p></td>
												<td><p><b>Narahubung : </b>{{$registrasiData['narahubung_lainnya_'.$x.'']}}</p></td>
											</tr>																	
										</table>
									</td>
								</tr>																												
								@php $no4+=1; @endphp
							@endfor
						</table>											
					</td>
				</tr>
            </table>
		</div>
	</div>			

<script src="{{asset('/assets/js/checkData.js')}}"></script>
<script>	    
    data=document.getElementById("stat_val").textContent;     
	function getProgress (data) {return checkProgress(data);}
	function getNotif (data) {return notifProgress(data);}	    
	/*
	document.getElementById("status").innerText = getProgress(data);
	*/
	document.getElementById("notif_user").innerHTML = "<b>Status : </b>"+getProgress(data)+"";
</script>

</body>
</html>
{{-- @php dd($registrasiData) @endphp --}}