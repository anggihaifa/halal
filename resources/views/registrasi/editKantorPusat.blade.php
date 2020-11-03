@extends('layouts.default')

@section('title', 'Edit Kantor Pusat')

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
		<li class="breadcrumb-item active">Edit Kantor Pusat</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Edit Kantor Pusat <small>{{$dataRegistrasi[0]['perusahaan']}}</small></h1>
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
                    <form action="{{route('updatekantorpusat',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @method('PUT')

                           	@component('components.inputtext',['name'=> 'kantor_pusat','label' => 'Nama Kantor Pusat','required'=>true,'placeholder'=>'Nama Kantor Pusat*','value'=>$data->kantor_pusat])@endcomponent

                           	@component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat*','value'=>$data->alamat])@endcomponent

                           	@component('components.inputtext',['name'=> 'kota','label' => 'Kota*','required'=>true,'placeholder'=>'Kota','value'=>$data->kota])@endcomponent

                           	@component('components.inputtext',['name'=> 'negara','label' => 'Negara*','required'=>true,'placeholder'=>'Negara','value'=>$data->negara])@endcomponent

                           	@component('components.inputtext',['name'=> 'kota','label' => 'Kota','required'=>true,'placeholder'=>'Kota','value'=>$data->kota])@endcomponent

                           	@component('components.inputtext',['name'=> 'kode_pos','label' => 'Kode Pos','required'=>false,'placeholder'=>'Kode Pos','value'=>$data->kode_pos])@endcomponent

                           	@component('components.inputtext',['name'=> 'phone','label' => 'Telepon*','required'=>true,'placeholder'=>'Telepon','value'=>$data->phone])@endcomponent

                           	@component('components.inputtext',['name'=> 'fax','label' => 'Fax','required'=>false,'placeholder'=>'Fax','value'=>$data->fax])@endcomponent

                           	@component('components.inputemail2',['name'=> 'email','label' => 'Email Kantor Pusat*','required'=>true,'labelid'=> 'labelemail','value'=>$data->email])@endcomponent

                           	@component('components.inputtext',['name'=> 'pic','label' => 'Nama PIC*','required'=>true,'placeholder'=>'Nama PIC','value'=>$data->pic])@endcomponent

                           	@component('components.inputtext',['name'=> 'pic_title','label' => 'Titel PIC','required'=>false,'placeholder'=>'Titel PIC','value'=>$data->pic_title])@endcomponent

                           	@component('components.inputtext',['name'=> 'pic_phone','label' => 'Telepon PIC*','required'=>true,'placeholder'=>'Telepon PIC','value'=>$data->pic_phone])@endcomponent

                           	@component('components.inputtext',['name'=> 'pic_mobile_phone','label' => 'Telepon Genggam PIC*','required'=>true,'placeholder'=>'Telepon Genggam PIC','value'=>$data->pic_mobile_phone])@endcomponent

                           	@component('components.inputemail2',['name'=> 'pic_email','label' => 'Email PIC*','required'=>true,'labelid'=> 'labelemailpic','value'=>$data->pic_email])@endcomponent

                           	@component('components.inputtext',['name'=> 'cp','label' => 'Nama Kontak Personal*','required'=>true,'placeholder'=>'Nama Kontak Personal','value'=>$data->cp])@endcomponent

                           	@component('components.inputtext',['name'=> 'cp_title','label' => 'Titel CP','required'=>false,'placeholder'=>'Titel CP','value'=>$data->cp_title])@endcomponent

                           	@component('components.inputtext',['name'=> 'cp_phone','label' => 'Telepon Kontak Personal*','required'=>true,'placeholder'=>'Telepon Kontak Personal','value'=>$data->cp_phone])@endcomponent

                           	@component('components.inputtext',['name'=> 'cp_mobile_phone','label' => 'Telepon Genggam Kontak Personal*','required'=>true,'placeholder'=>'Telepon Genggam Kontak Personal','value'=>$data->cp_mobile_phone])@endcomponent

                            @component('components.inputemail2',['name'=> 'cp_email','label' => 'Email Kontak Personal*','required'=>true,'labelid'=> 'labelemailcp','value'=>$data->cp_email])@endcomponent

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
        setInputFilter(document.getElementById("phone"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });
        setInputFilter(document.getElementById("pic_phone"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });
        setInputFilter(document.getElementById("pic_mobile_phone"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });
        setInputFilter(document.getElementById("cp_phone"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });
        setInputFilter(document.getElementById("cp_mobile_phone"), function(value) {
            return /^\d*\.?\d*$/.test(value); 
        });
        $('#email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("labelemail");
            var y = $('#email').val();
            //console.log(y);
            if(!ev.test(y)){
                x.innerHTML = "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML = "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });
        $('#pic_email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("labelemailpic");
            var y = $('#pic_email').val();
            //console.log(y);
            if(!ev.test(y)){
                x.innerHTML = "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML = "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });
        $('#cp_email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("labelemailcp");
            var y = $('#cp_email').val();
            //console.log(y);
            if(!ev.test(y)){
                x.innerHTML = "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML = "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });

    </script>

@endpush