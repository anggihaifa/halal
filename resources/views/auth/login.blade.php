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
            @php
                $maintenance = 0;
            @endphp
            <!-- begin login-header -->            
            <div class="login-header">
                <div class="brand" style="font-family:textmeone">                
                    <img src="{{asset('/assets/img/logo/white-sci2.png')}}" alt="" /> <b>LPH</b><span>SUCOFINDO</span>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-content -->
            @if ($maintenance == 1)
                <div class="login-content">                
                    <h2 class="text-center text-grey-darker mb-5" style="color: #d6dee2!important;margin-top: 10px;margin-bottom: -5px !important;">
                        UNDER MAINTENANCE
                    </h2>                                                                                                                                             
                </div>
            @else
                <div class="login-content">
                    <form action="{{route('authenticate')}}" method="post" class="margin-bottom-0">
                        @csrf
                        <div class="input-login form-group m-b-15">
                            <div class="label"><i class="fa fa-user"></i></div>
                            <input type="text" name="username" placeholder="username / email" autocomplete="off" required />
                        </div>
                        <div class="input-login form-group m-b-15">
                            <div class="label"><i class="fa fa-lock"></i></div>
                            <input type="password" name="password" placeholder="password" autocomplete="off" required />
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
            @endif            
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

    <div id="modalMaintenance" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">List Perubahan LPH SUCOFINDO 2.0</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>                
                    <div class="modal-body">                        
                       <table>
                           <tr>
                               <td>1. Update Tampilan Registrasi</td>
                            </tr>
                            <tr>
                                <td>2.	Update Tampilan Pengaturan Profile</td>
                             </tr>
                             <tr>
                                <td>3. Update Tampilan List Registrasi</td>
                             </tr>
                             <tr>
                                <td>4. Update Tampilan Dashboard</td>
                             </tr>
                             <tr>
                                <td>5. Update Tampilan Progres Status dan Log Kegiatan</td>
                             </tr>
                             <tr>
                                <td>6. Update Tampilan Submenu Pembayaran</td>
                             </tr>
                             <tr>
                                <td>7. Update Tampilan Subbmenu Akad</td>
                             </tr>
                             <tr>
                                <td>8. Update Tampilan Submenu Order Confitmation</td>
                             </tr>
                             <tr>
                                <td>9. Update Tampilan Submenu Laporan Audit Dan Berita Acara</td>
                             </tr>
                             <tr>
                                <td>10. Penambahan Menu Unduh Form</td>
                             </tr>
                       </table>
                    </div>
                    <div class="modal-footer">
                       
                    </div>                
            </div>            
        </div>
    </div>
    <!-- end login -->
@endsection

@push('scripts')
<script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
<script>
    
    $(document).ready(function(){
        $("#modalMaintenance").modal('show');
    });

</script>
@endpush
