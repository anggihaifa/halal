@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Edit Data Master Kode Asset')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item"><a href="{{route("kodeasset.index")}}">Kode Asset</a></li>
        <li class="breadcrumb-item active">Edit Data Kode Asset</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Master Kode Asset<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Master Kode Asset</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('kodeasset.update',["kodeasset"=>$data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @method('PUT')
                            <label class="col-lg-4 col-form-label">Kategori</label>
                            <div class="col-lg-8">
                                <select name="kategori" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                    @if($data->kategori == "1")
                                        <option value="1" selected>Tanah dan Bangunan</option>
                                        <option value="2">Non Tanah dan Bangunan</option>
                                    @else
                                        <option value="1" >Tanah dan Bangunan</option>
                                        <option value="2" selected>Non Tanah dan Bangunan</option>
                                    @endif
                                </select>
                            </div>
                            @component('components.inputtext',['id'=>'kode_kelompok','name'=> 'kode_kelompok','label' => 'Kode Kelompok','value'=>$data->kode_kelompok])@endcomponent
                            @component('components.inputtext',['name'=> 'nama_item','label' => 'Item','value'=>$data->nama_item])@endcomponent
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("bumn.index")])@endcomponent
                                @component('components.buttonupdate')@endcomponent
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
    <script src="{{asset('/assets/js/setInput.js')}}"></script>
    <script>
        /*
        setInputFilter(document.getElementById("no_item"), function(value) {
            return /^-?\d*$/.test(value); });
        setInputFilter(document.getElementById("kode_kelompok"), function(value) {
            return /^-?\d*$/.test(value); });

        var maxLength = 5;
        $(document).ready(function(){
            $('#kode_kelompok').on('keydown keyup change', function(){
                var char = $(this).val();
                var charLength = $(this).val().length;
                if(charLength > maxLength){
                    $(this).val(char.substring(0, maxLength));}
            });
        });*/
    </script>
@endpush