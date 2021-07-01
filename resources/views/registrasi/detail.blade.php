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
											<span id="stat_val" style="display:none">{{$value['statusnya']}}</span>
											<td colspan="2"><h6><p id="notif_user"></p></h6></td>
											{{-- <td><p><b>No. Registrasi : </b> {{$value['no_registrasi']}}</p></td> --}}
										</tr>
										<tr>											
											<td colspan="2"><h5>Data Registrasi</h5></td>
										</tr>
										<tr>
											<td><p><b>Tanggal Registrasi : </b> <br>{{$value['tgl_registrasi']}}</p></td>
											<td><p><b>No. Pendaftaran BPJPH : </b> <br>{{$value['no_registrasi_bpjph']}}</p></td>
											<td><p><b>Status Registrasi : </b><br>{{$value['status_registrasi']}}</p></td>
											<td><p><b>Jenis Layanan : </b> <br>{{$value['jenis']}}</p></td>											
										</tr>
										<tr>											
											<td colspan="2"><h5>Data Perusahaan</h5></td>
										</tr>
										<tr>											
											<td><p><b>Alamat Perusahaan : </b><br>{{$value['alamat_perusahaan']}}</p></td>
											<td><p><b>Telepon Perusahaan : </b><br>{{$value['telepon_perusahaan']}}</p></td>
											<td><p><b>Alamat Pabrik : </b><br>{{$value['alamat_pabrik']}}</p></td>
											<td><p><b>Telepon Pabrik : </b><br>{{$value['telepon_pabrik']}}</p></td>
										</tr>
										<tr>
											<td><p><b>Contact Person : </b>{{$value['contact_person']}}</p></td>
											<td><p><b>Email : </b>{{$value['email']}}</p></td>											
										</tr>
										<tr>											
											<td colspan="2"><h5>Data KTP & NPWP</h5></td>
										</tr>
										<tr>
											<td colspan="2"><p><b>KTP</b></p></td>
											<td colspan="2"><p><b>NPWP</b></p></td>
										</tr>
										<tr>										
											<td colspan="2">
												<img src="{{url('') .Storage::url('ktp/'.$value['id'].'/'.$value['ktp']) }}" style="width: 30%">
												<br><a href="{{url('') .Storage::url('ktp/'.$value['id'].'/'.$value['ktp']) }}" download>Download KTP</a>
											</td>
											<td colspan="2">
												<img src="{{url('') .Storage::url('npwp/'.$value['id'].'/'.$value['npwp']) }}" style="width: 30%">
												<br><a href="{{url('') .Storage::url('npwp/'.$value['id'].'/'.$value['npwp']) }}" download>Download NPWP</a>
											</td>
										</tr>
										<tr>											
											<td colspan="2"><h5>Data Produk</h5></td>
										</tr>
										<tr>																						
											<td><p><b>Jenis Produk : </b><br>{{$value['kelompok']}}</p></td>
											<td><p><b>Rincian Jenis Produk : </b><br>{{$value['rincian_jenis_produk']}}</p></td>
											<td><p><b>Nama Merk : </b><br>{{$value['nama_merk_produk']}}</p></td>
											<td><p><b>Daerah Pemasaran : </b><br>{{$value['daerah_pemasaran']}}</p></td>
										</tr>
										<tr>											
										</tr>										
									</table>
								</div>																								                                                                								
							<div class="col-md-12 offset-md-5">
								{{-- @if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)
									<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
									<a href="{{route('exportdata')}}" class="btn bnt-sm btn-primary">Download Data</a>
								@else
									@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
								@endif	 --}}
								<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
							</div>
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