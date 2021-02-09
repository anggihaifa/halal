@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')      

    <div class="container-fluid col-lg-12">        
        <div class="row col-lg-12 ml-5">
            <div class="wrapper col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            @component('components.buttonback',['href' => route('landingpage.index')])@endcomponent
                        </div>
                    </div>
            </div>                            
            <div class="panel-body panel-form col-lg-8">

                    <div class="col-lg-12" class="center">
                        <label class="col-12 col-form-label"><h2>@php echo $berita->judul_berita @endphp</h2></label>
                        <label class="col-12 col-form-label"><p>@php echo $berita->created_at @endphp</p></label>
                    </div>                        
                    <div class="col-lg-12" class="center">
                        <label class="col-12 col-form-label">@php echo $berita->isi_berita @endphp</label>
                    </div>
            </div>
            <div class="panel-body panel-form col-lg-4">
                <div class="container-fluid col-lg-12">        
                    <div class="ml-5">
                        <span class="col-lg-12 col-form-label"><h3>Berita Lainnya</h3></span>
                        @foreach ($berita_all as $item)
                            @if ($item->id == $berita->id)
                            @else
                            <div class="row col-lg-10 border mb-3 p-10" style="min-height: 100px;">
                                <p class="col-sm-12">{{$item->created_at}}</p>
                                <a href="{{url('detail_berita_user')}}/{{$item->id}}" class="text-dark"><h6 class="col-sm-12">{{$item->judul_berita}}</h6></a>
                                {{-- <a class="col-sm-12 btn btn-outline-primary float-right">Detail</a> --}}
                            </div>
                            @endif
                        @endforeach            
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>        
    
@endsection