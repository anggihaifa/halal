@extends('layouts.default')

@section('title', 'Upload Report')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Upload Report</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Upload Report<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Upload Report</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfilereportadmin',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
																					
                            @if($data->file_report == null)
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload Report</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File report masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required />
								</div>															
																
                            @elseif($data->file_report != null)
                            <!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload Ulang Report</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File report masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required />
								</div>															
								

								<label class="col-lg-4 col-form-label">Report</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/bukti_report/'.$data->id_user.'/'.$data->file_report) }}" download>{{$data->file_report}}</a>
									</div>
								</div>
							@endif
								
							
								<div class="col-md-12 offset-md-5">																										
                                        @component('components.buttonback',['href' => route("listberitaacara")])@endcomponent
                                        @if($data->status_report == 0)
                                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                        @elseif($data->status_report == 1)
                                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                            <button  class="btn btn-sm btn-warning m-r-5" disabled>Menunggu persetujuan user</button>
                                        @elseif($data->status_report == 2)
                                            <button type="submit" class="btn btn-sm btn-warning m-r-5" disabled>User Telah Setuju</button>
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
        // var today = new Date();
    	// $('#tgl_akad').datepicker({
        //     format: "yyyy-mm-dd",
        //     todayHighlight: true,
        // });
        // $('#tgl_akad').datepicker('setDate', today);       


    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush