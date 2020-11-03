@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Master BUMN')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">System</a></li>
        <li class="breadcrumb-item active"><a href="#">BUMN</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Master BUMN  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Master BUMN </h4>
            <div class="panel-heading-btn">
                <a href="{{route('bumn.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
            <table id="table" class="table table-striped table-bordered table-td-valign-middle " cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-nowrap valign-middle text-center">No</th>
                        <th class="text-nowrap valign-middle text-center">Kode</th>
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
                    "data":"bumn_code"
                },
                {
                    "data":"bumn_name"
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<a href="{{url('master/bumn')}}/`+full.id+`/edit" class="btn btn-xs btn-icon btn-circle btn-lime" ><i class="fa fa-edit"></i></a>`+
                          `<form class="forDelete" action="{{url('master/bumn')}}/${full.id}" method="post" style="display:inline-block;margin-left:5px;">
                            @csrf
                            @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-icon btn-circle btn-danger" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')"><i class="fa fa-times"></i></button>
                        </form>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.bumn.datatable')}}",
            order:[[0,'asc']]
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush