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
                        <li class="nav-item text-center">
                            <a class="nav-link active" data-toggle="tab" href="#card-tab-1">Laporan SJPH</a>
                        </li>                    
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-2">Laporan Bahan</a>
                        </li>                                    
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-3">Laporan Bahan</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-4">Laporan Bahan</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-5">Laporan Bahan</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-6">Laporan Bahan</a>
                        </li>
                        <li class="nav-item text-center">                        
                            <a class="nav-link" data-toggle="tab" href="#card-tab-7">Laporan Bahan</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body table-responsive-lg ">
					<div class="tab-content p-0 m-0">
                        <div class="tab-pane fade active show" id="card-tab-1">
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
                            3
                        </div>
                        <div class="tab-pane fade" id="card-tab-4">
                            4
                        </div>
                        <div class="tab-pane fade" id="card-tab-5">
                            5
                        </div>
                        <div class="tab-pane fade" id="card-tab-6">
                            6
                        </div>
                        <div class="tab-pane fade" id="card-tab-7">
                            7
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
        detailkegiatan.style.display = 'none';
        detailkegiatan2.style.display = 'none';

        var jmlKegiatan = 0;
        var jmlKegiatan2 = 0;
        var noKegiatan = 1;
        var noKegiatan2 = 1;

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

        $('#tgl_audit').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
    </script>
@endpush