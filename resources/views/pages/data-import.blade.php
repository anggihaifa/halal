@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tambah Aset')

@push('css')
	<link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Manajemen Data</a></li>
		<li class="breadcrumb-item active">Import Data</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Import Data<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Import Data</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form class="form-horizontal form-bordered">
						<div class="form-group row">
							<label class="col-lg-4 col-form-label">Import File (Format Excel)</label>
							<div class="col-lg-4">
								<input type="file" name="fileToUpload" id="fileToUpload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
							</div>
							<!-- <div class="col-lg-4">
								<a href="#" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tekan untuk Import</a>
							</div> -->
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-form-label pt-1">Pilihan Import Data</label>
							<div class="col-md-8">
								<div class="custom-control custom-radio mb-1">
									<input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
									<label class="custom-control-label" for="customRadio1">Update Data Sebelumnya</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
									<label class="custom-control-label" for="customRadio2">Lewati Data Sebelumnya</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
						<label class="col-lg-4 col-form-label">Kategori Aset</label>
							<div class="col-lg-8">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Tanah dan Bangunan</option>
									<option value="#">Non Tanah dan Bangunan</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
						<div class="col-md-12 offset-md-5">
								<button type="submit" class="btn btn-sm btn-primary m-r-5">Import Data</button>
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
	<script src="/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
	<script src="/assets/js/demo/form-plugins.demo.js"></script>
@endpush