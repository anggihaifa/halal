@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Pelaksana')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Data Pelaksana</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Pelaksana  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Pelaskana</h4>
            <div class="panel-heading-btn">
                <a href="{{route('detailpelaksana.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
            <table id="table" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class="valign-middle text-center">No</th>
                    <th class="valign-middle text-center">Foto</th>
                    <th class="valign-middle text-center">Nama</th>
                    <th class="valign-middle text-center">L/P</th>
                    <th class="valign-middle text-center">Status Karyawan</th>
                    <th class="valign-middle text-center">Wilayah</th>
                    <th class="valign-middle text-center">No telp & Email</th>
                    <th class="valign-middle text-center">No Registrasi BPJPH</th>
                    <th class="valign-middle text-center">No Registrasi BPJPH</th>
                    <th class="valign-middle text-center">Alamat</th>
                    <th class="valign-middle text-center">Status</th>
                    <th class="valign-middle text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
                {"data":"email"},
                {"data":"username"},
                {"data":"name"},
                {"data":"role"},
                {"data":"perusahaan"},
                {"data":"negara"},
                {"data":"kota"},
                {"data":"alamat"},
                {
                    "data":"status",
                    "render":function (data) {return checkStatus(data);}
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                      return `<div class="btn-group m-r-5 show">
                                <a href="{{url('master/detailpelaksana')}}/`+full.id+`/edit"  class="btn btn-info btn-xs"></i> Lengkapi data</a>
                                
                            </div>` 
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.detailpelaksana.datatable')}}",
            order:[[0,'asc']]
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush