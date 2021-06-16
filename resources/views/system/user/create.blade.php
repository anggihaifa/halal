@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Tambah Data Pengguna')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
        <li class="breadcrumb-item active">Tambah Data Pengguna</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Tambah Data Pengguna<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Tambah Data Pengguna</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('user.store')}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @csrf
                            @component('components.inputemail',['name'=> 'email','label' => 'Email','required'=>true])@endcomponent
                            @component('components.inputtext',['name'=> 'username','label' => 'Username','required'=>true])@endcomponent
                            @component('components.inputtext',['name'=> 'name','label' => 'Name','required'=>true])@endcomponent
                            @component('components.inputselect',['name'=>'usergroup_id','label'=>'Role','options'=>$userGroup,'labelKey'=>'usergroup','required'=>true])@endcomponent
                            @component('components.inputpassword2',['id'=>'password','name'=> 'password','label' => 'Password','required'=>true])@endcomponent
                            <label class="col-lg-4 col-form-label" id="lblx"></label>
                            <div class="col-lg-8" id="valx">
                                <div id="pwdvalidation" >
                                    <b><span style="margin-right:10px;">Password harus terdiri dari :  </span>
                                    <span id="letter" style="margin-right:5px;">Lowercase</span>
                                    <span id="capital" style="margin-right:5px;">Capital</span>
                                    <span id="number" style="margin-right:5px;">Number</span>
                                    <span id="length" style="margin-right:5px;">8 Character</span></b>
                                </div>
                            </div>
                            @component('components.inputpassword',['id'=>'confirmpassword','name'=> 'confirmpassword','label' => 'Konfirmasi Password','required'=>true])@endcomponent
                            <label class="col-lg-4 col-form-label"></label>
                            <div class="col-lg-8"><span id="message"></span></div>
                            @component('components.inputtext',['name'=> 'perusahaan','label' => 'Nama Perusahaan','required'=>true])@endcomponent
                            @component('components.inputtext',['name'=> 'negara','label' => 'Negara','required'=>true])@endcomponent
                            @component('components.inputtext',['name'=> 'kota','label' => 'Kota','required'=>true])@endcomponent
                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat Perusahaan','required'=>true])@endcomponent
                            <label class="col-lg-4 col-form-label">Status</label>
                            <div class="col-lg-8">
                                <select name="status" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0" selected>Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>                            
                            <label class="col-lg-4 col-form-label">Wilayah</label>
                            <div class="col-lg-8">
                                <select name="kode_wilayah" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="119" selected>Pusat</option>
                                    <option value="115" >Cabang Balikpapan</option>
                                    <option value="125" >Cabang Bandar Lampung</option>
                                    <option value="107" >Cabang Bandung</option>
                                    <option value="117" >Cabang Banjarmasin</option>
                                    <option value="123" >Cabang Batam</option>
                                    <option value="104" >Cabang Batu Licin</option>
                                    <option value="103" >Cabang Bekasi</option>
                                    <option value="129" >Cabang Bengkulu</option>
                                    <option value="121" >Cabang Bontang</option>
                                    <option value="113" >Cabang Cilacap</option>
                                    <option value="131" >Cabang Cilegon</option>
                                    <option value="105" >Cabang Cirebon</option>
                                    <option value="114" >Cabang Denpasar</option>
                                    <option value="127" >Cabang Dumai</option>
                                    <option value="130" >Cabang Jakarta</option>
                                    <option value="128" >Cabang Jambi</option>
                                    <option value="111" >Cabang Makasar</option>
                                    <option value="116" >Cabang Manado</option>
                                    <option value="101" >Cabang Medan</option>
                                    <option value="126" >Cabang Padang</option>
                                    <option value="124" >Cabang Palembang</option>
                                    <option value="109" >Cabang Pekanbaru</option>
                                    <option value="122" >Cabang Pontianak</option>
                                    <option value="120" >Cabang Samarinda</option>
                                    <option value="102" >Cabang Sangatta</option>
                                    <option value="110" >Cabang Semarang</option>
                                    <option value="108" >Cabang Surabaya</option>
                                    <option value="106" >Cabang Tarakan</option>
                                    <option value="112" >Cabang Timika</option>
                                    <option value="118" >SBU Kantor Pusat</option>
                                    <option value="132" >SBU Laboratorium Cibitung</option>
                                    {{-- <option value="11" >Aceh</option>
                                    <option value="12" >Sumatera Utara</option>
                                    <option value="13" >Sumatera Barat</option>
                                    <option value="14" >Riau</option>
                                    <option value="15" >Jambi</option>
                                    <option value="16" >Sumatera Selatan</option>
                                    <option value="17" >Bengkulu</option>
                                    <option value="18" >Lampung</option>
                                    <option value="19" >Bangka Belitung</option>
                                    <option value="21" >Kep.Riau</option>
                                    <option value="31" >DKI Jakarta</option>
                                    <option value="32" >Jawa Barat</option>
                                    <option value="33" >Jawa Tengah</option>
                                    <option value="34" >DI Yogyakarta</option>
                                    <option value="35" >Jawa Timur</option>
                                    <option value="36" >Banten</option>
                                    <option value="51" >Bali</option>
                                    <option value="52" >NTB</option>
                                    <option value="53" >NTT</option>
                                    <option value="61" >Kalimantan Barat</option>
                                    <option value="62" >Kalimantan Tengah</option>
                                    <option value="63" >Kalimantan Selatan</option>
                                    <option value="64" >Kalimantan Timur</option>
                                    <option value="65" >Kalimantan Utara</option>
                                    <option value="71" >Sulawesi Utara</option>
                                    <option value="72" >Sulawesi Tengah</option>
                                    <option value="73" >Sulawesi Selatan</option>
                                    <option value="74" >Sulawesi Tenggara</option>
                                    <option value="75" >Gorontalo</option>
                                    <option value="76" >Sulawesi Barat</option>
                                    <option value="81" >Maluku</option>
                                    <option value="82" >Maluku Utara</option>
                                    <option value="91" >Papua</option>
                                    <option value="92" >Papua Barat</option> --}}
                                </select>
                            </div>
                            <div class="col-md-12 offset-md-5">
                                @component('components.buttonback',['href' => route("user.index")])@endcomponent
                                @component('components.buttonsubmit')@endcomponent
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection

@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
    <script src="{{asset('/assets/js/pwdvalidation.js')}}"></script>
    <script>
        $('#confirmpassword').on('keyup', function () {
            if ($('#password').val() == $('#confirmpassword').val()) {
                $('#message').html('Password Sesuai').css('color', 'green');
            } else
                $('#message').html('Password Tidak Sesuai').css('color', 'red');
        });
        $('#email').on('keyup', function () {
            var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
            var x = document.getElementById("check");
            var y = $('#email').val();
            //console.log(y);
            if(!ev.test(y)){
                x.innerHTML	= "Not a valid email";
                x.style.color = "red"
            }else{
                x.innerHTML	= "<i class='fa fa-check'></i>";
                x.style.color = "green"
            }

        });
        
    </script>
@endpush