@extends('layouts.default')

@section('title', 'Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">List Registrasi Halal</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Registrasi Halal  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->    
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Registrasi Halal</h4>
            <div class="panel-heading-btn">
                @if(isset($data))
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: Reg No.  {{$data->no_registrasi==null ? "-" : $data->no_registrasi }}</a>
                @else
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: ---</a>
                @endif
                
                <a href="{{route('registrasiHalal.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->

        <div class="col-md-12 mx-0 step widget widget-stats animated zoomIn">
            <form id="msform">	
                @foreach($dataCurrent as $key => $value)		
				@php
					$status_temp = $value['status'];
					$status = 'a'.'_'.$status_temp;
					// dd($status);                    
				@endphp
                @endforeach
                <!-- progressbar -->
                <ul id="progressbar">
					@if(count($dataCurrent) == null)
						<p class="text-dark mt-4"><b>Belum ada kegiatan</b></p>
					@else										
						@foreach($dataCurrent as $key => $value)								
							@if ($status == 'a_1')
								<li id="account" class="confirming"><strong>Pengajuan Baru</strong></li>
							@else
								<li id="account" class="confirming"><strong>Pengajuan Baru</strong></li>
							@endif							

							@if ($status == 'a_2')
								<li id="account" class="notyet"><strong>Verifikasi Berkas</strong></li>
							@elseif ($status == 'a_2_0')
								<li id="account" class="notyet"><strong>Belum Upload Berkas</strong></li>
							@elseif ($status == 'a_2_1')
								<li id="account" class="waiting"><strong>Menunggu Verifikasi Admin</strong></li>
							@elseif ($status == 'a_2_2')
								<li id="account" class="fixing"><strong>Perbaikan Berkas</strong></li>
							@elseif ($status == 'a_2_3')
								<li id="account" class="confirming"><strong>Berkas Terkonfirmasi</strong></li>
							@elseif ($status == 'a_1')
								<li id="account"><strong>Verifikasi Berkas</strong></li>						
							@else
								<li id="account" class="confirming"><strong>Berkas Terkonfirmasi</strong></li>
							@endif

							{{-- @if ($status == 'a_3')
								<li id="personal" class="notyet"><strong>Menentukan Kebutuhan Waktu Audit</strong></li>
							@elseif ($status == 'a_3_0')
								<li id="personal" class="notyet"><strong>Belum Ditentukan</strong></li>
							@elseif ($status == 'a_3_1')
								<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Reviewer</strong></li>
							@elseif ($status == 'a_3_2')
								<li id="personal" class="fixing"><strong>Perbaikan Kebutuhan Audit</strong></li>
							@elseif ($status == 'a_3_3')
								<li id="personal" class="confirming"><strong>Kebutuhan Waktu Audit Terkonfirmasi</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Menentukan Kebutuhan Waktu Audit</strong></li>
							@else
								<li id="account" class="confirming"><strong>Kebutuhan Waktu Audit Terkonfirmasi</strong></li>
							@endif --}}

							@if ($status == 'a_4')
								<li id="personal" class="notyet"><strong>Penawaran Harga dan Akad</strong></li>
							@elseif ($status == 'a_4_0')
								<li id="personal" class="waiting"><strong>Belum Upload Bukti Penawaran dan Akad</strong></li>
							@elseif ($status == 'a_4_1')
								<li id="personal" class="confirming"><strong>Sudah Upload Bukti Penawaran dan Akad</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Penawaran Harga dan Akad</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Penawaran Harga dan Akad</strong></li>
							@else
								<li id="account" class="confirming"><strong>Sudah Upload Bukti Penawaran Harga dan Akad</strong></li>
							@endif

							@if ($status == 'a_5')
								<li id="personal" class="notyet"><strong>Penerbitan Order Confirmation</strong></li>
							@elseif ($status == 'a_5_0')
								<li id="personal" class="notyet"><strong>Belum Upload OC</strong></li>								
							@elseif ($status == 'a_5_1')
								<li id="personal" class="waiting"><strong>Menunggu Pelanggan Upload Ulang OC</strong></li>								
							@elseif ($status == 'a_5_2')
								<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Admin</strong></li>								
							@elseif ($status == 'a_5_3')
								<li id="personal" class="fixing"><strong>Penerbitan OC Gagal</strong></li>
							@elseif ($status == 'a_5_4')
								<li id="personal" class="confirming"><strong>Penerbitan OC Terkonfirmasi</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Penerbitan OC</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Penerbitan OC</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Penerbitan OC</strong></li>
							@else
								<li id="account" class="confirming"><strong>Penerbitan OC Terkonfirmasi</strong></li>
							@endif

							@if ($status == 'a_6')
								<li id="personal" class="notyet"><strong>Pembayaran</strong></li>
							@elseif ($status == 'a_6_0')
								<li id="personal" class="notyet"><strong>Belum Upload Bukti Bayar</strong></li>								
							@elseif ($status == 'a_6_1')
								<li id="personal" class="waiting"><strong>Menunggu Sales Officer Mengkonfirmasi Pembayaran</strong></li>
							@elseif ($status == 'a_6_2')
								<li id="personal" class="fixing"><strong>Pembayaran Gagal</strong></li>
							@elseif ($status == 'a_6_3')								
								<li id="personal" class="confirming"><strong>Pembayaran Terkonfirmasi</strong></li>															
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')								
								<li id="account"><strong>Pembayaran</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Pembayaran</strong></li>								
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Pembayaran</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Pembayaran</strong></li>
							@else
								<li id="account" class="confirming"><strong>Pembayaran Terkonfirmasi</strong></li>
							@endif

							@if ($status == 'a_7')
								<li id="personal" class="notyet"><strong>Persiapan Audit Tahap1</strong></li>
							@elseif ($status == 'a_7_0')
								<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
							@elseif ($status == 'a_7_1')
								<li id="personal" class="waiting"><strong>Menunggu Reviewer Mengkonfirmasi Penjadwalan</strong></li>
							@elseif ($status == 'a_7_2')
								<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>
							@elseif ($status == 'a_7_3')
								<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>						
							@elseif ($status == 'a_8')
								<li id="personal" class="notyet"><strong>Proses Audit Tahap 1</strong></li>						
							@elseif ($status == 'a_8_1')
								<li id="personal" class="waiting"><strong>Menunggu Auditor Membuat Laporan Audit</strong></li>
							@elseif ($status == 'a_8_2')
								<li id="personal" class="fixing"><strong>Perbaikan Berkas Audit Tahap 1</strong></li>
							@elseif ($status == 'a_8_3')
								<li id="personal" class="confirming"><strong>Audit Tahap 1 Selesai</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Proses Audit Tahap 1</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Proses Audit Tahap 1</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Proses Audit Tahap 1</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Proses Audit Tahap 1</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Proses Audit Tahap 1</strong></li>
							@else
								<li id="account" class="confirming"><strong>Audit Tahap 1 Selesai</strong></li>
							@endif														

							@if ($status == 'a_9')
								<li id="personal" class="notyet"><strong>Persiapan Audit Tahap2</strong></li>						
							@elseif ($status == 'a_9_0')
								<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
							@elseif ($status == 'a_9_1')
								<li id="personal" class="waiting"><strong>Menunggu Reviewer Mengkonfirmasi Penjadwalan</strong></li>
							@elseif ($status == 'a_9_2')
								<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>
							@elseif ($status == 'a_9_3')
								<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>
							@elseif ($status == 'a_10')
								<li id="personal" class="notyet"><strong>Proses Audit Tahap 2</strong></li>													
							@elseif ($status == 'a_10_1')
								<li id="personal" class="fixing"><strong>Perbaikan Audit Tahap 2</strong></li>
							@elseif ($status == 'a_10_2')
								<li id="personal" class="confirming"><strong>Audit Tahap 2 Selesai</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@else
								<li id="account" class="confirming"><strong>Audit Tahap 2 Selesai</strong></li>
							@endif

							
							{{-- @elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Proses Audit Tahap 2</strong></li>
							@else
								<li id="account" class="confirming"><strong>Proses Audit Tahap 2</strong></li>
							@endif --}}

							@if ($status == 'a_11')
								<li id="personal" class="notyet"><strong>Persiapan Tehnical Review</strong></li>
							@elseif ($status == 'a_11_0')
								<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
							@elseif ($status == 'a_11_1')
								<li id="personal" class="waiting"><strong>Menunggu Reviewer Mengkonfirmasi Penjadwalan</strong></li>
							@elseif ($status == 'a_11_2')
								<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>						
							@elseif ($status == 'a_11_3')
								<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>
							@elseif ($status == 'a_12')
								<li id="personal" class="notyet"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_12_0')
								<li id="personal" class="notyet"><strong>Reviewer Belum Upload Review Laporan Audit</strong></li>
							@elseif ($status == 'a_12_1')
								<li id="personal" class="confirming"><strong>Proses Tehnical Review Selesai</strong></li>							
							@elseif ($status == 'a_13')
								<li id="personal" class="notyet"><strong>Persiapan Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_13_0')
								<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
							@elseif ($status == 'a_13_1')
								<li id="personal" class="waiting"><strong>Menunggu Reviewer Mengkonfirmasi Penjadwalan</strong></li>
							@elseif ($status == 'a_13_2')
								<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>
							@elseif ($status == 'a_13_3')
								<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>
							@elseif ($status == 'a_14')
								<li id="personal" class="notyet"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_14_0')
								<li id="personal" class="notyet"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></li>
							@elseif ($status == 'a_14_1')
								<li id="personal" class="confirming"><strong>Proses Komite Sertifkasi Selesai</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
								<li id="account"><strong>Proses Technical Review</strong></li>
							@else
								<li id="account" class="confirming"><strong>Proses Technical Review Selesai</strong></li>
							@endif
							
							{{-- @elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
								<li id="account"><strong>Pelunasan</strong></li>
							@elseif ($status == 'a_11' || $status == 'a_11_0' || $status == 'a_11_1' || $status == 'a_11_2')
								<li id="account"><strong>Pelunasan</strong></li>
							@else
								<li id="account" class="confirming"><strong>Pelunasan Terkonfirmasi</strong></li>
							@endif --}}

							{{-- @if ($status == 'a_13')
								<li id="personal" class="notyet"><strong>Persiapan Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_13_0')
								<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
							@elseif ($status == 'a_13_1')
								<li id="personal" class="waiting"><strong>Menunggu Reviewer Mengkonfirmasi Penjadwalan</strong></li>
							@elseif ($status == 'a_13_2')
								<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>
							@elseif ($status == 'a_13_3')
								<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>
							@elseif ($status == 'a_14')
								<li id="personal" class="notyet"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_14_0')
								<li id="personal" class="notyet"><strong>Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</strong></li>
							@elseif ($status == 'a_14_1')
								<li id="personal" class="confirming"><strong>Proses Komite Sertifkasi Selesai</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_11' || $status == 'a_11_0' || $status == 'a_11_1' || $status == 'a_11_2')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@elseif ($status == 'a_12' || $status == 'a_12_0' || $status == 'a_12_1' || $status == 'a_12_2' || $status == 'a_12_3')
								<li id="account"><strong>Proses Komite Sertifikasi</strong></li>
							@else
								<li id="account" class="confirming"><strong>Proses Komite Sertifkasi Selesai</strong></li>
							@endif --}}

							@if ($status == 'a_15')
								<li id="personal" class="notyet"><strong>Proses Persiapan Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_15_0')
								<li id="personal" class="notyet"><strong>Reviewer Belum Mereview Laporan Hasil Akhir Audit</strong></li>
							@elseif ($status == 'a_15_1')
								<li id="personal" class="confirming"><strong>Laporan Akhir Audit Terkonfirmasi</strong></li>							
							@elseif ($status == 'a_16')
								<li id="personal" class="confirming"><strong>Proses Sidang Fatwa</strong></li>							
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_11' || $status == 'a_11_0' || $status == 'a_11_1' || $status == 'a_11_2')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_12' || $status == 'a_12_0' || $status == 'a_12_1' || $status == 'a_12_2' || $status == 'a_12_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_13' || $status == 'a_13_0' || $status == 'a_13_1' || $status == 'a_13_2' || $status == 'a_13_3')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@elseif ($status == 'a_14' || $status == 'a_14_0' || $status == 'a_14_1')
								<li id="account"><strong>Sidang Penetapan Kehalalan Produk</strong></li>
							@else
								<li id="account" class="confirming"><strong>Proses Sidang Fatwa</strong></li>
							@endif

							@if ($status == 'a_17')
								<li id="account" class="confirming"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3' || $status == 'a_5_4')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_11' || $status == 'a_11_0' || $status == 'a_11_1' || $status == 'a_11_2')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_12' || $status == 'a_12_0' || $status == 'a_12_1' || $status == 'a_12_2' || $status == 'a_12_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_13' || $status == 'a_13_0' || $status == 'a_13_1' || $status == 'a_13_2' || $status == 'a_13_3')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_14' || $status == 'a_14_0' || $status == 'a_14_1')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_15' || $status == 'a_15_0' || $status == 'a_15_1')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@elseif ($status == 'a_16')
								<li id="account"><strong>Sidang Fatwa Halal</strong></li>
							@else
								<li id="account" class="confirming"><strong>Sidang Fatwa Halal</strong></li>
							@endif							
													
						@endforeach
					@endif	                     
                                                            																														
				</ul> <!-- fieldsets -->
			</form>
		</div>
        
        <div class="panel-body" style="min-height: 230px">
            <h5 style="color: #ff6961;">NOTE: Silahkan Aktifkan Registrasi Anda Untuk Melanjutkan Ke Tahapan Berikutnya</h5>
           <table id="table" class="table" cellspacing="0" style="width:100%">
                <thead style="display: none;">
                    <tr>
                        <th ></th>                         
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->
    </div>           
    
