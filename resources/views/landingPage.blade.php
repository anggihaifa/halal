@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Beranda')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid col-lg-12">
        <nav class="navbar navbar-light bg-halal" >
        <a class="navbar-brand text-white" href="#">
            <img src="{{asset('/assets/img/logo/white-sci.png')}}" alt="">
            <b>LPH</b>SUCOFINDO
        </a>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light bg-halal">
        {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link nav-halal" href="#">Beranda <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Informasi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="#">Pelanggan Kami</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="#">FAQ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ubah Bahasa
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('login')}}">Masuk</a>
            </li>
            </ul>
        </div>
        
        </nav>        
    </div>

    <div class="container-fluid col-lg-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="First slide" style="min-height:400px; background: #b9b9b9">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="assets/img/berita_utama/berita_utama2.jpg" alt="Second slide" style="min-height:400px; background: #b9b9b9">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="assets/img/berita_utama/berita_utama1.jpg" alt="Third slide" style="min-height:400px; background: #b9b9b9">
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

    <div class="container-fluid col-lg-12">
        <div class="container-fluid col-lg-8">
            <div class="row">            
            <div class="input-group rounded mt-5 mb-4">            
                <form action="{{route('berita.store')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <div class="input-group">
                <input type="search" class="form-control rounded col-lg-12" placeholder="Masukan No Sertifikat/Nama Produk/Nama Perusahaan" aria-label="Search"
                    aria-describedby="search-addon" />
                &nbsp;&nbsp;
                <button type="button" class="btn btn-outline-primary">Cari Produk</button>
                </div>            
                </form>
            </div>            
            </div>
        </div>
    </div>

    <div class="container-fluid col-lg-12">        
        <div class="row col-lg-12 ml-5">
            <span class="col-lg-12 col-form-label"><h3>Berita</h3></span>
            <div class="col-lg-12">
                <div class="col-lg-4 mt-3 mb-3">
                <div class="input-group rounded">
                    <div class="input-group">
                        <input type="search" class="form-control rounded" placeholder="Kata Kunci Berita" aria-label="Search" aria-describedby="search-addon" />
                        &nbsp;&nbsp;<button type="button" class="btn btn-outline-primary">Cari Berita</button>
                    </div>
                </div>
                </div>
            </div>
            @foreach ($berita as $item)
                <div class="row col-lg-2 border mr-3 mb-3 p-10 ml-2" style="min-height: 100px;">
                    <p class="col-sm-12">{{$item->created_at}}</p>
                    <a href="{{url('detail_berita_user')}}/{{$item->id}}" class="text-dark"><h6 class="col-sm-12">{{$item->judul_berita}}</h6></a>
                    {{-- <a class="col-sm-12 btn btn-outline-primary float-right">Detail</a> --}}
                </div>
            @endforeach            
        </div>
        
    </div>
        

<div class="container-fluid col-lg-12">
    <!-- Footer -->
    <footer class="text-lg-start mt-5 bg-halal text-white">
    <!-- Grid container -->
    <div class="container p-20">
        <!--Grid row-->
        <div class="row">
        <!--Grid column-->
        <div class="col-lg-3 mb-4">
            <h5 class="text-uppercase">Lph Sucofindo</h5>

            <p class="mt-4">
            Lembaga pemeriksa halal PT Sucofindo (Persero)
            </p>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0 explore-halal">
            <h5 class="text-uppercase">Explore</h5>

            <ul class="list-unstyled mb-5">
            <li>
                <a href="#!">Beranda</a>
            </li>
            <li>
                <a href="#!">Pelanggan Kami</a>
            </li>
            <li>
                <a href="#!">FAQ</a>
            </li>
            <li>
                <a href="#!">Tentang Kami</a>
            </li>
            </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        {{-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0 explore-halal">
            <h5 class="text-uppercase mb-0">Links</h5>

            <ul class="list-unstyled">
            <li>
                <a href="#!">Link 1</a>
            </li>
            <li>
                <a href="#!">Link 2</a>
            </li>
            <li>
                <a href="#!">Link 3</a>
            </li>
            <li>
                <a href="#!">Link 4</a>
            </li>
            </ul>
        </div> --}}
        <div class="col-lg-3 col-md-12 mb-4 mb-md-0">
            <h5 class="text-uppercase">Visit</h5>

            <p>
            Jl. Raya Pasar Minggu Kav. 34, Jakarta, Indonesia 12780
            </p>

            <h5 class="text-uppercase mt-5">Hotline</h5>

            <p>
            Nomor : 021-7983666 ext 1324
            </p>
        </div>
        <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2021 Copyright: PT SUCOFINDO (Persero). All Right Reserved        
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->
</div>
    
@endsection
