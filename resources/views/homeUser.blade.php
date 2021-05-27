@extends('layouts.default')

@section('title', 'Home')
@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <!--greeting panel-->
        <div class="col-xl-12 for-greeting">
            <div>
                <h1 class="page-header">Home<small></small></h1>
            </div>
            <div id="panelGreeting">
                <div  class="panel-greeting animated bounceIn delay-7s">
                        <div class="greeting-emoticon">
                            <i class="fa fa-smile"></i>
                        </div>
                        <div>
                            <div>Hai, <span >{{ucwords(strtolower(Auth::user()->name))}}</span></div>
                            <div>Selamat Datang di aplikasi LPHSUCOFINDO</div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 ">
			<div class="widget widget-stats bg-personal animated zoomIn delay-2s">
				<div class="stats-icon"><i class="ion-md-desktop text-white"></i></div>
				<div class="stats-info" style="font-size: 15px;">
					@foreach($dataDetailUser as $key => $value)
		        	<div>
		        		<span><i class="ion-md-person" style="color: #e2e2e2"></i>   {{$value['name']}}</span>
		        	</div>
		        	<div>
		        		<span><i class="ion-ios-business" style="color: #e2e2e2"></i>   {{$value['perusahaan']}}</span>
		        	</div>
		        	<div>
		        		<span><i class="ion-ios-pin" style="color: #e2e2e2"></i>   {{$value['alamat']}}</span>
		        	</div>
		        	<div>
		        		<span><i class="ion-ios-flag" style="color: #e2e2e2"></i>   {{$value['negara']}}</span>
		        	</div>
		        	@endforeach
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6">
			@if($dataCurrent == null)
			<div class="widget widget-stats bg-inverse animated zoomIn delay-5s">
				<div class="stats-icon"><i class="ion-md-remove-circle-outline text-white"></i></div>
				<div class="stats-info">
					<h4>Notifikasi</h4>
					<div><span>-</span></div>
					<div><span>-</span></div>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
			@else
			<div class="widget widget-stats bg-red animated zoomIn delay-5s">
				
				<div class="stats-info">
					<h4>Notifikasi</h4>
					@foreach($dataCurrent as $key => $value)
						
						<div id="stat_val" style="display: none"><span>
							{{$value['status']}}
						</span></div>
						<div id="notif_user"><span></span></div>
							
					@endforeach	
				</div>
			<div class="stats-link">
				<a href="javascript:;" target="_top"></a>
			</div>
			</div>
			@endif
		</div>
        <div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-info animated zoomIn delay-3s">
				<div class="stats-icon"><i class="ion-ios-document text-white"></i></div>
				<div class="stats-info">
					<h4>TOTAL REGISTRASI</h4>
					<a href="{{route('registrasiHalal.index')}}" class="text-white"><p>{{$totalRegistrasiUser}}</p></a>
				</div>

				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6">
			@if($dataCurrent == null)
			<div class="widget widget-stats bg-inverse animated zoomIn delay-5s">
				<div class="stats-icon"><i class="ion-md-remove-circle-outline text-white"></i></div>
				<div class="stats-info">
					<h4>REGISTRASI AKTIF</h4>
					<div><span>-</span></div>
					<div><span>-</span></div>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
			@else
			<div class="widget widget-stats bg-green animated zoomIn delay-5s">
				<div class="stats-icon"><i class="ion-ios-checkmark-circle-outline text-white"></i></div>
				<div class="stats-info">
					<h4>REGISTRASI AKTIF</h4>
					@foreach($dataCurrent as $key => $value)
							<div><a class="text-white" href="{{url('detail_registrasi')}}/{{$value['id']}}"><span>{{$value['no_registrasi']}}</span></a></div>
							<div><span>{{$value['jenis_registrasi']}}</span></div>
							{{-- @php $id_prog = $value['progress'] @endphp --}}
							<!--
							<div id="stat_val" style="display: none"><span>
								{{$value['status']}}
							</span></div>
							<div id="status"><span></span></div>
							-->
								
					@endforeach	
				</div>
				
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
			@endif
		</div>

		<div class="col-md-12 mx-0 step widget widget-stats bg-light animated zoomIn delay-5s">
            <form id="msform">			
				@php
					$status_temp = $value['status'];
					$status = 'a'.'_'.$status_temp;
					// dd($status);
				@endphp
                <!-- progressbar -->
                <ul id="progressbar">
					@foreach($dataCurrent as $key => $value)	
						<h4 style="color: #32a932; margin-bottom: 30px;">PROGRESS</h4>
						@if ($status == 'a_1')
							<li id="account" class="confirming"><strong>Pengajuan Baru</strong></li>
						@else
							<li id="account" class="confirming"><strong>Pengajuan Baru</strong></li>
						@endif

						@php
							// dd($value['status']);				
						@endphp

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

						@if ($status == 'a_3')
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
						@endif

						@if ($status == 'a_4')
							<li id="personal" class="confirming"><strong>Penawaran Harga dan Akad</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Penawaran Harga dan Akad</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Penawaran Harga dan Akad</strong></li>
						@else
							<li id="account" class="confirming"><strong>Penawaran Harga dan Akad</strong></li>
						@endif

						@if ($status == 'a_5')
							<li id="personal" class="notyet"><strong>Pembayaran</strong></li>
						@elseif ($status == 'a_5_0')
							<li id="personal" class="notyet"><strong>Belum Bayar</strong></li>
						@elseif ($status == 'a_5_1')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Sales</strong></li>
						@elseif ($status == 'a_5_2')
							<li id="personal" class="fixing"><strong>Pembayaran Gagal</strong></li>
						@elseif ($status == 'a_5_3')
							<li id="personal" class="confirming"><strong>Pembayaran Terkonfirmasi</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Pembayaran</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Pembayaran</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Pembayaran</strong></li>
						@else
							<li id="account" class="confirming"><strong>Pembayaran Terkonfirmasi</strong></li>
						@endif

						@if ($status == 'a_6')
							<li id="personal" class="notyet"><strong>Penerbitan OC</strong></li>
						@elseif ($status == 'a_6_0')
							<li id="personal" class="notyet"><strong>Belum Upload OC</strong></li>
						@elseif ($status == 'a_6_1')
							<li id="personal" class="waiting"><strong>Menunggu Pelanggan Upload Ulang OC</strong></li>
						@elseif ($status == 'a_6_2')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Admin</strong></li>
						@elseif ($status == 'a_6_3')
							<li id="personal" class="fixing"><strong>Penerbitan OC Gagal</strong></li>
						@elseif ($status == 'a_6_4')
							<li id="personal" class="confirming"><strong>Penerbitan OC Terkonfirmasi</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Penerbitan OC</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Penerbitan OC</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Penerbitan OC</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Penerbitan OC</strong></li>						
						@else
							<li id="account" class="confirming"><strong>Penerbitan OC Terkonfirmasi</strong></li>
						@endif

						@if ($status == 'a_7')
							<li id="personal" class="notyet"><strong>Penjadwalan</strong></li>
						@elseif ($status == 'a_7_0')
							<li id="personal" class="notyet"><strong>Belum Dijadwalkan</strong></li>
						@elseif ($status == 'a_7_1')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Reviewer</strong></li>
						@elseif ($status == 'a_7_2')
							<li id="personal" class="fixing"><strong>Perbaikan Penjadwalan</strong></li>
						@elseif ($status == 'a_7_3')
							<li id="personal" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>						
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Penjadwalan</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Penjadwalan</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Penjadwalan</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Penjadwalan</strong></li>
						@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
							<li id="account"><strong>Penjadwalan</strong></li>
						@else
							<li id="account" class="confirming"><strong>Penjadwalan Terkonfirmasi</strong></li>
						@endif

						@if ($status == 'a_8')
							<li id="personal" class="notyet"><strong>Proses Audit Tahap 1</strong></li>						
						@elseif ($status == 'a_8_1')
							<li id="personal" class="waiting"><strong>Menunggu Verifikasi Admin</strong></li>
						@elseif ($status == 'a_8_2')
							<li id="personal" class="fixing"><strong>Perbaikan Berkas</strong></li>
						@elseif ($status == 'a_8_3')
							<li id="personal" class="confirming"><strong>Audit Tahap 1 Selesai</strong></li>						
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
							<li id="account"><strong>Proses Audit Tahap 1</strong></li>
						@else
							<li id="account" class="confirming"><strong>Proses Audit Tahap 1</strong></li>
						@endif

						@if ($status == 'a_9')
							<li id="personal" class="notyet"><strong>Pembayaran Tahap 2</strong></li>						
						@elseif ($status == 'a_9_0')
							<li id="personal" class="notyet"><strong>Belum Bayar</strong></li>
						@elseif ($status == 'a_9_1')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Sales</strong></li>
						@elseif ($status == 'a_9_2')
							<li id="personal" class="fixing"><strong>Pembayaran Gagal</strong></li>
						@elseif ($status == 'a_9_3')
							<li id="personal" class="confirming"><strong>Pembayaran Terkonfirmasi</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
							<li id="account"><strong>Pembayaran Tahap 2</strong></li>
						@else
							<li id="account" class="confirming"><strong>Pembayaran Tahap 2</strong></li>
						@endif

						@if ($status == 'a_10')
							<li id="personal" class="notyet"><strong>Proses Audit Tahap 2</strong></li>						
						@elseif ($status == 'a_10_0')
							<li id="personal" class="notyet"><strong>Belum Upload Audit Plan</strong></li>
						@elseif ($status == 'a_10_1')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Pelaku Usaha</strong></li>
						@elseif ($status == 'a_10_2')
							<li id="personal" class="fixing"><strong>Audit Plan Ditolak</strong></li>
						@elseif ($status == 'a_10_3')
							<li id="personal" class="confirming"><strong>Audit Plan Terkonfirmasi</strong></li>
						@elseif ($status == 'a_10_4')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Technical Reviewer</strong></li>
						@elseif ($status == 'a_10_5')
							<li id="personal" class="fixing"><strong>Perbaikan Laporan Audit Tahap 2</strong></li>
						@elseif ($status == 'a_10_6')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Komite Sertifikasi</strong></li>
						@elseif ($status == 'a_10_7')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Reviewer Operasi</strong></li>
						@elseif ($status == 'a_10_8')
							<li id="personal" class="confirming"><strong>Laporan Audit Tahap 2 Terkonfirmasi</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Proses Audit Tahap 2</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Proses Audit Tahap 2</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Proses Audit Tahap 2</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
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
						@endif

						@if ($status == 'a_11')
							<li id="personal" class="notyet"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_11_0')
							<li id="personal" class="waiting"><strong>Belum Upload Berita Acara</strong></li>
						@elseif ($status == 'a_11_1')
							<li id="personal" class="confirming"><strong>Menunggu Pelanggan Upload Ulang Berita Acara</strong></li>
						@elseif ($status == 'a_11_2')
							<li id="personal" class="fixing"><strong>Berita Acara Terkonfirmasi</strong></li>						
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
							<li id="account"><strong>Berita Acara</strong></li>
						@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
							<li id="account"><strong>Berita Acara</strong></li>
						@else
							<li id="account" class="confirming"><strong>Berita Acara</strong></li>
						@endif

						@if ($status == 'a_12')
							<li id="personal" class="notyet"><strong>Pelunasan</strong></li>
						@elseif ($status == 'a_12_0')
							<li id="personal" class="notyet"><strong>Belum Bayar</strong></li>
						@elseif ($status == 'a_12_1')
							<li id="personal" class="waiting"><strong>Menunggu Konfirmasi Sales</strong></li>
						@elseif ($status == 'a_12_2')
							<li id="personal" class="fixing"><strong>Pelunasan Gagal</strong></li>
						@elseif ($status == 'a_12_3')
							<li id="personal" class="confirming"><strong>Pelunasan Terkonfirmasi</strong></li>
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Pelunasan</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Pelunasan</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Pelunasan</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
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
						@endif

						@if ($status == 'a_13')
							<li id="personal" class="confirming"><strong>Proses Sidang Fatwa</strong></li>						
						@elseif ($status == 'a_1' || $status == 'a_2' || $status == 'a_2_0' || $status == 'a_2_1' || $status == 'a_2_2' || $status == 'a_2_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_3' || $status == 'a_3_0' || $status == 'a_3_1' || $status == 'a_3_2' || $status == 'a_3_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_4' || $status == 'a_4_0' || $status == 'a_4_1' || $status == 'a_4_2' || $status == 'a_4_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_5' || $status == 'a_5_0' || $status == 'a_5_1' || $status == 'a_5_2' || $status == 'a_5_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_6' || $status == 'a_6_0' || $status == 'a_6_1' || $status == 'a_6_2' || $status == 'a_6_3' || $status == 'a_6_4')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_7' || $status == 'a_7_0' || $status == 'a_7_1' || $status == 'a_7_2' || $status == 'a_7_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_8' || $status == 'a_8_1' || $status == 'a_8_2' || $status == 'a_8_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_9' || $status == 'a_9_0' || $status == 'a_9_1' || $status == 'a_9_2' || $status == 'a_9_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_10' || $status == 'a_10_0' || $status == 'a_10_1' || $status == 'a_10_2' || $status == 'a_10_3' || $status == 'a_10_4' || $status == 'a_10_5' || $status == 'a_10_6' || $status == 'a_10_7' || $status == 'a_10_8')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_11' || $status == 'a_11_0' || $status == 'a_11_1' || $status == 'a_11_2')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@elseif ($status == 'a_12' || $status == 'a_12_0' || $status == 'a_12_1' || $status == 'a_12_2' || $status == 'a_12_3')
							<li id="account"><strong>Proses Sidang Fatwa</strong></li>
						@else
							<li id="account" class="confirming"><strong>Proses Sidang Fatwa</strong></li>
						@endif
						
						{{-- @if ($value['status'] == 3)
							<li id="personal" class="active"><strong>Verifikasi Data</strong></li>						
						@elseif ($value['status'] == 4)
							<li id="personal" class="warning"><strong>Perbaiki Data Berkas</strong></li>
						@elseif ($value['status'] == 5)
							<li id="personal" class="active"><strong>Konfirmasi Data Berkas</strong></li>
						@elseif ($value['status'] > 5)
							<li id="personal" class="active"><strong>Verifikasi Data</strong></li>
						@elseif ($value['status'] == 'c' || $value['status'] == 'f')
							<li id="payment" class="active"><strong>Verifikasi Data</strong></li>						
						@elseif ($value['status'] == 'b' || $value['status'] == 'd' || $value['status'] == 'g' || $value['status'] == 'h' || $value['status'] == 'i' || $value['status'] == 'j' || $value['status'] == 'k' || $value['status'] == 'l' || $value['status'] == 'm' || $value['status'] == 'n' || $value['status'] == 'o' || $value['status'] == 'p' || $value['status'] == 'q' || $value['status'] == 'r' || $value['status'] == 's')
							<li id="payment" class="active"><strong>Verifikasi Data</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="personal" class="active"><strong>Verifikasi Data</strong></li>
						@else
							<li id="personal"><strong>Verifikasi Data</strong></li>
						@endif

						@if ($value['status'] == 6)
							<li id="payment" class="active"><strong>Akad</strong></li>	
						@elseif ($value['status'] == 7)
							<li id="payment" class="failed"><strong>Akad Gagal</strong></li>
						@elseif ($value['status'] == 8)
							<li id="payment" class="active"><strong>Akad Terkonfirmasi</strong></li>
						@elseif ($value['status'] == 'c')
							<li id="payment" class="active"><strong>Menunggu User Upload Akad</strong></li>
						@elseif ($value['status'] == 'f')
							<li id="payment" class="active"><strong>Menunggu Konfirmasi Akad</strong></li>
						@elseif ($value['status'] == 'b' || $value['status'] == 'd' || $value['status'] == 'g' || $value['status'] == 'h' || $value['status'] == 'i' || $value['status'] == 'j' || $value['status'] == 'k' || $value['status'] == 'l')
							<li id="payment" class="active"><strong>Menunggu Konfirmasi Akad</strong></li>
						@elseif ($value['status'] == 'm')
							<li id="payment" class="active"><strong>Menunggu Persetujuan Reviewer</strong></li>
						@elseif ($value['status'] == 'n')
							<li id="payment" class="active"><strong>Menunggu Persetujuan Approver</strong></li>
						@elseif ($value['status'] == 'o')
							<li id="payment" class="warning"><strong>Reviewer Menolak Akad</strong></li>
						@elseif ($value['status'] == 'p')
							<li id="payment" class="warning"><strong>Approver Menolak Akad</strong></li>
						@elseif ($value['status'] == 'q')
							<li id="payment" class="warning"><strong>Reviewer Mengkonfirmasi Akad</strong></li>
						@elseif ($value['status'] == 'r')
							<li id="payment" class="warning"><strong>Approver Mengkonfirmasi Akad</strong></li>
						@elseif ($value['status'] == 's')
							<li id="payment" class="warning"><strong>User Tidak Menyutujui Berkas Akad</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="payment" class="active"><strong>Akad</strong></li>
						@elseif ($value['status'] > 8)
							<li id="payment" class="active"><strong>Akad</strong></li>
						@else
							<li id="payment"><strong>Akad</strong></li>
						@endif

						@if ($value['status'] == 9)
							<li id="confirm" class="active"><strong>Pembayaran</strong></li>
						@elseif ($value['status'] == 10)
							<li id="confirm" class="warning"><strong>Pembayaran Kurang</strong></li>
						@elseif ($value['status'] == 11)
							<li id="confirm" class="warning"><strong>Pembayaran Lebih</strong></li>
						@elseif ($value['status'] == 12)
							<li id="confirm" class="failed"><strong>Pembayaran Gagal</strong></li>
						@elseif ($value['status'] == 13)
							<li id="confirm" class="active"><strong>Pembayaran Terkonfirmasi</strong></li>						
						@elseif ($value['status'] == 'b')
							<li id="confirm" class="failed"><strong>Cancel Order Pembayaran</strong></li>
						@elseif ($value['status'] == 'd')
							<li id="confirm" class="active"><strong>Menunggu Konfirmasi Pembayaran</strong></li>
						@elseif ($value['status'] == 'g')
							<li id="confirm" class="active"><strong>Pembayaran Tahap 2</strong></li>
						@elseif ($value['status'] == 'h')
							<li id="confirm" class="warning"><strong>Pembayaran Tahap 2 Kurang</strong></li>
						@elseif ($value['status'] == 'i')
							<li id="confirm" class="warning"><strong>Pembayaran Tahap 2 Lebih</strong></li>
						@elseif ($value['status'] == 'j')
							<li id="confirm" class="failed"><strong>Pembayaran Tahap 2 Gagal</strong></li>
						@elseif ($value['status'] == 'k')
							<li id="confirm" class="active"><strong>Menunggu Konfirmasi Pembayaran Tahap 2</strong></li>
						@elseif ($value['status'] == 'l')
							<li id="confirm" class="active"><strong>Pembayaran Tahap 2 Terkonfirmasi</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Pembayaran</strong></li>
						@elseif ($value['status'] > 13)
							<li id="confirm" class="active"><strong>Pembayaran Tahap 2</strong></li>
						@else
							<li id="confirm"><strong>Pembayaran</strong></li>
						@endif		

						@if ($value['status'] == 14)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($value['status'] > 14)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 1</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Proses Audit Tahap 1</strong></li>
						@else
							<li id="confirm"><strong>Proses Audit Tahap 1</strong></li>
						@endif

						@if ($value['status'] == 15)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 2</strong></li>
						@elseif ($value['status'] > 15)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 2</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Proses Audit Tahap 2</strong></li>
						@else
							<li id="confirm"><strong>Proses Audit Tahap 2</strong></li>
						@endif

						@if ($value['status'] == 16)
							<li id="confirm" class="active"><strong>Pelaporan Audit Tahap 2</strong></li>
						@elseif ($value['status'] == 17)
							<li id="confirm" class="active"><strong>Konfirmasi Berita Acara</strong></li>
						@elseif ($value['status'] > 17)
							<li id="confirm" class="active"><strong>Pelaporan Audit Tahap 2</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Pelaporan Audit Tahap 2</strong></li>
						@else
							<li id="confirm"><strong>Pelaporan Audit Tahap 2</strong></li>
						@endif

						@if ($value['status'] == 18)
							<li id="confirm" class="active"><strong>Tinjauan Hasil Audit</strong></li>
						@elseif ($value['status'] == 19)
							<li id="confirm" class="active"><strong>Rekomendasi Hasil Pemeriksaan</strong></li>
						@elseif ($value['status'] > 19)
							<li id="confirm" class="active"><strong>Tinjauan Hasil Audit</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Tinjauan Hasil Audit</strong></li>
						@else
							<li id="confirm"><strong>Tinjauan Hasil Audit</strong></li>
						@endif

						@if ($value['status'] == 20)
							<li id="confirm" class="active"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@elseif ($value['status'] > 20)
							<li id="confirm" class="active"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@else
							<li id="confirm"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@endif

						@if ($value['status'] == 21)
							<li id="confirm" class="active"><strong>Pelunasan</strong></li>
						@elseif ($value['status'] == 22)
							<li id="confirm" class="warning"><strong>Pelunasan Kurang</strong></li>
						@elseif ($value['status'] == 23)
							<li id="confirm" class="warning"><strong>Pelunasan Lebih</strong></li>
						@elseif ($value['status'] == 24)
							<li id="confirm" class="failed"><strong>Pelunasan Gagal</strong></li>
						@elseif ($value['status'] == 25)
							<li id="confirm" class="active"><strong>Pelunasan Terkonfirmasi</strong></li>
						@elseif ($value['status'] == 'e')
							<li id="confirm" class="active"><strong>Menunggu Konfirmasi Pelunasan</strong></li>
						@elseif ($value['status'] > 25)
							<li id="confirm" class="active"><strong>Pelunasan</strong></li>
						@else
							<li id="confirm"><strong>Pelunasan</strong></li>
						@endif
						

						@if ($value['status'] == 26)
							<li id="confirm" class="active"><strong>Proses Sertifikasi</strong></li>
						@elseif ($value['status'] == 27)
							<li id="confirm" class="active"><strong>Keputusan Halal/Haram</strong></li>
						@elseif ($value['status'] == 28)
							<li id="confirm" class="active"><strong>Sertifikat Halal</strong></li>
						@elseif ($value['status'] > 28)
							<li id="confirm" class="active"><strong>Sertifikat Halal</strong></li>
						@else
							<li id="confirm"><strong>Sertifikat Halal</strong></li>
						@endif --}}
					@endforeach	                    
                                                            																														
				</ul> <!-- fieldsets -->
			</form>
		</div>
    </div>
    <!-- end row -->
    
@endsection
@push('scripts')
<script src="{{asset('/assets/js/checkData.js')}}"></script>
<script>	

	function getProgress (data) {return checkProgress(data);}
	function getNotif (data) {return notifProgress(data);}
	data=document.getElementById("stat_val").textContent;
	/*
	document.getElementById("status").innerText = getProgresss(data);
	*/
	document.getElementById("notif_user").innerHTML = "<h6><b>"+getNotif(data)+"</h6></b>";
</script>

<script>
    setTimeout(function(){
        $('#panelGreeting').fadeOut();  
    }, 5000);
</script>


@endpush

