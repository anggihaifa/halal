@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.css')}}" rel="stylesheet" />    
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Pelatihan</a></li>        
        <li class="breadcrumb-item active">Detail Pelatihan</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Detail Pelatihan<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Detail Pelatihan</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">

                    <div class="col-lg-12" class="center">
                        <img src="{{url('') .Storage::url('pelatihan/'.$pelatihan->gambar_cover) }}" style="width: 80%">
                        <label class="col-12 col-form-label"><h2>@php echo $pelatihan->judul_pelatihan @endphp</h2></label>
                        <label class="col-12 col-form-label"><p>@php echo $pelatihan->created_at @endphp</p></label>
                    </div>                        
                    <div class="col-lg-12" class="center">
                        <label class="col-12 col-form-label">@php echo $pelatihan->isi_pelatihan @endphp</label>
                    </div>
                </div>

                <div class="wrapper col-lg-12">
                    <div class="row">
                        <div class="col-md-12 offset-md-5">                                        
                            @component('components.buttonback',['href' => route("pelatihan.index")])@endcomponent
                        </div>
                    </div>
                </div>                            
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection