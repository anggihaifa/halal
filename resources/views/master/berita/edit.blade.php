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
        <li class="breadcrumb-item"><a href="#">Berita</a></li>        
        <li class="breadcrumb-item active">Edit Berita</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Berita<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Berita</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('editberita.store')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        
                        <div class="form-group row">                            
                            @csrf                                                        
                            @component('components.inputtext',['name'=> 'nama_penulis','label' => 'Nama Penulis','required'=>true,'placeholder'=>'Nama Penulis','readonly'=>true,'value'=>$user->name])@endcomponent
                            @component('components.inputtext',['name'=> 'id_user','label' => 'ID User','required'=>true,'placeholder'=>'ID User','readonly'=>true,'value'=>$user->id,'hidden'=>true])@endcomponent
                            @component('components.inputtext',['name'=> 'judul_berita','label' => 'Judul Berita','required'=>true,'placeholder'=>'Judul Berita','value'=>$berita->judul_berita,'readonly'=>false])@endcomponent
                            <input type="text" name="id_berita" value="{{$berita->id}}" hidden>                            


                            {{-- <label id="tglpublikasi" class="col-lg-4 col-form-label">Tanggal Publikasi</label>
                            <div id="dtglpublikasi" class="col-lg-8">
                                <div class="input-group date">
                                    <input id="tgl_publikasi" name="tanggal_publikasi" type="text" class="form-control" placeholder="Tanggal Publikasi"  data-date-start-date="Date.default" value="{{$berita->judul_berita}}"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div> --}}
                            <label id="jisiberita" class="col-lg-12 col-form-label">Isi Berita</label>
                            <div id="disiberita" class="col-lg-12">
                                <textarea class="form-control" name="isi_berita" id="summernote">@php echo $berita->isi_berita @endphp</textarea>
                            </div>

                            <div class="wrapper col-lg-12">
                                <div class="row">
                                    <div class="col-md-12 offset-md-5">
                                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Update</button>
                                        @component('components.buttonback',['href' => route("berita.index")])@endcomponent
                                    </div>
                                </div>
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
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    {{-- <script src="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.js')}}"></script> --}}            
    <script src="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.js')}}"></script>    
    <script>
        $('#tgl_publikasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        

        $(document).ready(function() {
            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

            $('#summernote').summernote({
                spellcheck: false,
                height: 350,
                callbacks: {
                    onImageUpload: function(files) {
                        if (!files.length) return;
                        for (var i = 0; i < files.length; i++) {                            
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            // $('#summernote').val($("#summernote").summernote('code', `<?php echo isset($konten->isi_konten) ? $konten->isi_konten : ""; ?>`));


            function uploadImage(file) {
                var data = new FormData();
                data.append('file', file);
                $.ajax({
                    url: "{{route('master.uploadimage')}}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "post",
                    success: function(url) {                        
                        // var image = $('<img>').attr('src', 'http://' + url);
                        var image = $('<img>').attr('src', 'http://' + url);
                        $('#summernote').summernote("insertNode", image[0]);
                        console.log(url);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });                
            }
        });
    </script>
@endpush