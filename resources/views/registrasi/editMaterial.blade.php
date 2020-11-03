@extends('layouts.default')

@section('title', 'Edit Material')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Edit Material</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Edit Material <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<a href="#" class="btn btn-sm btn-lime active"></i>No. Registrasi : {{$dataRegistrasi[0]['no_registrasi']}}</a>
					<h4 class="panel-title" style="margin-left:5px"></h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
                    <form action="{{route('updatematerial',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @method('PUT')

                            <label class="col-lg-4 col-form-label">Tipe Material</label>
							<div class="col-lg-8">
								<select name="tipe_material" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="Bahan Baku + Tambahan" {{ $data->tipe_material == "Bahan Baku + Tambahan" ? 'selected' : ''}}>Bahan Baku + Tambahan</option>
									<option value="Bahan Penolong" {{ $data->tipe_material == "Bahan Penolong" ? 'selected' : ''}}>Bahan Penolong</option>
								</select>
                            </div>

							@component('components.inputtext',['name'=> 'nama_material','label' => 'Nama Material','required'=>true,'placeholder'=>'Nama Material','value'=>$data->nama_material])@endcomponent

							@component('components.inputtext',['name'=> 'produsen','label' => 'Produsen','required'=>true,'placeholder'=>'Produsen','value'=>$data->produsen])@endcomponent

							@component('components.inputtext',['name'=> 'negara','label' => 'Negara','required'=>true,'placeholder'=>'Negara','value'=>$data->negara])@endcomponent

							@component('components.inputtext',['name'=> 'pemasok','label' => 'Pemasok','required'=>true,'placeholder'=>'Pemasok','value'=>$data->pemasok])@endcomponent

							@component('components.inputtext',['name'=> 'negara_pemasok','label' => 'Negara Pemasok','required'=>true,'placeholder'=>'Negara Pemasok','value'=>$data->negara_pemasok])@endcomponent

							@component('components.inputtext',['name'=> 'lembaga_halal','label' => 'Lembaga Halal','required'=>true,'placeholder'=>'Lembaga Halal','value'=>$data->lembaga_halal])@endcomponent

							@component('components.inputtext',['name'=> 'no_sertifikat','label' => 'No. Sertifikat','required'=>true,'placeholder'=>'No. Sertifikat','value'=>$data->no_sertifikat])@endcomponent

							<label class="col-lg-4 col-form-label">Tanggal Expired</label>
							<div class="col-lg-8">
								<div class="input-group date">
									<input id="tanggal_exp" name="tanggal_exp" type="text" class="form-control"  data-date-start-date="Date.default" value="{{$data->tanggal_exp}}"/>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>

                            @component('components.inputtextarea',['name'=> 'catatan','label' => 'Catatan','value'=>$data->catatan])@endcomponent

                            <label class="col-lg-4 col-form-label">File Material</label>
							<div class="col-lg-8">
								<div class="form-control" readonly>
										@if($data->file_material == null)
											<a href="#" >-</a>
										@else
											<a href="{{url('') .Storage::url('public/uploadDokumen/'.$data->id_user.'/'.$data->id_registrasi.'/MATERIAL/'.$data->file_material) }}" download>{{$data->file_material}}</a>
										@endif
									</div>
							</div>

                            <label class="col-lg-4 col-form-label">Update File Material</label>
							<div class="col-lg-8">
								<input type="file"  name="file_material" />
							</div>

                            
							<div class="col-md-12 offset-md-5">
								@component('components.buttonback',['href' => route("registrasi.unggahDataSertifikasi")])@endcomponent
								@component('components.buttonupdate')@endcomponent
								<!--<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-sm btn-default m-r-5">Back</button>-->
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
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <!--<script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>-->
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script>
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var d = date.getDate();
        var month = date.getMonth()+1;
        var y = date.getFullYear();
        if(d < 10 ){ d = '0'+ d;}
        if(month < 10){ month = '0'+ month; }
        var todayFormat = y+"-"+month+"-"+d ;
        $('#tanggal_exp').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        
    </script>

@endpush