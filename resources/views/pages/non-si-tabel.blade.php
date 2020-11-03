@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Non Tanah dan Bangunan')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Non Tanah dan Bangunan</a></li>
		<li class="breadcrumb-item active"><a href="#">PT SI (Persero)</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Non Tanah dan Bangunan / PT SI (Persero) <small></small></h1>
	<!-- end page-header -->
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<!-- begin panel-heading -->
		<div class="panel-heading">
			<h4 class="panel-title">Non Tanah dan Bangunan / PT SI (Persero) </h4>
			<div class="panel-heading-btn">
				<a href="/non/tambah" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Aset</a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<!-- end panel-heading -->
		<!-- begin panel-body -->
		<div class="panel-body table-responsive">
			<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle" style="width:100%">
				<thead>
					<tr>
						<th rowspan="3" width="1%"></th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">BUMN</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">No Item Aset</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">Nama/Deskripsi Aset</th>
						<th rowspan="3" class="text-nowrap valign-middle text-center">Kode Kelompok Aset</th>
						<th colspan="2" class="text-nowrap valign-middle text-center">Lokasi</th>
						<th colspan="6" class="text-nowrap valign-middle text-center">Spesifikasi</th>
						<th colspan="2" class="text-nowrap valign-middle text-center">Kondisi</th>
						<th colspan="4" class="text-nowrap valign-middle text-center">Kalibrasi</th>
						<th colspan="4" class="text-nowrap valign-middle text-center">Lisensi</th>
						<th colspan="4" class="text-nowrap valign-middle text-center">Perolehan</th>
					</tr>
					<tr>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Koordinat</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Alamat</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Merek</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tipe</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Dimensi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Mobilitas</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Keterangan Teknologi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">SDK</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Fisik</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Keterpakaian</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Periode</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tanggal Kalibrasi Terakhir</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tanggal Kalibrasi Berikut</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Institusi</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Perolehan</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tanggal Terakhir</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Tanggal Berikut</th>
						<th rowspan="2" class="text-nowrap valign-middle text-center">Institusi</th>
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
					</tr>
					<tr class="even">
						<td class="text-nowrap valign-middle text-center">2</td>
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
					<tr class="odd">
						<td class="text-nowrap valign-middle text-center">3</td>
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