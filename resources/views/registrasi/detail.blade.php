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
                            
                                {{-- @php
                                    $sh = $value['status_registrasi'] ? $value['status_halal'] : '-';
                                    $shb = $value['sh_berlaku'] ? $value['sh_berlaku'] : '-';
                                @endphp --}}
								<div class="container col-lg-12">
									<table cellpadding="10" border="0">
										<tr>
											<td colspan="3"><h4 style="color: #2980b9"><b> {{$value['name']}}</b> ({{$value['nama_perusahaan']}})</h4></td>
										</tr>
										<tr>
											<td><p><b>No. Registrasi : </b> {{$value['no_registrasi']}}</p></td>
											<td><p><b>No. Surat Permohonan Sertifikasi : </b> {{$value['no_registrasi_bpjph']}}</p></td>
											<td><p><b>Tanggal Registrasi : </b> {{$value['tgl_registrasi']}}</p></td>
											<td><p><b>Jenis Registrasi : </b> {{$value['jenis']}}</p></td>
										</tr>
										<tr>											
											<td><p><b>Status Registrasi : </b>{{$value['status_registrasi']}}</p></td>											
										</tr>										
										<tr>																						
											<td><p><b>Jenis Produk : </b>{{$value['kelompok']}}</p></td>
										</tr>										
										<tr>
											<span id="stat_val" style="display:none">{{$value['statusnya']}}</span>
											<td><p id="notif_user"></p></td>											
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
				
            </div>
						
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