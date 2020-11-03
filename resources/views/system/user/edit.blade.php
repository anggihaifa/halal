@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Edit Data Pengguna')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
        <li class="breadcrumb-item active">Edit Data Pengguna</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Data Pengguna<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Data Pengguna</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('user.update',['user'=>$data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @method('PUT')
                            @component('components.inputemail',['name'=> 'email','label' => 'Name','value'=>$data->email])@endcomponent
                            @component('components.inputtext',['name'=> 'username','label' => 'Username','value'=>$data->username])@endcomponent
                            @component('components.inputtext',['name'=> 'name','label' => 'Name','value'=>$data->name])@endcomponent
                            <label for="bumn" class="col-lg-4 col-form-label">Role</label>
                            <div class="col-lg-8">
                                <select id="usergroup_id" name="usergroup_id" class="form-control selectpicker" data-size="10" data-style="btn-white">
                                    @foreach($userGroup as $index =>$value)
                                        <option value="{{$value->id}}" {{$value->id == $data->usergroup_id ? 'selected' : ''}}>{{$value->usergroup}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @component('components.inputtext',['name'=> 'perusahaan','label' => 'Nama Perusahaan','value'=>$data->perusahaan])@endcomponent
                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','value'=>$data->negara])@endcomponent
                            @component('components.inputtext',['name'=> 'kota','label' => 'Kota','value'=>$data->kota])@endcomponent
                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat Perusahaan','value'=>$data->alamat])@endcomponent
                            <label class="col-lg-4 col-form-label">Status</label>
                            <div class="col-lg-8">
                                <select name="status" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                <option value="0" {{ $data->status == "0" ? 'selected' : ''}}>Inactive</option>
                                    <option value="1" {{ $data->status == "1" ? 'selected' : ''}}>Active</option>
                                </select>
                            </div>
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("user.index")])@endcomponent
                                @component('components.buttonsubmit')@endcomponent
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
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
    <script>
        $('#email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("check");
            var y = $('#email').val();
            console.log(y);
            if(!ev.test(y)){
                x.innerHTML	= "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML	= "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });
    </script>
@endpush