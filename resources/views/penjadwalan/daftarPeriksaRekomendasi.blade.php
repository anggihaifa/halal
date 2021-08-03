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
		<li class="breadcrumb-item"><a href="#">Technical Review</a></li>
		<li class="breadcrumb-item"><a href="#">List Technical Review</a></li>
        <li class="breadcrumb-item active">Daftar Periksa Dan Rekomendasi</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Daftar Periksa Dan Rekomendasi</h1>
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
            @if (Auth::user()->usergroup_id == 11 || Auth::user()->usergroup_id == 12 || Auth::user()->usergroup_id == 13)
            <div class="card-header tab-overflow p-t-0 p-b-0">
                <ul class="nav nav-tabs card-header-tabs">                                                
                    <li class="nav-item text-center">                        
                        <a class="nav-link active" data-toggle="tab" href="#card-tab-1">Form Daftar Periksa dan Rekomendasi</a>
                    </li>                    
                    <li class="nav-item text-center">  
                        @if (Auth::user()->usergroup_id == 11 || Auth::user()->usergroup_id == 12)
                            <a class="nav-link" data-toggle="tab" href="#card-tab-2">Upload Form</a>
                        @else
                            <a class="nav-link" data-toggle="tab" href="#card-tab-3">Upload Form</a>
                        @endif                        
                    </li>                    
                </ul>
            </div>
            @endif

		
			
			<div class="card-body table-responsive">
					<div class="tab-content p-0 m-0">
						<div class="tab-pane fade active show" id="card-tab-1">
							@php
								$regId = Auth::user()->registrasi_id;
								$fieldSudah = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:#2fca2f"></i></td>';
								$fieldBelum = '<td class="text-nowrap valign-middle text-center"><i class="fas fa-upload" style="color:grey"></i></td>';
								$buttonUnduhDisabled = '<td class="valign-middle text-center"><a href="#" ><i class="fa fa-eye" style="color:grey;"></i></a></td>';
								$buttonUnduh = '<td class="valign-middle text-center"><a href="#"><i class="fa fa-eye"></i></a></td>';
						
							@endphp
							
							{{-- <h5>Dokumen Lengkap</h5> --}}
																
							<form action="{{route('uploaddaftarperiksarekomendasi')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
								@method('POST')
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['label' => 'Nama Pelaku Usaha','required'=>true,'placeholder'=>'Nama Pelaku Usaha', 'value'=>$dataRegis[0]['nama_perusahaan'],'name'=>'nama_perusahaan','readonly'=>'true'])@endcomponent                                            
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12" style="display: none">
                                        <div class="row">
                                            @component('components.inputtext',['label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi', 'value'=>$dataRegis[0]['id'],'name'=>'id_registrasi','readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Nomor ID BPJPH','required'=>true,'placeholder'=>'Nomor ID BPJPH','name'=>'nomor_id_bpjph','value'=>$dataRegis[0]['no_registrasi_bpjph'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Jenis Produk','required'=>true,'placeholder'=>'Jenis Produk','name'=>'jenis_produk', 'value'=>$dataRegis[0]['kelompok_produk'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
                                        <div class="row">
											@component('components.inputtext',['label' => 'Tanggal Audit','required'=>true,'placeholder'=>'Tanggal Audit','name'=>'mulai_audit1', 'value'=>$dataRegis[0]['mulai_audit1'].' s/d '.$dataRegis[0]['selesai_audit2'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>
									<div class="wrapper col-lg-12">
										@php
											if($dataRegis[0]['pelaksana1_audit2']){
												$str =  explode("_",$dataRegis[0]['pelaksana1_audit2']);
												$dataRegis[0]['pelaksana1_audit2'] = $str[1];
											}
											if($dataRegis[0]['pelaksana2_audit2']){
												$str2 =  explode("_",$dataRegis[0]['pelaksana2_audit2']);
												$dataRegis[0]['pelaksana2_audit2'] = $str2[1];
											}																																
										@endphp
                                        <div class="row">
											@component('components.inputtext',['label' => 'Tim Audit','required'=>true,'placeholder'=>'Ketua Tim Audit','name'=>'pelaksana1_audit1', 'value'=>$dataRegis[0]['pelaksana1_audit2'].' & '.$dataRegis[0]['pelaksana2_audit2'],'readonly'=>'true'])@endcomponent
                                        </div>
                                    </div>

                                    <table class="table table-bordered table-td-valign-middle table-sm table-responsive" cellspacing="0" style="width:100%; overflow: hidden">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" width="1%" class="text-nowrap valign-middle text-center">No</th>
                                                <th rowspan="2" width="30%" class="text-nowrap valign-middle text-center">Materi</th>
                                                <th rowspan="2" width="1%" class="text-nowrap valign-middle text-center">Materi</th>
                                                <th colspan="3" width="38%" class="text-nowrap valign-middle text-center">Technical Review</th>
                                                <th rowspan="2" width="30%" class="text-nowrap valign-middle text-center">Catatan Komite Sertifikasi</th>
                                            </tr>
                                            <tr>                                                                                                
                                                <th width="10%" class="text-nowrap valign-middle text-center">Ada</th>
                                                <th width="10%" class="text-nowrap valign-middle text-center">Tidak Ada</th>
                                                <th width="19%" class="text-nowrap valign-middle text-center">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">1</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Penawaran Harga</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_akad'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                    
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/penawaran_harga') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">                                                        
                                                        <input type="radio" name="rbpenawaran" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status1'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : ''}}/>

                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbpenawaran" value='{{$dataPeriksaRekomendasi[0]['status1']}}' hidden>
                                                        @endif                                                        
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">                                                        
                                                        <input type="radio" name="rbpenawaran" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status1'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : ''}}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">                                                    
                                                    <textarea name="capenawaran" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan1'] != null ? $dataPeriksaRekomendasi[0]['catatan1'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">2</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Konfirmasi Jadwal, Syarat & Ketentuan Audit</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_konfirmasi_sk_audit'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                    
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/konfirmasi_sk') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkonfirmasi" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status2'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }} {{Auth::user()->usergroup_id == 13 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbkonfirmasi" value='{{$dataPeriksaRekomendasi[0]['status2']}}' hidden>
                                                        @endif                                                        
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">                                                        
                                                        <input type="radio" name="rbkonfirmasi" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status2'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">                                                    
                                                    <textarea name="cakonfirmasi" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan2'] != null ? $dataPeriksaRekomendasi[0]['catatan2'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">3</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Surat Tugas</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_surat_tugas'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                        
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/surat_tugas') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbst" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status3'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbst" value='{{$dataPeriksaRekomendasi[0]['status3']}}' hidden>
                                                        @endif                                                        
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbst" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status3'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="cast" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan3'] != null ? $dataPeriksaRekomendasi[0]['catatan3'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">4</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Audit Plan</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_rencana_audit'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                        
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/audit_plan') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbap" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status4'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbap" value='{{$dataPeriksaRekomendasi[0]['status4']}}' hidden>
                                                        @endif                                                        
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbap" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status4'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caap" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan4'] != null  ? $dataPeriksaRekomendasi[0]['catatan4'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">5</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Laporan Audit Tahap 1</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_laporan_audit1'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                    
                                                        <a class="btn btn-xs" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/laporan_audit_tahap1') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit1" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status5'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbaudit1" value='{{$dataPeriksaRekomendasi[0]['status5']}}' hidden>
                                                        @endif                                                        
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit1" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status5'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caaudit1" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan5'] != null ? $dataPeriksaRekomendasi[0]['catatan5'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="caaudit1_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan5_2'] != null ? $dataPeriksaRekomendasi[0]['catatan5_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="caaudit1_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan5_2'] != null ? $dataPeriksaRekomendasi[0]['catatan5_2'] : '' }}</textarea>                                                        
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">6</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Laporan Audit Tahap 2</label>
                                                </td>     
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_laporan_audit_tahap_2'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                    
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/laporan_audit_tahap2') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>                                           
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">a. Laporan Bahan dan Kelengkapan Dokumen Pendukungya</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    {{-- <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/laporan_bahan') }}"><i class="fa fa-eye text-primary"></i></a> --}}
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2a" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6a'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbaudit2a" value='{{$dataPeriksaRekomendasi[0]['status6a']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2a" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6a'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caaudit2a" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan6a'] != null ? $dataPeriksaRekomendasi[0]['catatan6a'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="caaudit2a_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan6a_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6a_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="caaudit2a_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan6a_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6a_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">b.	Laporan Fasilitas Produksi</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    {{-- <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/'.$dataRegis[0]['file_akad'].'') }}"><i class="fa fa-eye text-primary"></i></a> --}}
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2b" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6b'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbaudit2b" value='{{$dataPeriksaRekomendasi[0]['status6b']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2b" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6b'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caaudit2b" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan6b'] != null ? $dataPeriksaRekomendasi[0]['catatan6b'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="caaudit2b_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan6b_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6b_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="caaudit2b_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan6b_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6b_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">c.	Laporan Ruang Lingkup Produk yang disertifikasi beserta Kelengkapannya</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    {{-- <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/'.$dataRegis[0]['file_akad'].'') }}"><i class="fa fa-eye text-primary"></i></a> --}}
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2c" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6c'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbaudit2c" value='{{$dataPeriksaRekomendasi[0]['status6c']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2c" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6c'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caaudit2c" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan6c'] != null ? $dataPeriksaRekomendasi[0]['catatan6c'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="caaudit2c_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan6c_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6c_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="caaudit2c_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan6c_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6c_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">d.	Laporan SJPH</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    {{-- <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/'.$dataRegis[0]['file_akad'].'') }}"><i class="fa fa-eye text-primary"></i></a> --}}
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2d" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6d'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbaudit2d" value='{{$dataPeriksaRekomendasi[0]['status6d']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbaudit2d" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status6d'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caaudit2d" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan6d'] != null ? $dataPeriksaRekomendasi[0]['catatan6d'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="caaudit2d_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan6d_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6d_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="caaudit2d_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan6d_2'] != null ? $dataPeriksaRekomendasi[0]['catatan6d_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">7</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Berita Acara Pemeriksaan</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_bap'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/bap') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbap" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status7'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbbap" value='{{$dataPeriksaRekomendasi[0]['status7']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbap" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status7'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="cabap" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan7'] != null ? $dataPeriksaRekomendasi[0]['catatan7'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="cabap_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan7_2'] != null ? $dataPeriksaRekomendasi[0]['catatan7_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="cabap_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan7_2'] != null ? $dataPeriksaRekomendasi[0]['catatan7_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">8</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Berita Acara Pengambilan Sampel</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_bap_sampel'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/baps') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                                                                        
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbaps" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status8'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbbaps" value='{{$dataPeriksaRekomendasi[0]['status8']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbaps" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status8'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="cabaps" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan8'] != null ? $dataPeriksaRekomendasi[0]['catatan8'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="cabaps_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan8_2'] != null ? $dataPeriksaRekomendasi[0]['catatan8_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="cabaps_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan8_2'] != null ? $dataPeriksaRekomendasi[0]['catatan8_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">9</label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Daftar Hadir Opening & Closing Meeting</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_daftar_hadir'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else                                                    
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/daftarHadir') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                                                                                                                            
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbdh" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status9'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbdh" value='{{$dataPeriksaRekomendasi[0]['status9']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbdh" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status9'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="cadh" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan9'] != null ? $dataPeriksaRekomendasi[0]['catatan9'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle">
                                                    @if (Auth::user()->usergroup_id == 13)
                                                        <textarea name="cadh_ks" type="text" class="form-control" placeholder="Catatan">{{$dataPeriksaRekomendasi[0]['catatan9_2'] != null ? $dataPeriksaRekomendasi[0]['catatan9_2'] : '' }}</textarea>
                                                    @else
                                                        <textarea name="cadh_ks" type="text" class="form-control" placeholder="Catatan" disabled>{{$dataPeriksaRekomendasi[0]['catatan9_2'] != null ? $dataPeriksaRekomendasi[0]['catatan9_2'] : '' }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">10</label>
                                                </td>
                                                <td class="valign-middle" colspan="5">
                                                    <label class=" control-label font-weight-bold" for="id">Pelaksanaan Sidang Komisi Fatwa</label>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">a.	Surat Permohonan Sidang Fatwa Halal</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_surat_permohonan_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/suratPermohonan') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfa" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10a'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskfa" value='{{$dataPeriksaRekomendasi[0]['status10a']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfa" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10a'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskfa" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10a'] != null ? $dataPeriksaRekomendasi[0]['catatan10a'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">b.	Daftar Hadir Sidang Fatwa Halal</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_daftar_hadir_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/daftarHadirSidang') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfb" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10b'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskfb" value='{{$dataPeriksaRekomendasi[0]['status10b']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfb" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10b'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskfb" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10b'] != null ? $dataPeriksaRekomendasi[0]['catatan10b'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">c.	Berita Acara Sidang Fatwa Halal</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_berita_acara_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/beritaAcaraSidang') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfc" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10c'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskfc" value='{{$dataPeriksaRekomendasi[0]['status10c']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfc" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10c'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskfc" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10c'] != null ? $dataPeriksaRekomendasi[0]['catatan10c'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">d.	Tanda Terima Dokumen dan Sampel</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_tanda_terima_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/tandaTerima') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfd" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10d'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskfd" value='{{$dataPeriksaRekomendasi[0]['status10d']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfd" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10d'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskfd" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10d'] != null ? $dataPeriksaRekomendasi[0]['catatan10d'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">e.	Keputusan Fatwa MUI</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_keputusan_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/keputusanFatwa') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfe" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10e'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }} />
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskfe" value='{{$dataPeriksaRekomendasi[0]['status10e']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskfe" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10e'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskfe" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10e'] != null ? $dataPeriksaRekomendasi[0]['catatan10e'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id"></label>
                                                </td>
                                                <td class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">f.	Dokumentasi Sidang Fatwa (foto pelaksanaan)</label>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    @if ($dataRegis[0]['file_dokumentasi_sidang'] == null)
                                                        <a class="btn btn-xs" disabled><i class="fa fa-eye text-grey"></i></a>
                                                    @else
                                                        <a class="btn btn-xs" target="blank_" href="{{ url('penjadwalan_viewer_berkas/'.$dataRegis[0]['id'].'/'.$dataRegis[0]['id_user'].'/dokumentasiSidang') }}"><i class="fa fa-eye text-primary"></i></a>
                                                    @endif                                                    
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskff" value="ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10f'] == 'ada' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <input type="text" name="rbskff" value='{{$dataPeriksaRekomendasi[0]['status10f']}}' hidden>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbskff" value="tidak ada" style="cursor: pointer;" {{$dataPeriksaRekomendasi[0]['status10f'] == 'tidak ada' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle">
                                                    <textarea name="caskff" type="text" class="form-control" placeholder="Catatan" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'readonly' : '' }}>{{$dataPeriksaRekomendasi[0]['catatan10f'] != null ? $dataPeriksaRekomendasi[0]['catatan10f'] : '' }}</textarea>
                                                </td>
                                                <td class="valign-middle" style="background: gray">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" rowspan="5" class="valign-middle">
                                                    <label class=" control-label font-weight-bold" for="id">Rekomendasi</label>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="valign-middle">
                                                    <div class="row">
                                                        {{-- @if (Auth::user()->name == $dataRegis[0]['pelaksana1_audit2'])
                                                            @php
                                                                $nama_rekomen = $dataRegis[0]['pelaksana1_audit2'];
                                                            @endphp
                                                        @elseif(Auth::user()->name == $dataRegis[0]['pelaksana2_audit2'])
                                                            @php
                                                                $nama_rekomen = $dataRegis[0]['pelaksana2_audit2'];
                                                            @endphp
                                                        @endif --}}

                                                        @if($dataPeriksaRekomendasi[0]['nama_rekomendasi_tr'] != null)
                                                            @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>$dataPeriksaRekomendasi[0]['nama_rekomendasi_tr'],'name'=>'nama_tr','readonly'=>'true'])@endcomponent
                                                        @else
                                                            @if (Auth::user()->usergroup_id == 11 || Auth::user()->usergroup_id == 12)
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>Auth::user()->name,'name'=>'nama_tr','readonly'=>'true'])@endcomponent
                                                            @else
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>'','name'=>'nama_tr','readonly'=>'true'])@endcomponent
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td colspan="4" class="valign-middle">
                                                    <div class="row">
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            @if($dataPeriksaRekomendasi[0]['nama_rekomendasi_ks'] != null)
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>$dataPeriksaRekomendasi[0]['nama_rekomendasi_ks'],'name'=>'nama_ks','readonly'=>'true'])@endcomponent
                                                            @else
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>Auth::user()->name,'name'=>'nama_ks','readonly'=>'true'])@endcomponent
                                                            @endif
                                                        @else
                                                            @if($dataPeriksaRekomendasi[0]['nama_rekomendasi_ks'] != null)
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>$dataPeriksaRekomendasi[0]['nama_rekomendasi_ks'],'name'=>'nama_ks','readonly'=>'true', 'disabled'=>'true'])@endcomponent
                                                            @else
                                                                @component('components.inputtext',['label' => 'Nama :','required'=>true,'placeholder'=>'Nama', 'value'=>'','name'=>'nama_ks','readonly'=>'true', 'disabled'=>'true'])@endcomponent
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="valign-middle">                                                    
                                                    <div class="row">                                                        
                                                        <label class="col-lg-4 col-form-label">Tanggal</label>
                                                        <div id="shb" class="col-lg-8">
                                                            <div class="input-group date">
                                                                <input type="text" id="tanggal_rekomendasi" name="tanggal_rekomendasi_tr" class="form-control" placeholder="Tanggal" value='{{$dataPeriksaRekomendasi[0]['tgl_rekomendasi_tr'] != null ? $dataPeriksaRekomendasi[0]['tgl_rekomendasi_tr'] : '' }}' data-date-start-date="Date.default" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                                @if (Auth::user()->usergroup_id == 13)
                                                                    <input type="text" id="tanggal_rekomendasi" name="tanggal_rekomendasi_tr" class="form-control" placeholder="Tanggal" value='{{$dataPeriksaRekomendasi[0]['tgl_rekomendasi_tr'] != null ? $dataPeriksaRekomendasi[0]['tgl_rekomendasi_tr'] : '' }}' data-date-start-date="Date.default" hidden/>
                                                                @endif
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="3" class="valign-middle">
                                                    <div class="row">
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <label class="col-lg-4 col-form-label">Tanggal</label>
                                                            <div id="shb" class="col-lg-8">
                                                                <div class="input-group date">
                                                                    <input type="text" id="tanggal_rekomendasi2" name="tanggal_rekomendasi_ks" class="form-control" value='{{$dataPeriksaRekomendasi[0]['tgl_rekomendasi_ks'] != null ? $dataPeriksaRekomendasi[0]['tgl_rekomendasi_ks'] : '' }}' placeholder="Tanggal" data-date-start-date="Date.default" />
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <label class="col-lg-4 col-form-label">Tanggal</label>
                                                            <div id="shb" class="col-lg-8">
                                                                <div class="input-group date">
                                                                    <input type="text" id="tanggal_rekomendasi2" name="tanggal_rekomendasi_ks" class="form-control" value='{{$dataPeriksaRekomendasi[0]['tgl_rekomendasi_ks'] != null ? $dataPeriksaRekomendasi[0]['tgl_rekomendasi_ks'] : '' }}' placeholder="Tanggal" data-date-start-date="Date.default" disabled/>
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="valign-middle"> 
                                                    <div id="shb" class="col-lg-12">
                                                        <div class="input-group date">
                                                            <div class="radio radio-css radio-inline">                                         
                                                                <input type="radio" name="kesiapanrekomen_tr" value="siap" style="cursor: pointer;" id="siap" {{$dataPeriksaRekomendasi[0]['status_rekomendasi_tr'] == 'siap' ? 'checked' : '' }} required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                                <label for="siap">Siap</label>                                                                
                                                            </div>
                                                            <div class="radio radio-css radio-inline">                                         
                                                                <input type="radio" name="kesiapanrekomen_tr" value="belum siap" style="cursor: pointer;" id="tidaksiap" {{$dataPeriksaRekomendasi[0]['status_rekomendasi_tr'] == 'belum siap' ? 'checked' : '' }} {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/> 
                                                                <label for="tidaksiap">Belum Siap</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (Auth::user()->usergroup_id == 13)                                                                
                                                        <input type="text" name="kesiapanrekomen_tr" value='{{$dataPeriksaRekomendasi[0]['status_rekomendasi_tr']}}' style="cursor: pointer;" id="siap" required hidden/>
                                                    @endif
                                                    <label class="col-lg-12 col-form-label">lanjut ke tahapan berikutnya</label>
                                                </td>
                                                <td colspan="3" class="valign-middle">
                                                    <div class="row">
                                                        @if (Auth::user()->usergroup_id == 13)
                                                            <div id="shb" class="col-lg-12">
                                                                <div class="input-group date">           
                                                                    <div class="radio radio-css radio-inline">                                         
                                                                        <input type="radio" name="kesiapanrekomen_ks" value="siap" style="cursor: pointer;" id="siap2" {{$dataPeriksaRekomendasi[0]['status_rekomendasi_ks'] == 'siap' ? 'checked' : '' }} required/> 
                                                                        <label for="siap2">Siap</label>
                                                                    </div>
                                                                    <div class="radio radio-css radio-inline">                                         
                                                                        <input type="radio" name="kesiapanrekomen_ks" value="belum siap" style="cursor: pointer;" id="tidaksiap2" {{$dataPeriksaRekomendasi[0]['status_rekomendasi_ks'] == 'belum siap' ? 'checked' : '' }}/> 
                                                                        <label for="tidaksiap2">Belum Siap</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label class="col-lg-12 col-form-label">diajukan ke Sidang Komisi Fatwa</label>
                                                        @else
                                                            <div id="shb" class="col-lg-12">
                                                                <div class="input-group date">           
                                                                    <div class="radio radio-css radio-inline">                                         
                                                                        <input type="radio" name="kesiapanrekomen_ks" value="siap" style="cursor: pointer;" id="siap2" disabled {{$dataPeriksaRekomendasi[0]['status_rekomendasi_ks'] == 'siap' ? 'checked' : '' }} required/> 
                                                                        <label for="siap2">Siap</label>
                                                                    </div>
                                                                    <div class="radio radio-css radio-inline">                                         
                                                                        <input type="radio" name="kesiapanrekomen_ks" value="belum siap" style="cursor: pointer;" id="tidaksiap2" {{$dataPeriksaRekomendasi[0]['status_rekomendasi_ks'] == 'belum siap' ? 'checked' : '' }} disabled/> 
                                                                        <label for="tidaksiap2">Tidak Siap</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label class="col-lg-12 col-form-label">diajukan ke Sidang Komisi Fatwa</label>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td colspan="4" class="valign-middle"> 
                                                    <label class="col-lg-12 col-form-label">Lanjut ke tahapan </label>
                                                    <div id="shb" class="col-lg-12">
                                                        <div class="input-group date">
                                                            <div class="radio radio-css radio-inline">                                         
                                                                <input type="radio" name="kesiapansidang_tr" value="ks" style="cursor: pointer;" id="ks" required {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/>
                                                                <label for="ks">Komite Sertifikasi</label>                                                                
                                                            </div>
                                                            <div class="radio radio-css radio-inline">                                         
                                                                <input type="radio" name="kesiapansidang_tr" value="sidang" style="cursor: pointer;" id="sidang" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 ? 'disabled' : '' }}/> 
                                                                <label for="sidang">Persiapan Sidang</label>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </td>
                                                <td colspan="3" class="valign-middle">                                                    
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class=" offset-md-5">
                                    <a type="button"  href="{{url()->previous()}}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-md btn-lime offset-md-1" style="z-index: 100;" {{Auth::user()->usergroup_id != 11 && Auth::user()->usergroup_id != 12 && Auth::user()->usergroup_id != 13 ? 'hidden' : '' }} onclick= "return confirm('Apakah anda yakin ?? Jika Siap maka proses akan dilanjutkan ke tahapan berikutnya, apabila belum siap maka akan dikembalikan ke proses audit tahap 2')">Submit</button>
                                </div>		
                            </form>
						</div>
                        <div class="tab-pane fade show" id="card-tab-2">
                        
                                    <form action="{{route('storelaporantr')}}" method="post"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                                                                    
                        
                                            <div class = "modal-body">
                                                
                        
                                                <div>
                                                    <table class="table  table-sm table-borderless border-none">
                                                    
                                                        <thead class="table-success">   
                                                        <th >Upload File</th>
                        
                                                        </thead>
                                                        <tbody>
                                                            <tr style="display:none">
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class="control-label font-weight-bold" for="id">ID</label>  
                                                                    <div >
                                                                        <input id="id"  name="id" type="text" placeholder="" class="form-control " readonly>
                                                                    
                                                                    </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class=" control-label font-weight-bold" for="id">Review Laporan Audit</label>  
                                                                    <div >
                                                                        <input id="file_laporan_tr"  name="file_laporan_tr" type="file" placeholder="" >
                                                                    
                                                                    </div>
                                                                    </div
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                        
                                                </div>
                        
                                                <div>
                                                    <table class="table  table-sm table-borderless border-none">
                                                    
                                                        <thead class="table-success">   
                                                        <th >Hasil Technical Review Review</th>
                        
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class=" control-label font-weight-bold" for="id">Catatan Technical Review</label>  
                                                                        <div >
                                                                            <input type="text" id="catatan_tr" class="form-control"  name="catatan_tr" placeholder="" >
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class=" control-label font-weight-bold" for="id">Hasil</label>  
                                                                    <select id="status_laporan_tr" name="status_laporan_tr" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" requied>
                                                                        <option value="">==Pilih==</option>
                                                                        <option value="1">Lanjut Ke Tahapan Berikutnya</option>
                                                                        <option value="0">Perbaikan</option>                                                               
                                                                    </select>
                                                                    </div
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                        
                                                </div>
                        
                                            <div>
                                                <table class="table  table-sm">
                                                
                                                    <thead class="table-success">   
                                                    <th >Apakah Membutuhkan Tahapan Komite Sertifikasi ?</th>
                        
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select id="status_lanjut_ks" name="status_lanjut_ks" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" requied>
                                                                    <option value="">==Pilih==</option>
                                                                    <option value="1">Ya</option>
                                                                    <option value="0">Tidak, Lanjutkan Persiapan Sidang Fatwa Halal</option>                                                               
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                                    
                                            </div>
                        
                                              
                                            </div>
                                         
                                            <div class = "modal-footer">
                                                <div >
                                                    <button class="btn btn-sm btn-success" type="submit" >Submit</button>
                                                
                                                </div>
                                            </div>
                                        
                                    </form>
                                                                                                                                                       
                        </div>
                        <div class="tab-pane fade show" id="card-tab-3">                                                    
                                    <form action="{{route('storelaporanks')}}" method="post"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                        
                                            <div class = "modal-body">
                                                
                        
                                                <div>
                                                    <table class="table  table-sm table-borderless border-none">
                                                    
                                                        <thead class="table-success">   
                                                        <th >Upload File</th>
                        
                                                        </thead>
                                                        <tbody>
                                                            <tr style="display:none">
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class="control-label font-weight-bold" for="id">ID</label>  
                                                                    <div >
                                                                        <input id="id"  name="id" type="text" placeholder="" class="form-control " readonly>
                                                                    
                                                                    </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class=" control-label font-weight-bold" for="id">File Tinjauan Komite Sertifikasi</label>  
                                                                    <div >
                                                                        <input id="file_laporan_tinjauan"  name="file_laporan_tinjauan" type="file" placeholder="" >
                                                                    
                                                                    </div>
                                                                    </div
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                        
                                                </div>
                        
                                                <div>
                                                    <table class="table  table-sm table-borderless border-none">
                                                    
                                                        <thead class="table-success">   
                                                        <th >Hasil Tinjauan Komite Sertifikasi</th>
                        
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class=" control-label font-weight-bold" for="id">Catatan Tinjauan Komite Sertifikasi</label>  
                                                                        <div >
                                                                            <input type="text" id="catatan_tinjauan" class="form-control"  name="catatan_tinjauan" placeholder="" >
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <label class=" control-label font-weight-bold" for="id">Hasil</label>  
                                                                    <select id="status_laporan_tinjauan" name="status_laporan_tinjauan" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                                                        <option value="">==Pilih==</option>
                                                                        <option value="1">Lanjut Ke Tahapan Bertikutnya</option>
                                                                        <option value="0">Perbaikan</option>                                                               
                                                                    </select>
                                                                    </div
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                        
                                                </div>
                        
                        
                        
                                              
                                            </div>
                                         
                                            <div class = "modal-footer">
                                                <div >
                                                    <button class="btn btn-sm btn-success" type="submit" >Submit</button>
                                                
                                                </div>
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
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
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


			if(h1 == '2' && h2 == '2'&& h3 == '2'&& h4== '2'&& h5 == '2'&& h6 == '2'&& h7 == '2'&& h8 == '2'&& h9 == '2'&& h10 == '2'&& h11 == '2'&& h12 == '2'&& h13 == '2'&& h14 == '2'&& h15 == '2'&& h16 == '2'){

		  		$("#tidak_memenuhi").prop('checked', true);
				//$("#catatan_akhir_audit").removeAttr()('readonly');
		  	}else{
		  		
		  		$("#memenuhi").prop('checked', true);
		  		
		  	}
		});

        $(document).ready(
            function() {

                $('#tanggal_rekomendasi').datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                });

                $('#tanggal_rekomendasi2').datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                });
            }
        );

		

	</script>
@endpush