@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Login Page')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin login -->
    <div class="login login-with-news-feed forlogin login-bg">
        <!-- begin news-feed -->
        <div class="news-feed"> 
            <div class="halal-logo">
                <div class="content-a">
                    <img class="animated bounceIn delay-1s" src="{{asset('/assets/img/logo/halal.png')}}" alt="" style="height: 150px;">    
                </div>
                <div class="content-b">
                    <div class="halal-title animated bounceIn delay-2s"><b>LPH</b>SUCOFINDO</div>
                    <div class="halal-subtitle animated bounceIn delay-3s">Lembaga Pemeriksa Halal</div>
                    <div class="halal-subtitle animated bounceIn delay-5s">PT Sucofindo (Persero)</div>
                </div>
            </div>
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div class="right-content right-content-custom">
            <!-- begin login-header -->            
            <div class="login-header">
                <div class="brand" style="font-family:textmeone">                
                    <img src="{{asset('/assets/img/logo/white-sci2.png')}}" alt="" /> <b>LPH</b><span>SUCOFINDO</span>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{route('authenticate')}}" method="post" class="margin-bottom-0">
                    @csrf
                    <div class="input-login form-group m-b-15">
                        <div class="label"><i class="fa fa-user"></i></div>
                        <input type="text" name="username" placeholder="username / email" autocomplete="off" required />
                    </div>
                    <div class="input-login form-group m-b-15">
                        <div class="label"><i class="fa fa-lock"></i></div>
                        <input type="text" name="password" placeholder="Password yang dienkripsi" autocomplete="off" required />
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg btn-login">Login</button>
                    </div>

                  
                </form>
                    <p class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        Belum punya akun? Klik <a href="{{route('registeruser')}}" style="color:#daf1a4">disini</a> untuk mendaftar.
                    </p>
                    <p class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        Lupa password? Klik <a href="{{route('forgotpassword')}}" style="color:#ffabab">disini</a>
                    </p>
                    <hr />
                    <p class="text-center text-grey-darker mb-0" style="color: #b3bfc5!important;">
                        &copy; PT SUCOFINDO (Persero) All Right Reserved 2020
                    </p>

                    <div style="margin-top:15px;" class="animated pulse infinite" >
                        <a href="#confirm-signout" data-toggle="modal" class="btn btn-inverse btn-block btn-lg forFaq">
                            <h5 style="margin-bottom: 0px;">
                                <img src="{{asset('/assets/img/user/faq-icon.png')}}" alt="" style="height: 30px;margin-left: -10px;">    
                                <span style="color: #89d0d4">Informasi</span>
                            </h5>
                        </a>
                    </div>

                     <div style="margin-top:15px;" class="animated pulse infinite" >
                        <a  href="{{asset('/assets/doc/manual/MANUAL GUIDELINE HALAL LPH SUCOFINDO.pdf')}}"  class="btn btn-inverse btn-block btn-lg forFaq"  download>
                            <h5 style="margin-bottom: 0px;">
                               
                                <span style="color: #89d0d4">Download Manual Guide</span>
                                
                            </h5> 
                        </a>
                    </div>

                    <div style="margin-top:15px;" >
                        <a  href="{{route('landingpage.index')}}"  class="btn btn-inverse btn-block btn-lg forFaq">
                            <h5 style="margin-bottom: 0px;">
                               
                                <span style="color: #89d0d4">Halaman Utama</span>
                                
                            </h5> 
                        </a>
                    </div>                                            
                    
                    @if(isset($notes))
                        <div class="login-info-red"><span>{{$notes}}</span></div>
                    @endif
                    @if(isset($regnotes))
                        <div class="login-info-blue"><span>{{$regnotes}}</span></div>
                    @endif
                    @if (session('statusreg'))
                        <div class="login-info-blue">
                            <span>{{ session('statusreg') }}</span>
                        </div>
                    @endif
                    @if(session('errstatus'))
                        <div class="login-info-red"><span>{{session('errstatus')}}</span></div>
                    @endif
                    @if(session('status'))
                        <div class="login-info-red"><span>{{session('status')}}</span></div>
                    @endif
            </div>
            <!-- end login-content -->
        </div>
        <!-- end right-container -->
    </div>
    <div class="modal fade" id="confirm-signout">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header faq-modal-header" style="padding: 5px 10px;">
                    <h4 class="modal-title">
                        <img class="animated bounceIn delay-3s" src="{{asset('/assets/img/user/halal-faq.png')}}" alt="" style="height: 50px;margin-left: 0px;">
                        <span>F.A.Q</span> 
                    </h4>
                </div>
                <div class="modal-body" style="max-height:415px;overflow:auto;">
                    <div id="accordion" class="accordion">
                        @foreach($dataFaq as $index => $value)
                            <!-- begin card -->
                            <div class="card">
                                <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse{{$value['id']}}" style="cursor: pointer;">
                                    <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-ask-0.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                    <span class="faq-ask">{{ucwords($value['question'])}}</span>
                                </div>
                                <div id="collapse{{$value['id']}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php echo html_entity_decode($value['answer'])?>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal"> Close</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
@endsection
