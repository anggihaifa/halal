@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tambah Data Dokumen Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Dokumen Hala</a></li>
        <li class="breadcrumb-item active">Tambah Data Dokumen Halal</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Tambah Data Dokumen Halal<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Tambah Data Dokumen Halal</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('dokumen.store')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf

                            
                            <label class="col-lg-4 col-form-label">Nama File</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="nama_file" name="nama_file" placeholder="Masukan Nama File" required>
                            </div>

                            <label for="file" class="col-lg-4 col-form-label">Upload File</label>
                            <div class="col-lg-8">
                                <input type="file" class="form-control-input" name="file" id="file" required />
                            </div>

                            <label class="col-lg-4 col-form-label">Kategori Role</label>
                            <div class="col-lg-8">
                                <select id="role" name="role" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required="">
                                    <option value="">==Pilih Kategori Role==</option>
                                    <option value="pelanggan">Pelanggan</option>
                                    <option value="user">Karyawan PT SUCOFINDO</option>                                                               
                                </select>
                            </div>

                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("dokumen.index")])@endcomponent
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