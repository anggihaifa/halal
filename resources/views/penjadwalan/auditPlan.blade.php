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
                            <form action="{{route('downloadauditplan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body panel-form" style="display: none">
                                    @foreach($dataRegistrasi as $index => $value)
                                        @component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$value->id])@endcomponent
                                        @component('components.inputtext',['name'=> 'jenis_audit','label' => 'Jenis Audit','required'=>true,'placeholder'=>'Jenis Audit','readonly'=>true,'value'=>$value->status_registrasi])@endcomponent
                                        @component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Organisasi','required'=>true,'placeholder'=>'Nama Organisasi','readonly'=>true,'value'=>$value->nama_perusahaan])@endcomponent
                                        @component('components.inputtext',['name'=> 'alamat_perusahaan','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat])@endcomponent
                                        @foreach($dataPenjadwalan as $index => $value2)
                                            @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                            @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit2." s/d ".$value2->selesai_audit2])@endcomponent
                                        @endforeach
                                    @endforeach                        
                                </div>
                                <div class="form-group row">   
                                    <div class="row col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info offset-md-9">Download Format Audit Plan</button>
                                    </div>
                                </div>
                            </form>
                            @foreach($dataPenjadwalan as $index => $value2)
                                @if($value2->berkas_audit_plan != null)
                                    <div class="panel-body panel-form">
                                        <div class="wrapper col-lg-12">
                                            <div class="row">                                                
                                                <label class="col-lg-4 col-form-label"><b>Berkas Audit Plan</b></label>
                                                <div id="shb" class="col-lg-8">
                                                    <div class="input-group date">                                                        
                                                        <a class="form-control" href="{{url('') .Storage::url('docx/upload/'.$value2->berkas_audit_plan) }}" download>{{$value2->berkas_audit_plan}}</a>
                                                    </div>
                                                </div>                                                                                                    
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <form action="{{route('uploadauditplan')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
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
                            </form>
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
                                                @component('components.inputtext',['name'=> 'alamat_perusahaan','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$value->alamat])@endcomponent
                                            </div>
                                        </div>
                                        <div class="wrapper col-lg-12">
                                            <div class="row">
                                                @foreach($dataPenjadwalan as $index => $value2)
                                                    @component('components.inputtext',['name'=> 'id_penjadwalan','label' => 'ID Penjadwalan','required'=>true,'placeholder'=>'ID Penjadwalan','readonly'=>true,'value'=>$value2->id])@endcomponent
                                                    @component('components.inputtext',['name'=> 'tanggal_audit','label' => 'Tangal Audit','required'=>true,'placeholder'=>'Tanggal Audit','readonly'=>true,'value'=>$value2->mulai_audit1." s/d ".$value2->selesai_audit2])@endcomponent
                                                @endforeach
                                            </div>
                                        </div>                            
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
                                            @component('components.inputtext',['name'=> 'no_audit','label' => 'No Audit','required'=>true,'placeholder'=>'No Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tujuan_audit','label' => 'Tujuan Audit','required'=>true,'placeholder'=>'Tujuan Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'standar','label' => 'Standar','required'=>true,'placeholder'=>'Standar'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'lingkup_audit','label' => 'Lingkup Audit','required'=>true,'placeholder'=>'Lingkup Audit'])@endcomponent
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'jenis_produk','label' => 'Jenis Produk & Kode Klasifikasi','required'=>true,'placeholder'=>'Jenis Produk & Kode Klasifikasi'])@endcomponent
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
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            @component('components.inputtext',['name'=> 'tim_audit3','label' => '','required'=>true,'placeholder'=>'Tim Audit 3'])@endcomponent
                                        </div>
                                    </div>                                            
                                </div>
                                <div class="panel-body panel-form" style="background: rgb(230, 235, 236);">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label"><b>Tanggal Audit</b></label>
                                            <div id="shb" class="col-lg-8">
                                                <div class="input-group date">
                                                    <input type="text" id="tgl_audit1" name="tgl_audit[]" class="form-control" placeholder="Tanggal Audit" value="" data-date-start-date="Date.default" />
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
                                                    <input id="jam_audit1" name="jam_audit[]" type='text' class="form-control" placeholder="Jam Audit"/>
                                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>                        
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Detail Kegiatan</label>
                                            <div class="col-lg-8"><div>
                                                <textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea>
                                            </div></div>                                
                                        </div>
                                    </div>
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil"></div></div>                                
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
                                            <div class="detail_kegiatan" id="detail_kegiatan" style="width: 100%; background: #fff;"></div>
                                            <div class="col-md-12">
                                                <a id="tam_detail_kegiatan" class="tam_detail_kegiatan btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah Kegiatan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body panel-form">
                                    <div class="wrapper col-lg-12">
                                        <div class="row">
                                            <div class="detail_hari" id="detail_hari" style="width: 100%; background: #fff;"></div>                                
                                            <div class="col-md-12">                                    
                                                <a id="tam_detail_hari" class="tam_detail_hari btn btn-sm btn-info m-r-5 float-right" style="color:white; min-width: 125px;">Tambah Hari</a>
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
@endsection
@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script>                
        var detailkegiatan = document.getElementById('detail_kegiatan');
        var detailhari = document.getElementById('detail_hari');                

        detailkegiatan.style.display = 'none';
        detailhari.style.display = 'none';

        var jmlKegiatan = 0;
        var noKegiatan = 1;

        var jmlHari = 0;        
        var noHari = 1;

        var jmlDetail = 1;
        var jmlJam = 0;
        var jmlTgl = 0;

        $('#tam_detail_kegiatan').on('click', function(){
            // alert("disini");
            detailkegiatan.style.display = 'block';
            noKegiatan += 1;
            addDataKegiatan();
        });        

        document.getElementById('jml_kegiatan1').value = 1;
        function addDataKegiatan(){
            jmlKegiatan+=1;
            jmlJam+=1;
            var data_kegiatan = '<div style="background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-8"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil"></div></div>                                </div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
            $('.detail_kegiatan').append(data_kegiatan);            
            jam(jmlJam);                                    
            document.getElementById('jml_kegiatan1').value = jmlKegiatan + 1;
            // alert(jmlKeg);
        }

        $(document).on('click','#hapus_datakegiatanlain', function(){
            $(this).parent().parent().parent().remove();
            jmlKegiatan-=1;
            noKegiatan-=1;

            document.getElementById('jml_kegiatan1').value = jmlKegiatan + 1;

            if(jmlKegiatan == 0){
                detailkegiatan.style.display = 'none';
            }
        });

        $('#tam_detail_hari').on('click', function(){
            // alert("disini");
            detailhari.style.display = 'block';
            noHari += 1;
            addDataHari();
        }); 

        function addDataHari(){
            jmlDetail+=1;
            jmlJam+=1;
            jmlTgl+=1;
            var data_hari = '<div>  <div class="panel-body panel-form" style="background: rgb(230, 235, 236);"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-4 col-form-label"><b>Tanggal Audit</b></label><div id="shb" class="col-lg-8"><div class="input-group date"><input type="text" id="tgl_audit'+(jmlTgl+1)+'" name="tgl_audit[]" class="form-control" placeholder="Tanggal Audit" value="" data-date-start-date="Date.default" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-8"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil"></div></div>                                </div></div</div><div class="panel-body panel-form"><div class="wrapper col-lg-12" style="display:none"><div class="row"><label class="col-4 col-form-label">Jumlah Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="jumlah_kegiatan[]" type="text" label="Jumlah Kegiatan" placeholder="Jumlah Kegiatan" value="1" id="jml_kegiatan'+jmlDetail+'"></div></div></div></div><div class="wrapper col-lg-12"><div class="row"><div class="detail_kegiatan'+jmlDetail+'" id="detail_kegiatan'+jmlDetail+'" style="width: 100%; background: #fff;"></div><div id="isi'+jmlDetail+'" style="display:none">'+jmlDetail+'</div><div class="col-md-12"><a id="tam_detail_kegiatan'+jmlDetail+'" class="tam_detail_kegiatan'+jmlDetail+' btn btn-sm btn-primary m-r-5 float-right" style="color:white">Tambah Kegiatan</a></div></div></div></div>            <div class="col-lg-12"><div><a id="hapus_dataharilain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Hari</a></div></div><br></div>';
            // var data_hari = '<div> data <div class="col-lg-12"><div><a id="hapus_dataharilain" class="btn btn-sm btn-danger m-r-5" style="margin-top: 10px;color:white">Hapus Hari</a></div></div><br></div>';
            $('.detail_hari').append(data_hari);
            jam(jmlJam);
            tanggal(jmlTgl);
            jmlHari+=1;                
            
            var detailkegiatan2 = document.getElementById('detail_kegiatan'+jmlDetail+'');
            var jmlKegiatan2 = 0;
            var noKegiatan2 = 1;

            var isi = document.getElementById("isi"+jmlDetail+"").innerText; 
            // alert(isi);
            // alert(document.getElementById("isi"+jmlDetail+"").innerText);
            
            // $('#tam_detail_kegiatan'+jmlDetail+'').on('click', function(){
            $('#tam_detail_kegiatan'+isi+'').on('click', function(){
                // alert(jmlDetail);
                detailkegiatan2.style.display = 'block';
                noKegiatan2 += 1;
                addDataKegiatan2();
            });

            document.getElementById('jml_kegiatan'+isi+'').value = 1;
            function addDataKegiatan2(){
                // var data_kegiatan2 = '<div> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-8"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil"></div></div>                                </div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain'+jmlDetail+'" class="btn btn-sm btn-warning m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
                // $('.detail_kegiatan'+jmlDetail+'').append(data_kegiatan2);
                jmlJam+=1;
                var data_kegiatan2 = '<div style="background: rgb(242, 242, 242);"> <div class="panel-body panel-form"><div class="wrapper col-lg-12"><div class="row"><label class="col-lg-2 col-form-label">Jam</label><div class="col-lg-2"><div class="input-group date"><input id="jam_audit'+(jmlJam+1)+'" name="jam_audit[]" type="text" class="form-control" placeholder="Jam Audit"/><span class="input-group-addon"><i class="fa fa-clock"></i></span></div></div><div class="col-lg-8"><div class="row"><label class="col-4 col-form-label">Judul Kegiatan</label><div class="col-lg-8"><div><input class="form-control" name="judul_kegiatan[]" type="text" label="Judul Kegiatan" placeholder="Judul Kegiatan"></div></div>                                        </div></div></div></div>                        <div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Detail Kegiatan</label><div class="col-lg-8"><div><textarea name="detail_kegiatan[]" class="form-control" placeholder="Detail Kegiatan"></textarea></div></div>                                </div></div><div class="wrapper col-lg-12"><div class="row"><label class="col-4 col-form-label">Personil</label><div class="col-lg-8"><div><input class="form-control" name="personil[]" type="text" label="Personil" placeholder="Personil"></div></div>                                </div></div></div> <div class="col-lg-12"><div><a id="hapus_datakegiatanlain'+isi+'" class="btn btn-sm btn-warning m-r-5" style="margin-top: 10px;color:white">Hapus Kegiatan</a></div></div><br></div>';
                $('.detail_kegiatan'+isi+'').append(data_kegiatan2);
                jmlKegiatan2+=1;
                document.getElementById('jml_kegiatan'+isi+'').value = jmlKegiatan2 + 1;
                jam(jmlJam);       
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
        $(document).on('click','#hapus_dataharilain', function(){
            $(this).parent().parent().parent().parent().remove();
            jmlHari-=1;
            noHari-=1;                
            if(jmlHari == 0){
                detailhari.style.display = 'none';
            }
        });

        $('#tgl_audit1').datepicker({
            format: "yyyy-mm-dd",
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

        function jam(isi) {
            // alert(isi);
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

        function tanggal(isi) {
            $('#tgl_audit'+(isi+1)+'').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
            });
        }
    </script>
@endpush