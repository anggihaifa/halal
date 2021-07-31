@extends('layouts.default')

@section('title', 'Home')
@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />    
@endpush

<style>
        .bar-chart {
        position: relative;
        width: 100%;
        margin-top: 15px;
        padding-bottom: 1px;
    }
    .bar-chart > .legend {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40px;
        margin-bottom: -45px;
        border-top: 1px solid #000;
    }
    .bar-chart > .legend > .label {
        position: relative;
        display: inline-block;
        float: left;
        width: 25%;
        text-align: center;
    }
    .bar-chart > .legend > .label:before {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        content: '';
        width: 1px;
        height: 8px;
        background-color: #000;
        margin-top: -8px;
    }
    .bar-chart > .legend > .label.last:after {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        left: auto;
        content: '';
        width: 1px;
        height: 8px;
        background-color: #000;
        margin-top: -8px;
    }
    .bar-chart > .legend > .label h4 {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .bar-chart > .chart {
        position: relative;
        width: 100%;
    }
    .bar-chart > .chart > .item {
        position: relative;
        width: 100%;
        height: 40px;
        margin-bottom: 10px;
        color: #fff;
        text-transform: uppercase;
    }
    .bar-chart > .chart > .item > .bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ff4081;
        z-index: 5;
    }
    .bar-chart > .chart > .item > .bar > .persen {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        height: 40px;
        line-height: 40px;
        padding-right: 12px;
        z-index: 15;
    }
    .bar-chart > .chart > .item > .bar > .progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #3e50b4;
        z-index: 10;
    }
    .bar-chart > .chart > .item > .bar > .progress > .title {
        display: block;
        position: absolute;
        height: 40px;
        line-height: 40px;
        padding-left: 12px;
        letter-spacing: 2px;
        z-index: 15;
    }
</style>

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
                <h1 class="page-header">Dashboard Auditor<small></small></h1>
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
		<div class="col-xl-3 col-md-6 " >
			<div class="widget widget-stats bg-blue animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-book text-white"></i></div>
				<div class="stats-info">
					<h4>JUMLAH AUDIT 1 / 2</h4>
					<a href="{{route('listaudit1')}}" class="text-white"><span style="font-size: 23px">{{$dataAudit_1}}</span></a> / 
                    <a href="{{route('listaudit2')}}" class="text-white"><span style="font-size: 23px"> {{$dataAudit_2}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-4 col-md-6 ">
			<div class="widget widget-stats bg-info animated zoomIn delay-3s">
				<div class="stats-icon"><i class="fa fa-certificate text-white"></i></div>
				<div class="stats-info">
					<h4>JUMLAH PELATIHAN YANG TELAH DIIKUTI</h4>
					{{-- <a href="{{route('user.listpelanggan')}}" class="text-white"><p>{{$dataPelanggan}}</p></a> --}}
                    <a href="#" class="text-white"><p>-</p></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-xl-4 col-md-6 ">
			<div class="widget widget-stats bg-orange animated zoomIn delay-4s">
				<div class="stats-icon"><i class="fa fa-signal text-white"></i></div>
				<div class="stats-info">
					<h4>PENILAIAN KERJA AUDITOR</h4>
					<a href="#" class="text-white"><p>-</p></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		{{-- <div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-green animated zoomIn delay-5s">
				<div class="stats-icon"><i class="fa fa-clock text-white"></i></div>
				<div class="stats-info">
					<h4>TOTAL REGISTRASI</h4>
					<a href="{{route('listregistrasipelangganaktif')}}" class="text-white"><p>{{$dataRegistrasi}}</p></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div> --}}
		<!-- end col-3 -->
		{{-- <div class="row col-xl-6">
            <div class="col-xl-12">
                <div class="card mb-4 animated zoomIn delay-5s">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                            AUDIT
                    </div> --}}
                	{{-- <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div> --}}
                {{-- </div> --}}
            {{-- </div>			                 --}}
        {{-- </div> --}}

        <figure class="highcharts-figure">
            {{-- <div id="container-speed" class="chart-container"></div>
            <div id="container-rpm" class="chart-container"></div>
            <p class="highcharts-description">
                Chart demonstrating solid gauges with dynamic data. Two separate charts
                are used, and each is updated dynamically every few seconds. Solid
                gauges are popular charts for dashboards, as they visualize a number
                in a range at a glance. As demonstrated by these charts, the color of
                the gauge can change depending on the value of the data shown.
            </p> --}}
        </figure>

		{{-- <div class="row col-xl-6">
            <div class="col-xl-12">
                <div class="card mb-4 animated zoomIn delay-5s">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                            PERFORMA
                    </div>
                    <div class="item">
                        <div class="bar">
                            <span class="persen">68%</span>
                            <div class="progress" data-persen="68">
                                <span class="title">PENGETAHUAN MySQL</span>
                            </div>
                        </div>
                    </div>                	
                </div>
            </div>			                
        </div>		 --}}
    </div>
    <!-- end row -->    
@endsection
@push('scripts')
{{-- <script src="assets/js/jquery.min.js"></script> --}}
{{-- <script src="assets/js/chart-area-demo.js"></script> --}}
<script>
$(document).ready(function(){
    barChart();
    $(window).resize(function(){
        barChart();
    });
    function barChart(){
        $('.bar-chart').find('.progress').each(function(){
            var itemProgress = $(this),
            itemProgressWidth = $(this).parent().width() * ($(this).data('persen') / 100);
            itemProgress.css('width', itemProgressWidth);
        });
    }
});

</script>

@endpush

