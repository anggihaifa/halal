@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tanah dan Bangunan')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Tanah dan Bangunan</a></li>
		<li class="breadcrumb-item active"><a href="#">Konsolidasi</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tanah dan Bangunan / Konsolidasi  <small></small></h1>
	<!-- end page-header -->
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
			<h4 class="panel-title">Tanah dan Bangunan / Konsolidasi </h4>
			<div class="panel-heading-btn">
				<a href="/tanah/tambah" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Aset</a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<!-- end panel-heading -->
		<!-- begin panel-body -->
		<div class="panel-body table-responsive">
			<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
				<thead>
					<tr>
						<th rowspan="3" class="text-nowrap valign-middle text-center">No</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">BUMN</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">No Item Aset</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">Nama/Deskripsi Aset</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">Kode Kelompok Aset</th>
						<th colspan="3" class="text-nowrap valign-middle text-center">Lokasi</th>
						<th colspan="3" class="text-nowrap valign-middle text-center">Kondisi Bangunan</th>
						<th colspan="2" class="text-nowrap valign-middle text-center">Luasan</th>
						<th colspan="7" class="text-nowrap valign-middle text-center">Faktor Risiko Alam</th>
						<th colspan="4" class="text-nowrap valign-middle text-center">Public Utility</th>
						<th colspan="3" class="text-nowrap valign-middle text-center">Legalitas</th>
						<th colspan="4" class="text-nowrap valign-middle text-center">Perolehan</th>
					</tr>
					<tr>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Koordinat</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">RUTR</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Alamat</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Fisik</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Utilitas</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Histori Renovasi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tanah</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Bangunan</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Gempa</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Banjir/Rob</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Longsor</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tsunami</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Puting Beliung</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Petir</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Erupsi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Air Bersih</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Listrik</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Jaringan Gas</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Telekomunikasi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">HGB</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Masalah Hukum</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">IMB</th>
						<th colspan="2" class="text-nowrap valign-middle text-center">Nilai</th>
						<th colspan="2" class="text-nowrap valign-middle text-center">Tahun</th>
					</tr>
					<tr>
						<th class="text-nowrap valign-middle text-center">Awal</th>
						<th class="text-nowrap valign-middle text-center">Revaluasi</th>
						<th class="text-nowrap valign-middle text-center">Awal</th>
						<th class="text-nowrap valign-middle text-center">Revaluasi</th>
					</tr>
				</thead>
				<tbody>
					<tr class="odd">
						<td class="text-nowrap valign-middle text-center">1</td>
						<td>BKI</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
					</tr>
					<tr class="even">
						<td class="text-nowrap valign-middle text-center">2</td>
						<td>SCI</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
					</tr>
					<tr class="odd">
						<td class="text-nowrap valign-middle text-center">3</td>
						<td>SI</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
						<td>Dummy Data</td>
					</tr>
					<tr class="even">
						<td class="text-nowrap valign-middle text-center">4</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- end panel-body -->
	</div>
	<!-- end panel -->
@endsection

@push('scripts')
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/js/demo/table-manage-default.demo.js"></script>
@endpush