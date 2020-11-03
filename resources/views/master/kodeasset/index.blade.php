@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Kode Kelompok Asset')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Kode Kelompok Asset</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Master Kode Kelompok Asset  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Kode Kelompok Asset</h4>
            <div class="panel-heading-btn">
                <a href="#filter" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Search</a>
                <a href="{{route('kodeasset.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
                    <th class="text-nowrap valign-middle text-center">Kategori</th>
                    <th class="text-nowrap valign-middle text-center">Kode Kelompok</th>
                    <th class="text-nowrap valign-middle text-center">Item</th>
                    <th class="text-nowrap valign-middle text-center">Aksi</th>
                </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
    <div class="modal fade" id="filter">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-cstm">
                    <h4 class="modal-title"><i class="ion-md-search"></i>  Filter </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        <div class="form-group row">
                            @component('components.inputkodekelompok',['id'=>'kode_kelompok','name'=> 'kode_kelompok','label' => 'Kode Kelompok'])@endcomponent
                            @component('components.inputtext',['id'=>'nama_item','name'=> 'nama_item','label' => 'Item'])@endcomponent
                            <div class="col-md-12 offset-md-5">

                            @component('components.buttonsearch')@endcomponent
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('master.kodeasset.datatable')}}",
                data:function (d) {
                    d.kode_kelompok = $('input[name=kode_kelompok]').val();
                    d.nama_item = $('input[name=nama_item]').val();
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
                {
                    "data":"kategori",
                    "render":function (data) {
                        return (data==1)? "Tanah Bangunan":"Non Tanah Bangunan";
                    }
                },
                {"data":"kode_kelompok"},
                {"data":"nama_item"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<a href="{{url('master/kodeasset')}}/`+full.id+`/edit" class="btn btn-xs btn-icon btn-circle btn-lime" ><i class="fa fa-edit"></i></a>`+
                            `<form class="forDelete" action="{{url('master/kodeasset')}}/${full.id}" method="post" style="display:inline-block;margin-left:5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-icon btn-circle btn-danger" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')"><i class="fa fa-times"></i></button>
                      </form>`
                    }
                }
            ],
            processing:true,
            serverSide:true,
            searching:false,
            order:[[1,'asc']]
        });

        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });

    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush