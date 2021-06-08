@extends('layouts.default', ['boxedLayout' => false], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Unggah Data Sertifikasi')

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

							@php

								$regId = Auth::user()->registrasi_id;
								$fieldSudah = '<td class="  valign-middle text-center"><i class="ion-ios-cloud-done" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="  valign-middle text-center"><i class="ion-ios-remove-circle-outline" style="color:#ababab"></i></td>';
								
								$buttonUnduhDisabled = '<td class="valign-middle text-center"><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>';
								$buttonUnduh = '<button type="submit" style="height:70%" class="btn btn-xm btn-primary">Unggah</button> <td class="valign-middle text-center"><a href="#" class="btn btn-primary btn-xs">unduh</a></td>';
								

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

								<span style="margin-right: 5px; "><i class="ion-ios-paper" style="color:#ababab"></i> Belum diperiksa</span>
								<span style="margin-right: 5px;"><i class="ion-ios-paper" style="color:#2fca2f"></i> Sesuai</span>
								<span style="margin-right: 10px;"><i class="ion-ios-paper" style="color:#e46464"></i> Revisi</span>
								<span style="margin-right: 5px; "><i class="ion-ios-cloud-done" style="color:#2fca2f"></i> Sudah diunggah</span>
								<span style="margin-right: 5px; "><i class="ion-ios-remove-circle-outline" style="color:#ababab"></i> Belum diunggah</span>
								<h6></h6>
								<h5 style="color:#ff6961">NOTE: Ukuran Maksimal File 2MB. Silahkan Upload File Satu Persatu</h5>

								
								
								
							</div>
							<form action="{{route('storedokumensertifikasi')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<input type="text" id="has_selected" name="has_selected" hidden value="tes">
								<table id="hasTable"  class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
									<thead>
										<tr>
											<th width="1%" class="  valign-middle text-center">No</th>
											<th width="70%" class=" valign-middle text-center">Nama Dokumen</th>
											<th width="1%" class="  valign-middle text-center">File</th>
											@if($dataHas !== null)
											<th width="1%" class="  valign-middle text-center">Status</th>
											@endif
											<th width="1%" class="  valign-middle text-center">Keterangan</th>
											<th width="30%" class="  valign-middle text-center">Temuan</th>
											<th width="30%" class="  valign-middle text-center">Review Tambahan/ Perbaikan  Dokumen</th>

											<th width="1%" class="  valign-middle text-center">Aksi</th>
											
										</tr>
									</thead>
									<tbody>
										
									@if($dataHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="  valign-middle text-center">1</td>
											<td class="">Manual Sistem Jaminan Produk Halal (SJPH)</td>
											<td class="valign-middle text-center"><input type="file" id="has_1" name="has_1" onchange="getValue('has_1')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											
											<td class="valign-middle text-center"> <button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_1')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>

										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">2</td>
											<td class=" valign-middle">Matriks Bahan</td>
											<td class="  valign-middle text-center"><input type="file" id="has_2" name="has_2" onchange="getValueSJPH('has_2')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>

											<td class="valign-middle text-center"> <button type="submit" id="btn_has2" class="btn btn-xs btn-primary" onclick="setHas('has_2')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>

										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">3</td>
											<td class=" valign-middle">Data Produk Yang Dihasilkan</td>
											<td class="  valign-middle text-center"><input type="file" id="has_3" name="has_3" onchange="getValue('has_3')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has3" class="btn btn-xs btn-primary" onclick="setHas('has_3')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">4</td>
											<td class="  valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											<td class="  valign-middle text-center"><input type="file" id="has_4" name="has_4" onchange="getValue('has_4')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has4" class="btn btn-xs btn-primary" onclick="setHas('has_4')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">5</td>
											<td class=" valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
											<td class="  valign-middle text-center"><input type="file" id="has_5" name="has_5" onchange="getValue('has_5')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has5" class="btn btn-xs btn-primary" onclick="setHas('has_5')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										<tr class="even">
											<td class="  valign-middle text-center">6</td>
											<td class=" valign-middle">Sertifikat Halal Sebelumnya (Jika Ada)</td>
											<td class="  valign-middle text-center"><input type="file" id="has_6" name="has_6" onchange="getValue('has_6')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has6" class="btn btn-xs btn-primary" onclick="setHas('has_6')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">7</td>
											<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											<td class="  valign-middle text-center"><input type="file" id="has_7" name="has_7" onchange="getValue('has_7')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has7" class="btn btn-xs btn-primary" onclick="setHas('has_7')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										<tr class="even">
											<td class="  valign-middle text-center">8</td>
											<td class=" valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
											<td class="  valign-middle text-center"><input type="file" id="has_8" name="has_8" onchange="getValue('has_8')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has8" class="btn btn-xs btn-primary" onclick="setHas('has_8')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">9</td>
											<td class=" valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
											<td class="  valign-middle text-center"><input type="file" id="has_9" name="has_9" onchange="getValue('has_9')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has9" class="btn btn-xs btn-primary" onclick="setHas('has_9')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">10</td>
											<td class=" valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya.</td>
											<td class="  valign-middle text-center"><input type="file" id="has_10" name="has_10" onchange="getValue('has_10')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has10" class="btn btn-xs btn-primary" onclick="setHas('has_10')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="odd">
											<td class="  valign-middle text-center">11</td>
											<td class=" valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)*Dilampirkan Aspek Legal Perusahaan
											</td>
											<td class="  valign-middle text-center"><input type="file" id="has_11" name="has_11" onchange="getValue('has_11')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has11" class="btn btn-xs btn-primary" onclick="setHas('has_11')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">12</td>
											<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
											<td class="  valign-middle text-center"><input type="file" id="has_12" name="has_12" onchange="getValue('has_12')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has12" class="btn btn-xs btn-primary" onclick="setHas('has_12')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">13</td>
											<td class="valign-middle">Bukti Sertifikat Penyelia Halal</td>
											<td class="  valign-middle text-center"><input type="file" id="has_13" name="has_13" onchange="getValue('has_13')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has13" class="btn btn-xs btn-primary" onclick="setHas('has_13')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">14</td>
											<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
											<td class="  valign-middle text-center"><input type="file" id="has_14" name="has_14" onchange="getValue('has_14')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has14" class="btn btn-xs btn-primary" onclick="setHas('has_14')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">15</td>
											<td class="valign-middle">Bukti Pelaksanaan Audit Internal</td>
											<td class="  valign-middle text-center"><input type="file" id="has_15" name="has_15" onchange="getValue('has_15')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has15" class="btn btn-xs btn-primary" onclick="setHas('has_15')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">16</td>
											<td class="valign-middle">Bukti Kaji Ulang Manajemen</td>
											<td class="  valign-middle text-center"><input type="file" id="has_16" name="has_16" onchange="getValue('has_16')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has16" class="btn btn-xs btn-primary" onclick="setHas('has_16')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">17</td>
											<td class="valign-middle">Informasi Denah Lokasi Produksi</td>
											<td class="  valign-middle text-center"><input type="file" id="has_17" name="has_17" onchange="getValue('has_17')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has17" class="btn btn-xs btn-primary" onclick="setHas('has_17')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										<tr class="even">
											<td class="  valign-middle text-center">18</td>
											<td class="valign-middle">BBukti Registrasi Dari BPJPH</td>
											<td class="  valign-middle text-center"><input type="file" id="has_16" name="has_18" onchange="getValue('has_18')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" ></td>
											{!! $fieldBelum !!}
											<td class=" valign-middle"></td>
											<td class=" valign-middle"></td>
											<td class="valign-middle text-center"> <button type="submit" id="btn_has18" class="btn btn-xs btn-primary" onclick="setHas('has_18')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
										</tr>
										
									@else
											@foreach($dataHas as $has => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td id="no_has1" class="valign-middle text-center">1</td>
													<td class=" valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
													<td   class=valign-middle text-center">
														<input style="width:180px"type="file" id="has_1" name="has_1" onchange="getValue('has_1')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_1']])@endcomponent

													@if($value['has_1'] !== null)
														{!! $fieldSudah !!}
														<td class="   valign-middle">
															{{$value['keterangan_has_1']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_1']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" class="btn btn-xs btn-primary" id="btn_has1" onclick="setHas('has_1')">Unggah</button> <a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_1']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_1']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_1']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_1')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>
												<tr class="even">
													<td id="no_has2" class="valign-middle text-center">2</td>
													<td class=" valign-middle">Matriks Bahan</td>
													<td class="valign-middle text-center">
														<input style="width:180px" type="file" id="has_2" name="has_2" onchange="getValueSJPH('has_2')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_2']])@endcomponent
													@if($value['has_2'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_2']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_2']}}
														</td>
														<td class="  valign-middle text-center">
															<button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has2" onclick="setHas('has_2')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_2']) }}" class="btn btn-primary btn-xs" download>unduh</a>
														</td>
													@else
														{!! $fieldBelum !!}														
														<td class="   valign-middle">
															{{$value['keterangan_has_2']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_2']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has2" class="btn btn-xs btn-primary" onclick="setHas('has_2')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="odd">
													<td id="no_has3" class="  valign-middle text-center">3</td>
													<td class="valign-middle">Data Produk Yang Dihasilkan</td>
													<td class="valign-middle text-center">
														<input style="width:180px" type="file" id="has_3" name="has_3" onchange="getValue('has_3')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_3']])@endcomponent
													@if($value['has_3'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_3']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_3']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has3" onclick="setHas('has_3')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_3']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="   valign-middle">
															{{$value['keterangan_has_3']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_3']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has3" class="btn btn-xs btn-primary" onclick="setHas('has_3')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="even">
													<td id="no_has4" class="  valign-middle text-center">4</td>
													<td class="  valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
													<td class="valign-middle text-center">
														<input style="width:180px" type="file" id="has_4" name="has_4" onchange="getValue('has_4')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_4']])@endcomponent
													@if($value['has_4'] !== null)
														{!! $fieldSudah !!}
														<td class="   valign-middle">
															{{$value['keterangan_has_4']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_4']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has4" onclick="setHas('has_4')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_4']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_4']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_4']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has4" class="btn btn-xs btn-primary" onclick="setHas('has_4')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="odd">
													<td id="no_has5" class="  valign-middle text-center">5</td>
													<td class=" valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
													<td class="valign-middle text-center">
														<input style="width:180px" type="file" id="has_5" name="has_5" onchange="getValue('has_5')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_5']])@endcomponent
													@if($value['has_5'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_5']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_5']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has5" onclick="setHas('has_5')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_5']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_5']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_5']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has5" class="btn btn-xs btn-primary" onclick="setHas('has_5')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												<tr class="even">
													<td id="no_has6" class="  valign-middle text-center">6</td>
													<td class=" valign-middle">Sertifikat Halal Sebelumnya</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_6" name="has_6" onchange="getValue('has_6')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_6']])@endcomponent
													@if($value['has_6'] !== null)
														{!! $fieldSudah !!}
														<td class="   valign-middle">
															{{$value['keterangan_has_6']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_6']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has6" onclick="setHas('has_6')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_6']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_6']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_6']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has6" class="btn btn-xs btn-primary" onclick="setHas('has_6')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="odd">
													<td id="no_has7" class="  valign-middle text-center">7</td>
													<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_7" name="has_7" onchange="getValue('has_7')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_7']])@endcomponent
													@if($value['has_7'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_7']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_7']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has7" onclick="setHas('has_7')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_7']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_7']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_7']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has7" class="btn btn-xs btn-primary" onclick="setHas('has_7')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												<tr class="even">
													<td id="no_has8" class="  valign-middle text-center">8</td>
													<td class=" valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_8" name="has_8" onchange="getValue('has_8')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_8']])@endcomponent
													@if($value['has_8'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_8']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_8']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has8" onclick="setHas('has_8')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_8']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_8']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_8']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has8" class="btn btn-xs btn-primary" onclick="setHas('has_8')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="odd">
													<td id="no_has9" class="  valign-middle text-center">9</td>
													<td class=" valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_9" name="has_9" onchange="getValue('has_9')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_9']])@endcomponent
													@if($value['has_9'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_9']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_9']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has9" onclick="setHas('has_9')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_9']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_9']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_9']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has9" class="btn btn-xs btn-primary" onclick="setHas('has_9')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="even">
													<td id="no_has10" class="  valign-middle text-center">10</td>
													<td class=" valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya.</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_10" name="has_10" onchange="getValue('has_10')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_10']])@endcomponent
													@if($value['has_10'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_10']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_10']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has10" onclick="setHas('has_10')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_10']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_10']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_10']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has10" class="btn btn-xs btn-primary" onclick="setHas('has_10')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="odd">
													<td id="no_has11" class="  valign-middle text-center">11</td>
													<td class=" valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)*Dilampirkan Aspek Legal Perusahaan
													</td>
													<td class="valign-middle text-center">
														<input style="width:180px" type="file" id="has_11" name="has_11" onchange="getValue('has_11')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_11']])@endcomponent
													@if($value['has_11'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_11']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_11']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has11" onclick="setHas('has_11')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_11']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_11']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_11']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has11" class="btn btn-xs btn-primary" onclick="setHas('has_11')" >Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												</tr>
												<tr class="even">
													<td id="no_has12" class="  valign-middle text-center">12</td>
													<td class=" valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_12" name="has_12" onchange="getValue('has_12')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_12']])@endcomponent
													@if($value['has_12'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_12']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_12']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has12" onclick="setHas('has_12')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_12']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_12']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_12']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has12" class="btn btn-xs btn-primary" onclick="setHas('has_12')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="even">
													<td id="no_has13" class="  valign-middle text-center">13</td>
													<td class=" valign-middle">Bukti Sertifikat Penyelia Halal</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_13" name="has_13" onchange="getValue('has_13')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_13']])@endcomponent
													@if($value['has_13'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_13']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_13']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has13" onclick="setHas('has_13')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_13']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_13']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_13']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has13" class="btn btn-xs btn-primary" onclick="setHas('has_13')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="even">
													<td id="no_has14" class="  valign-middle text-center">14</td>
													<td class=" valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_14" name="has_14" onchange="getValue('has_14')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_14']])@endcomponent
													@if($value['has_14'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_14']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_14']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has14" onclick="setHas('has_14')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_14']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_14']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_14']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has14" class="btn btn-xs btn-primary" onclick="setHas('has_14')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="even">
													<td id="no_has15" class="  valign-middle text-center">15</td>
													<td class=" valign-middle">Bukti Pelaksanaan Audit Internal</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_15" name="has_15" onchange="getValue('has_15')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_15']])@endcomponent
													@if($value['has_15'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_15']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_15']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has15" onclick="setHas('has_15')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_15']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_15']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_15']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has15" class="btn btn-xs btn-primary" onclick="setHas('has_15')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="even">
													<td id="no_has16" class="  valign-middle text-center">16</td>
													<td class=" valign-middle">Bukti Kaji Ulang Manajemen</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_16" name="has_16" onchange="getValue('has_16')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_16']])@endcomponent
													@if($value['has_16'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_16']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_16']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has16" onclick="setHas('has_16')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_16']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_16']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_16']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has16" class="btn btn-xs btn-primary" onclick="setHas('has_16')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="odd">
													<td id="no_has17" class="  valign-middle text-center">17</td>
													<td class=" valign-middle">Informasi Layout Fasilitas Produksi</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_17" name="has_17" onchange="getValue('has_17')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_17']])@endcomponent
													@if($value['has_17'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_17']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_17']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has17" onclick="setHas('has_17')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_17']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_17']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_17']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has17" class="btn btn-xs btn-primary" onclick="setHas('has_17')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
													@endif
												
												</tr>

												<tr class="even">
													<td id="no_has18" class="  valign-middle text-center">18</td>
													<td class=" valign-middle">Bukti Registrasi BPJPH</td>
													<td class=" valign-middle text-center">
														<input style="width:180px" type="file" id="has_18" name="has_18" onchange="getValue('has_18')" accept="application/msword,application/pdf,application/vnd.ms-excel, image/*" >
													</td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_18']])@endcomponent
													@if($value['has_18'] !== null)
														{!! $fieldSudah !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_18']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_18']}}
														</td>
														<td class="  valign-middle text-center"><button type="submit" style="margin-right:5px;"  class="btn btn-xs btn-primary" id="btn_has18" onclick="setHas('has_18')">Unggah</button><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HPAS/'.$value['has_18']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														<td class="  valign-middle">
															{{$value['keterangan_has_18']}}
														</td>
														<td class="   valign-middle">
															{{$value['review_perbaikan_18']}}
														</td>
														<td class="valign-middle text-center"> <button type="submit" id="btn_has18" class="btn btn-xs btn-primary" onclick="setHas('has_18')">Unggah</button><a href="#" class="btn btn-grey btn-xs disabled">unduh</a> </td>
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
										<button type="button"  class="btn btn-sm btn-default btn-warning" disabled=>Reset</button>
									@else
										<button type="submit" class="btn btn-sm btn-success m-r-5" hidden>Unggah</button>
										@foreach($dataHas as $has => $value)
											<a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
											
											<a href="{{url('delete_dokumen_sertifikasi')}}/{{$value['id']}}"><button type="button"  class="btn btn-sm btn-default btn-warning" onclick= "return confirm('Apakah anda yakin untuk menghapus semua data dokumen SJPH atau SJH??')">Reset</button></a>
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