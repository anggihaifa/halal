@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')  
    <div class="containercol-lg-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner h-100 bg-light">
                <div class="carousel-item active" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="First slide" style="min-height:400px; background: #b9b9b9">
                    <div class="carousel-caption d-none d-md-block w-100">
                        <h2 class="text-white">Pertemuan Auditor</h2>
                        <p style="font-size: 15px;">Pertemuan auditor semua cabang Sucofindo</p>
                    </div>                    
                </div>
                <div class="carousel-item" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="First slide" style="min-height:400px; background: #b9b9b9">                    
                    <div class="carousel-caption d-none d-md-block w-100">
                        <h2 class="text-white">Pertemuan Auditor</h2>
                        <p style="font-size: 15px;">Pertemuan auditor semua cabang Sucofindo</p>
                    </div>                    
                </div>
                <div class="carousel-item" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="First slide" style="min-height:400px; background: #b9b9b9">                    
                    <div class="carousel-caption d-none d-md-block w-100">
                        <h2 class="text-white">Pertemuan Auditor</h2>
                        <p style="font-size: 15px;">Pertemuan auditor semua cabang Sucofindo</p>
                    </div>                    
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
    </div>              
      
    <div class="container col-lg-12 ">
        <div class="col-lg-12 rounded text-center p-30">
            <form action="{{route('landingpage.cariproduk')}}" method="get" name="produkForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <input style="font-size: 16px;height: 50px;" type="search" class="form-control text-center rounded" style="height: 50px;text-size:15px;" name="katakunci" placeholder="Masukan No Registrasi/No Sertifikat" aria-label="Search" aria-describedby="search-addon" required/>
                </div>
                <div class="col-lg-12">
                <br>
                <button type="submit" class="btn btn-outline-primary btn-md">Cari Produk</button>
                </div>
            </form>
        </div>                        
    </div>    
        @if(isset($produk))  
        @if(isset($cek))
        @else      
        <div class="container-fluid">
        <div class="col-lg-12 rounded mt-5 mb-4">
            <div class="row col-lg-12 d-flex justify-content-center">
            <h4 class="col-lg-12 text-center text-primary">Hasil Pencarian Produk</h4>
            @if (count($produk) == 0)
                <div class="row text-warning p-15 text-center ">
                    <p class="h6">Produk yang dicari tidak ditemukan</p>
                </div>
            @else                            
                @php $no=1; @endphp
                @foreach ($produk as $item2)
                    <div class="row border p-15 col-lg-12 mt-2">
                        <span class="col-sm-8 text-info" style="font-size:14px"><b>No Registrasi : {{$item2->no_registrasi}}</b></span>
                        <span class="col-sm-4" id="notif_user{{$no}}" style="font-size:14px"></span>
                        <hr>
                        <span class="col-sm-12" style="font-size:13px">Tanggal Registrasi : {{$item2->tgl_registrasi}}</span>
                        <span class="col-sm-12" style="font-size:13px">Nama Perusahaan : {{$item2->nama_perusahaan}}</span>
                        <span class="col-sm-12" style="font-size:13px">Jenis Usaha : {{$item2->jenis_usaha}}</span>
                        <span class="col-sm-12" style="font-size:13px">Status Registrasi : {{$item2->status_registrasi}}</span>
                        <span class="col-sm-12" style="font-size:13px">No Sertifikat : {{$item2->no_sertifikat}}</span>
                        <span id="stat_val{{$no}}" style="display:none">{{$item2->status}}</span>
                        <hr>
                        <a href="{{route('login')}}" class="button btn-info btn-lg ml-2"><b>Login Untuk Melihat Detail</b></a>
                    </div>
                @php $no+=1; @endphp
                @endforeach  
            @endif                       
            @endif
            </div>
        </div>
        </div>
        @endif        
    

    <div class="containercol-lg-12 bg-halal" style="background: #218c74">
        <div class="col-lg-12 rounded mt-2 mb-4">
            <div class="row col-lg-12">
                <span class="col-lg-12 mt-3 col-form-label text-center text-white"><h2>Berita</h2></span>
                <div class="col-lg-12">
                    <div class="mt-3 mb-5">
                    <div class="input-group rounded">
                        <form action="{{route('master.berita.cariberita')}}" method="get" name="searchForm" class="form-horizontal form-bordered col-lg-12" enctype="multipart/form-data">
                            <div class="input-group">
                                <input type="search" style="font-size:16px;height:50px;" class="form-control text-center rounded" style="height: 50px;text-size:15px;" name="katakunci" placeholder="Kata Kunci Berita" aria-label="Search" aria-describedby="search-addon" required/>
                                &nbsp;&nbsp;<button type="submit" class="btn btn-outline-white">Cari Berita</button>
                            </div>
                        </form>
                    </div>                
                    </div>
                </div>
                @if(isset($berita))                    
                    @if (count($berita) == 0)
                        <h4 class="col-lg-12 text-center text-white">Hasil Pencarian Berita</h4>
                        <h6 class="col-lg-12 text-center text-warning mb-5 mt-3">Produk yang dicari tidak ditemukan</h4>
                    @else      
                        @foreach ($berita as $item)
                            <div class="box-berita row bg-white col-lg-4 border mr-3 mb-3 p-20 ml-4" style="min-height: 150px;">
                                <span class="col-sm-12"><b>{{$item->created_at}} </b>
                                <br><span style="font-size: 10px;">Oleh : {{$item->nama_penulis}} </span>
                                <br><br><a href="{{url('detail_berita_user')}}/{{$item->id}}" class="text-dark"><h5 class="text-primary">{{$item->judul_berita}}</h5></a></span>
                            </div>
                        @endforeach         
                    @endif   
                @endif
            </div>
        </div>
    </div>        

    <div class="container-fluid">
        <div class="col-lg-12 rounded mt-5 mb-4">
            <div class="row col-lg-12">
                <span class="col-lg-12 col-form-label text-center text-primary"><h2>Pelatihan</h2></span>
                @if(isset($pelatihan))
                    @if (count($pelatihan) == 0)
                        <div class="row border text-center text-warning col-lg-10 mr-3 mb-3 p-10 ml-2">
                            Pelatihan yang dicari tidak ditemukan
                        </div>
                    @else      
                        @foreach ($pelatihan as $item)
                            <div class="box-pelatihan row col-lg-12 border mr-3 mb-3 p-20 ml-2" style="min-height: 150px;">
                                <img src="{{url('') .Storage::url('pelatihan/'.$item->gambar_cover) }}" style="width:15%;">
                                <div class="col-sm-4">
                                    <span><b>{{$item->created_at}}</b></span>
                                    <br><span style="font-size: 10px;">Oleh : {{$item->nama_penulis}} </span>
                                    <br><br><a href="{{url('detail_pelatihan_user')}}/{{$item->id}}" class="text-dark"><h6 class="text-primary">{{$item->judul_pelatihan}}</h6></a></span>
                                </div>                                
                            </div>
                        @endforeach
                    @endif   
                @endif
            </div>
        </div>
    </div>        
    
@endsection

@push('scripts')
<script src="{{asset('/assets/js/checkData.js')}}"></script>
<script>	            
    var produk = {!! json_encode($produk->toArray()) !!};
    if(produk.length != 0){
        console.log(produk.length);
        /*
        document.getElementById("status").innerText = getProgress(data);
        */
        for(var x=1;x<=produk.length;x++){        
            data=document.getElementById("stat_val"+x+"").textContent;
            function getProgress (data) {return checkProgress(data);}
            function getNotif (data) {return notifProgress(data);}        
            document.getElementById('notif_user'+x+'').innerHTML = "<h5 class='text-right text-info'><b>Status : "+getProgress(data)+"</h5></b>";
        }	
    }    
</script>


@endpush
