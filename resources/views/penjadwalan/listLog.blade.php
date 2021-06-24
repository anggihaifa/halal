@extends('layouts.default')

@section('title', 'Log Audit')

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
       
    </ol>
    
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="label-primary panel-title">Log Audit</h4>
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
                                                <input id="f_mulai"  name="f_mulai" class="form-control" class="form-control">
                                                </input>
                                                <span id="btncalendar" class="add-on">
                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                                    </i>
                                                </span>   
                                                
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
            
            format: "yyyy-mm",
            todayHighlight: true,
        });
        
        $('#f_mulai').datepicker({
          
            format: "yyyy-mm",
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
        var id_user = {!! json_encode($id_user) !!};
        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('datalog')}}",
                data:function(d){
                    d.no_registrasi = $('#no_registrasi').val();
                    d.mulai = $('#f_mulai').val();
                    d.nama_perusahaan = $('#nama_perusahaan').val();
    

                }
            },
            
            columns:[
                
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

                    if(!full.pelaksana2){
                        var jumlah = 1;
                    }else{
                        var jumlah = 2;
                    }

                    /* var mulai = full.mulai.split(" ");
                    var selesai = full.selesai.split(" ");*/

                    var date1 = new Date(full.mulai); 
                    var date2 = new Date(full.selesai); 
                        
                    // To calculate the time difference of two dates 
                    

                    var p1 = full.pelaksana1.split("_");
                    if(full.pelaksana2){
                        var p2 = full.pelaksana2.split("_");
                    }
                    

                    if(id_user == p1[0]){
                        var peran = 'Ketua';
                    }else{
                        var peran = 'Anggota';
                    }

                    if(p1[2] == 'tahap1'){
                        var jenis = "Tahap1 - Remote";

                    }else if(p1[2] == 'tahap2'){
                            var jenis = "Tahap2 - " +full.ktg;

                    }else if(p1[2] == 'tr'){
                            var jenis = "Tehnical Review - Remote";

                    }else if(p1[2] == 'tinjauan'){
                            var jenis = "Tijauan Komite Sertifikasi - Remote";

                    }

                    
                        
                        return `<div class="col-lg-12 row border-left rounded-lg border-primary" >
                                    
                                        
                                    <div class="col-lg-7" style="padding-left:10%; padding-top:2%">
                                        <label class="inline text-center">

                                            <i class="fa fa-calendar text-primary" style="font-size:600%"></i>
                                            <br>
                                            <h3 class="text-grey" style=>`+full.mulai+`</h3>
                                            
                                           
                                            <span class="label label-success"><a style="color: white;">NOMOR AUDIT:`+full.no_registrasi+`</a></span>
                                            

                                            
                                        </label>
                                    </div>
                                    

                                    <div class="col-lg-4 >

                                            <span class="lbl">
                                                <br><i class="fa fa-building text-primary" ></i> 
                                                `+full.nama_perusahaan+`<br>
                                                
                                            
                                            </span>    

                                        
                                            <span>
                                                <i class="fa fa-bars text-primary" >
                                                </i> Detail Audit<br>

                                                <li>
                                                    Jumlah Auditor: `+jumlah+`
                                                </li>
                                                <li>
                                                    Peran: `+peran+`
                                                </li>
                                                <li>
                                                    Skema: `+full.skema+`
                                                </li>
                                                    <li>
                                                    Jenis: `+jenis+`
                                                </li>
                                                
                                            </span> 
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

        $(document).ready(function () {

           

           



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