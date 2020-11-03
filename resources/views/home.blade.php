@extends('layouts.default')

@section('title', 'Home')
@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
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
                <h1 class="page-header">Dashboard<small></small></h1>
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

        <!-- begin col-3 -->
		<div class="col-xl-3 col-md-6 ">
			<div class="widget widget-stats bg-blue animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-desktop text-white"></i></div>
				<div class="stats-info">
					<h4>REGISTRASI AKTIF</h4>
					<p>{{$dataRegistrasiAktif}}</p>	
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6 ">
			<div class="widget widget-stats bg-info animated zoomIn delay-3s">
				<div class="stats-icon"><i class="fa fa-link text-white"></i></div>
				<div class="stats-info">
					<h4>PELANGGAN TERDAFTAR</h4>
					<p>{{$dataPelanggan}}</p>	
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6 ">
			<div class="widget widget-stats bg-orange animated zoomIn delay-4s">
				<div class="stats-icon"><i class="fa fa-users text-white"></i></div>
				<div class="stats-info">
					<h4>PELANGGAN AKTIF</h4>
					<p>{{$dataUser}}</p>	
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-green animated zoomIn delay-5s">
				<div class="stats-icon"><i class="fa fa-clock text-white"></i></div>
				<div class="stats-info">
					<h4>TOTAL REGISTRASI</h4>
					<p>{{$dataRegistrasi}}</p>	
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
    </div>
    <!-- end row -->
    
@endsection
@push('scripts')

<script>
    setTimeout(function(){
        $('#panelGreeting').fadeOut();  
    }, 5000);
</script>

@endpush

