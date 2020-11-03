@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Lupa Password')

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
                     <span><i class="ion-ios-lock"></i> | Lupa Password</span>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{route('sendresetpassword')}}" method="post" class="margin-bottom-0">
                    @csrf
                    <label class="control-label">Email<span class="text-danger"> *</span>  <span id="check" style="padding-left: 7px;"></span></label>
					<div class="row m-b-15">
						<div class="col-md-12">
							<input id="email" name="email" type="text" class="form-control" placeholder="email@example.com" required />
						</div>
					</div>

                    <div class="login-buttons">
                        <button id="buttonSubmit" type="submit" class="btn btn-success btn-block btn-lg btn-login">Send Email</button>
                    </div>
                </form>
                    <p class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        
                    </p>
                    <p class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        Kembali ke halaman login? Klik <a href="{{route('login')}}" style="color:#8bf161">disini</a>
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
    </script>
@endpush
