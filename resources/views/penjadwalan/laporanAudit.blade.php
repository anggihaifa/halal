@extends('layouts.default')

@section('title', 'Laporan Audit  Tahap 2')

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
        <li class="breadcrumb-item"><a href="#">Audit Tahap 2</a></li>        
        <li class="breadcrumb-item active">Laporan Audit Tahap 2</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Laporan Audit Tahap 2<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Laporan Audit Tahap 2</h4>
                    <div class="panel-heading-btn">
                        {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> --}}
                    </div>
                </div>
                <div class="card-header tab-overflow p-t-0 p-b-0">
                    <ul class="nav nav-tabs card-header-tabs">                                                
                        <li class="nav-item text-center">                        
                            <a class="nav-link active" data-toggle="tab" href="#card-tab-5">Form Audit Tahap 2</a>
                        </li>
                        <li class="nav-item text-center">      
                            <a class="nav-link" data-toggle="tab" href="#card-tab-6">Form Checklist Audit Tahap 2</a>
                        </li>
                        <li class="nav-item text-center">      
                            <a class="nav-link" data-toggle="tab" href="#card-tab-8">Form Temuan Ketidaksesuaian</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-7">Laporan Audit Tahap 2</a>
                        </li>                                                
                    </ul>
                </div>
                <div class="card-body table-responsive-lg ">
					<div class="tab-content p-0 m-0">                       
                        <div class="tab-pane fade active show" id="card-tab-5">
                            <span class="text-danger">Silahkan refresh jika data form yang diinput belum ada</span>
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
                                                        <th class="text-center">Upload Perbaikan (Jika Ada)</th>
                                                        <th class="text-center">Berkas</th>
                                                        <th class="text-center">Tanggal Upload Perbaikan</th>
                                                        <th class="text-center">Keterangan</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">Form Laporan Audit Tahap 2</td>
                                                        <td class="text-center">
                                                            <form action="{{route('downloadlaporanauditsjph')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="wrapper col-lg-12" style="display: none">
                                                                    @foreach($dataRegistrasi as $index => $value)
                                                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                        
                                                                    @endforeach                        
                                                                </div>                                                                                                                                
                                                                <button type="submit" class="btn btn-sm btn-info">Download Formulir</button>
                                                            </form>
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['laporan_audit2_isian'])
                                                                        <a class="btn btn-sm btn-info" href="{{url('') .Storage::url('public/laporan/upload/Laporan Audit Tahap 2/Isian/'.$val['laporan_audit2_isian']) }}" download>Laporan Hasil Audit Tahap 2</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalLaporanAudit' style="cursor:pointer">Upload Disini</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_laporan_audit_tahap_2'])
                                                                        <a style="font-size: 9px" href="{{url('') .Storage::url('public/laporan/upload/Laporan Audit Tahap 2/'.$val['file_laporan_audit_tahap_2']) }}" download>{{$val['file_laporan_audit_tahap_2']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_laporan_audit_tahap_2'] == null? "-" : $val['tgl_penyerahan_laporan_audit_tahap_2']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                @if (isset($kt))
                                                                    @foreach ($kt as $val2)
                                                                        <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalLaporanAuditUlang' style="cursor:pointer">Upload Perbaikan</a>
                                                                        {{-- <p>Temuan : {{$val2['jumlah_tidak_sesuai']}}<br>Status : {{$val2['status']}}</p> --}}
                                                                    @endforeach
                                                                @else
                                                                -
                                                                @endif                                                                
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_laporan_audit_tahap_2_ulang'])
                                                                        <a style="font-size: 9px" href="{{url('') .Storage::url('public/laporan/upload/Laporan Audit Tahap 2/'.$val['file_laporan_audit_tahap_2_ulang']) }}" download>{{$val['file_laporan_audit_tahap_2_ulang']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_laporan_audit_tahap_2_ulang'] == null? "-" : $val['tgl_penyerahan_laporan_audit_tahap_2_ulang']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td class="text-center">Form Checklist Audit Tahap 2</td>
                                                        <td class="text-center">
                                                            <form action="{{route('downloadchecklisttahap2')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="wrapper col-lg-12" style="display: none">
                                                                    @foreach($dataRegistrasi as $index => $value)
                                                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                        
                                                                    @endforeach                        
                                                                </div>                                                                                                                                
                                                                <button type="submit" class="btn btn-sm btn-info">Download Formulir</button>
                                                            </form>
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['form_checlist_isian'])
                                                                        <a class="btn btn-sm btn-info" href="{{url('') .Storage::url('public/laporan/upload/Checklist Audit/Isian/'.$val['form_checlist_isian']) }}" download>Form Checklist Hasil Audit Tahap 2</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalChecklistAudit' style="cursor:pointer">Upload Disini</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_form_ceklis'])
                                                                        <a style="font-size: 9px" href="{{url('') .Storage::url('public/laporan/upload/Checklist Audit/'.$val['file_form_ceklis']) }}" download>{{$val['file_form_ceklis']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_form_ceklis'] == null? "-" : $val['tgl_penyerahan_form_ceklis']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">Form Temuan Ketidaksesuaian</td>
                                                        <td class="text-center">
                                                            {{-- <form action="{{route('downloadketidaksesuaian')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="wrapper col-lg-12" style="display: none">
                                                                    @foreach($dataRegistrasi as $index => $value)
                                                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                        
                                                                    @endforeach                        
                                                                </div>                                                                                                                                
                                                                <button type="submit" class="btn btn-sm btn-info">Download Format Temuan Ketidaksesuaian</button>
                                                            </form> --}}
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['ketidaksesuaian_isian'])
                                                                        <a class="btn btn-sm btn-info" href="{{url('') .Storage::url('public/laporan/download/Laporan Ketidaksesuaian/Isian/'.$val['ketidaksesuaian_isian']) }}" download>Form Temuan Ketidaksesuaian Hasil Audit Tahap 2</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)                                                               
                                                                @if (isset($kt))
                                                                    @if (count($kt) == 0)
                                                                        <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalKetidaksesuaian2' style="cursor:pointer">Upload Disini</a>                                                                        
                                                                    @else                                                                                                                                            
                                                                        <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalKetidaksesuaian' style="cursor:pointer">Upload Disini</a>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_laporan_ketidaksesuaian'])
                                                                        <a style="font-size: 9px" href="{{url('') .Storage::url('public/laporan/upload/Laporan Ketidaksesuaian/'.$val['file_laporan_ketidaksesuaian']) }}" download>{{$val['file_laporan_ketidaksesuaian']}}</a>                                                                        
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @foreach ($laporan2 as $val)
                                                                {{$val['tgl_penyerahan_laporan_ketidaksesuaian'] == null? "-" : $val['tgl_penyerahan_laporan_ketidaksesuaian']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (isset($kt))
                                                                @foreach ($kt as $val2)                                                                    
                                                                    @if($val2['status'] == 'open')
                                                                        <p style="font-size: 9px;">Ketidaksesuaian : {{$val2['jumlah_tidak_sesuai']}}<br>Status : {{$val2['status']}}</p>
                                                                        <a href="{{url('update_status_audit_tahap2')}}/{{$value->id}}/11/{{Auth::user()->name }}/{{$val2['id']}}" class="btn btn-sm btn-info" style="font-size: 9px;">Lanjut ke tahapan Technical Review</a>
                                                                    @else
                                                                        <p style="font-size: 9px;">Ketidaksesuaian : {{$val2['jumlah_tidak_sesuai']}}<br>Status : {{$val2['status']}}</p>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">Berita Acara Pemeriksaan</td>
                                                        <td class="text-center">                                                            
                                                            -
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalBAP' style="cursor:pointer">Upload Disini</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_bap'])
                                                                        <a href="{{url('') .Storage::url('public/laporan/upload/BAP/'.$val['file_bap']) }}" download>{{$val['file_bap']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_bap'] == null? "-" : $val['tgl_penyerahan_bap']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            -    
                                                        </td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td class="text-center">5</td>
                                                        <td class="text-center">Surat Tugas</td>
                                                        <td class="text-center">                                                            
                                                            -
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['ketidaksesuaian_isian'])
                                                                        <a class="btn btn-sm btn-info" href="{{url('') .Storage::url('public/laporan/download/Laporan Ketidaksesuaian/Isian/'.$val['ketidaksesuaian_isian']) }}" download>Form Surat Tugas</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>                                                        
                                                        <td class="text-center">
                                                            @if (Auth::user()->usergroup_id == 10 || Auth::user()->usergroup_id == 11)
                                                                <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$value->id}}` data-target='#modalSuratTugas' style="cursor:pointer">Upload Disini</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @if (count($laporan2) == 0)
                                                                -
                                                            @else                                                            
                                                                @foreach ($laporan2 as $val)
                                                                    @if ($val['file_surat_tugas'])
                                                                        <a href="{{url('') .Storage::url('public/laporan/upload/Surat Tugas/'.$val['file_surat_tugas']) }}" download>{{$val['file_surat_tugas']}}</a>
                                                                    @else		
                                                                    -																
                                                                    @endif																			
                                                                @endforeach									
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                            @foreach ($laporan2 as $val)										
                                                                {{$val['tgl_penyerahan_surat_tugas'] == null? "-" : $val['tgl_penyerahan_surat_tugas']}}
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                        <td class="text-center" style="font-size: 9px;">
                                                        -    
                                                        </td>
                                                    </tr>
                                                    </table>                                                
                                            </div>
                                        </div>
                                    </div>                                
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="card-tab-6">                            
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
                                                            <td class="valign-middle">1. Pelaku usaha/manajemen puncak perusahaan harus menetapkan Kebijakan halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="m" id="1a1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="tm" id="1a1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a1" value="tr" id="1a1tr" style="cursor: pointer;"/>
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
                                                                    <input type="radio" name="rb1a2" value="m" id="1a2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a2" value="tm" id="1a2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a2" value="tr" id="1a2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a2" type="text" class="form-control" placeholder="Catatan" id="1a2ca" />
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku usaha/manajemen puncak perusahaan harus memastikan bahwa kebijakan halal yang ditetapkan dipahami dan diterapkan oleh seluruh personil dalam organisasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="m" id="1a3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="tm" id="1a3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a3" value="tr" id="1a3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1a3" type="text" class="form-control" placeholder="Catatan" id="1a3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha/manajemen puncak perusahaan harus mensosialisasikan dan mengkomunikasikan kebijakan kepada seluruh pihak terkait (stakeholder)</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="m" id="1a4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="tm" id="1a4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1a4" value="tr" id="1a4tr" style="cursor: pointer;"/>
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
                                                            <td class="valign-middle">1. Pelaku usaha/pimpinan puncak perusahaan menjamin tersedianya sumber daya manusia yang kompeten dan memadai untuk penyusunan, penerapan dan perbaikan berkelanjutan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="m" id="1b1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="tm" id="1b1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b1" value="tr" id="1b1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b1" type="text" class="form-control" placeholder="Catatan" id="1b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha/pimpinan puncak perusahaan harus menetapkan personil muslim sebagai Penyelia Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="m" id="1b2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="tm" id="1b2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b2" value="tr" id="1b2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b2" type="text" class="form-control" placeholder="Catatan" id="1b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha/pimpinan puncak perusahaan harus meregistrasi Penyelia Halal kepada Badan Penyelenggara Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="m" id="1b3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="tm" id="1b3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b3" value="tr" id="1b3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b3" type="text" class="form-control" placeholder="Catatan" id="1b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha/pimpinan puncak perusahaan berkomitmen mengizinkan personil muslim untuk melaksanakan kewajiban beribadah</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="m" id="1b4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="tm" id="1b4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b4" value="tr" id="1b4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b4" type="text" class="form-control" placeholder="Catatan" id="1b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha/pimpinan puncak perusahaan harus memastikan komitmen semua personil di perusahaan termasuk pemasok dan distributor untuk menjaga integritas halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="m" id="1b5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="tm" id="1b5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b5" value="tr" id="1b5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b5" type="text" class="form-control" placeholder="Catatan" id="1b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha/pimpinan puncak perusahaan berskala besar harus menetapkan tim manajemen halal yang melibatkan seluruh pihak terkait dan disertai bukti tertulis</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="m" id="1b6m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="tm" id="1b6tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b6" value="tr" id="1b6tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b6" type="text" class="form-control" placeholder="Catatan" id="1b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Pelaku Usaha berskala Mikro dan Kecil (UMK) dapat memiliki tim manajemen halal dan/atau Penyelia Halal melalui fasilitasi oleh pihak lain seperti Pemerintah Pusat, Pemerintah Daerah, BUMN, BUMD, Perguruan Tinggi Negeri melalui Pusat Kajian Halal, dan Lembaga Keagamaan Islam berbadan hukum</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b7" value="m" id="1b7m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b7" value="tm" id="1b7tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1b7" value="tr" id="1b7tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1b7" type="text" class="form-control" placeholder="Catatan" id="1b7ca"/>
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
                                                            <td class="valign-middle">1. Pelaku Usaha/pimpinan puncak perusahaan harus mengikutsertakan Penyelia Halal dalam pelatihan Penyelia Halal yang dilaksanakan oleh Badan Penyelenggara Jaminan Produk Halal dan/atau lembaga pendidikan dan pelatihan lain yang bekerja sama dengan Badan Penyelenggara Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="m" id="1c1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="tm" id="1c1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c1" value="tr" id="1c1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c1" type="text" class="form-control" placeholder="Catatan" id="1c1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha/pimpinan puncak perusahaan harus memfasilitasi pelatihan terhadap personil terkait sesuai kebutuhan penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="m" id="1c2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="tm" id="1c2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c2" value="tr" id="1c2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c2" type="text" class="form-control" placeholder="Catatan" id="1c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha/perusahaan harus memiliki prosedur tertulis pelatihan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="m" id="1c3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="tm" id="1c3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c3" value="tr" id="1c3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c3" type="text" class="form-control" placeholder="Catatan" id="1c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha/perusahaan harus memelihara bukti pelaksanaan pelatihan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="m" id="1c4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="tm" id="1c4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb1c4" value="tr" id="1c4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca1c4" type="text" class="form-control" placeholder="Catatan" id="1c4ca"/>
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
                                                        <td class="valign-middle text-center">2.1</td>
                                                        <td class="valign-middle">Pelaku usaha wajib menggunakan bahan halal untuk Proses Produk Halal yang terdiri atas bahan baku, bahan olahan, bahan tambahan, dan bahan penolong</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="m" id="21m" style="cursor: pointer;" required/>                                  
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="tm" id="21tm" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb21" value="tr" id="21tr" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca21" type="text" class="form-control" placeholder="Catatan" id="21ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center">2.2</td>
                                                        <td class="valign-middle">Bahan yang dimaksud pada poin 2.1 adalah berasal dari : hewan, tumbuhan, mikroba atau bahan yang dihasilkan melalui proses kimiawi, proses biologi, atau proses rekayasa genetik.</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="m" id="22m" style="cursor: pointer;" required/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="tm" id="22tm" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb22" value="tr" id="22tr" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca22" type="text" class="form-control" placeholder="Catatan" id="22ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle text-center">2.3</td>
                                                        <td class="valign-middle">Dokumen Pendukung Bahan Pelaku Usaha wajib melengkapi Bahan yang digunakan dengan dokumen pendukung kehalalan yang sesuai dan valid, kecuali Bahan-bahan yang sudah ditetapkan oleh Badan Penyelenggara Jaminan Produk Halal tidak perlu memiliki dokumen pendukung</td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="m" id="23m" style="cursor: pointer;" required/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="tm" id="23tm" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle text-center">
                                                            <div class="radio">
                                                                <input type="radio" name="rb23" value="tr" id="23tr" style="cursor: pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td class="valign-middle">
                                                            <input name="ca23" type="text" class="form-control" placeholder="Catatan" id="23ca"/>
                                                        </td>                                                                                                
                                                    </tr>
                                                    {{-- <tr>
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
                                                    </tr> --}}
                                                    <!-- <tr>
                                                        <td class="valign-middle text-center"></td>
                                                        <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                        <td class="valign-middle" colspan="4">
                                                            <input type="button" value="Reset Semua Data" class="btn btn-sm btn-danger float-right" id="btn_reset2">
                                                        </td>                                                                                                
                                                    </tr> -->
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
                                                            <td class="valign-middle font-weight-bold">Lokasi, Tempat dan Alat</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">1. Pelaku usaha wajib memisahkan lokasi, tempat, dan alat proses produk halal dengan proses Produk tidak halal. Lokasi yang wajib dipisahkan yakni lokasi penyembelihan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="m" id="3a1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="tm" id="3a1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a1" value="tr" id="3a1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a1" type="text" class="form-control" placeholder="Catatan" id="3a1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku usaha wajib memisahkan lokasi penyembelihan hewan halal dengan hewan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="m" id="3a2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="tm" id="3a2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a2" value="tr" id="3a2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a2" type="text" class="form-control" placeholder="Catatan" id="3a2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku usaha wajib memisahkan lokasi penyembelihan yang memenuhi persyaratan :</td>                                                            
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Terpisah secara fisik antara lokasi rumah potong hewan halal dengan lokasi rumah potong hewan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3a" value="m" id="3a3am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3a" value="tm" id="3a3atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3a" value="tr" id="3a3atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3a" type="text" class="form-control" placeholder="Catatan" id="3a3aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Dibatasi dengan pagar tembok paling rendah 3 (tiga) meter untuk mencegah lalu lintas orang, alat, dan Produk antar rumah potong</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3b" value="m" id="3a3bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3b" value="tm" id="3a3btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3b" value="tr" id="3a3btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3b" type="text" class="form-control" placeholder="Catatan" id="3a3bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. Tidak berada di daerah rawan banjir, tercemar asap, bau, debu, dan kontaminan lainnya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3c" value="m" id="3a3cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3c" value="tm" id="3a3ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3c" value="tr" id="3a3ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3c" type="text" class="form-control" placeholder="Catatan" id="3a3cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">d. Memiliki fasilitas penanganan limbah padat dan cair yang terpisah dengan rumah potong hewan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3d" value="m" id="3a3dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3d" value="tm" id="3a3dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3d" value="tr" id="3a3dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3d" type="text" class="form-control" placeholder="Catatan" id="3a3dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">e. Konstruksi dasar seluruh bangunan harus mampu mencegah kontaminasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3e" value="m" id="3a3em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3e" value="tm" id="3a3etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3e" value="tr" id="3a3etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3e" type="text" class="form-control" placeholder="Catatan" id="3a3eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">f. Memiliki pintu yang terpisah untuk masuknya hewan potong dengan keluarnya karkas dan daging</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3f" value="m" id="3a3fm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3f" value="tm" id="3a3ftm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a3f" value="tr" id="3a3ftr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a3f" type="text" class="form-control" placeholder="Catatan" id="3a3fca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku usaha wajib memisahkan tempat penyembelihan hewan halal dengan hewan tidak halal meliputi :</td>                                                                      
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. penampungan hewan </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4a" value="m" id="3a4am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4a" value="tm" id="3a4atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4a" value="tr" id="3a4atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4a" type="text" class="form-control" placeholder="Catatan" id="3a4aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. penyembelihan hewan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4b" value="m" id="3a4bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4b" value="tm" id="3a4btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4b" value="tr" id="3a4btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4b" type="text" class="form-control" placeholder="Catatan" id="3a4bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. pengulitan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4c" value="m" id="3a4cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4c" value="tm" id="3a4ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4c" value="tr" id="3a4ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4c" type="text" class="form-control" placeholder="Catatan" id="3a4cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">d. pengeluaran jeroan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4d" value="m" id="3a4dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4d" value="tm" id="3a4dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4d" value="tr" id="3a4dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4d" type="text" class="form-control" placeholder="Catatan" id="3a4dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">e. ruang pelayuan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4e" value="m" id="3a4em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4e" value="tm" id="3a4etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4e" value="tr" id="3a4etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4e" type="text" class="form-control" placeholder="Catatan" id="3a4eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">f. penanganan karkas</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4f" value="m" id="3a4fm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4f" value="tm" id="3a4ftm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4f" value="tr" id="3a4ftr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4f" type="text" class="form-control" placeholder="Catatan" id="3a4fca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">g. ruang pendinginan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4g" value="m" id="3a4gm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4g" value="tm" id="3a4gtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4g" value="tr" id="3a4gtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4g" type="text" class="form-control" placeholder="Catatan" id="3a4gca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">h. sarana penanganan limbah</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4h" value="m" id="3a4hm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4h" value="tm" id="3a4htm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a4h" value="tr" id="3a4htr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a4h" type="text" class="form-control" placeholder="Catatan" id="3a4hca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku usaha wajib memisahkan tempat dan alat PPH yang dimaksud pada butir 1 (satu) meliputi tempat :</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. penyembelihan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5a" value="m" id="3a5am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5a" value="tm" id="3a5atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5a" value="tr" id="3a5atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5a" type="text" class="form-control" placeholder="Catatan" id="3a5aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. pengolahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5b" value="m" id="3a5bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5b" value="tm" id="3a5btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5b" value="tr" id="3a5btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5b" type="text" class="form-control" placeholder="Catatan" id="3a5bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. penyimpanan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5c" value="m" id="3a5cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5c" value="tm" id="3a5ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5c" value="tr" id="3a5ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5c" type="text" class="form-control" placeholder="Catatan" id="3a5cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">d. pengemasan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5d" value="m" id="3a5dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5d" value="tm" id="3a5dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5d" value="tr" id="3a5dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5d" type="text" class="form-control" placeholder="Catatan" id="3a5dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">e. pendistribusian</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5e" value="m" id="3a5em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5e" value="tm" id="3a5etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5e" value="tr" id="3a5etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5e" type="text" class="form-control" placeholder="Catatan" id="3a5eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">f. penjualan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5f" value="m" id="3a5fm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5f" value="tm" id="3a5ftm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5f" value="tr" id="3a5ftr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5f" type="text" class="form-control" placeholder="Catatan" id="3a5fca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">g. penyajian</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5g" value="m" id="3a5gm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5g" value="tm" id="3a5gtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a5f" value="tr" id="3a5gtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a5g" type="text" class="form-control" placeholder="Catatan" id="3a5gca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Seluruh penggunaan fasilitas, barang, dan peralatan terpisahkan antara produk halal dan non halal. (compile dengan point 7 & 8.)</td>                                                                                                                                                         
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Menjaga kebersihan dan higienitas lokasi dan tempat PPH</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6a" value="m" id="3a6am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6a" value="tm" id="3a6atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6a" value="tr" id="3a6atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a6a" type="text" class="form-control" placeholder="Catatan" id="3a6aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Memiliki lokasi dan tempat PPH yang bebas dari Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6b" value="m" id="3a6bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6b" value="tm" id="3a6btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6b" value="tr" id="3a6btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a6b" type="text" class="form-control" placeholder="Catatan" id="3a6bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. Memiliki lokasi dan tempat PPH yang bebas dari bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6c" value="m" id="3a6cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6c" value="tm" id="3a6ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a6c" value="tr" id="3a6ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a6c" type="text" class="form-control" placeholder="Catatan" id="3a6cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Pelaku Usaha wajib memisahkan tempat pengolahan antara yang halal dan tidak halal meliputi : </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. penampungan bahan </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="m" id="3a7am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="tm" id="3a7atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7a" value="tr" id="3a7atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7a" type="text" class="form-control" placeholder="Catatan" id="3a7aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. penimbangan bahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="m" id="3a7bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="tm" id="3a7btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7b" value="tr" id="3a7btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7b" type="text" class="form-control" placeholder="Catatan" id="3a7bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. pencampuran bahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="m" id="3a7cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="tm" id="3a7ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7c" value="tr" id="3a7ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7c" type="text" class="form-control" placeholder="Catatan" id="3a7cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">d. pencetakan produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7d" value="m" id="3a7dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7d" value="tm" id="3a7dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7d" value="tr" id="3a7dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7d" type="text" class="form-control" placeholder="Catatan" id="3a7dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">e. pemasakan produk dan/atau </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7e" value="m" id="3a7em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7e" value="tm" id="3a7etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7e" value="tr" id="3a7etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7e" type="text" class="form-control" placeholder="Catatan" id="3a7eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">f. proses lainnya yang mempengaruhi pengolahan pangan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7f" value="m" id="3a7fm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7f" value="tm" id="3a7ftm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a7f" value="tr" id="3a7ftr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a7f" type="text" class="form-control" placeholder="Catatan" id="3a7fca"/>
                                                            </td>                                                                                                
                                                        </tr>                                                        
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Pelaku Usaha wajib memisahkan tempat penyimpanan antara yang halal dan tidak halal meliputi : </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Penerimaan Bahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8a" value="m" id="3a8am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8a" value="tm" id="3a8atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8a" value="tr" id="3a8atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a8a" type="text" class="form-control" placeholder="Catatan" id="3a8aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Penerimaan Produk setelah proses pengolahan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8b" value="m" id="3a8bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8b" value="tm" id="3a8btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8b" value="tr" id="3a8btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a8b" type="text" class="form-control" placeholder="Catatan" id="3a8bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">c. Sarana yang digunakan untuk penyimpanan Bahan dan Produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8c" value="m" id="3a8cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8c" value="tm" id="3a8ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a8c" value="tr" id="3a8ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a8c" type="text" class="form-control" placeholder="Catatan" id="3a8cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">9. Pelaku Usaha wajib memisahkan tempat pengemasan antara yang halal dan tidak halal meliputi :</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Bahan kemasan yang digunakan untuk mengemas produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9a" value="m" id="3a9am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9a" value="tm" id="3a9atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9a" value="tr" id="3a9atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a9a" type="text" class="form-control" placeholder="Catatan" id="3a9aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Sarana pengemasan produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9b" value="m" id="3a9bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9b" value="tm" id="3a9btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a9b" value="tr" id="3a9btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a9b" type="text" class="form-control" placeholder="Catatan" id="3a9bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">10. Pelaku Usaha wajib memisahkan tempat pendistribusian antara produk halal dan tidak halal meliputi :</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Sarana pengangkutan dari tempat penyimpanan ke alat distribusi produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10a" value="m" id="3a10am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10a" value="tm" id="3a10atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10a" value="tr" id="3a10atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a10a" type="text" class="form-control" placeholder="Catatan" id="3a10aca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Alat transportasi untuk distribusi produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10b" value="m" id="3a10bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10b" value="tm" id="3a10btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a10b" value="tr" id="3a10btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a10b" type="text" class="form-control" placeholder="Catatan" id="3a10bca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">11.	Pelaku Usaha wajib memisahkan tempat penjualan antara yang halal dan tidak halal meliputi :</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">a. Sarana penjualan produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11a" value="m" id="3a11am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11a" value="tm" id="3a11atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11a" value="tr" id="3a11atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a11a" type="text" class="form-control" placeholder="Catatan" id="3a11aca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">b. Proses penjualan produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11b" value="m" id="3a11bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11b" value="tm" id="3a11btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a11b" value="tr" id="3a11btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a11b" type="text" class="form-control" placeholder="Catatan" id="3a11bca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">12.	Pelaku Usaha wajib memisahkan </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="m" id="3a12m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="tm" id="3a12tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a12" value="tr" id="3a12tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a12" type="text" class="form-control" placeholder="Catatan" id="3a12ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">13. Pelaku Usaha wajib menyediakan tempat proses produksi halal yang bebas dari hewan peliharaan dan hewan liar</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="m" id="3a13m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="tm" id="3a13tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a13" value="tr" id="3a13tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a13" type="text" class="form-control" placeholder="Catatan" id="3a13ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">14. Pelaku Usaha wajib memisahkan tempat/fasilitas pencucian peralatan produksi antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="m" id="3a14m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="tm" id="3a14tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a14" value="tr" id="3a14tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a14" type="text" class="form-control" placeholder="Catatan" id="3a14ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">15. Pelaku Usaha wajib menyediakan fasilitas sanitasi dalam jumlah yang memadai dan dipelihara kebersihannya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="m" id="3a15m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="tm" id="3a15tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a15" value="tr" id="3a15tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a15" type="text" class="form-control" placeholder="Catatan" id="3a15ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">16. Pelaku Usaha wajib memisahkan secara fisik fasilitas display antara Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="m" id="3a16m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="tm" id="3a16tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a16" value="tr" id="3a16tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a16" type="text" class="form-control" placeholder="Catatan" id="3a16ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">17. Pelaku Usaha wajib memastikan tidak terdapat barang-barang dan peralatan yang tidak terkait dengan proses produksi berada di Area pemrosesan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="m" id="3a17m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="tm" id="3a17tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a17" value="tr" id="3a17tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a17" type="text" class="form-control" placeholder="Catatan" id="3a17ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">18. Pelaku Usaha wajib memisahkan lokasi dan tempat penyembelihan antara hewan halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="m" id="3a18m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="tm" id="3a18tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a18" value="tr" id="3a18tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a18" type="text" class="form-control" placeholder="Catatan" id="3a18ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">19. Pelaku Usaha wajib memisahkan tempat pengolahan antara penampungan, penimbangan, dan pencampuran Bahan halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="m" id="3a19m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="tm" id="3a19tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a19" value="tr" id="3a19tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a19" type="text" class="form-control" placeholder="Catatan" id="3a19ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">20. Pelaku Usaha wajib memisahkan tempat pengolahan antara pencetakan dan pemasakan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a20" value="m" id="3a20m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a20" value="tm" id="3a20tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a20" value="tr" id="3a20tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a20" type="text" class="form-control" placeholder="Catatan" id="3a20ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">21. Pelaku Usaha wajib memisahkan tempat penyimpanan penerimaan Bahan antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a21" value="m" id="3a21m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a21" value="tm" id="3a21tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a21" value="tr" id="3a21tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a21" type="text" class="form-control" placeholder="Catatan" id="3a21ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">22. Pelaku Usaha wajib memisahkan tempat penyimpanan penerimaan Produk setelah proses pengolahan antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a22" value="m" id="3a22m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a22" value="tm" id="3a22tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a22" value="tr" id="3a22tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a22" type="text" class="form-control" placeholder="Catatan" id="3a22ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">23. Pelaku Usaha wajib memisahkan tempat penyimpanan sarana yang digunakan untuk penyimpanan Bahan dan Produk antara halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a23" value="m" id="3a23m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a23" value="tm" id="3a23tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a23" value="tr" id="3a23tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a23" type="text" class="form-control" placeholder="Catatan" id="3a23ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">24. Pelaku Usaha wajib memisahkan tempat pengemasan Bahan kemasan yang digunakan untuk pengemasan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a24" value="m" id="3a24m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a24" value="tm" id="3a24tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a24" value="tr" id="3a24tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a24" type="text" class="form-control" placeholder="Catatan" id="3a24ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">25. Pelaku Usaha wajib memisahkan tempat pengemasan sarana pengemasan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a25" value="m" id="3a25m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a25" value="tm" id="3a25tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a25" value="tr" id="3a25tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a25" type="text" class="form-control" placeholder="Catatan" id="3a25ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">26. Pelaku Usaha wajib memisahkan tempat pendistribusian sarana pengangkutan dari tempat penyimpanan ke alat distribusi Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a26" value="m" id="3a26m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a26" value="tm" id="3a26tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a26" value="tr" id="3a26tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a26" type="text" class="form-control" placeholder="Catatan" id="3a26ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">27. Pelaku Usaha wajib memisahkan tempat pendistribusian alat transportasi untuk distribusi Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a27" value="m" id="3a27m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a27" value="tm" id="3a27tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a27" value="tr" id="3a27tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a27" type="text" class="form-control" placeholder="Catatan" id="3a27ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">28.	Pelaku Usaha wajib memisahkan tempat sarana penjualan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a28" value="m" id="3a28m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a28" value="tm" id="3a28tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a28" value="tr" id="3a28tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a28" type="text" class="form-control" placeholder="Catatan" id="3a28ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">29. Pelaku Usaha wajib memisahkan tempat proses penjualan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a29" value="m" id="3a29m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a29" value="tm" id="3a29tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a29" value="tr" id="3a29tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a29" type="text" class="form-control" placeholder="Catatan" id="3a29ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">30. Pelaku Usaha wajib memisahkan tempat sarana penyajian Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a30" value="m" id="3a30m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a30" value="tm" id="3a30tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a30" value="tr" id="3a30tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a30" type="text" class="form-control" placeholder="Catatan" id="3a30ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">31. Pelaku Usaha wajib memisahkan tempat proses penyajian Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a31" value="m" id="3a31m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a31" value="tm" id="3a31tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a31" value="tr" id="3a31tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a31" type="text" class="form-control" placeholder="Catatan" id="3a31ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">32. Pelaku Usaha tidak boleh menggunakan tempat produksi yang pernah digunakan untuk Produk yang mengandung babi atau turunannya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a32" value="m" id="3a32m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a32" value="tm" id="3a32tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a32" value="tr" id="3a32tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a32" type="text" class="form-control" placeholder="Catatan" id="3a32ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">33. Pelaku Usaha wajib memisahkan tempat penyimpanan material Produk Bahan halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a33" value="m" id="3a33m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a33" value="tm" id="3a33tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a33" value="tr" id="3a33tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a33" type="text" class="form-control" placeholder="Catatan" id="3a33ca"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">34. Pelaku Usaha wajib menjamin tidak ada kontaminasi pada saat pengambilan sampel Bahan dan Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a34" value="m" id="3a34m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a34" value="tm" id="3a343tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3a34" value="tr" id="3a34tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3a34" type="text" class="form-control" placeholder="Catatan" id="3a34ca"/>
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
                                                            <td class="valign-middle">1. Pelaku Usaha wajib memisahkan peralatan dan perangkat Proses Produk Halal dengan Produk yang tidak halal meliputi alat penyembelihan, pengolahan, penyimpanan, pengemasan, pendistribusian, penjualan, dan penyajian</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="m" id="3b1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="tm" id="3b1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b1" value="tr" id="3b1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b1" type="text" class="form-control" placeholder="Catatan" id="3b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha wajib menjamin kebersihan dan higienitas peralatan dan perangkat Proses Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="m" id="3b2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="tm" id="3b2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b2" value="tr" id="3b2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b2" type="text" class="form-control" placeholder="Catatan" id="3b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha wajib menjamin peralatan dan perangkat Proses Produk Halal bebas dari Najis</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="m" id="3b3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="tm" id="3b3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b3" value="tr" id="3b3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b3" type="text" class="form-control" placeholder="Catatan" id="3b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha wajib menjamin peralatan dan perangkat Proses Produk Halal bebas dari Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="m" id="3b4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="tm" id="3b4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b4" value="tr" id="3b4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b4" type="text" class="form-control" placeholder="Catatan" id="3b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha wajib menjamin setiap bagian dari peralatan, perangkat, dan mesin yang bersentuhan langsung dengan Proses Produksi Halal tidak terbuat dari Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="m" id="3b5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="tm" id="3b5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b5" value="tr" id="3b5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b5" type="text" class="form-control" placeholder="Catatan" id="3b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha wajib menjamin penggunaan Bahan untuk perawatan mesin, peralatan dan perangkat Proses Produk Halal tidak terbuat dari Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="m" id="3b6m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="tm" id="3b6tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b6" value="tr" id="3b6tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b6" type="text" class="form-control" placeholder="Catatan" id="3b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Pelaku Usaha dilarang menggunakan peralatan atau sikat dari bulu babi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="m" id="3b7m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="tm" id="3b7tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b7" value="tr" id="3b7tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b7" type="text" class="form-control" placeholder="Catatan" id="3b7ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Pelaku Usaha wajib tidak menggunakan peralatan penyimpanan secara bergantian antara Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="m" id="3b8m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="tm" id="3b8tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b8" value="tr" id="3b8tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b8" type="text" class="form-control" placeholder="Catatan" id="3b8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">9. Pelaku Usaha wajib menggunakan sarana peralatan penyimpanan yang berbeda dalam kegiatan pembersihan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="m" id="3b9m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="tm" id="3b9tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b9" value="tr" id="3b9tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b9" type="text" class="form-control" placeholder="Catatan" id="3b9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">10. Pelaku Usaha wajib menggunakan sarana peralatan penyimpanan yang berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="m" id="3b10m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="tm" id="3b10tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b10" value="tr" id="3b10tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b10" type="text" class="form-control" placeholder="Catatan" id="3b10ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">11. Pelaku Usaha wajib memiliki tempat penyimpanan peralatan sendiri untuk yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="m" id="3b11m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="tm" id="3b11tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b11" value="tr" id="3b11tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b11" type="text" class="form-control" placeholder="Catatan" id="3b11ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">12. Pelaku Usaha wajib tidak menggunakan peralatan pengemasan secara bergantian antara Produk halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="m" id="3b12m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="tm" id="3b12tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b12" value="tr" id="3b12tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b12" type="text" class="form-control" placeholder="Catatan" id="3b12ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">13. Pelaku Usaha wajib menggunakan sarana peralatan pengemasan yang berbeda dalam kegiatan pembersihan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="m" id="3b13m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="tm" id="3b13tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b13" value="tr" id="3b13tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b13" type="text" class="form-control" placeholder="Catatan" id="3b13ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">14. Pelaku Usaha wajib menggunakan sarana peralatan pengemasan yang berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b14" value="m" id="3b14m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b14" value="tm" id="3b14tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b14" value="tr" id="3b14tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b14" type="text" class="form-control" placeholder="Catatan" id="3b14ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">15. Pelaku Usaha wajib memiliki tempat pengemasan peralatan sendiri untuk yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b15" value="m" id="3b15m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b15" value="tm" id="3b15tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b15" value="tr" id="3b15tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b15" type="text" class="form-control" placeholder="Catatan" id="3b15ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">16. Pelaku Usaha wajib tidak menggunakan peralatan pendistribusian secara bergantian antara Produk halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b16" value="m" id="3b16m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b16" value="tm" id="3b16tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b16" value="tr" id="3b16tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b16" type="text" class="form-control" placeholder="Catatan" id="3b16ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">17. Pelaku Usaha wajib menggunakan sarana peralatan pendistribusian yang berbeda dalam kegiatan pembersihan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b17" value="m" id="3b17m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b17" value="tm" id="3b17tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b17" value="tr" id="3b17tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b17" type="text" class="form-control" placeholder="Catatan" id="3b17ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">18. Pelaku Usaha wajib menggunakan sarana peralatan pendistribusian yang berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b18" value="m" id="3b18m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b18" value="tm" id="3b18tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b18" value="tr" id="3b18tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b18" type="text" class="form-control" placeholder="Catatan" id="3b18ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">19. Pelaku Usaha wajib memiliki tempat pendistribusian peralatan sendiri untuk yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b19" value="m" id="3b19m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b19" value="tm" id="3b19tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b19" value="tr" id="3b19tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b19" type="text" class="form-control" placeholder="Catatan" id="3b19ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">20. Pelaku Usaha wajib tidak menggunakan peralatan penjualan secara bergantian antara Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b20" value="m" id="3b20m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b20" value="tm" id="3b20tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b20" value="tr" id="3b20tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b20" type="text" class="form-control" placeholder="Catatan" id="3b20ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">21. Pelaku Usaha wajib menggunakan sarana peralatan penjualan yang berbeda dalam kegiatan pembersihan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b21" value="m" id="3b21m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b21" value="tm" id="3b21tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b21" value="tr" id="3b21tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b21" type="text" class="form-control" placeholder="Catatan" id="3b21ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">22. Pelaku Usaha wajib menggunakan sarana peralatan penjualan yang berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b22" value="m" id="3b22m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b22" value="tm" id="3b22tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b22" value="tr" id="3b22tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b22" type="text" class="form-control" placeholder="Catatan" id="3b22ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">23. Pelaku Usaha wajib tidak menggunakan peralatan penyajian secara bergantian antara Produk Halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b23" value="m" id="3b23m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b23" value="tm" id="3b23tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b23" value="tr" id="3b23tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b23" type="text" class="form-control" placeholder="Catatan" id="3b23ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">24. Pelaku Usaha wajib menggunakan sarana peralatan penyajian yang berbeda dalam kegiatan pembersihan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b24" value="m" id="3b24m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b24" value="tm" id="3b24tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b24" value="tr" id="3b24tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b24" type="text" class="form-control" placeholder="Catatan" id="3b24ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">25. Pelaku Usaha wajib menggunakan sarana peralatan penyajian yang berbeda untuk kegiatan pemeliharaan peralatan yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b25" value="m" id="3b25m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b25" value="tm" id="3b25tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b25" value="tr" id="3b25tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b25" type="text" class="form-control" placeholder="Catatan" id="3b25ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">26. Pelaku Usaha wajib memiliki tempat penyimpanan peralatan penyajian sendiri untuk yang halal dan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b26" value="m" id="3b26m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b26" value="tm" id="3b26tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b26" value="tr" id="3b26tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b26" type="text" class="form-control" placeholder="Catatan" id="3b26ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">27. Pelaku Usaha tidak boleh menggunakan peralatan dan perangkat yang pernah digunakan dalam proses produksi Produk tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b27" value="m" id="3b27m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b27" value="tm" id="3b27tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b27" value="tr" id="3b27tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b27" type="text" class="form-control" placeholder="Catatan" id="3b27ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">28. Pelaku Usaha wajib menjamin peralatan dan perangkat yang digunakan dalam proses display Produk Halal wajib bersih, higienis, aman dan tidak digunakan secara bergantian saat menangani Produk yang tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b28" value="m" id="3b28m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b28" value="tm" id="3b28tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3b28" value="tr" id="3b28tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3b28" type="text" class="form-control" placeholder="Catatan" id="3b28ca"/>
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
                                                                1.	Pelaku Usaha wajib memiliki dan menerapkan prosedur pelaksanaan Proses Produk Halal sebagai berikut :
                                                            </td>                                                                                                                                                          
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                a. Pemastian penggunaan fasilitas produksi yang kontak dengan Bahan dan/atau Produk antara/akhir bersifat bebas dari Najis berat (Mughalazah)
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1a" value="m" id="3c1am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1a" value="tm" id="3c1atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1a" value="tr" id="3c1atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1a" type="text" class="form-control" placeholder="Catatan" id="3c1aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                b. Pemastian penggunaan Bahan dan Produk yang diajukan tidak terkontaminasi Najis
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1b" value="m" id="3c1bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1b" value="tm" id="3c1btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1b" value="tr" id="3c1btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1b" type="text" class="form-control" placeholder="Catatan" id="3c1bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                c. Penyucian fasilitas produksi sesuai syariat Islam
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1c" value="m" id="3c1cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1c" value="tm" id="3c1ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1c" value="tr" id="3c1ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1c" type="text" class="form-control" placeholder="Catatan" id="3c1cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                d. Penggunaan Bahan baru yang akan digunakan untuk Produk Halal
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1d" value="m" id="3c1dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1d" value="tm" id="3c1dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1d" value="tr" id="3c1dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1d" type="text" class="form-control" placeholder="Catatan" id="3c1dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                e.	Pembelian Bahan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1e" value="m" id="3c1em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1e" value="tm" id="3c1etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1e" value="tr" id="3c1etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1e" type="text" class="form-control" placeholder="Catatan" id="3c1eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                f. Pemeriksaan kedatangan Bahan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1f" value="m" id="3c1fm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1f" value="tm" id="3c1ftm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1f" value="tr" id="3c1ftr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1f" type="text" class="form-control" placeholder="Catatan" id="3c1fca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                g. Proses produksi
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1g" value="m" id="3c1gm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1g" value="tm" id="3c1gtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1g" value="tr" id="3c1gtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1g" type="text" class="form-control" placeholder="Catatan" id="3c1gca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                h. Penyimpanan Bahan dan Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1h" value="m" id="3c1hm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1h" value="tm" id="3c1htm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1h" value="tr" id="3c1htr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1h" type="text" class="form-control" placeholder="Catatan" id="3c1hca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                i. Transportasi Bahan dan Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1i" value="m" id="3c1im" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1i" value="tm" id="3c1itm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1i" value="tr" id="3c1itr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1i" type="text" class="form-control" placeholder="Catatan" id="3c1ica"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                j.	Ketertelusuran kehalalan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1j" value="m" id="3c1jm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1j" value="tm" id="3c1jtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1j" value="tr" id="3c1jtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1j" type="text" class="form-control" placeholder="Catatan" id="3c1jca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                k. Penanganan Produk yang tidak memenuhi kriteria halal
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1k" value="m" id="3c1km" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1k" value="tm" id="3c1ktm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1k" value="tr" id="3c1ktr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1k" type="text" class="form-control" placeholder="Catatan" id="3c1kca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                l.	Penarikan Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1l" value="m" id="3c1lm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1l" value="tm" id="3c1ltm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1l" value="tr" id="3c1ltr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1l" type="text" class="form-control" placeholder="Catatan" id="3c1lca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                m. Peluncuran/penjualan Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1m" value="m" id="3c1mm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1m" value="tm" id="3c1mtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1m" value="tr" id="3c1mtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1m" type="text" class="form-control" placeholder="Catatan" id="3c1mca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                n.	Formulasi produk/pengembangan Produk baru
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1n" value="m" id="3c1nm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1n" value="tm" id="3c1ntm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1n" value="tr" id="3c1ntr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1n" type="text" class="form-control" placeholder="Catatan" id="3c1nca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                o. Display Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1o" value="m" id="3c1om" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1o" value="tm" id="3c1otm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1o" value="tr" id="3c1otr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1o" type="text" class="form-control" placeholder="Catatan" id="3c1oca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                p. Ketentuan pengunjung
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1p" value="m" id="3c1pm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1p" value="tm" id="3c1ptm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1p" value="tr" id="3c1ptr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1p" type="text" class="form-control" placeholder="Catatan" id="3c1pca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                q.	Penentuan menu
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1q" value="m" id="3c1qm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1q" value="tm" id="3c1qtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1q" value="tr" id="3c1qtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1q" type="text" class="form-control" placeholder="Catatan" id="3c1qca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                r. Pemingsanan hewan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1r" value="m" id="3c1rm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1r" value="tm" id="3c1rtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1r" value="tr" id="3c1rtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1r" type="text" class="form-control" placeholder="Catatan" id="3c1rca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                s. Penyembelihan hewan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1s" value="m" id="3c1sm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1s" value="tm" id="3c1stm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c1s" value="tr" id="3c1str" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c1s" type="text" class="form-control" placeholder="Catatan" id="3c1sca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha wajib mensosialisasikan prosedur Proses Produk Halal ke semua pihak yang terkait</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="m" id="3c2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="tm" id="3c2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c2" value="tr" id="3c2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c2" type="text" class="form-control" placeholder="Catatan" id="3c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha wajib memelihara bukti sosialisasi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="m" id="3c3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="tm" id="3c3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c3" value="tr" id="3c3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c3" type="text" class="form-control" placeholder="Catatan" id="3c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha wajib melakukan evaluasi efektifitas prosedur Proses Produk Halal secara berkala</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="m" id="3c4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="tm" id="3c4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c4" value="tr" id="3c4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c4" type="text" class="form-control" placeholder="Catatan" id="3c4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha wajib menyampaikan hasil evaluasi kepada penanggung jawab Proses Produk Halal dan pihak terkait</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="m" id="3c5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="tm" id="3c5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c5" value="tr" id="3c5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c5" type="text" class="form-control" placeholder="Catatan" id="3c5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha wajib menangani Produk yang tidak memenuhi kriteria halal dengan melakukan penarikan untuk mencegah Produk masuk kedalam rantai Proses Produk Halal serta melakukan pengendalian termasuk melakukan pengamanan dan pengawasan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="m" id="3c6m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="tm" id="3c6tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c6" value="tr" id="3c6tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c6" type="text" class="form-control" placeholder="Catatan" id="3c6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Pelaku Usaha wajib memiliki prosedur identifikasi, analisis bahaya ketidakhalalan dalam proses produksinya dan penetapan titik kritis serta menetapkan tindakan pencegahan dan monitoring terhadap titik kritis tersebut</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="m" id="3c7m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="tm" id="3c7tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c7" value="tr" id="3c7tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c7" type="text" class="form-control" placeholder="Catatan" id="3c7ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Pelaku Usaha wajib menetapkan tindakan koreksi dan tindakan pencegahan yang diperlukan terhadap hasil evaluasi serta batas waktu penyelesaiannya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="m" id="3c8m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="tm" id="3c8tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c8" value="tr" id="3c8tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c8" type="text" class="form-control" placeholder="Catatan" id="3c8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                9. Pelaku Usaha wajib menjamin prosedur pencucian Najis mughallazah yang masuk ke dalam jalur produksi halal sesuai dengan ketentuan syariat Islam sebagai berikut :
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="m" id="3c9m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="tm" id="3c9tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c9" value="tr" id="3c9tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c9" type="text" class="form-control" placeholder="Catatan" id="3c9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                10. Pelaku Usaha wajib harus menyiapkan diagram alir untuk Produk atau proses yang dicakup dalam Sistem Jaminan Produk Halal
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="m" id="3c10m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="tm" id="3c10tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb3c10" value="tr" id="3c10tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca3c10" type="text" class="form-control" placeholder="Catatan" id="3c10ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <!-- <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-danger float-right" id="btn_reset3">
                                                            </td>                                                                                                
                                                        </tr> -->
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
                                                            <td class="valign-middle">1. Pelaku Usaha wajib menghasilkan Produk dari Bahan halal, diproses dengan cara sesuai syariat Islam, menggunakan peralatan, fasilitas produksi, sistem pengemasan, penyimpanan, dan distribusi yang tidak terkontaminasi dengan Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="m" id="4a1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="tm" id="4a1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a1" value="tr" id="4a1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a1" type="text" class="form-control" placeholder="Catatan" id="4a1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha wajib menjamin Produk selama persiapan, pemrosesan, pengemasan, penyimpanan, dan pengangkutannya dipisahkan secara fisik dari Produk atau materi lain yang tidak halal sesuai dengan syariat Islam</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="m" id="4a2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="tm" id="4a2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a2" value="tr" id="4a2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a2" type="text" class="form-control" placeholder="Catatan" id="4a2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                3.	Pelaku Usaha tidak dapat melakukan sertifikasi halal terhadap Produk dengan :
                                                            </td>                                                                                                                                                        
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                a.	Nama Produk yang mengandung nama minuman keras
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3a" value="m" id="4a3am" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3a" value="tm" id="4a3atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3a" value="tr" id="4a3atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3a" type="text" class="form-control" placeholder="Catatan" id="4a3aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                b.	Nama Produk yang mengandung nama babi dan anjing serta turunannya,
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3b" value="m" id="4a3bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3b" value="tm" id="4a3btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3b" value="tr" id="4a3btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3b" type="text" class="form-control" placeholder="Catatan" id="4a3bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                c.	Nama Produk yang mengandung nama setan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3c" value="m" id="4a3cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3c" value="tm" id="4a3ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3c" value="tr" id="4a3ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3c" type="text" class="form-control" placeholder="Catatan" id="4a3cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                d.	Nama Produk yang mengarah kepada hal-hal yang menimbulkan kekufuran dan kebatilan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3d" value="m" id="4a3dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3d" value="tm" id="4a3dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3d" value="tr" id="4a3dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3d" type="text" class="form-control" placeholder="Catatan" id="4a3dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                e.	Nama Produk yang mengandung kata-kata yang berkonotasi erotis, vulgar dan/atau porno
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3e" value="m" id="4a3em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3e" value="tm" id="4a3etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a3e" value="tr" id="4a3etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a3e" type="text" class="form-control" placeholder="Catatan" id="4a3eca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha tidak dapat melakukan sertifikasi halal Produk dengan bentuk Produk hewan babi dan anjing. Bentuk Produk atau label kemasan yang sifatnya erotis, vulgar dan/atau porno</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="m" id="4a4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="tm" id="4a4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a4" value="tr" id="4a4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a4" type="text" class="form-control" placeholder="Catatan" id="4a4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha tidak dapat melakukan sertifikasi halal terhadap karakteristik/profil sensori Produk yang memiliki kecenderungan bau atau rasa yang mengarah kepada Produk haram atau yang telah dinyatakan haram berdasarkan ketetapan fatwa</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="m" id="4a5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="tm" id="4a5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a5" value="tr" id="4a5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4a5" type="text" class="form-control" placeholder="Catatan" id="4a5ca"/>
                                                            </td>                                                                                 
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha wajib menghasilkan Produk atau Bahan yang aman untuk dikonsumsi</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="m" id="4a6m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="tm" id="4a6tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4a6" value="tr" id="4a6tr" style="cursor: pointer;"/>
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
                                                            <td class="valign-middle">1. Pelaku Usaha wajib menggunakan Bahan pengemas yang tidak terbuat atau mengandung Bahan yang tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="m" id="4b1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="tm" id="4b1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b1" value="tr" id="4b1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b1" type="text" class="form-control" placeholder="Catatan" id="4b1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha wajib memastikan proses produksi Bahan pengemas menggunakan peralatan yang tidak terkontaminasi dengan  Najis dan Bahan tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="m" id="4b2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="tm" id="4b2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b2" value="tr" id="4b2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b2" type="text" class="form-control" placeholder="Catatan" id="4b2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha wajib memastikan Bahan pengemas tidak berbahaya bagi kesehatan manusia</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="m" id="4b3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="tm" id="4b3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b3" value="tr" id="4b3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b3" type="text" class="form-control" placeholder="Catatan" id="4b3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha wajib memisahkan Bahan pengemas selama persiapan, proses, penyimpanan, dan transportasi dari Produk atau materi lain yang tidak memenuhi persyaratan kehalalan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="m" id="4b4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="tm" id="4b4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b4" value="tr" id="4b4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b4" type="text" class="form-control" placeholder="Catatan" id="4b4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha wajib mengemas Produk Halal sesuai dengan isinya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="m" id="4b5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="tm" id="4b5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b5" value="tr" id="4b5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b5" type="text" class="form-control" placeholder="Catatan" id="4b5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">6. Pelaku Usaha wajib mengemas dengan menggunakan peralatan yang tidak terkontaminasi Najis dan sesuai persyaratan kebersihan, higenitas, keamanan, dan kualitas Produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="m" id="4b6m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="tm" id="4b6tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b6" value="tr" id="4b6tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b6" type="text" class="form-control" placeholder="Catatan" id="4b6ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">7. Pelaku Usaha wajib mengemas Produk karkas dengan menggunakan kemasan yang bersih, sehat, tidak berbau, tidak mempengaruhi kualitas dan keamanan daging</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="m" id="4b7m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="tm" id="4b7tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b7" value="tr" id="4b7tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b7" type="text" class="form-control" placeholder="Catatan" id="4b7ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">8. Pelaku Usaha wajib mendesain kemasan, tanda, simbol, logo, nama, dan gambar yang tidak menyesatkan dan/atau melanggar prinsip syariat Islam</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b8" value="m" id="4b8m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b8" value="tm" id="4b8tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b8" value="tr" id="4b8tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b8" type="text" class="form-control" placeholder="Catatan" id="4b8ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">9. Pelaku Usaha wajib memberi Label Halal dengan tepat sehingga bisa diidentifikasi dan dibedakan dari Produk yang tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b9" value="m" id="4b9m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b9" value="tm" id="4b9tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b9" value="tr" id="4b9tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b9" type="text" class="form-control" placeholder="Catatan" id="4b9ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">10. Pelaku Usaha wajib mencantumkan Label Halal pada Produk yang telah mendapat Sertifikat Halal pada : kemasan produk; bagian tertentu dari Produk; Tempat tertentu pada Produk</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b10" value="m" id="4b10m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b10" value="tm" id="4b10tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b10" value="tr" id="4b10tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b10" type="text" class="form-control" placeholder="Catatan" id="4b10ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">11. Pelaku Usaha wajib mencantumkan Label Halal pada tempat yang mudah dilihat dan dibaca, serta tidak mudah dihapus, dilepas, dan dirusak</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b11" value="m" id="4b11m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b11" value="tm" id="4b11tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b11" value="tr" id="4b11tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b11" type="text" class="form-control" placeholder="Catatan" id="4b11ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">12. Pelaku Usaha wajib mencantumkan Label Halal sesuai ketentuan yang ditetapkan oleh Badan Penyelenggara Jaminan Produk Halal dan tetap memperhatikan peraturan perundangan yang terkait Label sesuai dengan komoditinya</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b12" value="m" id="4b12m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b12" value="tm" id="4b12tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4b12" value="tr" id="4b12tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4b12" type="text" class="form-control" placeholder="Catatan" id="4b12ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle font-weight-bold">Penyimpanan, Display, Pelayanan, dan Penyajian</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                1. Pelaku Usaha wajib memberi identifikasi Produk yang disimpan seperti diantaranya tanggal masuk, lokasi penyimpanan, kode tempat penyimpanan, barcode, tanggal produksi, dan lainya sesuai ketentuan yang ditetapkan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="m" id="4c1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="tm" id="4c1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c1" value="tr" id="4c1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c1" type="text" class="form-control" placeholder="Catatan" id="4c1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">2. Pelaku Usaha wajib menyimpan Produk Halal terpisah secara fisik dari Produk yang tidak halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="m" id="4c2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="tm" id="4c2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c2" value="tr" id="4c2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c2" type="text" class="form-control" placeholder="Catatan" id="4c2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">3. Pelaku Usaha wajib menjamin Produk Halal bebas dari kontaminasi atau tercampur dengan Bahan yang tidak halal, selama proses penanganan dan penyimpanan</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="m" id="4c3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="tm" id="4c3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c3" value="tr" id="4c3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c3" type="text" class="form-control" placeholder="Catatan" id="4c3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">4. Pelaku Usaha tidak diperbolehkan menyajikan makanan dan minuman yang tidak halal termasuk menyajikan minuman beralkohol (Khusus Katering dan Restoran)</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="m" id="4c4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="tm" id="4c4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c4" value="tr" id="4c4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c4" type="text" class="form-control" placeholder="Catatan" id="4c4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">5. Pelaku Usaha wajib menerapkan aturan larangan bagi pengunjung dan karyawan membawa dan mengonsumsi makanan dan minuman yang tidak halal atau tidak jelas kehalalannya (Khusus Restoran).</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="m" id="4c5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="tm" id="4c5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4c5" value="tr" id="4c5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4c5" type="text" class="form-control" placeholder="Catatan" id="4c5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">d</td>
                                                            <td class="valign-middle font-weight-bold">Identifikasi dan Mampu Telusur</td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                1. Pelaku Usaha wajib menjamin ketertelusuran kehalalan Produk
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d1" value="m" id="4d1m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d1" value="tm" id="4d1tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d1" value="tr" id="4d1tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4d1" type="text" class="form-control" placeholder="Catatan" id="4d1ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                2. Pelaku Usaha wajib mempunyai prosedur terdokumentasi untuk menjamin ketertelusuran kehalalan Produk yang disertifikasi
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d2" value="m" id="4d2m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d2" value="tm" id="4d2tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d2" value="tr" id="4d2tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4d2" type="text" class="form-control" placeholder="Catatan" id="4d2ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                3. Pelaku Usaha wajib menjamin Bahan dengan kode yang sama mempunyai status halal yang sama bila menerapkan pengkodena Bahan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d3" value="m" id="4d3m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d3" value="tm" id="4d3tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d3" value="tr" id="4d3tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4d3" type="text" class="form-control" placeholder="Catatan" id="4d3ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                4. Pelaku Usaha wajib menjamin ketertelusuran informasi asal Bahan di setiap kegiatan
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d4" value="m" id="4d4m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d4" value="tm" id="4d4tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d4" value="tr" id="4d4tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4d4" type="text" class="form-control" placeholder="Catatan" id="4d4ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle">
                                                                5. Pelaku Usaha wajib menjamin tidak ada perubahan informasi Bahan (nama Produk, nama produsen, nama Bahan, negara produsen, dan Label Halal) pada saat melakukan pengemasan ulang
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d5" value="m" id="4d5m" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d5" value="tm" id="4d5tm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb4d5" value="tr" id="4d5tr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca4d5" type="text" class="form-control" placeholder="Catatan" id="4d5ca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <!-- <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-danger float-right" id="btn_reset4">
                                                            </td>                                                                                                
                                                        </tr>                                                                                                                -->
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
                                                            <td class="valign-middle">Pelaku Usaha wajib melakukan audit internal setiap enam bulan untuk memantau penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="m" id="5am" style="cursor: pointer;" required/>                                  
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="tm" id="5atm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5a" value="tr" id="5atr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5a" type="text" class="form-control" placeholder="Catatan" id="5aca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">b</td>
                                                            <td class="valign-middle">Pelaku Usaha wajib melakukan kaji ulang manajemen untuk mengevaluasi penerapan Sistem Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="m" id="5bm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="tm" id="5btm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5b" value="tr" id="5btr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5b" type="text" class="form-control" placeholder="Catatan" id="5bca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">c</td>
                                                            <td class="valign-middle">
                                                                Pelaku Usaha wajib memiliki prosedur audit internal dan kaji ulang manajemen
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="m" id="5cm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="tm" id="5ctm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5c" value="tr" id="5ctr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5c" type="text" class="form-control" placeholder="Catatan" id="5cca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">d</td>
                                                            <td class="valign-middle">Pelaku Usaha wajib memelihara bukti pelaksanaan audit internal dan kaji ulang manajemen harus dipelihara</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="m" id="5dm" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="tm" id="5dtm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5d" value="tr" id="5dtr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5d" type="text" class="form-control" placeholder="Catatan" id="5dca"/>
                                                            </td>                                                                                                
                                                        </tr>
                                                        <tr>
                                                            <td class="valign-middle text-center">e</td>
                                                            <td class="valign-middle">Pelaku Usaha wajib melaporkan hasil audit internal dan kaji ulang manajemen sesuai ketentuan dari Badan Penyelenggara Jaminan Produk Halal</td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="m" id="5em" style="cursor: pointer;" required/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="tm" id="5etm" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle text-center">
                                                                <div class="radio">
                                                                    <input type="radio" name="rb5e" value="tr" id="5etr" style="cursor: pointer;"/>
                                                                </div>
                                                            </td>
                                                            <td class="valign-middle">
                                                                <input name="ca5e" type="text" class="form-control" placeholder="Catatan" id="5eca"/>
                                                            </td>                                                                                 
                                                        </tr>
                                                        <!-- <tr>
                                                            <td class="valign-middle text-center"></td>
                                                            <td class="valign-middle font-weight-bold">Reset</td>                                                            
                                                            <td class="valign-middle" colspan="4">
                                                                <input type="button" value="Reset Semua Data" class="btn btn-sm btn-danger float-right" id="btn_reset5">
                                                            </td>                                                                                                 -->
                                                        </tr>                                                                                                               
                                                </tbody>
                                            </table>
                                            
                                            {{-- <div class="wrapper col-lg-12">
                                                <div class="row">
                                                    @component('components.inputtextarea',['name'=> 'kesimpulan','label' => 'Kesimpulan','required'=>true,'placeholder'=>'Kesimpulan'])@endcomponent
                                                </div>
                                            </div> --}}
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
                            <form action="{{route('downloadlaporanaudittahap2fix2')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            {{-- @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent --}}
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">
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
                                                    <input type="text" id="tanggal_audit_" name="tanggal_audit_" class="form-control" placeholder="Tanggal Akhir" value="" data-date-start-date="Date.default" required/>
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
                                            @component('components.inputtext',['name'=> 'nama_organisasi','label' => 'Nama Pelaku Usaha','required'=>true,'placeholder'=>'Nama Pelaku Usaha','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_usaha','label' => 'Nama Usaha/Merk Dagang','required'=>true,'placeholder'=>'Nama Usaha','readonly'=>true,'value'=>$value->nama_merk_produk])@endcomponent
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
                                                <select id="tujuan_audit" name="tujuan_audit" class="form-control" data-size="10" data-live-search="true" data-style="btn-white" required>
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
                                            @component('components.inputtextarea',['name'=> 'jenis_produk2','label' => 'Jenis Produk & Kode Klasifikasi','required'=>true,'placeholder'=>'Jenis Produk & Kode Klasifikasi','readonly'=>true,'value'=>$value->rincian_jenis_produk])@endcomponent
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
                                            if(isset($value2->pelaksana2_audit2)){
                                                $anggota_arr = explode("_",$value2->pelaksana2_audit2);
                                                $anggota = $anggota_arr[1];
                                            }
                                            $ketua = $ketua_arr[1];
                                        @endphp
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'ketua_tim','label' => 'Ketua Tim','required'=>true,'placeholder'=>'Tim Audit 1 (XX)','readonly'=>true,'value'=>$ketua])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @if(isset($value2->pelaksana2_audit2)){
                                                    @component('components.inputtext',['name'=> 'tim_audit1','label' => 'TIm Audit','required'=>true,'placeholder'=>'Tim Audit 2 (YY)','readonly'=>true,'value'=>$anggota])@endcomponent
                                                @else
                                                    @component('components.inputtext',['name'=> 'tim_audit1','label' => 'TIm Audit','required'=>true,'placeholder'=>'Tim Audit 2 (YY)','readonly'=>true])@endcomponent
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
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'pimpinan_perusahaan','label' => 'Pimpinan Perusahaan','required'=>true,'placeholder'=>'Pimpinan Perusahaan'])@endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>I. DESKRIPSI PERUSAHAAN/ PELAKU USAHA</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-8"><div><textarea class="form-control" name="deskripsi_perusahaan" label="Deskripsi Perusahaan" placeholder="Deskripsi Perusahaan" required></textarea></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>II. GAMBARAN UMUM PROSES PRODUKSI HALAL</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-8"><div><textarea class="form-control" name="narasi_halal" label="Narasi" placeholder="Narasi" required></textarea></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Flowchart/ Bagan Alir</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="flowchart" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>III. DAFTAR FASILITAS</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Fasilitas</label><div class="col-lg-8"><div><input class="form-control" name="nama_fasilitas[]" type="text" label="Nama Fasilitas" placeholder="Nama Fasilitas" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Fungsi</label><div class="col-lg-8"><div><input class="form-control" name="fungsi[]" type="text" label="Fungsi" placeholder="Fungsi" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" name="alamat_fasilitas[]" label="Alamat Fasilitas" placeholder="Alamat Fasilitas" required></textarea></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan8" id="detail_kegiatan{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a onClick="addDataKegiatan8({{$value->id}})" class="btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>IV. DAFTAR PRODUK</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Produk/Menu - Merk</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk" placeholder="Nama Produk" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Foto Produk</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="foto_data_produk[]" accept="image/*" required>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Jenis Produk</label>
                                                    <div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Rincian Jenis Produk</label>
                                                    <div class="col-lg-8"><div><input class="form-control" name="rincian_jenis_produk[]" type="text" label="Rincian Jenis Produk" placeholder="Rincian Jenis Produk" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                      
                                </div>                                
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan9" id="detail_kegiatan9{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a onClick="addDataKegiatan9({{$value->id}})" class="btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>V. DAFTAR BAHAN</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Nama Bahan Bentuk/Warna/Rasa/Merk</label><div class="col-lg-8"><div><input class="form-control" name="nama_bahan[]" type="text" label="Nama Bahan" placeholder="Nama Bahan Bentuk/Warna/Rasa/Merk" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">                                                    
                                                    {{-- <div class="col-lg-8"><div><input class="form-control" name="kategori[]" type="text" label="Kategori" placeholder="Kategori"></div></div>
                                                     --}}
                                                     <label class="col-lg-4 col-form-label">Kategori</label>
                                                     <div class="col-lg-8">
                                                        <select id="kategori" name="kategori[]" class="form-control" data-size="10" data-live-search="true" data-style="btn-white" required>
                                                            <option value="Kritis harus SH">
                                                                Kritis harus SH
                                                            </option>
                                                            <option value="Kritis tidak harus SH">
                                                                Kritis tidak harus SH
                                                            </option>
                                                            <option value="Tidak kritis">
                                                                Tidak kritis
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Produsen</label><div class="col-lg-8"><div><input class="form-control" name="produsen[]" type="text" label="Produsen" placeholder="Produsen" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>           
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Dokumen Pendukung</label><div class="col-lg-8"><div><input class="form-control" name="dokumen_pendukung[]" type="text" label="Dokumen Pendukung" placeholder="Dokumen Pendukung" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Komentar" placeholder="Masa Berlaku" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_kegiatan10" id="detail_kegiatan10{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a onClick="addDataKegiatan10({{$value->id}})" class="btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                             
                                <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                    <thead>
                                        <tr>                                                            
                                            <td colspan="6" class="valign-middle font-weight-bold">
                                                VI. KRITERIA SISTEM JAMINAN HALAL
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
                                                <td class="valign-middle text-center">1</td>
                                                <td class="valign-middle">Kebijakan Halal</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkebijakanhalal" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkebijakanhalal" value="tidak memenuhi" style="cursor: pointer;"/>
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
                                                        <input type="radio" name="rbtimmanajemenhalal" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbtimmanajemenhalal" value="tidak memenuhi" style="cursor: pointer;"/>
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
                                                        <input type="radio" name="rbpelatihanedukasi" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpelatihanedukasi" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="capelatihanedukasi" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>                                            
                                            <tr>
                                                <td class="valign-middle text-center">4</td>
                                                <td class="valign-middle">Bahan</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbahan" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbbahan" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cabahan" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>      
                                            <tr>
                                                <td class="valign-middle text-center">5</td>
                                                <td class="valign-middle">Produk</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbproduk" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbproduk" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="caproduk" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>                                      
                                            <tr>
                                                <td class="valign-middle text-center">6</td>
                                                <td class="valign-middle">Fasilitas Produksi</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbfasilitasproduksi" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbfasilitasproduksi" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cafasilitasproduksi" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">7</td>
                                                <td class="valign-middle">Prosedur Tertulis Untuk Aktifitas Kritis</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbprosedurtertulis" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbprosedurtertulis" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="caprosedurtertulis" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">8</td>
                                                <td class="valign-middle">Kemampuan Telusur</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkemampuantelusur" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkemampuantelusur" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cakemampuantelusur" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>  
                                            <tr>
                                                <td class="valign-middle text-center">9</td>
                                                <td class="valign-middle">Penanganan Produk Tidak Memenuhi Kriteria</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpenangananproduk" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbpenangananproduk" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="capenangananproduk" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>                                                                                      
                                            <tr>
                                                <td class="valign-middle text-center">10</td>
                                                <td class="valign-middle">Audit Internal</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbauditinternal" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbauditinternal" value="tidak memenuhi" style="cursor: pointer;"/>
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
                                                        <input type="radio" name="rbkajiulang" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbkajiulang" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="cakajiulang" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">12</td>
                                                <td class="valign-middle">Manual SJH</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbksjh" value="memenuhi" style="cursor: pointer;" required/>
                                                    </div>
                                                </td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input type="radio" name="rbsjh" value="tidak memenuhi" style="cursor: pointer;"/>
                                                    </div>
                                                </td>                                                
                                                <td class="valign-middle">
                                                    <input name="casjh" type="text" class="form-control" placeholder="Keterangan"/>
                                                </td>                                                                                                
                                            </tr>
                                            <tr>                                                
                                                <td colspan="2" class="valign-middle">Kesimpulan</td>                                                
                                                {{-- <td class="valign-middle" colspan="3">
                                                    <input name="kesimpulan" type="text" class="form-control" placeholder="Kesimpulan"/>
                                                </td> --}}
                                                <td class="valign-middle" colspan="3">
                                                    <div class="input-group date">           
                                                        <div class="radio radio-css radio-inline">                                         
                                                            <input type="radio" name="kesimpulan" value="memenuhi" id="kesimpulan1" style="cursor: pointer;" required/>
                                                            <label for="kesimpulan1">Sidang komisi fatwa dapat dilaksanakan setelah semua tindak lanjut temuan sudah dinyatakan memenuhi</label>
                                                        </div>
                                                        <br>
                                                        <div class="radio radio-css radio-inline">                                         
                                                            <input type="radio" name="kesimpulan" value="tidak_memenuhi" id="kesimpulan2" style="cursor: pointer;"/>
                                                            <label for="kesimpulan2">Sidang komisi fatwa dapat dilaksanakan</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>                                            
                                    </tbody>
                                </table>

                                <table class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%; ">
                                    <thead>
                                        <tr>                                                            
                                            <td colspan="6" class="valign-middle font-weight-bold">
                                                DAFTAR LAMPIRAN
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="2%" class="  valign-middle text-center">No</th>
                                            <th width="50%" class=" valign-middle text-center">Kegiatan</th>
                                            <th width="5%" class="  valign-middle text-center">Jenis</th>
                                            <th width="43%" class="  valign-middle text-center">Dokumentasi</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                                                                                
                                            <tr>
                                                <td class="valign-middle text-center">1</td>
                                                <td class="valign-middle">Tampak Luar Lokasi Produksi</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <input id="file" name="foto1" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input id="video3" name="video1" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">2</td>
                                                <td class="valign-middle"><i>Opening Meeting</i></td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <input id="file" name="foto2" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input id="video2" name="video2" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">3</td>
                                                <td class="valign-middle">Kebijakan Halal</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <input id="file" name="foto3" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input id="video3" name="video3" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">4</td>
                                                <td class="valign-middle">Bahan (aktivitas verifikasi bahan)</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <input id="file" name="foto4" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">
                                                    <div class="radio">
                                                        <input id="video4" name="video4" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......" />
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">5</td>
                                                <td class="valign-middle">Fasilitas Produksi</td>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle text-center"></td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">a. Penerimaan/penyimpanan bahan</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5a" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5a" name="video5a" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">b. Tempat proses produksi (proses dari bahan baku sampai produk yang telah dikemas)</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5b" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5b" name="video5b" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">c. Peralatan produksi (kuas, mesin, kompor, dll)</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5c" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5c" name="video5c" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">d. Area fasilitas produksi</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5d" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5d" name="video5d" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">e. Tempat pencucian bahan & alat produksi</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5e" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5e" name="video5e" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">f. Penyimpanan produk</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5f" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5f" name="video5f" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">g. Label/ tanda fasilitas hanya diperuntukkan untuk produksi produk halal (sharing facility)</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5g" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5g" name="video5g" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">h. Tempat penyajian</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5h" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5h" name="video5h" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle">i. Media Transportasi/Distribusi</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto5i" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video5i" name="video5i" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">6</td>
                                                <td class="valign-middle">Video Proses Produksi (ada/tidak ada)*</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto6" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video6" name="video6" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">7</td>
                                                <td class="valign-middle">Mampu Telusur (bon pembelian, bon penjualan)</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto7" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video7" name="video7" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center">8</td>
                                                <td class="valign-middle">Closing Meeting</td>
                                                <td class="valign-middle text-center">Foto</td>
                                                <td class="valign-middle text-center">
                                                    <input id="file" name="foto8" class="form-control" type="file" class="form-control" accept="image/*"/>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td class="valign-middle text-center"></td>
                                                <td class="valign-middle"></td>
                                                <td class="valign-middle text-center">Video</td>
                                                <td class="valign-middle text-center">                                                    
                                                    <div class="radio">
                                                        <input id="video8" name="video8" class="form-control" type="text" class="form-control" placeholder="Link Google Drive Contoh: drive.google.com/......"/>
                                                    </div>
                                                </td>
                                            </tr>
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
                        <div class="tab-pane fade" id="card-tab-8">
                            <form action="{{route('downloadketidaksesuaianfix')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf                                
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent                                        
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            {{-- @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent --}}
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'nama_organisasi','label' => 'Nama Perusahaan','required'=>true,'placeholder'=>'Nama Perusahaan','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent                                            
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'no_id_bpjph','label' => 'No ID BPJPH','required'=>true,'placeholder'=>'No ID BPJPH','readonly'=>true,'value'=>$value->no_registrasi_bpjph])@endcomponent
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'standar_acuan','label' => 'Standar/Acuan','required'=>true,'placeholder'=>'Standar/Acuan'])@endcomponent
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
                                        <div class="wrapper col-lg-12" style="display: none">
                                            <div class="row">
                                                @component('components.inputtext',['name'=> 'ketua_tim','label' => 'Ketua Tim','required'=>true,'placeholder'=>'Ketua Tim','readonly'=>true,'value'=>$ketua])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @if(isset($value2->pelaksana2_audit2))
                                                    @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$ketua.' dan '.$anggota])@endcomponent
                                                @else
                                                    @component('components.inputtext',['name'=> 'nama_auditor','label' => 'Nama Auditor','required'=>true,'placeholder'=>'Nama Auditor','readonly'=>true,'value'=>$ketua])@endcomponent
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
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
                                                    <input type="text" id="tanggal_audit_2" name="tanggal_audit_" class="form-control" placeholder="Tanggal Akhir" value="" data-date-start-date="Date.default" required/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tanggal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        </div>
                                    </div>                                                                                                                                       --}}
                                </div>                                                                
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-12 col-form-label"><b>KETIDAKSESUAIAN</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Klausul</label><div class="col-lg-8"><div><input class="form-control" name="klausul[]" type="text" label="Klausul" placeholder="Klausul" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Auditor</label>
                                                    <div class="col-lg-8"><div><input class="form-control" name="auditor[]" type="text" label="Auditor" placeholder="Auditor" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Deskripsi</label>
                                                    <div class="col-lg-8"><div><textarea class="form-control" name="deskripsi[]" label="Deskripsi" placeholder="Deskripsi" required></textarea></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Investigasi Akar Permasalahan</label><div class="col-lg-8"><div><input class="form-control" name="investigasi[]" type="text" label="Investasi Akar Permasalahan" placeholder="Investigasi Akar Permasalahan" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Tindakan Perbaikan dan Pencegahan</label><div class="col-lg-8"><div><input class="form-control" name="tindakan[]" type="text" label="Tindakan Perbaikan dan Pencegahan" placeholder="Tindakan Perbaikan dan Pencegahan" required></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">                                            
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Hasil Tinjauan Tim Audit</label>
                                                    <div class="col-lg-8"><div>
                                                        <select name="hasil[]" class="form-control">
                                                            <option value="open">Open</option>
                                                            <option value="close">Close</option>
                                                        </select>                                                        
                                                    </div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">                                                                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div id="detail_kegiatan_ketidaksesuaian{{$value->id}}" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a onClick="addDataKetidaksesuaian({{$value->id}})" class="btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah</a>
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
                    </div>
                </div>
                
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
    <div id="modalLaporanAudit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Laporan Audit Tahap 2</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_laporan2" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalSuratTugas" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload Surat Tugas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_surattugas" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalLaporanAuditUlang" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload Perbaikan File Laporan Audit Tahap 2</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_laporan2_ulang" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalChecklistAudit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Checklist Audit</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_checklist" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalKetidaksesuaian" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Laporan Ketidaksesuaian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_ketidaksesuaian" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalKetidaksesuaian2" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Laporan Ketidaksesuaian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_ketidaksesuaian2" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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

    <div id="modalBAP" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Berita Acara Pemeriksaan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control" id="no" name="no" value="4" readonly />
                                @foreach($dataRegistrasi as $index => $value)               
                                    <input type="text" class="form-control" id="noregis" name="noregis" value="{{$value->no_registrasi}}" readonly />
                                    <input type="text" class="form-control" id="idregis" name="idregis" value="{{$value->id}}" readonly />
                                @endforeach                        								                                
                            </div>
                                                      
                            <div class="form-group">
                                <label>Berkas</label>
                                <input id="file" name="berkas_bap" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
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
    <script>        
        var jmlKegiatan8 = 0;
        var jmlKegiatan9 = 0;
        var jmlKegiatan10 = 0;        
        var noKegiatan8 = 1;
        var noKegiatan9 = 1;
        var noKegiatan10 = 1;
        var jmlAnggota = 1;
        var noAnggota = 1;

        var jmlKetidaksesuaian = 0;
        var noKetidaksesuaian = 1;                

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

        function addDataKegiatan8($id){                        
            noKegiatan8 += 1;
            jmlKegiatan8+=1;               
            var data_kegiatan8 = '<div id="kegiatan'+jmlKegiatan8+'" style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;">                    <div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Fasilitas</label><div class="col-lg-8"><div><input class="form-control" name="nama_fasilitas[]" type="text" label="Nama Fasilitas" placeholder="Nama Fasilitas" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Fungsi</label><div class="col-lg-8"><div><input class="form-control" name="fungsi[]" type="text" label="Fungsi" placeholder="Fungsi" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Alamat</label><div class="col-lg-8"><div><textarea class="form-control" name="alamat_fasilitas[]" label="Alamat Fasilitas" placeholder="Alamat Fasilitas" required></textarea></div></div></div></div></div></div>                    <div class="col-lg-12"><div><a onClick="hapusKegiatan('+$id+','+jmlKegiatan8+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div></div>';
            $('#detail_kegiatan'+$id).append(data_kegiatan8);            
        }

        function addDataKegiatan9($id){            
            noKegiatan9 += 1;
            jmlKegiatan9 +=1;                        
            var data_kegiatan9 = '<div id="kegiatan9'+jmlKegiatan9+'" style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Produk</label><div class="col-lg-8"><div><input class="form-control" name="nama_produk[]" type="text" label="Nama Produk/Menu - Merk" placeholder="Nama Produk/Menu - Merk" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Foto Produk</label><div class="col-lg-8"><input type="file" class="form-control" name="foto_data_produk[]" accept="image/*" required></div></div></div>                <div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="jenis_produk[]" type="text" label="Jenis Produk" placeholder="Jenis Produk" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Rincian Jenis Produk</label><div class="col-lg-8"><div><input class="form-control" name="rincian_jenis_produk[]" type="text" label="Rincian Jenis Produk" placeholder="Rincian Jenis Produk" required></div></div></div></div></div></div>                <div class="col-lg-12"><div><a onClick="hapusKegiatan2('+$id+','+jmlKegiatan9+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> </div>';
            $('#detail_kegiatan9'+$id).append(data_kegiatan9);
        }
                
        function addDataKegiatan10($id){            
            noKegiatan10 += 1;
            jmlKegiatan10 +=1;            
            var data_kegiatan10 = '<div id="kegiatan10'+jmlKegiatan10+'" style="margin-bottom:2px; background: rgb(242, 242, 242);"> <div class="panel-body panel-form" style="border-top: 1px solid #bbb;"><div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Nama Bahan Bentuk/Warna/Rasa/Merk</label><div class="col-lg-8"><div><input class="form-control" name="nama_bahan[]" type="text" label="Nama Bahan" placeholder="Nama Bahan Bentuk/Warna/Rasa/Merk" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-lg-4 col-form-label">Kategori</label><div class="col-lg-8"><select id="kategori" name="kategori[]" class="form-control" data-size="10" data-live-search="true" data-style="btn-white" required><option value="Kritis harus SH">Kritis harus SH</option><option value="Kritis tidak harus SH">Kritis tidak harus SH</option><option value="Tidak kritis">Tidak kritis</option></select></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Produsen</label><div class="col-lg-8"><div><input class="form-control" name="produsen[]" type="text" label="Produsen" placeholder="Produsen" required></div></div></div></div></div></div>           <div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Dokumen Pendukung</label><div class="col-lg-8"><div><input class="form-control" name="dokumen_pendukung[]" type="text" label="Dokumen Pendukung" placeholder="Dokumen Pendukung" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Catatan</label><div class="col-lg-8"><div><input class="form-control" name="catatan[]" type="text" label="Catatan" placeholder="Catatan" required></div></div></div></div></div></div> <div class="col-lg-12"><div><a onClick="hapusKegiatan3('+$id+','+jmlKegiatan10+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> <br></div>';
            $('#detail_kegiatan10'+$id).append(data_kegiatan10);
        }

        function addDataKetidaksesuaian($id){
            noKetidaksesuaian += 1;
            jmlKetidaksesuaian +=1;            
            var data_kegiatan_ketidaksesuaian = '<div id="kegiatanketidaksesuaian'+jmlKetidaksesuaian+'" style="margin-bottom:2px; background: rgb(242, 242, 242);">  <div class="wrapper col-lg-12"><div class="row"><div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Klausul</label><div class="col-lg-8"><div><input class="form-control" name="klausul[]" type="text" label="Klausul" placeholder="Klausul" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Auditor</label><div class="col-lg-8"><div><input class="form-control" name="auditor[]" type="text" label="Auditor" placeholder="Auditor" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Deskripsi</label><div class="col-lg-8"><div><textarea class="form-control" name="deskripsi[]" label="Deskripsi" placeholder="Deskripsi" required></textarea></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Investigasi Akar Permasalahan</label><div class="col-lg-8"><div><input class="form-control" name="investigasi[]" type="text" label="Investasi Akar Permasalahan" placeholder="Investigasi Akar Permasalahan" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Tindakan Perbaikan dan Pencegahan</label><div class="col-lg-8"><div><input class="form-control" name="tindakan[]" type="text" label="Tindakan Perbaikan dan Pencegahan" placeholder="Tindakan Perbaikan dan Pencegahan" required></div></div></div></div></div></div><div class="wrapper col-lg-12"><div class="row">                                            <div class="col-lg-12"><div class="row"><label class="col-4 col-form-label">Hasil Tinjauan Tim Audit</label><div class="col-lg-8"><div><select name="hasil[]" class="form-control"><option value="open">Open</option><option value="close">Close</option></select>                                                        </div></div></div></div></div></div><div class="col-lg-12"><div><a onClick="hapusKetidaksesuaian('+$id+','+jmlKetidaksesuaian+')" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div> <br></div>';
            // var data_kegiatan_ketidaksesuaian = 'disini';
            $('#detail_kegiatan_ketidaksesuaian'+$id).append(data_kegiatan_ketidaksesuaian);
        }                

        function hapusKegiatan($id,$jml){            
            var select1 = document.getElementById('detail_kegiatan'+$id);
            var select2 = document.getElementById('kegiatan'+$jml);
            select1.removeChild(select2);                        
        }

        function hapusKegiatan2($id,$jml){            
            var select1 = document.getElementById('detail_kegiatan9'+$id);
            var select2 = document.getElementById('kegiatan9'+$jml);
            select1.removeChild(select2);            
        }

        function hapusKegiatan3($id,$jml){            
            var select1 = document.getElementById('detail_kegiatan10'+$id);
            var select2 = document.getElementById('kegiatan10'+$jml);
            select1.removeChild(select2);            
        }

        function hapusKetidaksesuaian($id,$jml){            
            var select1 = document.getElementById('detail_kegiatan_ketidaksesuaian'+$id);
            var select2 = document.getElementById('kegiatanketidaksesuaian'+$jml);
            select1.removeChild(select2);                        
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

        $(document).ready(
            function() {

                $('#tanggal_audit').datepicker({
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#tanggal_audit_').datepicker({                    
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#tanggal_audit2').datepicker({
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#tanggal_audit_2').datepicker({                    
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });

                $('#tgl_audit').datepicker({
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                });
                
            }
        );
    </script>
@endpush