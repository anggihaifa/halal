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

                                @component('components.fordetail',['label' => 'No. Surat Permohonan Sertifikasi','value'=>$value['no_surat']])@endcomponent
                                @component('components.fordetail',['label' => 'No. Registrasi','value'=>$value['no_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Nama','value'=>$value['name']])@endcomponent
                                @component('components.fordetail',['label' => 'Perusahaan','value'=>$value['nama_perusahaan']])@endcomponent
                                @component('components.fordetail',['label' => 'Tanggal Registrasi','value'=>$value['tgl_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Registrasi','value'=>$value['jenis']])@endcomponent
                                @component('components.fordetail',['label' => 'Status Registrasi','value'=>ucwords($value['status_registrasi'])])@endcomponent
                                @component('components.fordetail',['label' => 'Status Halal Sebelumnya','value'=>$sh])@endcomponent
                                @component('components.fordetail',['label' => 'SH Berlaku s/d','value'=>$shb])@endcomponent
                                <!-- @component('components.fordetail',['label' => 'Status SJPH','value'=>$value['no_surat']])@endcomponent -->
                                @component('components.fordetail',['label' => 'No Sertifikat SJPH','value'=>$value['no_sertifikat']])@endcomponent
                                @component('components.fordetail',['label' => 'SJPH Berlaku s/d','value'=>$value['tgl_sjph']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Produk','value'=>$value['jenis_produk']])@endcomponent

								@if ($value['jenis'] == "Rumah Potong Hewan")
									@component('components.fordetail',['label' => 'Status Unit Usaha','value'=>$value['jenis_badan_usaha']])@endcomponent
									@component('components.fordetail',['label' => 'Jenis Usaha','value'=>$value['jenis_usaha']])@endcomponent
								@elseif ($value['jenis'] == "Industri Pengolahan")
									@component('components.fordetail',['label' => 'Jenis Badan Usaha','value'=>$value['jenis_badan_usaha']])@endcomponent
								@endif
								
								@component('components.fordetail',['label' => 'Kepemilikan','value'=>$value['kepemilikan']])@endcomponent

                                @component('components.fordetail',['label' => 'Skala Usaha','value'=>ucwords($value['skala_usaha'])])@endcomponent
                                @component('components.fordetail',['label' => 'No. KTP/NPWP','value'=>$value['no_tipe']])@endcomponent
                                @component('components.fordetail',['label' => 'Jenis Izin Usaha','value'=>$value['jenis_izin']])@endcomponent
                                @component('components.fordetail',['label' => 'Jumlah Karyawan','value'=>$value['jumlah_karyawan']])@endcomponent
                                @component('components.fordetail',['label' => 'Kapasitas Produk','value'=>$value['kapasitas_produksi']])@endcomponent
                                @component('components.fordetail',['label' => 'Kelompok Produk','value'=>$value['kelompok']])@endcomponent
								
								{{-- Alamat Kantor --}}
								@if ($value['jenis'] == "Rumah Potong Hewan")									
									<div class="col-lg-6 text-center"><h4>Alamat Utama</h4></div><div class="col-lg-6"></div>
								@elseif ($value['jenis'] == "Industri Pengolahan")
									<div class="col-lg-6 text-center"><h4>Alamat Kantor</h4></div><div class="col-lg-6"></div>
								@endif
								
								@component('components.fordetail',['label' => 'Kota','value'=>$value2['kota']])@endcomponent
								@component('components.fordetail',['label' => 'Provinsi','value'=>$value2['provinsi']])@endcomponent
								@component('components.fordetail',['label' => 'Negara','value'=>$value2['negara']])@endcomponent
								@component('components.fordetail',['label' => 'Telepon','value'=>$value2['telepon']])@endcomponent
								@component('components.fordetail',['label' => 'Kode Pos','value'=>$value2['kodepos']])@endcomponent
								@component('components.fordetail',['label' => 'Email','value'=>$value2['email']])@endcomponent

								{{-- Alamat Pabrik --}}
								@if ($value['jenis'] == "Rumah Potong Hewan")									
									<div class="col-lg-6 text-center"><h4>Alamat RPH/U Lainnya</h4></div><div class="col-lg-6"></div>
								@elseif ($value['jenis'] == "Industri Pengolahan")
									<div class="col-lg-6 text-center"><h4>Alamat Pabrik</h4></div><div class="col-lg-6"></div>
								@endif

								@component('components.fordetail',['label' => 'Alamat','value'=>$value3['alamat']])@endcomponent
								@component('components.fordetail',['label' => 'Kota','value'=>$value3['kota']])@endcomponent
								@component('components.fordetail',['label' => 'Provinsi','value'=>$value3['provinsi']])@endcomponent
								@component('components.fordetail',['label' => 'Negara','value'=>$value3['negara']])@endcomponent
								@component('components.fordetail',['label' => 'Telepon','value'=>$value3['telepon']])@endcomponent
								@component('components.fordetail',['label' => 'Kode Pos','value'=>$value3['kodepos']])@endcomponent
								@component('components.fordetail',['label' => 'Email','value'=>$value3['email']])@endcomponent
								@if ($value['jenis'] == "Rumah Potong Hewan")
									@component('components.fordetail',['label' => 'Status RPH/U','value'=>$value3['status_pabrik']])@endcomponent
								@elseif ($value['jenis'] == "Industri Pengolahan")
									@component('components.fordetail',['label' => 'Status Pabrik','value'=>$value3['status_pabrik']])@endcomponent
								@endif			
								@component('components.fordetail',['label' => 'Jenis Fasilitas Poduksi','value'=>$value3['jenis_fasilitas_produksi']])@endcomponent

								{{-- Pemilik Perusahaan --}}
								<div class="col-lg-6 text-center"><h4>Pemilik Perusahaan</h4></div><div class="col-lg-6"></div>
								@component('components.fordetail',['label' => 'Nama','value'=>$value4['nama_pemilik']])@endcomponent
								@component('components.fordetail',['label' => 'Jabatan','value'=>$value4['jabatan_pemilik']])@endcomponent
								@component('components.fordetail',['label' => 'Telepon','value'=>$value4['telepon_pemilik']])@endcomponent
								@component('components.fordetail',['label' => 'Fax','value'=>$value4['fax_pemilik']])@endcomponent
								@component('components.fordetail',['label' => 'Email','value'=>$value4['email_pemilik']])@endcomponent

								<div class="col-lg-6 text-center"><h4>Penanggung Jawab</h4></div><div class="col-lg-6"></div>
								@component('components.fordetail',['label' => 'Nama','value'=>$value4['nama_pj']])@endcomponent
								@component('components.fordetail',['label' => 'Jabatan','value'=>$value4['jabatan_pj']])@endcomponent
								@component('components.fordetail',['label' => 'Telepon','value'=>$value4['telepon_pj']])@endcomponent
								@component('components.fordetail',['label' => 'Email','value'=>$value4['email_pj']])@endcomponent								
								

								@component('components.fordetail',['label' => 'Sertifikat Perusahaan','value'=>$value['sertifikat_perusahaan']])@endcomponent
								@component('components.fordetail',['label' => 'Nomor Induk Berusaha (NIB)','value'=>$value['nib']])@endcomponent
								@if ($value['jenis'] == "Rumah Potong Hewan")
									@component('components.fordetail',['label' => 'Nomor Kontrol Veteriner','value'=>$value['nkv']])@endcomponent
								@elseif ($value['jenis'] == "Industri Pengolahan")
									<div class="col-lg-6 text-center"><h4>Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll)</h4></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Jenis Surat','value'=>$value['jenis_surat']])@endcomponent
									@component('components.fordetail',['label' => 'Nomor Surat','value'=>$value['no_surat']])@endcomponent
								@endif

								{{-- Data SDM --}}
								@if ($value['jenis'] == "Rumah Potong Hewan")
									<div class="col-lg-6 text-center"><h4>Data Sumber Daya Manusia</h4></div><div class="col-lg-6"></div>
								
									@php $no=1; @endphp
									@foreach($dataSDM as $index5 => $value5)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no}}</h5></div><div class="col-lg-6"></div>							
										@component('components.fordetail',['label' => 'Jenis Data SDM','value'=>$value5['jenis_sdm']])@endcomponent
										@component('components.fordetail',['label' => 'Nama','value'=>$value5['nama_sdm']])@endcomponent
										@component('components.fordetail',['label' => 'No KTP','value'=>$value5['ktp_sdm']])@endcomponent
										@component('components.fordetail',['label' => 'No Sertifikat','value'=>$value5['sertif_sdm']])@endcomponent
										@component('components.fordetail',['label' => 'No dan Tanggal SK','value'=>$value5['no_tglsk_sdm']])@endcomponent
										@component('components.fordetail',['label' => 'No Kontrak','value'=>$value5['no_kontrak_sdm']])@endcomponent
										@php $no+=1; @endphp
									@endforeach

									<div class="col-lg-6 text-center"><h4>Jumlah Produksi</h4></div><div class="col-lg-6"></div>

									@php $no2=1; @endphp
									@foreach($dataJmlProduksi as $index6 => $value6)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no2}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Jenis Hewan','value'=>$value6['jenis_hewan']])@endcomponent
										@component('components.fordetail',['label' => 'Jumlah Produksi Perhari','value'=>$value6['jumlah_produksi_perhari']])@endcomponent
										@component('components.fordetail',['label' => 'Jumlah Produksi Perbulan','value'=>$value6['jumlah_produksi_perbulan']])@endcomponent
										@php $no2+=1; @endphp
									@endforeach
								@elseif ($value['jenis'] == "Industri Pengolahan" || $value['jenis'] == "Barang Gunaan")
									<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

									@php $no5=1; @endphp
									@foreach($dataPenyeliaHalal as $index10 => $value10)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Nama','value'=>$value10['nama_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No KTP','value'=>$value10['ktp_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Sertifikat','value'=>$value10['sertif_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No dan Tanggal SK','value'=>$value10['no_tglsk_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Kontrak','value'=>$value10['no_kontrak_dph']])@endcomponent
										@php $no5+=1; @endphp
									@endforeach

									<div class="col-lg-6 text-center"><h4>Data Produk</h4></div><div class="col-lg-6"></div>
									@php $no6=1; @endphp

									@foreach($dataProduk as $index11 => $value11)
									@component('components.fordetail',['label' => 'Klasifikasi Jenis Produk','value'=>$value11['klasifikasi_jenis_produk']])@endcomponent
									@component('components.fordetail',['label' => 'Area Pemasaran','value'=>$value11['area_pemasaran']])@endcomponent
									@component('components.fordetail',['label' => 'Izin Edar','value'=>$value11['izin_edar']])@endcomponent
									@component('components.fordetail',['label' => 'Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):','value'=>$value11['produk_lain']])@endcomponent
									@endforeach

									@foreach($detailDataProduk as $index12 => $value12)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no6}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Merk/Brand','value'=>$value12['merk']])@endcomponent
										@php $no6+=1; @endphp
									@endforeach
								@elseif ($value['jenis'] == "Restoran / Katering")
									<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

									@php $no5=1; @endphp
									@foreach($dataPenyeliaHalal as $index10 => $value10)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Nama','value'=>$value10['nama_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No KTP','value'=>$value10['ktp_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Sertifikat','value'=>$value10['sertif_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No dan Tanggal SK','value'=>$value10['no_tglsk_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Kontrak','value'=>$value10['no_kontrak_dph']])@endcomponent
										@php $no5+=1; @endphp
									@endforeach

									<div class="col-lg-6 text-center"><h4>Kelompok Usaha</h4></div><div class="col-lg-6"></div>
									@foreach($dataKelompokUsaha as $index13 => $value13)
										@component('components.fordetail',['label' => 'Kelompok Usaha','value'=>$value13['kelompok_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Kategori Usaha','value'=>$value13['kategori_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Jumlah Cabang Usaha','value'=>$value13['jumlah_cabang_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Alamat Cabang Usaha','value'=>$value13['alamat_cabang_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Area Pemasaran Usaha','value'=>$value13['area_pemasaran_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Izin Edar Usaha','value'=>$value13['izin_edar_usaha']])@endcomponent
										@component('components.fordetail',['label' => 'Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):','value'=>$value13['produk_lain_usaha']])@endcomponent
									@endforeach

									@php $no7=1; @endphp
									@foreach($detailRegisKelompok as $index14 => $value14)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no7}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Sertifikat Lainnya','value'=>$value14['sertifikat_lainnya']])@endcomponent
										@php $no7+=1; @endphp
									@endforeach
								@elseif ($value['jenis'] == "Jasa")
									<div class="col-lg-6 text-center"><h4>Data Penyelia Halal</h4></div><div class="col-lg-6"></div>

									@php $no5=1; @endphp
									@foreach($dataPenyeliaHalal as $index10 => $value10)
										<div class="col-lg-6 text-center"><h5>Data Ke-{{$no5}}</h5></div><div class="col-lg-6"></div>
										@component('components.fordetail',['label' => 'Nama','value'=>$value10['nama_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No KTP','value'=>$value10['ktp_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Sertifikat','value'=>$value10['sertif_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No dan Tanggal SK','value'=>$value10['no_tglsk_dph']])@endcomponent
										@component('components.fordetail',['label' => 'No Kontrak','value'=>$value10['no_kontrak_dph']])@endcomponent
										@php $no5+=1; @endphp
									@endforeach

									<div class="col-lg-6 text-center"><h4>Jasa</h4></div><div class="col-lg-6"></div>

									@foreach($dataJasa as $index11 => $value11)										
										@component('components.fordetail',['label' => 'Klasifikasi Jenis Jasa','value'=>$value11['klasifikasi_jenis_jasa']])@endcomponent
										@component('components.fordetail',['label' => 'Area Pemasaran Jasa','value'=>$value11['area_pemasaran_jasa']])@endcomponent
										@component('components.fordetail',['label' => 'Produk Lain Jasa','value'=>$value11['produk_lain_jasa']])@endcomponent
									@endforeach

								@endif

								{{-- Data DSM --}}
								@php $no3=1; @endphp
								<div class="col-lg-6 text-center"><h4>Data Sistem Manajemen</h4></div><div class="col-lg-6"></div>
								@foreach($detailDSM as $index8 => $value8)
									<div class="col-lg-6 text-center"><h5>Data Ke-{{$no3}}</h5></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Sistem manajemen perusahaan yang relevan','value'=>$value8['sistem_manajemen']])@endcomponent
									@component('components.fordetail',['label' => 'Sertifikasi','value'=>$value8['sertifikasi_manajemen']])@endcomponent
									@php $no3+=1; @endphp
								@endforeach

								@component('components.fordetail',['label' => 'Proses yang di subkontrakkan (outsourcing), jika ada :','value'=>$value7['outsourcing']])@endcomponent
								@component('components.fordetail',['label' => 'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :','value'=>$value7['konsultan']])@endcomponent
								@component('components.fordetail',['label' => 'Total jumlah karyawan dalam organisasi :','value'=>$value7['jumlah_karyawan_organisasi']])@endcomponent
								<div class="col-lg-6 text-center"><h6>Jumlah karyawan (penuh waktu) dalam lingkup sertifikasi</h6></div><div class="col-lg-6"></div>								
								@component('components.fordetail',['label' => 'Shift 1','value'=>$value7['shift_1']])@endcomponent
								@component('components.fordetail',['label' => 'Shift 2','value'=>$value7['shift_2']])@endcomponent
								@component('components.fordetail',['label' => 'Shift 3','value'=>$value7['shift_3']])@endcomponent

								{{-- Data Lokasi Lain --}}
								<div class="col-lg-6 text-center"><h4>Data Lokasi Lainnya</h4></div><div class="col-lg-6"></div>
								@php $no4=1; @endphp
								@foreach($dataLokasiLain as $index9 => $value9)
									<div class="col-lg-6 text-center"><h5>Data Ke-{{$no4}}</h5></div><div class="col-lg-6"></div>
									@component('components.fordetail',['label' => 'Nama Lokasi','value'=>$value9['nama_lokasi_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Alamat','value'=>$value9['alamat_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Kota','value'=>$value9['kota_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Telepon','value'=>$value9['telepon_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Kode Pos','value'=>$value9['kodepos_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Fax','value'=>$value9['fax_lainnya']])@endcomponent
									@component('components.fordetail',['label' => 'Narahubung','value'=>$value9['narahubung_lainnya']])@endcomponent
									@php $no4+=1; @endphp
								@endforeach
								
                                
                                <!-- @component('components.fordetail',['label' => 'Biaya Registrasi','value'=>$value['biaya_registrasi']])@endcomponent
                                @component('components.fordetail',['label' => 'Metode Pembayaran','value'=>ucwords($value['metode_pembayaran'])])@endcomponent
                                
                                <label class="col-lg-4 col-form-label ">Invoice Registrasi</label>
								<div id="sh" class="col-lg-8">
										<div class="form-control" readonly>
											<a href="{{url('') .Storage::url('public/registrasi/'.$value['inv_registrasi']) }}" download>{{$value['inv_registrasi']}}</a>
										</div>
								</div>

                                @if($value['status_pembayaran'] == '1' || $value['status_pembayaran'] == '2' )
									<label class="col-lg-4 col-form-label">Bukti Pembayaran</label>
									<div id="sh" class="col-lg-8">
										<div class="form-control" readonly>
											<a href="{{url('') .Storage::url('public/buktipembayaran/'.Auth::user()->id.'/'.$value['bukti_pembayaran']) }}" download>{{$value['bukti_pembayaran']}}</a>
										</div>
									</div>
								@endif
								<label class="col-lg-4 col-form-label">Status Pembayaran</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										@if($value['status_pembayaran'] == 2)
											<span style="color: green;">Sudah Dikonfirmasi</span>
										@elseif($value['status_pembayaran'] == 1)
											<span style="color: orange;">Menunggu Konfirmasi</span>
										@else
											<span style="color: red;">Belum Bayar</span>
										@endif
									</div>
								</div>

								@if($value['inv_pembayaran'] == null)
									<label class="col-lg-4 col-form-label">Invoice Pembayaran</label>
									<div id="sh" class="col-lg-8">
											<div class="form-control" readonly>
												-
											</div>
									</div>
								@else
									<label class="col-lg-4 col-form-label">Invoice Pembayaran</label>
									<div id="sh" class="col-lg-8">
											<div class="form-control" readonly>
												<a href="{{url('') .Storage::url('public/pembayaran/'.$value['inv_pembayaran']) }}" download>{{$value['inv_pembayaran']}}</a>
											</div>
									</div>
								@endif -->
								
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

    

@endpush