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

			<!-- begin card -->
			<div class="card border-0">
				<div class="card-header tab-overflow p-t-0 p-b-0">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item prev-button"><a href="#" data-click="prev-tab" class="nav-link text-primary"><i class="fa fa-arrow-left"></i></a></li>
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/has.png')}}" width="40%" alt="" /> 
							<a class="nav-link active" data-toggle="tab" href="#card-tab-1">Dokumen</a>
						</li>
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/kantor.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-7">Kantor Pusat</a>
						</li>
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/menu.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-8">Menu Restoran</a>
						</li>
						@endif
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/fasilitas-1.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-2">Fasilitas</a>
						</li>
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 3 || $dataRegistrasi[0]['id_jenis_registrasi'] == 4 )
						<li class="nav-item text-center">
							@if($dataRegistrasi[0]['id_jenis_registrasi'] == 4)
							<img src="{{asset('/assets/img/halal/servis.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-3">Servis</a>
							@else
							<img src="{{asset('/assets/img/halal/produk-1.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-3">Produk</a>
							@endif
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/material-1.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-4">Material</a>
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/matriks.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-5">Matriks Produk</a>
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 3 )
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/penyembelih.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-9">Jagal</a>
						</li>
						@endif
						<li class="nav-item text-center">
							<img src="{{asset('/assets/img/halal/kuesioner.png')}}" width="40%" alt="" /> 
							<a class="nav-link" data-toggle="tab" href="#card-tab-6">Kuesioner SJPH</a>
						</li>
						<li class="nav-item next-button"><a href="#" data-click="next-tab" class="nav-link text-primary"><i class="fa fa-arrow-right"></i></a></li>
					</ul>
				</div>
				<div class="card-body table-responsive">
					<div class="tab-content p-0 m-0">
						<div class="tab-pane fade active show" id="card-tab-1">
							@php

								$regId = Auth::user()->registrasi_id;
								$fieldSudah = '<td class="text-nowrap valign-middle text-center"><i class="ion-ios-cloud-done" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="text-nowrap valign-middle text-center"><i class="ion-ios-remove-circle-outline" style="color:#ababab"></i></td>';
								$buttonUnduhDisabled = '<td class="text-nowrap valign-middle text-center"><a href="#" class="btn btn-grey btn-xs disabled">unduh</a></td>';

								$buttonUnduh = '<td class="text-nowrap valign-middle text-center"><a href="#" class="btn btn-primary btn-xs">unduh</a></td>';
								

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
								
							</div>
							<form action="{{route('storedokumenhas')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<table id="hasTable" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th class=" valign-middle text-center">Nama Dokumen</th>
											<th width="1%" class="text-nowrap valign-middle text-center">File</th>
											@if($dataHas !== null)
											<th width="1%" class="text-nowrap valign-middle text-center">Status</th>
											@endif
											<th width="1%" class="text-nowrap valign-middle text-center">Keterangan</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Aksi</th>
											
										</tr>
									</thead>
									<tbody>
										
									@if($dataHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="">Sertifikat Halal Sebelumnya (Registrasi Perpanjangan/Pengembangan)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_1" name="has_1" onchange="getValue('has_1')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">2</td>
											<td class="text-nowrap valign-middle">Manual SJPH (untuk Registrasi Baru/Perpanjangan dan Pendaftaran Pengembangan dengan Status SJH B)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_2" name="has_2" onchange="getValue('has_2')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">3</td>
											<td class="text-nowrap valign-middle">Status SJPH atau Sertifikat SJH (untuk Registrasi Pengembangan/Perpanjangan)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_3" name="has_3" onchange="getValue('has_3')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">4</td>
											<td class="text-nowrap valign-middle">Flow process chart of halal certified products</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_4" name="has_4" onchange="getValue('has_4')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">5</td>
											<td class="text-nowrap valign-middle">Pernyataan fasilitas bebas dari babi dan turunannya (untuk registrasi baru atau fasilitas baru)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_5" name="has_5" onchange="getValue('has_5')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">6</td>
											<td class="text-nowrap valign-middle">Daftar alamat seluruh fasilitas produksi (termasuk gerai, dapur, gudang dan kantor pusat)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_6" name="has_6" onchange="getValue('has_6')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">7</td>
											<td class="text-nowrap valign-middle">Bukti diseminasi/sosialisasi kebijakan halal (untuk registrasi baru atau fasilitas baru)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_7" name="has_7" onchange="getValue('has_7')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">8</td>
											<td class="text-nowrap valign-middle">Bukti pelaksanaan pelatihan internal SJPH (untuk registrasi baru atau fasilitas baru)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_8" name="has_8" onchange="getValue('has_8')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">9</td>
											<td class="text-nowrap valign-middle">Bukti pelaksanaan Audit Internal (untuk registrasi baru atau fasilitas baru)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_9" name="has_9" onchange="getValue('has_9')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">10</td>
											<td class="text-nowrap valign-middle">Izin usaha (untuk registrasi baru atau untuk fasilitas baru)</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_10" name="has_10" onchange="getValue('has_10')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">11</td>
											<td class="text-nowrap valign-middle">Bukti registrasi dari BPJPH</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_11" name="has_11" onchange="getValue('has_11')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">12</td>
											<td class="text-nowrap valign-middle">Denah/ Tata letak ruang produksi</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" id="has_12" name="has_12" onchange="getValue('has_12')"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
									@else
											@foreach($dataHas as $has => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">1</td>
													<td class="text-nowrap valign-middle">Sertifikat Halal Sebelumnya (Registrasi Perpanjangan/Pengembangan)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_1" name="has_1" onchange="getValue('has_1')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_1']])@endcomponent
													@if($value['has_1'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_1']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
													
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">2</td>
													<td class="text-nowrap valign-middle">Manual SJPH (untuk Registrasi Baru/Perpanjangan dan Pendaftaran Pengembangan dengan Status SJH B)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_2" name="has_2" onchange="getValue('has_2')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_2']])@endcomponent
													@if($value['has_2'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_2']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">3</td>
													<td class="text-nowrap valign-middle">Status SJPH atau Sertifikat SJH (untuk Registrasi Pengembangan/Perpanjangan)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_3" name="has_3" onchange="getValue('has_3')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_3']])@endcomponent
													@if($value['has_3'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_3']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">4</td>
													<td class="text-nowrap valign-middle">Flow process chart of halal certified products</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_4" name="has_4" onchange="getValue('has_4')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_4']])@endcomponent
													@if($value['has_4'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_4']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">5</td>
													<td class="text-nowrap valign-middle">Pernyataan fasilitas bebas dari babi dan turunannya (untuk registrasi baru atau fasilitas baru)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_5" name="has_5" onchange="getValue('has_5')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_5']])@endcomponent
													@if($value['has_5'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_5']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">6</td>
													<td class="text-nowrap valign-middle">Daftar alamat seluruh fasilitas produksi (termasuk gerai, dapur, gudang dan kantor pusat)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_6" name="has_6" onchange="getValue('has_6')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_6']])@endcomponent
													@if($value['has_6'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_6']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">7</td>
													<td class="text-nowrap valign-middle">Bukti diseminasi/sosialisasi kebijakan halal (untuk registrasi baru atau fasilitas baru)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_7" name="has_7" onchange="getValue('has_7')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_7']])@endcomponent
													@if($value['has_7'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_7']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">8</td>
													<td class="text-nowrap valign-middle">Bukti pelaksanaan pelatihan internal SJPH (untuk registrasi baru atau fasilitas baru)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_8" name="has_8" onchange="getValue('has_8')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_8']])@endcomponent
													@if($value['has_8'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_8']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">9</td>
													<td class="text-nowrap valign-middle">Bukti pelaksanaan Audit Internal (untuk registrasi baru atau fasilitas baru)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_9" name="has_9" onchange="getValue('has_9')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_9']])@endcomponent
													@if($value['has_9'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_9']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">10</td>
													<td class="text-nowrap valign-middle">Izin usaha (untuk registrasi baru atau untuk fasilitas baru)</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_10" name="has_10" onchange="getValue('has_10')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_10']])@endcomponent
													@if($value['has_10'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_10']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">11</td>
													<td class="text-nowrap valign-middle">Bukti registrasi dari BPJPH</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_11" name="has_11" onchange="getValue('has_11')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_11']])@endcomponent
													@if($value['has_11'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_11']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">12</td>
													<td class="text-nowrap valign-middle">Denah/ Tata letak ruang produksi</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" id="has_12" name="has_12" onchange="getValue('has_12')"></td>
													@component('components.forstatusdokumen',['value'=>$value['status_has_12']])@endcomponent
													@if($value['has_12'] !== null)
														{!! $fieldSudah !!}
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_12']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $fieldBelum !!}
														{!! $buttonUnduhDisabled !!}
													@endif
												</tr>
											@endforeach()
										@endif
									</tbody>
								</table>
								<div class="col-md-12 offset-md-5">
									@if($dataHas == null)
										<button type="submit" class="btn btn-sm btn-primary m-r-5">Unggah</button>
										<button type="button"  class="btn btn-sm btn-default" disabled=>Reset</button>
									@else
										<button type="submit" class="btn btn-sm btn-success m-r-5">Unggah</button>
										@foreach($dataHas as $has => $value)
											<a href="{{url('delete_dokumen_has')}}/{{$value['id']}}"><button type="button"  class="btn btn-sm btn-default" onclick= "return confirm('Apakah anda yakin untuk menghapus semua data dokumen HAS??')">Reset</button></a>
										@endforeach
									@endif
								</div>
							</form>	
						</div>
						<div class="tab-pane fade" id="card-tab-7">
							<div class="text-right">
								<a href="{{route('tambahkantorpusat')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Kantor Pusat</a>	
							</div>
							
							<table id="kantorPusatTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Kantor Pusat</th>
				                        <th class="text-nowrap valign-middle text-center">Alamat</th>
				                        <th class="text-nowrap valign-middle text-center">Kota</th>
				                        <th class="text-nowrap valign-middle text-center">Negara</th>
				                        <th class="text-nowrap valign-middle text-center">Telepon</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-8">
							<div class="text-right">
								<a href="{{route('tambahmenurestoran')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Menu Restoran</a>	
							</div>
							
							<table id="menuRestoranTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Menu Restoran</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-2">
							<div class="text-right">
								<a href="{{route('tambahfasilitas')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Fasilitas</a>	
							</div>
							
							<table id="fasilitasTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Fasilitas</th>
				                        <th class="text-nowrap valign-middle text-center">Alamat</th>
				                        <th class="text-nowrap valign-middle text-center">Kota</th>
				                        <th class="text-nowrap valign-middle text-center">Negara</th>
				                        <th class="text-nowrap valign-middle text-center">Telepon</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-3">
							<div class="text-right">
								<a href="{{route('tambahproduk')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Produk</a>	
							</div>
							
							<table id="produkTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Fasilitas</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Produk</th>
				                        <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-4">
							<div class="text-right">
								<a href="{{route('tambahmaterial')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Material</a>	
							</div>
							
							<table id="materialTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Tipe Material</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Material</th>
				                        <th class="text-nowrap valign-middle text-center">File</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-5">
							@if($dataMatriksProduk !== null)
								@foreach($dataMatriksProduk as $matriks => $value)
									@if($value['status_matriks_produk'] == 1)
										<h5 style="float: left;">Dokumen Lengkap</h5>
									@else
										<h5 style="float: left;">Dokumen Belum Lengkap</h5>
									@endif 
								@endforeach
							@else
								<h5 style="float: left;">Dokumen Belum Lengkap</h5>	
							@endif
							<a href="{{ url('').Storage::url('public/templateDokumen/template_matriks_produk.xlsx') }}" class="btn btn-info btn-sm right" style="float: right;margin-bottom: 5px;" download>&nbsp;&nbsp;Unduh Format File Matriks Produk&nbsp;&nbsp;</a>
							<form action="{{route('storematriksproduk')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<table  class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="10%" class="text-nowrap valign-middle text-center">No Registrasi</th>
											<th width="10%" class="text-nowrap valign-middle text-center">File</th>
											<th width="10%" class="text-nowrap valign-middle text-center">Status</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Aksi</th>
										</tr>
									</thead>
									<tbody>
										@if($dataMatriksProduk == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="text-nowrap valign-middle text-center">{{$data->no_registrasi}}</td>
											<td class="text-nowrap valign-middle text-center"><input type="file" name="matriks_produk" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"></td>
											{!! $fieldBelum !!}
											{!! $buttonUnduhDisabled !!}
										</tr>
										@else
											@foreach($dataMatriksProduk as $matriks => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">1</td>
													<td class="text-nowrap valign-middle text-center">{{$data->no_registrasi}}</td>
													<td class="text-nowrap valign-middle text-center"><input type="file" name="matriks_produk" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"></td>
													{!! $fieldSudah !!}
													<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/MATRIKSPRODUK/'.$value['matriks_produk']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
												</tr>
											@endforeach
										@endif	
									</tbody>
								</table>
								<div class="col-md-12 offset-md-5">
									@if($dataMatriksProduk == null)
										<button type="submit" class="btn btn-sm btn-primary m-r-5">Unggah</button>
										<button type="button"  class="btn btn-sm btn-default" disabled>Reset</button>
									@else
										<button type="submit" class="btn btn-sm btn-success m-r-5">Unggah</button>
										@foreach($dataMatriksProduk as $matriks => $value)
											<a href="{{url('delete_matriks_produk')}}/{{$value['id']}}"><button type="button"  class="btn btn-sm btn-default" onclick= "return confirm('Apakah anda yakin untuk menghapus semua data dokumen Matriks Produk??')">Reset</button></a>
										@endforeach
									@endif
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="card-tab-9">
							<div class="text-right">
								<a href="{{route('tambahjagal')}}" class="btn btn-sm btn-primary  m-b-15"><i class="fa fa-plus"></i> Tambah Jagal</a>	
							</div>
							
							<table id="jagalTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Nama</th>
				                        <th class="text-nowrap valign-middle text-center">ID Penerbit Kartu</th>
				                        <th class="text-nowrap valign-middle text-center">ID Kartu</th>
				                        <th class="text-nowrap valign-middle text-center">Masa Berlaku</th>
				                        <th class="text-nowrap valign-middle text-center">Komentar</th>
				                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-6">
							@if($dataKuisionerHas !== null)
								@foreach($dataKuisionerHas as $kuis => $value)
									@if($value['status_kuis'] == 1)
										<h5>Kuisioner Sudah Terisi</h5>
									@else
										<h5>Kuisioiner Belum Diisi</h5>
									@endif 
								@endforeach
							@else
								<h5>Kuisioiner Belum Diisi</h5>	
							@endif
							<form action="{{route('storekuisionerhas')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<table  class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="10%" class="text-nowrap valign-middle text-center">Kuesioner</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Jawaban</th>
										</tr>
									</thead>
									@if($dataKuisionerHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tbody>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">1</td>
												<td class="text-nowrap valign-middle text-left">
													Apakah perusahaan pemohon sertifikasi adalah distributor (bukan produsen/manufacturer)?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_1" id="kuis11" value="1" />
														<label for="kuis11">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_1" id="kuis12" value="0" />
														<label for="kuis12">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">2</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 1 Ya, apakah perusahaan pemohon merupakan satu grup dengan produsen/manufacturer?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_2" id="kuis21" value="1" />
														<label for="kuis21">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_2" id="kuis22" value="0" />
														<label for="kuis22">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">3</td>
												<td class="text-nowrap valign-middle text-left">
													Apakah perusahaan pemohon melakukan proses pelabelan ulang (relabeling) atau pengemasan ulang (repacking)?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_3" id="kuis31" value="1" />
														<label for="kuis31">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_3" id="kuis32" value="0" />
														<label for="kuis32">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">4</td>
												<td class="text-nowrap valign-middle text-left">
													Selain menghasilkan produk yang disertifikasi, apakah pabrik juga menghasilkan produk yang tidak disertifikasi?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_4" id="kuis41" value="1" />
														<label for="kuis41">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_4" id="kuis42" value="0" />
														<label for="kuis42">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">5</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 4 Ya, apakah ada penggunaan fasilitas produksi dan peralatan pembantu yang sama untuk produk yang disertifikasi dan produk yang tidak disertifikasi?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_5" id="kuis51" value="1" />
														<label for="kuis51">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_5" id="kuis52" value="0" />
														<label for="kuis52">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">6</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 5 Ya, apakah ada penggunaan bahan dari babi atau turunannya?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_6" id="kuis61" value="1" />
														<label for="kuis61">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_6" id="kuis62" value="0" />
														<label for="kuis62">Tidak</label>
													</div>
												</td>
											</tr>
										</tbody>
									@else
										@foreach($dataKuisionerHas as $kuis => $value)
											<input type="text" name="status" value="1" readonly hidden>
											<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
											<tbody>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">1</td>
												<td class="text-nowrap valign-middle text-left">
													Apakah perusahaan pemohon sertifikasi adalah distributor (bukan produsen/manufacturer)?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_1" id="kuis11" value="1" {{$value['kuis_1'] == 1 ? 'checked' : ''}} />
														<label for="kuis11">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_1" id="kuis12" value="0" {{$value['kuis_1'] == 0 ? 'checked' : ''}}/>
														<label for="kuis12">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">2</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 1 Ya, apakah perusahaan pemohon merupakan satu grup dengan produsen/manufacturer?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_2" id="kuis21" value="1" {{$value['kuis_2'] == 1 ? 'checked' : ''}}/>
														<label for="kuis21">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_2" id="kuis22" value="0" {{$value['kuis_2'] == 0 ? 'checked' : ''}}/>
														<label for="kuis22">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">3</td>
												<td class="text-nowrap valign-middle text-left">
													Apakah perusahaan pemohon melakukan proses pelabelan ulang (relabeling) atau pengemasan ulang (repacking)?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_3" id="kuis31" value="1" {{$value['kuis_3'] == 1 ? 'checked' : ''}}/>
														<label for="kuis31">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_3" id="kuis32" value="0" {{$value['kuis_3'] == 0 ? 'checked' : ''}}/>
														<label for="kuis32">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">4</td>
												<td class="text-nowrap valign-middle text-left">
													Selain menghasilkan produk yang disertifikasi, apakah pabrik juga menghasilkan produk yang tidak disertifikasi?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_4" id="kuis41" value="1" {{$value['kuis_4'] == 1 ? 'checked' : ''}}/>
														<label for="kuis41">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_4" id="kuis42" value="0" {{$value['kuis_4'] == 0 ? 'checked' : ''}}/>
														<label for="kuis42">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">5</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 4 Ya, apakah ada penggunaan fasilitas produksi dan peralatan pembantu yang sama untuk produk yang disertifikasi dan produk yang tidak disertifikasi?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_5" id="kuis51" value="1" {{$value['kuis_5'] == 1 ? 'checked' : ''}}/>
														<label for="kuis51">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_5" id="kuis52" value="0" {{$value['kuis_5'] == 0 ? 'checked' : ''}}/>
														<label for="kuis52">Tidak</label>
													</div>
												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">6</td>
												<td class="text-nowrap valign-middle text-left">
													Jika jawaban pada poin 5 Ya, apakah ada penggunaan bahan dari babi atau turunannya?
												</td>
												<td class="text-nowrap valign-middle text-center">
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_6" id="kuis61" value="1" {{$value['kuis_6'] == 1 ? 'checked' : ''}}/>
														<label for="kuis61">Ya</label>
													</div>
													<div class="radio radio-css radio-inline">
														<input type="radio" name="kuis_6" id="kuis62" value="0" {{$value['kuis_6'] == 0 ? 'checked' : ''}}/>
														<label for="kuis62">Tidak</label>
													</div>
												</td>
											</tr>
										</tbody>
										@endforeach
									@endif	
								</table>
								<div class="col-md-12 offset-md-5">
									@if($dataKuisionerHas == null)
										<button type="submit" class="btn btn-sm btn-primary m-r-5">Submit</button>
										<button type="button"  class="btn btn-sm btn-default" disabled>Reset</button>
									@else
										<button type="submit" class="btn btn-sm btn-success m-r-5">Submit</button>
										@foreach($dataKuisionerHas as $kuis => $value)
											<a href="{{url('delete_kuisioner_has')}}/{{$value['id']}}"><button type="button"  class="btn btn-sm btn-default" onclick= "return confirm('Apakah anda yakin untuk reset jawaban kuisioner has??')">Reset</button></a>
										@endforeach
									@endif
								</div>
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
	<script type="text/javascript">
		$('#fasilitasTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"fasilitas"
                },
                {
                    "data":"alamat"
                },
                {
                    "data":"kota"
                },
                {
                    "data":"negara"
                },
                {
                    "data":"telepon"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('detail_fasilitas')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-eye"></i> Detail</a>

                                    <a href="{{url('edit_fasilitas')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>
   
                                </div>
                            </div>`

                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listfasilitas')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

        $('#produkTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"fasilitas"
                },
                {
                    "data":"nama_produk"
                },
                {
                    "data":"kelompok"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<a href="{{url('edit_produk')}}/`+full.id+`" class="btn btn-primary btn-xs" >&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listproduk')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

        $('#hasTable').DataTable({
        	"paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching":false
        });

        $('#materialTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"tipe_material"
                },
                {
                    "data":"nama_material"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                    	if(full.file_material == null){
                    		return `<a href="" class="btn btn-lime btn-xs" disabled>&nbsp;&nbsp;Unduh File&nbsp;&nbsp;</a>`
                    	}else{
                    		return `<a href="{{ url('').Storage::url('public/uploadDokumen/`+full.id_user+`/`+full.id_registrasi+`/MATERIAL/`+full.file_material+`') }}" class="btn btn-lime btn-xs" download>&nbsp;&nbsp;Unduh File&nbsp;&nbsp;</a>`
                    	}
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('detail_material')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-eye"></i> Detail</a>

                                    <a href="{{url('edit_material')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>
   
                                </div>
                            </div>`		

                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listmaterial')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

        $('#kantorPusatTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"kantor_pusat"
                },
                {
                    "data":"alamat"
                },
                {
                    "data":"kota"
                },
                {
                    "data":"negara"
                },
                {
                    "data":"phone"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('detail_kantor_pusat')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-eye"></i> Detail</a>

                                    <a href="{{url('edit_kantor_pusat')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>
   
                                </div>
                            </div>`		
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listkantorpusat')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

        $('#menuRestoranTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"menu"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<a href="{{url('edit_menu_restoran')}}/`+full.id+`" class="btn btn-primary btn-xs" >&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listmenurestoran')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

        $('#jagalTable').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"nama_jagal"
                },
                {
                    "data":"id_penerbit_kartu"
                },
                {
                    "data":"id_kartu"
                },
                {
                    "data":"tanggal_expired"
                },
                {
                    "data":"deskripsi"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('detail_jagal')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-eye"></i> Detail</a>

                                    <a href="{{url('edit_jagal')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>
   
                                </div>
                            </div>`		
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('listjagal')}}",
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });


        function getValue(y){
        	const x  = document.getElementById(y);

        	// var length = x.files[0];
        	// console.log(length);

            var getSize = x.files[0].size;
            //var maxSize = 5120*1024;
            var maxSize = 3072*1024;
            var values = x.value;
            var ext = values.split('.').pop();
            if(getSize > maxSize){
                    alert("File terlalu besar, ukuran file maksimal 3MB");
                    x.value = "";
                    return false;
            }

            // if(ext=="pdf" || ext=="docx" || ext=="doc"){
            //     if(getSize > maxSize){
            //         alert("File terlalu besar :( , ukuran file maksimal 5MB :)");
            //         x.value = "";
            //         return false;
            //     }
            // }else{
            //     alert(ext);
            //     alert("file tidak termasuk");
            //     x.value = "";
            // }
        }
	</script>
@endpush