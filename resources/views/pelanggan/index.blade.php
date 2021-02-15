@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Pengguna')

@push('css')
    <link href="{{asset('/assets/css/animate.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
        <li class="breadcrumb-item active"><a href="#">List Pelanggan</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Pelanggan  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Pelanggan</h4>
            <div class="panel-heading-btn">
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body">
            <!--panel pencarian-->
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
                                <div class="card-body">
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            @component('components.inputfilter',['name'=> 'email','label' => 'Email'])@endcomponent
                                            @component('components.inputfilter',['name'=> 'username','label' => 'Username'])@endcomponent
                                            @component('components.inputfilter',['name'=> 'name','label' => 'Nama'])@endcomponent
                                            @component('components.inputfilter',['name'=> 'perusahaan','label' => 'Perusahaan'])@endcomponent
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
            <table id="table" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%" style="margin-top: 10px;">
                <thead>
                <tr>
                    <th class="text-nowrap valign-middle text-center">No</th>
                    <th class=" valign-middle text-center">Email</th>
                    <th class=" valign-middle text-center">Username</th>
                    <th class="valign-middle text-center">Nama</th>
                    <th class="valign-middle text-center">Perusahaan</th>
                    <th class="valign-middle text-center">Negara</th>
                    <th class="valign-middle text-center">Kota</th>
                    <th class=" valign-middle text-center">Alamat</th>
                    <th class="valign-middle text-center">Status</th>
                    {{--<th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;</th>--}}
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
    <style type="text/css">
        
        table.dataTable tbody td {
            word-break: break-word;
            vertical-align: top;
        }
    </style>
    <script>
        console.log("SHOW");
        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('system.pelanggan.datatable')}}",
                data:function(d){
                    d.email = $('input[name=email]').val();
                    d.username = $('input[name=username]').val();
                    d.name = $('input[name=name]').val();
                    d.perusahaan = $('input[name=perusahaan]').val();
                }
            },
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
                {"data":"perusahaan"},
                {"data":"negara"},
                {"data":"kota"},
                {"data":"alamat"},
                {
                    "data":"status",
                    "render":function (data) {return checkStatus(data);}
                },/*
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return `<a href="{{url('system/user')}}/`+full.id+`/edit" class="btn btn-xs btn-icon btn-circle btn-lime" ><i class="fa fa-edit"></i></a>`+
                            `<form class="forDelete" action="{{url('system/user')}}/${full.id}" method="post" style="display:inline-block;margin-left:5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-icon btn-circle btn-danger" onclick= "return confirm('Apakah anda yakin untuk menghapus data??')"><i class="fa fa-times"></i></button>
                      </form>`
                    }
                }*/
            ],
            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush