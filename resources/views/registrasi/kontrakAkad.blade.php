@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Kontrak Akad Sertifikasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Kontrak Akad Sertifikasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Kontrak Akad Sertifikasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfileakaduser',['id' => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							
							<label class="col-lg-4 col-form-label">Tanggal Akad</label>
							<div class="col-lg-8">
							@if($data->status_akad == 0 )

								<input id="tgl_akad" name="tgl_akad" type="text" class="form-control"/>
							@else
								<input id="tgl_akad" name="tgl_akad" type="text" class="form-control" value={{ $data->status_akad}} readonly />
							@endif
							</div>
							<label class="col-lg-4 col-form-label">Skala Usaha</label>
							<div class="col-lg-8">
								<input id="skala_usaha" class="form-control"  name="skala_usaha" value={{ $data->skala_usaha }} type="text" readonly/>
                              
                            </div>
							
							
							<label class="col-lg-12 col-form-label">Biaya Sertifikasi</label>
							
							<label class="col-lg-4 col-form-label">Mata Uang</label>
							<div class="col-lg-8">
								<input id="mata_uang" name="mata_uang" type="text" class="form-control "  readonly value={{$data->mata_uang}}>
	                        </div>  
																				
							<label class="col-lg-4 col-form-label">Total Biaya Sertifikasi</label>
							<div class="col-lg-8">
								<input id="total_biaya" name="total_biaya" type="text" class="form-control " readonly value={{$data->total_biaya}}  />
							</div>

							@if($data->status_akad == 1)
								<!--Auto Download-->
							<label class="col-lg-4 col-form-label">Kontrak Akad</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
									<a href="{{url('') .Storage::url('public//buktiakad/'.Auth::user()->id.'/'.$data->file_akad) }}" download>{{$data->file_akad}}</a>
								</div>
							</div>
							<label class="col-lg-4 col-form-label">Upload Kontrak Akad</label>
							<div class="col-lg-8">
								<input type="file"  name="file" id="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" onchange="getValue('file')"/>
							</div>

							<label class="col-lg-4 col-form-label">Catatan (Diisi jika kontrak akad tidak sesuai menurut anda)</label>
							<div class="col-lg-8">
								<input id="catatan_user" name="catatan_user" type="text" class="form-control" placeholder="Catatan"/>
							</div>
							
							@elseif($data->status_akad==2 || $data->status_akad==3 )
								

							<label class="col-lg-4 col-form-label">Kontrak Akad</label>
							<div id="sh" class="col-lg-8">
								<div class="form-control" readonly>
									<a href="{{url('') .Storage::url('public/buktiakad/'.Auth::user()->id.'/'.$data->file_akad) }}" download>{{$data->file_akad}}</a>
								</div>
							</div>
							@endif

							
								
							
							<div class="col-md-12 offset-md-5">
								
							
							@component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent	
							@if($data->status_akad == 1 || $data->status_akad == 2)
								<button  type = "sumbit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin mengunggah berkas kontrak akad ?????')">Konfirmasi</button>
								@if($data->status_akad == 1)
									<button type="submit" name="tidaksetuju" value="Tidak Setuju" class="btn btn-sm btn-warning m-r-5">Tidak Setuju</button>
									<button class="btn btn-sm btn-warning m-r-5" disabled="">Menunggu File Upload User</button>									
								@else
									<button type="submit" class="btn btn-sm btn-green m-r-5" disabled>Akad Sedang Diproses</button>
								@endif
							<!-- @elseif($data->status_akad == 2)
								<button type="submit" class="btn btn-sm btn-green m-r-5" disabled>Akad Sedang Diproses</button> -->
							@elseif($data->status_akad == 3)
								<button type="submit" class="btn btn-sm btn-success m-r-5" disabled>Akad Sudah Dikonfirmasi</button>
							@elseif($data->status_akad == 0)
								<button class="btn btn-sm btn-yellow m-r-5" disabled="">Menunggu File Kontrak Diupload oleh Admin</button>
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

		function getValue(y){
	    	const x  = document.getElementById(y);

	    	// var length = x.files[0];
	    	// console.log(length);

	        var getSize = x.files[0].size;
	        //var maxSize = 5120*1024;
	        var maxSize = 2048*1024;
	        var values = x.value;
	        var ext = values.split('.').pop();
	        if(getSize > maxSize){
	                alert("File terlalu besar, ukuran file maksimal 2MB");
	                x.value = "";
	                return false;
	        }

	          
	    }
		


    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush