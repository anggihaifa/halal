@extends('layouts.default')

@section('title', 'Detail Kantor Pusat')

@push('css')
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Detail Kantor Pusat</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Detail Kantor Pusat <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            @foreach($dataKantorPusat as $index => $value)
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

                                @component('components.fordetail',['label' => 'Nama Kantor Pusat','value'=>$value['kantor_pusat']])@endcomponent

								@component('components.fordetail',['label' => 'Alamat','value'=>$value['alamat']])@endcomponent                                

								@component('components.fordetail',['label' => 'Kota','value'=>$value['kota']])@endcomponent

								@component('components.fordetail',['label' => 'Negara','value'=>$value['negara']])@endcomponent

								@component('components.fordetail',['label' => 'Kode Pos','value'=>$value['kode_pos']])@endcomponent

								@component('components.fordetail',['label' => 'Telepon','value'=>$value['phone']])@endcomponent

								@component('components.fordetail',['label' => 'Fax','value'=>$value['fax']])@endcomponent

								@component('components.fordetail',['label' => 'Email Kantor Pusat','value'=>$value['email']])@endcomponent

								@component('components.fordetail',['label' => 'Nama PIC','value'=>$value['pic']])@endcomponent

								@component('components.fordetail',['label' => 'Titel PIC','value'=>$value['pic_title']])@endcomponent

								@component('components.fordetail',['label' => 'Telepon PIC','value'=>$value['pic_phone']])@endcomponent

								@component('components.fordetail',['label' => 'Telepon Genggam PIC','value'=>$value['pic_mobile_phone']])@endcomponent

								@component('components.fordetail',['label' => 'Email PIC','value'=>$value['pic_email']])@endcomponent

								@component('components.fordetail',['label' => 'Nama Kontak Personal','value'=>$value['cp']])@endcomponent

								@component('components.fordetail',['label' => 'Titel Kontak Personal','value'=>$value['cp_title']])@endcomponent

								@component('components.fordetail',['label' => 'Telepon Kontak Personal','value'=>$value['cp_phone']])@endcomponent

								@component('components.fordetail',['label' => 'Telepon Genggam Kontak Personal','value'=>$value['cp_mobile_phone']])@endcomponent

								@component('components.fordetail',['label' => 'Email Kontak Personal','value'=>$value['cp_email']])@endcomponent
                            
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