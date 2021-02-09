@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])
{{-- @extends('layouts.landingpage') --}}

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')                                  
    <div class="container-fluid col-lg-12">       
        <div class="row col-lg-11 ml-5 mt-5">
            <!-- begin panel-body -->
            <div class="panel-body table-responsive">                     
                <div>
                        <div id="accordion" class="accordion">
                            @foreach($dataFaq as $index => $value)
                                <!-- begin card -->
                                <div class="card">
                                    <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapse{{$value['id']}}" style="cursor: pointer;">
                                        <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-ask-0.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                        <span class="faq-ask">{{ucwords($value['question'])}}</span>
                                    </div>
                                    <div id="collapse{{$value['id']}}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <?php echo html_entity_decode($value['answer'])?>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>                
            </div>
            <!-- end panel-body -->        
        </div>        
    </div>        
    
@endsection