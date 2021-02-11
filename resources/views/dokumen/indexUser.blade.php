@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Dokumen Halal')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Akomodasi</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Dokumen Halal<small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Dokumen Halal</h4>
            <div class="panel-heading-btn">
    
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
                        <th class="text-nowrap valign-middle text-center">Nama File</th>
                        <th class="text-nowrap valign-middle text-center">Lihat</th>
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
                {"data":"nama_file"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        
                       
                    return `<a href="{{url('dokumen_view')}}/`+full.id+`" ><i class="fa fa-eye"></i></a>`
                         
                    }
                }
                
                
            ],
            'columnDefs': [
                {
                      "targets": [0,1,2],
                      "className": "text-center",
                     
                }],
            processing:true,
            serverSide:true,
            ajax:"{{route('dokumen.datatable')}}",
            order:[[0,'asc']]
        });
      
    </script>
@endpush