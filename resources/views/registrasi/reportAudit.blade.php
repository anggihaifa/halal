@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Report Audit</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Report Audit<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Report Audit</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.accauditadmin',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
														
							<label class="col-lg-4 col-form-label">File Report Audit</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/buktireport/'.Auth::user()->id.'/'.$data->file_report) }}" download>{{$data->file_report}}</a>
									</div>
							</div>  							
														
							<label class="col-lg-4 col-form-label">File Report Berita Acara</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/beritaacara/'.Auth::user()->id.'/'.$data->file_berita_acara) }}" download>{{$data->file_berita_acara}}</a>
									</div>
							</div>                            																					                          																					
								
							
								<div class="col-md-12 offset-md-5">
                                        @component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
										@if($data->status_report == 0 and $data->status_berita_acara == 0)											
											<button  class="btn btn-sm btn-warning m-r-5" disabled>Menunggu File Report Audit Dari Admin</button>
										@elseif($data->status_report == 1 and $data->status_berita_acara == 1)
											<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
										@elseif($data->status_report == 2 and $data->status_berita_acara == 2)
											<button type="submit" class="btn btn-sm btn-success m-r-5" disabled>Report Audit Sudah Dikonfirmasi</button>										
										@endif								
									
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
	<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript">
    	//var date = new Date();
        var today = new Date();
    	$('#tgl_akad').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_akad').datepicker('setDate', today);


        function jml(){

    		 
    		 var nominal1 = parseInt(removeCommas(document.getElementById('biaya_pemeriksaan').value)); 
    		 var nominal2 = parseInt(removeCommas(document.getElementById('biaya_pengujian').value));
    		 var nominal3 = parseInt(removeCommas(document.getElementById('biaya_fatwa').value));

			
			if (isNaN(nominal1)){

				nominal1 = parseInt("0");
				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			

			}else if (isNaN(nominal2)){

				nominal2 = parseInt("0");

				if (isNaN(nominal1)){

					nominal1 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			}else if (isNaN(nominal3)){

				nominal3 = parseInt("0");

				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal1)){

					nominal1 = parseInt("0");

				}

			}
			var jumlah = nominal1+nominal2+nominal3;
    		
    		console.log(nominal1);
    		console.log(nominal2);
    		console.log(nominal3);
    		//console.log(jumlah);
			document.getElementById('total_biaya').value= jumlah;
    	}
    	function removeCommas(str) {
		    while (str.search(",") >= 0) {
		        str = (str + "").replace(',', '');
		    }
		    return str;
		};
		


    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush