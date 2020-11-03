@extends('layouts.default')

@section('title', 'Tambah Material')

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
		<li class="breadcrumb-item active">Tambah Material</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tambah Material <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
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
                    <form action="{{route('storematerial')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
						<div class="form-group row">
                            @csrf
                            <label class="col-lg-4 col-form-label">Tipe Material</label>
							<div class="col-lg-8">
								<select name="tipe_material" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="Bahan Baku + Tambahan" selected>Bahan Baku + Tambahan</option>
									<option value="Bahan Penolong">Bahan Penolong</option>
								</select>
                            </div>

                            @component('components.inputtext',['name'=> 'nama_material','label' => 'Nama Material','required'=>true,'placeholder'=>'Nama Material'])@endcomponent

                            @component('components.inputtext',['name'=> 'produsen','label' => 'Produsen','required'=>true,'placeholder'=>'Produsen'])@endcomponent

                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','required'=>true,'placeholder'=>'Negara'])@endcomponent

                            @component('components.inputtext',['name'=> 'pemasok','label' => 'Pemasok','required'=>true,'placeholder'=>'Pemasok'])@endcomponent

                            @component('components.inputtext',['name'=> 'negara_pemasok','label' => 'Negara Pemasok','required'=>true,'placeholder'=>'Negara Pemasok'])@endcomponent

                            @component('components.inputtext',['name'=> 'lembaga_halal','label' => 'Lembaga Halal','required'=>true,'placeholder'=>'Lembaga Halal'])@endcomponent

                            @component('components.inputtext',['name'=> 'no_sertifikat','label' => 'No. Sertifikat','required'=>true,'placeholder'=>'No. Sertifikat'])@endcomponent

                            <label class="col-lg-4 col-form-label">Tanggal Expired</label>
							<div class="col-lg-8">
								<div class="input-group date">
									<input id="tanggal_exp" name="tanggal_exp" type="text" class="form-control"  data-date-start-date="Date.default" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>

                            @component('components.inputtextarea',['name'=> 'catatan','label' => 'Catatan','required'=>true])@endcomponent


                            <label class="col-lg-4 col-form-label">Upload File Material</label>
							<div class="col-lg-8">
								<input type="file"  name="file_material" oninvalid="this.setCustomValidity('File material masih kosong')" oninput="setCustomValidity('')" onchange="getValue(this)"  required />
							</div>
							<div class="col-md-12 offset-md-5">
								@component('components.buttonback',['href' => route("registrasi.unggahDataSertifikasi")])@endcomponent
								<button type="submit" class="btn btn-sm btn-primary m-r-5">Submit</button>
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
    <script type="text/javascript">
        // function setInputFilter(textbox, inputFilter) {
        //     ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        //         textbox.addEventListener(event, function() {
        //         if (inputFilter(this.value)) {
        //             this.oldValue = this.value;
        //             this.oldSelectionStart = this.selectionStart;
        //             this.oldSelectionEnd = this.selectionEnd;
        //         } else if (this.hasOwnProperty("oldValue")) {
        //             this.value = this.oldValue;
        //             this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        //         } else {
        //             this.value = "";
        //         }
        //         });
        //     });
        // }
        // setInputFilter(document.getElementById("telepon"), function(value) {
        //     return /^\d*\.?\d*$/.test(value); 
        // });

    </script>

@endpush