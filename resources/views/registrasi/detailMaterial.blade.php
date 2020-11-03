@extends('layouts.default')

@section('title', 'Detail Material')

@push('css')
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Detail Material</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Detail Material <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            @foreach($dataMaterial as $index => $value)
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<a href="#" class="btn btn-sm btn-lime active"></i>No. Registrasi : {{$dataRegistrasi[0]['no_registrasi']}}</a>
					<h4 class="panel-title" style="margin-left:5px"></h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
                    <form class="form-horizontal form-bordered" >
						<div class="form-group row label-detail">
                                @component('components.fordetail',['label' => 'Tipe Material','value'=>$value['tipe_material']])@endcomponent

                                @component('components.fordetail',['label' => 'Nama Material','value'=>$value['nama_material']])@endcomponent

								@component('components.fordetail',['label' => 'Produsen','value'=>$value['produsen']])@endcomponent                                

								@component('components.fordetail',['label' => 'Negara','value'=>$value['negara']])@endcomponent

								@component('components.fordetail',['label' => 'Pemasok','value'=>$value['pemasok']])@endcomponent

								@component('components.fordetail',['label' => 'Negara Pemasok','value'=>$value['negara_pemasok']])@endcomponent

								@component('components.fordetail',['label' => 'Lembaga Halal','value'=>$value['lembaga_halal']])@endcomponent

								@component('components.fordetail',['label' => 'No. Sertifikat','value'=>$value['no_sertifikat']])@endcomponent

								@component('components.fordetail',['label' => 'Tanggal Expired','value'=>$value['tanggal_exp']])@endcomponent

								@component('components.fordetail',['label' => 'Catatan','value'=>$value['catatan']])@endcomponent

								<label class="col-lg-4 col-form-label">File Material</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										@if($value['file_material'] == null)
											<a href="#" >-</a>
										@else
											<a href="{{url('') .Storage::url('public/uploadDokumen/'.$value['id_user'].'/'.$value['id_registrasi'].'/MATERIAL/'.$value['file_material']) }}" download>{{$value['file_material']}}</a>
										@endif
									</div>
								</div>
                                
                            
							<div class="col-md-12 offset-md-5">
								@if(Auth::user()->usergroup_id == 1 ||  Auth::user()->usergroup_id == 3)	
									@component('components.buttonback',['href' => route("detailunggahdatasertifikasi",$value['id_registrasi'])])@endcomponent
								@else
									@component('components.buttonback',['href' => route("registrasi.unggahDataSertifikasi")])@endcomponent
								@endif	
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

    

@endpush