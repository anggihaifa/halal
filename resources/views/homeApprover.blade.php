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
                <h1 class="page-header">Dashboard Approver<small></small></h1>
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
					<h4>VERIFIKASI</h4>
					<a href="#" class="text-white"><span style="font-size: 23px">{{$dataVerifikasi}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
        <div class="col-xl-3 col-md-6 " >
			<div class="widget widget-stats bg-green animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-book text-white"></i></div>
				<div class="stats-info">
					<h4>AUDIT TAHAP 1</h4>
                    <a href="#" class="text-white"><span style="font-size: 23px"> {{$dataAudit1}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
        <div class="col-xl-3 col-md-6 " >
			<div class="widget widget-stats bg-aqua animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-book text-white"></i></div>
				<div class="stats-info">
					<h4>AUDIT TAHAP 2</h4>
                    <a href="#" class="text-white"><span style="font-size: 23px"> {{$dataAudit2}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
        <div class="col-xl-3 col-md-6 " >
			<div class="widget widget-stats bg-red animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-book text-white"></i></div>
				<div class="stats-info">
					<h4>SIDANG FATWA HALAL</h4>
                    <a href="#" class="text-white"><span style="font-size: 23px"> {{$dataSidangFatwa}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
        <div class="col-xl-3 col-md-6 ">
			<div class="widget widget-stats bg-black animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-book text-white"></i></div>
				<div class="stats-info">
					<h4>KETETAPAN HALAL</h4>
                    <a href="#" class="text-white"><span style="font-size: 23px"> {{$dataKetetapanHalal}}</span></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"><!--Lihat Detail <i class="fa fa-arrow-alt-circle-right"></i>--></a>
				</div>
			</div>
		</div>
        <div class="col-xl-9 col-md-6 " >
        </div>
        <div class="row col-xl-6">
            <div class="col-xl-12">
                <div class="card mb-4 animated zoomIn delay-5s">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                            REGISTRASI HALAL
                    </div>
                	<div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>			                
        </div>		

		<div class="row col-xl-6">
            <div class="col-xl-12">
                <div class="card mb-4 animated zoomIn delay-5s">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                            PELANGGAN BARU
                    </div>
                	<div class="card-body"><canvas id="myAreaChart2" width="100%" height="40"></canvas></div>
                </div>
            </div>			                
        </div>		
    </div>		
    @endsection
    @push('scripts')
    <script src="assets/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    {{-- <script src="assets/js/chart-area-demo.js"></script> --}}
    <script>
        setTimeout(function(){
            $('#panelGreeting').fadeOut();  
        }, 5000);
    
    var chartbulan = {!! json_encode($statistikregistrasi->toArray()) !!};
    var chartpelanggan = {!! json_encode($statistikpelanggan->toArray()) !!};
    console.log(chartpelanggan);
    var bulan=[];
    var jml=[];
    var bulan2=[];
    var jml2=[];
    chartbulan.forEach(element => {
        if(element['bulan'] == 1){
            bulan.push("Januari")
        }else if(element['bulan'] == 2){
            bulan.push("Februari")
        }else if(element['bulan'] == 3){
            bulan.push("Maret")
        }else if(element['bulan'] == 4){
            bulan.push("April")
        }else if(element['bulan'] == 5){
            bulan.push("Mei")
        }else if(element['bulan'] == 6){
            bulan.push("Juni")
        }else if(element['bulan'] == 7){
            bulan.push("Juli")
        }else if(element['bulan'] == 8){
            bulan.push("Agustus")
        }else if(element['bulan'] == 9){
            bulan.push("September")
        }else if(element['bulan'] == 10){
            bulan.push("Oktober")
        }else if(element['bulan'] == 11){
            bulan.push("Nopember")
        }else if(element['bulan'] == 12){
            bulan.push("Desember")
        }
    });
    chartpelanggan.forEach(element => {
        if(element['bulan'] == 1){
            bulan2.push("Januari")
        }else if(element['bulan'] == 2){
            bulan2.push("Februari")
        }else if(element['bulan'] == 3){
            bulan2.push("Maret")
        }else if(element['bulan'] == 4){
            bulan2.push("April")
        }else if(element['bulan'] == 5){
            bulan2.push("Mei")
        }else if(element['bulan'] == 6){
            bulan2.push("Juni")
        }else if(element['bulan'] == 7){
            bulan2.push("Juli")
        }else if(element['bulan'] == 8){
            bulan2.push("Agustus")
        }else if(element['bulan'] == 9){
            bulan2.push("September")
        }else if(element['bulan'] == 10){
            bulan2.push("Oktober")
        }else if(element['bulan'] == 11){
            bulan2.push("Nopember")
        }else if(element['bulan'] == 12){
            bulan2.push("Desember")
        }
    });
    chartbulan.forEach(element => {	
        jml.push(element['jumlah'])
    });
    chartpelanggan.forEach(element => {	
        jml2.push(element['jumlah'])
    });
    console.log(jml2);
    
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    
    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var ctx2 = document.getElementById("myAreaChart2");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        // labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September","Oktober", "November", "Desember"],		
        labels: bulan,
        datasets: [{
          label: "Registrasi Halal",
          lineTension: 0.5,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
        //   data: [5, 7, 4, 10, 15, 12, 7, 4, 10, 15, 20, 13],      
          data: jml,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: 50,
              maxTicksLimit: 10
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
    
    var myLineChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        // labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September","Oktober", "November", "Desember"],
        labels: bulan2,
        datasets: [{
          label: "Pelanggan",
          lineTension: 0.5,
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",      
        //   data: [5, 7, 4, 10, 15, 12, 7, 4, 10, 15, 20, 13],      
          data: jml2,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: 20,
              maxTicksLimit: 10
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
    
    </script>
    
    @endpush