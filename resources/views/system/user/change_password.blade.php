@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
<!-- begin breadcrumb -->
<ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item active">Edit Data Pengguna</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Pengaturan<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Pengaturan</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>

                <div class="panel-body panel-form">
                    <form action="{{route('system.user.updatepassword')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            
                            @component('components.inputpassword',['id'=>'current-password','name'=> 'current-password','label' => 'Password Lama'])@endcomponent
                            @component('components.inputpassword2',['id'=>'password','name'=> 'password','label' => 'Password'])@endcomponent
                            <label class="col-lg-4 col-form-label" id="lblx"></label>
                            <div class="col-lg-8" id="valx">
                                <div id="pwdvalidation" >
                                    <b><span style="margin-right:10px;">Password harus terdiri dari :  </span>
                                    <span id="letter" style="margin-right:5px;">Lowercase</span>
                                    <span id="capital" style="margin-right:5px;">Capital</span>
                                    <span id="number" style="margin-right:5px;">Number</span>
                                    <span id="length" style="margin-right:5px;">8 Character</span></b>
                                </div>
                            </div>
                            @component('components.inputpassword',['id'=>'new-password-confirmation','name'=> 'new-password-confirmation','label' => 'Konfirmasi Password'])@endcomponent
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8"><span id="message"></span></div>
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("home.index")])@endcomponent
                                @component('components.buttonsubmit')@endcomponent
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/pwdvalidation.js')}}"></script>
    <script>
       $('#new-password-confirmation').on('keyup', function () {
            if ($('#password').val() == $('#new-password-confirmation').val()) {
                $('#message').html('Password Sesuai').css('color', 'green');
            } else
                $('#message').html('Password Tidak Sesuai').css('color', 'red');
        });
       
    </script>
@endpush
