@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Log')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/daterangepicker.css')}}" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">System</a></li>
        <li class="breadcrumb-item active"><a href="#">Log</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Log User  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Log User</h4>
            <div class="panel-heading-btn">
                <a href="#filter" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Search</a>
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
                    <th class="text-nowrap valign-middle text-center">Nama</th>
                    <th class="text-nowrap valign-middle text-center">Bumn</th>
                    <th class="text-nowrap valign-middle text-center">Aktivitas</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal dan Jam</th>
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
                            @component('components.inputselectuser',['id'=>'name','name'=>'name','label'=>'user','options'=>$user,'labelKey'=>'username'])@endcomponent
                            @component('components.inputselectbumn',['id'=>'bumn_code','name'=>'bumn_code','label'=>'BUMN','options'=>$bumn,'labelKey'=>'bumn_name'])@endcomponent
                            @component('components.inputtext',['id'=>'activity','name'=> 'activity','label' => 'Aktivitas'])@endcomponent
                            <label class="col-lg-4 col-form-label">Tanggal Daterange</label>
                            <div class="col-lg-8">
                                <input id="xdaterange" type="text" class="form-control"s name="daterange"  />
                            </div>
                            {{--<label class="col-lg-4 col-form-label">Tanggal</label>
                            <div class="col-lg-8">
                                <input name="date" class="form-control xdatepicker" rows="1" />
                            </div>--}}
                            
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
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('/assets/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script>
        var startDate;
        var endDate;

        $('input[name="daterange"]').daterangepicker({
            opens: 'top',
            autoApply:true,
            locale: {
                format: 'YYYY/MM/DD'
                }
            }, function(start, end, label) {
                //alert("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
        });
                

        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('system.log.datatable')}}",
                data:function (d) {
                    d.name = $('#name').val();
                    d.bumn_code = $('#bumn_code').val();
                    d.activity = $('#activity').val();
                    d.startdate = startDate;
                    d.enddate = endDate;
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
                {"data":"name"},
                {"data":"bumn_code"},
                {"data":"activity"},
                {
                    "data":null,
                    "render":function (data) {
                        return data.date +"&nbsp;&nbsp;&nbsp;"+ data.time;
                    }
                },
            ],
            processing:true,
            serverSide:true,
            searching:false,
            order:[[1,'asc']]
        });

        /*$('.xdatepicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('.xdatepicker').datepicker('setDate', today);*/
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush