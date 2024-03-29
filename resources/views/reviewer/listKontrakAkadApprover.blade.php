@extends('layouts.default')

@section('title', 'Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">List Kontrak Akad Sertifikasi Halal</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Kontrak Akad Sertifikasi Halal  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Kontrak Akad Sertifikasi Halal</h4>
            <div class="panel-heading-btn">
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
            <div class="forFilter panel-inverse" >
                <div id="dtransfer">
                    <div id="accordionFilter" class="accordion">
                        <!-- begin card -->
                        <div class="card">
                            <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapseFilter" style="cursor: pointer; padding: 2px 5px">
                                <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-search.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                <span class="faq-ask">Filter</span>
                            </div>
                            <div id="collapseFilter" class="collapse" data-parent="#accordionFilter">
                                <div class="card-body" style="overflow: auto;">
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            @component('components.inputfilter',['name'=> 'no_registrasi','label' => 'No Registrasi'])@endcomponent
                                            
                                            @component('components.inputfilter',['name'=> 'name','label' => 'Nama'])@endcomponent

                                            <label for="kelompok" class="col-lg-2 col-form-label">Kelompok Produk</label>
                                            <div class="col-lg-4">
                                                <select id="jenis_registrasi" name="jenis_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">--Pilih Jenis Registrasi--</option>
                                                    @if(isset($dataJenis))
                                                        @foreach($dataJenis as $index => $value)
                                                            <option value="{{$value['jenis_registrasi']}}"> - {{$value['jenis_registrasi']}}</i></option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            @component('components.inputfilter',['name'=> 'perusahaan','label' => 'Perusahaan'])@endcomponent   

                                            
                                            <label class="col-lg-2 col-form-label">Status Akad</label>
                                            <div class="col-lg-4">
                                                <select id="status_akad" name="status_akad" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Status Akad--</option>
                                                    <option value="0">Belum Akad</option>
                                                    <option value="1">Menunggu Pelanggan Upload Ulang</option>
                                                    <option value="2">Pelanggan Sudah Upload Ulang Menunggu Konfirmasi Admin</option>
                                                </select>
                                            </div>

                                            

                                            <label class="col-lg-2 col-form-label">Tanggal Registrasi</label>
                                            <div class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control" placeholder="Tanggal Registrasi" value="" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                @component('components.buttonsearch')@endcomponent
                                            </div>
                                        </div>
                                    </form>            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="table" class="table table-hover table-bordered table-td-valign-middle table-sm " cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class="text-nowrap valign-middle text-center">No</th>
                    
                    <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                    <th class="text-nowrap valign-middle text-center">Jenis </th>
                    <th class="text-nowrap valign-middle text-center">Pelanggan</th>
                    <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal</th>
                    <th class="text-nowrap valign-middle text-center">Status</th>                
                    <th class="text-nowrap valign-middle text-center">Biaya</th>
                    <th class="text-nowrap valign-middle text-center">Detail</th>                    
                    <th class="text-nowrap valign-middle text-center">Catatan</th>
                    <th class="text-nowrap valign-middle text-center">Aksi</th>
                </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection
@push('scripts')
    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script>    
        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

        var catatan_fix="";
        var dataArray = [];                
        function catatan_reviewer(no){
            catatan_fix = document.getElementById("catatan_akad"+no+"").value;            
            dataArray[no] = catatan_fix;
            
            xTable.ajax.reload();
            // alert(dataArray);            
        }
        
        var xTable = $('#table').DataTable({

            ajax:{
                url:"{{route('dataakadapprover')}}",
                data:function(d){
                    d.no_registrasi = $('input[name=no_registrasi]').val();
                    d.name = $('input[name=name]').val();
                    d.perusahaan = $('input[name=perusahaan]').val();
                    d.tgl_registrasi = $('input[name=tgl_registrasi]').val();
                    d.kelompok_produk = $('#kelompok_produk').val();          
                    d.status_akad = $('#status_akad').val();                    
                }   
            },
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                
                {"data":"no_registrasi"},

                {"data":"jenis"},
                {"data":"name"},
                {"data":"nama_perusahaan"},
                {"data":"tgl_registrasi"},
                {
                    "data":"status",
                    "render":function (data) {return checkProgress(data);}
                },
                
                {
                    "data":"total_biaya",
                    
                    "searchable":false,
                    "orderable":false,
                    "render": function(data, type, row) {
                        return Number(data).toLocaleString('id', {
                          maximumFractionDigits: 2,
                          style: 'currency',
                          currency: 'IDR'
                        });
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                            if(full.status_akad == 0 || full.status_akad == null || full.status_akad == 1 ){

                            return `-`
                            }else{
                                return `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`" class="btn btn-indigo btn-xs">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`    
                            }
                        
                        
                    }
                }, 
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {                                
                                if(dataArray[meta.row] != null){
                                    return `<form><input type="text" id="catatan_akad`+meta.row+`" onchange="catatan_reviewer(`+meta.row+`)" name="catatan" value="`+dataArray[meta.row]+`" class="form-control"></form>`
                                }else{
                                    // if(full.catatan!=null){
                                    //     return `<form><input type="text" id="catatan_akad`+meta.row+`" onchange="catatan_reviewer(`+meta.row+`)" name="catatan" value="`+full.catatan+`" class="form-control"></form>`
                                    // }
                                    return `<form><input type="text" id="catatan_akad`+meta.row+`" onchange="catatan_reviewer(`+meta.row+`)" name="catatan" class="form-control"></form>`
                                }                                
                                      
                        
                    }
                }, 

                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                                
                                // alert(document.getElementById("catatan_akad").value);                                
                                if(dataArray[meta.row] != null){
                                    var status8 = `<a href="{{url('update_status_akad_approve')}}/`+full.id+`/`+full.id_user+`/p/`+full.id_akad+`/`+dataArray[meta.row]+`"   class="dropdown-item"> Akad Gagal</a> `;
                                }else{                                    
                                    var status8 = `<a href="{{url('update_status_akad_approve')}}/`+full.id+`/`+full.id_user+`/p/`+full.id_akad+`/-"   class="dropdown-item"> Akad Gagal</a> `;
                                }
                                var konfirm = `<a href="{{url('konfirmasi_akad_approver')}}/`+full.id+`/`+full.id_akad+`"  class="dropdown-item" >Konfirmasi Akad</a>` ;

                                return `<div class="btn-group m-r-5 show">
                                        <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">                                            

                                            
                                            <div class="dropdown-divider"></div>`+status8+konfirm+
                                        `</div>
                                    </div>`
                                      
                        
                    }
                }
            ],
           'columnDefs': [
            {
                  "targets": [1,2,3,4,5,6,7,8,9,10],
                  "className": "text-center",
                 
            }],

            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,

        });
       /* $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });*/        
        function dButton(x){
            var disableButton = `<a href="#" class="dropdown-item" style="color:#3dad55;">`+ x +` <i class="ion-ios-checkmark-circle" style='color:#1fe01f;'></i></a>`;
            return disableButton;
        }
        
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush