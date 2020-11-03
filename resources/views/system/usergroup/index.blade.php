@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Grup Pegguna')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">System</a></li>
        <li class="breadcrumb-item active"><a href="#">Grup Pengguna</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Grup Pengguna  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Grup Pengguna </h4>
            <div class="panel-heading-btn">
                <a href="{{route('usergroup.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
                    <th class="text-nowrap valign-middle text-center">Nama</th>
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
        console.log("SHOW");
        $('#table').DataTable({
            columns:[
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return meta.row + 1;
                        console.log(data);
                    }
                },
                {
                    "data":"usergroup"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                      return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">
                                
                                    <a href="{{url('system/usergroup')}}/`+full.id+`/edit" class="dropdown-item" ><i class="fa fa-edit"></i> Edit</a>

                                    <form class="forDelete dropdown-item" action="{{url('system/usergroup')}}/${full.id}" method="post" style="padding:0px;">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')" style="outline:none;"><i class="ion-ios-trash"></i> Delete</button>
                                        </form>       
                                </div>
                            </div>` 
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('system.usergroup.datatable')}}",
            order:[[0,'asc']]
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush