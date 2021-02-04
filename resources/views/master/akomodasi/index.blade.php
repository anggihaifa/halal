@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Master Akomodasi')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Akomodasi</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Master Akomodasi  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Master Akomodasi </h4>
            <div class="panel-heading-btn">
                <a href="{{route('akomodasi.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
                        <th class="text-nowrap valign-middle text-center">Akomodasi</th>
                        <th class="text-nowrap valign-middle text-center">Jenis Akomodasi</th>
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
                {"data":"transportasi_darat"},

                {"data":"jenis_akomodasi"},
                
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                    <a href="{{url('master/akomodasi')}}/edit/`+full.id+`/`+full.jenis_akomodasi+`" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                    <form class="forDelete dropdown-item" action="{{url('master/akomodasi')}}/delete/${full.id}/${full.jenis_akomodasi}" style="padding:0px;">
                                        @csrf
                                       
                                            <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                        </form>       
                                </div>
                            </div>`    
                    }
                }
            ],
            'columnDefs': [
                {
                      "targets": [0,1,2,3],
                      "className": "text-center",
                     
                }],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.akomodasi.datatable')}}",
            order:[[0,'asc']]
        });
      
    </script>
@endpush