@extends('layouts.landingpage', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')  
    <div class="container-fluid col-lg-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner h-100 bg-light">
                <div class="carousel-item active" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="First slide" style="min-height:400px; background: #b9b9b9">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Pertemuan Auditor</h5>
                        <p>Pertemuan auditor semua cabang Sucofindo</p>
                    </div>
                </div>
                <div class="carousel-item" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama2.jpg" alt="Second slide" style="min-height:400px; background: #b9b9b9">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Pertemuan Auditor</h5>
                        <p>Pertemuan auditor semua cabang Sucofindo</p>
                    </div>
                </div>
                <div class="carousel-item" style="height:450px">
                    <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="Third slide" style="min-height:400px; background: #b9b9b9">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Pertemuan Auditor</h5>
                        <p>Pertemuan auditor semua cabang Sucofindo</p>
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
      
    <div class="container-fluid">
        <div class="col-lg-12 rounded mt-5 mb-4 text-center">
            <form action="{{route('landingpage.cariproduk')}}" method="get" name="produkForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <input type="search" class="form-control text-center rounded" style="height: 50px;text-size:15px;" name="katakunci" placeholder="Masukan No Registrasi/No Sertifikat/Nama Perusahaan" aria-label="Search" aria-describedby="search-addon" required/>
                </div>
                <div class="col-lg-12">
                <br>
                <button type="submit" class="btn btn-outline-primary">Cari Produk</button>
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
            <h5 class="col-lg-12">Hasil Pencarian</h5>
            @if (count($produk) == 0)
                <div class="row border text-warning col-lg-12 p-15">
                    <span class="text-center">Produk yang dicari tidak ditemukan</span>
                </div>
            @else                            
                @php $no=1; @endphp
                @foreach ($produk as $item2)
                    <div class="row border p-15 col-lg-12 mt-2">
                        <span class="col-sm-8 text-info"><b>No Registrasi : {{$item2->no_registrasi}}</b></span>
                        <span class="col-sm-4" id="notif_user{{$no}}"></span>
                        <hr>
                        <span class="col-sm-12">Tanggal Registrasi : {{$item2->tgl_registrasi}}</span>
                        <span class="col-sm-12">Nama Perusahaan : {{$item2->nama_perusahaan}}</span>
                        <span class="col-sm-12">Jenis Usaha : {{$item2->jenis_usaha}}</span>
                        <span class="col-sm-12">Status Registrasi : {{$item2->status_registrasi}}</span>
                        <span class="col-sm-12">No Sertifikat : {{$item2->no_sertifikat}}</span>
                        <span id="stat_val{{$no}}" style="display:none">{{$item2->status}}</span>
                        <hr>
                        <a href="{{route('login')}}" class="button btn-sm btn-info ml-2"><b>Login Untuk Melihat Detail</b></a>
                    </div>
                @php $no+=1; @endphp
                @endforeach  
            @endif                       
            @endif
            </div>
        </div>
        </div>
        @endif        
    

    <div class="container-fluid">
    <div class="col-lg-12 rounded mt-5 mb-4">
        <div class="row col-lg-12">
            <span class="col-lg-12 col-form-label"><h3>Berita</h3></span>
            <div class="col-lg-12">
                <div class="mt-3 mb-3">
                <div class="input-group rounded">
                    <form action="{{route('master.berita.cariberita')}}" method="get" name="searchForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" style="height: 40px;text-size:15px;" name="katakunci" placeholder="Kata Kunci Berita" aria-label="Search" aria-describedby="search-addon" required/>
                            &nbsp;&nbsp;<button type="submit" class="btn btn-outline-primary">Cari Berita</button>
                        </div>
                    </form>
                </div>                
                </div>
            </div>
            @if(isset($berita))
                @if (count($berita) == 0)
                    <div class="row border text-center text-warning col-lg-10 mr-3 mb-3 p-10 ml-2">
                        Berita yang dicari tidak ditemukan
                    </div>
                @else      
                    @foreach ($berita as $item)
                        <div class="row col-lg-12 border mr-3 mb-3 p-10 ml-2">
                            <p class="col-sm-12">{{$item->created_at}}</p>
                            <a href="{{url('detail_berita_user')}}/{{$item->id}}" class="text-dark"><h6 class="col-sm-12 text-primary">{{$item->judul_berita}}</h6></a>
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
            document.getElementById('notif_user'+x+'').innerHTML = "<h6 class='text-right text-info'><b>Status : "+getProgress(data)+"</h6></b>";
        }	
    }    
</script>


@endpush
