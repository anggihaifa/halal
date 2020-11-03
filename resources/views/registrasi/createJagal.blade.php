@extends('layouts.default')

@section('title', 'Tambah Jagal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Tambah Jagal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tambah Jagal <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
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
                    <form action="{{route('storejagal')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
						<div class="form-group row">
                            @csrf
                            @component('components.inputselect',['name'=>'id_fasilitas','label'=>'Nama Fasilitas*','options'=>$fasilitas,'labelKey'=>'fasilitas','required'=>true])@endcomponent
							
							@component('components.inputtext',['name'=> 'tipe_hewan','label' => 'Tipe Hewan*','required'=>true,'placeholder'=>'Tipe Hewan'])@endcomponent
							
							<label class="col-lg-4 col-form-label">Tipe Jagal*</label>
							<div class="col-lg-8">
								<select name="tipe_jagal" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="manual" selected>Manual</option>
									<option value="mekanikal">Mekanikal</option>
								</select>
                            </div>

                            <label class="col-lg-4 col-form-label">Metode*</label>
							<div class="col-lg-8">
								<select name="metode" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="no stunning" selected>No Stunning</option>
									<option value="mekanikal">Mekanikal</option>
									<option value="elektrikal">Elektrikal</option>
								</select>
                            </div>

                            @component('components.inputtext',['name'=> 'kapasitas','label' => 'Kapasitas*','required'=>true,'placeholder'=>'contoh: 50 / Hari'])@endcomponent

                            @component('components.inputtext',['name'=> 'nama_jagal','label' => 'Name Jagal*','required'=>true,'placeholder'=>'Nama Jagal'])@endcomponent

                            @component('components.inputtext',['name'=> 'posisi','label' => 'Posisi*','required'=>true,'placeholder'=>'Posisi'])@endcomponent

                            @component('components.inputtext',['name'=> 'id_penerbit_kartu','label' => 'ID Penerbit Kartu*','required'=>true,'placeholder'=>'ID Penerbit Kartu'])@endcomponent

                            @component('components.inputtext',['name'=> 'id_kartu','label' => 'ID Kartu*','required'=>true,'placeholder'=>'ID Kartu'])@endcomponent

                            <label id="lshb" class="col-lg-4 col-form-label">Masa Berlaku*</label>
							<div id="shb" class="col-lg-8">
                                <div class="input-group date">
                                    <input type="text" id="tanggal_expired" name="tanggal_expired" class="form-control" value="" data-date-start-date="Date.default" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
                            </div>

                            @component('components.inputtextarea',['name'=> 'deskripsi','label' => 'Deskripsi','required'=>false])@endcomponent

                            <div class="col-md-12 offset-md-5">
								@component('components.buttonback',['href' => route("registrasi.unggahDataSertifikasi")])@endcomponent
								<button type="submit" class="btn btn-sm btn-primary m-r-5">Submit</button>
								<!--<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-sm btn-default m-r-5">Back</button>-->
							</div>
						</div>
					</form>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script>
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var d = date.getDate();
        var month = date.getMonth()+1;
        var y = date.getFullYear();
        if(d < 10 ){ d = '0'+ d;}
        if(month < 10){ month = '0'+ month; }
        var todayFormat = y+"-"+month+"-"+d ;
        $('#tanggal_expired').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

    </script>
@endpush