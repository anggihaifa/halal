<div class="containercol-lg-12">
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
                <a class="nav-link nav-halal" href="{{route('landingpage.index')}}"><h5>Beranda</h5></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <h5>Informasi</h5>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{route('informasipanduan')}}"><h6>Panduan Pengguna</h6></a>
                <a class="dropdown-item" href="{{route('informasialur')}}"><h6>Alur Sertifikasi Halal</h6></a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="#"><h5>Pelanggan Kami</h5></a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('faquser')}}"><h5>FAQ</h5></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <h5>Ubah Bahasa</h5>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#"><h6>Bahasa Indonesia</h6></a>
                <a class="dropdown-item" href="#"><h6>Bahasa Inggris</h6></a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('login')}}"><h5>Masuk</h5></a>
            </li>
            </ul>
        </div>
        
        </nav>        
    </div>    