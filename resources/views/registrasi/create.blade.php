@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/css/customize.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('/assets/css/multistep.css')}}" rel="stylesheet" /> --}}    
    <link rel="stylesheet" >            
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi</a></li>
        <li class="breadcrumb-item">Registrasi Halal</li>
        <li class="breadcrumb-item active">Tambah Registrasi Halal</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Tambah Registrasi Halal<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Tambah Registrasi Halal</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body panel-form">
                    <form action="{{route('registrasiHalal.store')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data" id="msform">                        

                        <div class="form-group row">
                            <fieldset>
                            <div class="form-card row">
                                @csrf                            
                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-12"><h4>Data Registrasi</h4></label>
                                    </div>
                                </div>

                                <label class="col-lg-4 col-form-label">Tanggal Input Data</label>
                                <div class="col-lg-8">
                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control " readonly/>
                                </div>

                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Status Registrasi</label>
                                        <div class="col-lg-8">
                                            <div style="margin-bottom:7px;">
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="permohonan baru" checked />
                                                    <label for="statusRegistrasi1">Permohonan Baru</label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="pembaruan" />
                                                    <label for="statusRegistrasi2">Pembaruan</label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="perluasan" />
                                                    <label for="statusRegistrasi3">Perluasan</label>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Jenis Registrasi</label>
                                        <div class="col-lg-8">
                                            <select id="id_jenis_reg" onchange="getSelectedValue();"  name="id_jenis_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                @php
                                                foreach ($jenisRegistrasi as $jenis) {
                                                    echo "<option value='$jenis->id'>$jenis->jenis_registrasi</option>";
                                                }                                    
                                                @endphp                             
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                                                
                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'no_registrasi_bpjph','id' => 'no_registrasi_bpjph','label' => 'No. Registrasi BPJPH *','required'=>true,'placeholder'=>'xx-x-xxxx-xxxx'])@endcomponent
                                </div>
                                </div>                                
                                                                
                            </div>
                            <div class="text-center"><input type="button" name="next" class="next action-button" value="Lanjut" /></div>
                            </fieldset>
                            <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data Perusahaan</h4></label>
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan *','required'=>true,'placeholder'=>'Nama Perusahaan'])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat_perusahaan','label' => 'Alamat Perusahaan *','required'=>true,'placeholder'=>'Alamat Perusahaan','id'=>'alamatPerusahaan','value'=>''])@endcomponent                            
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'telepon_perusahaan','label' => 'Telepon Perusahaan *','required'=>true,'placeholder'=>'Telepon Perusahaan','id'=>'teleponPerusahaan'])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat_pabrik','label' => 'Alamat Pabrik *','required'=>true,'placeholder'=>'Alamat Pabrik','id'=>'alamatPabrik','value'=>''])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'telepon_pabrik','label' => 'Telepon Pabrik *','required'=>true,'placeholder'=>'Telepon Pabrik','id'=>'teleponPabrik'])@endcomponent
                                        </div>
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                            <div class="row col-lg-6">
                                                @component('components.inputtext',['name'=> 'contact_person','label' => 'Contact Person *','required'=>true,'placeholder'=>'Contact Person','id'=>'contactPerson'])@endcomponent
                                            </div>
                                            
                                        </div>
        
                                        <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputemail',['name'=> 'email','label' => 'Email Contact Person*','required'=>true,'placeholder'=>'Email Contact Person','id'=>'emailCP'])@endcomponent
                                        </div>
                                    </div>   
                                </div>    
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
    
                                    {{-- <div class="text-center">                                                                                                    
                                        <button type="submit" class="action-button">Kirim</button>
                                    </div> --}}
                            </fieldset>
                            <fieldset>                                
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data KTP & NPWP</h4></label>
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">KTP*</label>
                                            <div class="col-lg-8"><div>                                            
                                                <input type="file" name="ktp" required>
                                            </div></div>
                                        </div>
                                    </div>
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">NPWP*</label>
                                            <div class="col-lg-8"><div>                                            
                                                <input type="file" name="npwp" required>
                                            </div></div>
                                        </div>
                                    </div>                                                                    
                                </div>
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                                    {{-- <div class="text-center">                                                                                                    
                                        <button type="submit" class="action-button">Kirim</button>
                                    </div> --}}
                            </fieldset>
                            <fieldset>                                
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-12"><h4>Data Produk</h4></label>
                                        </div>
                                    </div>                                    
    
                                    <div id="wrapperdataproduk" class="wrapper col-lg-12 row">
                                        {{-- <div class="wrapper row"> --}}
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Merk/Brand*</label><div class="col-lg-8"><div><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">                                                
                                                    <div class="detail_dataproduk" id="detail_dataproduk" style="width: 100%; margin-left:-3px"></div>
                                                    <div class="col-md-12">
                                                        <a id="tam_data_produk" class="tam_data_produk btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Merk/Brand</a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div> 
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label for="kelompok" class="col-lg-4 col-form-label">Jenis Produk*</label>
    
                                            <div class="col-lg-8">
                                                <select id="id_kelompok_produk" name="id_kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">--Pilih Jenis Produk--</option>
                                                        @if(isset($kelompokProduk))
                                                            @foreach($kelompokProduk as $index => $value)
                                                                <option value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                                @endforeach
                                                        @endif
                                                </select>                                
                                            </div>   
                                        </div>
                                    </div>
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label for="kelompok" class="col-lg-4 col-form-label">Rincian Jenis Produk*</label>
    
                                            <div class="col-lg-8">
                                                <select multiple="multiple" id="id_rincian_kelompok_produk" name="id_rincian_kelompok_produk[]" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">--Pilih Jenis Produk--</option>
                                                </select>
                                            </div>   
                                        </div>
                                    </div>
    
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <!--skala usaha-->
                                        <label class="col-lg-4 col-form-label">Daerah Pemasaran*</label>
                                        <div class="col-lg-8">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="daerah_pemasaran" id="daerahPemasaran1" value="Provinsi" checked />
                                                <label for="daerahPemasaran1">Provinsi</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="daerah_pemasaran" id="daerahPemasaran2" value="Nasional"/>
                                                <label for="daerahPemasaran2">Nasional</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="daerah_pemasaran" id="daerahPemasaran3" value="Internasional"/>
                                                <label for="daerahPemasaran3">Internasional</label>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Sistem Pemasaran*</label>
                                            <div class="col-lg-8">
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="sistem_pemasaran" id="sistemPemasaran1" value="Retail" checked />
                                                    <label for="sistemPemasaran1">Retail</label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="sistem_pemasaran" id="sistemPemasaran2" value="Non Retail" />
                                                    <label for="sistemPemasaran2">Non Retail</label>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <button type="submit" class="action-button">Kirim</button>
                                </div>
                            </fieldset>
                        </div>
                        
                        {{-- <div class="form-group row"> --}}
                            {{-- <fieldset>
                                <div class="form-card row">
                                @csrf                            
                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <label class="col-12"><h4>Data Umum</h4></label>
                                </div>
                                </div>

                                <label class="col-lg-4 col-form-label">Tanggal Pendaftaran</label>
                                <div class="col-lg-8">
                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control " readonly/>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Registrasi</label>
                                    <div class="col-lg-8">
                                        <select id="id_jenis_reg" onchange="getSelectedValue();"  name="id_jenis_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                            @php
                                            foreach ($jenisRegistrasi as $jenis) {
                                                echo "<option value='$jenis->id'>$jenis->jenis_registrasi</option>";
                                            }                                    
                                            @endphp                             
                                        </select>
                                    </div>
                                </div>
                                </div>

                                <div class="wrapper col-lg-12" id="wrapperip" style="display: none">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Industri Pengolahan</label>
                                        <div class="col-lg-8">
                                            <select id="id_jenis_reg"  name="id_jenis_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                <option value="makanan">Makanan</option>
                                                <option value="makanan">Minuman</option>
                                                <option value="makanan">Obat</option>
                                                <option value="makanan">Kosmetik</option>                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">Jenis Pendaftaran</label>
                                    <div class="col-lg-8">
                                        <div style="margin-bottom:7px;">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="baru" checked />
                                                <label for="statusRegistrasi1">Baru</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="perpanjangan" />
                                                <label for="statusRegistrasi2">Perpanjangan</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="pengembangan" />
                                                <label for="statusRegistrasi3">Perubahan</label>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan *','required'=>true,'placeholder'=>'Nama Perusahaan'])@endcomponent
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'no_surat','id' => 'no_surat','label' => 'No. Surat Permohonan Sertifikasi (BPJPH) *','required'=>true,'placeholder'=>'xx-x-xxxx-xxxx'])@endcomponent                            
                                </div>
                                </div>

                                <div class="wrapper col-lg-12" id="lsh">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">*Status Halal Sebelumnya</label>
                                    <div id="sh" class="col-lg-8">
                                        <input type="text" name="status_halal" class="form-control" placeholder="Status Halal Sebelumnuya"  />
                                    </div>
                                </div>
                                </div>
                                <div class="wrapper col-lg-12" id="lshb">
                                <div class="row">
                                    <label class="col-lg-4 col-form-label">*SH Berlaku s/d</label>
                                    <div id="shb" class="col-lg-8">                                
                                        <div class="input-group date">
                                            <input type="text" id="sh_berlaku" name="sh_berlaku" class="form-control" placeholder="SH Berlaku s/d" value="" data-date-start-date="Date.default" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="wrapper col-lg-12" id="nosjh">
                                <div class="row">
                                    <label id="lsjph0" class="col-lg-4 col-form-label">No. Sertifikat SJH/ SJPH</label>
                                    <div id="dsjph0" class="col-lg-8">
                                        <input type="text" name="no_sertifikat" class="form-control" placeholder="No. Sertifikat SJPH"  />
                                    </div>
                                </div>
                                </div>

                                <div class="wrapper col-lg-12" id="nosjh2">
                                <div class="row">
                                    <label id="lsjph" class="col-lg-4 col-form-label">SJH/ SJPH Berlaku s/d</label>
                                    <div id="dsjph" class="col-lg-8">
                                        <div class="input-group date">
                                            <input id="tgl_sjph" name="tgl_sjph" type="text" class="form-control" placeholder="SJPH Berlaku s/d"  data-date-start-date="Date.default" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                </div>                                

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <!--jenis badan usaha-->                                                        
                                    <label class="col-lg-4 col-form-label" id="textjenisbadanusaha">Jenis Badan Usaha</label>
                                    <div class="col-lg-8">
                                        <div style="margin-bottom:10px;">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu1" value="pt" checked />
                                                <label for="jbu1">PT</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu2" value="cv" />
                                                <label for="jbu2">CV</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu3" value="pd" />
                                                <label for="jbu3">PD</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu4" value="ud" />
                                                <label for="jbu4">UD</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu5" value="koperasi" />
                                                <label for="jbu5">Koperasi</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu6" value="firma" />
                                                <label for="jbu6">Firma</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu7" value="perorangan" />
                                                <label for="jbu7">Perorangan</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_badan_usaha" id="jbu8" value="lainnya" />
                                                <label for="jbu8">Lainnya</label>
                                            </div>
                                        </div>
                                        <input id="j_badanusaha" name="nama_jenis_badan_usaha" type="text" class="form-control" placeholder="Lainnya" />
                                    </div>          
                                </div>                  
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <!--kepemilikan-->
                                    <label class="col-lg-4 col-form-label">Kepemilikan</label>
                                    <div class="col-lg-8">
                                        <div style="margin-bottom:10px;">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="kepemilikan" id="kp1" value="pmdn" checked />
                                                <label for="kp1">PMDN</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="kepemilikan" id="kp2" value="bumn" />
                                                <label for="kp2">BUMN</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="kepemilikan" id="kp3" value="pribadi" />
                                                <label for="kp3">Pribadi</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="kepemilikan" id="kp4" value="pma" />
                                                <label for="kp4">PMA</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="kepemilikan" id="kp5" value="lainnya" />
                                                <label for="kp5">Lainnya</label>
                                            </div>
                                        </div>
                                        <input id="k_lainnya" name="nama_kepemilikan" type="text" class="form-control" placeholder="Lainnya" />
                                    </div>
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <!--skala usaha-->
                                    <label class="col-lg-4 col-form-label">Skala Usaha</label>
                                    <div class="col-lg-8">
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="skala_usaha" id="skalaUsaha1" value="mikro" checked />
                                            <label for="skalaUsaha1">Mikro</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="skala_usaha" id="skalaUsaha2" value="kecil" />
                                            <label for="skalaUsaha2">Kecil</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="skala_usaha" id="skalaUsaha3" value="menengah" />
                                            <label for="skalaUsaha3">Menengah</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="skala_usaha" id="skalaUsaha4" value="besar" />
                                            <label for="skalaUsaha4">Besar</label>
                                        </div>                                        
                                    </div>
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <!--jenis usaha-->                                
                                    <label class="col-lg-4 col-form-label" id="jusaha1">Jenis Usaha</label>
                                    <div class="col-lg-8" id="jusaha2">
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="jenis_usaha" id="jenisusaha1" value="rumah potong hewan" checked/>
                                            <label for="jenisusaha1">Rumah Potong Hewan</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="jenis_usaha" id="jenisusaha2" value="rumah potong unggas" />
                                            <label for="jenisusaha2">Rumah Potong Unggas</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="jenis_usaha" id="jenisusaha3" value="lainnya" />
                                            <label for="jenisusaha3">Lainnya</label>
                                        </div>                                  
                                        <input id="ju" name="nama_jenis_usaha" type="text" class="form-control" placeholder="Lainnya" />
                                    </div>  
                                </div>                          
                                </div>           

                                <div class="wrapper col-lg-12">
                                <div class="row">                                    
                                    <label class="col-lg-4 col-form-label">NPWP</label>
                                    <div class="col-lg-8">                                        
                                        
                                        <input id="no_tipe2" name="no_tipe2" type="text" class="form-control npwp" placeholder="NPWP"/>
                                        
                                    </div>   
                                </div>
                                </div>           

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'jenis_izin','label' => 'Jenis Izin Usaha *','required'=>true,'placeholder'=>'MD/ML/PIRT/TR/TI/DKL/SD/SI/CD/CL/CA//ITUP/ISUP/NKV/HC/CFS'])@endcomponent
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['id'=>'jumlah_karyawan','name'=> 'jumlah_karyawan','label' => 'Jumlah Karyawan *','type' => 'number','max' => '10','required'=>true,'placeholder'=>'Jumlah Karyawan'])@endcomponent
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'kapasitas_produksi','label' => 'Kapasitas Produksi *','required'=>true,'placeholder'=>'Contoh: 1000 Ton / Tahun'])@endcomponent
                                </div>
                                </div>                                                                

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtext',['name'=> 'nib','label' => 'Nomor Induk Berusaha (NIB) *','required'=>true,'placeholder'=>'Nomor Induk Berusaha (NIB)'])@endcomponent
                                </div>
                                </div>

                                <div id="wrapperaspeklegal" class="wrapper row">
                                    <div class="wrapper row">
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                <label class="col-12 col-form-label"><h4>Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll)</h4></label>
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'jenis_surat','label' => 'Jenis Surat','required'=>false,'placeholder'=>'Jenis Surat'])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'nomor_surat','label' => 'Nomor Surat','required'=>false,'placeholder'=>'Nomor Surat'])@endcomponent
                                                <div class="col-lg-12">
                                                    <small class="f-s-12 text-grey-darker m-t-5">*jika sudah memiliki NIB, dokumen lainnya tidak diperlukan</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>                                                     
                                </div>       
                                
                                <div class="text-center"><input type="button" name="next" class="next action-button" value="Lanjut" /></div>
                            </fieldset>         --}}

                            {{-- <fieldset>
                                <div class="form-card row">

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    <label class="col-12" id="textalamatkantor"><h4>Alamat Kantor</h4></label>                            
                                </div>
                                </div>

                                <div class="wrapper col-lg-12">
                                <div class="row">
                                    @component('components.inputtextarea',['name'=> 'alamat_kantor','label' => 'Alamat *','required'=>true,'placeholder'=>'Alamat Kantor','id'=>'alamatKantor','value'=>''])@endcomponent                            
                                </div>
                                </div>
                                
                                
                                <label class="col-lg-4 col-form-label">Negara</label>
                                <div class="col-lg-8">
                                    <select id="negara_kantor" onchange="getNegara();"  name="negara_kantor" class="selectpicker form-control" data-size="10" data-live-search="true" data-style="btn-white">
                                        <option value="">== Pilih Negara ==</option>
                                        @php                                    
                                        foreach ($dataNegara as $negara) {
                                            echo "<option value='$negara->territory_short_name'>$negara->territory_short_name</option>";
                                        }                                    
                                        @endphp                             
                                    </select>
                                </div>

                                <div class="wrapper col-lg-12" id="label-prov">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Provinsi</label>
                                        <div class="col-lg-8">
                                            <select id="prov_kantor" name="provinsi_kantor_domestik" class="selectpicker form-control" data-size="10" data-live-search="true" data-style="btn-white">
                                                <option value="">== Pilih Provinsi ==</option>
                                                @php
                                                foreach ($dataProvinsi as $provinsi) {
                                                    echo "<option value='$provinsi->id'>$provinsi->nama_provinsi</option>";
                                                }                                    
                                                @endphp                             
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrapper col-lg-12" id="label-kot">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label">Kota/Kabupaten</label>
                                        <div class="col-lg-8">
                                            <select id="kotkantor" name="kota_kantor_domestik" class="selectpicker form-control" data-size="100" data-live-search="true" data-style="btn-white">
                                                <option value="">==Pilih Kota/Kabupaten==</option>
                                            </select>
                                        </div> 
                                    </div>   
                                </div>                        
                                                                
                                <div class="wrapper col-lg-12" id="provprov"><div class="row">
                                @component('components.inputtext',['name'=> 'provinsi_kantor','label' => 'Provinsi','required'=>false,'placeholder'=>'Provinsi','id'=>'provinsiKantor'])@endcomponent
                                </div></div>
                                <div class="wrapper col-lg-12" id="kotkot"><div class="row">
                                @component('components.inputtext',['name'=> 'kota_kantor','label' => 'Kota','required'=>false,'placeholder'=>'Kota/Kab','id'=>'kotaKantor','class'=>'kotaKantor'])@endcomponent
                                </div></div>
                                <div class="wrapper col-lg-12"><div class="row">
                                @component('components.inputtext',['name'=> 'telepon_kantor','label' => 'Telepon *','required'=>true,'placeholder'=>'Telepon','id'=>'teleponKantor'])@endcomponent
                                </div></div>
                                <div class="wrapper col-lg-12"><div class="row">
                                @component('components.inputtext',['name'=> 'kodepos_kantor','label' => 'Kode Pos *','required'=>true,'placeholder'=>'Kode Pos','id'=>'kodeposKantor'])@endcomponent
                                </div></div>
                                <div class="wrapper col-lg-12"><div class="row">
                                @component('components.inputemail',['name'=> 'email_kantor','label' => 'Email *','required'=>true,'placeholder'=>'Email','id'=>'emailKantor'])@endcomponent                            
                                </div></div>                            
                                </div>
                                <div class="text-center">
                                <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}
                            
                            {{-- <fieldset>
                                <div class="form-card row">

                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-4" id="textalamatpabrik"><h4>Alamat Pabrik</h4></label>
                                        <div class="col-lg-8">
                                            <input type="checkbox" id="autofill_alamat" name="autofill_alamat" onclick="autofill();"/>
                                            <label for="autofill_alamat">Data sama dengan alamat kantor</label><br>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtextarea',['name'=> 'alamat_pabrik','label' => 'Alamat *','required'=>true,'placeholder'=>'Alamat Pabrik','id'=>'alamatPabrik'])@endcomponent
                                    </div>
                                    </div>

                                    <label class="col-lg-4 col-form-label"></label>
                                    <div class="col-lg-8">                                    
                                    </div>
                                    <label class="col-lg-4 col-form-label">Negara</label>
                                    <div class="col-lg-8">
                                        <select id="negara_pabrik" onchange="getNegara2();"  name="negara_pabrik" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                            <option value="">== Pilih Negara ==</option>
                                            @php                                    
                                            foreach ($dataNegara as $negara) {
                                                echo "<option value='$negara->territory_short_name'>$negara->territory_short_name</option>";
                                            }                                                                            
                                            @endphp                             
                                        </select>
                                    </div>

                                    <div class="wrapper col-lg-12" id="label-prov2">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Provinsi</label>
                                            <div class="col-lg-8">
                                                <select id="prov_pabrik" name="provinsi_pabrik_domestik" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">== Pilih Provinsi ==</option>
                                                    @php
                                                    foreach ($dataProvinsi as $provinsi) {
                                                        echo "<option value='$provinsi->id'>$provinsi->nama_provinsi</option>";
                                                    }                                    
                                                    @endphp                             
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12" id="label-kot2">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Kota/Kabupaten</label>
                                            <div class="col-lg-8">
                                                <select id="kotpabrik" name="kota_pabrik_domestik" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                                    <option value="">==Pilih Kota/Kabupaten==</option>                                                                        
                                                </select>
                                            </div> 
                                        </div>   
                                    </div>                                                            
                                    <div class="wrapper col-lg-12" id="provprov2"><div class="row">
                                    @component('components.inputtext',['name'=> 'provinsi_pabrik','label' => 'Provinsi','required'=>false,'placeholder'=>'Provinsi','id'=>'provinsiPabrik'])@endcomponent
                                    </div></div>
                                    <div class="wrapper col-lg-12" id="kotkot2"><div class="row">
                                    @component('components.inputtext',['name'=> 'kota_pabrik','label' => 'Kota','required'=>false,'placeholder'=>'Kota/Kab','id'=>'kotaPabrik','class'=>'kotaPabrik'])@endcomponent
                                    </div></div>
                                    <div class="wrapper col-lg-12"><div class="row">
                                    @component('components.inputtext',['name'=> 'telepon_pabrik','label' => 'Telepon *','required'=>true,'placeholder'=>'Telepon','id'=>'teleponPabrik'])@endcomponent
                                    </div></div>
                                    <div class="wrapper col-lg-12"><div class="row">
                                    @component('components.inputtext',['name'=> 'kodepos_pabrik','label' => 'Kode Pos *','required'=>true,'placeholder'=>'Kode Pos','id'=>'kodeposPabrik'])@endcomponent
                                    </div></div>
                                    <div class="wrapper col-lg-12"><div class="row">
                                    @component('components.inputemail',['name'=> 'email_pabrik','label' => 'Email *','required'=>true,'placeholder'=>'Email','id'=>'emailPabrik'])@endcomponent
                                    </div></div>

                                    <!--status pabrik-->
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label" id="textstatuspabrik">Status Pabrik</label>
                                        <div class="col-lg-8">
                                            <div style="margin-bottom:10px;">                    
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_pabrik" id="statusPabrik1" value="milik sendiri" checked />
                                                    <label for="statusPabrik1">Milik Sendiri</label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_pabrik" id="statusPabrik2" value="maklon" />
                                                    <label for="statusPabrik2">Maklon</label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" name="status_pabrik" id="statusPabrik3" value="lainnya" />
                                                    <label for="statusPabrik3">Lainnya</label>
                                                </div>
                                            </div>      
                                            <input id="sp" name="nama_status_pabrik" type="text" class="form-control" placeholder="Lainnya" />
                                        </div>
                                    </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                    <!--jenis fasilitas produksi-->
                                        <label class="col-lg-4 col-form-label">Jenis Fasilitas Produksi</label>
                                        <div class="col-lg-8">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_fasilitas_produksi" id="jfp1" value="halal dedicated" checked />
                                                <label for="jfp1">Halal Dedicated</label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" name="jenis_fasilitas_produksi" id="jfp2" value="sharing facility" />
                                                <label for="jfp2">Sharing Facility</label>
                                            </div>                                                                                              
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}

                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                    <label class="col-12"><h4>Pemilik Perusahaan</h4></label>
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'nama_pemilik','label' => 'Nama *','required'=>true,'placeholder'=>'Nama'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'jabatan_pemilik','label' => 'Jabatan *','required'=>true,'placeholder'=>'Jabatan'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'telepon_pemilik','label' => 'Telepon *','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'fax_pemilik','label' => 'Fax *','required'=>true,'placeholder'=>'Fax'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputemail',['name'=> 'email_pemilik','label' => 'Email *','required'=>true,'placeholder'=>'Email'])@endcomponent
                                    </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}

                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        <label class="col-4"><h4>Penanggung Jawab</h4></label>
                                        <div class="col-lg-8">
                                            <input type="checkbox" id="autofill_pj" name="autofill_pj" onclick="autofill2();"/>
                                            <label for="autofill_pj">Data sama dengan pemilik perusahaan</label><br>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'nama_pj','label' => 'Nama *','required'=>true,'placeholder'=>'Nama'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'jabatan_pj','label' => 'Jabatan *','required'=>true,'placeholder'=>'Jabatan'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'telepon_pj','label' => 'Telepon *','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputtext',['name'=> 'fax_pj','label' => 'Fax *','required'=>true,'placeholder'=>'Fax'])@endcomponent
                                    </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                    <div class="row">
                                        @component('components.inputemail',['name'=> 'email_pj','label' => 'Email *','required'=>true,'placeholder'=>'Email'])@endcomponent
                                    </div>
                                    </div>

                                    <!--sertif perusahaan-->
                                    <label class="col-lg-4 col-form-label">Sertifikat Perusahaan</label>
                                    <div class="col-lg-8">
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="sertifikat_perusahaan" id="sertifperusahaan1" value="sertifikat halal" checked />
                                            <label for="sertifperusahaan1">Sertifikat Halal</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" name="sertifikat_perusahaan" id="sertifperusahaan2" value="lainnya" />
                                            <label for="sertifperusahaan2">Lainnya</label>
                                        </div>                                                                                          
                                    </div>
                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'penerbit_sertifikat_perusahaan','label' => 'Penerbit Sertifikat','required'=>true,'placeholder'=>'Penerbit Sertifikat'])@endcomponent
                                        </div>
                                    </div>

                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_sertifikat_perusahaan','label' => 'No Sertifikat','required'=>true,'placeholder'=>'No Sertifikat'])@endcomponent
                                        </div>
                                    </div>

                                    <label class="col-4 col-form-label" id="nkv1">Nomor Kontrol Veteriner</label><div class="col-lg-8" id="nkv2"><div><input class="form-control" id="nkv3" name="nkv" type="text" placeholder="Nomor Kontrol Veteriner (NKV)"></div></div>
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}

                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div>
                                        <div id="wrapperpenyelia" class="wrapper row">
                                            <div class="wrapper row">
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-12"><h4>Data Penyelia Halal</h4></label>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" id="dph1" name="nama_dph[]" type="text" label="Nama" placeholder="Nama"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No KTP</label><div class="col-lg-8"><div><input class="form-control ktp" id="dph2" name="ktp_dph[]" type="text" label="No KTP" placeholder="No KTP"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-8"><div><input class="form-control" id="dph3" name="sertif_dph[]" type="text" label="No Sertifikasi" placeholder="No Sertifikasi" ></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-8"><div><input class="form-control" id="dph4" name="no_tglsk_dph[]" type="text" label="No dan Tanggal SK" placeholder="No dan Tanggal SK"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No Kontak</label><div class="col-lg-8"><div><input class="form-control" id="dph5" name="no_kontrak_dph[]" type="text" label="No Kontrak" placeholder="No Kontak"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <div class="penyelia" id="detail_dph" style="width: 100%; background: #e8e8e8;"></div>
                                                    <div class="col-md-12">
                                                        <a id="tam_penyelia" class="tambah_penyelia btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Penyelia Halal</a>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>   
                                        </div>
                                                            
                                        <div id="wrappersdm" class="wrapper row">
                                            <div class="wrapper row">
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-12"><h4>Data Sumber Daya Manusia</h4></label>                            
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Jenis Data SDM</label>
                                                        <div class="col-lg-8">
                                                            <div>
                                                                <select name="jenis_sdm[]" class="form-control selectpicker">
                                                                    <option value="penyelia halal" selected>Penyelia Halal</option>
                                                                    <option value="juru sembelih halal">Juru Sembelih Halal</option>
                                                                    <option value="dokter hewan">Dokter Hewan</option>
                                                                    <option value="lainnya">Lainnya</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" id="dph1" name="nama_sdm[]" type="text" label="Nama" placeholder="Nama"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No KTP</label><div class="col-lg-8"><div><input class="form-control ktp" id="dph2" name="ktp_sdm[]" type="text" label="No KTP" placeholder="No KTP"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-8"><div><input class="form-control" id="dph3" name="sertif_sdm[]" type="text" label="No Sertifikasi" placeholder="No Sertifikasi" ></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-8"><div><input class="form-control" id="dph4" name="no_tglsk_sdm[]" type="text" label="No dan Tanggal SK" placeholder="No dan Tanggal SK"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">No Kontak</label><div class="col-lg-8"><div><input class="form-control" id="dph5" name="no_kontrak_sdm[]" type="text" label="No Kontrak" placeholder="No Kontak"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">                                
                                                        <div class="detail_sdm" id="detail_dph_sdm" style="width: 100%; background: #e8e8e8;"></div>
                                                        <div class="col-md-12">
                                                            <a id="tam_penyelia_sdm" class="tambah_penyelia_sdm btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Sumber Daya Manusia</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}
                            
                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div>
                                        <div id="wrapperdataproduk" class="wrapper row">
                                            <div class="wrapper row">
                                                <label class="col-12 col-form-label"><h4>Data Produk</h4></label>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Klasifikasi Jenis Produk</label>
                                                            <div class="col-lg-8">
                                                                <div class="radio radio-css radio-inline">
                                                                    <input type="radio" name="klasifikasi_jenis_produk" id="kjpmakanan" value="makanan" checked />
                                                                    <label for="kjpmakanan">Makanan</label>
                                                                </div>
                                                                <div class="radio radio-css radio-inline">
                                                                    <input type="radio" name="klasifikasi_jenis_produk" id="kjpminuman" value="minuman" />
                                                                    <label for="kjpminuman">Minuman</label>
                                                                </div>
                                                                <div class="radio radio-css radio-inline">
                                                                    <input type="radio" name="klasifikasi_jenis_produk" id="kjpobat" value="obat" />
                                                                    <label for="kjpobat">Obat</label>
                                                                </div>
                                                                <div class="radio radio-css radio-inline">
                                                                    <input type="radio" name="klasifikasi_jenis_produk" id="kjpkosmetik" value="kosmetik" />
                                                                    <label for="kjpkosmetik">Kosmetik</label>
                                                                </div>                                                          
                                                            </div>     
                                                    </div>                                                   
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label for="kelompok" class="col-lg-4 col-form-label">Jenis Produk</label>
                
                                                        <div class="col-lg-8">
                                                            <select id="id_kelompok_produk" name="id_kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                                                <option value="">--Pilih Jenis Produk--</option>
                                                                    @if(isset($kelompokProduk))
                                                                        @foreach($kelompokProduk as $index => $value)
                                                                            <option value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                                            @endforeach
                                                                    @endif
                                                            </select>                                
                                                        </div>   
                                                    </div>
                                                </div>
                
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label for="kelompok" class="col-lg-4 col-form-label">Rincian Jenis Produk</label>
                
                                                        <div class="col-lg-8">
                                                            <select multiple="multiple" id="id_rincian_kelompok_produk" name="id_rincian_kelompok_produk[]" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                                                <option value="">--Pilih Jenis Produk--</option>
                                                            </select>
                                                        </div>   
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                
                                                    <label class="col-lg-4 col-form-label">Area Pemasaran</label>
                                                    <div class="col-lg-8">
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="area_pemasaran" id="aplokal" value="lokal" checked />
                                                            <label for="aplokal">Lokal (Maks. 3 Provinsi)</label>
                                                        </div>
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="area_pemasaran" id="apnasional" value="nasional" />
                                                            <label for="apnasional">Nasional</label>
                                                        </div>
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="area_pemasaran" id="apinter" value="internasional" />
                                                            <label for="apinter">Internasional</label>
                                                        </div>                                                          
                                                    </div>   
                                                </div>                                     
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Sistem Pemasaran</label>
                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="jenis_produk" id="jenisProduk1" value="Retail" checked />
                                                                <label for="jenisProduk1">Retail</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="jenis_produk" id="jenisProduk2" value="Non Retail" />
                                                                <label for="jenisProduk2">Non Retail</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="jenis_produk" id="jenisProduk3" value="Retail & Non Retail" />
                                                                <label for="jenisProduk3">Retail & Non Retail</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Izin Edar</label><div class="col-lg-8"><div><input class="form-control" id="izinedar" name="izin_edar" type="text" label="Izin Edar" placeholder="Izin Edar"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produklain" name="produk_lain" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12" id="wrappersni">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">SNI</label><div class="col-lg-8"><div><input class="form-control" id="izinedar" name="sni" type="text" label="SNI" placeholder="SNI"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Merk/Brand</label><div class="col-lg-8"><div><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <div class="detail_dataproduk" id="detail_dataproduk" style="width: 100%; background: #e8e8e8;"></div>
                                                        <div class="col-md-12">
                                                            <a id="tam_data_produk" class="tam_data_produk btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Merk/Brand</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                            
                                        <div id="wrapperjumlahproduksi" class="wrapper row">
                                            <div class="wrapper row">
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-12 col-form-label"><h4>Jumlah Produksi</h4></label>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Jenis Hewan</label><div class="col-lg-8"><div><input class="form-control" id="jenishewan" name="jenis_hewan[]" type="text" label="Jenis Hewan" placeholder="Jenis Hewan"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Jumlah Produksi Perhari</label><div class="col-lg-8"><div><input class="form-control" id="produksiperhari" name="jumlah_produksi_perhari[]" type="text" label="Produksi Perhari" placeholder="Produksi Perhari"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Jumlah Produksi Perbulan</label><div class="col-lg-8"><div><input class="form-control" id="produksiperbulan" name="jumlah_produksi_perbulan[]" type="text" label="Produksi Perbulan" placeholder="Produksi Perbulan"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <div class="jumlahproduksi" id="detail_jumlahproduksi" style="width: 100%; background: #e8e8e8;"></div>
                                                        <div class="col-md-12">
                                                            <a id="tam_jumlah_produksi" class="tam_jumlah_produksi btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Jumlah Produksi</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                      
                                        
                                        <div id="wrapperdatakelompokusaha" class="wrapper row">
                                            <div class="wrapper row">
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-12 col-form-label"><h4>Kelompok Usaha</h4></label>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Kelompok Usaha</label>                                        
                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kelompok_usaha" id="kkrumahmakan" value="rumah makan" checked />
                                                                <label for="kkrumahmakan">Rumah Makan</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kelompok_usaha" id="kkjasaboga" value="jasa boga/katering" />
                                                                <label for="kkjasaboga">Jasa Boga/Katering</label>
                                                            </div>                                    
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Kategori</label>
                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kategori_usaha" id="kelrestoran" value="restoran" checked />
                                                                <label for="kelrestoran">Restoran</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kategori_usaha" id="kelwarung" value="warung" />
                                                                <label for="kelwarung">Warung</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kategori_usaha" id="kelkedai" value="kedai/kafe/kantin/dll" />
                                                                <label for="kelkedai">Kedai/Kafe/Kantin/dll</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="kategori_usaha" id="kelkatering" value="katering" />
                                                                <label for="kelkatering">Katering</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Jumlah Cabang</label><div class="col-lg-8"><div><input class="form-control" id="jumlahcabang" name="jumlah_cabang_usaha" type="text" label="Julah Cabang" placeholder="Jumlah Cabang"></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Alamat Cabang</label><div class="col-lg-8"><div><textarea class="form-control" id="alamatcabang" name="alamat_cabang_usaha" placeholder="Alamat Cabang"></textarea></div></div>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Area Pemasaran</label>                                        
                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_usaha" id="aplokal_ku" value="lokal" checked />
                                                                <label for="aplokal_ku">Lokal (Maks. 3 Provinsi)</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_usaha" id="apnasional_ku" value="nasional" />
                                                                <label for="apnasional_ku">Nasional</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_usaha" id="apinter_ku" value="internasional" />
                                                                <label for="apinter_ku">Internasional</label>
                                                            </div>                                                          
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Izin Edar</label><div class="col-lg-8"><div><input class="form-control" id="izinedar_ku" name="izin_edar_usaha" type="text" label="Izin Edar" placeholder="Izin Edar"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produklain_ku" name="produk_lain_usaha" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-4 col-form-label">Sertifikat Lainnya (Salinan sertifikat laik sehat atau izin usaha lainnya)</label><div class="col-lg-8"><div><input class="form-control" id="sertiflainnya" name="sertifikat_lainnya[]" type="text" label="Sertifikat Lainnya" placeholder="Sertifikat Lainnya"></div></div>
                                                    </div>
                                                </div>

                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <div class="detail_sertifikatlainnya" id="detail_sertifikatlainnya" style="width: 100%; background: #e8e8e8;"></div>
                                                        <div class="col-md-12">
                                                            <a id="tam_sertifikat_lainnya" class="tam_sertifikat_lainnya btn btn-sm btn-primary m-r-5" style="color:white">Tambah Sertifikat Lainnya</a>
                                                        </div>          
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                      
                                        
                                        <div id="wrapperdatajasa" class="wrapper row">
                                            <div class="wrapper row">
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-12 col-form-label"><h4>Jasa</h4></label>
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">
                                                        <label class="col-lg-4 col-form-label">Klasifikasi Jenis Jasa</label>

                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapengolahan" value="pengolahan" checked />
                                                                <label for="kjjasapengolahan">Pengolahan</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapengemasan" value="pengemasan" />
                                                                <label for="kjjasapengemasan">Pengemasan</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapenjualan" value="penjualan" />
                                                                <label for="kjjasapenjualan">Penjualan</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapenyimpanan" value="penyimpanan" />
                                                                <label for="kjjasapenyimpanan">Penyimpanan</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapendistribusian" value="pendistribusian" />
                                                                <label for="kjjasapendistribusian">Pendistribusian</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="klasifikasi_jenis_jasa" id="kjjasapenyajian" value="penyajian" />
                                                                <label for="kjjasapenyajian">Penyajian</label>
                                                            </div>
                                                        </div>                             
                                                    </div>
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">                                                                    
                                                        <label class="col-lg-4 col-form-label">Area Pemasaran</label>
                                                        <div class="col-lg-8">
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_jasa" id="aplokal_jasa" value="lokal" checked />
                                                                <label for="aplokal_jasa">Lokal (Maks. 3 Provinsi)</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_jasa" id="apnasional_jasa" value="nasional" />
                                                                <label for="apnasional_jasa">Nasional</label>
                                                            </div>
                                                            <div class="radio radio-css radio-inline">
                                                                <input type="radio" name="area_pemasaran_jasa" id="apinter_jasa" value="internasional" />
                                                                <label for="apinter_jasa">Internasional</label>
                                                            </div>                                                          
                                                        </div>        
                                                    </div>                        
                                                </div>
                                                <div class="wrapper col-lg-12">
                                                    <div class="row">   
                                                        <label class="col-4 col-form-label">Produk/jasa lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produk_lain_jasa" name="produk_lain_jasa" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                     
                                    </div>                                
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset>                             --}}

                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper row">
                                        <div class="wrapper row">
                                            <label class="col-12 col-form-label"><h4>Data Sistem Manajemen</h4></label>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Sistem manajemen perusahaan yang relevan :</label><div class="col-lg-8"><div><input class="form-control" id="sm_perusahaan" name="sistem_manajemen[]" type="text" placeholder="Sistem manajemen perusahaan"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-lg-4 col-form-label">Sertifikasi</label>
                                                        <div class="col-lg-8"><div>
                                                            <select class="form-control" name="sertifikasi_manajemen[]">
                                                                <option value="ya">Ya</option>
                                                                <option value="tidak">Tidak</option>
                                                            </select>
                                                        </div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <div class="detail_sm" id="detail_sm" style="width: 100%; background: #e8e8e8;"></div>
                                                    <div class="col-md-12">
                                                        <a id="tam_detail_sm" class="tam_detail_sm btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Sistem Manajemen Yang Relevan</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    @component('components.inputtext',['name' => 'outsourcing','label' => 'Proses yang di subkontrakkan (outsourcing), jika ada :','required'=>false,'placeholder'=>'Proses yang di subkontrakkan (outsourcing), jika ada :'])@endcomponent
                                                </div>
                                            </div>

                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    @component('components.inputtext',['name' => 'konsultan','label' => 'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :','required'=>false,'placeholder'=>'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :'])@endcomponent
                                                </div>
                                            </div>

                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    @component('components.inputtext',['name' => 'jumlah_karyawan_organisasi','label' => 'Total jumlah karyawan dalam organisasi :','required'=>false,'placeholder'=>'Total jumlah karyawan dalam organisasi :'])@endcomponent
                                                </div>
                                            </div>

                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-lg-4 col-form-label">Jumlah karyawan (penuh waktu) dalam lingkup sertifikasi</label>
                                                    <div class="col-lg-2">
                                                        @component('components.inputtext',['name'=> 'shift_1','label' => 'Shift 1','required'=>false,'placeholder'=>'Total karyawan'])@endcomponent
                                                    </div>
                                                    <div class="col-lg-2">
                                                        @component('components.inputtext',['name'=> 'shift_2','label' => 'Shift 2','required'=>false,'placeholder'=>'Total karyawan'])@endcomponent
                                                    </div>
                                                    <div class="col-lg-2">
                                                        @component('components.inputtext',['name'=> 'shift_3','label' => 'Shift 3','required'=>false,'placeholder'=>'Total karyawan'])@endcomponent
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" /> <input type="button" name="next" class="next action-button" value="Lanjut" />
                                </div>
                            </fieldset> --}}

                            {{-- <fieldset>
                                <div class="form-card row">
                                    <div class="wrapper row">
                                        <div class="wrapper row">
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><h4>Data Lokasi Lainnya</h4></label>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Lokasi</label><div class="col-lg-8"><div><input class="form-control" id="nama_lokasi_lainnya" name="nama_lokasi_lainnya[]" type="text" label="Nama Lokasi:" placeholder="Nama Lokasi:"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" id="alamat_lainnya" name="alamat_lainnya[]" placeholder="Alamat"></textarea></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Kota</label><div class="col-lg-8"><div><input class="form-control" id="kota_lainnya" name="kota_lainnya[]" type="text" placeholder="Kota"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Kode Pos</label><div class="col-lg-8"><div><input class="form-control" id="kodepos_lainnya" name="kodepos_lainnya[]" type="text" placeholder="Kode Pos"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Telepon</label><div class="col-lg-8"><div><input class="form-control" id="telepon_lainnya" name="telepon_lainnya[]" type="text" placeholder="Telepon"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Fax</label><div class="col-lg-8"><div><input class="form-control" id="fax_lainnya" name="fax_lainnya[]" type="text" placeholder="Fax"></div></div>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Narahubung</label><div class="col-lg-8"><div><input class="form-control" id="narahubung_lainnya" name="narahubung_lainnya[]" type="text" placeholder="Narahubung"></div></div>
                                                </div>
                                            </div>

                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    <div class="detail_datalokasi" id="detail_datalokasi" style="width: 100%; background: #e8e8e8;"></div>
                                                    <div class="col-md-12">
                                                        <a id="tam_detail_datalokasi" class="tam_detail_datalokasi btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Lokasi Lainnya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                             
                                <div class="text-center">                                                                
                                    <input type="button" name="previous" class="previous action-button-previous" value="Kembali" />
                                    <button type="submit" class="action-button">Kirim</button>
                                </div>
                            </fieldset> --}}

                            {{-- <div class="wrapper col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Kirim</button>
                                        @component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
                                    </div>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
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
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>    
    <script>
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var d = date.getDate();
        var month = date.getMonth()+1;
        var y = date.getFullYear();
        if(d < 10 ){ d = '0'+ d;}
        if(month < 10){ month = '0'+ month; }
        var todayFormat = y+"-"+month+"-"+d ;        

        $('#tgl_registrasi').val(todayFormat);        

        var jumlah=0;
        var jumlahdataproduk=0;                        
        
        var merk;
        var detaildataproduk = document.getElementById('detail_dataproduk');
        detaildataproduk.style.display = 'block';

        $('#tam_data_produk').on('click', function(){             
            merk = $('#merk').val();             

            detaildataproduk.style.display = 'block';

            adddataproduk();       
        });        

        function adddataproduk(){
            var data_produk = '<div> <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Merk/Brand</label><div class="col-lg-7"><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand" required></div> <div class="col-lg-1"><a id="hapus_dataproduk" class="btn btn-sm btn-danger m-r-5" style="color:white">X</a></div> </div> </div> </div>';
            // var data_produk = '<div>q</div>';
            $('.detail_dataproduk').append(data_produk);
            jumlahdataproduk+=1;            
        }

        $(document).on('click','#hapus_dataproduk', function(){                        
            $(this).parent().parent().parent().remove();
            jumlahdataproduk-=1;

            if(jumlahdataproduk == 0){
                detaildataproduk.style.display = 'none';
            }            
        });                         

        $(function () {
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });            

            $('#id_kelompok_produk').on('change', function () {                                        
                $.ajax({                    
                    url: '{{ route('dependent_dropdown_rincian.store') }}',
                    method: 'POST',
                    data: {id: $(this).val()},
                    success: function (response) {                                                
                        $('#id_rincian_kelompok_produk').empty();                               
                        $.each(response, function (rincian_kelompok_produk, kode_klasifikasi) {                            
                            $("#id_rincian_kelompok_produk").append(new Option(kode_klasifikasi+' | '+rincian_kelompok_produk, rincian_kelompok_produk))
                        })
                        $('#id_rincian_kelompok_produk').selectpicker('refresh');
                    }                   
                })
            });
        });

    </script> 

    <script>
    $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function(){            
        
        // current_fs = $(this).parent().;
        // next_fs = $(this).parent().next();
        current_fs = $(this).parent().parent();
        next_fs = $(this).parent().parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        next_fs.css({'opacity': opacity});
        },
        duration: 600
        });
        });

        $(".previous").click(function(){

        current_fs = $(this).parent().parent();
        previous_fs = $(this).parent().parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        previous_fs.css({'opacity': opacity});
        },
        duration: 600
        });
        });

        $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
        });

        $(".submit").click(function(){
        return false;
        })

        });   
    </script>

    <script src="{{asset('/assets/js/cleave.js')}}"></script>
    <script src="{{asset('/assets/js/main.js')}}"></script>    
                    
@endpush