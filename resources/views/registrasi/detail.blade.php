@extends('layouts.default')

@section('title', 'Detail Registrasi Halal')

@push('css')
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item">Registrasi Halal</li>
		<li class="breadcrumb-item active">Detail Registrasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Detail Registrasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->

			@foreach($data as $index => $value)
			@foreach($dataKantor as $index2 => $value2)			            
			@foreach($dataPabrik as $index3 => $value3)						
			@foreach($dataPemilikPerusahaan as $index4 => $value4)						
			@foreach($dataDSM as $index7 => $value7)						

			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">

					<h4 class="panel-title">Detail Registrasi Halal : {{$value['no_registrasi']}}</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
                    <form class="form-horizontal form-bordered" >
						<div class="form-group row label-detail">
                            
                                @php
                                    $sh = $value['status_halal'] ? $value['status_halal'] : '-';
                                    $shb = $value['sh_berlaku'] ? $value['sh_berlaku'] : '-';
                                @endphp
								<div class="container col-lg-12">
									<table cellpadding="10" border="0">
										<tr>
											<td colspan="3"><h4 style="color: #2980b9"><b> {{$value['name']}}</b> ({{$value['nama_perusahaan']}})</h4></td>
										</tr>
										<tr>
											<td><p><b>No. Surat Permohonan Sertifikasi : </b> {{$value['no_surat']}}</p></td>										
											<td><p><b>No. Registrasi : </b> {{$value['no_registrasi']}}</p></td>
											<td><p><b>Tanggal Registrasi : </b> {{$value['tgl_registrasi']}}</p></td>
											<td><p><b>Jenis Registrasi : </b> {{$value['jenis']}}</p></td>
										</tr>
										<tr>											
											<td><p><b>Status Registrasi : </b>{{$value['status_registrasi']}}</p></td>
											<td><p><b>Status Halal Sebelumnya : </b>{{$sh}}</p></td>
											<td><p><b>SH Berlaku s/d : </b>{{$shb}}</p></td>											
										</tr>
										<tr>																						
											<td><p><b>No Sertifikat SJPH : </b>{{$value['no_sertifikat']}}</p></td>
											<td><p><b>SJPH Berlaku s/d : </b>{{$value['tgl_sjph']}}</p></td>
										</tr>
										<tr>																						
											<td><p><b>Jenis Produk : </b>{{$value['jenis_produk']}}</p></td>
											<td><p><b>Jenis Badan Usaha : </b>{{$value['jenis_badan_usaha']}}</p></td>
											<td><p><b>Kepemilikan : </b>{{$value['kepemilikan']}}</p></td>
											<td><p><b>Skala Usaha : </b>{{$value['skala_usaha']}}</p></td>											
										</tr>
										<tr>																						
											<td><p><b>No KTP : </b>{{$value['no_tipe']}}</p></td>
											<td><p><b>No NPWP : </b>{{$value['no_tipe2']}}</p></td>
											<td><p><b>Jenis Izin Usaha : </b>{{$value['jenis_izin']}}</p></td>
											<td><p><b>Jumlah Karyawan : </b>{{$value['jumlah_karyawan']}}</p></td>
										</tr>
										<tr>																						
											<td><p><b>Kapasitas Produksi : </b>{{$value['kapasitas_produksi']}}</p></td>
											<td colspan="3"><p><b>Jenis Produk : </b>{{$value['kelompok']}}</p></td>											
										</tr>
										<tr>
											<td><p><b>Sertifikat Perusahaan : </b>{{$value['sertifikat_perusahaan']}}</p></td>
											<td><p><b>Nomor Induk Berusaha (NIB) : </b>{{$value['nib']}}</p></td>
											@if ($value['jenis'] == "Rumah Potong Hewan")
												<td><p><b>Nomor Kontrol Veteriner (NKV) : </b>{{$value['nkv']}}</p></td>
												{{-- @component('components.fordetail',['label' => 'Nomor Kontrol Veteriner','value'=>$value['nkv']])@endcomponent --}}											
											@endif
										</tr>
										<tr>
											<span id="stat_val" style="display:none">{{$value['statusnya']}}</span>
											<td><p id="notif_user"></p></td>											
										</tr>
										@if ($value['jenis'] == "Industri Pengolahan")
											<tr>
												<td colspan="4">
													<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
														<tr>
															<td colspan="2"><h4 style="color: #2980b9">Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll) :</h4></td>																								
														</tr>
														<tr>														
															<td><p><b>Jenis Surat : </b>{{$value['jenis_surat']}}</p></td>
															<td><p><b>Nomor Surat : </b>{{$value['nomor_surat']}}</p></td>
														</tr>
													</table>																																						
												</td>
											</tr>
										@endif
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
													<tr>
														@if ($value['jenis'] == "Rumah Potong Hewan")									
															<td colspan="6"><h4 style="color: #196a5b">Alamat Utama</h4></td>
														@elseif ($value['jenis'] == "Industri Pengolahan")
															<td colspan="6"><h4 style="color: #196a5b">Alamat Kantor</h4></td>
														@else
															<td colspan="6"><h4 style="color: #196a5b">Alamat Kantor</h4></td>
														@endif																						
													</tr>
													<tr>
														<td colspan="6"><p><b>Alamat : </b>{{$value2['alamat']}}</p></td>
													</tr>
													<tr>																			
														<td><p><b>Negara : </b><br>{{$value2['negara']}}</p></td>
														
														@if ($value2['negara'] == 'Indonesia')
															<td><p><b>Provinsi : </b><br>{{$value2['provinsi_domestik']}}</p></td>
															<td><p><b>Kota : </b><br>{{$value2['kota_domestik']}}</p></td>
															{{-- @component('components.fordetail',['label' => 'Provinsi','value'=>$value2['provinsi_domestik']])@endcomponent
															@component('components.fordetail',['label' => 'Kota','value'=>$value2['kota_domestik']])@endcomponent --}}
														@else
															<td><p><b>Provinsi : </b><br>{{$value2['provinsi']}}</p></td>
															<td><p><b>Kota : </b><br>{{$value2['kota']}}</p></td>
															{{-- @component('components.fordetail',['label' => 'Provinsi','value'=>$value2['provinsi']])@endcomponent
															@component('components.fordetail',['label' => 'Kota','value'=>$value2['kota']])@endcomponent --}}
														@endif											
														{{-- @component('components.fordetail',['label' => 'Telepon','value'=>$value2['telepon']])@endcomponent
														@component('components.fordetail',['label' => 'Kode Pos','value'=>$value2['kodepos']])@endcomponent
														@component('components.fordetail',['label' => 'Email','value'=>$value2['email']])@endcomponent --}}
														<td><p><b>Telepon : </b><br>{{$value2['telepon']}}</p></td>
														<td><p><b>Kode Pos : </b><br>{{$value2['kodepos']}}</p></td>
														<td><p><b>Email : </b><br>{{$value2['email']}}</p></td>
													</tr>													
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6;">
													<tr>
														@if ($value['jenis'] == "Rumah Potong Hewan")									
															<td colspan="6"><h4 style="color: #2980b9">Alamat RPH/U Lainnya</h4></td>
														@elseif ($value['jenis'] == "Industri Pengolahan")
															<td colspan="6"><h4 style="color: #2980b9">Alamat Pabrik</h4></td>
														@else
															<td colspan="6"><h4 style="color: #2980b9">Alamat Pabrik</h4></td>
														@endif																	
													</tr>
													<tr>
														<td colspan="6"><p><b>Alamat : </b>{{$value3['alamat']}}</p></td>
													</tr>
													<tr>															
														<td><p><b>Negara : </b><br>{{$value3['negara']}}</p></td>
														
														@if ($value3['negara'] == 'Indonesia')
															<td><p><b>Provinsi : </b><br>{{$value3['provinsi_domestik']}}</p></td>
															<td><p><b>Kota : </b><br>{{$value3['kota_domestik']}}</p></td>
															{{-- @component('components.fordetail',['label' => 'Provinsi','value'=>$value2['provinsi_domestik']])@endcomponent
															@component('components.fordetail',['label' => 'Kota','value'=>$value2['kota_domestik']])@endcomponent --}}
														@else
															<td><p><b>Provinsi : </b><br>{{$value3['provinsi']}}</p></td>
															<td><p><b>Kota : </b><br>{{$value3['kota']}}</p></td>
															{{-- @component('components.fordetail',['label' => 'Provinsi','value'=>$value2['provinsi']])@endcomponent
															@component('components.fordetail',['label' => 'Kota','value'=>$value2['kota']])@endcomponent --}}
														@endif											
														{{-- @component('components.fordetail',['label' => 'Telepon','value'=>$value2['telepon']])@endcomponent
														@component('components.fordetail',['label' => 'Kode Pos','value'=>$value2['kodepos']])@endcomponent
														@component('components.fordetail',['label' => 'Email','value'=>$value2['email']])@endcomponent --}}
														<td><p><b>Telepon : </b><br>{{$value3['telepon']}}</p></td>
														<td><p><b>Kode Pos : </b><br>{{$value3['kodepos']}}</p></td>
														<td><p><b>Email : </b><br>{{$value3['email']}}</p></td>
													</tr>
													<tr>														
													</tr>
													<tr>														
														@if ($value['jenis'] == "Rumah Potong Hewan")
															<td><p><b>Status RPH/U : </b>{{$value3['status_pabrik']}}</p></td>
														@elseif ($value['jenis'] == "Industri Pengolahan")															
															<td><p><b>Status Pabrik : </b>{{$value3['status_pabrik']}}</p></td>
														@endif			
														<td colspan="5"><p><b>Jenis Fasilitas Produksi : </b>{{$value3['jenis_fasilitas_produksi']}}</p></td>
														{{-- @component('components.fordetail',['label' => 'Jenis Fasilitas Poduksi','value'=>$value3['jenis_fasilitas_produksi']])@endcomponent --}}
													</tr>
												</table>
											</td>										
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Pemilik Perusahaan</h4></td>
													</tr>
													<tr>
														<td><p><b>Nama : </b>{{$value4['nama_pemilik']}}</p></td>
														<td colspan="2"><p><b>Jabatan : </b>{{$value4['jabatan_pemilik']}}</p></td>
													</tr>
													<tr>
														<td><p><b>Telepon : </b>{{$value4['telepon_pemilik']}}</p></td>
														<td><p><b>Fax : </b>{{$value4['fax_pemilik']}}</p></td>
														<td><p><b>Email : </b>{{$value4['email_pemilik']}}</p></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
													<tr>
														<td colspan="6"><h4 style="color: #2980b9">Penanggung Jawab</h4></td>
													</tr>
													<tr>
														<td><p><b>Nama : </b>{{$value4['nama_pj']}}</p></td>
														<td colspan="2"><p><b>Jabatan : </b>{{$value4['jabatan_pj']}}</p></td>
													</tr>
													<tr>
														<td><p><b>Telepon : </b>{{$value4['telepon_pj']}}</p></td>
														<td><p><b>Fax : </b>{{$value4['fax_pj']}}</p></td>
														<td><p><b>Email : </b>{{$value4['email_pj']}}</p></td>
													</tr>
													<tr>
														
													</tr>
													{{-- @component('components.fordetail',['label' => 'Sertifikat Perusahaan','value'=>$value['sertifikat_perusahaan']])@endcomponent
													@component('components.fordetail',['label' => 'Nomor Induk Berusaha (NIB)','value'=>$value['nib']])@endcomponent --}}
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
												@if ($value['jenis'] == "Industri Pengolahan" || $value['jenis'] == "Barang Gunaan")
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
													</tr>
													@php $no5=1; @endphp
													@foreach($dataPenyeliaHalal as $index10 => $value10)
														<tr>
															<td colspan="6"><h5 style="color: #196a5b">Data Ke-{{$no5}}</h4></td>
														<tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td colspan="2"><p><b>Nama : </b>{{$value10['nama_dph']}}</p></td>
																		<td><p><b>No KTP : </b>{{$value10['ktp_dph']}}</p></td>																		
																	</tr>
																	<tr>
																		<td><p><b>No Sertifikat : </b>{{$value10['sertif_dph']}}</p></td>
																		<td><p><b>No dan Tanggal SK : </b>{{$value10['no_tglsk_dph']}}</p></td>
																		<td><p><b>No Kontak : </b>{{$value10['no_kontrak_dph']}}</p></td>
																	</tr>
																</table>
															</td>
														</tr>														
														@php $no5+=1; @endphp
													@endforeach
													
												@elseif ($value['jenis'] == "Rumah Potong Hewan")
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Sumber Daya Manusia</h4></td>
													</tr>
													@php $no=1; @endphp
													@foreach($dataSDM as $index5 => $value5)
														<tr>
															<td colspan="6"><h5 style="color: #196a5b">Data Ke-{{$no}}</h4></td>
														<tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">																	
																	<tr>
																		<td><p><b>Jenis Data SDM : </b>{{$value5['jenis_sdm']}}</p></td>
																		<td><p><b>Nama : </b>{{$value5['nama_sdm']}}</p></td>
																		<td><p><b>No KTP : </b>{{$value5['ktp_sdm']}}</p></td>
																	</tr>
																	<tr>
																		<td><p><b>No Sertifikat : </b>{{$value5['sertif_sdm']}}</p></td>
																		<td><p><b>No dan Tanggal SK : </b>{{$value5['no_tglsk_sdm']}}</p></td>
																		<td><p><b>No Kontak : </b>{{$value5['no_kontrak_sdm']}}</p></td>
																	</tr>
																</table>
															</td>
														</tr>														
														@php $no+=1; @endphp
													@endforeach														
												@elseif ($value['jenis'] == "Restoran / Katering")
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
													</tr>
													@php $no5=1; @endphp
													@foreach($dataPenyeliaHalal as $index10 => $value10)
														<tr>
															<td colspan="6"><h5 style="color: #196a5b">Data Ke-{{$no5}}</h4></td>
														<tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td colspan="2"><p><b>Nama : </b>{{$value10['nama_dph']}}</p></td>
																		<td><p><b>No KTP : </b>{{$value10['ktp_dph']}}</p></td>																		
																	</tr>
																	<tr>
																		<td><p><b>No Sertifikat : </b>{{$value10['sertif_dph']}}</p></td>
																		<td><p><b>No dan Tanggal SK : </b>{{$value10['no_tglsk_dph']}}</p></td>
																		<td><p><b>No Kontak : </b>{{$value10['no_kontrak_dph']}}</p></td>
																	</tr>
																</table>
															</td>
														</tr>														
														@php $no5+=1; @endphp
													@endforeach													
												@elseif ($value['jenis'] == "Jasa")
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Penyelia Halal</h4></td>
													</tr>
													@php $no5=1; @endphp
													@foreach($dataPenyeliaHalal as $index10 => $value10)
														<tr>
															<td colspan="6"><h5 style="color: #196a5b">Data Ke-{{$no5}}</h4></td>
														<tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td colspan="2"><p><b>Nama : </b>{{$value10['nama_dph']}}</p></td>
																		<td><p><b>No KTP : </b>{{$value10['ktp_dph']}}</p></td>																		
																	</tr>
																	<tr>
																		<td><p><b>No Sertifikat : </b>{{$value10['sertif_dph']}}</p></td>
																		<td><p><b>No dan Tanggal SK : </b>{{$value10['no_tglsk_dph']}}</p></td>
																		<td><p><b>No Kontak : </b>{{$value10['no_kontrak_dph']}}</p></td>
																	</tr>
																</table>
															</td>
														</tr>														
														@php $no5+=1; @endphp
														@endforeach														
												@endif													
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
												@if ($value['jenis'] == "Industri Pengolahan" || $value['jenis'] == "Barang Gunaan")													
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Produk</h4></td>
													</tr>
													@foreach($dataProduk as $index11 => $value11)														
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td><p><b>Klasifikasi Jenis Produk : </b>{{$value11['klasifikasi_jenis_produk']}}</p></td>																		
																		<td><p><b>Area Pemasaran : </b>{{$value11['area_pemasaran']}}</p></td>
																		<td><p><b>Izin Edar : </b>{{$value11['izin_edar']}}</p></td>
																	</tr>
																	<tr>																																				
																	</tr>
																	<tr>																																				
																	</tr>
																	<tr>																		
																		<td colspan="3"><p style="width: 500px;"><b>Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada) : </b>{{$value11['izin_edar']}}</p></td>
																	</tr>
																	@php $no6=1; @endphp
																	@foreach($detailDataProduk as $index12 => $value12)
																		<tr>
																			<td><p><b>Merk/Brand Ke-{{$no6}} : </b>{{$value12['merk']}}</p></td>
																		</tr>
																		@php $no6+=1; @endphp
																	@endforeach
																</table>
															</td>
														</tr>																												
													@endforeach																										
												@elseif ($value['jenis'] == "Rumah Potong Hewan")													
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Jumlah Produksi</h4></td>
													</tr>
													@php $no2=1; @endphp
													@foreach($dataJmlProduksi as $index6 => $value6)
														<tr>
															<td colspan="6"><h5 style="color: #196a5b">Data Ke-{{$no2}}</h4></td>
														<tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td><p><b>Jenis Hewan : </b>{{$value6['jenis_hewan']}}</p></td>
																		<td><p><b>Jumlah Produksi Perhari : </b>{{$value6['jumlah_produksi_perhari']}}</p></td>
																		<td><p><b>Jumlah Produksi Perbulan : </b>{{$value6['jumlah_produksi_perbulan']}}</p></td>
																	</tr>																	
																</table>
															</td>
														</tr>														
														@php $no2+=1; @endphp
													@endforeach													
												@elseif ($value['jenis'] == "Restoran / Katering")													
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Kelompok Usaha</h4></td>
													</tr>
													@foreach($dataKelompokUsaha as $index13 => $value13)
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #78b3a8">
																	<tr>
																		<td><p><b>Kelompok Usaha : </b>{{$value13['kelompok_usaha']}}</p></td>
																		<td><p><b>Kategori Usaha : </b>{{$value13['kategori_usaha']}}</p></td>
																		<td><p><b>Jumlah Cabang Usaha : </b>{{$value13['jumlah_cabang_usaha']}}</p></td>
																	</tr>
																	<tr>
																		<td><p><b>Alamat Cabang Usaha : </b>{{$value13['alamat_cabang_usaha']}}</p></td>
																		<td><p><b>Area Pemasaran Usaha : </b>{{$value13['area_pemasaran_usaha']}}</p></td>
																		<td><p><b>Izin Edar Usaha : </b>{{$value13['izin_edar_usaha']}}</p></td>
																	</tr>
																	<tr>																		
																		<td colspan="3"><p><b>Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada) : </b>{{$value13['produk_lain_usaha']}}</p></td>
																	</tr>
																	@endforeach
																	@php $no7=1; @endphp
																	@foreach($detailRegisKelompok as $index14 => $value14)
																		<tr>
																			<td><p><b>Sertifikat Lainnya-{{$no7}} : </b>{{$value14['sertifikat_lainnya']}}</p></td>
																		</tr>														
																		@php $no7+=1; @endphp
																	@endforeach
																</table>
															</td>
														</tr>													
												@elseif ($value['jenis'] == "Jasa")																					
														<tr>
															<td colspan="3"><h4 style="color: #196a5b">Jasa</h4></td>
														</tr>
														@foreach($dataJasa as $index11 => $value11)	
															<tr>
																<td><p><b>Klasifikasi Jenis Jasa : </b>{{$value11['klasifikasi_jenis_jasa']}}</p></td>																
															</tr>
															<tr>																
																<td><p><b>Area Pemasaran Jasa : </b>{{$value11['area_pemasaran_jasa']}}</p></td>																
															</tr>
															<tr>																
																<td><p><b>Produk Lain Jasa : </b>{{$value11['produk_lain_jasa']}}</p></td>
															</tr>																	
														@endforeach
												@endif													
												</table>
											</td>
										</tr>										
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
													<tr>
														<td colspan="6"><h4 style="color: #2980b9">Data Sistem Manajemen</h4></td>
													</tr>
													@php $no3=1; @endphp
													@foreach($detailDSM as $index8 => $value8)
														<tr>																
															<td colspan="3"><h5 style="color: #2980b9">Data Ke- : {{$no3}}</h5></td>
														</tr>
														<tr>
															<td colspan="3">
																<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
																	<tr>																
																		<td><p><b>Sistem manajemen perusahaan yang relevan : </b>{{$value8['sistem_manajemen']}}</p></td>
																	</tr>
																	<tr>																
																		<td><p><b>Sertifikasi : </b>{{$value8['sertifikasi_manajemen']}}</p></td>
																	</tr>
																</table>
															</td>
														</tr>														
														@php $no3+=1; @endphp
													@endforeach
													<tr>																
														<td colspan="3"><p><b>Proses yang di subkontrakkan (outsourcing), jika ada : </b>{{$value7['outsourcing']}}</p></td>
													</tr>
													<tr>																
														<td colspan="3"><p><b>Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) : </b>{{$value7['konsultan']}}</p></td>
													</tr>
													<tr>																
														<td colspan="3"><p><b>Total jumlah karyawan dalam organisasi : </b>{{$value7['jumlah_karyawan_organisasi']}}</p></td>
													</tr>
													<tr>																
														<td colspan="3"><p><b>Jumlah karyawan (penuh waktu) dalam lingkup sertifikasi</b></p></td>
													</tr>
													<tr>																
														<td><p><b>Shift 1 : </b>{{$value7['shift_1']}}</p></td>
														<td><p><b>Shift 2 : </b>{{$value7['shift_2']}}</p></td>
														<td><p><b>Shift 3 : </b>{{$value7['shift_3']}}</p></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
													<tr>
														<td colspan="6"><h4 style="color: #2980b9">Data Lokasi Lainnya</h4></td>
													</tr>
													@php $no4=1; @endphp
													@foreach($dataLokasiLain as $index9 => $value9)
														<tr>
															<td colspan="6"><h5 style="color: #2980b9">Data Ke-{{$no4}}</h5></td>
														</tr>
														<tr>
															<td>
																<table border="0" cellpadding="10" style="border-left: 3px solid #5eb7e6">
																	<tr>																
																		<td colspan="4"><p><b>Nama Lokasi : </b>{{$value9['nama_lokasi_lainnya']}}</p></td>																		
																	</tr>
																	<tr>																																																				
																		<td colspan="4"><p><b>Kota : </b>{{$value9['kota_lainnya']}}</p></td>
																	</tr>
																	<tr>																																		
																		<td colspan="4"><p><b>Alamat : </b>{{$value9['alamat_lainnya']}}</p></td>																		
																	</tr>																	
																	<tr>																																																				
																		<td><p><b>Telepon : </b>{{$value9['telepon_lainnya']}}</p></td>
																		<td><p><b>Kode Pos : </b>{{$value9['kodepos_lainnya']}}</p></td>
																		<td><p><b>Fax : </b>{{$value9['fax_lainnya']}}</p></td>
																		<td><p><b>Narahubung : </b>{{$value9['narahubung_lainnya']}}</p></td>
																	</tr>																	
																</table>
															</td>
														</tr>																												
														@php $no4+=1; @endphp
													@endforeach
												</table>											
											</td>
										</tr>
									</table>                                	
								</div>																								                                                                								
							<div class="col-md-12 offset-md-5">
								@if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>	
								@else
									@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
								@endif	
							</div>
						</div>
					</form>
				</div>
				<!-- end panel-body -->
            </div>
			
			@endforeach			
			@endforeach
			@endforeach
			@endforeach
			@endforeach						
            			
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')
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
@endpush