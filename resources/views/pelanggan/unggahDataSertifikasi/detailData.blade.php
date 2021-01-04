@extends('layouts.default', ['boxedLayout' => false], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Detail Unggah Data Sertifikasi')

@push('css')
	<link href="{{asset('/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />	
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item active">Detail Unggah Data Sertifikasi</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Unggah Data Sertifikasi  <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
			<h4 class="panel-title" style="margin-left:5px">
                <span>No.Registrasi : {{$dataRegistrasi[0]['no_registrasi']}}</span>
            </h4>
			<div class="panel-heading-btn">
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
							<a data-toggle="tab" href="#card-tab-1">
								<img src="{{asset('/assets/img/halal/has.png')}}" width="40%" alt=""  /> 
							</a>
							
							<a class="nav-link active" data-toggle="tab" href="#card-tab-1">Dokumen</a>
						</li>
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-7">
								<img src="{{asset('/assets/img/halal/kantor.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-7">Kantor Pusat</a>
						</li>
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-8">
								<img src="{{asset('/assets/img/halal/menu.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-8">Menu Restoran</a>
						</li>
						@endif
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-2">
								<img src="{{asset('/assets/img/halal/fasilitas-1.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-2">Fasilitas</a>
						</li>
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 3 || $dataRegistrasi[0]['id_jenis_registrasi'] == 4 )
						<li class="nav-item text-center">
							@if($dataRegistrasi[0]['id_jenis_registrasi'] == 4)
							<a data-toggle="tab" href="#card-tab-3">
								<img src="{{asset('/assets/img/halal/servis.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-3">Servis</a>
							@else
							<a data-toggle="tab" href="#card-tab-3">
								<img src="{{asset('/assets/img/halal/produk-1.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-3">Produk</a>
							@endif
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-4">
								<img src="{{asset('/assets/img/halal/material-1.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-4">Material</a>
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 1 || $dataRegistrasi[0]['id_jenis_registrasi'] == 2 )
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-5">
								<img src="{{asset('/assets/img/halal/matriks.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-5">Matriks Produk</a>
						</li>
						@endif
						@if($dataRegistrasi[0]['id_jenis_registrasi'] == 3 )
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-9">
								<img src="{{asset('/assets/img/halal/penyembelih.png')}}" width="40%" alt="" /> 
							</a>
							<a class="nav-link" data-toggle="tab" href="#card-tab-9">Jagal</a>
						</li>
						@endif
						<li class="nav-item text-center">
							<a data-toggle="tab" href="#card-tab-6">
								<img src="{{asset('/assets/img/halal/kuesioner.png')}}" width="40%" alt="" /> 
							</a>
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
								$fieldSudah = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:grey"></i></td>';
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
							</div>
							@if($dataHas !== null)
								@foreach($dataHas as $has => $value)
									<form action="{{route('updatestatushas',["id" => $value['id']])}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
										@csrf
										@method('PUT')
								@endforeach()	
							@else
								<form action="#" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
									@csrf
							@endif
								<table id="hasTable" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Nama Dokumen</th>
											<th width="1%" class="text-nowrap valign-middle text-center">File</th>
											@if($dataHas !== null)
											<th class="text-nowrap valign-middle text-center" style="width: 120px;">&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;</th>
											@endif
											<th width="20%" class="text-nowrap valign-middle text-center">Catatan</th>
										</tr>
									</thead>
									<tbody>
										
									@if($dataHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="valign-middle">Sertifikat Halal Sebelumnya (Registrasi Perpanjangan/Pengembangan)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">2</td>
											<td class="valign-middle" style="word-wrap:break-word">Manual SJPH (untuk Registrasi Baru/Perpanjangan dan Pendaftaran Pengembangan dengan Status SJH B)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
																			<tr class="odd">
											<td class="text-nowrap valign-middle text-center">3</td>
											<td class="text-nowrap valign-middle">Status SJPH atau Sertifikat SJH (untuk Registrasi Pengembangan/Perpanjangan)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">4</td>
											<td class=" valign-middle">Flow process chart of halal certified products</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">5</td>
											<td class="valign-middle">Pernyataan fasilitas bebas dari babi dan turunannya (untuk registrasi baru atau fasilitas baru)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">6</td>
											<td class=" valign-middle">Daftar alamat seluruh fasilitas produksi (termasuk gerai, dapur, gudang dan kantor pusat)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">7</td>
											<td class=" valign-middle">Bukti diseminasi/sosialisasi kebijakan halal (untuk registrasi baru atau fasilitas baru)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">8</td>
											<td class="valign-middle">Bukti pelaksanaan pelatihan internal SJPH (untuk registrasi baru atau fasilitas baru)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>

										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">9</td>
											<td class="valign-middle">Bukti pelaksanaan Audit Internal (untuk registrasi baru atau fasilitas baru)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">10</td>
											<td class="valign-middle">Izin usaha (untuk registrasi baru atau untuk fasilitas baru)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">11</td>
											<td class="valign-middle">Bukti registrasi dari BPJPH</td>
											
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">12</td>
											<td class="valign-middle">Denah/ Tata letak ruang produksi</td>
											{!! $buttonUnduhDisabled !!}
											<td class=" valign-middle"/>
										</tr>
									@else
											@foreach($dataHas as $has => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">1</td>
													<td class="valign-middle">Sertifikat Halal Sebelumnya (Registrasi Perpanjangan/Pengembangan)</td>
													@if($value['has_1'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_1']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_1" name="status_has_1" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_1"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_1"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_1"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td >
														<input class="form-control" id="keterangan_has_1" type="text" name="keterangan_has_1" value={{$value['keterangan_has_1']}}>
														</input>
														

													</td>
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">2</td>
													<td class="valign-middle">Manual SJPH (untuk Registrasi Baru/Perpanjangan dan Pendaftaran Pengembangan dengan Status SJH B)</td>
													@if($value['has_2'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_2']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_2" name="status_has_2" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_2"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_2"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_2"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td >
														<input type="text" class="form-control" name="keterangan_has_2" value={{$value["keterangan_has_2"]}} ></input>
													</td>
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">3</td>
													<td class="text-nowrap valign-middle">Status SJPH atau Sertifikat SJH (untuk Registrasi Pengembangan/Perpanjangan)</td>
													@if($value['has_3'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_3']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_3" name="status_has_3" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_3"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_3"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_3"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td >
														<input type="text" class="form-control" name="keterangan_has_3" value={{$value['keterangan_has_3']}} >
														</input>
													</td>
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">4</td>
													<td class="valign-middle">Flow process chart of halal certified products</td>
													@if($value['has_4'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_4']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_4" name="status_has_4" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_4"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_4"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_4"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_4" value={{$value['keterangan_has_4']}} ></input></td>
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">5</td>
													<td class="valign-middle">Pernyataan fasilitas bebas dari babi dan turunannya (untuk registrasi baru atau fasilitas baru)</td>
													@if($value['has_5'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_5']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_5" name="status_has_5" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_5"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_5"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_5"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control"  name="keterangan_has_5" value={{$value['keterangan_has_5']}}  ></input></td>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">6</td>
													<td class="valign-middle">Daftar alamat seluruh fasilitas produksi (termasuk gerai, dapur, gudang dan kantor pusat)</td>
													@if($value['has_6'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_6']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_6" name="status_has_6" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_6"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_6"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_6"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control"  name="keterangan_has_6" value={{$value['keterangan_has_6']}} ></input></td>
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">7</td>
													<td class="valign-middle">Bukti diseminasi/sosialisasi kebijakan halal (untuk registrasi baru atau fasilitas baru)</td>
													@if($value['has_7'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_7']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_7" name="status_has_7" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_7"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_7"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_7"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_7" value={{$value['keterangan_has_7']}} ></input></td>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">8</td>
													<td class="valign-middle">Bukti pelaksanaan pelatihan internal SJPH (untuk registrasi baru atau fasilitas baru)</td>
													@if($value['has_8'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_8']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_8" name="status_has_8" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_8"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_8"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_8"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_8" value={{$value['keterangan_has_8']}} ></input></td>
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">9</td>
													<td class="valign-middle">Bukti pelaksanaan Audit Internal (untuk registrasi baru atau fasilitas baru)</td>
													@if($value['has_9'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_9']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_9" name="status_has_9" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_9"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_9"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_9"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_9" value={{$value['keterangan_has_9']}} ></input></td>
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">10</td>
													<td class=" valign-middle">Izin usaha (untuk registrasi baru atau untuk fasilitas baru)</td>
													@if($value['has_10'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_10']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_10" name="status_has_10" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_10"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_10"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_10"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_10" value={{$value['keterangan_has_10']}}></input></td>
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">11</td>
													<td class="valign-middle">Bukti registrasi dari BPJPH</td>
													@if($value['has_11'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_11']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_11" name="status_has_11" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_11"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_11"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_11"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_11" value={{$value['keterangan_has_11']}} ></input></td>
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">12</td>
													<td class="valign-middle">Denah/ Tata letak ruang produksi</td>
													@if($value['has_12'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/HAS/'.$value['has_12']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_12" name="status_has_12" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_12"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_12"] == 1 ? 'selected' : ''}}>Approve</option>
						                                    <option value="2" {{$value["status_has_12"] == 2 ? 'selected' : ''}}>Reject</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_12" value={{$value['keterangan_has_12']}} ></input></td>
												</tr>
											@endforeach()
										@endif
									</tbody>
								</table>
								
							</form>	
						</div>
						<div class="tab-pane fade" id="card-tab-7">
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
							<table id="menuRestoranTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Menu Restoran</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-2">
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
							<table id="produkTable" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				                <thead>
				                    <tr>
				                        <th class="text-nowrap valign-middle text-center">No</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Fasilitas</th>
				                        <th class="text-nowrap valign-middle text-center">Nama Produk</th>
				                        <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>
				                    </tr>
				                </thead>
				            </table>
						</div>
						<div class="tab-pane fade" id="card-tab-4">
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
							<form action="{{route('storematriksproduk')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
								@csrf
								<table  class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="10%" class="text-nowrap valign-middle text-center">No Registrasi</th>
											<th width="10%" class="text-nowrap valign-middle text-center">Status</th>
										</tr>
									</thead>
									<tbody>
										@if($dataMatriksProduk == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="text-nowrap valign-middle text-center">{{$dataRegistrasi[0]['no_registrasi']}}</td>
											{!! $buttonUnduhDisabled !!}
										</tr>
										@else
											@foreach($dataMatriksProduk as $matriks => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">1</td>
													<td class="text-nowrap valign-middle text-center">{{$dataRegistrasi[0]['no_registrasi']}}</td>
													<td class="text-nowrap valign-middle text-center"><a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/MATRIKSPRODUK/'.$value['matriks_produk']) }}" class="btn btn-primary btn-xs" download>unduh</a></td>
												</tr>
											@endforeach
										@endif	
									</tbody>
								</table>
							</form>
						</div>
						<div class="tab-pane fade" id="card-tab-9">
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
                                                <td class="valign-middle text-left">
                                                    Apakah perusahaan pemohon sertifikasi adalah distributor (bukan produsen/manufacturer)?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_1" id="kuis11" value="1" disabled/>
                                                        <label for="kuis11">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_1" id="kuis12" value="0" disabled/>
                                                        <label for="kuis12">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class="text-nowrap valign-middle text-center">2</td>
                                                <td class="valign-middle text-left">
                                                    Jika jawaban pada poin 1 Ya, apakah perusahaan pemohon merupakan satu grup dengan produsen/manufacturer?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_2" id="kuis21" value="1" disabled/>
                                                        <label for="kuis21">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_2" id="kuis22" value="0" disabled/>
                                                        <label for="kuis22">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="text-nowrap valign-middle text-center">3</td>
                                                <td class=" valign-middle text-left">
                                                    Apakah perusahaan pemohon melakukan proses pelabelan ulang (relabeling) atau pengemasan ulang (repacking)?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_3" id="kuis31" value="1" disabled/>
                                                        <label for="kuis31">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_3" id="kuis32" value="0" disabled/>
                                                        <label for="kuis32">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class="text-nowrap valign-middle text-center">4</td>
                                                <td class=" valign-middle text-left">
                                                    Selain menghasilkan produk yang disertifikasi, apakah pabrik juga menghasilkan produk yang tidak disertifikasi?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_4" id="kuis41" value="1" disabled/>
                                                        <label for="kuis41">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_4" id="kuis42" value="0" disabled/>
                                                        <label for="kuis42">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="text-nowrap valign-middle text-center">5</td>
                                                <td class=" valign-middle text-left">
                                                    Jika jawaban pada poin 4 Ya, apakah ada penggunaan fasilitas produksi dan peralatan pembantu yang sama untuk produk yang disertifikasi dan produk yang tidak disertifikasi?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_5" id="kuis51" value="1" disabled/>
                                                        <label for="kuis51">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_5" id="kuis52" value="0" disabled/>
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
                                                        <input type="radio" name="kuis_6" id="kuis61" value="1" disabled/>
                                                        <label for="kuis61">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_6" id="kuis62" value="0" disabled/>
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
                                                <td class=" valign-middle text-left">
                                                    Apakah perusahaan pemohon sertifikasi adalah distributor (bukan produsen/manufacturer)?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_1" id="kuis11" value="1" {{$value['kuis_1'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis11">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_1" id="kuis12" value="0" {{$value['kuis_1'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis12">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class="text-nowrap valign-middle text-center">2</td>
                                                <td class=" valign-middle text-left">
                                                    Jika jawaban pada poin 1 Ya, apakah perusahaan pemohon merupakan satu grup dengan produsen/manufacturer?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_2" id="kuis21" value="1" {{$value['kuis_2'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis21">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_2" id="kuis22" value="0" {{$value['kuis_2'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis22">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="text-nowrap valign-middle text-center">3</td>
                                                <td class=" valign-middle text-left">
                                                    Apakah perusahaan pemohon melakukan proses pelabelan ulang (relabeling) atau pengemasan ulang (repacking)?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_3" id="kuis31" value="1" {{$value['kuis_3'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis31">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_3" id="kuis32" value="0" {{$value['kuis_3'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis32">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class="text-nowrap valign-middle text-center">4</td>
                                                <td class=" valign-middle text-left">
                                                    Selain menghasilkan produk yang disertifikasi, apakah pabrik juga menghasilkan produk yang tidak disertifikasi?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_4" id="kuis41" value="1" {{$value['kuis_4'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis41">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_4" id="kuis42" value="0" {{$value['kuis_4'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis42">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td class="text-nowrap valign-middle text-center">5</td>
                                                <td class=" valign-middle text-left">
                                                    Jika jawaban pada poin 4 Ya, apakah ada penggunaan fasilitas produksi dan peralatan pembantu yang sama untuk produk yang disertifikasi dan produk yang tidak disertifikasi?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_5" id="kuis51" value="1" {{$value['kuis_5'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis51">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_5" id="kuis52" value="0" {{$value['kuis_5'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis52">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class="text-nowrap valign-middle text-center">6</td>
                                                <td class="text-center valign-middle text-left">
                                                    Jika jawaban pada poin 5 Ya, apakah ada penggunaan bahan dari babi atau turunannya?
                                                </td>
                                                <td class="text-nowrap valign-middle text-center">
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_6" id="kuis61" value="1" {{$value['kuis_6'] == 1 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis61">Ya</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" name="kuis_6" id="kuis62" value="0" {{$value['kuis_6'] == 0 ? 'checked' : ''}} disabled/>
                                                        <label for="kuis62">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    @endif  
								</table>
							</form>	
						</div>
					</div>
				</div>
			</div>

			<div class=" offset-md-5">
                @component('components.buttonback',['href' => route("listregistrasipelangganaktif")])@endcomponent
               
				@if($dataHas !== null)
					<button type="submit" class="btn btn-md btn-lime offset-md-1" style="z-index: 100;">Submit</button>
				@endif
				
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
	<script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
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
                        return `<a href="{{url('fasilitas_detail')}}/`+full.id_registrasi+`/`+full.id+`" class="btn btn-lime btn-xs" >&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_fasilitas')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
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
                }
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_produk')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
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
                        return `<a href="{{url('material_detail')}}/`+full.id_registrasi+`/`+full.id+`" class="btn btn-green btn-xs" >&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_material')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
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
                        return `<a href="{{url('kantor_pusat_detail')}}/`+full.id_registrasi+`/`+full.id+`" class="btn btn-lime btn-xs" >&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_kantor_pusat')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
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
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_menu_restoran')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
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
                        return `<a href="{{url('jagal_detail')}}/`+full.id_registrasi+`/`+full.id+`" class="btn btn-lime btn-xs" >&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:'{{url('data_jagal')}}'+'/'+'<?php echo $dataRegistrasi[0]['id'] ;?>',
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        "searching": false,
            order:[[0,'asc']]
        });

	</script>
@endpush