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
		<div class="col-xl-3 col-md-6 " >
			<div class="widget widget-stats bg-blue animated zoomIn delay-2s">
				<div class="stats-icon"><i class="fa fa-desktop text-white"></i></div>
				<div class="stats-info">
					<h4>REGISTRASI AKTIF</h4>
					<a href="{{route('listregistrasipelangganaktif')}}" class="text-white"><p>{{$dataRegistrasiAktif}}</p></a>
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
					<a href="{{route('user.listpelanggan')}}" class="text-white"><p>{{$dataPelanggan}}</p></a>
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
					<a href="{{route('user.listpelanggan')}}" class="text-white"><p>{{$dataUser}}</p></a>
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
					<a href="{{route('listregistrasipelangganaktif')}}" class="text-white"><p>{{$dataRegistrasi}}</p></a>
				</div>
				<div class="stats-link">
					<a href="javascript:;" target="_top"></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
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
    <!-- end row -->    
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

