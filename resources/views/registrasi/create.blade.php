@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link rel="stylesheet" >    
@endpush

@section('content')
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
                    <form action="{{route('registrasiHalal.store')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        
                        <div class="form-group row">                            
                            @csrf                            
                            <label class="col-12 col-form-label"><h4>Data Umum</h4></label>

                            <label class="col-lg-4 col-form-label">Tanggal Registrasi</label>
                            <div class="col-lg-8">
                                <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control " readonly/>
                            </div>
                            

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

                            <label class="col-lg-4 col-form-label">Status Registrasi</label>
                            <div class="col-lg-8">
                                <div style="margin-bottom:7px;">
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi1" value="baru" checked />
                                        <label for="statusRegistrasi1">Baru</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi2"  value="perpanjangan" />
                                        <label for="statusRegistrasi2">*Perpanjangan</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="status_registrasi" id="statusRegistrasi3"  value="pengembangan" />
                                        <label for="statusRegistrasi3">*Pengembangan</label>
                                    </div>
                                </div>
                            </div>

                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan','required'=>true,'placeholder'=>'Nama Perusahaan'])@endcomponent

                            @component('components.inputtext',['name'=> 'no_surat','id' => 'no_surat','label' => 'No. Surat Permohonan Sertifikasi','required'=>true,'placeholder'=>'32-2-0120-1005'])@endcomponent                            

                            <label id="lsh" class="col-lg-4 col-form-label">*Status Halal Sebelumnya</label>
                            <div id="sh" class="col-lg-8">
                                <input type="text" name="status_halal" class="form-control" placeholder="Status Halal Sebelumnuya"  />
                            </div>

                            <label id="lshb" class="col-lg-4 col-form-label">*SH Berlaku s/d</label>
                            <div id="shb" class="col-lg-8">                                
                                <div class="input-group date">
                                    <input type="text" id="sh_berlaku" name="sh_berlaku" class="form-control" placeholder="SH Berlaku s/d" value="" data-date-start-date="Date.default" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>                            

                            <label id="lsjph0" class="col-lg-4 col-form-label">No. Sertifikat SJPH</label>
                            <div id="dsjph0" class="col-lg-8">
                                <input type="text" name="no_sertifikat" class="form-control" placeholder="No. Sertifikat SJPH"  />
                            </div>

                            <label id="lsjph" class="col-lg-4 col-form-label">SJPH Berlaku s/d</label>
                            <div id="dsjph" class="col-lg-8">
                                <div class="input-group date">
                                    <input id="tgl_sjph" name="tgl_sjph" type="text" class="form-control" placeholder="SJPH Berlaku s/d"  data-date-start-date="Date.default" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>

                            <label class="col-lg-4 col-form-label">Jenis Produk</label>
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
                                <small class="f-s-12 text-grey-darker m-t-5">Jika nilai "Skala Usaha" adalah "Usaha Kecil" maka Registrasi bisa menggunakan NPWP atau KTP</small>
                            </div>

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
                            

                            <label class="col-lg-4 col-form-label">NPWP/KTP</label>
                            <div class="col-lg-8">
                                <div style="margin-bottom:10px;">
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="tipe" id="tipe1" value="ktp" checked />
                                        <label for="tipe1">KTP</label>
                                    </div>
                                    <div class="radio radio-css radio-inline">
                                        <input type="radio" name="tipe" id="tipe2" value="npwp" />
                                        <label for="tipe2">NPWP</label>
                                    </div>
                                </div>
                                <input id="no_tipe" name="no_tipe" type="text" class="form-control ktp" placeholder="KTP"/>
                                <input id="no_tipe2" name="no_tipe2" type="text" class="form-control npwp" placeholder="NPWP"/>
                            </div>

                            @component('components.inputtext',['name'=> 'jenis_izin','label' => 'Jenis Izin Usaha','required'=>true,'placeholder'=>'MD/ML/PIRT/TR/TI/DKL/SD/SI/CD/CL/CA//ITUP/ISUP/NKV/HC/CFS'])@endcomponent

                            @component('components.inputtext',['id'=>'jumlah_karyawan','name'=> 'jumlah_karyawan','label' => 'Jumlah Karyawan','type' => 'number','max' => '10','required'=>true,'placeholder'=>'Jumlah Karyawan'])@endcomponent

                            @component('components.inputtext',['name'=> 'kapasitas_produksi','label' => 'Kapasitas Produksi','required'=>true,'placeholder'=>'Contoh: 1000 Ton / Tahun'])@endcomponent

                            <label for="kelompok" class="col-lg-4 col-form-label">Kelompok Produk</label>

                            <div class="col-lg-8">
                                <select id="id_kelompok_produk" name="id_kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="">--Pilih Kelompok Produk--</option>
                                        @if(isset($kelompokProduk))
                                            @foreach($kelompokProduk as $index => $value)
                                                <option value="{{$value['id']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                @endforeach
                                        @endif
                                </select>
                            </div>                            

                            <label class="col-12 col-form-label" id="textalamatkantor"><h4>Alamat Kantor</h4></label>
                            @component('components.inputtextarea',['name'=> 'alamat_kantor','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat Kantor'])@endcomponent
                            @component('components.inputtext',['name'=> 'kota_kantor','label' => 'Kota','required'=>true,'placeholder'=>'Kota/Kab'])@endcomponent
                            @component('components.inputtext',['name'=> 'provinsi_kantor','label' => 'Provinsi','required'=>true,'placeholder'=>'Provinsi'])@endcomponent
                            @component('components.inputtext',['name'=> 'negara_kantor','label' => 'Negara','required'=>true,'placeholder'=>'Negara'])@endcomponent
                            @component('components.inputtext',['name'=> 'telepon_kantor','label' => 'Telepon','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                            @component('components.inputtext',['name'=> 'kodepos_kantor','label' => 'Kode Pos','required'=>true,'placeholder'=>'Kode Pos'])@endcomponent
                            @component('components.inputemail',['name'=> 'email_kantor','label' => 'Email','required'=>true,'placeholder'=>'Email'])@endcomponent
                            
                            <label class="col-12 col-form-label" id="textalamatpabrik"><h4>Alamat Pabrik</h4></label>
                            @component('components.inputtextarea',['name'=> 'alamat_pabrik','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat Pabrik'])@endcomponent
                            @component('components.inputtext',['name'=> 'kota_pabrik','label' => 'Kota','required'=>true,'placeholder'=>'Kota/Kab'])@endcomponent
                            @component('components.inputtext',['name'=> 'provinsi_pabrik','label' => 'Provinsi','required'=>true,'placeholder'=>'Provinsi'])@endcomponent
                            @component('components.inputtext',['name'=> 'negara_pabrik','label' => 'Negara','required'=>true,'placeholder'=>'Negara'])@endcomponent
                            @component('components.inputtext',['name'=> 'telepon_pabrik','label' => 'Telepon','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                            @component('components.inputtext',['name'=> 'kodepos_pabrik','label' => 'Kode Pos','required'=>true,'placeholder'=>'Kode Pos'])@endcomponent
                            @component('components.inputemail',['name'=> 'email_pabrik','label' => 'Email','required'=>true,'placeholder'=>'Email'])@endcomponent

                            <!--status pabrik-->
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

                            <label class="col-12 col-form-label"><h4>Pemilik Perusahaan</h4></label>
                            @component('components.inputtext',['name'=> 'nama_pemilik','label' => 'Nama','required'=>true,'placeholder'=>'Nama'])@endcomponent
                            @component('components.inputtext',['name'=> 'jabatan_pemilik','label' => 'Jabatan','required'=>true,'placeholder'=>'Jabatan'])@endcomponent
                            @component('components.inputtext',['name'=> 'telepon_pemilik','label' => 'Telepon','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                            @component('components.inputtext',['name'=> 'fax_pemilik','label' => 'Fax','required'=>true,'placeholder'=>'Fax'])@endcomponent
                            @component('components.inputemail',['name'=> 'email_pemilik','label' => 'Email','required'=>true,'placeholder'=>'Email'])@endcomponent

                            <label class="col-12 col-form-label"><h4>Penanggung Jawab</h4></label>
                            @component('components.inputtext',['name'=> 'nama_pj','label' => 'Nama','required'=>true,'placeholder'=>'Nama'])@endcomponent
                            @component('components.inputtext',['name'=> 'jabatan_pj','label' => 'Jabatan','required'=>true,'placeholder'=>'Jabatan'])@endcomponent
                            @component('components.inputtext',['name'=> 'telepon_pj','label' => 'Telepon','required'=>true,'placeholder'=>'Telepon'])@endcomponent
                            @component('components.inputtext',['name'=> 'fax_pj','label' => 'Fax','required'=>true,'placeholder'=>'Fax'])@endcomponent
                            @component('components.inputemail',['name'=> 'email_pj','label' => 'Email','required'=>true,'placeholder'=>'Email'])@endcomponent

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

                            @component('components.inputtext',['name'=> 'nib','label' => 'Nomor Induk Berusaha (NIB)','required'=>true,'placeholder'=>'Nomor Induk Berusaha (NIB)'])@endcomponent

                            <label class="col-4 col-form-label" id="nkv1">Nomor Kontrol Veteriner</label><div class="col-lg-8" id="nkv2"><div><input class="form-control" id="nkv3" name="nkv" type="text" placeholder="Nomor Kontrol Veteriner (NKV)"></div></div>

                            <div id="wrapperaspeklegal" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Aspek Legal Lainnya (IUMK,IUI,SIUP,API,Dll)</h4></label>
                                    @component('components.inputtext',['name'=> 'jenis_surat','label' => 'Jenis Surat','required'=>false,'placeholder'=>'Jenis Surat'])@endcomponent
                                    @component('components.inputtext',['name'=> 'nomor_surat','label' => 'Nomor Surat','required'=>false,'placeholder'=>'Nomor Surat'])@endcomponent
                                        <div class="col-lg-8">
                                            <small class="f-s-12 text-grey-darker m-t-5">jika sudah memiliki NIB, dokumen lainnya tidak diperlukan</small>
                                        </div>
                                </div>
                            </div>

                            
                                                        

                            <div id="wrapperpenyelia" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Data Penyelia Halal</h4></label>
                                    <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" id="dph1" name="nama_dph[]" type="text" label="Nama" placeholder="Nama"></div></div>
                                    <label class="col-4 col-form-label">No KTP</label><div class="col-lg-8"><div><input class="form-control" id="dph2" name="ktp_dph[]" type="text" label="No KTP" placeholder="No KTP"></div></div>
                                    <label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-8"><div><input class="form-control" id="dph3" name="sertif_dph[]" type="text" label="No Sertifikasi" placeholder="No Sertifikasi" ></div></div>
                                    <label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-8"><div><input class="form-control" id="dph4" name="no_tglsk_dph[]" type="text" label="No dan Tanggal SK" placeholder="No dan Tanggal SK"></div></div>
                                    <label class="col-4 col-form-label">No Kontrak</label><div class="col-lg-8"><div><input class="form-control" id="dph5" name="no_kontrak_dph[]" type="text" label="No Kontrak" placeholder="No Kontrak"></div></div>
                                
                                    <div class="penyelia" id="detail_dph" style="width: 100%; background: #e8e8e8;"></div>
                                        <div class="col-md-12">
                                            <a id="tam_penyelia" class="tambah_penyelia btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Penyelia Halal</a>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            
                            <div id="wrappersdm" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Data Sumber Daya Manusia</h4></label>                            

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

                                    <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" id="dph1" name="nama_sdm[]" type="text" label="Nama" placeholder="Nama"></div></div>
                                    <label class="col-4 col-form-label">No KTP</label><div class="col-lg-8"><div><input class="form-control" id="dph2" name="ktp_sdm[]" type="text" label="No KTP" placeholder="No KTP"></div></div>
                                    <label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-8"><div><input class="form-control" id="dph3" name="sertif_sdm[]" type="text" label="No Sertifikasi" placeholder="No Sertifikasi" ></div></div>
                                    <label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-8"><div><input class="form-control" id="dph4" name="no_tglsk_sdm[]" type="text" label="No dan Tanggal SK" placeholder="No dan Tanggal SK"></div></div>
                                    <label class="col-4 col-form-label">No Kontrak</label><div class="col-lg-8"><div><input class="form-control" id="dph5" name="no_kontrak_sdm[]" type="text" label="No Kontrak" placeholder="No Kontrak"></div></div>
                                
                                    <div class="detail_sdm" id="detail_dph_sdm" style="width: 100%; background: #e8e8e8;"></div>
                                    <div class="col-md-12">
                                        <a id="tam_penyelia_sdm" class="tambah_penyelia_sdm btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Sumber Daya Manusia</a>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- --------------------------------------------}}
                            <div id="wrapperdataproduk" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Data Produk</h4></label>
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

                                        <label class="col-4 col-form-label">Izin Edar</label><div class="col-lg-8"><div><input class="form-control" id="izinedar" name="izin_edar" type="text" label="Izin Edar" placeholder="Izin Edar"></div></div>
                                        <label class="col-4 col-form-label">Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produklain" name="produk_lain" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>

                                        <label class="col-4 col-form-label">Merk/Brand</label><div class="col-lg-8"><div><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand"></div></div>
                                        <div class="detail_dataproduk" id="detail_dataproduk" style="width: 100%; background: #e8e8e8;"></div>
                                        <div class="col-md-12">
                                            <a id="tam_data_produk" class="tam_data_produk btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Merk/Brand</a>
                                        </div>            
                                </div>
                            </div>  
                            {{-- akhir data produk --}}
                                                   
                            <div id="wrapperjumlahproduksi" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Jumlah Produksi</h4></label>
                                    <label class="col-4 col-form-label">Jenis Hewan</label><div class="col-lg-8"><div><input class="form-control" id="jenishewan" name="jenis_hewan[]" type="text" label="Jenis Hewan" placeholder="Jenis Hewan"></div></div>
                                    <label class="col-4 col-form-label">Jumlah Produksi Perhari</label><div class="col-lg-8"><div><input class="form-control" id="produksiperhari" name="jumlah_produksi_perhari[]" type="text" label="Produksi Perhari" placeholder="Produksi Perhari"></div></div>
                                    <label class="col-4 col-form-label">Jumlah Produksi Perbulan</label><div class="col-lg-8"><div><input class="form-control" id="produksiperbulan" name="jumlah_produksi_perbulan[]" type="text" label="Produksi Perbulan" placeholder="Produksi Perbulan"></div></div>
                                    <div class="jumlahproduksi" id="detail_jumlahproduksi" style="width: 100%; background: #e8e8e8;"></div>
                                    <div class="col-md-12">
                                        <a id="tam_jumlah_produksi" class="tam_jumlah_produksi btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Jumlah Produksi</a>
                                    </div>            
                                </div>
                            </div>  
                            {{-- akhir data produk --}}

                            {{--kelompok usaha---}}
                            <div id="wrapperdatakelompokusaha" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Kelompok Usaha</h4></label>
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
                                    
                                    <label class="col-4 col-form-label">Jumlah Cabang</label><div class="col-lg-8"><div><input class="form-control" id="jumlahcabang" name="jumlah_cabang_usaha" type="text" label="Julah Cabang" placeholder="Jumlah Cabang"></div></div>
                                    <label class="col-4 col-form-label">Alamat Cabang</label><div class="col-lg-8"><div><textarea class="form-control" id="alamatcabang" name="alamat_cabang_usaha" placeholder="Alamat Cabang"></textarea></div></div>
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
                                    <label class="col-4 col-form-label">Izin Edar</label><div class="col-lg-8"><div><input class="form-control" id="izinedar_ku" name="izin_edar_usaha" type="text" label="Izin Edar" placeholder="Izin Edar"></div></div>
                                    <label class="col-4 col-form-label">Produk lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produklain_ku" name="produk_lain_usaha" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>

                                    <label class="col-4 col-form-label">Sertifikat Lainnya (Salinan sertifikat laik sehat atau izin usaha lainnya)</label><div class="col-lg-8"><div><input class="form-control" id="sertiflainnya" name="sertifikat_lainnya[]" type="text" label="Sertifikat Lainnya" placeholder="Sertifikat Lainnya"></div></div>

                                    <div class="detail_sertifikatlainnya" id="detail_sertifikatlainnya" style="width: 100%; background: #e8e8e8;"></div>
                                    <div class="col-md-12">
                                        <a id="tam_sertifikat_lainnya" class="tam_sertifikat_lainnya btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Lokasi Lainnya</a>
                                    </div>          
                                </div>
                            </div>  
                            {{-- akhir data kelompokusaha --}}

                            {{--jasa---}}
                            <div id="wrapperdatajasa" class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Jasa</h4></label>
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
                                    <label class="col-4 col-form-label">Produk/jasa lain yang diproduksi/dilayani oleh organisasi diluar ruang lingkup sertifikasi yang diajukan, (jika ada):</label><div class="col-lg-8"><div><input class="form-control" id="produk_lain_jasa" name="produk_lain_jasa" type="text" label="Produk Lain" placeholder="Produk Lain"></div></div>
                                </div>
                            </div> 

                            {{-- akhir data jasa --}}
                            <div class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Data Sistem Manajemen</h4></label>
                                    <label class="col-4 col-form-label">Sistem manajemen perusahaan yang relevan :</label><div class="col-lg-8"><div><input class="form-control" id="sm_perusahaan" name="sistem_manajemen[]" type="text" placeholder="Sistem manajemen perusahaan"></div></div>
                                    <label class="col-lg-4 col-form-label">Sertifikasi</label>
                                    <div class="col-lg-8"><div>
                                        <select class="form-control" name="sertifikasi_manajemen[]">
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div></div>
                                    
                                    <div class="detail_sm" id="detail_sm" style="width: 100%; background: #e8e8e8;"></div>
                                    <div class="col-md-12">
                                        <a id="tam_detail_sm" class="tam_detail_sm btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Sistem Manajemen Yang Relevan</a>
                                    </div>

                                    @component('components.inputtext',['name' => 'outsourcing','label' => 'Proses yang di subkontrakkan (outsourcing), jika ada :','required'=>false,'placeholder'=>'Proses yang di subkontrakkan (outsourcing), jika ada :'])@endcomponent
                                    @component('components.inputtext',['name' => 'konsultan','label' => 'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :','required'=>false,'placeholder'=>'Konsultan yang akan/sedang membantu (nama dan informasi kontak konsultan) :'])@endcomponent
                                    @component('components.inputtext',['name' => 'jumlah_karyawan_organisasi','label' => 'Total jumlah karyawan dalam organisasi :','required'=>false,'placeholder'=>'Total jumlah karyawan dalam organisasi :'])@endcomponent
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

                            <div class="wrapper row">
                                <div class="wrapper row">
                                    <label class="col-12 col-form-label"><h4>Data Lokasi Lainnya</h4></label>
                                    <label class="col-4 col-form-label">Nama Lokasi</label><div class="col-lg-8"><div><input class="form-control" id="nama_lokasi_lainnya" name="nama_lokasi_lainnya[]" type="text" label="Nama Lokasi:" placeholder="Nama Lokasi:"></div></div>
                                    <label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" id="alamat_lainnya" name="alamat_lainnya[]" placeholder="Alamat"></textarea></div></div>
                                    <label class="col-4 col-form-label">Kota</label><div class="col-lg-8"><div><input class="form-control" id="kota_lainnya" name="kota_lainnya[]" type="text" placeholder="Kota"></div></div>
                                    <label class="col-4 col-form-label">Kode Pos</label><div class="col-lg-8"><div><input class="form-control" id="kodepos_lainnya" name="kodepos_lainnya[]" type="text" placeholder="Kode Pos"></div></div>
                                    <label class="col-4 col-form-label">Telepon</label><div class="col-lg-8"><div><input class="form-control" id="telepon_lainnya" name="telepon_lainnya[]" type="text" placeholder="Telepon"></div></div>
                                    <label class="col-4 col-form-label">Fax</label><div class="col-lg-8"><div><input class="form-control" id="fax_lainnya" name="fax_lainnya[]" type="text" placeholder="Fax"></div></div>
                                    <label class="col-4 col-form-label">Narahubung</label><div class="col-lg-8"><div><input class="form-control" id="narahubung_lainnya" name="narahubung_lainnya[]" type="text" placeholder="Narahubung"></div></div>
                            
                                    <div class="detail_datalokasi" id="detail_datalokasi" style="width: 100%; background: #e8e8e8;"></div>
                                    <div class="col-md-12">
                                        <a id="tam_detail_datalokasi" class="tam_detail_datalokasi btn btn-sm btn-primary m-r-5" style="color:white">Tambah Data Lokasi Lainnya</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 offset-md-5">
                                <button type="submit" class="btn btn-sm btn-primary m-r-5">Kirim</button>
                                @component('components.buttonback',['href' => route("registrasiHalal.index")])@endcomponent
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
        $('#sh_berlaku').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_sjph').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

        var selectedValue;
        function getSelectedValue(){
            selectedValue = document.getElementById("id_jenis_reg").value;
            console.log(selectedValue);
            if(selectedValue == 1 || selectedValue == 5){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Pabrik</h4>';

                document.getElementById("wrapperdataproduk").style.display = 'block';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'none';
                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 2){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Lokasi Produksi</h4>';
                document.getElementById("textstatuspabrik").innerHTML = 'Status Lokasi Produksi';
                
                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'block';
                document.getElementById("wrapperdatajasa").style.display = 'none';                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 4){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Pabrik</h4>';

                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'block';                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 3){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat RPH/U Lainnya</h4>';
                document.getElementById("textjenisbadanusaha").innerHTML = 'Status Unit Usaha';
                document.getElementById("textalamatkantor").innerHTML = '<h4>Alamat Utama</h4>';
                document.getElementById("textstatuspabrik").innerHTML = 'Status RPH/U';

                
                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'none';
                document.getElementById("wrapperaspeklegal").style.display = 'none';                
                document.getElementById("nkv1").style.display = 'block';
                document.getElementById("nkv2").style.display = 'block';
                document.getElementById("jusaha1").style.display = 'block';
                document.getElementById("jusaha2").style.display = 'block';                
                document.getElementById("wrapperpenyelia").style.display = 'none';
                document.getElementById("wrappersdm").style.display = 'block';
                document.getElementById("wrapperjumlahproduksi").style.display = 'block';
            }
        }        

        selectedValue = document.getElementById("id_jenis_reg").value;
        console.log(selectedValue);
            if(selectedValue == 1 || selectedValue == 5){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Pabrik</h4>';

                document.getElementById("wrapperdataproduk").style.display = 'block';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'none';                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 2){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Lokasi Produksi</h4>';
                document.getElementById("textstatuspabrik").innerHTML = 'Status Lokasi Produksi';
                
                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'block';
                document.getElementById("wrapperdatajasa").style.display = 'none';                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 4){
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat Pabrik</h4>';
                document.getElementById("textalamatkantor").innerHTML = '<h4>Alamat Kantor</h4>';

                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'block';                
                document.getElementById("wrapperaspeklegal").style.display = 'block';
                document.getElementById("nkv1").style.display = 'none';
                document.getElementById("nkv2").style.display = 'none';
                document.getElementById("jusaha1").style.display = 'none';
                document.getElementById("jusaha2").style.display = 'none';
                document.getElementById("wrapperpenyelia").style.display = 'block';
                document.getElementById("wrappersdm").style.display = 'none';
                document.getElementById("wrapperjumlahproduksi").style.display = 'none';
            }else if(selectedValue == 3){                
                document.getElementById("textalamatpabrik").innerHTML = '<h4>Alamat RPH/U Lainnya</h4>';
                document.getElementById("textjenisbadanusaha").innerHTML = 'Status Unit Usaha';
                document.getElementById("textalamatkantor").innerHTML = '<h4>Alamat Utama</h4>';

                document.getElementById("wrapperdataproduk").style.display = 'none';
                document.getElementById("wrapperdatakelompokusaha").style.display = 'none';
                document.getElementById("wrapperdatajasa").style.display = 'none';                
                document.getElementById("wrapperaspeklegal").style.display = 'none';
                document.getElementById("nkv1").style.display = 'block';
                document.getElementById("nkv2").style.display = 'block';
                document.getElementById("jusaha1").style.display = 'block';
                document.getElementById("jusaha2").style.display = 'block';
                document.getElementById("wrapperpenyelia").style.display = 'none';
                document.getElementById("wrappersdm").style.display = 'block';
                document.getElementById("wrapperjumlahproduksi").style.display = 'block';
            }

        var jumlah=0;
        var jumlahdataproduk=0;
        var jumlahdatasm=0;
        var jumlahlokasilainnya=0;
        var jumlahsertiflainnya=0;
        var nama;
        var ktp;
        var sertif;
        var sk;
        var kontrak;
        var detaildph = document.getElementById('detail_dph');
        var detaildphsdm = document.getElementById('detail_dph_sdm');
        var detailjumlahproduksi = document.getElementById('detail_jumlahproduksi');
        detaildph.style.display = 'none'; 
        detaildphsdm.style.display = 'none';
        detail_jumlahproduksi.style.display = 'none';
        var jmlsdm=0;
        var jmlproduksi=0;        
                
        //1
        $('#tam_penyelia').on('click', function(){                                    
            nama = $('#dph1').val();
            ktp = $('#dph2').val();
            sertif = $('#dph3').val();
            sk = $('#dph4').val();
            kontrak = $('#dph5').val(); 

            detaildph.style.display = 'block';                       

            addpenyelia();          
        });

        function addpenyelia(){
            jumlah+=1;
            var penyelia = '<div> <label class="col-4 col-form-label">Nama</label><div class="col-lg-4"><input class="form-control" id="dph1" name="nama_dph[]" type="text" placeholder="Nama"></div><label class="col-4 col-form-label">No KTP</label><div class="col-lg-4"><div><input class="form-control" id="dph2" name="ktp_dph[]" type="text" placeholder="No KTP"></div></div><label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-4"><div><input class="form-control" id="dph3" name="sertif_dph[]" type="text"  placeholder="No Sertifikasi" ></div></div><label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-4"><div><input class="form-control" id="dph4" name="no_tglsk_dph[]" type="text" placeholder="No dan Tanggal SK" ></div></div><label class="col-4 col-form-label">No Kontrak</label><div class="col-lg-4"><div><input class="form-control" id="dph5" name="no_kontrak_dph[]" type="text" placeholder="No Kontrak"></div></div><div class="col-lg-12"><div><a id="hapus_penyelia" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr></div>';
            $('.penyelia').append(penyelia);            
        }

        $(document).on('click','#hapus_penyelia', function(){                        
            $(this).parent().parent().parent().remove();
            jumlah-=1;

            if(jumlah == 0){
                detaildph.style.display = 'none';
            }
        });

        //2
        var listkjp = document.registerForm.klasifikasi_jenis_produk;
        var klasifikasi='Makanan';

        for (var j = 0; j < listkjp.length; j++) {
            listkjp[j].addEventListener('change', function() {
                if (this.value == 'makanan') {
                    klasifikasi = 'Makanan';
                }else if (this.value == 'minuman') {
                    klasifikasi = 'Minuman';
                }else if (this.value == 'obat') {
                    klasifikasi = 'Obat';
                }else if (this.value == 'kosmetik') {
                    klasifikasi = 'Kosmetik';
                }else{
                    
                }
            });
        }
        
        var merk;
        var detaildataproduk = document.getElementById('detail_dataproduk');
        detaildataproduk.style.display = 'none';

        $('#tam_data_produk').on('click', function(){                                                
            merk = $('#merk').val();             

            detaildataproduk.style.display = 'block';                     

            adddataproduk();       
        });

        function adddataproduk(){
            var data_produk = '<div> <label class="col-4 col-form-label">Merk/Brand</label><div class="col-lg-8"><div><input class="form-control" id="merk" name="merk[]" type="text" label="Merk/Brand" placeholder="Merk/Brand" required></div></div> <div class="col-lg-12"><div><a id="hapus_dataproduk" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr> </div>';            
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

        //3
        var sistemmanajemen;
        var detaildatasm = document.getElementById('detail_sm');
        detaildatasm.style.display = 'none';
        var nosertif=1;
        var nosm = 2;

        $('#tam_detail_sm').on('click', function(){                                                
            sistemmanajemen = $('#sm_perusahaan').val();           

            detaildatasm.style.display = 'block';                     

            nosertif+=1;
            adddatasm();       
        });

        function adddatasm(){
            var data_sm = '<div> <label class="col-4 col-form-label">Sistem manajemen perusahaan yang relevan :</label><div class="col-lg-8"><div><input class="form-control" id="sm_perusahaan" name="sistem_manajemen[]" type="text" placeholder="Sistem manajemen perusahaan"></div></div> <label class="col-lg-4 col-form-label">Sertifikasi</label><div class="col-lg-8"><div><select class="form-control" name="sertifikasi_manajemen[]"><option value="ya">Ya</option><option value="tidak">Tidak</option></select></div></div> <div class="col-lg-12"><div><a id="hapus_datasm" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr> </div>';
            $('.detail_sm').append(data_sm);
            nosm++;
            jumlahdatasm+=1;
        }

        $(document).on('click','#hapus_datasm', function(){                        
            $(this).parent().parent().parent().remove();
            jumlahdatasm-=1;
            nosertif-=1;

            if(jumlahdatasm == 0){
                detaildatasm.style.display = 'none';
            }
        });

        //4
        var lokasilainnya,alamatlainnya,kotalainnya,kodeposlainnya,teleponlainnya,faxlainnya,narahubunglainnya;        
        var detaildatalokasilain = document.getElementById('detail_datalokasi');
        detaildatalokasilain.style.display = 'none';
        var nolainnya=1;

        $('#tam_detail_datalokasi').on('click', function(){                                                
            lokasilainnya = $('#nama_lokasi_lainnya').val();
            alamatlainnya = $('#alamat_lainnya').val();
            kotalainnya = $('#kota_lainnya').val();
            kodeposlainnya = $('#kodepos_lainnya').val();
            teleponlainnya = $('#telepon_lainnya').val();
            faxlainnya = $('#fax_lainnya').val();
            narahubunglainnya = $('#narahubung_lainnya').val();            

            detaildatalokasilain.style.display = 'block';                     

            nolainnya+=1;
            adddatalokasilain();       
        });

        function adddatalokasilain(){            
            var data_lain = '<div>  <label class="col-4 col-form-label">Nama Lokasi</label><div class="col-lg-8"><div><input class="form-control" id="nama_lokasi_lainnya" name="nama_lokasi_lainnya[]" type="text" label="Nama Lokasi:" placeholder="Nama Lokasi:"></div></div><label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" id="alamat_lainnya" name="alamat_lainnya[]" placeholder="Alamat"></textarea></div></div><label class="col-4 col-form-label">Kota</label><div class="col-lg-8"><div><input class="form-control" id="kota_lainnya" name="kota_lainnya[]" type="text" placeholder="Kota"></div></div><label class="col-4 col-form-label">Kode Pos</label><div class="col-lg-8"><div><input class="form-control" id="kodepos_lainnya" name="kodepos_lainnya[]" type="text" placeholder="Kode Pos"></div></div><label class="col-4 col-form-label">Telepon</label><div class="col-lg-8"><div><input class="form-control" id="telepon_lainnya" name="telepon_lainnya[]" type="text" placeholder="Telepon"></div></div><label class="col-4 col-form-label">Fax</label><div class="col-lg-8"><div><input class="form-control" id="fax_lainnya" name="fax_lainnya[]" type="text" placeholder="Fax"></div></div><label class="col-4 col-form-label">Narahubung</label><div class="col-lg-8"><div><input class="form-control" id="narahubung_lainnya" name="narahubung_lainnya[]" type="text" placeholder="Narahubung"></div></div> <div class="col-lg-12"><div><a id="hapus_datalain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr> </div>';
            $('.detail_datalokasi').append(data_lain);
            jumlahsertiflainnya+=1;            
        }

        $(document).on('click','#hapus_datalain', function(){                        
            $(this).parent().parent().parent().remove();
            jumlahsertiflainnya-=1;
            nolainnya-=1;

            if(jumlahsertiflainnya == 0){
                detaildatalokasilain.style.display = 'none';
            }
        });      

        // detail_sertifikatlainnya     

        var detailsertifikatlainnya = document.getElementById('detail_sertifikatlainnya');                             
        detailsertifikatlainnya.style.display = 'none';

        $('#tam_sertifikat_lainnya').on('click', function(){                                                            

            detailsertifikatlainnya.style.display = 'block';                     
            
            // nolainnya+=1;
            adddatasertiflain();  
        });

        function adddatasertiflain(){            
            var data_sertiflain = '<div>  <label class="col-4 col-form-label">Sertifikat Lainnya (Salinan sertifikat laik sehat atau izin usaha lainnya)</label><div class="col-lg-8"><div><input class="form-control" id="sertiflainnya" name="sertifikat_lainnya[]" type="text" label="Sertifikat Lainnya" placeholder="Sertifikat Lainnya"></div></div> <div class="col-lg-12"><div><a id="hapus_sertiflain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr> </div>';
            $('.detail_sertifikatlainnya').append(data_sertiflain);
            jumlahlokasilainnya+=1;                    
        }

        $(document).on('click','#hapus_sertiflain', function(){                        
            $(this).parent().parent().parent().remove();
            jumlahlokasilainnya-=1;
            nolainnya-=1;

            if(jumlahlokasilainnya == 0){
                detaildatalokasilain.style.display = 'none';
            }
        }); 


        $('#tam_jumlah_produksi').on('click', function(){                                                            

            detailjumlahproduksi.style.display = 'block';            

            addjmlprod();
        });

        function addjmlprod(){
            jmlproduksi+=1;            
            var jmlprod = '<div> <div id="wrapperjumlahproduksi" class="wrapper row"><div class="wrapper row"><label class="col-4 col-form-label">Jenis Hewan</label><div class="col-lg-8"><div><input class="form-control" id="jenishewan" name="jenis_hewan[]" type="text" label="Jenis Hewan" placeholder="Jenis Hewan"></div></div> <label class="col-4 col-form-label">Julah Produksi Perhari</label><div class="col-lg-8"><div><input class="form-control" id="produksiperhari" name="jumlah_produksi_perhari[]" type="text" label="Produksi Perhari" placeholder="Produksi Perhari"></div></div> <label class="col-4 col-form-label">Jumlah Produksi Perbulan</label><div class="col-lg-8"><div><input class="form-control" id="produksiperbulan" name="jumlah_produksi_perbulan[]" type="text" label="Produksi Perbulan" placeholder="Produksi Perbulan"></div></div> </div></div> <div class="col-lg-12"><div><a id="hapus_jml_produksi" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr> </div>';
            
            $('.jumlahproduksi').append(jmlprod);            
        }

        $(document).on('click','#hapus_jml_produksi', function(){                        
            $(this).parent().parent().parent().remove();
            jmlproduksi-=1;

            if(jmlproduksi == 0){
                detailjumlahproduksi.style.display = 'none';
            }
        });
        

        $('#tam_penyelia_sdm').on('click', function(){                                                            

            detaildphsdm.style.display = 'block';            

            addsdm();
        });

        function addsdm(){
            jmlsdm+=1;            
            var sdm = '<div> <div id="wrappersdm" class="wrapper row"><div class="wrapper row"><label class="col-lg-4 col-form-label">Jenis Data SDM</label><div class="col-lg-8"><div><select name="jenis_sdm[]" class="form-control"><option value="penyelia halal" selected>Penyelia Halal</option><option value="juru sembelih halal">Juru Sembelih Halal</option><option value="dokter hewan">Dokter Hewan</option><option value="lainnya">Lainnya</option></select></div></div><label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" id="dph1" name="nama_sdm[]" type="text" label="Nama" placeholder="Nama"></div></div><label class="col-4 col-form-label">No KTP</label><div class="col-lg-8"><div><input class="form-control" id="dph2" name="ktp_sdm[]" type="text" label="No KTP" placeholder="No KTP"></div></div><label class="col-4 col-form-label">No Sertifikat</label><div class="col-lg-8"><div><input class="form-control" id="dph3" name="sertif_sdm[]" type="text" label="No Sertifikasi" placeholder="No Sertifikasi" ></div></div><label class="col-4 col-form-label">No dan Tanggal SK</label><div class="col-lg-8"><div><input class="form-control" id="dph4" name="no_tglsk_sdm[]" type="text" label="No dan Tanggal SK" placeholder="No dan Tanggal SK"></div></div><label class="col-4 col-form-label">No Kontrak</label><div class="col-lg-8"><div><input class="form-control" id="dph5" name="no_kontrak_sdm[]" type="text" label="No Kontrak" placeholder="No Kontrak"></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_penyelia_sdm" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus</a></div></div><hr></div>';
            
            $('.detail_sdm').append(sdm);            
        }

        $(document).on('click','#hapus_penyelia_sdm', function(){                        
            $(this).parent().parent().parent().remove();
            jmlsdm-=1;

            if(jmlsdm == 0){
                detaildphsdm.style.display = 'none';
            }
        });     

        var reg = document.registerForm.status_registrasi;
        var tipe = document.registerForm.tipe;
        var skala = document.registerForm.skala_usaha;
        var jenisbadanusaha = document.registerForm.jenis_badan_usaha;
        var jusaha = document.registerForm.jenis_usaha;
        var kp_kep = document.registerForm.kepemilikan;
        var stat_pabrik = document.registerForm.status_pabrik;

        var lsh = document.getElementById('lsh');
        var sh = document.getElementById('sh');
        var lshb = document.getElementById('lshb');
        var shb = document.getElementById('shb');
        var jb_usaha = document.getElementById('j_badanusaha');
        var kepemilikan_lainnya = document.getElementById('k_lainnya');
        var s_pabrik = document.getElementById('sp');   
        var s_jenisusaha = document.getElementById('ju');

        lsh.style.display = 'none';
        sh.style.display = 'none';
        lshb.style.display = 'none';
        shb.style.display = 'none';
        jb_usaha.style.display = 'none';
        kepemilikan_lainnya.style.display = 'none';
        s_pabrik.style.display = 'none';
        s_jenisusaha.style.display = 'none';

        for (var j = 0; j < jenisbadanusaha.length; j++) {
            jenisbadanusaha[j].addEventListener('change', function() {
                if (this.value == 'lainnya') {
                    jb_usaha.style.display = 'block';
                }else{
                    jb_usaha.style.display = 'none';                    
                }
            });
        }

        for (var j = 0; j < jusaha.length; j++) {
            jusaha[j].addEventListener('change', function() {
                if (this.value == 'lainnya') {
                    s_jenisusaha.style.display = 'block';
                }else{
                    s_jenisusaha.style.display = 'none';                    
                }
            });
        }
        

        for (var j = 0; j < stat_pabrik.length; j++) {
            stat_pabrik[j].addEventListener('change', function() {
                if (this.value == 'lainnya') {
                    s_pabrik.style.display = 'block';
                }else{
                    s_pabrik.style.display = 'none';                    
                }
            });
        }

        for (var j = 0; j < kp_kep.length; j++) {
            kp_kep[j].addEventListener('change', function() {
                if (this.value == 'lainnya') {
                    k_lainnya.style.display = 'block';
                }else{
                    k_lainnya.style.display = 'none';                    
                }
            });
        }

        for (var i = 0; i < reg.length; i++) {
            reg[i].addEventListener('change', function() {
                if (this.value == 'baru') {
                    lsh.style.display = 'none';
                    sh.style.display = 'none';
                    lshb.style.display = 'none';
                    shb.style.display = 'none';
                }else{
                    lsh.style.display = 'block';
                    sh.style.display = 'block';
                    lshb.style.display = 'block';
                    shb.style.display = 'block';
                }
            });
        }

        $('#no_tipe').attr('placeholder','No. KTP');
        $('#no_tipe2').attr('placeholder','No. NPWP');        

        document.getElementById("no_tipe").style.display="block";
        document.getElementById("no_tipe2").style.display="none";

        for (var i = 0; i < tipe.length; i++) {
            tipe[i].addEventListener('change', function() {
                if (this.value == 'ktp') {                    
                    document.getElementById("no_tipe").style.display="block";
                    document.getElementById("no_tipe2").style.display="none";                                       
                }else{                    
                    document.getElementById("no_tipe").style.display="none";
                    document.getElementById("no_tipe2").style.display="block";        
                }
            });
        }

        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
                });
            });
        }
        setInputFilter(document.getElementById("jumlah_karyawan"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        });                

    </script>    

    <script src="{{asset('/assets/js/cleave.js')}}"></script>
    <script src="{{asset('/assets/js/main.js')}}"></script>    
                    
@endpush