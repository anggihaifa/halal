@extends('layouts.default')

@section('title', 'Persiapan Sidang Penetapan Kehalalan Produk')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
     

@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Persiapan Sidang Penetapan Kehalalan Produk</a></li>
        <li class="breadcrumb-item active"><a href="#">List Persiapan Sidang Penetapan Kehalalan Produk</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Persiapan Sidang Penetapan Kehalalan Produk <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Persiapan Sidang Penetapan Kehalalan Produk</h4>
            <div class="panel-heading-btn">
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive">
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
                                <div class="card-body" style="overflow: auto;">
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            @component('components.inputfilter',['name'=> 'no_registrasi','label' => 'No Registrasi'])@endcomponent
                                            
                                            @component('components.inputfilter',['name'=> 'nama_perusahaan','label' => 'Perusahaan'])@endcomponent   
                                            

                                    
                                            
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
            <table id="table" class="table table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead class="thead-light">
                    <tr>
                        <th class="valign-middle text-center">No</th>      
                        <th class="valign-middle text-center">No. Registrasi</th>
                        <th class="valign-middle text-center">Perusahaan</th>
                        <th class="valign-middle text-center">Jenis Produk</th>
                        <th class="valign-middle text-center" >Unduh</th>
                        <th class="valign-middle text-center" >Status Pembayaran</th>
                        
                        <th class="valign-middle text-center" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>

    <div id="modalpersiapansidang" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('storepersiapansidang')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Hasil Review Persiapan Sidang Penetapan Kehalalan Produk</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        

                       

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                
                                <tbody>
                                    <tr style="display:none">
                                    
                                        <td>
                                            <div class="form-group">
                                            <label class="control-label font-weight-bold" for="id">ID</label>  
                                            <div >
                                                <input id="id"  name="id" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class=" control-label font-weight-bold" for="catatan_persiapan_sidang">Catatan Persiapan Sidang Penetapan Kehalalan Produk</label>  
                                                <div >
                                                    <input type="text" id="catatan_persiapan_sidang" class="form-control"  name="catatan_persiapan_sidang" placeholder="" >
                                                
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                            <label class=" control-label font-weight-bold" for="id">Hasil</label>  
                                            <select id="status_persiapan_sidang" name="status_persiapan_sidang" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                                <option value="">==Pilih==</option>
                                                <option value="1">Lanjut Ke Tahapan Sidang Fatwa Halal</option>
                                                <option value="0">Perbaikan</option>                                                               
                                            </select>
                                            </div
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                                
                        </div>



                      
                    </div>
                 
                    <div class = "modal-footer">
                        <div >
                            <button class="btn btn-sm btn-success" type="submit" >Submit</button>
                        
                        </div>
                    </div>
                </div>
            </form>

           
            
        </div>
    </div>   

     <!-- end panel -->

    
    
