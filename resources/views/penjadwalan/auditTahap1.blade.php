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
	<h1 class="page-header">Unggah Data Sertifikasi  <small>{{$dataRegis[0]['nama_perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
			<h4 class="panel-title" style="margin-left:5px">
                <span>No.Registrasi : {{$dataRegis[0]['no_registrasi']}}</span>
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
								$buttonUnduh = '<td class="valign-middle text-center"><a href="#"><i class="fa fa-eye"></i></a></td>';
						
							@endphp
							
							<h5>Dokumen Lengkap</h5>
																
							@foreach($dataHas as $has => $value)
								<form action="{{route('updatestatusaudittahap1',$laporanAudit1[0]['id'])}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
							@endforeach
								@csrf
								@method('PUT')

								<div class="panel-body panel-form">
									<div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['label' => 'Tujuan Audit','required'=>true,'placeholder'=>'Tujuan Audit','name'=>'tujuan_audit'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Lokasi Audit','required'=>true,'placeholder'=>'Lokasi Audit','name'=>'lokasi_audit'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Lingkup Audit','required'=>true,'placeholder'=>'Lingkup Audit','name'=>'lingkup_audit', 'value'=>$dataRegis[0]['ruang_lingkup'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Tanggal Audit','required'=>true,'placeholder'=>'Tanggal Audit','name'=>'mulai_audit1', 'value'=>$dataRegis[0]['mulai_audit1'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
										@php
											if($dataRegis[0]['pelaksana1_audit1']){
												$str =  explode("_",$dataRegis[0]['pelaksana1_audit1']);
												$dataRegis[0]['pelaksana1_audit1'] = $str[1];
											}
											if($dataRegis[0]['pelaksana2_audit1']){
												$str2 =  explode("_",$dataRegis[0]['pelaksana2_audit1']);
												$dataRegis[0]['pelaksana2_audit1'] = $str2[1];
											}
											
										
											
										@endphp
										
											
										

                                        <div class="row">
											@component('components.inputtext',['label' => 'Ketua Tim Audit','required'=>true,'placeholder'=>'Ketua Tim Audit','name'=>'pelaksana1_audit1', 'value'=>$dataRegis[0]['pelaksana1_audit1'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
									
											@component('components.inputtext',['label' => 'Auditor','required'=>true,'placeholder'=>'Auditor','name'=>'pelaksana2_audit1', 'value'=>$dataRegis[0]['pelaksana2_audit1'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
                                    
	
								<table id="hasTable" class="table  table-bordered table-td-valign-middle table-sm table-responsive" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th width="1%" class="text-nowrap valign-middle text-center">No</th>
											<th width="50%" class="text-nowrap valign-middle text-center">Nama Dokumen</th>
											<th width="1%" class="text-nowrap valign-middle text-center">File</th>
											@if($dataHas !== null)
											<th class="text-nowrap valign-middle text-center" style="width: 120px;">&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;</th>
											@endif
											<th width="20%" class="valign-middle text-center">Deskripsi Temuan dan Tanggal Pemeriksaan Awal</th>
											<th width="1%" class="valign-middle text-center">Tanggal Penyerahan Tambahan/ Perbaikan  Dokumen</th>
											<th width="30%" class="valign-middle text-center">Pemeriksaan Tambahan/ Perbaikan Dokumen dan Tanggal </th>
										</tr>
									</thead>
									<tbody>

									@if($dataHas == null)
										<input type="text" name="status" value="0" readonly hidden>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">1</td>
											<td class="valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">2</td>
											<td class="valign-middle" style="word-wrap:break-word">Matriks Bahan Vs Produk</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">3</td>
											<td class="text-nowrap valign-middle">Data Produk Yang Dihasilkan</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">4</td>
											<td class=" valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">5</td>
											<td class="valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">6</td>
											<td class=" valign-middle">Sertifikat Halal Sebelumnya (Jika Ada)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">7</td>
											<td class=" valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										<tr class="even">
											<td class="text-nowrap valign-middle text-center">8</td>
											<td class="valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang </td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">9</td>
											<td class="valign-middle">Diagram Alir Proses Untuk Produk Yang Disertifikasi</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">10</td>
											<td class="valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="odd">
											<td class="text-nowrap valign-middle text-center">11</td>
											<td class="valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)*Dilampirkan Aspek Legal Perusahaan (NIB dan NPWP)</td>
											
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">12</td>
											<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">13</td>
											<td class="valign-middle">Bukti Sertifikat Pelatihan Penyelia Halal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">14</td>
											<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">15</td>
											<td class="valign-middle">Bukti Pelaksanaan Audit Internal</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">16</td>
											<td class="valign-middle">Bukti Pelaksanaan Kaji Ulang Manajemen</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">17</td>
											<td class="valign-middle">Informasi Layout Lokasi Produksi</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										<tr class="even">
											<td class="text-nowrap valign-middle text-center">18</td>
											<td class="valign-middle">Bukti Registrasi Dari BPJPH</td>
											{!! $buttonUnduhDisabled !!}
											<td></td>
											<td></td>
											<td></td>

										</tr>
										
									@else
										@foreach($dataHas as $has => $value)
											<input type="text" name="status" value="1" readonly hidden>
											<input type="text" name="id" value="{{$laporanAudit1[0]['id']}}" readonly hidden>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">1</td>
												<td class="valign-middle">Manual Sistem Jaminan Produk Halal (SJPH)</td>
												@if($value['has_1'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_1')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_1" name="status_has_1" class="form-control selectpicker" data-size="10" data-live-search="true"@if($laporanAudit1[0]["status_has_1"] == 1) data-style="btn-green btn-sm";@elseif($laporanAudit1[0]["status_has_1"] == 3) data-style="btn-grey btn-sm";@elseif($laporanAudit1[0]["status_has_1"] == 2) data-style="btn-red btn-sm";@else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_1"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_1"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_1"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_1"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>

													</select>
												</td>
												<td >
													<textarea class="form-control" id="keterangan_has_1" type="text" name="keterangan_has_1"> {{$laporanAudit1[0]['keterangan_has_1']}}
													</textarea>
													

												</td>
												<td>
												<input class="form-control" id="tgl_penyerahan_1" type="text" name="tgl_penyerahan_1" value='{{$laporanAudit1[0]['tgl_penyerahan_1']}}' style="font-size:8px;width:100px" readonly>
													</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_1" type="text" name="review_perbaikan_1" >{{$laporanAudit1[0]['review_perbaikan_1']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">2</td>
												<td class="valign-middle">Matriks Baham vs Produk</td>
												@if($value['has_2'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_2')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_2" name="status_has_2" class="form-control selectpicker" data-size="10" data-live-search="true"@if($laporanAudit1[0]["status_has_2"] == 1) data-style="btn-green btn-sm";@elseif($laporanAudit1[0]["status_has_2"] == 3) data-style="btn-grey btn-sm";@elseif($laporanAudit1[0]["status_has_2"] == 2) data-style="btn-red btn-sm";@else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_2"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_2"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_2"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_2"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td >
													<textarea type="text" id="keterangan_has_2" class="form-control" name="keterangan_has_2" >{{$laporanAudit1[0]['keterangan_has_2']}}</textarea>
												</td>
												<td>
													<input class="form-control" id="tgl_penyerahan_2" type="text" name="tgl_penyerahan_2" value='{{$laporanAudit1[0]['tgl_penyerahan_2']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_2" type="text" name="review_perbaikan_2" >{{$laporanAudit1[0]['review_perbaikan_2']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">3</td>
												<td class="text-nowrap valign-middle">Data Produk Yang Dihasilkan Sendiri</td>
												@if($value['has_3'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_3')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_3" name="status_has_3" class="form-control selectpicker" data-size="10" data-live-search="true"@if($laporanAudit1[0]["status_has_3"] == 1) data-style="btn-green btn-sm";@elseif($laporanAudit1[0]["status_has_3"] == 3) data-style="btn-grey btn-sm";@elseif($laporanAudit1[0]["status_has_3"] == 2) data-style="btn-red btn-sm";@else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_3"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_3"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_3"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_3"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td >
													<textarea type="text" class="form-control" id="keterangan_has_3" name="keterangan_has_3" >{{$laporanAudit1[0]['keterangan_has_3']}}
													</textarea>
												</td>
												<td>
													<input class="form-control" id="tgl_penyerahan_3" type="text" name="tgl_penyerahan_3" value='{{$laporanAudit1[0]['tgl_penyerahan_3']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
												<textarea class="form-control" type="text" name="review_perbaikan_3" >{{$laporanAudit1[0]['review_perbaikan_3']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">4</td>
												<td class="valign-middle">Data Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
												@if($value['has_4'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_4')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_4" name="status_has_4" class="form-control selectpicker" data-size="10" data-live-search="true"@if($laporanAudit1[0]["status_has_4"] == 1) data-style="btn-green btn-sm";@elseif($laporanAudit1[0]["status_has_4"] == 3) data-style="btn-grey btn-sm";@elseif($laporanAudit1[0]["status_has_4"] == 2) data-style="btn-red btn-sm";@else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_4"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_4"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_4"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_4"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_4" name="keterangan_has_4" >{{$laporanAudit1[0]['keterangan_has_4']}}
													</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_4" type="text" name="tgl_penyerahan_4" value='{{$laporanAudit1[0]['tgl_penyerahan_4']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_4" type="text" name="review_perbaikan_4" >{{$laporanAudit1[0]['review_perbaikan_4']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">5</td>
												<td class="valign-middle">Data Bahan Baku, Bahan Tambahan dan Bahan Penolong</td>
												@if($value['has_5'] !== null)
												<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_5')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_5" name="status_has_5" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_5"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_5"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_5"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_5"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_5"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_5"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_5"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control"  id="keterangan_has_5" name="keterangan_has_5">{{$laporanAudit1[0]['keterangan_has_5']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_5" type="text" name="tgl_penyerahan_5" value='{{$laporanAudit1[0]['tgl_penyerahan_5']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_5" type="text" name="review_perbaikan_5" >{{$laporanAudit1[0]['review_perbaikan_5']}}
													</textarea>
													

												</td>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">6</td>
												<td class="valign-middle">Sertifikat Halal Sebelumnya (Jika Ada)</td>
												@if($value['has_6'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_6')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_6" name="status_has_6" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_6"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_6"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_6"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_6"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_6"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_6"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_6"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_6"  name="keterangan_has_6">{{$laporanAudit1[0]['keterangan_has_6']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_6" type="text" name="tgl_penyerahan_6" value='{{$laporanAudit1[0]['tgl_penyerahan_6']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_6" type="text" name="review_perbaikan_6" >{{$laporanAudit1[0]['review_perbaikan_6']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">7</td>
												<td class="valign-middle">Copy Sertifikat Halal Pada Produk Konsinyasi/Titipan (Khusus Restoran/Catering)</td>
												@if($value['has_7'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_7')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_7" name="status_has_7" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_1"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_1"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_1"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_7"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_7"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_7"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_7"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_7" name="keterangan_has_7" >{{$laporanAudit1[0]['keterangan_has_7']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_7" type="text" name="tgl_penyerahan_7" value='{{$laporanAudit1[0]['tgl_penyerahan_7']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_7" type="text" name="review_perbaikan_7" >{{$laporanAudit1[0]['review_perbaikan_7']}}
													</textarea>
													

												</td>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">8</td>
												<td class="valign-middle">Informasi Formula/Resep Produk Tanpa Gramasi Yang Disahkan Oleh Personil Yang Berwenang</td>
												@if($value['has_8'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_8')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_8" name="status_has_8" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_8"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_8"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_8"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_8"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_8"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_8"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_8"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_8" name="keterangan_has_8" >{{$laporanAudit1[0]['keterangan_has_8']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_8" type="text" name="tgl_penyerahan_8" value='{{$laporanAudit1[0]['tgl_penyerahan_8']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_8" type="text" name="review_perbaikan_8" >{{$laporanAudit1[0]['review_perbaikan_8']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">9</td>
												<td class="valign-middle">Diagram Alir Proses Untuk Produk Yang disertifikasi</td>
												@if($value['has_9'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_9')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_9" name="status_has_9" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_9"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_9"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_9"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_9"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_9"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_9"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_9"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_9" name="keterangan_has_9" >{{$laporanAudit1[0]['keterangan_has_9']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_9" type="text" name="tgl_penyerahan_9" value='{{$laporanAudit1[0]['tgl_penyerahan_9']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_9" type="text" name="review_perbaikan_9" >{{$laporanAudit1[0]['review_perbaikan_9']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="even">
												<td class="text-nowrap valign-middle text-center">10</td>
												<td class="valign-middle">Pernyataan Dari Pemilik Fasilitas Produksi Bahwa Fasilitas Produksi (Termasuk Peralatan Pembantu) Tidak Digunakan Secara Bergantian Untuk Proses Produk Halal Dengan Produk  Yang Mengandung Babi/Turunannya</td>
												@if($value['has_10'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_10')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_10" name="status_has_10" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_10"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_10"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_10"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_10"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_10"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_10"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_10"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_10" name="keterangan_has_10" >{{$laporanAudit1[0]['keterangan_has_10']}}</textarea></td>

												<td>
													<input class="form-control" id="tgl_penyerahan_10" type="text" name="tgl_penyerahan_10" value='{{$laporanAudit1[0]['tgl_penyerahan_10']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_10" type="text" name="review_perbaikan_10" >{{$laporanAudit1[0]['review_perbaikan_10']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">11</td>
												<td class="valign-middle">Daftar Alamat  Seluruh Fasilitas Produksi Yang Terlibat Dalam Proses Produk Halal, Termasuk Pabrik Sendiri/Makloon, Gudang Bahan/Produk Intermediet, Fasilitas Praproduksi (Penimbangan, Pencampuran, Pengeringan, Dll), Kantor Pusat (Jika Ada Aktivitas Kritis Seperti Pembelian, R&D)<br><b>*dilampirkan aspek legal perusahaan (NIB dan NPWP)</b></td>
												@if($value['has_11'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_11')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_11" name="status_has_11" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_11"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_11"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_11"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_11"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_11"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_11"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_11"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_11" name="keterangan_has_11" >{{$laporanAudit1[0]['keterangan_has_11']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_11" type="text" name="tgl_penyerahan_11" value='{{$laporanAudit1[0]['tgl_penyerahan_11']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_11" type="text" name="review_perbaikan_11" >{{$laporanAudit1[0]['review_perbaikan_11']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">12</td>
												<td class="valign-middle">Bukti Sosialisasi Dan Komunikasi Kebijakan Halal Kepada Seluruh Pihak Terkait</td>
												@if($value['has_12'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_12')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_12" name="status_has_12" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_12"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_12"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_12"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_12"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_12"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_12"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_12"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_12" name="keterangan_has_12" >{{$laporanAudit1[0]['keterangan_has_12']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_12" type="text" name="tgl_penyerahan_12" value='{{$laporanAudit1[0]['tgl_penyerahan_12']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_12" type="text" name="review_perbaikan_12" >{{$laporanAudit1[0]['review_perbaikan_12']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">13</td>
												<td class="valign-middle">Bukti Sertifikat Pelatihan Penyelia Halal</td>
												@if($value['has_13'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_13')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_13" name="status_has_13" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_13"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_13"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_13"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_13"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_13"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_13"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_13"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_13" name="keterangan_has_13" >{{$laporanAudit1[0]['keterangan_has_13']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_13" type="text" name="tgl_penyerahan_13" value='{{$laporanAudit1[0]['tgl_penyerahan_13']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_13" type="text" name="review_perbaikan_13" >{{$laporanAudit1[0]['review_perbaikan_13']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">14</td>
												<td class="valign-middle">Bukti Pelaksanaan Pelatihan Internal</td>
												@if($value['has_14'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_14')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_14" name="status_has_14" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_14"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_14"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_14"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_14"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_14"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_14"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_14"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_14" name="keterangan_has_14" >{{$laporanAudit1[0]['keterangan_has_14']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_14" type="text" name="tgl_penyerahan_14" value='{{$laporanAudit1[0]['tgl_penyerahan_14']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_14" type="text" name="review_perbaikan_14" >{{$laporanAudit1[0]['review_perbaikan_14']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">15</td>
												<td class="valign-middle">Bukti Pelaksanaan Audit Internal</td>
												@if($value['has_15'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_15')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_15" name="status_has_15" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_15"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_15"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_15"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_15"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_15"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_15"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_15"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_15" name="keterangan_has_15" >{{$laporanAudit1[0]['keterangan_has_15']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_15" type="text" name="tgl_penyerahan_15" value='{{$laporanAudit1[0]['tgl_penyerahan_15']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_15" type="text" name="review_perbaikan_15" >{{$laporanAudit1[0]['review_perbaikan_15']}}
													</textarea>
													

												</td>
											</tr>
											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">16</td>
												<td class="valign-middle">Bukti Pelaksanaan Kaji Ulang Manajemen</td>
												@if($value['has_16'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_16')}}"><i class="fa fa-eye"></i></a></td>
												@else
													{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_16" name="status_has_16" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_16"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_16"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_16"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_16"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_16"] == 1 ? 'selected' : ''}}>Memenuhi</option>
					                                    <option value="2" {{$laporanAudit1[0]["status_has_16"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
					                                    <option value="3" {{$laporanAudit1[0]["status_has_16"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_16" name="keterangan_has_16" >{{$laporanAudit1[0]['keterangan_has_16']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_16" type="text" name="tgl_penyerahan_16" value='{{$laporanAudit1[0]['tgl_penyerahan_16']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_16" type="text" name="review_perbaikan_16" >{{$laporanAudit1[0]['review_perbaikan_16']}}
													</textarea>
													

												</td>
											</tr>

											<tr class="even">
												<td class="text-nowrap valign-middle text-center">17</td>
												<td class="valign-middle">Informasi Layout Lokasi Produksi</td>
												@if($value['has_17'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_17')}}"><i class="fa fa-eye"></i></a></td>
												@else
												{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_17" name="status_has_17" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_17"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_17"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_17"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_17"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_17"] == 1 ? 'selected' : ''}}>Memenuhi</option>
														<option value="2" {{$laporanAudit1[0]["status_has_17"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
														<option value="3" {{$laporanAudit1[0]["status_has_17"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_17" name="keterangan_has_17" >{{$laporanAudit1[0]['keterangan_has_17']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_17" type="text" name="tgl_penyerahan_17" value='{{$laporanAudit1[0]['tgl_penyerahan_17']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_17" type="text" name="review_perbaikan_17" >{{$laporanAudit1[0]['review_perbaikan_17']}}
													</textarea>


												</td>
											</tr>

											<tr class="odd">
												<td class="text-nowrap valign-middle text-center">18</td>
												<td class="valign-middle">Bukti Registrasi dari BPJPH</td>
												@if($value['has_18'] !== null)
													<td class="text-nowrap valign-middle text-center"><a href="{{url('penjadwalan_viewer/'.$laporanAudit1[0]['id_registrasi'].'/has_18')}}"><i class="fa fa-eye"></i></a></td>
												@else
												{!! $buttonUnduhDisabled !!}
												@endif
												<td>
													<select id="status_has_18" name="status_has_18" class="form-control selectpicker" data-size="10" data-live-search="true" @if($laporanAudit1[0]["status_has_18"] == 1) data-style="btn-green btn-sm"; @elseif($laporanAudit1[0]["status_has_18"] == 3) data-style="btn-grey btn-sm"; @elseif($laporanAudit1[0]["status_has_18"] == 2) data-style="btn-red btn-sm"; @else data-style="btn-white btn-sm" @endif>
														<option value="" {{$laporanAudit1[0]["status_has_18"] == null ? 'selected' : ''}}>Belum Diperiksa</option>
														<option value="1" {{$laporanAudit1[0]["status_has_18"] == 1 ? 'selected' : ''}}>Memenuhi</option>
														<option value="2" {{$laporanAudit1[0]["status_has_18"] == 2 ? 'selected' : ''}}>Tidak Memenuhi</option>
														<option value="3" {{$laporanAudit1[0]["status_has_18"] == 3 ? 'selected' : ''}}>Tidak Relevan</option>
													</select>
												</td>
												<td ><textarea type="text" class="form-control" id="keterangan_has_18" name="keterangan_has_18" >{{$laporanAudit1[0]['keterangan_has_18']}}</textarea></td>
												<td>
													<input class="form-control" id="tgl_penyerahan_18" type="text" name="tgl_penyerahan_18" value='{{$laporanAudit1[0]['tgl_penyerahan_18']}}' style="font-size:8px;width:100px" readonly>
														</input></td>

												<td >
													<textarea class="form-control" id="review_perbaikan_18" type="text" name="review_perbaikan_18" >{{$laporanAudit1[0]['review_perbaikan_18']}}
													</textarea>


												</td>
											</tr>

										@endforeach
									@endif
									</tbody>
								</table>

								<div style="margin-bottom:10px;">
									<div>
										<label><b>Catatan:</b></label>

										<label><b>Organisasi/ Pelaku usaha harus menyerahkan tambahan/ perbaikan dokumen kepada LPH dengan tembusan kepada BPJPH dalam jangka waktu paling lama 5 (lima) hari kerja sejak permintaan tambahan dokumen diterima. Apabila melebihi dari 5 hari kerja maka permohonan sertifikat halal tidak dapat diproses lebih lanjut.</b></label>
									</div>
									<div class="radio radio-css ">
                                        <input type="radio" name="status_memenuhi" id="memenuhi" value="memenuhi" checked/>
                                        <label for="memenuhi"><b>Audit Tahap II dapat dilaksanakan</b></label>
                                    </div>

                                    <div class="radio radio-css ">
                                        <input  type="radio" name="status_memenuhi" id="tidak_memenuhi" value="tidak memenuhi" />
                                        <label for="tidak_memenuhi"><b>Audit Tahap II dapat dilaksanakan setelah semua tindak lanjut temuan sudah dinyatakan memenuhi, dengan batas maksimal penyerahan dokumen perbaikan 5 hari setelah pemeriksaan audit tahap 1</b></label>

                                    </div>

									
									<div>
										<label><b>Syarat Untuk Lanjut Ke Audit Tahap 2</b></label>
									</div>

									<div class="col-lg-12">
										
										<textarea class="col-lg-12" name="catatan_akhir_audit1" id="catatan_akhir_audit1" placeholder="Masukan catatan disini apabila pelaku usaha dapat lanjut ke tahap dua namun masih ada dokumen yang tidak memenuhi" ></textarea>
										

                                    </div>
								</div>
								<div class=" offset-md-5">
					               <a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
					                @if($dataHas !== null)
										<button type="submit" class="btn btn-md btn-lime offset-md-1" style="z-index: 100;" onclick="return confirm('Note: Catatan hanya boleh diisi apabila terdapat berkas yang tidak memenuhi namun akan dilanjutkan ke tahapan audit tahap 2')">Submit</button>

										
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
	<link href="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.css')}}" rel="stylesheet" />    
	<script type="text/javascript">

		$(document).ready(function() {
            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

            $('#keterangan_has_1, #keterangan_has_2, #keterangan_has_3, #keterangan_has_4, #keterangan_has_5, #keterangan_has_6, #keterangan_has_7, #keterangan_has_8, #keterangan_has_9, #keterangan_has_10, #keterangan_has_11, #keterangan_has_12, #keterangan_has_13, #keterangan_has_14, #keterangan_has_15, #keterangan_has_16, #keterangan_has_17, #keterangan_has_18, #review_perbaikan_1, #review_perbaikan_2, #review_perbaikan_3, #review_perbaikan_4, #review_perbaikan_5, #review_perbaikan_6, #review_perbaikan_7, #review_perbaikan_8, #review_perbaikan_9, #review_perbaikan_10, #review_perbaikan_11, #review_perbaikan_12, #review_perbaikan_13, #review_perbaikan_14, #review_perbaikan_15, #review_perbaikan_16, #review_perbaikan_17, #review_perbaikan_18').summernote({
                spellcheck: false,
                height: 350,                
            });			
		});		


		var dlDate = new Date();
		var numberOfDaysToAdd = 5;

		dlDate.setDate(dlDate.getDate() + numberOfDaysToAdd); 
		var dd = String(dlDate.getDate()).padStart(2, '0');
		var mm = String(dlDate.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = dlDate.getFullYear();

		dlDate = dd + '/' + mm + '/' + yyyy;

		

		$('#status_has_1, #status_has_2, #status_has_3, #status_has_4, #status_has_5, #status_has_6, #status_has_7, #status_has_8, #status_has_9, #status_has_10, #status_has_11, #status_has_12, #status_has_13, #status_has_14, #status_has_15, #status_has_16').on('change', function() {

			var h1 = $("#status_has_1").val();
			var h2 = $("#status_has_2").val();
			var h3 = $("#status_has_3").val();
			var h4 = $("#status_has_4").val();
			var h5 = $("#status_has_5").val();
			var h6 = $("#status_has_6").val();
			var h7 = $("#status_has_7").val();
			var h8 = $("#status_has_8").val();
			var h9 = $("#status_has_9").val();
			var h10 = $("#status_has_10").val();
			var h11 = $("#status_has_11").val();
			var h12 = $("#status_has_12").val();
			var h13 = $("#status_has_13").val();
			var h14 = $("#status_has_14").val();
			var h15 = $("#status_has_15").val();
			var h16 = $("#status_has_16").val();


			if(h1 == '2' || h2 == '2'|| h3 == '2'|| h4== '2'|| h5 == '2'|| h6 == '2'|| h7 == '2'|| h8 == '2'|| h9 == '2'|| h10 == '2'|| h11 == '2'|| h12 == '2'|| h13 == '2'|| h14 == '2'|| h15 == '2'|| h16 == '2'){

		  		$("#tidak_memenuhi").prop('checked', true);
				//$("#catatan_akhir_audit").removeAttr()('readonly');
		  	}else{
		  		
		  		$("#memenuhi").prop('checked', true);
		  		
		  	}
		});

		

	</script>
@endpush