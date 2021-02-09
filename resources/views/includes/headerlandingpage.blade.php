<div class="container-fluid col-lg-12">
        <nav class="navbar navbar-light bg-halal" >
        <a class="navbar-brand text-white" href="{{route('landingpage.index')}}">
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
                <a class="nav-link nav-halal" href="{{route('landingpage.index')}}">Beranda <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Informasi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{route('informasipanduan')}}">Panduan Pengguna</a>
                <a class="dropdown-item" href="{{route('informasialur')}}">Alur Sertifikasi Halal</a>                
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="#">Pelanggan Kami</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('faquser')}}">FAQ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-halal" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ubah Bahasa
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Bahasa Indonesia</a>
                <a class="dropdown-item" href="#">Bahasa Inggris</a>                
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-halal" href="{{route('login')}}">Masuk</a>
            </li>
            </ul>
        </div>
        
        </nav>        
    </div>    