@endsection
@push('scripts')


    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
    
    <script>
        window.addEventListener('load', (event) => {
            $('#modalpersiapansidang').find('form').trigger('reset');
            
        });

        $('#modalpersiapansidang').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
    
        
        })

         $('#modalpersiapansidang').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var id = $this.data('id');
            var status_persiapan_sidang = $this.data('status-persiapan-sidang');
            var catatan_persiapan_sidang = $this.data('catatan_persiapan_sidang');
            
            var modal = $('#modalpersiapansidang');
           
          
            if(modal.find('#id').val()){
               
            }else{

               
                modal.find('#id').val(id);

                modal.find('#status_persiapan_sidang').val(status_persiapan_sidang).change();   
                modal.find('#catatan_persiapan_sidang').val(catatan_persiapan_sidang);        
               
               
                  
                modal.find('#modalpersiapansidang').attr('action', function (i,old) {
                   return old + '/' +id;
            });  
            }
           

        });



        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });


        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('datapersiapansidang')}}",
                data:function(d){
                    d.no_registrasi = $('#no_registrasi').val();
                    d.nama_perusahaan = $('#nama_perusahaan').val();

                    //d.id_user = $('#id_user').val();

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

                {"data":"no_registrasi"},
                {"data":"nama_perusahaan"},
                {"data":"kelompok"},
                
               
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        //var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                        //var form_report = `<button class="btn btn-succes btn-xs"  href="">Form Laporan</a>`;

                        if(full.file_laporan_audit1 ){

                            var unduhLaporan1 = `<a href="{{ url('').Storage::url('public/laporan/download/Laporan Audit1/`+full.file_laporan_audit1+`') }}" class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan Audit1&nbsp;&nbsp;</a>`;

                                                                    
                        }else{
                            var unduhLaporan1 = `<a  href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbspLaporan Audit1&nbsp;&nbsp;</a>`;

                        }
                        if(full.file_laporan_tr ){

                            var unduhLaporanTR = `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Tehnical Review/`+full.file_laporan_tr+`') }}" class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan TR&nbsp;&nbsp;</a>`;

                                                                    
                        }else{
                            var unduhLaporanTR = `<a  href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbspLaporan TR&nbsp;&nbsp;</a>`;

                        }
                        if(full.file_laporan_tinjauan ){

                            var unduhLaporanKS = `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Tinjauan Komite/`+full.file_laporan_tinjauan+`') }}" class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan KS&nbsp;&nbsp;</a>`;

                                                                    
                        }else{
                            var unduhLaporanKS = `<a  href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbspLaporan KS&nbsp;&nbsp;</a>`;

                        }
                        

                        if(full.file_laporan_audit_tahap_2 ){

                            var unduhLaporan2 = `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Audit Tahap 2/`+full.file_laporan_audit_tahap_2+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan Audit2&nbsp;&nbsp;</a>`;
                            
                                                                            
                        }else{
                            var unduhLaporan2 = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;Laporan Audit2&nbsp;&nbsp;</a>`;
                            
                        }

                        if(full.file_bap ){

                            var unduhBAP = `<a href="{{ url('').Storage::url('public/laporan/upload/BAP/`+full.file_bap+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;

                                                                        
                        }else{
                            var unduhBAP = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;

                        }
                        if(full.file_laporan_ketidaksesuaian ){

                            var unduhTS = `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Ketidaksesuaian/`+full.file_laporan_ketidaksesuaian+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan Ketidaksesuaian&nbsp;&nbsp;</a>`;

                                                                        
                            }else{
                            var unduhTS = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;Laporan Ketidaksesuaian&nbsp;&nbsp;</a>`;

                        }

                        var unduhDPR = `<a href="{{ url('').Storage::url('public/laporan/fix/FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi.docx') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Daftar Periksa&nbsp;&nbsp;</a>`;

                        // if(full.status_dpra == '0'){

                        //     var dpra = ` <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modaldpra' >Unggah</button>`;

                                                                        
                        // }else{
                        //     var dpra = `<button class="btn btn-xs btn-grey m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modaldpra' >Unggah</button>`;

                        // }

                        return `<table class="table-xs table-borderless" style="width: 100%">
                                    <tr>
                                        <td class="text-center">
                                            `+unduhLaporan1+`
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center ">
                                            `+unduhLaporan2+`
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            `+unduhBAP+`
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            `+unduhTS+`
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            `+unduhLaporanTR+`
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            `+unduhLaporanKS+`
                                        </td>
                                    </tr>
                                    
                                </table>`
                                    
                        
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type, full, meta) {
                        if(full.nominal_tahap2){
                            if(full.status_tahap2 != '0' && full.status_tahap1 != '0' && full.status_tahap3 != '0'){
                                return `<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }
                        }else if(full.nominal_tahap3){
                            if(full.status_tahap1 != '0' && full.status_tahap3 != '0'){
                                return`<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }
                        }else if(full.status_tahap1){
                           
                            if(full.status_tahap1 != '0'){
                                return `<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }

                        }else{
                            return `<a style="color:red">Belum Akad</a>`
                        }
                    }
                }, 
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                        //var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                        //var form_report = `<button class="btn btn-succes btn-xs"  href="">Form Laporan</a>`;

                        

                        return `<table class="table-xs table-borderless text-center" style="width:100%">
                                    <tr class="text-center align-midle">
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id_regis+`' data-catatan_persiapan_sidang='`+full.catatan_persiapan_sidang+`' data-status-laporan_persiapan_sidang='`+full.status_persiapan_sidang+`'  data-target='#modalpersiapansidang' >Hasil Review</button>
                                        </td>
                                    </tr>
                                </table>`
                                    
                        
                    }
                }
            ],
            'columnDefs': [
            {
                    "targets": [0,1,2,3,4,5],
                    "className": "text-center",
                    
            }],
            
            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            bFilter: false,
			lengthChange: false

        });


        $(document).ready(function () {
    
        });
         
     
        
        function dButton(x){
            var disableButton = `<a href="#" class="dropdown-item" style="color:#3dad55;">`+ x +` <i class="ion-ios-checkmark-circle" style='color:#1fe01f;'></i></a>`;
            return disableButton;
        }

        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>

@endpush