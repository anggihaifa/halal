@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tambah Data Master Akomodasi')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item"><a href="#">Akomodasi</a></li>
        <li class="breadcrumb-item active">Tambah Data Master Akomodasi</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Tambah Dagta Master Akomodasi<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Tambah Data Master Akomodasi</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('akomodasi.store')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf

                            @component('components.inputselect',['name'=>'jenis_akomodasi','label'=>'Jenis Akomodasi','options'=>$jenis_akomodasi,'labelKey'=>'jenis_akomodasi','required'=>true])@endcomponent


                            @component('components.inputtext',['name'=> 'detail_akomodasi','label' => 'Detail Akomodasi'])@endcomponent
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("akomodasi.index")])@endcomponent
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
@endpush