@endsection
@push('scripts')


    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    
    <script>



       
        $('#btncalendar').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        
        function formatRupiah(d) {
            return Number(d).toLocaleString('id', {
              maximumFractionDigits: 2,
              style: 'currency',
              currency: 'IDR'
            });
        }
      
        $(document).ready(function () {

            var aktif_reg =  {!! json_encode(Auth::user()->registrasi_id) !!};

            var xTable = $('#table').DataTable({
               
                columns:[
                   
                   {     
                        "data":'no_registrasi',              
                        "render":function (data,type,full,meta) {

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                           
                            var akad = `<a href="{{url('upload_kontrak_akad_user')}}/`+full.id+`"  class="dropdown-item" >Kontrak Akad</a> `;
                            var oc = `<a href="{{url('upload_oc_user')}}/`+full.id+`"  class="dropdown-item" >Order Confirmation</a> `;                            

                            var pembayaran = `<a href="{{url('pembayaran_registrasi')}}/`+full.id+`"  class="dropdown-item"> Pembayaran</a> `;
                            var pembayaran2 = `<a href="{{url('pembayaran_tahap2')}}/`+full.id+`"  class="dropdown-item"> Pembayaran Tahap 2</a> `;
                            var pelunasan = `<a href="{{url('pelunasan')}}/`+full.id+`"  class="dropdown-item" >Bukti Pembayaran</a>` ;
                            var reportA = `<a href="{{url('report_audit')}}/`+full.id+`"  class="dropdown-item" >Report Audit dan Berita Acara</a>`;
                           

                            if(full.id == aktif_reg ){
                                var aktif =`<a style="color:green" ><strong>Sedang Berjalan</strong></a>`;
                                var uploadBerkas = `<a href="{{url('unggah_dokumen_sertifikasi')}}"  class="dropdown-item" ><i class="fa fa-edit"></i>Upload Berkas Sertifikasi</a>`;
                                var div_aktif = `<div class="col-lg-12 row rounded-sm shadow border pt-3 pb-3 m-0">`;
                            }else{
                                var aktif = `<a style="color:red" ><strong>Tidak Aktif</strong></a>`;
                                var uploadBerkas = `<a href="{{url('activate_registrasi')}}/`+full.id+`"  class="dropdown-item" >Aktifkan</a>`;
                                 var div_aktif = `<div class="col-lg-12 row rounded-sm shadow-sm border pt-3 pb-3 m-0">`;
                            }
                            
                            return ``+div_aktif+`
                                       
                                          
                                       
                                        <div class="col-lg-5 row" >
                                             <div class="col-lg-4 d-flex justify-content-center align-items-center">
                                                <i class="fa fa-building text-primary" style="font-size:600%"></i>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <h4 class="text-grey" style=>`+full.nama_perusahaan+`</h4>
                                                <a  href="{{url('detail_registrasi')}}/`+full.id+`"  style="color: white; " class="label label-success">NOMOR ID: `+full.no_registrasi+`</a><br> 
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.tgl_registrasi+`<br>
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.kelompok+`<br>
                                                <i class="fa fa-info text-primary" ></i>
                                                `+full.alamat_perusahaan+`<br>
                                                <i class="fa fa-info text-primary" ></i> Aktivasi: 
                                                `+aktif+`<br>
                                             </div>     
                                            
                                           
                                        </div>
                                      

                                        <div class="col-lg-7 row " >

                                            <table class="table table-sm"> 
                                                <tr>
                                                     <td class="text-center">Cabang Pelaksana</td>
                                                    <td class="text-center" style="max-width:20%; min-width:20%;">Progres</td>
                                                    <td class="text-center">Status</td>
                                                    <td class="text-center">Status Berkas</td>
                                                    <td class="text-center">Aksi</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkWilayah(full.kode_wilayah)+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkProgress(full.status)+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+full.status_registrasi+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkStatusBerkas(full.status_berkas)+`
                                                    </td>

                                              

                                                    <td class="text-center">
                                                        <div class="btn-group m-r-5 show">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">
                                                                `+uploadBerkas+`
                                                                <div class="dropdown-divider"></div>
                                                                `+akad+oc+reportA+pelunasan+`
                                                               
                                                            </div> 
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>                                                  
                                        </div>                                        
                                    </div>`  
                        }
                    }
                ],

              
               
               //tambahkan bkti bayar 1,2,3, bkti kontrak akad, berita acara,
                
                
               
                
                bSortable: false,
                ordering: false,
                processing:true,
                serverSide:true,
                ajax:"{{route('registrasi.datatable')}}",
              

            });



        });

  
        
        
      

        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush