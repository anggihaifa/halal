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

		
			<div class="table-responsive">
				<div class="tab-content p-0 m-0">

					<div class="tab-pane fade active show" id="card-tab-1">
							@php
								$regId = Auth::user()->registrasi_id;
								$fieldSudah = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:grey"></i></td>';
								$buttonUnduhDisabled = '<td class="valign-middle text-center"><a href="#" ><i class="fa fa-eye" style="color:grey;"></i></a></td>';
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
								<span style="margin-right: 5px; "><i class="ion-ios-paper" style="color:#ababab"></i> Belum diperiksa</span>
								<span style="margin-right: 5px;"><i class="ion-ios-paper" style="color:#2fca2f"></i> Sesuai</span>
								<span style="margin-right: 10px;"><i class="ion-ios-paper" style="color:#e46464"></i> Revisi</span>
							</div>

							@if($dataHas !== null)
								@foreach($dataHas as $has => $value)
								<form action="{{route('updatestatusverifikasi',$value['id'])}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
									@csrf
									@method('PUT')
								@endforeach()	
							@else
							<form action="#" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
									@csrf
							@endif

								<input type="text" id="has_selected" name="has_selected" hidden value="tes">
								
								<table id="hasTable" class="table  table-bordered table-td-valign-middle table-sm table-responsive" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="50%" class="text-nowrap valign-middle text-center">Nama Dokumen</th>
											<th width="1%" class="text-nowrap valign-middle text-center">File</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Aksi</th>
											<th width="20%" class="text-nowrap valign-middle text-center">Catatan</th>
											<th width="1%" class="text-nowrap valign-middle text-center">Unggah File</th>
											
										</tr>
									</thead>
									<tbody>
										
									@if($dataHas == null)
										
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												
												<form action="{{route('storedokumenhasadmin',$value['id'])}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
													@csrf
													@method('PUT')
													<input type="text" id="has_selected" name="has_selected" hidden value="tes">
													
													<input type="file" id="has_1" name="has_1">
													<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_1')" >Unggah
												</form>
												</button>
												
											</td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">2</td>
											<td class="valign-middle" style="word-wrap:break-word">Matriks Bahan</td>

											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_2" name="has_2">
												<button type="submit" id="btn_has2" class="btn btn-xs btn-primary" onclick="setHas('has_2')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">3</td>
											<td class="text-nowrap valign-middle">Data Produk Yang Dihasilkan</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_3" name="has_3">
												<button type="submit" id="btn_has3" class="btn btn-xs btn-primary" onclick="setHas('has_3')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">4</td>
											<td class=" valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_4" name="has_4">
												<button type="submit" id="btn_has4" class="btn btn-xs btn-primary" onclick="setHas('has_4')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">5</td>
											<td class="valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_5" name="has_5">
												<button type="submit" id="btn_has5" class="btn btn-xs btn-primary" onclick="setHas('has_5')" >Unggah
												</button>
											</td>
											
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">6</td>
											<td class=" valign-middle">Sertifikat Halal Sebelumnya</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_6" name="has_6">
												<button type="submit" id="btn_has6" class="btn btn-xs btn-primary" onclick="setHas('has_6')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">7</td>
											<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_7" name="has_7">
												<button type="submit" id="btn_has7" class="btn btn-xs btn-primary" onclick="setHas('has_7')" >Unggah
												</button>
											</td>
											
										<tr class="even">
											<td class="valign-middle text-center">8</td>
											<td class="valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang </td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_8" name="has_8">
												<button type="submit" id="btn_has8" class="btn btn-xs btn-primary" onclick="setHas('has_8')" >Unggah
												</button>
											</td>
											

										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">9</td>
											<td class="valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_9" name="has_9">
												<button type="submit" id="btn_has9" class="btn btn-xs btn-primary" onclick="setHas('has_9')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">10</td>
											<td class="valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_10" name="has_10">
												<button type="submit" id="btn_has10" class="btn btn-xs btn-primary" onclick="setHas('has_10')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">11</td>
											<td class="valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D <b>)*Dilampirkan Aspek Legal Perusahaan (NIB dan NPWP></b></td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_11" name="has_11">
												<button type="submit" id="btn_has11" class="btn btn-xs btn-primary" onclick="setHas('has_11')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">12</td>
											<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_12" name="has_12">
												<button type="submit" id="btn_has12" class="btn btn-xs btn-primary" onclick="setHas('has_12')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">13</td>
											<td class="valign-middle">Bukti Sertifikat Penyelia Halal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_13" name="has_13">
												<button type="submit" id="btn_has13" class="btn btn-xs btn-primary" onclick="setHas('has_13')" >Unggah
												</button>
											</td>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">14</td>
											<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_14" name="has_14">
												<button type="submit" id="btn_has14" class="btn btn-xs btn-primary" onclick="setHas('has_14')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">15</td>
											<td class="valign-middle">Bukti Pelaksaan Audit Internal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_15" name="has_15">
												<button type="submit" id="btn_has15" class="btn btn-xs btn-primary" onclick="setHas('has_15')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">16</td>
											<td class="valign-middle">Bukti Pelaksanaan Kaji Ulang Manajemen</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_16" name="has_16">
												<button type="submit" id="btn_has16" class="btn btn-xs btn-primary" onclick="setHas('has_16')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">17</td>
											<td class="valign-middle">Informasi Layout Lokasi Produksi</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_17" name="has_17">
												<button type="submit" id="btn_has15" class="btn btn-xs btn-primary" onclick="setHas('has_15')" >Unggah
												</button>
											</td>
											
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">18</td>
											<td class="valign-middle">Bukti Registrasi Dari BPJPH</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td class="valign-middle text-center">
												<input type="file" id="has_18" name="has_18">
												<button type="submit" id="btn_has16" class="btn btn-xs btn-primary" onclick="setHas('has_16')" >Unggah
												</button>
											</td>
											
										</tr>
									
									
										
									@else
											@foreach($dataHas as $has => $value)
												<input type="text" name="status" value="1" readonly hidden>
												<input type="text" name="id" value="{{$value['id']}}" readonly hidden>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">1</td>
													<td class="valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
													@if($value['has_1'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_1')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_1" name="status_has_1" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_1"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_1"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_1"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_1"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_1" value='{{$value['keterangan_has_1']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_1" name="has_1">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_1')" >Unggah
														</button>
														
													</td>
													
												</tr>
												
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">2</td>
													<td class="valign-middle">Matriks Bahan vs Produk </td>
													@if($value['has_2'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_2')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_2" name="status_has_2" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_2"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_2"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_2"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_2"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_2" value='{{$value['keterangan_has_2']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_2" name="has_2">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_2')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">3</td>
													<td class="text-nowrap valign-middle">Data Produk Yang Dihasilkan Sendiri</td>
													@if($value['has_3'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_3')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_3" name="status_has_3" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_3"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_3"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_3"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_3"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_3" value='{{$value['keterangan_has_3']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_3" name="has_3">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_3')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">4</td>
													<td class="valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
													@if($value['has_4'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_4')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													
													<td>
														<select id="status_has_4" name="status_has_4" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_4"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_4"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_4"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_4"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_4" value='{{$value['keterangan_has_4']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_4" name="has_4">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_4')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">5</td>
													<td class="valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
													@if($value['has_5'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_5')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_5" name="status_has_5" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_5"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_5"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_5"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_5"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_5" value='{{$value['keterangan_has_5']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_5" name="has_5">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_5')" >Unggah
														</button>
														
													</td>
												</tr>
													
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">6</td>
													<td class="valign-middle">Sertifikat Halal Sebelumnya (Jika Ada)</td>
													@if($value['has_6'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_6')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_6" name="status_has_6" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_6"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_6"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_6"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_6"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_6" value='{{$value['keterangan_has_6']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_6" name="has_6">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_6')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">7</td>
													<td class="valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
													@if($value['has_7'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_7')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_7" name="status_has_7" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_7"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_7"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_7"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_7"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_7" value='{{$value['keterangan_has_7']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_7" name="has_7">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_7')" >Unggah
														</button>
														
													</td>
												
												</tr>	
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">8</td>
													<td class="valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
													@if($value['has_8'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_8')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif
													
											
													<td>
														<select id="status_has_8" name="status_has_8" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_8"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_8"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_8"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_8"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_8" value='{{$value['keterangan_has_8']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_8" name="has_8">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_8')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">9</td>
													<td class="valign-middle">Diagram Alir Proses Untuk Produk Yang disertifikasi</td>
													@if($value['has_9'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_9')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_9" name="status_has_9" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_9"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_9"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_9"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_9"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_9" value='{{$value['keterangan_has_9']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_9" name="has_9">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_9')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">10</td>
													<td class="valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya</td>
													@if($value['has_10'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_10')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_10" name="status_has_10" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_10"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_10"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_10"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_10"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_10" value='{{$value['keterangan_has_10']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_10" name="has_10">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_10')" >Unggah
														</button>
														
													</td>
													
												</tr>

												<tr class="even">
													<td class="text-nowrap valign-middle text-center">11</td>
													<td class="valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D) <b>*) dilampirkan aspek legal perusahaan (NIB dan NPWP)</b></td>
													@if($value['has_11'] !== null)
														

														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_11')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_11" name="status_has_11" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_11"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_11"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_11"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_11"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_11" value='{{$value['keterangan_has_11']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_11" name="has_11">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_11')" >Unggah
														</button>
														
													</td>
													
												</tr>

												<tr class="even">
													<td class="text-nowrap valign-middle text-center">12</td>
													<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
													@if($value['has_12'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_12')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_12" name="status_has_12" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_12"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_12"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_12"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_12"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_12" value='{{$value['keterangan_has_12']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_12" name="has_12">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_12')" >Unggah
														</button>
														
													</td>
													
												</tr>

												<tr class="even">
													<td class="text-nowrap valign-middle text-center">13</td>
													<td class="valign-middle">Bukti Sertifikat Pelatihan Penyelia Halal</td>
													@if($value['has_13'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_13')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_13" name="status_has_13" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_13"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_13"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_13"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_13"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_13" value='{{$value['keterangan_has_13']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_13" name="has_13">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_13')" >Unggah
														</button>
														
													</td>
													
												</tr>

												<tr class="even">
													<td class="text-nowrap valign-middle text-center">14</td>
													<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
													@if($value['has_14'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_14')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_14" name="status_has_14" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_14"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_14"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_14"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_14"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_14" value='{{$value['keterangan_has_14']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_14" name="has_14">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_14')" >Unggah
														</button>
														
													</td>
													
												</tr>

												<tr class="even">
													<td class="text-nowrap valign-middle text-center">15</td>
													<td class="valign-middle">Bukti Pelaksanaan Audit Internal</td>
													@if($value['has_15'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_15')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_15" name="status_has_15" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_15"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_15"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_15"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_15"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_15" value='{{$value['keterangan_has_15']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_15" name="has_15">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_15')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">16</td>
													<td class="valign-middle">Bukti Pelaksanaan Kaji Ulang Manajemen</td>
													@if($value['has_16'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_16')}}"><i class="fa fa-eye"></i></a></td>
													@else
														{!! $buttonUnduhDisabled !!}
													@endif

													<td>
														<select id="status_has_16" name="status_has_16" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_16"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_16"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_16"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_16"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_16" value='{{$value['keterangan_has_16']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_16" name="has_16">
														<button type="submit" id="btn_has1" class="btn btn-xs btn-primary" onclick="setHas('has_16')" >Unggah
														</button>
														
													</td>
													
												</tr>
												<tr class="even">
													<td class="text-nowrap valign-middle text-center">17</td>
													<td class="valign-middle">Informasi Layout Lokasi Produksi</td>
													@if($value['has_17'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_17')}}"><i class="fa fa-eye"></i></a></td>
													@else
													{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_17" name="status_has_17" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_17"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_17"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_17"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_17"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_17" value='{{$value['keterangan_has_17']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_17" name="has_17">
														<button type="submit" id="btn_has17" class="btn btn-xs btn-primary" onclick="setHas('has_17')" >Unggah
														</button>
														
													</td>
												</tr>

												<tr class="odd">
													<td class="text-nowrap valign-middle text-center">18</td>
													<td class="valign-middle">Bukti Registrasi dari BPJPH</td>
													@if($value['has_18'] !== null)
														<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$value['id_registrasi'].'/has_18')}}"><i class="fa fa-eye"></i></a></td>
													@else
													{!! $buttonUnduhDisabled !!}
													@endif
													<td>
														<select id="status_has_18" name="status_has_18" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white btn-sm">
															<option value="" {{$value["status_has_18"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
															<option value="1" {{$value["status_has_18"] == 1 ? 'selected' : ''}}>Memenuhi</option>
															<option value="2" {{$value["status_has_18"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
															<option value="3" {{$value["status_has_18"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
														</select>
													</td>
													<td ><input type="text" class="form-control" name="keterangan_has_18" value='{{$value['keterangan_has_18']}}' ></input></td>
													<td class="valign-middle text-center">
														<input type="file" id="has_18" name="has_18">
														<button type="submit" id="btn_has18" class="btn btn-xs btn-primary" onclick="setHas('has_18')" >Unggah
														</button>
														
													</td>
													
												</tr>

											@endforeach
										@endif
									</tbody>
								</table>
								
								<div class=" offset-md-5">
					               <a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
					                @if($dataHas !== null)
										<button type="submit" class="btn btn-md btn-success " style="">Submit</button>
									@endif
									
					            </div>
								
								
								
									
								
							</form>	
						</div>
				</div>		
			</div>
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
		

        

		function setHas(d){

			var x = document.getElementById("has_selected");
			x.value = d;

			//console.log(x.value);

		}

	</script>
@endpush