	@extends('layouts.default')

@section('title', 'Kontrak Akad Sertifikasi Halal')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Invoice Sertifikasi Halal</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Invoice Sertifikasi Halal<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Invoice Akad Sertifikasi Halal</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfileinvoice',['id' => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
							
							<label class="col-lg-4 col-form-label">Tanggal Pelunasan</label>
							<div class="col-lg-8">
					
							<input id="tanggal_tahap3" name="tanggal_tahap3" type="text" class="form-control" value={{ $data->status_tahap3}} readonly />
							</div>

							<label class="col-lg-4 col-form-label">Upload Invoice</label>
							<div class="col-lg-8">
								<input type="file"  name="file" oninvalid="this.setCustomValidity('File kontrak akad masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required />
							</div>
							
							
							<div class="col-md-12 offset-md-5">
								
							
									@component('components.buttonback',['href' => route("listakadadmin")])@endcomponent	
									@if($dataP->status_tahap3 == 2)
										<button type="submit" class="btn btn-sm btn-success m-r-5" >Upload Invoice</button>
									@elseif($dataP->status_tahap3 == 3)
										<button type="submit" class="btn btn-sm btn-yellow m-r-5" disabled>Invoice Sudah Berhasil diupload</button>
									
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
    	$('#tanggal_tahap3').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tanggal_tahap3').datepicker('setDate', today);


       
    	


    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush