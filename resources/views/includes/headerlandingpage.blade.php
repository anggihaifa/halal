<div class="container-fluid col-lg-12">
        <nav class="navbar navbar-light bg-halal d-flex justify-content-center">
        <a class="navbar-brand text-white" href="{{route('landingpage.index')}}">
            <img src="{{asset('/assets/img/logo/white-sci.png')}}" alt="">
            <span style="font-size: 22px"><b>LPH</b>SUCOFINDO</span>
        </a>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light bg-halal">
        {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link nav-halal" href="{{route('landingpage.index')}}"><span style="font-size: 13px">Beranda</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span style="font-size: 13px">Informasi</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{route('informasipanduan')}}">Panduan Pengguna</a>
                <a class="dropdown-item" href="{{route('informasialur')}}">Alur Sertifikasi Halal</a>                
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="#"><span style="font-size: 13px">Pelanggan Kami</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('faquser')}}"><span style="font-size: 13px">FAQ</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span style="font-size: 13px">Ubah Bahasa</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Bahasa Indonesia</a>
                <a class="dropdown-item" href="#">Bahasa Inggris</a>                
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('login')}}"><span style="font-size: 13px">Masuk</span></a>
            </li>
            </ul>
        </div>
        
        </nav>        
    </div>    