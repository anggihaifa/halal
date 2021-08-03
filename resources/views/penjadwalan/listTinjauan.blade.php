@extends('layouts.default')

@section('title', 'Tinjauan Komite Sertifikasi')

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
        <li class="breadcrumb-item"><a href="#">Tinjauan Komite Sertifikasi</a></li>
        <li class="breadcrumb-item active"><a href="#">List Tinjauan Komite Sertifikasi</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Tinjauan Komite Sertifikasi <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Tinjauan Komite Sertifikasi</h4>
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
                        <th class="valign-middle text-center" style="max-width:20%">Komite Sertifikasi</th>
                      
                        {{-- <th class="valign-middle text-center" >Unduh</th> --}}
                        
                        <th class="valign-middle text-center" style="max-width:20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>

    <div id="modalks" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('storelaporanks')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Tinjauan Komite Sertifikasi</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                <thead class="table-success">   
                                <th >Upload File</th>

                                </thead>
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
                                            <label class=" control-label font-weight-bold" for="id">File Tinjauan Komite Sertifikasi</label>  
                                            <div >
                                                <input id="file_laporan_tinjauan"  name="file_laporan_tinjauan" type="file" placeholder="" >
                                            
                                            </div>
                                            </div
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                                
                        </div>

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                <thead class="table-success">   
                                <th >Hasil Tinjauan Komite Sertifikasi</th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class=" control-label font-weight-bold" for="id">Catatan Tinjauan Komite Sertifikasi</label>  
                                                <div >
                                                    <input type="text" id="catatan_tinjauan" class="form-control"  name="catatan_tinjauan" placeholder="" >
                                                
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                            <label class=" control-label font-weight-bold" for="id">Hasil</label>  
                                            <select id="status_laporan_tinjauan" name="status_laporan_tinjauan" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                                <option value="">==Pilih==</option>
                                                <option value="1">Lanjut Ke Tahapan Bertikutnya</option>
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
            $('#modalks').find('form').trigger('reset');
            
        });

        $('#modalks').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
    
        
        })

         $('#modalks').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var id = $this.data('id');
            var status_laporan_tinjauan = $this.data('status-laporan-tinjauan');
            var catatan_tinjauan = $this.data('catatan-tinjauan');
            
            var modal = $('#modalks');
           
          
            if(modal.find('#id').val()){
               
            }else{

               
                modal.find('#id').val(id);

                modal.find('#status_laporan_tinjauan').val(status_laporan_tinjauan).change();   
                modal.find('#catatan_tinjauan').val(catatan_tinjauan);        
               
               
                  
                modal.find('#modalks').attr('action', function (i,old) {
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
                    url:"{{route('datatinjauan')}}",
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
                   
                            if(full.pelaksana1_tinjauan){
                                var str = full.pelaksana1_tinjauan.split("_");
                                    
                                if(full.pelaksana2_tinjauan){
                                    var str2 = full.pelaksana2_tinjauan.split("_");
                                    return str[1]+'<br>'+str2[2]
                                }else{
                                    return str[1]+'<br>-'
                                }
                            }else{
                                return '-'
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

                           

                            return `<table class="table-xs table-borderless text-center">
                                        <tr class="text-center align-midle">
                                            <td class="text-center">
                                                
                                                <a class="btn btn-xs btn-primary m-r-5" href="{{url('daftar_periksa_rekomendasi')}}/`+full.id_regis+`">Isi Daftar Periksa dan Rekomendasi</a>
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