@extends('layouts.default')

@section('title', 'Registrasi Halal')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">List Registrasi Halal</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Registrasi Halal  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Registrasi Halal</h4>
            <div class="panel-heading-btn">
                @if(isset($data))
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: Reg No.  {{$data->no_registrasi==null ? "-" : $data->no_registrasi }}</a>
                @else
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: ---</a>
                @endif
                
                <a href="{{route('registrasiHalal.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
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
                    <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal</th>
                    <th class="text-nowrap valign-middle text-center">Jenis </th>
                    <th class="text-nowrap valign-middle text-center">Status</th>
                    <th class="text-nowrap valign-middle text-center">Aktif/Non Aktif</th>
                    <th class="text-nowrap valign-middle text-center">Progress</th>
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
                {"data":"no_registrasi"},
                {"data":"tgl_registrasi"},
                {"data":"jenis"},
                {"data":"status_registrasi"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        // if(full.status_pembayaran == 2 ){
                        //     if(full.id == `{{Auth::user()->registrasi_id}}` ){
                        //         return `<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-yellow btn-xs" >Non Aktifkan</a>`
                        //     }else{
                        //         return `<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-green btn-xs" >Aktifkan</a>`
                        //     }
                        // }else{
                        //     return `-`
                        // }
                        
                        if(full.id == `{{Auth::user()->registrasi_id}}` ){
                            return `<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-yellow btn-xs" >Non Aktifkan</a>`
                        }else{
                            return `<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-green btn-xs" >Aktifkan</a>`
                        }
                        
                    }
                },
                {
                    "data":"status",
                    "render":function (data) {return checkProgress(data);}
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        // if(full.status_pembayaran == null || full.status_pembayaran == 0 || full.status_pembayaran == 1){
                        //     return `<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-primary btn-xs" >Detail</a> `+
                        //         `<a href="{{url('pembayaran_registrasi')}}/`+full.id+`" class="btn btn-info btn-xs" >Bayar</a>`
                        // }else{
                        //     return `<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-primary btn-xs" >Detail</a> `
                        // }
                        return `<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-primary btn-xs" >Detail</a> `
                    }
                }
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('registrasi.datatable')}}",
            order:[[0,'asc']]
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush