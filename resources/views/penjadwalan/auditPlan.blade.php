@extends('layouts.default')

@section('title', 'Tambah Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />    
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Penjadwalan</a></li>        
        <li class="breadcrumb-item active">Audit Plan</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Audit Plan<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Audit Plan</h4>
                    <div class="panel-heading-btn">
                        {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> --}}
                    </div>
                </div>
                <div class="card-header tab-overflow p-t-0 p-b-0">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item text-center">
                            <a class="nav-link active" data-toggle="tab" href="#card-tab-1">Dokumen Manual</a>
                        </li>                    
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-2">Isi Form Dokumen</a>
                        </li>                                            
                    </ul>
                </div>
                <div class="card-body table-responsive-lg ">
					<div class="tab-content p-0 m-0">
                        <div class="tab-pane fade active show" id="card-tab-1">
                            <span class="text-danger">Silahkan refresh jika data form rencana audit belum ada</span>
                            @foreach($dataPenjadwalan as $index => $value2)                                
                                    <div class="panel-body panel-form">
                                        <div class="wrapper col-lg-12">
                                            <div class="row">                                                
                                                <table class="table table-lg"> 							
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Jenis Berkas</th>
                                                        <th class="text-center">Download</th>
                                                        <th class="text-center">Download</th>
                                                        <th class="text-center">Upload</th>
                                                        <th class="text-center">Berkas</th>
                                                        <th class="text-center">Tanggal Upload</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">Rencana Audit</td>
                                                        <td class="text-center">
                                                            <form action="{{route('downloadauditplan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="wrapper col-lg-12" style="display: none">
                                                                    @foreach($dataRegistrasi as $index => $value)
                                                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                        
                                                                    @endforeach                        
                                                                </div>                                                                                                                                
                                                                <button type="submit" class="btn btn-sm btn-info">Format Rencana Audit</button>
                                                            </form>                                                            
                                                        </td>     
                                                        <td class="text-center">                                                            
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                @if(isset($val['rencana_audit_isian']))
                                                                    @if ($val['rencana_audit_isian'])
                                                                        <a class="btn btn-sm btn-info" href="{{url('') .Storage::url('public/laporan/upload/AP/Isian/'.$val['rencana_audit_isian']) }}" download>Rencana Audit Isian</a>
                                                                    @else		
                                                                    -																
                                                                    @endif		
                                                                @endif																	
                                                                @endforeach									
                                                            @endif
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalAuditPlan' style="cursor:pointer">Upload Disini</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_rencana_audit'])
                                                                        <a href="{{url('') .Storage::url('public/laporan/upload/AP/'.$val['file_rencana_audit']) }}" download>{{$val['file_rencana_audit']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_rencana_audit'] == null? "-" : $val['tgl_penyerahan_rencana_audit']}}
                                                            @endforeach
                                                        </td>
                                                    </tr>                                                    
                                                    </table>                                                
                                            </div>
                                        </div>
                                    </div>                                
                            @endforeach
                            {{-- <form action="{{route('uploadauditplan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12" style="display:none">
                                        @foreach($dataRegistrasi as $index => $value)
                                            @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                            @foreach($dataPenjadwalan as $index => $value2)
                                                @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @endforeach
                                        @endforeach
                                    </div>    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label"><b>Unggah Berkas Audit Plan</b></label>
                                            <div id="shb" class="col-lg-8">
                                                <div class="input-group date">
                                                    <input type="file" name="file_audit_plan" class="form-control">                                            
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">   
                                    <div class="col-md-12 offset-md-5 mb-5">
                                        <button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-info">Unggah</button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                        <div class="tab-pane fade" id="card-tab-2">
                            <form action="{{route('downloadauditplanfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none"> 
                                    @foreach($dataRegistrasi as $index => $value)
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'jenis_audit','label' => 'Jenis Audit','required'=>true,'placeholder'=>'Jenis Audit','readonly'=>true,'value'=>$value->status_registrasi])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                {{-- @component('components.inputtext',['name'=> 'alamat_perusahaan','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat_kantor])@endcomponent --}}
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @foreach($dataPenjadwalan as $index => $value2)
                                                    @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                                    {{-- @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit1." s/d ".$value2->selesai_audit2])@endcomponent --}}
                                                @endforeach
                                            </div>
                                        </div>                            
                                    @endforeach                                
                                </div>
                                <div class="panel-body panel-form">
                                    @foreach($dataRegistrasi as $index => $value)
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_id_bpjph','label' => 'No ID BPJPH','required'=>true,'placeholder'=>'No ID BPJPH','readonly'=>true,'value'=>$value->no_registrasi_bpjph])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @foreach($dataPenjadwalan as $index => $valueP)
                                            @php
                                                $mulai = explode("-",$valueP->mulai_audit2);                                                
                                                $tahun = $mulai[0];
                                                $bulan = $mulai[1];
                                                $tanggal = $mulai[2];
                                                $tgl = $tanggal.'-'.$bulan.'-'.$tahun;
                                            @endphp
                                            <label class="col-lg-4 col-form-label">Tanggal Audit</label>
                                            <div id="shb" class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" name="tanggal_audit" class="form-control" placeholder="Tanggal Mulai" data-date-start-date="Date.default" value='{{$tgl}}' readonly/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div id="shb" class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="tanggal_audit_" name="tanggal_audit_" class="form-control" placeholder="Tanggal Akhir" value="" data-date-start-date="Date.default" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">                               
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Skema Audit</label>
                                            <div id="shb" class="col-lg-8">
                                                <div class="input-group date">           
                                                    <div class="radio radio-css radio-inline">                                         
                                                        <input type="radio" name="skema_audit" value="sjh" id="sjh"/>
                                                        <label for="sjh">SJH</label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline">                                         
                                                        <input type="radio" name="skema_audit" value="sjph" id="sjph" checked/>
                                                        <label for="sjph">SJPH</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                                                                    
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'status_sertifikasi','label' => 'Status Sertifikasi','required'=>true,'placeholder'=>'Status Sertifikasi','readonly'=>true,'value'=>$value->status_registrasi])@endcomponent                                            
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_audit','label' => 'No Audit','required'=>true,'placeholder'=>'No Audit','readonly'=>true,'value'=>$value->no_registrasi])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_organisasi','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'alamat','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat_perusahaan])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Tujuan Audit</label>
                                            <div class="col-lg-8">
                                                <select id="tujuan_audit" name="tujuan_audit" class="form-control" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="Memastikan Bahwa SJPH Sudah Diterapkan Dengan Baik Oleh Pelaku Usaha">
                                                        Memastikan Bahwa SJPH Sudah Diterapkan Dengan Baik Oleh Pelaku Usaha
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'lingkup_audit','label' => 'Lingkup Audit','required'=>true,'placeholder'=>'Lingkup Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtextarea',['name'=> 'jenis_produk','label' => 'Jenis Produk & Kode Klasifikasi','required'=>true,'placeholder'=>'Jenis Produk & Kode Klasifikasi','readonly'=>true,'value'=>$value->rincian_jenis_produk])@endcomponent
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
                                    @foreach($dataPenjadwalan as $index => $value2)
                                        @php                                        
                                            $ketua_arr = explode("_",$value2->pelaksana1_audit2);
                                            $ketua = $ketua_arr[1];
                                            if(isset($value2->pelaksana2_audit2)){
                                                $anggota_arr = explode("_",$value2->pelaksana2_audit2);
                                                $anggota = $anggota_arr[1];
                                            }                                                                                        
                                        @endphp
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'tim_audit1','label' => 'Ketua Tim','required'=>true,'placeholder'=>'Tim Audit 1 (XX)','readonly'=>true,'value'=>$ketua])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @if(isset($value2->pelaksana2_audit2))
                                                    @component('components.inputtext',['name'=> 'tim_audit2','label' => 'TIm Audit','required'=>true,'placeholder'=>'Tim Audit 2 (YY)','readonly'=>true,'value'=>$anggota])@endcomponent
                                                @else
                                                    @component('components.inputtext',['name'=> 'tim_audit2','label' => 'TIm Audit','required'=>true,'placeholder'=>'Tim Audit 2 (YY)','readonly'=>true])@endcomponent
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Anggota Tambahan</label><div class="col-lg-6"><div><input class="form-control" id="tim_audit3" name="tim_audit3[]" type="text" label="Anggota Tambahan" placeholder="Anggota Tambahan"></div></div>
                                            <div class="col-lg-2">
                                                <div>
                                                    <select id="anggota_tambahan1" name="anggota_tambahan[]" class="form-control" data-size="10" data-live-search="true" data-style="btn-white">
                                                        <option value="Observer">Observer</option>
                                                        <option value="TA">TA</option>
                                                        <option value="PPC">PPC</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="wrapper col-lg-12">
                                                <div class="row">                                                
                                                    <div class="detail_anggota_tambahan" id="detail_anggota_tambahan{{$value->id}}" style="width: 100%;"></div>
                                                    <div class="col-md-12">
                                                        <a onClick="addAnggotaTambahan({{$value->id}})" class="tam_anggota_tambahan btn btn-sm btn-primary float-right" style="color:white">Tambah Anggota</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    @endforeach                                            
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label"><b>Tanggal Audit</b></label>
                                            <div id="shb" class="col-lg-8">
                                                <div class="input-group date">
                                                    <input type="text" id="tgl_audit1" name="tgl_audit[]" class="form-control" placeholder="Tanggal Audit" value="" data-date-start-date="Date.default" required/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-2 col-form-label">Jam</label>
                                            <div class="col-lg-2">
                                                <div class="input-group date">
                                                    <input id="jam_audit1" name="jam_audit[]" type='text' class="form-control" placeholder="Jam Audit" required/>
                                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                                </div>
                                            </div>
                                            <label class="col-form-label">-</label>
                                            <div class="col-lg-2">
                                                <div class="input-group date">
                                                    <input id="jam_audit21" name="jam_audit2[]" type='text' class="form-control" placeholder="Jam Audit" required/>
                                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Detail Kegiatan</label>
                                            <div class="col-lg-8"><div>
                                                <textarea id="detail_kegiatan" name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan" required></textarea>
                                            </div></div>                                
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Ch. All / Auditor (XX) / Auditor (XX) dan Auditor (YY)" required></div></div>
                                        </div>
                                    </div>                        
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12" style="display: none">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Jumlah Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="jumlah_kegiatan[]" type="text" label="Jumlah Kegiatan" placeholder="Jumlah Kegiatan" value="1" id="jml_kegiatan1"></div></div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan" id="detail_kegiatan{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a onClick="addDataKegiatan({{$value->id}})" class="tam_detail_kegiatan btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah Kegiatan</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div id="detail_hari{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">                                    
                                                <a onClick="addDataHari({{$value->id}})" class="tam_detail_hari btn btn-sm btn-info m-r-5 float-right" style="color:white; min-width: 125px;">Tambah Hari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">                                        
                                        <button type="submit" class="btn btn-sm btn-primary offset-md-5">Kirim</button>
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

    <div id="modalAuditPlan" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Konfirmasi Jadwal, SK Audit</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="1" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />                                                                        
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_ap" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
                            </div>                                                                                    
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan berkas?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <link href="{{asset('/assets/plugins/summernote-0.8.18/dist/summernote.min.css')}}" rel="stylesheet" />
    <script>                 

        document.getElementById('jml_kegiatan1').value = "1";           

        var jmlKegiatan = 1;
        var noKegiatan = 1;

        var jmlAnggota = 1;
        var noAnggota = 1;

        var jmlHari = 0;        
        var noHari = 1;

        var jmlDetail = 1;
        var jmlJam = 0;
        var jmlTgl = 0;                              

        function addDataKegiatan($id){
            jmlKegiatan+=1;
            jmlJam+=1;

            // alert(jmlKegiatan);
            var data_kegiatan = '<div id="datakegiatan'+jmlKegiatan+'" style="background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><label class="col-form-label">-</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit2'+(jmlJam+1)+'" name="jam_audit2[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-5"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan" required></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea id="d_kegiatan'+jmlKegiatan+'" name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan" required></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Ch. All / Auditor (XX) / Auditor (XX) dan Auditor (YY)" required></div></div>                                </div></div></div> <div class="col-lg-12"><div><a onClick="hapusKegiatan('+$id+','+jmlKegiatan+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('#detail_kegiatan'+$id).append(data_kegiatan);
            
            // document.getElementById('d_kegiatan'+jmlKegiatan).summernote({
            //     spellcheck: false,
            //     height: 350,                
            // });

            jam(jmlJam);
            jam2(jmlJam);
            document.getElementById('jml_kegiatan1').value = jmlKegiatan;            			
            // alert(jmlKeg);
        }

        function hapusKegiatan($id, $jml){  
            jmlKegiatan-=1;  
            jmlJam-=1;

            var select1 = document.getElementById('detail_kegiatan'+$id);
            var select2 = document.getElementById('datakegiatan'+$jml);
            select1.removeChild(select2);  
            
            document.getElementById('jml_kegiatan1').value = jmlKegiatan;
        }

        // $(document).on('click','#hapus_datakegiatanlain', function(){
        //     $(this).parent().parent().parent().remove();
        //     jmlKegiatan-=1;
        //     noKegiatan-=1;

        //     document.getElementById('jml_kegiatan1').value = jmlKegiatan + 1;

        //     if(jmlKegiatan == 0){
        //         detailkegiatan.style.display = 'none';
        //     }
        // });

        $('#tam_detail_hari').on('click', function(){
            // alert("disini");
            detailhari.style.display = 'block';
            noHari += 1;
            addDataHari();
        }); 

        function addDataHari($id){
            // alert($id);
            jmlDetail+=1;
            jmlJam+=1;
            jmlTgl+=1;
            var data_hari = '<div id="datahari'+jmlDetail+'">  <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label"><b>Tanggal Audit</b></label><div id="shb" class="col-lg-8"><div class="input-group date"><input type="text" id="tgl_audit'+(jmlTgl+1)+'" name="tgl_audit[]" class="form-control" placeholder="Tanggal Audit" value="" data-date-start-date="Date.default" required/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><label class="col-form-label">-</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit2'+(jmlJam+1)+'" name="jam_audit2[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-5"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan" required></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan" required></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Ch. All / Auditor (XX) / Auditor (XX) dan Auditor (YY)" required></div></div>                                </div></div</div><div class="panel-body panel-form"><div class="wrapper col-lg-12" style="display:none"><div class="row"><label class="col-4 col-form-label">Jumlah Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="jumlah_kegiatan[]" type="text" label="Jumlah Kegiatan" placeholder="Jumlah Kegiatan" value="1" id="jml_kegiatan'+jmlDetail+'"></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="detail_kegiatan'+jmlDetail+'" id="detail_kegiatan'+jmlDetail+'" style="width: 100%; background: #fff;"></div><div id="isi'+jmlDetail+'" style="display:none">'+jmlDetail+'</div><div class="col-md-12"><a id="tam_detail_kegiatan'+jmlDetail+'" class="tam_detail_kegiatan'+jmlDetail+' btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah Kegiatan</a></div></div></div></div>            <div class="col-lg-12"><div><a onClick="hapusHari('+$id+','+jmlDetail+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Hari</a></div></div><br></div>';
            $('#detail_hari'+$id).append(data_hari);
            jam(jmlJam);
            jam2(jmlJam);
            tanggal(jmlTgl);
            jmlHari+=1;                
            
            var detailkegiatan2 = document.getElementById('detail_kegiatan'+jmlDetail+'');
            var jmlKegiatan2 = 0;
            var noKegiatan2 = 1;

            var isi = document.getElementById("isi"+jmlDetail+"").innerText;
            $('#tam_detail_kegiatan'+isi+'').on('click', function(){                
                detailkegiatan2.style.display = 'block';
                noKegiatan2 += 1;
                addDataKegiatan2();
            });

            document.getElementById('jml_kegiatan'+isi+'').value = 1;
            function addDataKegiatan2(){                
                jmlJam+=1;
                var data_kegiatan2 = '<div id="datakegiatan'+jmlKegiatan2+'" style="background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><label class="col-form-label">-</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit2'+(jmlJam+1)+'" name="jam_audit2[]" type="text" class="form-control" placeholder="Jam Audit" required/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-5"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan" required></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan" required></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil" required></div></div>                                </div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain'+isi+'" class="btn btn-sm btn-warning m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
                $('.detail_kegiatan'+isi+'').append(data_kegiatan2);
                jmlKegiatan2+=1;
                document.getElementById('jml_kegiatan'+isi+'').value = jmlKegiatan2 + 1;
                jam(jmlJam);
                jam2(jmlJam);
            }

            // $(document).on('click','#hapus_datakegiatanlain'+jmlDetail+'', function(){
            $(document).on('click','#hapus_datakegiatanlain'+isi+'', function(){
                $(this).parent().parent().parent().remove();
                jmlKegiatan2-=1;
                noKegiatan2-=1;
                document.getElementById('jml_kegiatan'+isi+'').value = jmlKegiatan2 + 1;
                if(jmlKegiatan2 == 0){
                    detailkegiatan2.style.display = 'none';
                }
            });                         
        }        

        function hapusHari($id, $jml){  
            // alert("disini");
            var select1 = document.getElementById('detail_hari'+$id);
            var select2 = document.getElementById('datahari'+$jml);
            select1.removeChild(select2);
        }

        $(document).on('click','#hapus_dataharilain', function(){
            $(this).parent().parent().parent().parent().remove();
            jmlHari-=1;
            noHari-=1;                
            if(jmlHari == 0){
                detailhari.style.display = 'none';
            }
        });

        $(document).ready(
            function() {

                $('#tanggal_audit').datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                });

                $('#tanggal_audit_').datepicker({                    
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#tgl_audit1').datepicker({
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#jam_audit1').datetimepicker({
                    format: 'hh:ii',
                    language:  'id',
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 1,
                    minView: 0,
                    maxView: 1,
                    forceParse: 0,            
                });    

                $('#jam_audit21').datetimepicker({            
                    format: 'hh:ii',
                    language:  'id',
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 1,
                    minView: 0,
                    maxView: 1,
                    forceParse: 0,            
                }); 
            }
        );                           

        function jam(isi) {
            // alert(isi);
            $(document).ready(
                function() {
                    $('#jam_audit'+(isi+1)+'').datetimepicker({
                        format: 'hh:ii',
                        language:  'id',
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0,            
                    }); 
                }
            );
        }

        function jam2(isi) {
            $(document).ready(
                function() {            
                    $('#jam_audit2'+(isi+1)+'').datetimepicker({
                        format: 'hh:ii',
                        language:  'id',
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0,            
                    }); 
                }
            );
        }

        function tanggal(isi) {
            $(document).ready(
                function() {
                    $('#tgl_audit'+(isi+1)+'').datepicker({
                        format: "dd-mm-yyyy",
                        todayHighlight: true,
                    });
                }
            );
        }        

        function addAnggotaTambahan($id){
            jmlAnggota++;
            // alert($id);
            // var data_anggota = '<div id="datakegiatan'+jmlKegiatan+'" style="background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><label class="col-form-label">-</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit2'+(jmlJam+1)+'" name="jam_audit2[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-5"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Ch. All / Auditor (XX) / Auditor (XX) dan Auditor (YY)"></div></div>                                </div></div></div> <div class="col-lg-12"><div><a onClick="hapusKegiatan('+$id+','+jmlKegiatan+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            var data_anggota = '<div id="anggota_tambahan'+jmlAnggota+'"> <div class="wrapper col-lg-12"><div class="row"> <label class="col-4 col-form-label"></label><div class="col-lg-5"><div><input class="form-control" id="tim_audit3" name="tim_audit3[]" type="text" label="Anggota Tambahan" placeholder="Anggota Tambahan" required></div></div><div class="col-lg-2"><div><select id="anggota_tambahan'+(jmlAnggota)+'" name="anggota_tambahan[]" class="form-control" data-size="10" data-live-search="true" data-style="btn-white"><option value="Auditor">Auditor</option><option value="Observer">Observer</option><option value="TA">TA</option><option value="PPC">PPC</option></select></div></div> <div class="col-lg-1"><a onClick="hapusAnggota('+$id+','+jmlAnggota+')" class="btn btn-sm btn-danger m-r-5" style="color:white">X</a></div></div> </div></div>';
            $('#detail_anggota_tambahan'+$id).append(data_anggota);
            $('#anggota_tambahan'+jmlAnggota).selectpicker('refresh');            
        }

        function hapusAnggota($id,$jml){
            var select1 = document.getElementById('detail_anggota_tambahan'+$id);
            var select2 = document.getElementById('anggota_tambahan'+$jml);
            select1.removeChild(select2);
        }
    </script>
@endpush