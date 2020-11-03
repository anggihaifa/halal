@extends('layouts.default')

@section('title', 'Tambah Fasilitas')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="#">Registrasi</a></li>
		<li class="breadcrumb-item">Unggah Data Sertifikasi</li>
		<li class="breadcrumb-item active">Tambah Fasilitas</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Tambah Fasilitas <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
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
                    <form action="{{route('storefasilitas')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
						<div class="form-group row">
                            @csrf
							@component('components.inputtext',['name'=> 'fasilitas','label' => 'Nama Fasilitas','required'=>true,'placeholder'=>'Nama Fasilitas'])@endcomponent

                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat','required'=>true])@endcomponent

                            @component('components.inputtext',['name'=> 'kota','label' => 'Kota','required'=>true,'placeholder'=>'Kota'])@endcomponent

                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','required'=>true,'placeholder'=>'Negara'])@endcomponent

                            @component('components.inputtext',['id'=>'telepon','name'=> 'telepon','label' => 'Telepon','required'=>true,'placeholder'=>'Telepon'])@endcomponent

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
    <script>
       
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
                });
            });
        }
        setInputFilter(document.getElementById("telepon"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });

    </script>

@endpush