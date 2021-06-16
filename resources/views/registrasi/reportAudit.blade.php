@extends('layouts.default')

@section('title', 'Pelaporan Audit dan Berita Acara')

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
	<h1 class="page-header">Pelaporan Audit dan Berita Acara<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Pelaporan Audit dan Berita Acara</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form   class="form-horizontal form-bordered" enctype="multipart/form-data">
						
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data[0]['id']}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data[0]['no_registrasi']}}" readonly/>
							</div>

							<label class="col-lg-4 col-form-label">File Pelaporan Audit Tahap 1</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/Laporan Audit1/'.$data[0]['file_laporan_audit1']) }}" download>{{$data[0]['file_laporan_audit1']}}</a>
									</div>
							</div>  

							<label class="col-lg-4 col-form-label">Konfirmasi S&K Audit</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/Konfirmasi SK Audit/'.$data[0]['file_konfirmasi_sk_audit']) }}" download>{{$data[0]['file_konfirmasi_sk_audit']}}</a>
									</div>
							</div>  

							<label class="col-lg-4 col-form-label">File Rencana Audit</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/Rencana Audit/'.$data[0]['file_rencana_audit']) }}" download>{{$data[0]['file_rencana_audit']}}</a>
									</div>
							</div>  
														
							<label class="col-lg-4 col-form-label">File Pelaporan Audit Tahap 2</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/Laporan Audit2/'.$data[0]['file_laporan_audit_tahap_2']) }}" download>{{$data[0]['file_laporan_audit_tahap_2']}}</a>
									</div>
							</div>  

							<label class="col-lg-4 col-form-label">File Surat Tugas</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/Surat Tugas/'.$data[0]['file_surat_tugas']) }}" download>{{$data[0]['file_surat_tugas']}}</a>
									</div>
							</div>  

												
														
							<label class="col-lg-4 col-form-label">File Berita Acara Pemeriksaan</label>
							<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/laporan/download/BAP/'.$data[0]['file_bap']) }}" download>{{$data[0]['file_bap']}}</a>
									</div>
							</div>                            																					                          																					
								
							
								<div class="col-md-12 offset-md-5">
                                        @component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
																
									
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