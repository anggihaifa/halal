@extends('layouts.default')

@section('title', 'Master F.A.Q')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Guideline</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Master Guideline  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Master Guideline </h4>
            <div class="panel-heading-btn">                
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->

        <div class="widget widget-stats bg-inverse animated zoomIn delay-5s">				
				<div class="stats-info text-center">
                    {{-- <h4>Guideline Belum Tersedia</h4>                   --}}                    
                    @if($user->usergroup_id == 1)
                    <img src="{{asset('/assets/img/guideline/guideline2.jpg')}}" style="width: 100%;" alt="" />
                    @else
                    <img src="{{asset('/assets/img/guideline/guideline.jpg')}}" style="width: 100%;" alt="" />
                    @endif
                </div>				
		</div>
        
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection