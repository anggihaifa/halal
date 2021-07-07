@extends('layouts.default', ['boxedLayout' => false], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Unggah Data Sertifikasi')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" />
@endpush

@push('css')
	<link href="{{asset('/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item active">Unggah Data Sertifikasi</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Unggah Data Sertifikasi<small></small></h1>
	<!-- end page-header -->
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
			<h4 class="panel-title">Unggah Data Sertifikasi</h4>
			<div class="panel-heading-btn">
				<a href="#" class="btn btn-xs btn-default btn-default active"></i>Aktif: Reg No. {{$data->no_registrasi}}</a>
				<a href="#" class="btn btn-xs btn-default btn-default active"></i>Jenis: {{$data->jenis}}</a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
		</div>
		<!-- end panel-heading -->
		<!-- begin panel-body -->
		<div class="panel-body ">

			
				<div class="card-body table-responsive-lg ">
					<div class="tab-content p-0 m-0">
						<div class="tab-pane fade active show" id="card-tab-1">

							@if($dataHas !== null)								
								<div class="col-md-12 mx-0 step widget widget-stats animated zoomIn">
									<form id="msform">	
										<ul id="progressbar_verifikasi">												
											@foreach($dataHas as $has => $value)
													@php
														$status_temp = $value['status_berkas'];
														$status = 'a'.'_'.$status_temp;
													@endphp
													@if ($status == 'a_0')
														<li id="account" class="confirming"><strong>Dokumen Belum Lengkap</strong></li>
													@else
														<li id="account" class="confirming"><strong>Sudah Upload Berkas</strong></li>
													@endif													

													@if ($status == 'a_1')
														<li id="account" class="waiting"><strong>Menunggu Admin Verifikasi Berkas</strong></li>
													@elseif ($status == 'a_0')
														<li id="account"><strong>Menunggu Admin Verifikasi Berkas</strong></li>
													@else
														<li id="account" class="confirming"><strong>Admin Verifikasi Berkas</strong></li>
													@endif

													@if ($status == 'a_2')
														<li id="account" class="fixing"><strong>Perbaikan Berkas</strong></li>
													@elseif ($status == 'a_0')
														<li id="account"><strong>Perbaikan Berkas</strong></li>
													@elseif ($status == 'a_1')
														<li id="account"><strong>Perbaikan Berkas</strong></li>
													@else
														<li id="account" class="confirming"><strong>Berkas Telah Diperbaiki</strong></li>
													@endif

													@if ($status == 'a_3')
														<li id="account" class="confirming"><strong>Berkas Terverifikasi</strong></li>
													@elseif ($status == 'a_0')
														<li id="account"><strong>Berkas Terverifikasi</strong></li>
													@elseif ($status == 'a_1')
														<li id="account"><strong>Berkas Terverifikasi</strong></li>
													@elseif ($status == 'a_2')
														<li id="account"><strong>Berkas Terverifikasi</strong></li>
													@else
														<li id="account" class="confirming"><strong>Berkas Terverifikasi</strong></li>
													@endif
											@endforeach												
										</ul>
									</form>
								</div>
							@else
								<div class="col-md-12 mx-0 step widget widget-stats animated zoomIn">
									<form id="msform">	
										<ul id="progressbar_verifikasi">
											<li id="account" class="notyet"><strong>Belum Upload Berkas</strong></li>
											<li id="account"><strong>Menunggu Admin Verifikasi Berkas</strong></li>
											<li id="account"><strong>Perbaikan Berkas</strong></li>
											<li id="account"><strong>Berkas Terverifikasi</strong></li>
										</ul>
									</form>
								</div>
							@endif							

							@php

								$regId = Auth::user()->registrasi_id;
								$fieldSudah = '<td class="  valign-middle text-center" style="border:none"><i class="fa fa-check" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="  valign-middle text-center" style="border:none"><i class="fa fa-times" style="color:red"></i></td>';
								
								$buttonUnduhDisabled = '<td class="valign-middle text-center"><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>';
								$buttonUnduh = '<td class="valign-middle text-center"><a href="#" class="btn btn-primary btn-xs">unduh</a></td>';
								

							@endphp
							@if($dataHas !== null)
								@foreach($dataHas as $has => $value)
									@if($value['status_has'] == 1)
										<h5>Dokumen Lengkap</h5>
									@else
										<h5>Dokumen Belum Lengkap</h5>
									@endif 
								@endforeach
							@else
								<h5>Dokumen Belum Lengkap</h5>	
							@endif
							<div class="infoDokumen">

								
								<span style="margin-right: 5px; "><i class="fa fa-check" style="color:#2fca2f"></i> Sudah diunggah</span>
								<span style="margin-right: 5px; "><i class="fa fa-times" style="color:red"></i> Belum diunggah</span>
								<h6></h6>
								<h5 style="color:#ff6961">NOTE: Ukuran Maksimal File 2MB. Silahkan Upload File Satu Persatu</h5>

								
								
								
							</div>
							<form action="{{route('storedokumensertifikasi')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<input type="text" id="has_selected" name="has_selected" hidden value="tes">
								<table id="hasTable"  class="table  table-bordered table-td-valign-middle table-sm" cellspacing="0" >
									<thead>
										<tr>
											<th width="1%" class="  valign-middle text-center">No</th>
											<th width="70%" class=" valign-middle text-center">Nama Dokumen</th>
											<th style="width:200px!important;  text-overflow: ellipsis; white-space: nowrap;  overflow: hidden;"  class="  valign-middle text-center">File</th>
											@if($dataHas !== null)
											<th width="1%" class="  valign-middle text-center">Status</th>
											@endif
										
											<th width="30%" class="  valign-middle text-center">Temuan</th>
											<th width="30%" class="  valign-middle text-center">Review Tambahan/ Perbaikan  Dokumen</th>

											
											
										</tr>
									</thead>
									<tbody>
										
									@if($dataHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="  valign-middle text-center">1</td>
											<td class="">Manual Sistem Jaminan Produk Halal (SJPH)</td>
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
															<input type="file" id="has_1" name="has_1" onchange="getValue('has_1')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_1')" ><i class="fa fa-upload"></i><br>Upload</button>
														
														
														</td>
														
														
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
													
												</table>
												
											</td>
											
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											
											

										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">2</td>
											<td class=" valign-middle">Matriks Bahan</td>
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_2" name="has_2" onchange="getValue('has_2')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_2')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>

										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">3</td>
											<td class=" valign-middle">Data Produk Yang Dihasilkan</td>
											
										
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_3" name="has_3" onchange="getValue('has_3')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_3')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">4</td>
											<td class="  valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_4" name="has_4" onchange="getValue('has_4')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td >
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_4')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">5</td>
											<td class=" valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_5" name="has_5" onchange="getValue('has_5')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_5')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										<tr class="even">
											<td class="  valign-middle text-center">6</td>
											<td class=" valign-middle">Sertifikat Halal Sebelumnya (Jika Ada)</td>
										
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_6" name="has_6" onchange="getValue('has_6')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_6')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">7</td>
											<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
										
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_7" name="has_7" onchange="getValue('has_7')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_7')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										<tr class="even">
											<td class="  valign-middle text-center">8</td>
											<td class=" valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_8" name="has_8" onchange="getValue('has_8')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_8')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">9</td>
											<td class=" valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
										
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_9" name="has_9" onchange="getValue('has_9')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_9')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">10</td>
											<td class=" valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya.</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_10" name="has_10" onchange="getValue('has_10')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_10')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">11</td>
											<td class=" valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)*Dilampirkan Aspek Legal Perusahaan
											</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_11" name="has_11" onchange="getValue('has_11')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_11')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">12</td>
											<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_12" name="has_12" onchange="getValue('has_12')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_12')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">13</td>
											<td class="valign-middle">Bukti Sertifikat Penyelia Halal</td>
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_13" name="has_13" onchange="getValue('has_13')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_13')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">14</td>
											<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_14" name="has_14" onchange="getValue('has_14')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_14')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
														{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">15</td>
											<td class="valign-middle">Bukti Pelaksanaan Audit Internal</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_15" name="has_15" onchange="getValue('has_15')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_15')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">16</td>
											<td class="valign-middle">Bukti Kaji Ulang Manajemen</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_16" name="has_16" onchange="getValue('has_16')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_16')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">17</td>
											<td class="valign-middle">Informasi Denah Lokasi Produksi</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_17" name="has_17" onchange="getValue('has_17')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_17')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">18</td>
											<td class="valign-middle">BBukti Registrasi Dari BPJPH</td>
											
											
											<td class="valign-middle text-center">
												<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
													<tr style="border:none">
														<td style="border:none">
														<input type="file" id="has_18" name="has_18" onchange="getValue('has_18')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
														
														</td>
														<td style="border:none">
															<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_18')" ><i class="fa fa-upload"></i><br>Upload</button>
														</td>
													</tr>
													<tr style="border:none">
														<td style="border:none">
														
															{!! $fieldBelum !!}
														
														</td>
														
													</tr>
												</table>
												
											</td>
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
										</tr>
										
									@else
										@foreach($dataHas as $has => $value)
											<input type="text" name="status" value="1" readonly hidden>
											<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
											<tr class="odd">
												<td id="no_has1" class="valign-middle text-center">1</td>
												<td class=" valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_1" name="has_1" onchange="getValue('has_1')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_1')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_1'] !== null)
															
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_1')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																
																{!! $fieldSudah !!}
															@else
															
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_1']])@endcomponent

												@if($value['has_1'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_1']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_1']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_1']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_1']}}
													</td>
												@endif
											
											</tr>
											
											<tr class="even">
												<td id="no_has2" class="valign-middle text-center">2</td>
												<td class=" valign-middle">Matriks Bahan</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_2" name="has_2" onchange="getValue('has_2')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_2')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_2'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_2')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_2']])@endcomponent

												@if($value['has_2'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_2']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_2']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_2']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_2']}}
													</td>
												@endif
											</tr>
											
											<tr class="odd">
												<td id="no_has3" class="  valign-middle text-center">3</td>
												<td class="valign-middle">Data Produk Yang Dihasilkan</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_3" name="has_3" onchange="getValue('has_3')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_3')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_3'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_3')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_3']])@endcomponent

												@if($value['has_3'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_3']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_3']}}
													</td>
												
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_3']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_3']}}
													</td>
												@endif
											</tr>
											<tr class="even">
												<td id="no_has4" class="  valign-middle text-center">4</td>
												<td class="  valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_4" name="has_4" onchange="getValue('has_4')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_4')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_4'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_4')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_4']])@endcomponent

												@if($value['has_4'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_4']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_4']}}
													</td>
												
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_4']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_4']}}
													</td>
												@endif
											</tr>
											
											<tr class="odd">
												<td id="no_has5" class="  valign-middle text-center">5</td>
												<td class=" valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_5" name="has_5" onchange="getValue('has_5')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_5')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_5'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_5')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_5']])@endcomponent

												@if($value['has_5'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_5']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_5']}}
													</td>
												
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_5']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_5']}}
													</td>
												@endif
											</tr>
											
											<tr class="even">
												<td id="no_has6" class="  valign-middle text-center">6</td>
												<td class=" valign-middle">Sertifikat Halal Sebelumnya</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_6" name="has_6" onchange="getValue('has_6')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_6')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_6'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_6')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_6']])@endcomponent

												@if($value['has_6'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_6']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_6']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_6']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_6']}}
													</td>
												@endif
											</tr>
											
											<tr class="odd">
												<td id="no_has7" class="  valign-middle text-center">7</td>
												<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_7" name="has_7" onchange="getValue('has_7')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_7')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_7'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_7')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_7']])@endcomponent

												@if($value['has_7'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_7']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_7']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_7']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_7']}}
													</td>
												@endif
											</tr>
											
											<tr class="even">
												<td id="no_has8" class="  valign-middle text-center">8</td>
												<td class=" valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_8" name="has_8" onchange="getValue('has_8')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_8')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_8'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_8')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_8']])@endcomponent

												@if($value['has_8'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_8']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_8']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_8']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_8']}}
													</td>
												@endif
											</tr>
											
											<tr class="odd">
												<td id="no_has9" class="  valign-middle text-center">9</td>
												<td class=" valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_9" name="has_9" onchange="getValue('has_9')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_9')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_9'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_9')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_9']])@endcomponent

												@if($value['has_9'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_9']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_9']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_9']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_9']}}
													</td>
												@endif
											</tr>
											
											<tr class="even">
												<td id="no_has10" class="  valign-middle text-center">10</td>
												<td class=" valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya.</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
																<input type="file" id="has_10" name="has_10" onchange="getValue('has_10')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_10')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_10'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_10')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_10']])@endcomponent

												@if($value['has_10'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_10']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_10']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_10']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_10']}}
													</td>
												@endif
											</tr>
											
											<tr class="odd">
												<td id="no_has11" class="  valign-middle text-center">11</td>
												<td class=" valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)*Dilampirkan Aspek Legal Perusahaan
												</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_11" name="has_11" onchange="getValue('has_11')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_11')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_11'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_11')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_11']])@endcomponent

												@if($value['has_11'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_11']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_11']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_11']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_11']}}
													</td>
												@endif
											</tr>
											
											<tr class="even">
												<td id="no_has12" class="  valign-middle text-center">12</td>
												<td class=" valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_12" name="has_12" onchange="getValue('has_12')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_12')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_12'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_12')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_12']])@endcomponent

												@if($value['has_12'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_12']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_12']}}
													</td>
												
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_12']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_12']}}
													</td>
												@endif
											
											</tr>
											
											<tr class="even">
												<td id="no_has13" class="  valign-middle text-center">13</td>
												<td class=" valign-middle">Bukti Sertifikat Penyelia Halal</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_13" name="has_13" onchange="getValue('has_13')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_13')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_13'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_13')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_13']])@endcomponent

												@if($value['has_13'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_13']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_13']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_13']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_13']}}
													</td>
												@endif
											
											</tr>

											<tr class="even">
												<td id="no_has14" class="  valign-middle text-center">14</td>
												<td class=" valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_14" name="has_14" onchange="getValue('has_14')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_14')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_14'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_14')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_14']])@endcomponent

												@if($value['has_14'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_14']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_14']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_14']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_14']}}
													</td>
												@endif
											
											</tr>

											<tr class="even">
												<td id="no_has15" class="  valign-middle text-center">15</td>
												<td class=" valign-middle">Bukti Pelaksanaan Audit Internal</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_15" name="has_15" onchange="getValue('has_15')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>

															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_15')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_15'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_15')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_15']])@endcomponent

												@if($value['has_15'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_15']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_15']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_15']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_15']}}
													</td>
												@endif
											
											</tr>

											<tr class="even">
												<td id="no_has16" class="  valign-middle text-center">16</td>
												<td class=" valign-middle">Bukti Kaji Ulang Manajemen</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_16" name="has_16" onchange="getValue('has_16')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_16')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_16'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_16')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_16']])@endcomponent

												@if($value['has_16'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_16']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_16']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_16']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_16']}}
													</td>
												@endif
											
											</tr>

											<tr class="odd">
												<td id="no_has17" class="  valign-middle text-center">17</td>
												<td class=" valign-middle">Informasi Layout Fasilitas Produksi</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_17" name="has_17" onchange="getValue('has_17')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_17')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_17'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_17')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_17']])@endcomponent

												@if($value['has_17'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_17']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_17']}}
													</td>
													
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_17']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_17']}}
													</td>
												@endif
											
											</tr>

											<tr class="even">
												<td id="no_has18" class="  valign-middle text-center">18</td>
												<td class=" valign-middle">Bukti Registrasi BPJPH</td>
												<td class="valign-middle text-center">
													<table class="table-xs table borderless p-0 m-0" style="border:none border-collapse: collapse;">
														<tr style="border:none">
															<td style="border:none">
															<input type="file" id="has_18" name="has_18" onchange="getValue('has_18')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
															
															</td>
															<td style="border:none">
																<button type="submit"  style="background:none !important; border-radius:0; border:none !important; " onclick="setHas('has_18')" ><i class="fa fa-upload"></i><br>Upload</button>
															
															
															</td>
														</tr>
														<tr style="border:none">
															<td style="border:none;">
															
															
															@if($value['has_18'] !== null)
																<a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_18')}}" target="blank" ><i class="fa fa-eye"> View</i></a>
																{!! $fieldSudah !!}
															@else
																<a href="#" class="btn btn-grey btn-xs disabled"><i class="fa fa-eye"> View</i></a>
																{!! $fieldBelum !!}
															@endif
															</td>
															
														</tr>
													</table>
													
												</td>
												@component('components.forstatusdokumen',['value'=>$value['status_has_18']])@endcomponent

												@if($value['has_18'] !== null)
												
													<td class="   valign-middle">
														{{$value['keterangan_has_18']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_18']}}
													</td>
												
												@else
												
													<td class="  valign-middle">
														{{$value['keterangan_has_18']}}
													</td>
													<td class="   valign-middle">
														{{$value['review_perbaikan_18']}}
													</td>
												@endif
											
											</tr>
											
										@endforeach()
									@endif
									</tbody>
								</table>
								<div class="col-md-12 offset-md-5">
									@if($dataHas == null)
										<button type="submit" class="btn btn-sm btn-primary m-r-5" hidden>Unggah</button>
										<a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
										<!-- <button type="button"  class="btn btn-sm btn-default btn-warning" disabled=>Reset</button> -->
									@else
										<button type="submit" class="btn btn-sm btn-success m-r-5" hidden>Unggah</button>
										@foreach($dataHas as $has => $value)
											<a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
											
											<!-- <a href="{{url('delete_dokumen_sertifikasi')}}/{{$value['id']}}"><button type="button"  class="btn btn-sm btn-default btn-warning" onclick= "return confirm('Apakah anda yakin untuk menghapus semua data dokumen SJPH atau SJH??')">Reset</button></a> -->
										@endforeach
									@endif
								</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
			<!-- end card -->
		</div>
		<!-- end panel-body -->
	</div>
	<!-- end panel -->
@endsection

@push('scripts')
	<script src="{{asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('/assets/js/demo/table-manage-default.demo.js')}}"></script>
	<style>
		
		input[type="file"] {
		   
		    white-space: normal;
		    word-wrap: break-word;
		    width: 200px;
		    overflow: auto;
		}
	</style>
	<script type="text/javascript">
	


        function getValue(y){
        	const x  = document.getElementById(y);

        	// var length = x.files[0];
        	// console.log(length);

            var getSize = x.files[0].size;
            //var maxSize = 5120*1024;
            var maxSize = 2048*1024;
            var values = x.value;
            var ext = values.split('.').pop();
            if(getSize > maxSize){
                    alert("File terlalu besar, ukuran file maksimal 2MB");
                    x.value = "";
                    return false;
            }

           
        }

        function setHas(d){

        	var x = document.getElementById("has_selected");
        	x.value = d;

        	//console.log(x.value);

        }
        function getValueSJPH(y){
        	const x  = document.getElementById(y);

        	// var length = x.files[0];
        	// console.log(length);

            var getSize = x.files[0].size;
            //var maxSize = 5120*1024;
            var maxSize = 5120*1024;
            var values = x.value;
            var ext = values.split('.').pop();
            if(getSize > maxSize){
                    alert("File terlalu besar, ukuran file maksimal 5MB");
                    x.value = "";
                    return false;
            }

           
        }
	</script>
@endpush