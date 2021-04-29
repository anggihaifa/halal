@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Penjadwalan</a></li>        
        <li class="breadcrumb-item active">Laporan Audit</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Laporan Audit<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Laporan Audit</h4>
                    <div class="panel-heading-btn">
                        {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> --}}
                    </div>
                </div>
                <div class="card-header tab-overflow p-t-0 p-b-0">
                    <ul class="nav nav-tabs card-header-tabs">
                        {{-- <li class="nav-item text-center">
                            <a class="nav-link" data-toggle="tab" href="#card-tab-1">Laporan SJPH</a>
                        </li>                    
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-2">Laporan Bahan</a>
                        </li>                                    
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-3">Laporan Fasilitas Produksi</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-4">Laporan Produk</a>
                        </li> --}}
                        {{-- <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-5">Laporan Bahan</a>
                        </li> --}}
                        <li class="nav-item text-center">                        
                            <a class="nav-link active" data-toggle="tab" href="#card-tab-6">Form Checklist Audit Tahap 2</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-7">Laporan Audit Tahap 2</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body table-responsive-lg ">
					<div class="tab-content p-0 m-0">
                        {{-- <div class="tab-pane fade active show" id="card-tab-1">
                            <form action="{{route('downloadlaporanauditsjph')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                        
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan SJPH</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanauditsjphfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">                         
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_organisasi','label' => 'No Organisasi','required'=>true,'placeholder'=>'No Organisasi'])@endcomponent
                                        </div>
                                    </div>                                                                                                                                                                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor'])@endcomponent
                                        </div>
                                    </div>                                           
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Data</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Kriteria</label><div class="col-lg-8"><div><input class="form-control" name="kriteria[]" type="text" label="Kriteria" placeholder="Kriteria"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Temuan/Catatan</label>
                                            <div class="col-lg-8"><div>
                                                <textarea name="temuan[]" class="form-control" placeholder="Temuan/Catatan"></textarea>
                                            </div></div>                                
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan" id="detail_kegiatan" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan" class="tam_detail_kegiatan btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="card-tab-2">
                            <form action="{{route('downloadlaporanauditbahan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan Bahan</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanauditbahanfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">                                                                                                     
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor'])@endcomponent
                                        </div>
                                    </div>                                           
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Data</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Bahan</label><div class="col-lg-8"><div><input class="form-control" name="bahan[]" type="text" label="Bahan" placeholder="Bahan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Temuan</label>
                                            <div class="col-lg-8"><div>
                                                <textarea name="temuan[]" class="form-control" placeholder="Temuan"></textarea>
                                            </div></div>                                
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Kategori Bahan</label><div class="col-lg-8"><div><input class="form-control" name="kategori_bahan[]" type="text" label="Kategori Bahan" placeholder="Kategori Bahan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Catatan" placeholder="Catatan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan2" id="detail_kegiatan2" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan2" class="tam_detail_kegiatan2 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="card-tab-3">
                            <form action="{{route('downloadlaporanauditfasilitasproduksi')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)

                                            @php
                                            $str = explode("_", $value2->pelaksana1_audit2);
                                            $auditor1 = $str[1];

                                            $str2 = explode("_", $value2->pelaksana2_audit2);
                                            $auditor2 = $str2[1];
                                            @endphp
                                            
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$auditor1.' dan '.$auditor2])@endcomponent
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan Fasilitas Produksi</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanauditfasilitasproduksifix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                        @php
                                            $str = explode("_", $value2->pelaksana1_audit2);
                                            $auditor1 = $str[1];

                                            $str2 = explode("_", $value2->pelaksana2_audit2);
                                            $auditor2 = $str2[1];
                                            @endphp
                                            
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$auditor1.' dan '.$auditor2])@endcomponent
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Fasilitas Produksi</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_fasilitas_produksi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Fasilitas Produksi Lainnya</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_fasilitas_produksi_lainnya">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Gambar Denah Fasilitas Produksi</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="denah_fasilitas_produksi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Daftar Peralatan Yang Kontak Langsung Dengan Bahan</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Daftar Peralatan</label><div class="col-lg-8"><div><input class="form-control" name="daftar_peralatan[]" type="text" label="Daftar Peralatan" placeholder="Daftar Peralatan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Bahan Peralatan Yang Digunakan</label><div class="col-lg-8"><div><input class="form-control" name="bahan_peralatan[]" type="text" label="Bahan Peralatan Yang Digunakan" placeholder="Kategori Bahan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                      
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan3" id="detail_kegiatan3" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan3" class="tam_detail_kegiatan3 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="card-tab-4">
                            <form action="{{route('downloadlaporanproduk')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)

                                            @php
                                            $str = explode("_", $value2->pelaksana1_audit2);
                                            $auditor1 = $str[1];

                                            $str2 = explode("_", $value2->pelaksana2_audit2);
                                            $auditor2 = $str2[1];
                                            @endphp
                                            
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$auditor1.' dan '.$auditor2])@endcomponent
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan Produk</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanprodukfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi','required'=>true,'placeholder'=>'No Registrasi','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                        @php
                                            $str = explode("_", $value2->pelaksana1_audit2);
                                            $auditor1 = $str[1];

                                            $str2 = explode("_", $value2->pelaksana2_audit2);
                                            $auditor2 = $str2[1];
                                            @endphp
                                            
                                            @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$auditor1.' dan '.$auditor2])@endcomponent
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>                                
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Daftar Produk Yang Disertifikasi (Industri Pengolahan)</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Karakteristik Sensori</label><div class="col-lg-8"><div><input class="form-control" name="karakteristik_sensori[]" type="text" label="Karakteristik Sensori" placeholder="Karakteristik Sensori"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Bentuk</label><div class="col-lg-8"><div><input class="form-control" name="bentuk[]" type="text" label="Bentuk" placeholder="Bentuk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Penjualan (Retail/Non Retail)</label><div class="col-lg-8"><div><input class="form-control" name="penjualan[]" type="text" label="Penjualan" placeholder="Penjualan (Retail/Non Retail)"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan4" id="detail_kegiatan4" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan4" class="tam_detail_kegiatan4 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Produk</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_produk[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                        
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan5" id="detail_kegiatan5" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan5" class="tam_detail_kegiatan5 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Daftar Produk Yang Disertifikasi (Restoran/Katering)</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk2[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk2[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Karakteristik Sensori</label><div class="col-lg-8"><div><input class="form-control" name="karakteristik_sensori2[]" type="text" label="Karakteristik Sensori" placeholder="Karakteristik Sensori"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Bentuk</label><div class="col-lg-8"><div><input class="form-control" name="bentuk2[]" type="text" label="Bentuk" placeholder="Bentuk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Penjualan (Retail/Non Retail)</label><div class="col-lg-8"><div><input class="form-control" name="penjualan2[]" type="text" label="Penjualan" placeholder="Penjualan (Retail/Non Retail)"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan6" id="detail_kegiatan6" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan6" class="tam_detail_kegiatan6 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Produk</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_produk2[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto2[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                        
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan7" id="detail_kegiatan7" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan7" class="tam_detail_kegiatan7 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="card-tab-5">
                            5
                        </div> --}}
                        <div class="tab-pane fade active show" id="card-tab-6">
                            <form action="{{route('downloadlaporanaudit2')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan Audit Tahap 2</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanaudittahap2fix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">                         
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nomor_id','label' => 'No ID','required'=>true,'placeholder'=>'No ID'])@endcomponent
                                        </div>
                                    </div>                                                                                                                                                                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'skema_audit','label' => 'Skema Audit','required'=>true,'placeholder'=>'Skema Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'jenis_audit','label' => 'Jenis Audit','required'=>true,'placeholder'=>'Jenis Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_audit','label' => 'No Audit','required'=>true,'placeholder'=>'No Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tujuan_audit','label' => 'Tujuan Audit','required'=>true,'placeholder'=>'Tujuan Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'lingkup_audit','label' => 'Lingkup Audit','required'=>true,'placeholder'=>'Lingkup Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'jenis_produk','label' => 'Jenis Produk & Klasifikasi','required'=>true,'placeholder'=>'Jenis Produk & Kode Klasifikasi'])@endcomponent
                                            <p><b>&nbsp;&nbsp;&nbsp;*) Khusus skema audit SJPH</b></p>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'lokasi_audit1','label' => 'Lokasi Audit','required'=>true,'placeholder'=>'Lokasi Audit 1'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'lokasi_audit2','label' => '','required'=>false,'placeholder'=>'Lokasi Audit 2'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tim_audit1','label' => 'Tim Audit','required'=>true,'placeholder'=>'Tim Audit 1'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tim_audit2','label' => '','required'=>true,'placeholder'=>'Tim Audit 2'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="card-header bg-light">
                                        <ul class="nav nav-tabs card-header-tabs">
                                            <li class="nav-item text-center">
                                                <a class="nav-link active" data-toggle="tab" href="#card-tab-11">Komitmen dan tanggung Jawab</a>
                                            </li>                    
                                            <li class="nav-item text-center">                        
                                                <a class="nav-link" data-toggle="tab" href="#card-tab-22">Bahan</a>
                                            </li>
                                            <li class="nav-item text-center">                        
                                                <a class="nav-link" data-toggle="tab" href="#card-tab-33">Proses Produk Halal (PPH)</a>
                                            </li>
                                            <li class="nav-item text-center">                        
                                                <a class="nav-link" data-toggle="tab" href="#card-tab-44">Produk</a>
                                            </li>
                                            <li class="nav-item text-center">                        
                                                <a class="nav-link" data-toggle="tab" href="#card-tab-55">Pemantauan dan Evaluasi</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content p-0 m-0">
                                        <div class="tab-pane fade active show" id="card-tab-11">
                                            <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                                <thead>
                                                    <tr>                                                            
                                                        <td colspan="6" class="valign-middle font-weight-bold">
                                                            Keterangan:
                                                            <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                            <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).
                                                            <br>iii.	TR (Tidak Relevan): Pertanyaan tidak relevan atau tidak berlaku dengan kondisi perusahaan

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="2%" class="  valign-middle text-center">No</th>
                                                        <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                                        <th width="3%" class="  valign-middle text-center">M</th>                                                
                                                        <th width="3%" class="  valign-middle text-center">TM</th>
                                                        <th width="3%" class="  valign-middle text-center">TR</th>
                                                        <th width="30%" class="  valign-middle text-center">Catatan Auditor/ Perbaikan  Dokumen</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                                                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center">1</td>
                                                            <td colspan="5" class="valign-middle font-weight-bold">Komitmen dan Tanggung Jawab</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">a</td>
                                                            <td class="valign-middle font-weight-bold">Kebijakan Halal</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Kebijakan halal telah ditetapkan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="m" id="1a1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="tm" id="1a1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="tr" id="1a1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a1" type="text" class="form-control" placeholder="Catatan" id="1a1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku usaha/manajemen puncak perusahaan wajib melaksanakan kebijakan halal secara konsisten</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a2" value="m" id="1a2m"/>                                  
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a2" value="tm" id="1a2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a2" value="tr" id="1a2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a2" type="text" class="form-control" placeholder="Catatan" id="1a2ca" />
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Kebijakan halal telah dipahami dan diterapkan oleh seluruh personil dalam organisasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="m" id="1a3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="tm" id="1a3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="tr" id="1a3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a3" type="text" class="form-control" placeholder="Catatan" id="1a3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Kebijakan halal telah disosialisasikan dan dikomunikasikan kepada seluruh pihak terkait (stakeholder)</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="m" id="1a4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="tm" id="1a4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="tr" id="1a4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a4" type="text" class="form-control" placeholder="Catatan" id="1a4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">b</td>
                                                            <td class="valign-middle font-weight-bold">Tanggung Jawab Pimpinan Puncak</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Penyelia Halal muslim sudah ditetapkan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="m" id="1b1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="tm" id="1b1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="tr" id="1b1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b1" type="text" class="form-control" placeholder="Catatan" id="1b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Penyelia Halal sudah teregistrasi di Badan Penyelenggara Jaminan Produk Halal (BPJPH)</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="m" id="1b2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="tm" id="1b2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="tr" id="1b2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b2" type="text" class="form-control" placeholder="Catatan" id="1b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Personil muslim difasilitasi untuk beribadah</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="m" id="1b3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="tm" id="1b3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="tr" id="1b3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b3" type="text" class="form-control" placeholder="Catatan" id="1b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Komitmen untuk menjaga integritas halal telah diterapkan oleh semua personil di perusahaan termasuk pemasok dan distributor</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="m" id="1b4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="tm" id="1b4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="tr" id="1b4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b4" type="text" class="form-control" placeholder="Catatan" id="1b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha/pimpinan puncak perusahaan berskala besar wajib menetapkan tim manajemen halal yang melibatkan seluruh pihak terkait dan disertai bukti tertulis</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="m" id="1b5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="tm" id="1b5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="tr" id="1b5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b5" type="text" class="form-control" placeholder="Catatan" id="1b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha berskala Mikro dan Kecil (UMK) dapat memiliki tim manajemen halal dan/atau Penyelia Halal melalui fasilitasi oleh pihak lain seperti Pemerintah Pusat, Pemerintah Daerah, BUMN, BUMD, Perguruan Tinggi Negeri melalui Pusat Kajian Halal, dan Lembaga Keagamaan Islam berbadan hukum</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="m" id="1b6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="tm" id="1b6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="tr" id="1b6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b6" type="text" class="form-control" placeholder="Catatan" id="1b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle font-weight-bold">Pembinaan Sumber Daya Manusia</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Penyelia halal sudah diikutsertakan dalam pelatihan Penyelia Halal yang dilaksanakan oleh BPJPH dan/atau lembaga eksternal yang bekerja sama dengan BPJPH</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="m" id="1c1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="tm" id="1c1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="tr" id="1c1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c1" type="text" class="form-control" placeholder="Catatan" id="1c1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Personil terkait sudah difasilitasi pelatihan internal mengenai penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="m" id="1c2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="tm" id="1c2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="tr" id="1c2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c2" type="text" class="form-control" placeholder="Catatan" id="1c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Prosedur tertulis pelatihan sudah ditetapkan oleh manajemen puncak</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="m" id="1c3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="tm" id="1c3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="tr" id="1c3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c3" type="text" class="form-control" placeholder="Catatan" id="1c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Rekaman pelaksanaan pelatihan sudah terdokumentasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="m" id="1c4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="tm" id="1c4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="tr" id="1c4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c4" type="text" class="form-control" placeholder="Catatan" id="1c4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset">
                                                            </td>                                                                                                
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="card-tab-22">
                                            <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                                <thead>
                                                    <tr>                                                            
                                                        <td colspan="6" class="valign-middle font-weight-bold">
                                                            Keterangan:
                                                            <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                            <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).
                                                            <br>iii.	TR (Tidak Relevan): Pertanyaan tidak relevan atau tidak berlaku dengan kondisi perusahaan

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="2%" class="  valign-middle text-center">No</th>
                                                        <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                                        <th width="3%" class="  valign-middle text-center">M</th>                                                
                                                        <th width="3%" class="  valign-middle text-center">TM</th>
                                                        <th width="3%" class="  valign-middle text-center">TR</th>
                                                        <th width="30%" class="  valign-middle text-center">Catatan Auditor/ Perbaikan  Dokumen</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                    <tr>
                                                        <td class="valign-middle text-center">2</td>
                                                        <td colspan="5" class="valign-middle font-weight-bold">Bahan</td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle">1. Seluruh bahan yang digunakan untuk Proses Produk Halal wajib memiliki status kehalalan berdasarkan ketetapan Al-Qur’an, Hadits, dan Fatwa Ulama</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="m" id="21m"/>                                  
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="tm" id="21tm"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="tr" id="21tr"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca21" type="text" class="form-control" placeholder="Catatan" id="21ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle">2. Seluruh bahan didukung dengan dokumen yang sesuai dan valid</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="m" id="22m"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="tm" id="22tm"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="tr" id="22tr"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca22" type="text" class="form-control" placeholder="Catatan" id="22ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle">3. Seluruh bahan yang digunakan telah tercantum dalam daftar bahan</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="m" id="23m"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="tm" id="23tm"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="tr" id="23tr"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca23" type="text" class="form-control" placeholder="Catatan" id="23ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle">4. Bahan yang memerlukan verifikasi lebih lanjut diperlukan pengambilan sampel untuk pengujian laboratorium</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb24" value="m" id="24m"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb24" value="tm" id="24tm"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb24" value="tr" id="24tr"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca24" type="text" class="form-control" placeholder="Catatan" id="24ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                        <td class="valign-middle" colspan="4">
                                                            <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset2">
                                                        </td>                                                                                                
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="card-tab-33">
                                            <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                                <thead>
                                                    <tr>                                                            
                                                        <td colspan="6" class="valign-middle font-weight-bold">
                                                            Keterangan:
                                                            <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                            <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).
                                                            <br>iii.	TR (Tidak Relevan): Pertanyaan tidak relevan atau tidak berlaku dengan kondisi perusahaan

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="2%" class="  valign-middle text-center">No</th>
                                                        <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                                        <th width="3%" class="  valign-middle text-center">M</th>                                                
                                                        <th width="3%" class="  valign-middle text-center">TM</th>
                                                        <th width="3%" class="  valign-middle text-center">TR</th>
                                                        <th width="30%" class="  valign-middle text-center">Catatan Auditor/ Perbaikan  Dokumen</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                        <tr>
                                                            <td class="valign-middle text-center">3</td>
                                                            <td colspan="5" class="valign-middle font-weight-bold">Proses Produk Halal (PPH)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">a</td>
                                                            <td class="valign-middle font-weight-bold">Lokasi, Tempat dan peralatan</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Lokasi, tempat dan peralatan PPH bebas dari babi/turunannya, barang haram, dan najis</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="m" id="3a1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="tm" id="3a1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="tr" id="3a1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a1" type="text" class="form-control" placeholder="Catatan" id="3a1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Lokasi, tempat dan peralatan PPH wajib dipisahkan dari produk yang akan dihalalkan dengan produk yang tidak halal agar tidak terjadi kontaminasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="m" id="3a2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="tm" id="3a2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="tr" id="3a2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a2" type="text" class="form-control" placeholder="Catatan" id="3a2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Lokasi, tempat dan peralatan PPH wajib dijaga kebersihan, higieni sanitasi, dan terpelihara untuk mencegah masuknya hama dan penyakit serangga lainnya, serta bebas dari hewan peliharaan dan hewan liar</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3" value="m" id="3a3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3" value="tm" id="3a3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3" value="tr" id="3a3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3" type="text" class="form-control" placeholder="Catatan" id="3a3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Fasilitas sanitasi wajib disediakan dalam jumlah yang memadai dan dipelihara kebersihannya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4" value="m" id="3a4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4" value="tm" id="3a4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4" value="tr" id="3a4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4" type="text" class="form-control" placeholder="Catatan" id="3a4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Fasilitas display dipisahkan secara fisik antara produk halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5" value="m" id="3a5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5" value="tm" id="3a5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5" value="tr" id="3a5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5" type="text" class="form-control" placeholder="Catatan" id="3a5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Seluruh penggunaan fasilitas, barang, dan peralatan terpisahkan antara produk halal dan non halal. (compile dengan point 7 & 8.)</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6" value="m" id="3a6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6" value="tm" id="3a6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6" value="tr" id="3a6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a6" type="text" class="form-control" placeholder="Catatan" id="3a6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7.  a. Fasilitas Penerimaan/penampungan dan penimbangan bahan dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="m" id="3a7am"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="tm" id="3a7atm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="tr" id="3a7atr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7a" type="text" class="form-control" placeholder="Catatan" id="3a7aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">&nbsp;&nbsp;&nbsp;&nbsp;b. Fasilitas pencampuran dan pencetakkan bahan dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="m" id="3a7bm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="tm" id="3a7btm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="tr" id="3a7btr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7b" type="text" class="form-control" placeholder="Catatan" id="3a7bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">&nbsp;&nbsp;&nbsp;&nbsp;c. Fasilitas pemasakan dan proses-proses tambahan lainnya dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="m" id="3a7cm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="tm" id="3a7ctm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="tr" id="3a7ctr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7c" type="text" class="form-control" placeholder="Catatan" id="3a7cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Fasilitas penyimpanan bahan dan produk serta sarananya telah dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8" value="m" id="3a8m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8" value="tm" id="3a8tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8" value="tr" id="3a8tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a8" type="text" class="form-control" placeholder="Catatan" id="3a8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">9. Fasilitas pengemasan produk telah dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9" value="m" id="3a9m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9" value="tm" id="3a9tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9" value="tr" id="3a9tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a9" type="text" class="form-control" placeholder="Catatan" id="3a9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">10. Fasilitas sarana distribusi dari tempat penyimpanan ke distribusi produk dan alat transportasi untuk distribusi produk telah dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10" value="m" id="3a10m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10" value="tm" id="3a10tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10" value="tr" id="3a10tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a10" type="text" class="form-control" placeholder="Catatan" id="3a10ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">11. Fasilitas tempat penjualan dari sarana sampai proses penjualan telah dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11" value="m" id="3a11m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11" value="tm" id="3a11tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11" value="tr" id="3a11tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a11" type="text" class="form-control" placeholder="Catatan" id="3a11ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">12. Fasilitas tempat penyajian dari sarana sampai proses penyajian telah dipisahkan antara produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="m" id="3a12m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="tm" id="3a12tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="tr" id="3a12tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a12" type="text" class="form-control" placeholder="Catatan" id="3a12ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">13. Proses pendistribusian, penjualan, dan penyajian, produk hewan segar telah dipisahkan antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="m" id="3a13m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="tm" id="3a13tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="tr" id="3a13tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a13" type="text" class="form-control" placeholder="Catatan" id="3a13ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">14. Proses penjualan, penyajian produk hewan segar dan olahan asal hewan  telah dipisahkan antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="m" id="3a14m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="tm" id="3a14tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="tr" id="3a14tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a14" type="text" class="form-control" placeholder="Catatan" id="3a14ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">15. Tempat produksi dirancang untuk memfasilitasi proses pembersihan dan pengawasan yang tepat</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="m" id="3a15m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="tm" id="3a15tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="tr" id="3a15tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a15" type="text" class="form-control" placeholder="Catatan" id="3a15ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">16. Lokasi proses produksi jauh dari peternakan babi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="m" id="3a16m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="tm" id="3a16tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="tr" id="3a16tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a16" type="text" class="form-control" placeholder="Catatan" id="3a16ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">17. Tempat proses produksi halal bebas dari hewan peliharaan dan hewan liar</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="m" id="3a17m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="tm" id="3a17tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="tr" id="3a17tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a17" type="text" class="form-control" placeholder="Catatan" id="3a17ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">18.	Fasilitasi pencucian peralatan terpisah antara proses produksi halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="m" id="3a18m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="tm" id="3a18tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="tr" id="3a18tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a18" type="text" class="form-control" placeholder="Catatan" id="3a18ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">19. Fasilitas display antara produk halal dan non halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="m" id="3a19m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="tm" id="3a19tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="tr" id="3a19tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a19" type="text" class="form-control" placeholder="Catatan" id="3a19ca"/>
                                                            </td>
                                                        </tr>                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center">b</td>
                                                            <td class="valign-middle font-weight-bold">Peralatan dan Perangkat Proses Produk Halal</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Peralatan dan perangkat dipisahkan antara Proses Produk Halal dengan Produk yang tidak halal meliputi alat penyembelihan, pengolahan, penyimpanan, pengemasan, pendistribusian, penjualan, dan penyajian</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="m" id="3b1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="tm" id="3b1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="tr" id="3b1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b1" type="text" class="form-control" placeholder="Catatan" id="3b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Sarana peralatan penyembelihan yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="m" id="3b2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="tm" id="3b2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="tr" id="3b2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b2" type="text" class="form-control" placeholder="Catatan" id="3b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Sarana peralatan pengolahan yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="m" id="3b3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="tm" id="3b3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="tr" id="3b3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b3" type="text" class="form-control" placeholder="Catatan" id="3b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Alat proses produksi halal dijamin kebersihan, higienitas, bebas dari najis, dan bebas dari bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="m" id="3b4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="tm" id="3b4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="tr" id="3b4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b4" type="text" class="form-control" placeholder="Catatan" id="3b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Peralatan, perangkat, dan mesin yang bersentuhan langsung dengan PPH tidak terbuat dari bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="m" id="3b5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="tm" id="3b5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="tr" id="3b5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b5" type="text" class="form-control" placeholder="Catatan" id="3b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Bahan untuk perawatan perangkat proses produk halal tidak terbuat dari bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="m" id="3b6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="tm" id="3b6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="tr" id="3b6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b6" type="text" class="form-control" placeholder="Catatan" id="3b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Peralatan/alat penolong tidak menggunakan bahan tidak halal, contoh kuas babi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="m" id="3b7m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="tm" id="3b7tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="tr" id="3b7tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b7" type="text" class="form-control" placeholder="Catatan" id="3b7ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Sarana peralatan penyimpanan yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="m" id="3b8m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="tm" id="3b8tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="tr" id="3b8tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b8" type="text" class="form-control" placeholder="Catatan" id="3b8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">9. Sarana peralatan pengemasan yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="m" id="3b9m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="tm" id="3b9tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="tr" id="3b9tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b9" type="text" class="form-control" placeholder="Catatan" id="3b9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">10. Sarana peralatan pendistribusian yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="m" id="3b10m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="tm" id="3b10tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="tr" id="3b10tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b10" type="text" class="form-control" placeholder="Catatan" id="3b10ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">11. Sarana peralatan penjualan yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="m" id="3b11m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="tm" id="3b11tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="tr" id="3b11tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b11" type="text" class="form-control" placeholder="Catatan" id="3b11ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">12. Sarana peralatan penyajian yang digunakan berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="m" id="3b12m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="tm" id="3b12tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="tr" id="3b12tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b12" type="text" class="form-control" placeholder="Catatan" id="3b12ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">13. Peralatan untuk pengambilan sampel tidak terkontaminasi dengan bahan atau produk tidak halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="m" id="3b13m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="tm" id="3b13tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="tr" id="3b13tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b13" type="text" class="form-control" placeholder="Catatan" id="3b13ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle font-weight-bold">Prosedur Proses Produk Halal (PPH)</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                1.	Proses Produk Halal harus dimiliki dan diterapkan sebagai berikut :
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;a.	Penggunaan fasilitas produksi yang kontak dengan Bahan dan/atau Produk antara/akhir bersifat bebas dari Najis berat (Mughalazah)
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;b.	Penggunaan Bahan dan Produk yang diajukan tidak terkontaminasi Najis
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;c.	Penyucian fasilitas produksi sesuai syariat Islam
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;d.	Penggunaan Bahan baru yang akan digunakan untuk Produk Halal
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;e.	Pembelian Bahan
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;f.	Pemeriksaan kedatangan Bahan
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;g.	Proses produksi
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;h.	Penyimpanan Bahan dan Produk
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;i.	Transportasi Bahan dan Produk
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;j.	Ketertelusuran kehalalan
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;k.	Penanganan Produk yang tidak memenuhi kriteria halal
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;l.	Penarikan Produk
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;m.	Peluncuran/penjualan Produk
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;n.	Formulasi produk/pengembangan Produk baru
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;o.	Display Produk
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;p.	Ketentuan pengunjung
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;q.	Penentuan menu
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;r.	Pemingsanan hewan
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;s.	Penyembelihan hewan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1" value="m" id="3c1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1" value="tm" id="3c1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1" value="tr" id="3c1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1" type="text" class="form-control" placeholder="Catatan" id="3c1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Prosedur Proses Produk Halal disosialisasikan ke semua pihak yang terkait</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="m" id="3c2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="tm" id="3c2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="tr" id="3c2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c2" type="text" class="form-control" placeholder="Catatan" id="3c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Bukti sosialisasi terdokumentasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="m" id="3c3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="tm" id="3c3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="tr" id="3c3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c3" type="text" class="form-control" placeholder="Catatan" id="3c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Proses Produk Halal dilakukan evaluasi secara berkala</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="m" id="3c4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="tm" id="3c4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="tr" id="3c4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c4" type="text" class="form-control" placeholder="Catatan" id="3c4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Hasil evaluasi disampaikan kepada penanggung jawab Proses Produk Halal dan pihak terkait</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="m" id="3c5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="tm" id="3c5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="tr" id="3c5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c5" type="text" class="form-control" placeholder="Catatan" id="3c5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Memiliki prosedur penarikan dan pengendalian serta pengamanan dan pengawasan untuk produk yang tidak memenuhi kriteria halal.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="m" id="3c6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="tm" id="3c6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="tr" id="3c6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c6" type="text" class="form-control" placeholder="Catatan" id="3c6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Memiliki prosedur identifikasi, analisis bahaya ketidakhalalan dalam proses produksinya dan penetapan
                                                                titik kritis serta menetapkan tindakan pencegahan dan monitoring terhadap titik kritis tersebut
                                                                </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="m" id="3c7m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="tm" id="3c7tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="tr" id="3c7tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c7" type="text" class="form-control" placeholder="Catatan" id="3c7ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Tindakan koreksi dan tindakan pencegahan yang diperlukan terhadap hasil evaluasi serta batas waktu penyelesaiannya telah ditetapkan
                                                                </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="m" id="3c8m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="tm" id="3c8tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="tr" id="3c8tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c8" type="text" class="form-control" placeholder="Catatan" id="3c8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                9. Memiliki prosedur pencucian Najis mughallazah yang masuk ke dalam jalur produksi halal sesuai dengan ketentuan syariat Islam sebagai berikut :
                                                                &nbsp;&nbsp;&nbsp;&nbsp;a.	Cuci dengan air 7x yang salah satunya dengan tanah (atau pengganti dengan daya pembersih yang sama
                                                                &nbsp;&nbsp;&nbsp;&nbsp;b.	Tidak menggunakan secara bergantian produk babi dan non babi walaupun sudah melalui proses pencucian
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="m" id="3c9m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="tm" id="3c9tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="tr" id="3c9tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c9" type="text" class="form-control" placeholder="Catatan" id="3c9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                10. Memiliki diagram alir Produk atau proses yang dicakup dalam Sistem Jaminan Produk Halal
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="m" id="3c10m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="tm" id="3c10tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="tr" id="3c10tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c10" type="text" class="form-control" placeholder="Catatan" id="3c10ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset3">
                                                            </td>                                                                                                
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="card-tab-44">
                                            <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                                <thead>
                                                    <tr>                                                            
                                                        <td colspan="6" class="valign-middle font-weight-bold">
                                                            Keterangan:
                                                            <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                            <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).
                                                            <br>iii.	TR (Tidak Relevan): Pertanyaan tidak relevan atau tidak berlaku dengan kondisi perusahaan

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="2%" class="  valign-middle text-center">No</th>
                                                        <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                                        <th width="3%" class="  valign-middle text-center">M</th>                                                
                                                        <th width="3%" class="  valign-middle text-center">TM</th>
                                                        <th width="3%" class="  valign-middle text-center">TR</th>
                                                        <th width="30%" class="  valign-middle text-center">Catatan Auditor/ Perbaikan  Dokumen</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                        <tr>
                                                            <td class="valign-middle text-center">4</td>
                                                            <td colspan="5" class="valign-middle font-weight-bold">Produk</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">a</td>
                                                            <td class="valign-middle font-weight-bold">Umum</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Produk dan bahan yang dihasilkan harus diproses dengan cara sesuai syariat Islam, menggunakan peralatan, fasilitas produksi, sistem pengemasan, penyimpanan, dan distribusi yang tidak terkontaminasi dengan Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="m" id="4a1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="tm" id="4a1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="tr" id="4a1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a1" type="text" class="form-control" placeholder="Catatan" id="4a1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Produk selama persiapan, pemrosesan, pengemasan, penyimpanan, dan pengangkutannya dijamin terpisahkan secara fisik dari Produk atau materi lain yang tidak halal sesuai dengan syariat Islam</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="m" id="4a2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="tm" id="4a2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="tr" id="4a2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a2" type="text" class="form-control" placeholder="Catatan" id="4a2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                3. Produk tidak dapat disertifikasi apabila :
                                                                &nbsp;&nbsp;&nbsp;&nbsp;a.	Nama Produk yang mengandung nama minuman keras
                                                                &nbsp;&nbsp;&nbsp;&nbsp;b.	Nama Produk yang mengandung nama babi dan anjing serta turunannya, 
                                                                &nbsp;&nbsp;&nbsp;&nbsp;c.	Nama Produk yang mengandung nama setan
                                                                &nbsp;&nbsp;&nbsp;&nbsp;d.	Nama Produk yang mengarah kepada hal-hal yang menimbulkan kekufuran dan kebatilan
                                                                &nbsp;&nbsp;&nbsp;&nbsp;e.	Nama Produk yang mengandung kata-kata yang berkonotasi erotis, vulgar dan/atau porno
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3" value="m" id="4a3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3" value="tm" id="4a3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3" value="tr" id="4a3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3" type="text" class="form-control" placeholder="Catatan" id="4a3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Sertifikasi halal tidak dapat dilakukan apabila Produk dengan bentuk Produk hewan babi dan anjing. Bentuk Produk atau label kemasan yang sifatnya erotis, vulgar dan/atau porno</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="m" id="4a4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="tm" id="4a4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="tr" id="4a4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a4" type="text" class="form-control" placeholder="Catatan" id="4a4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Sertifikasi halal tidak dapat dilakukan apabila terhadap karakteristik/profil sensori Produk yang memiliki kecenderungan bau atau rasa yang mengarah kepada Produk haram atau yang telah dinyatakan haram berdasarkan ketetapan fatwa</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="m" id="4a5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="tm" id="4a5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="tr" id="4a5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a5" type="text" class="form-control" placeholder="Catatan" id="4a5ca"/>
                                                            </td>                                                                                 
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Produk atau Bahan yang dihasilkan aman untuk dikonsumsi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="m" id="4a6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="tm" id="4a6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="tr" id="4a6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a6" type="text" class="form-control" placeholder="Catatan" id="4a6ca"/>
                                                            </td>                                                                                                
                                                        </tr>                                                                                                                                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center">b</td>
                                                            <td class="valign-middle font-weight-bold">Pengemasan dan Pelabelan</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Bahan pengemas yang digunakan tidak terbuat atau mengandung Bahan yang tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="m" id="4b1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="tm" id="4b1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="tr" id="4b1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b1" type="text" class="form-control" placeholder="Catatan" id="4b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Kemasan produk halal sesuai dengan isinya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="m" id="4b2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="tm" id="4b2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="tr" id="4b2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b2" type="text" class="form-control" placeholder="Catatan" id="4b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Produk karkas dengan menggunakan kemasan yang bersih, sehat, tidak berbau, tidak mempengaruhi kualitas dan keamanan daging</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="m" id="4b3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="tm" id="4b3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="tr" id="4b3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b3" type="text" class="form-control" placeholder="Catatan" id="4b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Desain kemasan, tanda, symbol, logo, nama, dan gambaryang digunakan tidak menyesatkan dan melanggar syariat Islam</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="m" id="4b4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="tm" id="4b4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="tr" id="4b4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b4" type="text" class="form-control" placeholder="Catatan" id="4b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Label Halal dicantumkan di produk yang sudah disertifikasi halal pada kemasan produk, bagian dan tempat tertentu pada produk.</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="m" id="4b5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="tm" id="4b5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="tr" id="4b5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b5" type="text" class="form-control" placeholder="Catatan" id="4b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Label halal dicantumkan ditempat yang mudah dibaca, tidak mudah dihapus, dilepas, dan dirusak</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="m" id="4b6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="tm" id="4b6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="tr" id="4b6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b6" type="text" class="form-control" placeholder="Catatan" id="4b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Label halal yang dicantumkan sesuai dengan ketentuan yang ditetapkan BPJPH</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="m" id="4b7m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="tm" id="4b7tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="tr" id="4b7tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b7" type="text" class="form-control" placeholder="Catatan" id="4b7ca"/>
                                                            </td>                                                                                                
                                                        </tr>                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle font-weight-bold">Identifikasi dan Mampu Telusur</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                1.	Produk yang disimpan teridentifikasi seperti tanggal masuk, lokasi penyimpanan, kode tempat penyimpanan, bar code, tanggal produksi,dan lainnya.
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="m" id="4c1m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="tm" id="4c1tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="tr" id="4c1tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c1" type="text" class="form-control" placeholder="Catatan" id="4c1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Ketertelusuran kehalalan produk sudah terjamin</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="m" id="4c2m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="tm" id="4c2tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="tr" id="4c2tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c2" type="text" class="form-control" placeholder="Catatan" id="4c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Prosedur terdokumentasi dimiliki dan diimplementasikan untuk menjamin ketertelusuran kehalalan Produk yang disertifikasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="m" id="4c3m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="tm" id="4c3tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="tr" id="4c3tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c3" type="text" class="form-control" placeholder="Catatan" id="4c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Bahan dengan kode yang sama mempunyai status halal yang sama bila menerapkan pengkodean Bahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="m" id="4c4m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="tm" id="4c4tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="tr" id="4c4tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c4" type="text" class="form-control" placeholder="Catatan" id="4c4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5.	Ketertelusuran informasi asal Bahan dijamin pada setiap kegiatan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="m" id="4c5m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="tm" id="4c5tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="tr" id="4c5tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c5" type="text" class="form-control" placeholder="Catatan" id="4c5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Tidak ada perubahan informasi Bahan (nama Produk, nama produsen, nama Bahan, negara produsen, dan Label Halal) pada saat melakukan pengemasan ulang</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c6" value="m" id="4c6m"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c6" value="tm" id="4c6tm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c6" value="tr" id="4c6tr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c6" type="text" class="form-control" placeholder="Catatan" id="4c6ca"/>
                                                            </td>                                                                                                
                                                        </tr> 
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset4">
                                                            </td>                                                                                                
                                                        </tr>                                                                                                               
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="card-tab-55">
                                            <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                                <thead>
                                                    <tr>                                                            
                                                        <td colspan="6" class="valign-middle font-weight-bold">
                                                            Keterangan:
                                                            <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                            <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).
                                                            <br>iii.	TR (Tidak Relevan): Pertanyaan tidak relevan atau tidak berlaku dengan kondisi perusahaan
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="2%" class="  valign-middle text-center">No</th>
                                                        <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                                        <th width="3%" class="  valign-middle text-center">M</th>                                                
                                                        <th width="3%" class="  valign-middle text-center">TM</th>
                                                        <th width="3%" class="  valign-middle text-center">TR</th>
                                                        <th width="30%" class="  valign-middle text-center">Catatan Auditor/ Perbaikan  Dokumen</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                        <tr>
                                                            <td class="valign-middle text-center">5</td>
                                                            <td colspan="5" class="valign-middle font-weight-bold">Pemantauan dan Evaluasi</td>
                                                        </tr>                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center">a</td>
                                                            <td class="valign-middle">Audit internal dilakukan setiap enam bulan untuk memantau penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="m" id="5am"/>                                  
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="tm" id="5atm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="tr" id="5atr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5a" type="text" class="form-control" placeholder="Catatan" id="5aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">b</td>
                                                            <td class="valign-middle">Kaji ulang manajemen dilakukan untuk mengevaluasi penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="m" id="5bm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="tm" id="5btm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="tr" id="5btr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5b" type="text" class="form-control" placeholder="Catatan" id="5bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle">
                                                                Prosedur audit internal dimiliki dan kaji ulang manajemen diimplementasikan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="m" id="5cm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="tm" id="5ctm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="tr" id="5ctr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5c" type="text" class="form-control" placeholder="Catatan" id="5cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">d</td>
                                                            <td class="valign-middle">Bukti pelaksanaan audit internal dan kaji ulang manajemen harus didokumentasikan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="m" id="5dm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="tm" id="5dtm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="tr" id="5dtr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5d" type="text" class="form-control" placeholder="Catatan" id="5dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">e</td>
                                                            <td class="valign-middle">Hasil audit internal dan kaji ulang manajemen dilaporkan sesuai ketentuan dari Badan Penyelenggara Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="m" id="5em"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="tm" id="5etm"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="tr" id="5etr"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5e" type="text" class="form-control" placeholder="Catatan" id="5eca"/>
                                                            </td>                                                                                 
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset5">
                                                            </td>                                                                                                
                                                        </tr>                                                                                                               
                                                </tbody>
                                            </table>
                                            
                                            <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    @component('components.inputtextarea',['name'=> 'kesimpulan','label' => 'Kesimpulan','required'=>true,'placeholder'=>'Kesimpulan'])@endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group row">   
                                                <div class="col-md-12 offset-md-5 mb-5">
                                                    <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                                    <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>                                
                            </form>
                        </div> 
                        <div class="tab-pane fade" id="card-tab-7">
                            <form action="{{route('downloadlaporanauditsjph')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Laporan Audit Tahap 2</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('downloadlaporanaudittahap2fix2')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        {{-- @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent --}}
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_registrasi','label' => 'No Registrasi BPJPH','required'=>true,'placeholder'=>'No Registrasi BPJPH'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'merk_dagang','label' => 'Nama Merk Dagang','required'=>true,'placeholder'=>'Nama Merk Dagang'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'alamat_perusahaan','label' => 'Alamat Perusahaan','required'=>true,'value'=>$value->alamat,'placeholder'=>'Alamat Perusahaan'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tanggal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_auditor1','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor 1 (Ketua Auditor)'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_auditor2','label' => '','required'=>true,'placeholder'=>'Nama Auditor 2 (Auditor)'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_auditor3','label' => '','required'=>true,'placeholder'=>'Nama Auditor 3 (Auditor)'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'auditee','label' => 'Nama Auditee','required'=>true,'placeholder'=>'Nama Auditee','value'=>$value->nama_pemilik])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'status_sertifikasi','label' => 'Status Sertifikasi','required'=>true,'placeholder'=>'Status Sertifikasi','value'=>$value->status_registrasi,'readonly'=>true])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'penyelia_halal','label' => 'Penyelia Halal','required'=>true,'placeholder'=>'Penyelia Halal'])@endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>I. DATA FASILITAS PRODUKSI</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Fasilitas Produksi</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_fasilitas_produksi_fix[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Fasilitas</label><div class="col-lg-8"><div><input class="form-control" name="nama_fasilitas[]" type="text" label="Nama Fasilitas" placeholder="Nama Fasilitas"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" name="alamat_fasilitas[]" label="Alamat Fasilitas" placeholder="Alamat Fasilitas"></textarea></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Kota</label><div class="col-lg-8"><div><input class="form-control" name="kota_fasilitas[]" type="text" label="Kota Fasilitas" placeholder="Kota"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Negara</label><div class="col-lg-8"><div><input class="form-control" name="negara_fasilitas[]" type="text" label="Negara Fasilitas" placeholder="Negara"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan8" id="detail_kegiatan8" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan8" class="tam_detail_kegiatan8 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>II. DATA PRODUK</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Data Produk</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_data_produk[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Produk</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Rincian Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="rincian_jenis_produk[]" type="text" label="Rincian Jenis Produk" placeholder="Rincian Jenis Produk"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Pabrik</label><div class="col-lg-8"><div><input class="form-control" name="nama_pabrik[]" type="text" label="Nama Pabrik" placeholder="Nama Pabrik"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Status</label><div class="col-lg-8"><div><input class="form-control" name="status[]" type="text" label="Status" placeholder="Status"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan9" id="detail_kegiatan9" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan9" class="tam_detail_kegiatan9 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>III. DATA BAHAN</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Data Bahan</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_data_bahan[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Status</label>
                                                        <div class="col-lg-8"><div>
                                                                <div style="margin-bottom:7px;">
                                                                    <div class="radio radio-css radio-inline">
                                                                        <input type="radio" name="rbsesuai1" value="sesuai" id="sesuai1" checked/> 
                                                                        <label for="sesuai1">Sesuai</label>
                                                                    </div>                                                                                                                                
                                                                    <div class="radio radio-css radio-inline">
                                                                        <input type="radio" name="rbsesuai1" value="tidak sesuai" id="tidak_sesuai1"/>
                                                                        <label for="tidak_sesuai1">Tidak Sesuai</label>
                                                                    </div>
                                                                </div>
                                                        </div></div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nomor Sertifikat</label><div class="col-lg-8"><div><input class="form-control" name="nomor_sertifikat[]" type="text" label="Nomor Sertifikat" placeholder="Nomor Sertifikat"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Produsen</label><div class="col-lg-8"><div><input class="form-control" name="produsen[]" type="text" label="Produsen" placeholder="Produsen"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Masa Berlaku</label><div class="col-lg-8"><div><input class="form-control" name="masa_berlaku[]" type="text" label="Masa Berlaku" placeholder="Masa Berlaku"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Catatan" placeholder="Catatan"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>           
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan10" id="detail_kegiatan10" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan10" class="tam_detail_kegiatan10 btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                    <thead>
                                        <tr>                                                            
                                            <td colspan="6" class="valign-middle font-weight-bold">
                                                IV. KRITERIA SISTEM JAMINAN PRODUK HALAL<br>
                                                <br>Keterangan:
                                                <br>i.	M (Memenuhi): Penilaian dari Auditor menunjukkan implementasi SJPH pada komponen tersebut telah memenuhi.
                                                <br>ii.	TM (Tidak Memenuhi) : Penilaian dari Auditor menunjukan implementasi SJPH pada komponen tersebut tidak memenuhi (terdapat kelemahan).                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="2%" class="  valign-middle text-center">No</th>
                                            <th width="50%" class=" valign-middle text-center">Kriteria SJPH</th>
                                            <th width="3%" class="  valign-middle text-center">M</th>                                                
                                            <th width="3%" class="  valign-middle text-center">TM</th>                                            
                                            <th width="30%" class="  valign-middle text-center">Keterangan</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody>                                                    
                                            <tr>
                                                <td class="valign-middle text-center">A</td>
                                                <td colspan="5" class="valign-middle font-weight-bold">Komitmen dan Tanggung Jawab</td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">1</td>
                                                <td class="valign-middle">Kebijakan Halal</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkebijakanhalal" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkebijakanhalal" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cakebijakanhalal" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">2</td>
                                                <td class="valign-middle">Tim Manajemen Halal</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbtimmanajemenhalal" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbtimmanajemenhalal" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="catimmanajemenhalal" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">3</td>
                                                <td class="valign-middle">Pelatihan dan Edukasi</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpelatihanedukasi" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpelatihanedukasi" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="capelatihanedukasi" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">B</td>
                                                <td colspan="5" class="valign-middle font-weight-bold">Bahan</td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">4</td>
                                                <td class="valign-middle">Bahan</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbahan" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbahan" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cabahan" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">C</td>
                                                <td colspan="5" class="valign-middle font-weight-bold">Proses Produk Halal</td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">5</td>
                                                <td class="valign-middle">Fasilitas Produksi</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbfasilitasproduksi" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbfasilitasproduksi" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cafasilitasproduksi" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">6</td>
                                                <td class="valign-middle">Prosedur Tertulis Aktifitas Kritis</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbprosedurtertulis" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbprosedurtertulis" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="caprosedurtertulis" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">7</td>
                                                <td class="valign-middle">Penanganan Produk Tidak Sesuai Kriteria</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpenangananproduk" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpenangananproduk" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="capenangananproduk" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">D</td>
                                                <td colspan="5" class="valign-middle font-weight-bold">Produk</td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">8</td>
                                                <td class="valign-middle">Produk</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbproduk" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbproduk" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="caproduk" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">9</td>
                                                <td class="valign-middle">Kemampuan Telusur</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkemampuantelusur" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkemampuantelusur" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cakemampuantelusur" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">E</td>
                                                <td colspan="5" class="valign-middle font-weight-bold">Pemantauan dan Evaluasi</td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">10</td>
                                                <td class="valign-middle">Audit Internal</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbauditinternal" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbauditinternal" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="caauditinternal" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">11</td>
                                                <td class="valign-middle">Kaji Ulang Manajemen</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkajiulang" value="memenuhi"/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkajiulang" value="tidak memenuhi"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cakajiulang" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>                                                
                                                <td colspan="2" class="valign-middle">Kesimpulan</td>                                                
                                                <td class="valign-middle" colspan="3">
                                                    <input name="kesimpulan" type="text" class="form-control" placeholder="Kesimpulan"/>
                                                </td>                                                                                                
                                            </tr>
                                            {{-- <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                <td class="valign-middle" colspan="4">
                                                    <input type="button" value="Reset Semua Data" class="btn btn-sm btn-primary" id="btn_reset5">
                                                </td>                                                                                                
                                            </tr>--}}
                                    </tbody>
                                </table>                                
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>                       
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->                            
                
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
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script>
        var detailkegiatan = document.getElementById('detail_kegiatan');
        var detailkegiatan2 = document.getElementById('detail_kegiatan2');
        var detailkegiatan3 = document.getElementById('detail_kegiatan3');
        var detailkegiatan4 = document.getElementById('detail_kegiatan4');
        var detailkegiatan5 = document.getElementById('detail_kegiatan5');
        var detailkegiatan6 = document.getElementById('detail_kegiatan6');
        var detailkegiatan7 = document.getElementById('detail_kegiatan7');
        var detailkegiatan8 = document.getElementById('detail_kegiatan8');
        var detailkegiatan9 = document.getElementById('detail_kegiatan9');
        var detailkegiatan10 = document.getElementById('detail_kegiatan10');
        detailkegiatan.style.display = 'none';
        detailkegiatan2.style.display = 'none';
        detailkegiatan3.style.display = 'none';
        detailkegiatan4.style.display = 'none';
        detailkegiatan5.style.display = 'none';
        detailkegiatan6.style.display = 'none';
        detailkegiatan7.style.display = 'none';
        detailkegiatan8.style.display = 'none';
        detailkegiatan9.style.display = 'none';
        detailkegiatan10.style.display = 'none';

        var jmlKegiatan = 0;
        var jmlKegiatan2 = 0;
        var jmlKegiatan3 = 0;
        var jmlKegiatan4 = 0;
        var jmlKegiatan5 = 0;
        var jmlKegiatan6 = 0;
        var jmlKegiatan7 = 0;
        var jmlKegiatan8 = 0;
        var jmlKegiatan9 = 0;
        var jmlKegiatan10 = 0;
        var noKegiatan = 1;
        var noKegiatan2 = 1;
        var noKegiatan3 = 1;
        var noKegiatan4 = 1;
        var noKegiatan5 = 1;
        var noKegiatan6 = 1;
        var noKegiatan7 = 1;
        var noKegiatan8 = 1;
        var noKegiatan9 = 1;
        var noKegiatan10 = 1;

        $('#btn_reset').on('click', function () {
            // alert("dsn");
            document.getElementById("1a1m").checked = false;
            document.getElementById("1a1tm").checked = false;
            document.getElementById("1a1tr").checked = false;
            document.getElementById("1a1ca").value = "";

            document.getElementById("1a2m").checked = false;
            document.getElementById("1a2tm").checked = false;
            document.getElementById("1a2tr").checked = false;
            document.getElementById("1a2ca").value = "";

            document.getElementById("1a3m").checked = false;
            document.getElementById("1a3tm").checked = false;
            document.getElementById("1a3tr").checked = false;
            document.getElementById("1a3ca").value = "";

            document.getElementById("1a4m").checked = false;
            document.getElementById("1a4tm").checked = false;
            document.getElementById("1a4tr").checked = false;
            document.getElementById("1a4ca").value = "";

            document.getElementById("1b1m").checked = false;
            document.getElementById("1b1tm").checked = false;
            document.getElementById("1b1tr").checked = false;
            document.getElementById("1b1ca").value = "";

            document.getElementById("1b2m").checked = false;
            document.getElementById("1b2tm").checked = false;
            document.getElementById("1b2tr").checked = false;
            document.getElementById("1b2ca").value = "";

            document.getElementById("1b3m").checked = false;
            document.getElementById("1b3tm").checked = false;
            document.getElementById("1b3tr").checked = false;
            document.getElementById("1b3ca").value = "";

            document.getElementById("1b4m").checked = false;
            document.getElementById("1b4tm").checked = false;
            document.getElementById("1b4tr").checked = false;
            document.getElementById("1b4ca").value = "";

            document.getElementById("1b5m").checked = false;
            document.getElementById("1b5tm").checked = false;
            document.getElementById("1b5tr").checked = false;
            document.getElementById("1b5ca").value = "";

            document.getElementById("1b6m").checked = false;
            document.getElementById("1b6tm").checked = false;
            document.getElementById("1b6tr").checked = false;
            document.getElementById("1b6ca").value = "";

            document.getElementById("1c1m").checked = false;
            document.getElementById("1c1tm").checked = false;
            document.getElementById("1c1tr").checked = false;
            document.getElementById("1c1ca").value = "";

            document.getElementById("1c2m").checked = false;
            document.getElementById("1c2tm").checked = false;
            document.getElementById("1c2tr").checked = false;
            document.getElementById("1c2ca").value = "";

            document.getElementById("1c3m").checked = false;
            document.getElementById("1c3tm").checked = false;
            document.getElementById("1c3tr").checked = false;
            document.getElementById("1c3ca").value = "";

            document.getElementById("1c4m").checked = false;
            document.getElementById("1c4tm").checked = false;
            document.getElementById("1c4tr").checked = false;
            document.getElementById("1c4ca").value = "";
        });

        $('#btn_reset2').on('click', function () {
            document.getElementById("21m").checked = false;
            document.getElementById("21tm").checked = false;
            document.getElementById("21tr").checked = false;
            document.getElementById("21ca").value = "";

            document.getElementById("22m").checked = false;
            document.getElementById("22tm").checked = false;
            document.getElementById("22tr").checked = false;
            document.getElementById("22ca").value = "";

            document.getElementById("23m").checked = false;
            document.getElementById("23tm").checked = false;
            document.getElementById("23tr").checked = false;
            document.getElementById("23ca").value = "";

            document.getElementById("24m").checked = false;
            document.getElementById("24tm").checked = false;
            document.getElementById("24tr").checked = false;
            document.getElementById("24ca").value = "";

            document.getElementById("25m").checked = false;
            document.getElementById("25tm").checked = false;
            document.getElementById("25tr").checked = false;
            document.getElementById("25ca").value = "";
        });

        $('#btn_reset3').on('click', function () {
            document.getElementById("3a1m").checked = false;            
            document.getElementById("3a1tm").checked = false;
            document.getElementById("3a1tr").checked = false;
            document.getElementById("3a1ca").value = "";

            document.getElementById("3a2m").checked = false;            
            document.getElementById("3a2tm").checked = false;
            document.getElementById("3a2tr").checked = false;
            document.getElementById("3a2ca").value = "";

            document.getElementById("3a3m").checked = false;            
            document.getElementById("3a3tm").checked = false;
            document.getElementById("3a3tr").checked = false;
            document.getElementById("3a3ca").value = "";

            document.getElementById("3a4m").checked = false;            
            document.getElementById("3a4tm").checked = false;
            document.getElementById("3a4tr").checked = false;
            document.getElementById("3a4ca").value = "";

            document.getElementById("3a5m").checked = false;            
            document.getElementById("3a5tm").checked = false;
            document.getElementById("3a5tr").checked = false;
            document.getElementById("3a5ca").value = "";

            document.getElementById("3a6m").checked = false;            
            document.getElementById("3a6tm").checked = false;
            document.getElementById("3a6tr").checked = false;
            document.getElementById("3a6ca").value = "";

            document.getElementById("3a7am").checked = false;            
            document.getElementById("3a7atm").checked = false;
            document.getElementById("3a7atr").checked = false;
            document.getElementById("3a7aca").value = "";

            document.getElementById("3a7bm").checked = false;            
            document.getElementById("3a7btm").checked = false;
            document.getElementById("3a7btr").checked = false;
            document.getElementById("3a7bca").value = "";

            document.getElementById("3a7cm").checked = false;            
            document.getElementById("3a7ctm").checked = false;
            document.getElementById("3a7ctr").checked = false;
            document.getElementById("3a7cca").value = "";

            document.getElementById("3a8m").checked = false;            
            document.getElementById("3a8tm").checked = false;
            document.getElementById("3a8tr").checked = false;
            document.getElementById("3a8ca").value = "";

            document.getElementById("3a9m").checked = false;            
            document.getElementById("3a9tm").checked = false;
            document.getElementById("3a9tr").checked = false;
            document.getElementById("3a9ca").value = "";

            document.getElementById("3a10m").checked = false;            
            document.getElementById("3a10tm").checked = false;
            document.getElementById("3a10tr").checked = false;
            document.getElementById("3a10ca").value = "";

            document.getElementById("3a11m").checked = false;            
            document.getElementById("3a11tm").checked = false;
            document.getElementById("3a11tr").checked = false;
            document.getElementById("3a11ca").value = "";

            document.getElementById("3a12m").checked = false;            
            document.getElementById("3a12tm").checked = false;
            document.getElementById("3a12tr").checked = false;
            document.getElementById("3a12ca").value = "";

            document.getElementById("3a13m").checked = false;            
            document.getElementById("3a13tm").checked = false;
            document.getElementById("3a13tr").checked = false;
            document.getElementById("3a13ca").value = "";

            document.getElementById("3a14m").checked = false;            
            document.getElementById("3a14tm").checked = false;
            document.getElementById("3a14tr").checked = false;
            document.getElementById("3a14ca").value = "";

            document.getElementById("3a15m").checked = false;            
            document.getElementById("3a15tm").checked = false;
            document.getElementById("3a15tr").checked = false;
            document.getElementById("3a15ca").value = "";

            document.getElementById("3a16m").checked = false;            
            document.getElementById("3a16tm").checked = false;
            document.getElementById("3a16tr").checked = false;
            document.getElementById("3a16ca").value = "";

            document.getElementById("3a17m").checked = false;            
            document.getElementById("3a17tm").checked = false;
            document.getElementById("3a17tr").checked = false;
            document.getElementById("3a17ca").value = "";

            document.getElementById("3a18m").checked = false;            
            document.getElementById("3a18tm").checked = false;
            document.getElementById("3a18tr").checked = false;
            document.getElementById("3a18ca").value = "";

            document.getElementById("3a19m").checked = false;            
            document.getElementById("3a19tm").checked = false;
            document.getElementById("3a19tr").checked = false;
            document.getElementById("3a19ca").value = "";

            document.getElementById("3b1m").checked = false;            
            document.getElementById("3b1tm").checked = false;
            document.getElementById("3b1tr").checked = false;
            document.getElementById("3b1ca").value = "";

            document.getElementById("3b2m").checked = false;            
            document.getElementById("3b2tm").checked = false;
            document.getElementById("3b2tr").checked = false;
            document.getElementById("3b2ca").value = "";

            document.getElementById("3b3m").checked = false;            
            document.getElementById("3b3tm").checked = false;
            document.getElementById("3b3tr").checked = false;
            document.getElementById("3b3ca").value = "";

            document.getElementById("3b4m").checked = false;            
            document.getElementById("3b4tm").checked = false;
            document.getElementById("3b4tr").checked = false;
            document.getElementById("3b4ca").value = "";

            document.getElementById("3b5m").checked = false;            
            document.getElementById("3b5tm").checked = false;
            document.getElementById("3b5tr").checked = false;
            document.getElementById("3b5ca").value = "";

            document.getElementById("3b6m").checked = false;            
            document.getElementById("3b6tm").checked = false;
            document.getElementById("3b6tr").checked = false;
            document.getElementById("3b6ca").value = "";

            document.getElementById("3b7m").checked = false;            
            document.getElementById("3b7tm").checked = false;
            document.getElementById("3b7tr").checked = false;
            document.getElementById("3b7ca").value = "";

            document.getElementById("3b8m").checked = false;            
            document.getElementById("3b8tm").checked = false;
            document.getElementById("3b8tr").checked = false;
            document.getElementById("3b8ca").value = "";

            document.getElementById("3b9m").checked = false;            
            document.getElementById("3b9tm").checked = false;
            document.getElementById("3b9tr").checked = false;
            document.getElementById("3b9ca").value = "";

            document.getElementById("3b10m").checked = false;            
            document.getElementById("3b10tm").checked = false;
            document.getElementById("3b10tr").checked = false;
            document.getElementById("3b10ca").value = "";

            document.getElementById("3b11m").checked = false;            
            document.getElementById("3b11tm").checked = false;
            document.getElementById("3b11tr").checked = false;
            document.getElementById("3b11ca").value = "";

            document.getElementById("3b12m").checked = false;            
            document.getElementById("3b12tm").checked = false;
            document.getElementById("3b12tr").checked = false;
            document.getElementById("3b12ca").value = "";

            document.getElementById("3b13m").checked = false;            
            document.getElementById("3b13tm").checked = false;
            document.getElementById("3b13tr").checked = false;
            document.getElementById("3b13ca").value = "";

            document.getElementById("3c1m").checked = false;
            document.getElementById("3c1tm").checked = false;
            document.getElementById("3c1tr").checked = false;
            document.getElementById("3c1ca").value = "";

            document.getElementById("3c2m").checked = false;
            document.getElementById("3c2tm").checked = false;
            document.getElementById("3c2tr").checked = false;
            document.getElementById("3c2ca").value = "";

            document.getElementById("3c3m").checked = false;
            document.getElementById("3c3tm").checked = false;
            document.getElementById("3c3tr").checked = false;
            document.getElementById("3c3ca").value = "";

            document.getElementById("3c4m").checked = false;
            document.getElementById("3c4tm").checked = false;
            document.getElementById("3c4tr").checked = false;
            document.getElementById("3c4ca").value = "";

            document.getElementById("3c5m").checked = false;
            document.getElementById("3c5tm").checked = false;
            document.getElementById("3c5tr").checked = false;
            document.getElementById("3c5ca").value = "";

            document.getElementById("3c6m").checked = false;
            document.getElementById("3c6tm").checked = false;
            document.getElementById("3c6tr").checked = false;
            document.getElementById("3c6ca").value = "";

            document.getElementById("3c7m").checked = false;
            document.getElementById("3c7tm").checked = false;
            document.getElementById("3c7tr").checked = false;
            document.getElementById("3c7ca").value = "";

            document.getElementById("3c8m").checked = false;
            document.getElementById("3c8tm").checked = false;
            document.getElementById("3c8tr").checked = false;
            document.getElementById("3c8ca").value = "";
            
            document.getElementById("3c9m").checked = false;
            document.getElementById("3c9tm").checked = false;
            document.getElementById("3c9tr").checked = false;
            document.getElementById("3c9ca").value = "";

            document.getElementById("3c10m").checked = false;
            document.getElementById("3c10tm").checked = false;
            document.getElementById("3c10tr").checked = false;
            document.getElementById("3c10ca").value = "";
        });

        $('#btn_reset4').on('click', function () {
            document.getElementById("4a1m").checked = false;
            document.getElementById("4a1tm").checked = false;
            document.getElementById("4a1tr").checked = false;
            document.getElementById("4a1ca").value = "";

            document.getElementById("4a2m").checked = false;
            document.getElementById("4a2tm").checked = false;
            document.getElementById("4a2tr").checked = false;
            document.getElementById("4a2ca").value = "";

            document.getElementById("4a3m").checked = false;
            document.getElementById("4a3tm").checked = false;
            document.getElementById("4a3tr").checked = false;
            document.getElementById("4a3ca").value = "";

            document.getElementById("4a4m").checked = false;
            document.getElementById("4a4tm").checked = false;
            document.getElementById("4a4tr").checked = false;
            document.getElementById("4a4ca").value = "";

            document.getElementById("4a5m").checked = false;
            document.getElementById("4a5tm").checked = false;
            document.getElementById("4a5tr").checked = false;
            document.getElementById("4a5ca").value = "";

            document.getElementById("4a6m").checked = false;
            document.getElementById("4a6tm").checked = false;
            document.getElementById("4a6tr").checked = false;
            document.getElementById("4a6ca").value = "";

            document.getElementById("4b1m").checked = false;
            document.getElementById("4b1tm").checked = false;
            document.getElementById("4b1tr").checked = false;
            document.getElementById("4b1ca").value = "";

            document.getElementById("4b2m").checked = false;
            document.getElementById("4b2tm").checked = false;
            document.getElementById("4b2tr").checked = false;
            document.getElementById("4b2ca").value = "";

            document.getElementById("4b3m").checked = false;
            document.getElementById("4b3tm").checked = false;
            document.getElementById("4b3tr").checked = false;
            document.getElementById("4b3ca").value = "";

            document.getElementById("4b4m").checked = false;
            document.getElementById("4b4tm").checked = false;
            document.getElementById("4b4tr").checked = false;
            document.getElementById("4b4ca").value = "";

            document.getElementById("4b5m").checked = false;
            document.getElementById("4b5tm").checked = false;
            document.getElementById("4b5tr").checked = false;
            document.getElementById("4b5ca").value = "";

            document.getElementById("4b6m").checked = false;
            document.getElementById("4b6tm").checked = false;
            document.getElementById("4b6tr").checked = false;
            document.getElementById("4b6ca").value = "";

            document.getElementById("4b7m").checked = false;
            document.getElementById("4b7tm").checked = false;
            document.getElementById("4b7tr").checked = false;
            document.getElementById("4b7ca").value = "";

            document.getElementById("4c1m").checked = false;
            document.getElementById("4c1tm").checked = false;
            document.getElementById("4c1tr").checked = false;
            document.getElementById("4c1ca").value = "";

            document.getElementById("4c2m").checked = false;
            document.getElementById("4c2tm").checked = false;
            document.getElementById("4c2tr").checked = false;
            document.getElementById("4c2ca").value = "";

            document.getElementById("4c3m").checked = false;
            document.getElementById("4c3tm").checked = false;
            document.getElementById("4c3tr").checked = false;
            document.getElementById("4c3ca").value = "";

            document.getElementById("4c4m").checked = false;
            document.getElementById("4c4tm").checked = false;
            document.getElementById("4c4tr").checked = false;
            document.getElementById("4c4ca").value = "";

            document.getElementById("4c5m").checked = false;
            document.getElementById("4c5tm").checked = false;
            document.getElementById("4c5tr").checked = false;
            document.getElementById("4c5ca").value = "";

            document.getElementById("4c6m").checked = false;
            document.getElementById("4c6tm").checked = false;
            document.getElementById("4c6tr").checked = false;
            document.getElementById("4c6ca").value = "";
        });

        $('#btn_reset5').on('click', function () {
            document.getElementById("5am").checked = false;
            document.getElementById("5atm").checked = false;
            document.getElementById("5atr").checked = false;
            document.getElementById("5aca").value = "";

            document.getElementById("5bm").checked = false;
            document.getElementById("5btm").checked = false;
            document.getElementById("5btr").checked = false;
            document.getElementById("5bca").value = "";

            document.getElementById("5cm").checked = false;
            document.getElementById("5ctm").checked = false;
            document.getElementById("5ctr").checked = false;
            document.getElementById("5cca").value = "";

            document.getElementById("5dm").checked = false;
            document.getElementById("5dtm").checked = false;
            document.getElementById("5dtr").checked = false;
            document.getElementById("5dca").value = "";

            document.getElementById("5em").checked = false;
            document.getElementById("5etm").checked = false;
            document.getElementById("5etr").checked = false;
            document.getElementById("5eca").value = "";
        });

        $('#tam_detail_kegiatan').on('click', function(){            
            detailkegiatan.style.display = 'block';
            noKegiatan += 1;
            addDataKegiatan();
        });

        $('#tam_detail_kegiatan2').on('click', function(){            
            detailkegiatan2.style.display = 'block';
            noKegiatan2 += 1;
            addDataKegiatan2();
        });

        $('#tam_detail_kegiatan3').on('click', function(){            
            detailkegiatan3.style.display = 'block';
            noKegiatan3 += 1;
            addDataKegiatan3();
        });

        $('#tam_detail_kegiatan4').on('click', function(){            
            detailkegiatan4.style.display = 'block';
            noKegiatan4 += 1;
            addDataKegiatan4();
        });

        $('#tam_detail_kegiatan5').on('click', function(){            
            detailkegiatan5.style.display = 'block';
            noKegiatan5 += 1;
            addDataKegiatan5();
        });

        $('#tam_detail_kegiatan6').on('click', function(){            
            detailkegiatan6.style.display = 'block';
            noKegiatan6 += 1;
            addDataKegiatan6();
        });

        $('#tam_detail_kegiatan7').on('click', function(){            
            detailkegiatan7.style.display = 'block';
            noKegiatan7 += 1;
            addDataKegiatan7();
        });

        $('#tam_detail_kegiatan8').on('click', function(){            
            detailkegiatan8.style.display = 'block';
            noKegiatan8 += 1;
            addDataKegiatan8();
        });

        $('#tam_detail_kegiatan9').on('click', function(){            
            detailkegiatan9.style.display = 'block';
            noKegiatan9 += 1;
            addDataKegiatan9();
        });

        $('#tam_detail_kegiatan10').on('click', function(){            
            detailkegiatan10.style.display = 'block';
            noKegiatan10 += 1;
            addDataKegiatan10();
        });

        function addDataKegiatan(){            
            jmlKegiatan+=1;            
            var data_kegiatan = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Data</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Kriteria</label><div class="col-lg-8"><div><input class="form-control" name="kriteria[]" type="text" label="Kriteria" placeholder="Kriteria"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Temuan/Catatan</label><div class="col-lg-8"><div><textarea name="temuan[]" class="form-control" placeholder="Temuan/Catatan"></textarea></div></div>                                </div></div>                                    </div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan').append(data_kegiatan);                                                
        }

        function addDataKegiatan2(){            
            jmlKegiatan2+=1;            
            var data_kegiatan2 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form">                                    <div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Data</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Bahan</label><div class="col-lg-8"><div><input class="form-control" name="bahan[]" type="text" label="Bahan" placeholder="Bahan"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Temuan</label><div class="col-lg-8"><div><textarea name="temuan[]" class="form-control" placeholder="Temuan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Kategori Bahan</label><div class="col-lg-8"><div><input class="form-control" name="kategori_bahan[]" type="text" label="Kategori Bahan" placeholder="Kategori Bahan"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Catatan" placeholder="Catatan"></div></div></div></div></div></div>                                    </div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain2" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan2').append(data_kegiatan2);
        }

        function addDataKegiatan3(){
            jmlKegiatan3+=1;            
            var data_kegiatan3 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Data</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Daftar Peralatan</label><div class="col-lg-8"><div><input class="form-control" name="daftar_peralatan[]" type="text" label="Daftar Peralatan" placeholder="Daftar Peralatan"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Bahan Peralatan Yang Digunakan</label><div class="col-lg-8"><div><input class="form-control" name="bahan_peralatan[]" type="text" label="Bahan Peralatan Yang Digunakan" placeholder="Kategori Bahan"></div></div></div></div></div></div></div><div class="col-lg-12"><div><a id="hapus_datakegiatanlain3" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan3').append(data_kegiatan3);
        }

        function addDataKegiatan4(){
            jmlKegiatan4+=1;
            // var data_kegiatan4 = 'a';
            var data_kegiatan4 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Daftar Produk Yang Disertifikasi (Industri Pengolahan)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Karakteristik Sensori</label><div class="col-lg-8"><div><input class="form-control" name="karakteristik_sensori[]" type="text" label="Karakteristik Sensori" placeholder="Karakteristik Sensori"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Bentuk</label><div class="col-lg-8"><div><input class="form-control" name="bentuk[]" type="text" label="Bentuk" placeholder="Bentuk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Penjualan (Retail/Non Retail)</label><div class="col-lg-8"><div><input class="form-control" name="penjualan[]" type="text" label="Penjualan" placeholder="Penjualan (Retail/Non Retail)"></div></div></div></div></div></div></div><div class="col-lg-12"><div><a id="hapus_datakegiatanlain4" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan4').append(data_kegiatan4);
        }

        function addDataKegiatan5(){
            jmlKegiatan5+=1;
            // var data_kegiatan5 = 'a';
            var data_kegiatan5 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_produk[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div></div></div></div></div></div><div class="col-lg-12"><div><a id="hapus_datakegiatanlain5" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan5').append(data_kegiatan5);
        }

        function addDataKegiatan6(){
            jmlKegiatan6+=1;
            // var data_kegiatan6 = 'a';
            var data_kegiatan6 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Daftar Produk Yang Disertifikasi (Restoran/Katering)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk2[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk2[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Karakteristik Sensori</label><div class="col-lg-8"><div><input class="form-control" name="karakteristik_sensori2[]" type="text" label="Karakteristik Sensori" placeholder="Karakteristik Sensori"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Bentuk</label><div class="col-lg-8"><div><input class="form-control" name="bentuk2[]" type="text" label="Bentuk" placeholder="Bentuk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Penjualan (Retail/Non Retail)</label><div class="col-lg-8"><div><input class="form-control" name="penjualan2[]" type="text" label="Penjualan" placeholder="Penjualan (Retail/Non Retail)"></div></div></div></div></div></div></div><div class="col-lg-12"><div><a id="hapus_datakegiatanlain6" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan6').append(data_kegiatan6);
        }

        function addDataKegiatan7(){
            jmlKegiatan7+=1;
            // var data_kegiatan7 = 'a';
            var data_kegiatan7 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_produk2[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto2[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain8" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan7').append(data_kegiatan7);
        }

        function addDataKegiatan8(){
            jmlKegiatan8+=1;
            var data_kegiatan8 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Fasilitas Produksi</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_fasilitas_produksi_fix[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Fasilitas</label><div class="col-lg-8"><div><input class="form-control" name="nama_fasilitas[]" type="text" label="Nama Fasilitas" placeholder="Nama Fasilitas"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" name="alamat_fasilitas[]" label="Alamat Fasilitas" placeholder="Alamat Fasilitas"></textarea></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Kota</label><div class="col-lg-8"><div><input class="form-control" name="kota_fasilitas[]" type="text" label="Kota Fasilitas" placeholder="Kota"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Negara</label><div class="col-lg-8"><div><input class="form-control" name="negara_fasilitas[]" type="text" label="Negara Fasilitas" placeholder="Negara"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain8" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> <br></div>';
            // var data_kegiatan8 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_produk2[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto2[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain7" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan8').append(data_kegiatan8);
        }

        function addDataKegiatan9(){
            jmlKegiatan9+=1;
            var data_kegiatan9 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Data Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_data_produk[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Produk</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk" placeholder="Nama Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Rincian Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="rincian_jenis_produk[]" type="text" label="Rincian Jenis Produk" placeholder="Rincian Jenis Produk"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Pabrik</label><div class="col-lg-8"><div><input class="form-control" name="nama_pabrik[]" type="text" label="Nama Pabrik" placeholder="Nama Pabrik"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Status</label><div class="col-lg-8"><div><input class="form-control" name="status[]" type="text" label="Status" placeholder="Status"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain9" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> <br></div>';
            // var data_kegiatan8 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_produk2[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto2[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain7" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan9').append(data_kegiatan9);
        }

        function addDataKegiatan10(){
            jmlKegiatan10+=1;
            var data_kegiatan10 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Data Bahan</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_data_bahan[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Status</label><div class="col-lg-8"><div><div style="margin-bottom:7px;"><div class="radio radio-css radio-inline"><input type="radio" name="rbsesuai'+(jmlKegiatan10+1)+'" value="sesuai" id="sesuai'+(jmlKegiatan10+1)+'" checked/><label for="sesuai'+(jmlKegiatan10+1)+'">Sesuai</label></div><div class="radio radio-css radio-inline"><input type="radio" name="rbsesuai'+(jmlKegiatan10+1)+'" value="tidak sesuai" id="tidak_sesuai'+(jmlKegiatan10+1)+'"/><label for="tidak_sesuai'+(jmlKegiatan10+1)+'">Tidak Sesuai</label></div></div></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nomor Sertifikat</label><div class="col-lg-8"><div><input class="form-control" name="nomor_sertifikat[]" type="text" label="Nomor Sertifikat" placeholder="Nomor Sertifikat"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Produsen</label><div class="col-lg-8"><div><input class="form-control" name="produsen[]" type="text" label="Produsen" placeholder="Produsen"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Masa Berlaku</label><div class="col-lg-8"><div><input class="form-control" name="masa_berlaku[]" type="text" label="Masa Berlaku" placeholder="Masa Berlaku"></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Catatan" placeholder="Catatan"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain10" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> <br></div>';
            // var data_kegiatan8 = '<div style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-12 col-form-label"><b>Foto Produk Yang Disertifikasi (Beserta dengan kemasan primernya)</b></label></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_produk2[]"></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Keterangan Foto</label><div class="col-lg-8"><div><input class="form-control" name="keterangan_foto2[]" type="text" label="Keterangan Foto" placeholder="Keterangan Foto"></div></div></div></div></div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain7" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan10').append(data_kegiatan10);
        }

        $(document).on('click','#hapus_datakegiatanlain', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan-=1;
            noKegiatan-=1;            

            if(jmlKegiatan == 0){
                detailkegiatan.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain2', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan2-=1;
            noKegiatan2-=1;            

            if(jmlKegiatan2 == 0){
                detailkegiatan2.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain3', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan3-=1;
            noKegiatan3-=1;            

            if(jmlKegiatan3 == 0){
                detailkegiatan3.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain4', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan4-=1;
            noKegiatan4-=1;

            if(jmlKegiatan4 == 0){
                detailkegiatan4.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain5', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan5-=1;
            noKegiatan5-=1;

            if(jmlKegiatan5 == 0){
                detailkegiatan5.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain6', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan6-=1;
            noKegiatan6-=1;

            if(jmlKegiatan6 == 0){
                detailkegiatan6.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain7', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan7-=1;
            noKegiatan7-=1;

            if(jmlKegiatan7 == 0){
                detailkegiatan7.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain8', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan8-=1;
            noKegiatan8-=1;

            if(jmlKegiatan8 == 0){
                detailkegiatan8.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain9', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan9-=1;
            noKegiatan9-=1;

            if(jmlKegiatan9 == 0){
                detailkegiatan9.style.display = 'none';
            }
        });

        $(document).on('click','#hapus_datakegiatanlain10', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan10-=1;
            noKegiatan10-=1;

            if(jmlKegiatan10 == 0){
                detailkegiatan10.style.display = 'none';
            }
        });

        $('#tgl_audit').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
    </script>
@endpush