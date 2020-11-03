@extends('layouts.default')

@section('title', 'Detail Data F.A.Q')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item"><a href="#">F.A.Q</a></li>
        <li class="breadcrumb-item active">Detail Data F.A.Q</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Detail Data F.A.Q<small>{{$data->id}}</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Detail Data F.A.Q</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                	<form class="form-horizontal form-bordered" >
                		<div class="form-group row">
                            @csrf
                            @method('PUT')

                            @component('components.fordetail',['label' => 'Pertanyaan','value'=>$data->question])@endcomponent

                            <label class="col-lg-4 col-form-label">Jawaban</label>
                            <div class="col-lg-8">
                                <div class="form-control" style="max-height: 400px;overflow: auto;height: auto;word-break: break-word;" readonly>
                                	<?php echo html_entity_decode($data->answer)?>        
                                </div>
                            </div>

                            <label class="col-lg-4 col-form-label">File F.A.Q</label>
                            <div class="col-lg-8">
                                <div class="form-control" readonly>
                                        @if($data->file == null)
                                            <a href="#" >-</a>
                                        @else
                                            <a href="{{url('') .Storage::url('public/master/FAQ/'.$data->file) }}" download>{{$data->file}}</a>
                                        @endif
                                    </div>
                            </div>

                            @component('components.fordetail',['label' => 'Step','value'=>$data->step])@endcomponent

                            <label class="col-lg-4 col-form-label">Status</label>
                            <div class="col-lg-8">
                                <select name="status" class="form-control selectpicker disable" data-size="10" data-live-search="true" data-style="btn-white" disabled="">
                                	<option value="0" {{ $data->status == "nonaktif" ? 'selected' : ''}} >Non Aktif</option>
                                    <option value="1" {{ $data->status == "aktif" ? 'selected' : ''}} >Aktif</option>
                                    <option value="2" {{ $data->status == "transfer" ? 'selected' : ''}} >Transfer</option>
                                    <option value="3" {{ $data->status == "tunai" ? 'selected' : ''}} >Tunai</option>
                                </select>
                            </div>

                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("faq.index")])@endcomponent
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