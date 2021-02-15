@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Penjadwalan</a></li>        
        <li class="breadcrumb-item active">Audit Plan</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Audit Plan<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Audit Plan</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                
                <form action="{{route('downloadauditplan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                @csrf
                    <div class="panel-body panel-form" style="display: none">
                        @foreach($dataRegistrasi as $index => $value)
                            @component('components.inputtext',['name'=> 'jenis_audit','label' => 'Jenis Audit','required'=>true,'placeholder'=>'Jenis Audit','readonly'=>true,'value'=>$value->status_registrasi])@endcomponent
                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                            @component('components.inputtext',['name'=> 'alamat_perusahaan','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat])@endcomponent
                            @foreach($dataPenjadwalan as $index => $value2)
                                @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                            @endforeach
                        @endforeach                        
                    </div>
                    <div class="form-group row">   
                        <div class="row col-lg-12">
                            <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Audit Plan</button>
                        </div>
                    </div>
                </form>
                <form action="{{route('downloadauditplanfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                @csrf
                    <div class="panel-body panel-form" style="display:none"> 
                        @foreach($dataRegistrasi as $index => $value)
                            <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'jenis_audit','label' => 'Jenis Audit','required'=>true,'placeholder'=>'Jenis Audit','readonly'=>true,'value'=>$value->status_registrasi])@endcomponent
                                </div>
                            </div>
                            <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                </div>
                            </div>
                            <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'alamat_perusahaan','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat])@endcomponent
                                </div>
                            </div>
                            <div class="wrapper col-lg-12">
                                <div class="row">
                                    @foreach($dataPenjadwalan as $index => $value2)
                                        @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit1." s/d ".$value2->selesai_audit2])@endcomponent
                                    @endforeach
                                </div>
                            </div>                            
                        @endforeach                                
                    </div>
                    <div class="panel-body panel-form"> 
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'tujuan_audit','label' => 'Tujuan Audit','required'=>true,'placeholder'=>'Tujuan Audit'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'standar','label' => 'Standar','required'=>true,'placeholder'=>'Standar'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'lingkup_audit','label' => 'Lingkup Audit','required'=>true,'placeholder'=>'Lingkup Audit'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'lokasi_audit1','label' => 'Lokasi Audit','required'=>true,'placeholder'=>'Lokasi Audit 1'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'lokasi_audit2','label' => '','required'=>false,'placeholder'=>'Lokasi Audit 2'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'tim_audit1','label' => 'Tim Audit','required'=>true,'placeholder'=>'Tim Audit 1'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'tim_audit2','label' => '','required'=>true,'placeholder'=>'Tim Audit 2'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'tim_audit3','label' => '','required'=>true,'placeholder'=>'Tim Audit 3'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Hari 1</label>
                                <div id="shb" class="col-lg-8">
                                    <div class="input-group date">
                                        <input type="text" id="tgl_audit" name="tgl_audit" class="form-control" placeholder="Tanggal Audit" value="" data-date-start-date="Date.default" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Jam</label>
                                <div class="col-lg-8">
                                    <div class="input-group date">
                                        <input id="jam_audit" type='text' class="form-control" placeholder="Jam Audit"/>
                                        <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'Judul kegiatan','label' => 'Judul Kegiatan','required'=>true,'placeholder'=>'Judul Kegiatan'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtextarea',['name'=> 'Detail kegiatan','label' => 'Detail Kegiatan','required'=>true,'placeholder'=>'Detail Kegiatan'])@endcomponent
                            </div>
                        </div>
                        <div class="wrapper col-lg-12">
                            <div class="row">
                                @component('components.inputtext',['name'=> 'Personil','label' => 'Detail Kegiatan','required'=>true,'placeholder'=>'Detail Kegiatan'])@endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">   
                        <div class="row col-lg-12">
                            <button type="submit" class="btn btn-sm btn-primary offset-md-5">Kirim</button>
                        </div>
                    </div>
                </form>
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
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script>        
        $('#tgl_audit').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

        $('#jam_audit').datetimepicker({
            format: 'hh:ii',
            language:  'id',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,            
        });
    </script>
@endpush