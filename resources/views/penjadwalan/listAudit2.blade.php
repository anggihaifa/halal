@extends('layouts.default')

@section('title', 'Audit Tahap 2')

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
        <li class="breadcrumb-item"><a href="#">Penjadwalan Audit</a></li>
        <li class="breadcrumb-item active"><a href="#">Audit Tahap 2</a></li>
    </ol>
    
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="label-primary panel-title">Audit Tahap 2</h4>
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
                                            
                                            <label class="col-lg-2 col-form-label">Bulan Audit</label>
                                            <div class="col-lg-4">
                                                <input id="f_mulai_audit2"  name="f_mulai_audit2" class="form-control" class="form-control">
                                                </input>
                                                
                                                
                                            </div>
                                    
                                            
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
            <table id="table" class="table" cellspacing="0" style="width:100%">
                <thead style="display: none;">
                    <tr>
                        <th ></th>                         
                    </tr>
                </thead>
            </table>
            
          
            
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

     <div id="modalCatatan" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form  enctype="multipart/form-data">
              
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Catatan Perbaikan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="catatan_tr">Catatan Technical Review</label>  
                            <div >
                                <input id="catatan_tr"  name="catatan_tr" type="text" placeholder="" class="form-control " disabled>
                            
                            </div>
                        </div>
                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="catatan_tinjauan">Catatan Tinjauan Komite</label>  
                            <div >
                                <input id="catatan_tinjauan"  name="catatan_tinjauan" type="text" placeholder="" class="form-control " disabled>
                            
                            </div>
                        </div>
                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="catatan_persiapan_sidang">Catatan Persiapan Sidang</label>  
                            <div >
                                <input id="catatan_persiapan_sidang"  name="catatan_persiapan_sidang" type="text" placeholder="" class="form-control " disabled>
                            
                            </div>
                        </div>
                    </div>
                      
                </div>
            </form>

           
            
        </div>
    </div>   
    
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
            $('#modalCatatan').find('form').trigger('reset');
            
        });

        $('#modalCatatan').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        
        
        });

        $('#modalCatatan').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var catatan_tr = $this.data('catatan-tr');
            var catatan_tinjauan = $this.data('catatan-tinjauan');
            var catatan_persiapan_sidang = $this.data('catatan-persiapan-sidang');
            var modal = $('#modalCatatan');

            modal.find('#catatan_tr').val(catatan_tr);
            modal.find('#catatan_tinjauan').val(catatan_tinjauan);
            modal.find('#catatan_persiapan_sidang').val(catatan_persiapan_sidang);
            modal.find('#modalCatatan').attr('action', function (i,old) {
            return old + '/' + id;

            });

        });

       
        $('#btncalendar').datepicker({
            
            format: "yyyy-mm",
            todayHighlight: true,
        });
        
        $('#f_mulai_audit2').datepicker({
          
            format: "yyyy-mm",
            todayHighlight: true,
        });
        

       /* function format ( d ) {


            if(d.mulai_audit2  == null){

                d.mulai_audit2 ="-";
            }
            if(d.selesai_audit2  == null){

                d.selesai_audit2 ="-";
            }
           
        
            if(d.pelaksana1_audit2 != null){
                if (d.pelaksana1_audit2.indexOf('_') > -1)
                {
                    $str1 =  d.pelaksana1_audit2.split("_");
                    d.pelaksana1_audit2 = $str1[1];
                }
               
            }else{
                d.pelaksana1_audit2 ="-";
            }


             if(d.pelaksana2_audit2 != null){

                if (d.pelaksana2_audit2.indexOf('_') > -1){
                    $str2 =  d.pelaksana2_audit2.split("_");
                    d.pelaksana2_audit2 = $str2[1];
                }
                           
            }else{
                d.pelaksana2_audit2 ="-";
            }



            return '<table  class="table" cellspacing="0" style="width:100% padding-left:50px;">'+
                
                '<tr>'+
                    '<td class="valign-middle text-center" style="text-align:left !important"><li>Tanggal Mulai Audit:'+d.mulai_audit2+'</li><li>Selesai Audit:'+d.selesai_audit2+'</li><li>Lokasi Audit:</li><li>Skema Audit:</li><li>Nomor Audit:</li><li>Nomor Kontrak akad:</li></td>'+
                    
                    '<td class="valign-middle text-center"><a href="{{url('detail_registrasi')}}/`+d.id_registrasi+`" class="btn" ><i class="ion-ios-eye"></i> Detail Data</a> <br><a href="{{url('detail_unggah_data_sertifikasi_auditor')}}/`+d.id_registrasi+`" class="btn" ><i class="fa fa-edit"></i> Report Audit Tahap 2</a></td>'+
                   
                '</tr>'+
                
            '</table>';
        }
*/

        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('dataaudit2')}}",
                data:function(d){
                    d.no_registrasi = $('#no_registrasi').val();
                    d.nama_perusahaan = $('#nama_perusahaan').val();
                    d.mulai_audit2 = $('#f_mulai_audit2').val();
    

                }
            },
            
            columns:[
                
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        if(full.pelaksana1_audit2){
                            var str = full.pelaksana1_audit2.split("_");
                            p1_a2 = str[1];
                        }else{
                            p1_a2 = '';
                        }

                        if(full.pelaksana2_audit2){
                            var str2 = full.pelaksana2_audit2.split("_");
                            p2_a2 = str2[1];
                        }else{
                            p2_a2 = '';
                        }

                       
                        if(full.status == '10_1' ){
                            if(full.file_laporan_tinjauan){
                                buttonUnduh =  `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Tehnical Review/`+full.file_laporan_tr+`') }}" class="btn-xs btn btn-green" style="color: white;" download>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Tehnical Review
                                        </a>
                                        <a href="{{ url('').Storage::url('public/laporan/upload/Laporan Tinjauan Komite/`+full.file_laporan_tinjauan+`') }}" class="btn-xs btn btn-green" style="color: white;" download>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Komite Sertifikasi
                                        </a>
                                        <a  class="btn-xs btn btn-green" style="color: white;" data-toggle='modal' data-catatan-tr='`+full.catatan_tr+`' data-catatan-tinjauan='`+full.catatan_tinjauan+`' data-catatan-persiapan-sidang='`+full.catatan_persiapan_sidang+`' data-target='#modalCatatan' >
                                            <i class="fa fa-eye" aria-hidden="true"></i>View Catatan
                                        </a>`;
                            }else{
                                buttonUnduh =  `<a href="{{ url('').Storage::url('public/laporan/upload/Laporan Tehnical Review/`+full.file_laporan_tr+`') }}" class="btn-xs btn btn-green" style="color: white;" download>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Technical Review
                                        </a>
                                        <a class="btn-xs btn btn-grey" style="color: white;" disabled>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Komite Sertifikasi
                                        </a>
                                        <a  class="btn-xs btn btn-green" style="color: white;" data-toggle='modal' data-catatan-tr='`+full.catatan_tr+`' data-catatan-tinjauan='`+full.catatan_tinjauan+`' data-catatan-persiapan-sidang='`+full.catatan_persiapan_sidang+`' data-target='#modalCatatan' >
                                            <i class="fa fa-eye" aria-hidden="true"></i>View Catatan
                                        </a>`;

                            }

                           
                                       

                                                                    
                        }else{
                            buttonUnduh =  `<a  class="btn-xs btn btn-grey" style="color: white; cursor: context-menu;" disabled>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Technical Review
                                        </a>
                                        <a class="btn-xs btn btn-grey" style="color: white; cursor: context-menu;" disabled>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Komite Sertifikasi
                                        </a>
                                        <a  class="btn-xs btn btn-grey" style="color: white; cursor: context-menu;">
                                            <i class="fa fa-eye" aria-hidden="true" disabled></i>View Catatan
                                        </a>`;

                        }
                        
                        
                        
                        return `<div class="col-lg-12 row rounded-sm shadow-sm border pt-3 pb-3 m-0">
                                    <div class="col-lg-5" style="padding-left:10%; padding-top:2%">
                                        <label class="inline text-center">

                                            <i class="fa fa-calendar text-primary" style="font-size:600%"></i>
                                            <br>
                                            <h2 class="text-grey" style=>`+full.mulai_audit2+`</h2>
                                          
                                            <span class="label label-success"><a style="color: white;">NOMOR REG : `+full.no_registrasi+`</a></span>
   
                                        </label>
                                    </div>
                                    

                                    <div class="col-lg-7 >

                                            <span class="lbl">
                                                <br><b>`+full.nama_perusahaan+`</b><br>
                                                <i class="fa fa-map-marker fa-fw text-primary"></i>: `+full.alamat_perusahaan+`<br>
                                                  
                                            </span>    
                                            <span style=";">
                                            <table class = "table table-borderless table-xs p-0 m-0">
                                                <tr class="p-0 m-0" >
                                                    <td class="p-0 m-0" style="font-weight:bold; width:40%">
                                                        Ketua Tim Auditor:
                                                    </td>
                                                        
                                                    <td class="p-0 m-0" >
                                                        `+p1_a2+`
                                                    </td>

                                                </tr>
                                                <tr class="p-0 m-0" >
                                                    <td  style="font-weight:bold; width:40%" class="p-0 m-0" >
                                                        Auditor:
                                                    </td>

                                                    <td class="p-0 m-0" >
                                                        `+p2_a2+`
                                                    </td>

                                                </tr>
                                            </table
                                            <br>
                                            
                                            Lokasi Audit: `+full.ktg_audit2+`<br>

                                            
                                        
                                        <a href="{{url('audit_plan')}}/`+full.id_registrasi+`"   class="btn btn-primary btn-xs" style="color: white;">
                                            <i class="ace-icon fa fa-eye" ></i style="color: white; margin-right: 5px; "> Rencana Audit
                                        </a>
                                        <a href="{{url('laporan_audit')}}/`+full.id_registrasi+`" class="btn-xs btn btn-info" style="color: white;">
                                            <i class="ace-icon fa fa-edit bigger-130" ></i> Laporan Audit Tahap 2
                                        </a>
                                        <a href="{{ url('').Storage::url('public/laporan/download/Laporan Audit1/`+full.file_laporan_audit1+`') }}" class="btn-xs btn btn-green" style="color: white;" download>
                                            <i class="fa fa-download" aria-hidden="true"></i>Laporan Audit Tahap 1
                                        </a>
                                        <br>`+buttonUnduh+`
                                        
                                        <br><br><span class="text-muted small">Pelaksana Pekerjaan:</span><br><i class="fa fa-send fa-fw"></i>`+checkWilayah(full.kode_wilayah)+`
                                    </div>
                                       
                                </div>`  
                    }
                }
            ],

            
            
            bSortable: false,
            ordering: false,
            processing:true,
            serverSide:true,
            bFilter: false,
			lengthChange: false
           

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