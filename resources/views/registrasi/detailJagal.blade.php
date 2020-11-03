@extends('layouts.default')

@section('title', 'Detail Jagal')

@push('css')
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Detail Jagal</li>
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
            @foreach($dataJagal as $index => $value)
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

                                @component('components.fordetail',['label' => 'Fasilitas','value'=>$value['fasilitas']])@endcomponent

								@component('components.fordetail',['label' => 'Tipe Hewan','value'=>$value['tipe_hewan']])@endcomponent                                
								@component('components.fordetail',['label' => 'Tipe Jagal','value'=>$value['tipe_jagal']])@endcomponent

								@component('components.fordetail',['label' => 'Metode','value'=>$value['metode']])@endcomponent

								@component('components.fordetail',['label' => 'Kapasitas','value'=>$value['kapasitas']])@endcomponent

								@component('components.fordetail',['label' => 'Nama Jagal','value'=>$value['nama_jagal']])@endcomponent

								@component('components.fordetail',['label' => 'Posisi','value'=>$value['posisi']])@endcomponent

								@component('components.fordetail',['label' => 'ID Penerbit Kartu','value'=>$value['id_penerbit_kartu']])@endcomponent

								@component('components.fordetail',['label' => 'ID Kartu','value'=>$value['id_kartu']])@endcomponent

								@component('components.fordetail',['label' => 'Masa Berlaku','value'=>$value['tanggal_expired']])@endcomponent

								@component('components.fordetail',['label' => 'Deskripsi','value'=>$value['deskripsi']])@endcomponent
								
                            
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