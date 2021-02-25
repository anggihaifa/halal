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
													<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
												@if ($value['jenis'] == "Industri Pengolahan" || $value['jenis'] == "Barang Gunaan")													
													<tr>
														<td colspan="6"><h4 style="color: #196a5b">Data Produk</h4></td>
													</tr>
													@foreach($dataProduk as $index11 => $value11)														
														<tr>
															<td>
																<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
												<table border="0" cellpadding="10">
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
																<table border="0" cellpadding="10">
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
							{{-- <div class="col-md-12 offset-md-5">
								@if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
									<a href="{{route('exportdata')}}" class="btn bnt-sm btn-primary">Download Data</a>
								@else
									@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
								@endif	
							</div> --}}
						</div>
					</form>
				</div>
				<!-- end panel-body -->				
				
																	
					<div class="panel-body panel-form">												
						<form action="{{route('downloaddata')}}" method="post" class="form-horizontal form-bordered" name="formDetail" enctype="multipart/form-data" id="msform">						
						@csrf
							<div class="form-group row label-detail" style="display:none">
							
									@php
										$sh = $value['status_halal'] ? $value['status_halal'] : '-';
										$shb = $value['sh_berlaku'] ? $value['sh_berlaku'] : '-'; 
									@endphp

									@component('components.fordetail',['label' => 'No. Surat Permohonan Sertifikasi','name'=>'no_surat_sertif','value'=>$value['no_surat']])@endcomponent
									@component('components.fordetail',['label' => 'No. Registrasi','name'=>'no_registrasi','value'=>$value['no_registrasi']])@endcomponent
									@component('components.fordetail',['label' => 'Nama','name'=>'nama','value'=>$value['name']])@endcomponent
									@component('components.fordetail',['label' => 'Perusahaan','name'=>'perusahaan','value'=>$value['nama_perusahaan']])@endcomponent
									@component('components.fordetail',['label' => 'Tanggal Registrasi','name'=>'tgl_registrasi','value'=>$value['tgl_registrasi']])@endcomponent
									@component('components.fordetail',['label' => 'Jenis Registrasi','name'=>'jenis_registrasi','value'=>$value['jenis']])@endcomponent
									@component('components.fordetail',['label' => 'Status Registrasi','name'=>'status_registrasi','value'=>ucwords($value['status_registrasi'])])@endcomponent
									@component('components.fordetail',['label' => 'Status Halal Sebelumnya','name'=>'sh_sebelumnya','value'=>$sh])@endcomponent
									@component('components.fordetail',['label' => 'SH Berlaku s/d','name'=>'sh_berlaku','value'=>$shb])@endcomponent
									<!-- @component('components.fordetail',['label' => 'Status SJPH','name'=>'status_sjph','value'=>$value['no_surat']])@endcomponent -->
									@component('components.fordetail',['label' => 'No Sertifikat SJPH','name'=>'sertifikat_sjph','value'=>$value['no_sertifikat']])@endcomponent
									@component('components.fordetail',['label' => 'SJPH Berlaku s/d','name'=>'sjph_berlaku','value'=>$value['tgl_sjph']])@endcomponent
									@component('components.fordetail',['label' => 'Jenis Produk','name'=>'jenis_produk','value'=>$value['jenis_produk']])@endcomponent
									@component('components.fordetail',['label' => 'Status','name'=>'statusnya','value'=>$value['statusnya']])@endcomponent
									@component('components.fordetail',['label' => 'Jenis Badan Usaha','name'=>'jenis_badan_usaha','value'=>$value['jenis_badan_usaha']])@endcomponent

									@if ($value['jenis'] == "Rumah Potong Hewan")
										@component('components.fordetail',['label' => 'Status Unit Usaha','name'=>'status_unit_usaha','value'=>$value['jenis_badan_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Jenis Usaha','name'=>'jenis_usaha','value'=>$value['jenis_usaha']])@endcomponent
									@elseif ($value['jenis'] == "Industri Pengolahan")
										@component('components.fordetail',['label' => 'Jenis Badan Usaha','name'=>'jenis_badan_usaha','value'=>$value['jenis_badan_usaha']])@endcomponent	
									@endif
									
									@component('components.fordetail',['label' => 'Kepemilikan','name'=>'kepemilikan','value'=>$value['kepemilikan']])@endcomponent

									@component('components.fordetail',['label' => 'Skala Usaha','name'=>'skala_usaha','value'=>ucwords($value['skala_usaha'])])@endcomponent
									@component('components.fordetail',['label' => 'No. KTP','name'=>'no_ktp','value'=>$value['no_tipe']])@endcomponent
									@component('components.fordetail',['label' => 'No. NPWP','name'=>'no_npwp','value'=>$value['no_tipe2']])@endcomponent
									@component('components.fordetail',['label' => 'Jenis Izin Usaha','name'=>'jenis_izin_usaha','value'=>$value['jenis_izin']])@endcomponent
									@component('components.fordetail',['label' => 'Jumlah Karyawan','name'=>'jml_karyawan','value'=>$value['jumlah_karyawan']])@endcomponent
									@component('components.fordetail',['label' => 'Kapasitas Produk','name'=>'kapasitas_produk','value'=>$value['kapasitas_produksi']])@endcomponent
									@component('components.fordetail',['label' => 'Kelompok Produk','name'=>'kelompok_produk','value'=>$value['kelompok']])@endcomponent
									
									{{-- Alamat Kantor --}}
									@if ($value['jenis'] == "Rumah Potong Hewan")									
										<div class="col-lg-6 text-center"><h4>Alamat Utama</h4></div><div class="col-lg-6"></div>
									@elseif ($value['jenis'] == "Industri Pengolahan")
										<div class="col-lg-6 text-center"><h4>Alamat Kantor</h4></div><div class="col-lg-6"></div>
									@else
										<div class="col-lg-6 text-center"><h4>Alamat Kantor</h4></div><div class="col-lg-6"></div>
									@endif
									@component('components.fordetail',['label' => 'Alamat','name'=>'alamat_kantor','value'=>$value2['alamat']])@endcomponent
									@component('components.fordetail',['label' => 'Negara','name'=>'negara','value'=>$value2['negara']])@endcomponent
									@if ($value2['negara'] == 'Indonesia')
										@component('components.fordetail',['label' => 'Provinsi','name'=>'provinsi_domestik','value'=>$value2['provinsi_domestik']])@endcomponent
										@component('components.fordetail',['label' => 'Kota','name'=>'kota_domestik','value'=>$value2['kota_domestik']])@endcomponent
									@else
										@component('components.fordetail',['label' => 'Provinsi','name'=>'provinsi','value'=>$value2['provinsi']])@endcomponent
										@component('components.fordetail',['label' => 'Kota','name'=>'kota','value'=>$value2['kota']])@endcomponent
									@endif								
									@component('components.fordetail',['label' => 'Telepon','name'=>'telepon_kantor','value'=>$value2['telepon']])@endcomponent
									@component('components.fordetail',['label' => 'Kode Pos','name'=>'kode_pos_kantor','value'=>$value2['kodepos']])@endcomponent
									@component('components.fordetail',['label' => 'Email','name'=>'email_kantor','value'=>$value2['email']])@endcomponent

									{{-- Alamat Pabrik --}}
									@if ($value['jenis'] == "Rumah Potong Hewan")									
										<div class="col-lg-6 text-center"><h4>Alamat RPH/U Lainnya</h4></div><div class="col-lg-6"></div>
									@elseif ($value['jenis'] == "Industri Pengolahan")
										<div class="col-lg-6 text-center"><h4>Alamat Pabrik</h4></div><div class="col-lg-6"></div>
									@else
										<div class="col-lg-6 text-center"><h4>Alamat Pabrik</h4></div><div class="col-lg-6"></div>
									@endif

									@component('components.fordetail',['label' => 'Alamat','name'=>'alamat_pabrik','value'=>$value3['alamat']])@endcomponent
									@component('components.fordetail',['label' => 'Negara','name'=>'negara_pabrik','value'=>$value3['negara']])@endcomponent
									@if ($value3['negara'] == 'Indonesia')
										@component('components.fordetail',['label' => 'Provinsi','name'=>'provinsi_domestik_pabrik','value'=>$value3['provinsi_domestik']])@endcomponent
										@component('components.fordetail',['label' => 'Kota','name'=>'kota_domestik_pabrik','value'=>$value3['kota_domestik']])@endcomponent
									@else
										@component('components.fordetail',['label' => 'Provinsi','name'=>'provinsi_pabrik','value'=>$value3['provinsi']])@endcomponent
										@component('components.fordetail',['label' => 'Kota','name'=>'kota_pabrik','value'=>$value3['kota']])@endcomponent
									@endif																
									@component('components.fordetail',['label' => 'Telepon','name'=>'telepon_pabrik','value'=>$value3['telepon']])@endcomponent
									@component('components.fordetail',['label' => 'Kode Pos','name'=>'kodepos_pabrik','value'=>$value3['kodepos']])@endcomponent
									@component('components.fordetail',['label' => 'Email','name'=>'email_pabrik','value'=>$value3['email']])@endcomponent
									@if ($value['jenis'] == "Rumah Potong Hewan")
										@component('components.fordetail',['label' => 'Status RPH/U','name'=>'status_rphu','value'=>$value3['status_pabrik']])@endcomponent
									@elseif ($value['jenis'] == "Industri Pengolahan")
										@component('components.fordetail',['label' => 'Status Pabrik','name'=>'status_rphu','value'=>$value3['status_pabrik']])@endcomponent
									@endif			
									@component('components.fordetail',['label' => 'Jenis Fasilitas Poduksi','name'=>'jenis_fasilitas_produksi','value'=>$value3['jenis_fasilitas_produksi']])@endcomponent

									{{-- Pemilik Perusahaan --}}
									<div class="col-lg-6 text-center"><h4>Pemilik Perusahaan</h4></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Nama','name'=>'nama_pemilik','value'=>$value4['nama_pemilik']])@endcomponent
									@component('components.fordetail',['label' => 'Jabatan','name'=>'jabatan_pemilik','value'=>$value4['jabatan_pemilik']])@endcomponent
									@component('components.fordetail',['label' => 'Telepon','name'=>'telepon_pemilik','value'=>$value4['telepon_pemilik']])@endcomponent
									@component('components.fordetail',['label' => 'Fax','name'=>'fax_pemilik','value'=>$value4['fax_pemilik']])@endcomponent
									@component('components.fordetail',['label' => 'Email','name'=>'email_pemilik','value'=>$value4['email_pemilik']])@endcomponent

									<div class="col-lg-6 text-center"><h4>Penanggung Jawab</h4></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Nama','name'=>'nama_pj','value'=>$value4['nama_pj']])@endcomponent
									@component('components.fordetail',['label' => 'Jabatan','name'=>'jabatan_pj','value'=>$value4['jabatan_pj']])@endcomponent
									@component('components.fordetail',['label' => 'Telepon','name'=>'telepon_pj','value'=>$value4['telepon_pj']])@endcomponent
									@component('components.fordetail',['label' => 'Fax','name'=>'fax_pj','value'=>$value4['fax_pj']])@endcomponent
									@component('components.fordetail',['label' => 'Email','name'=>'email_pj','value'=>$value4['email_pj']])@endcomponent								
									

									@component('components.fordetail',['label' => 'Sertifikat Perusahaan','name'=>'sertif_perusahaan','value'=>$value['sertifikat_perusahaan']])@endcomponent
									@component('components.fordetail',['label' => 'Nomor Induk Berusaha (NIB)','name'=>'nib','value'=>$value['nib']])@endcomponent
									@if ($value['jenis'] == "Rumah Potong Hewan")
										@component('components.fordetail',['label' => 'Nomor Kontrol Veteriner','name'=>'nkv','value'=>$value['nkv']])@endcomponent
									@elseif ($value['jenis'] == "Industri Pengolahan")
										<div class="col-lg-6 text-center"><h4>Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll)</h4></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Jenis Surat','name'=>'jenis_surat','value'=>$value['jenis_surat']])@endcomponent
										@component('components.fordetail',['label' => 'Nomor Surat','name'=>'no_surat_aspeklegal','value'=>$value['no_surat']])@endcomponent
									@endif

									{{-- Data SDM --}}
									@if ($value['jenis'] == "Rumah Potong Hewan")
										<div class="col-lg-6 text-center"><h4>Data Sumber Daya Manusia</h4></div><div class="col-lg-6"></div>
									
										@php $no=1; @endphp
										@foreach($dataSDM as $index5 => $value5)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no}}</h5></div><div class="col-lg-6"></div>							
											@component('components.fordetail',['label' => 'Jenis Data SDM','name'=>'jenis_data_sdm_'.$no.'','value'=>$value5['jenis_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'Nama','name'=>'nama_sdm_'.$no.'','value'=>$value5['nama_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'No KTP','name'=>'no_ktp_sdm_'.$no.'','value'=>$value5['ktp_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'No Sertifikat','name'=>'no_sertif_sdm_'.$no.'','value'=>$value5['sertif_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'No dan Tanggal SK','name'=>'no_tglsk_sdm_'.$no.'','value'=>$value5['no_tglsk_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'No Kontrak','name'=>'no_kontrak_sdm_'.$no.'','value'=>$value5['no_kontrak_sdm']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah SDM','name'=>'jml_sdm','value'=>$no])@endcomponent
											@php $no+=1; @endphp
										@endforeach

										<div class="col-lg-6 text-center"><h4>Jumlah Produksi</h4></div><div class="col-lg-6"></div>

										@php $no2=1; @endphp
										@foreach($dataJmlProduksi as $index6 => $value6)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no2}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Jenis Hewan','name'=>'jenis_hewan_'.$no2.'','value'=>$value6['jenis_hewan']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah Produksi Perhari','name'=>'jumlah_produksi_perhari_'.$no2.'','value'=>$value6['jumlah_produksi_perhari']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah Produksi Perbulan','name'=>'jumlah_produksi_perbulan_'.$no2.'','value'=>$value6['jumlah_produksi_perbulan']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_produksi','value'=>$no2])@endcomponent
											@php $no2+=1; @endphp
										@endforeach
									@elseif ($value['jenis'] == "Industri Pengolahan" || $value['jenis'] == "Barang Gunaan")
										<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

										@php $no5=1; @endphp
										@foreach($dataPenyeliaHalal as $index10 => $value10)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Nama','name'=>'nama_dph_'.$no5.'','value'=>$value10['nama_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No KTP','name'=>'ktp_dph_'.$no5.'','value'=>$value10['ktp_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Sertifikat','name'=>'sertif_dph_'.$no5.'','value'=>$value10['sertif_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No dan Tanggal SK','name'=>'no_tglsk_dph_'.$no5.'','value'=>$value10['no_tglsk_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Kontrak','name'=>'no_kontrak_dph_'.$no5.'','value'=>$value10['no_kontrak_dph']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_dph','value'=>$no5])@endcomponent
											@php $no5+=1; @endphp
										@endforeach

										<div class="col-lg-6 text-center"><h4>Data Produk</h4></div><div class="col-lg-6"></div>
										@php $no6=1; @endphp

										@foreach($dataProduk as $index11 => $value11)
										@component('components.fordetail',['label' => 'Klasifikasi Jenis Produk','name'=>'klasifikasi_jenis_produk','value'=>$value11['klasifikasi_jenis_produk']])@endcomponent
										@component('components.fordetail',['label' => 'Area Pemasaran','name'=>'area_pemasaran','value'=>$value11['area_pemasaran']])@endcomponent
										@component('components.fordetail',['label' => 'Izin Edar','name'=>'izin_edar','value'=>$value11['izin_edar']])@endcomponent
										@component('components.fordetail',['label' => 'Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):','name'=>'produk_lain','value'=>$value11['produk_lain']])@endcomponent										
										@endforeach

										@foreach($detailDataProduk as $index12 => $value12)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no6}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Merk/Brand','name'=>'merk_'.$no6.'','value'=>$value12['merk']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_detail_produk','value'=>$no6])@endcomponent
											@php $no6+=1; @endphp
										@endforeach
									@elseif ($value['jenis'] == "Restoran / Katering")
										<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

										@php $no5=1; @endphp
										@foreach($dataPenyeliaHalal as $index10 => $value10)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Nama','name'=>'nama_dph_'.$no5.'','value'=>$value10['nama_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No KTP','name'=>'ktp_dph_'.$no5.'','value'=>$value10['ktp_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Sertifikat','name'=>'sertif_dph_'.$no5.'','value'=>$value10['sertif_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No dan Tanggal SK','name'=>'no_tglsk_dph_'.$no5.'','value'=>$value10['no_tglsk_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Kontrak','name'=>'no_kontrak_dph_'.$no5.'','value'=>$value10['no_kontrak_dph']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_dph','value'=>$no5])@endcomponent
											@php $no5+=1; @endphp
										@endforeach

										<div class="col-lg-6 text-center"><h4>Kelompok Usaha</h4></div><div class="col-lg-6"></div>
										@foreach($dataKelompokUsaha as $index13 => $value13)
											@component('components.fordetail',['label' => 'Kelompok Usaha','name'=>'kelompok_usaha','value'=>$value13['kelompok_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Kategori Usaha','name'=>'kategori_usaha','value'=>$value13['kategori_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah Cabang Usaha','name'=>'jumlah_cabang_usaha','value'=>$value13['jumlah_cabang_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Alamat Cabang Usaha','name'=>'alamat_cabang_usaha','value'=>$value13['alamat_cabang_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Area Pemasaran Usaha','name'=>'area_pemasaran_usaha','value'=>$value13['area_pemasaran_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Izin Edar Usaha','name'=>'izin_edar_usaha','value'=>$value13['izin_edar_usaha']])@endcomponent
											@component('components.fordetail',['label' => 'Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):','name'=>'produklain_usaha','value'=>$value13['produk_lain_usaha']])@endcomponent
										@endforeach

										@php $no7=1; @endphp
										@foreach($detailRegisKelompok as $index14 => $value14)
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no7}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Sertifikat Lainnya','name'=>'sertif_lainnya_'.$no7.'','value'=>$value14['sertifikat_lainnya']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_detail_regis_kel','value'=>$no7])@endcomponent
											@php $no7+=1; @endphp
										@endforeach
									@elseif ($value['jenis'] == "Jasa")
										<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

										@php $no5=1; @endphp
										@foreach($dataPenyeliaHalal as $index10 => $value10)											
											<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
											@component('components.fordetail',['label' => 'Nama','name'=>'nama_dph_'.$no5.'','value'=>$value10['nama_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No KTP','name'=>'ktp_dph_'.$no5.'','value'=>$value10['ktp_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Sertifikat','name'=>'sertif_dph_'.$no5.'','value'=>$value10['sertif_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No dan Tanggal SK','name'=>'no_tglsk_dph_'.$no5.'','value'=>$value10['no_tglsk_dph']])@endcomponent
											@component('components.fordetail',['label' => 'No Kontrak','name'=>'no_kontrak_dph_'.$no5.'','value'=>$value10['no_kontrak_dph']])@endcomponent
											@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_dph','value'=>$no5])@endcomponent
											@php $no5+=1; @endphp
										@endforeach

										<div class="col-lg-6 text-center"><h4>Jasa</h4></div><div class="col-lg-6"></div>

										@foreach($dataJasa as $index11 => $value11)										
											@component('components.fordetail',['label' => 'Klasifikasi Jenis Jasa','name'=>'klasifikasi_jenis_jasa','value'=>$value11['klasifikasi_jenis_jasa']])@endcomponent
											@component('components.fordetail',['label' => 'Area Pemasaran Jasa','name'=>'area_pemasaran_jasa','value'=>$value11['area_pemasaran_jasa']])@endcomponent
											@component('components.fordetail',['label' => 'Produk Lain Jasa','name'=>'produk_lain_jasa','value'=>$value11['produk_lain_jasa']])@endcomponent
										@endforeach

									@endif

									{{-- Data DSM --}}
									@php $no3=1; @endphp
									<div class="col-lg-6 text-center"><h4>Data Sistem Manajemen</h4></div><div class="col-lg-6"></div>
									@foreach($detailDSM as $index8 => $value8)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no3}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Sistem manajemen perusahaan yang relevan','name'=>'sistem_manajemen_'.$no3.'','value'=>$value8['sistem_manajemen']])@endcomponent
										@component('components.fordetail',['label' => 'Sertifikasi','name'=>'sertifikasi_manajemen_'.$no3.'','value'=>$value8['sertifikasi_manajemen']])@endcomponent
										@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_dsm','value'=>$no3])@endcomponent
										@php $no3+=1; @endphp
									@endforeach

									@component('components.fordetail',['label' => 'Proses yang di subkontrakkan (outsourcing), jika ada :','name'=>'outsourcing','value'=>$value7['outsourcing']])@endcomponent
									@component('components.fordetail',['label' => 'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :','name'=>'konsultan','value'=>$value7['konsultan']])@endcomponent
									@component('components.fordetail',['label' => 'Total jumlah karyawan dalam organisasi :','name'=>'jumlah_karyawan_organisasi','value'=>$value7['jumlah_karyawan_organisasi']])@endcomponent
									<div class="col-lg-6 text-center"><h6>Jumlah karyawan (penuh waktu) dalam lingkup sertifikasi</h6></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Shift 1','name'=>'shift1','value'=>$value7['shift_1']])@endcomponent
									@component('components.fordetail',['label' => 'Shift 2','name'=>'shift2','value'=>$value7['shift_2']])@endcomponent
									@component('components.fordetail',['label' => 'Shift 3','name'=>'shift3','value'=>$value7['shift_3']])@endcomponent

									{{-- Data Lokasi Lain --}}
									<div class="col-lg-6 text-center"><h4>Data Lokasi Lainnya</h4></div><div class="col-lg-6"></div>
									@php $no4=1; @endphp
									@foreach($dataLokasiLain as $index9 => $value9)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no4}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Nama Lokasi','name'=>'nama_lokasi_lainnya_'.$no4.'','value'=>$value9['nama_lokasi_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Alamat','name'=>'alamat_lainnya_'.$no4.'','value'=>$value9['alamat_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Kota','name'=>'kota_lainnya_'.$no4.'','value'=>$value9['kota_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Telepon','name'=>'telepon_lainnya_'.$no4.'','value'=>$value9['telepon_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Kode Pos','name'=>'kodepos_lainnya_'.$no4.'','value'=>$value9['kodepos_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Fax','name'=>'fax_lainnya_'.$no4.'','value'=>$value9['fax_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Narahubung','name'=>'narahubung_lainnya_'.$no4.'','value'=>$value9['narahubung_lainnya']])@endcomponent
										@component('components.fordetail',['label' => 'Jumlah','name'=>'jml_lokasilain','value'=>$no4])@endcomponent
										@php $no4+=1; @endphp
									@endforeach																																												
							</div>
							<div class="col-md-12 offset-md-5 mb-5">
								@if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
									<button type="submit" class="btn bnt-sm btn-primary">Download Data</button>
									{{-- <a href="{{route('exportdata')}}" class="btn bnt-sm btn-primary">Download Data</a> --}}
								@else
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
									<button type="submit" class="btn bnt-sm btn-primary">Download Data</button>
								@endif	
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