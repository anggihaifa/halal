@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Data Auditor dan Komite')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item active"><a href="#">Data Auditor dan Komite</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Data Auditor dan Komite<small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Data Auditor dan Komite</h4>
            <!-- <div class="panel-heading-btn">
                <a href="{{route('detailpelaksana.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div> -->
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
            <table id="table" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class="valign-middle text-center">No</th>
                   
                    <th class="valign-middle text-center">Nama</th>
                    <th class="valign-middle text-center">Jabatan</th>
                    <th class="valign-middle text-center">L/P</th>
                    <th class="valign-middle text-center">Status Karyawan</th>
                    <th class="valign-middle text-center">Wilayah</th>
                    <th class="valign-middle text-center">No telp & Email</th>
                    <th class="valign-middle text-center">No Registrasi BPJPH</th>
                    <th class="valign-middle text-center">Alamat</th>
                    <th class="valign-middle text-center">Log Audit</th>
                    
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
    <script src="{{asset('/assets/js/jszip.min.js')}}"></script>
    <script src="{{asset('/assets/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('/assets/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('/assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.print.min.js')}}"></script>
   
    <script>
        console.log("SHOW");
        $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    className: 'btn-green btn',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                }
               
                
            ],       
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
                {"data":"name"},
                {"data":"role"},
                {"data":"jenis_kelamin"},
                {"data":"status_karyawan"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return checkWilayah(full.kode_wilayah);
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return full.email +'<br>'+full.telp;
                        
                    }
                },
                {"data":"noreg_bpjph"},
                {"data":"alamat"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;
                        // var kebutuhanAudit = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-target='modalKebutuhan'>Penentuan Waktu Audit</a>`;
            
                        // data-no-registrasi-bpjph=`+full.no_registrasi_bpjph+` data-status-registrasi=`+full.status_registrasi+` data-name=`+full.name+` data-alamat-perusahaan=`+full.alamat_perusahaan+`
                        return `<a href="{{url('list_monitoring_log')}}/`+full.id+`" class="btn btn-sm" ><i class="fa fa-eye"></i> <br>View</a>`
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    }
                },
               
               
            ],
            processing:true,
            serverSide:true,
            ajax:"{{route('master.detailpelaksana.datatable')}}",
            order:[[0,'asc']],
            paging:false,
           
        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
@endpush