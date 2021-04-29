@extends('layouts.default')

@section('title', 'Audit Tahap 1')

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
        <li class="breadcrumb-item active"><a href="#">Audit Tahap 1</a></li>
    </ol>
    
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="label-primary panel-title">Audit Tahap 1</h4>
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
                             <!-- <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapseFilter" style="cursor: pointer; padding: 2px 5px">
                                <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-search.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                <span class="faq-ask">Filter</span>
                            </div>  -->
                            <div id="collapseFilter"  data-parent="#accordionFilter">
                                <div class="card-body border-box" style="overflow: auto;">
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="col-lg-4"></div>
                                            <label class="col-lg-1 col-form-label">Nomor ID</label>
                                            <div class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="nomor_id" name="nomor_id" class="form-control" placeholder="Nomor ID" value="" />
                                                   
                                                </div>
                                            </div>    
                                            <div class="col-lg-3"></div>                                        
                                            <div class="col-lg-4"></div>
                                            <label class="col-lg-1 col-form-label">Tanggal Mulai</label>
                                            <div class="col-lg-4">
                                                <div id="btncalendar" class="input-group date">
                                                    <input type="text" id="mulai_audit1" name="mulai_audit1" class="form-control" placeholder="Tanggal Mulai" value="" />
                                                    <span  class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div> 
                                            <div class="col-lg-3"></div>                                           
                                            <div class="col-lg-5"></div>
                                            <div class="col-lg-4">
                                                <a type="button" class="btn btn-sm btn-success " style="color:white;float:right;">Search</a>
                                               
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </form>            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="table" class="table table-bordered" cellspacing="0" style="width:100%">
                <thead style="display: none;">
                    <tr>
                        <th ></th>                         
                    </tr>
                </thead>
            </table>
            
          
            
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

    
    
@endsection
@push('scripts')


    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    
    <script>



       
        $('#btncalendar').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        

       /* function format ( d ) {


            if(d.mulai_audit1  == null){

                d.mulai_audit1 ="-";
            }
            if(d.selesai_audit1  == null){

                d.selesai_audit1 ="-";
            }
           
        
            if(d.pelaksana1_audit1 != null){
                if (d.pelaksana1_audit1.indexOf('_') > -1)
                {
                    $str1 =  d.pelaksana1_audit1.split("_");
                    d.pelaksana1_audit1 = $str1[1];
                }
               
            }else{
                d.pelaksana1_audit1 ="-";
            }


             if(d.pelaksana2_audit1 != null){

                if (d.pelaksana2_audit1.indexOf('_') > -1){
                    $str2 =  d.pelaksana2_audit1.split("_");
                    d.pelaksana2_audit1 = $str2[1];
                }
                           
            }else{
                d.pelaksana2_audit1 ="-";
            }



            return '<table  class="table" cellspacing="0" style="width:100% padding-left:50px;">'+
                
                '<tr>'+
                    '<td class="valign-middle text-center" style="text-align:left !important"><li>Tanggal Mulai Audit:'+d.mulai_audit1+'</li><li>Selesai Audit:'+d.selesai_audit1+'</li><li>Lokasi Audit:</li><li>Skema Audit:</li><li>Nomor Audit:</li><li>Nomor Kontrak akad:</li></td>'+
                    
                    '<td class="valign-middle text-center"><a href="{{url('detail_registrasi')}}/`+d.id_registrasi+`" class="btn" ><i class="ion-ios-eye"></i> Detail Data</a> <br><a href="{{url('detail_unggah_data_sertifikasi_auditor')}}/`+d.id_registrasi+`" class="btn" ><i class="fa fa-edit"></i> Report Audit Tahap 1</a></td>'+
                   
                '</tr>'+
                
            '</table>';
        }
*/

        $(document).ready(function () {

           

            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('dataaudit1')}}",
                    data:function(d){
                        d.no_registrasi = $('input[name=nomor_id]').val();
                        d.mulai_audit1 = $('input[name=mulai_audit1]').val();
     

                    }
                },
                
                columns:[
                   
                   {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

                          
                         
                            return `<div class="col-lg-12 row border-left rounded-lg border-primary" >
                                       
                                          
                                                    <div class="col-lg-7" style="padding-left:10%; padding-top:2%">
                                                        <label class="inline text-center">

                                                            <i class="fa fa-calendar text-primary" style="zoom:7.0"></i>
                                                            <br>
                                                            <h2 class="text-grey" style=>`+full.mulai_audit1+`</h2>
                                                            <span class="label label-primary"><a style="color: white;">NOMOR ID: `+full.id_registrasi+`</a></span>
                                                            <span class="label label-success"><a style="color: white;">NOMOR AUDIT</a></span>
                                                            <span class="label label-info"><a style="color: white;">NOMOR AKAD</a></span>
     
                                                            
                                                        </label>
                                                    </div>
                                                  

                                                    <div class="col-lg-4 >

                                                            <span class="lbl">
                                                                <br>`+full.nama_perusahaan+`<br>
                                                                Alamat: `+full.alamat_kantor+`<br>
                                                                Lokasi Audit:<br>
                                                                <i class="fa fa-map-marker fa-fw text-primary"></i>Lokasi Audit dari db<br>
                                                                <br>
                                                            </span>    

                                                        
                                                            <span style="font-weight:bold;">
                                                                `+full.pelaksana1_audit1+`<br>
                                                            </span> 
                                                            `+full.pelaksana2_audit1+`<br>

                                                            <br>Skema Audit: Ambil Skema dari DB<br>

                                                           
                                                        
                                                        <a href="{{url('detail_registrasi')}}/`+full.id_registrasi+`"   class="label label-primary" style="color: white;">
                                                            <i class="ace-icon fa fa-eye" ></i style="color: white; margin-right: 5px; ">Detail Data
                                                        </a>
                                                        <a href="{{url('detail_unggah_data_sertifikasi_auditor')}}/`+full.id_registrasi+`" class="label label-info" style="color: white;">
                                                            <i class="ace-icon fa fa-edit bigger-130" ></i> Report Audit Tahap 1
                                                        </a>
                                                        <br><br><span class="text-muted small">Pelaksana Pekerjaan:</span><br><i class="fa fa-send fa-fw"></i>Cabang yang menangani <i class="fa fa-clock-o fa-fw"></i>  
                                                    </div>
                                                    
                                               
                                            
                                           
                                       
                                        
                                    </div>`  
                        }
                    }
                ],

              
               
               
                
                processing:true,
                serverSide:true,
                order:[[0,'asc']],
                bFilter: false,
                bSortable: false,
                bInfo: false,
                lengthChange: false,
                ordering: false

            });



            /*$('#table tbody').on('click', 'td.details-control', function () {
                 var tr = $(this).closest('tr');
                 var tdi = tr.find("i.fa");
                 var row = xTable.row(tr);

                 //console.log(row.data());

                 if (row.child.isShown()) {
                     // This row is already open - close it
                     row.child.hide();
                     tr.removeClass('shown');
                     tdi.first().removeClass('fa-minus-square');
                     tdi.first().addClass('fa-plus-square');
                 }
                 else {
                     // Open this row
                     row.child(format(row.data())).show();
                     tr.addClass('shown');
                     tdi.first().removeClass('fa-plus-square');
                     tdi.first().addClass('fa-minus-square');
                 }
            });*/
        
    
        });

  
     
        
        function dButton(x){
            var disableButton = `<a href="#" class="dropdown-item" style="color:#3dad55;">`+ x +` <i class="ion-ios-checkmark-circle" style='color:#1fe01f;'></i></a>`;
            return disableButton;
        }

        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush