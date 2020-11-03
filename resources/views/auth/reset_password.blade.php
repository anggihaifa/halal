@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Reset Password')

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
                     <span><i class="ion-ios-lock"></i> | New Password</span>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{route('storenewpassword',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">    
                    @csrf
                    @method('PUT')
                    <label class="control-label">Email  <span id="check" style="padding-left: 7px;"></span></label>
                    <div class="row m-b-15">
                        <div class="col-md-12">
                            <input id="email" name="email" type="text" class="form-control" style="color:#ababab !important" value="{{$data->email}}" disabled />
                            <input  name="id" type="text" class="form-control" style="color:#ababab !important;display: none;" value="{{$data->id}}" />
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

                    <div class="login-buttons">
                        <button id="buttonSubmit" type="submit" class="btn btn-success btn-block btn-lg btn-login">Update New Password</button>
                    </div>
                </form>
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
    </script>
@endpush
