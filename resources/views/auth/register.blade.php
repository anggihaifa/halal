@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Register Page')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin login -->
    <div class="login login-with-news-feed pattern-bg">
        <!-- begin news-feed -->
        <div class="news-feed register-bg"> 
            <div class="distract-bg"></div>
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div class="right-content right-content-register">
            <!-- begin login-header -->
            <div class="login-header">
                <div class="brand" style="font-family:textmeone">
                     <span><i class="ion-ios-person"></i> | Pendaftaran </span>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{route('register.store')}}" method="post" class="margin-bottom-0">
                    @csrf
                    <label class="control-label">Email<span class="text-danger"> *</span>  <span id="check" style="padding-left: 7px;"></span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input id="email" name="email" type="text" class="form-control" placeholder="email@example.com" required />
						</div>
					</div>
					<label class="control-label">Username<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input name="username" type="text" class="form-control" placeholder="username" required />
						</div>
                    </div>
                    <label class="control-label">Name<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input name="name" type="text" class="form-control" placeholder="username" required />
						</div>
					</div>
                    <label class="control-label">Password<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input id="password" name="password" type="password" class="form-control" placeholder="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password harus terdiri dari huruf, huruf kapital, angka, dan minimal terdapat 8 karakter" required />
						</div>
                    </div>
                    <label class="control-label" id="lblx"></label>
                    <div class="row m-b-15" id="valx">
                        <div class="col-md-12" id="pwdvalidation" style="color:grey;" >
                            <b><span style="margin-right:10px;">Password harus terdiri dari :  </span>
                            <span id="letter" style="margin-right:5px;">Lowercase</span>
                            <span id="capital" style="margin-right:5px;">Capital</span>
                            <span id="number" style="margin-right:5px;">Number</span>
                            <span id="length" style="margin-right:5px;">8 Character</span></b>
                        </div>
                    </div>
                    <label class="control-label">Konfirmasi Password<span class="text-danger"> *</span>  <span id="message"></span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input id="confirmpassword" name="confirmpassword" type="password" class="form-control" placeholder="konfirmasi password" minlength="8" pattern=".{8,}" title="8 or more characters" required />
						</div>
                    </div>
                    <label class="control-label">Nama Perusahaan<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input name="perusahaan" type="text" class="form-control" placeholder="nama perusahaan" required />
						</div>
                    </div>
                    <label class="control-label">Negara<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input name="negara" type="text" class="form-control" placeholder="negara" required />
						</div>
                    </div>
                    <label class="control-label">Kota<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input name="kota" type="text" class="form-control" placeholder="kota" required />
						</div>
					</div>
                    <label class="control-label">Alamat Perusahaan<span class="text-danger"> *</span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
                            <textarea name="alamat" class="form-control" placeholder="alamat perusahaan" required ></textarea>
						</div>
                    </div>

                    <div class="checkbox checkbox-css m-b-30">
						<div class="checkbox checkbox-css m-b-30">
							<input type="checkbox" id="agreement_checkbox" value="">
							<label for="agreement_checkbox">
							Dengan mengklik Daftar, Anda menyetujui <a href="#">Ketentuan</a> kami dan Anda telah membaca <a href="#">Kebijakan Data</a> kami, termasuk Penggunaan <a href="#">Cookie</a>.
							</label>
						</div>
					</div>

                    <div class="login-buttons">
                        <button id="buttonSubmit" type="submit" class="btn btn-success btn-block btn-lg btn-login">Register</button>
                    </div>
                </form>
                    <p class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        Sudah memiliki akun? Klik <a href="{{route('login')}}" style="color:#8bf161">disini</a> untuk login.
                    </p>
                    <hr />
                    <p class="text-center text-grey-darker mb-0" style="color: #b3bfc5!important;">
                        &copy; PT SUCOFINDO (Persero) All Right Reserved 2020
                    </p>
                    @if(isset($notes))
                        <div class="login-info-red"><span>{{$notes}}</span></div>
                    @endif
                    @if(session('status'))
                        <div class="login-info-red"><span>{{session('status')}}</span></div>
                    @endif
                    @if(session('errstatus'))
                        <div class="login-info-red"><span>{{session('errstatus')}}</span></div>
                    @endif
                    
            </div>
            <!-- end login-content -->
        </div>
        <!-- end right-container -->
    </div>
    <!-- end login -->
@endsection
@push('scripts')
<script src="{{asset('/assets/js/pwdvalidation.js')}}"></script>
    <script>
        $('#confirmpassword').on('keyup', function () {
            if ($('#password').val() == $('#confirmpassword').val()) {
                $('#message').html('Password Sesuai').css('color', '#4dea59');
            } else
                $('#message').html('Password Tidak Sesuai').css('color', '#ea4d4d');
        });
        $('#email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("check");
            var y = $('#email').val();
            //console.log(y);
            if(!ev.test(y)){
                x.innerHTML	= "Not a valid email";
                x.style.color = "#ea4d4d"
            }else{
                x.innerHTML	= "<i class='fa fa-check'></i>";
                x.style.color = "#4dea59"
            }

        });
        if($('#agreement_checkbox').prop("checked") == true){
                $("#buttonSubmit").removeClass("disable");
                $("#buttonSubmit").prop("disabled",false);
            }
            else if($(this).prop("checked") == false){
                $("#buttonSubmit").addClass("disable");
                $("#buttonSubmit").prop("disabled",true);
        }
        $('#agreement_checkbox').click(function(){
            if($(this).prop("checked") == true){
                $("#buttonSubmit").removeClass("disable");
                $("#buttonSubmit").prop("disabled",false);
            }
            else if($(this).prop("checked") == false){
                $("#buttonSubmit").addClass("disable");
                $("#buttonSubmit").prop("disabled",true);
            }
        });
    </script>
@endpush
