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
			<div class="widget widget-stats bg-primary animated zoomIn delay-2s">
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
					<p>{{$totalRegistrasiUser}}</p>	
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
							<div><span>{{$value['no_registrasi']}}</span></div>
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
			<h4 style="color: #348fe2; margin-bottom: 30px;">PROGRESS</h4>
                <!-- progressbar -->
                <ul id="progressbar">
					@foreach($dataCurrent as $key => $value)	
						@if ($value['status'] >= 1)
							<li id="account" class="active"><strong>Pengajuan Baru</strong></li>
						@else
							<li id="account"><strong>Pengajuan Baru</strong></li>
						@endif

						@if ($value['status'] >= 3)
							<li id="personal" class="active"><strong>Verifikasi Data</strong></li>
						@else
							<li id="personal"><strong>Verifikasi Data</strong></li>
						@endif

						@if ($value['status'] >= 6)
							@if ($value['status'] == 7)
								<li id="payment" class="failed"><strong>Akad</strong></li>
							@else
								<li id="payment" class="active"><strong>Akad</strong></li>
							@endif
						@else
							<li id="payment"><strong>Akad</strong></li>
						@endif

						@if ($value['status'] >= 9)
							@if ($value['status'] == 10 || $value['status'] == 11)
								<li id="confirm" class="warning"><strong>Pembayaran</strong></li>
							@elseif ($value['status'] == 12)
								<li id="confirm" class="failed"><strong>Pembayaran</strong></li>
							@else
								<li id="payment" class="active"><strong>Pembayaran</strong></li>
							@endif							
						@else
							<li id="confirm"><strong>Pembayaran</strong></li>
						@endif

						@if ($value['status'] >= 14)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 1</strong></li>
						@else
							<li id="confirm"><strong>Proses Audit Tahap 1</strong></li>
						@endif

						@if ($value['status'] >= 15)
							<li id="confirm" class="active"><strong>Proses Audit Tahap 2</strong></li>
						@else
							<li id="confirm"><strong>Proses Audit Tahap 2</strong></li>
						@endif

						@if ($value['status'] >= 16)
							<li id="confirm" class="active"><strong>Pelaporan Audit Tahap 2</strong></li>
						@else
							<li id="confirm"><strong>Pelaporan Audit Tahap 2</strong></li>
						@endif

						@if ($value['status'] >= 18)
							<li id="confirm" class="active"><strong>Tinjauan Hasil Audit</strong></li>
						@else
							<li id="confirm"><strong>Tinjauan Hasil Audit</strong></li>
						@endif

						@if ($value['status'] >= 20)
							<li id="confirm" class="active"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@else
							<li id="confirm"><strong>Hasil Dikirimkan Ke MUI</strong></li>
						@endif

						@if ($value['status'] >= 21)
							@if ($value['status'] == 24)
								<li id="confirm" class="failed"><strong>Pelunasan</strong></li>
							@elseif ($value['status'] == 22 || $value['status'] == 23)
								<li id="confirm" class="warning"><strong>Pelunasan</strong></li>
							@else
								<li id="confirm" class="active"><strong>Pelunasan</strong></li>
							@endif														
						@else
							<li id="confirm"><strong>Pelunasan</strong></li>
						@endif

						@if ($value['status'] >= 28)
							<li id="confirm" class="active"><strong>Sertifikat Halal</strong></li>
						@else
							<li id="confirm"><strong>Sertifikat Halal</strong></li>
						@endif
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
	document.getElementById("status").innerText = getProgress(data);
	*/
	document.getElementById("notif_user").innerText = getNotif(data);
</script>

<script>
    setTimeout(function(){
        $('#panelGreeting').fadeOut();  
    }, 5000);
</script>


@endpush

