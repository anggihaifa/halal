@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])
{{-- @extends('layouts.landingpage') --}}

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')                                  
    <div class="container-fluid col-lg-12">       
        <div class="row col-lg-12 ml-5">
           <img src="{{asset('/assets/img/guideline/userguide2.jpg')}}" style="width: 90%;" class="mt-5" />
        </div>        
    </div>        
    
@endsection