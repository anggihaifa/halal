@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tambah Aset')

@push('css')
	<link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Tanah dan Bangunan</a></li>
		<li class="breadcrumb-item active">Tambah Aset</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tambah Aset Tanah dan Bangunan<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Tambah Aset Tanah dan Bangunan</h4>
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
							<label class="col-lg-4 col-form-label">BUMN</label>
							<div class="col-lg-8">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="BKI" selected>BKI</option>
									<option value="SCI">SCI</option>
									<option value="SI">SI</option>
								</select>
							</div>
							<label class="col-lg-4 col-form-label">No Item Aset</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-4 col-form-label">Nama/Deskripsi Aset</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-4 col-form-label">Kode Kelompok Aset</label>
							<div class="col-lg-8">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Kode 1</option>
									<option value="#">Kode 2</option>
									<option value="#">Kode 3</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Lokasi</label>
							<label class="col-lg-2 col-form-label">Koordinat</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">RUTR</label>
							<div class="col-lg-8">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Investasi</option>
									<option value="#">Perumahan</option>
									<option value="#">Perkebunan</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Alamat</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="2"></textarea>
							</div>
							<label class="col-lg-2 col-form-label">Kondisi Bangunan</label>
							<label class="col-lg-2 col-form-label">Fisik</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Baik</option>
									<option value="#">Rusak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Keterangan Detail</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Perlu Perbaikan</option>
									<option value="#">Siap Digunakan</option>
									<option value="#">Masih Bisa Digunakan</option>
									<option value="#">Tidak Bisa Digunakan</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Utilitas</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Terpakai</option>
									<option value="#">Idle</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Histori Renovasi</label>
							<div class="col-lg-3">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label">Luasan (m2)</label>
							<label class="col-lg-2 col-form-label">Tanah</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Bangunan</label>
							<div class="col-lg-4">
								<textarea class="form-control" rows="1" placeholder="Berdasarkan PBB"></textarea>
							</div>
							<div class="col-lg-4">
								<textarea class="form-control" rows="1" placeholder="Perhitungan Riil"></textarea>
							</div>
							<label class="col-lg-2 col-form-label">Faktor Risiko Alam</label>
							<label class="col-lg-2 col-form-label">Gempa</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Banjir/Rob</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Longsor</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Tsunami</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Puting Beliung</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Petir</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Erupsi</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-5 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Public Utility</label>
							<label class="col-lg-2 col-form-label">Air Bersih</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Air Tanah</option>
									<option value="#">PAM</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Listrik</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>PLN</option>
									<option value="#">Genset</option>
									<option value="#">Solar Cell</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Jaringan Gas</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ada</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Telekomunikasi</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Fixed</option>
									<option value="#">Celluler</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Legalitas</label>
							<label class="col-lg-2 col-form-label">HGB</label>
							<div class="col-lg-8">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Masalah Hukum</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">IMB</label>
							<div class="col-lg-3">
								<select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="#" selected>Ya</option>
									<option value="#">Tidak</option>
								</select>
							</div>
							<label class="col-lg-2 col-form-label">Perolehan</label>
							<label class="col-lg-2 col-form-label">Nilai Awal</label>
							<div class="col-lg-3">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label">Nilai Revaluasi</label>
							<div class="col-lg-3">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label"></label>
							<label class="col-lg-2 col-form-label">Tahun Awal</label>
							<div class="col-lg-3">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<label class="col-lg-2 col-form-label">Tahun Revaluasi</label>
							<div class="col-lg-3">
								<textarea class="form-control" rows="1"></textarea>
							</div>
							<div class="col-md-12 offset-md-5">
								<button type="submit" class="btn btn-sm btn-primary m-r-5">Tambah</button>
								<button type="submit" class="btn btn-sm btn-default">Batal</button>
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