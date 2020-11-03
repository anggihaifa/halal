@extends('layouts.default')

@section('title', 'Edit Data F.A.Q')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item"><a href="#">F.A.Q</a></li>
        <li class="breadcrumb-item active">Edit Data F.A.Q</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Data F.A.Q<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Data F.A.Q</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('faq.update',['faq'=>$data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @method('PUT')

                            @component('components.inputtext',['name'=> 'question','label' => 'Pertanyaan','value'=>$data->question])@endcomponent
                            
                            @component('components.inputtextarea',['name'=> 'answer','label' => 'Jawaban','value'=>$data->answer])@endcomponent

                            <!-- <label class="col-lg-4 col-form-label">File F.A.Q</label>
                            <div class="col-lg-8">
                                <div class="form-control" readonly>
                                        @if($data->file == null)
                                            <a href="#" >-</a>
                                        @else
                                            <a href="{{url('') .Storage::url('public/master/FAQ/'.$data->file) }}" download>{{$data->file}}</a>
                                        @endif
                                    </div>
                            </div> -->

                            <!-- <label class="col-lg-4 col-form-label">Update File F.A.Q</label>
                            <div class="col-lg-8">
                                <input type="file"  name="file" />
                            </div> -->

                            @component('components.inputtext',['name'=> 'step','label' => 'Step','value'=>$data->step])@endcomponent

                            <label class="col-lg-4 col-form-label">Status</label>
                            <div class="col-lg-8">
                                <select name="status" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="nonaktif" {{ $data->status == "nonaktif" ? 'selected' : ''}}>Non Aktif</option>
                                    <option value="aktif" {{ $data->status == "aktif" ? 'selected' : ''}}>Aktif</option>
                                    <option value="transfer" {{ $data->status == "transfer" ? 'selected' : ''}}>Transfer</option>
                                    <option value="tunai" {{ $data->status == "tunai" ? 'selected' : ''}}>Tunai</option>
                                </select>
                            </div>

                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("faq.index")])@endcomponent
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
    <script src="{{asset('/assets/js/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        var answer = document.getElementById("answer");
        CKEDITOR.replace(answer,{
            language:'en-gb'
          });
        CKEDITOR.config.allowedContent = true;
    </script>
@endpush