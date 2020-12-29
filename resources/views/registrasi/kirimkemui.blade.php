@extends('layouts.default')

@section('title', 'Upload Report')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Kirim File Hasil Tinjauan Komite Ke MUI</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Kirim File Hasil Tinjauan Komite<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Upload File Hasil Tinjauan Komite</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfilemui',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
																					
                            @if($data->file_mui == null)
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload File Hasil Tinjauan Komite</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File berita acara masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required />
								</div>															
																
                            @elseif($data->file_mui != null)
                            <!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload File Hasil Tinjauan Komite</label>
								<div class="col-lg-8">
									<input type="file"  name="file" oninvalid="this.setCustomValidity('File berita acara masih kosong')" oninput="setCustomValidity('')" accept="application/pdf" required />
								</div>															
								

								<label class="col-lg-4 col-form-label">File Hasil Tinjauan Komite</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/filemui/'.Auth::user()->id.'/'.$data->file_mui) }}" download>{{$data->file_mui}}</a>
									</div>
								</div>
							@endif
								
							
								<div class="col-md-12 offset-md-5">															
										@component('components.buttonback',['href' => route("listberitaacara")])@endcomponent
                                        @if($data->status_mui == 0)
                                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                        @elseif($data->status_mui == 1)
                                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                            <button  class="btn btn-sm btn-warning m-r-5" disabled>Menunggu persetujuan MUI</button>
                                        @elseif($data->status_mui == 2)
                                            <button type="submit" class="btn btn-sm btn-warning m-r-5" disabled>MUI Telah Setuju</button>
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