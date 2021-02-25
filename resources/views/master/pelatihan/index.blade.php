@extends('layouts.default')

@section('title', 'Master F.A.Q')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Pelatihan</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Pelatihan  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Pelatihan</h4>
            <div class="panel-heading-btn">                                
                <a href="{{route('pelatihan.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Info Pelatihan</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">            
            <table id="table" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class="text-nowrap valign-middle text-center">No</th>
                    <th class="text-nowrap valign-middle text-center">Judul Berita</th>
                    <th class="text-nowrap valign-middle text-center">Penulis</th>
                    <th class="text-nowrap valign-middle text-center">Waktu</th>
                    <th class="text-nowrap valign-middle text-center">Acc</th>
                    <th class="text-nowrap valign-middle text-center">Detail</th>
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
    <style type="text/css">
        td.details-control {
            text-align:center;
            color:forestgreen;
            cursor: pointer;
        }
        tr.shown td.details-control {
            text-align:center; 
            color:red;
        }
    </style>
    <script>        
        $('#table').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data":"judul_pelatihan"                    
                },
                {
                    "data":"nama_penulis"
                },
                {
                    "data":"created_at"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {                            
                        // return `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`" class="btn btn-indigo btn-xs">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                        if(full.status_approve == 0){
                            return `<p class="btn btn-warning btn-xs">&nbsp;&nbsp;Belum di Acc&nbsp;&nbsp;</p>`
                        }else{
                            return `<p class="btn btn-primary btn-xs">&nbsp;&nbsp;Sudah di Acc&nbsp;&nbsp;</p>`
                        }                        
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {                            
                        // return `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`" class="btn btn-indigo btn-xs">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                        return `<a href="{{url('detail_pelatihan')}}/`+full.id+`" class="btn btn-indigo btn-xs">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>`
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        if({{Auth::user()->usergroup_id}} == 6){
                            if(full.status_approve == 0){
                                return `<div class="btn-group m-r-5 show">
                                    <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                    <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                        <a href="{{url('acc_pelatihan')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-check-circle"></i> Acc</a>

                                        <a href="{{url('master/pelatihan')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                        <form class="forDelete dropdown-item" action="{{url('master/pelatihan')}}/${full.id}" method="post" style="padding:0px;">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                            </form>       
                                    </div>
                                </div>`
                            }else{
                                return `<div class="btn-group m-r-5 show">
                                    <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                    <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                        <a href="{{url('acc_pelatihan')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-check-circle"></i> Cabut Acc</a>

                                        <a href="{{url('master/pelatihan')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                        <form class="forDelete dropdown-item" action="{{url('master/pelatihan')}}/${full.id}" method="post" style="padding:0px;">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                            </form>       
                                    </div>
                                </div>`
                            }                  
                        }else{
                            return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('master/pelatihan')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                    <form class="forDelete dropdown-item" action="{{url('master/pelatihan')}}/${full.id}" method="post" style="padding:0px;">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                        </form>       
                                </div>
                            </div>`    
                        }                        
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.datapelatihan')}}",
            order:[[0,'asc']]
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
                              
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush