@extends('layouts.default')

@section('title', 'Penjadwalan Reviewer')

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
        <li class="breadcrumb-item"><a href="#">Penjadwalan Reviewer</a></li>
        <li class="breadcrumb-item active"><a href="#">List Penjadwalan Reviewer</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Penjadwalan Reviewer<small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Penjadwalan Reviewer</h4>
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
                                            

                                    
                                            <div class="col-lg-10"></div>
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
                        <th class="text-nowrap valign-middle text-center">No</th>      
                        <th class="text-nowrap valign-middle text-center">Detail</th>                  
                        <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                        <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                        <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>                     
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>
    <div id="modalapprove" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('approvepenjadwalanreviewer')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Approve Penjadwalan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                <tbody>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="id">ID</label>  
                                            <div >
                                                <input id="id"  name="id" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="jenis">Jenis</label>  
                                            <div >
                                                <input id="jenis"  name="jenis" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="pelaksana1">Pelaksana1</label>  
                                            <div >
                                                <input id="pelaksana1"  name="pelaksana1" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="pelaksana2">Pelaksana2</label>  
                                            <div >
                                                <input id="pelaksana2"  name="pelaksana2" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class=" control-label font-weight-bold" for="id">Catatan Penjadwalan</label>  
                                                <div >
                                                    <input type="text" id="catatan_penjadwalan" class="form-control"  name="catatan_penjadwalan" placeholder="" >
                                                
                                                </div>
                                            </div>
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

    <div id="modalreject" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('rejectpenjadwalanreviewer')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Reject Penjadwalan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                <tbody>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="id">ID</label>  
                                            <div >
                                                <input id="id"  name="id" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <div class="form-group" style="display:none">
                                            <label class="control-label font-weight-bold" for="jenis">Jenis</label>  
                                            <div >
                                                <input id="jenis"  name="jenis" type="text" placeholder="" class="form-control " readonly>
                                            
                                            </div>
                                            </div>
                                        </td>
                                    </tr>

                                  
                                  
                                
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class=" control-label font-weight-bold" for="id">Catatan Penjadwalan</label>  
                                                <div >
                                                    <input type="text" id="catatan_penjadwalan" class="form-control"  name="catatan_penjadwalan" placeholder="" >
                                                
                                                </div>
                                            </div>
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

    <style type="text/css">
        td.details-control {
            text-align:center;
            color:forestgreen;
            cursor: pointer;
        }
        tr.shown td.details-control {
            text-align:center; 
            color:red;
        }
    </style>
    
    <script>
        window.addEventListener('load', (event) => {
            $('#modalapprove').find('form').trigger('reset');
            
            $('#modalreject').find('form').trigger('reset');
            
        });

        $('#modalreject').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
    
        
        })

        $('#modalapprove').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
    
        
        })

         $('#modalapprove').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var id = $this.data('id');
            var jenis = $this.data('jenis');
            var catatan_penjadwalan = $this.data('catatan-penjadwalan');
            var pelaksana1 = $this.data('pelaksana1');
            var pelaksana2 = $this.data('pelaksana2');
            
            var modal = $('#modalapprove');
           
          
            if(modal.find('#id').val()){
               
            }else{

               
                modal.find('#id').val(id);

                modal.find('#jenis').val(jenis).change();   
                modal.find('#catatan_penjadwalan').val(catatan_penjadwalan);
                modal.find('#pelaksana1').val(pelaksana1);  
                modal.find('#pelaksana2').val(pelaksana2);        
               
               
                  
                modal.find('#modalapprove').attr('action', function (i,old) {
                   return old + '/' +id;
            });  
            }
           

        });

         $('#modalreject').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var id = $this.data('id');
            var jenis = $this.data('jenis');
            var catatan_penjadwalan = $this.data('catatan-penjadwalan');
            
            var modal = $('#modalreject');
           
          
            if(modal.find('#id').val()){
               
            }else{

               
                modal.find('#id').val(id);

                modal.find('#jenis').val(jenis).change();   
                modal.find('#catatan_penjadwalan').val(catatan_penjadwalan);        
               
               
                  
                modal.find('#modalapprove').attr('action', function (i,old) {
                   return old + '/' +id;
            });  
            }
           

        });

    
    


    


        

         


        function checkNamaAuditor(d,dom) {
            
            $.ajax({

                   
                url: '{{ route('detail_auditor.detail') }}',
                method: 'POST',
                data: {
                     _token: "{{ csrf_token() }}",
                    id: d,
                  
                },
                 success: function (response) {
                    
                        //alert(response);
                        if(response == ""){
                            document.getElementById(dom).innerHTML = "";
                        }else{
                            document.getElementById(dom).innerHTML = response[0];
                        }
                        
                       
                        //response = parseJSON(response);
                        //console.log(response[0]);
                },
               
               
            });   

        }

       
        
         
       function format ( d ) {

           

            if(d.mulai_audit1  == null){

                d.mulai_audit1 ="-";
            }else{
                if (d.mulai_audit1.indexOf('-') > -1){
                    $str_mulai1 =  d.mulai_audit1.split("-");
                    d.mulai_audit1 = $str_mulai1[2]+"-"+$str_mulai1[1]+"-"+$str_mulai1[0];
                }

            }
           
            if(d.mulai_audit2  == null){

                d.mulai_audit2 ="-";
            }else{
                if (d.mulai_audit2.indexOf('-') > -1){
                    $str_mulai2 =  d.mulai_audit2.split("-");
                    d.mulai_audit2 = $str_mulai2[2]+"-"+$str_mulai2[1]+"-"+$str_mulai2[0];
                }

            }
            if(d.selesai_audit1  == null){

                d.selesai_audit1 ="-";
            }else{
                if (d.selesai_audit1.indexOf('-') > -1){
                    $str_selesai1 =  d.selesai_audit1.split("-");
                    d.selesai_audit1 = $str_selesai1[2]+"-"+$str_selesai1[1]+"-"+$str_selesai1[0];
                }

            }

            if(d.selesai_audit2  == null){

                d.selesai_audit2 ="-";
            }else{
                if (d.selesai_audit2.indexOf('-') > -1){
                    $str_selesai2 =  d.selesai_audit2.split("-");
                    d.selesai_audit2 = $str_selesai2[2]+"-"+$str_selesai2[1]+"-"+$str_selesai2[0];
                }

            }

            if(d.mulai_tr  == null){

                d.mulai_tr ="-";
            }else{
                if (d.mulai_tr.indexOf('-') > -1){
                    $str_tr =  d.mulai_tr.split("-");
                    d.mulai_tr = $str_tr[2]+"-"+$str_tr[1]+"-"+$str_tr[0];
                }

            }

            if(d.mulai_tinjauan  == null){
                d.mulai_tinjauan ="-";
            }else{
                if (d.mulai_tinjauan.indexOf('-') > -1){
                    $str_tinjauan =  d.mulai_tinjauan.split("-");
                    d.mulai_tinjauan = $str_tinjauan[2]+"-"+$str_tinjauan[1]+"-"+$str_tinjauan[0];
                }
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


           


            if(d.pelaksana1_audit2 != null){
                
                if (d.pelaksana1_audit2.indexOf('_') > -1){
                    $str3 = d.pelaksana1_audit2.split("_");
                    d.pelaksana1_audit2 = $str3[1];
                }
                
            
            }
            else{
            
                d.pelaksana1_audit2 ="-";
            }


            if(d.pelaksana2_audit2 != null){
                if (d.pelaksana2_audit2.indexOf('_') > -1){
                    $str4 =  d.pelaksana2_audit2.split("_");
                    d.pelaksana2_audit2 = $str4[1];
                }
                
            }else{
                d.pelaksana2_audit2 ="-";
            }

            if(d.pelaksana1_tr != null){
                if (d.pelaksana1_tr.indexOf('_') > -1){
                    $str5 =  d.pelaksana1_tr.split("_");
                    d.pelaksana1_tr = $str5[1];
                }
                
            }else{
                d.pelaksana1_tr ="-";
            }

            if(d.pelaksana2_tr != null){
                if (d.pelaksana2_tr.indexOf('_') > -1){
                    $str6 =  d.pelaksana2_tr.split("_");
                    d.pelaksana2_tr = $str6[1];
                }
                
            }else{
                d.pelaksana2_tr ="-";
            }

        
            if(d.pelaksana1_tinjauan != null){
                if (d.pelaksana1_tinjauan.indexOf('_') > -1){
                    $str8 =  d.pelaksana1_tinjauan.split("_");
                    d.pelaksana1_tinjauan = $str8[1];
                }
            
            }else{
                d.pelaksana1_tinjauan ="-";
            }

            if(d.pelaksana2_tinjauan != null){
                if (d.pelaksana2_tinjauan.indexOf('_') > -1){
                    $str9 =  d.pelaksana2_tinjauan.split("_");
                    d.pelaksana2_tinjauan = $str9[1];
                }
                
            }else{
                d.pelaksana2_tinjauan ="-";
            }

            if(d.status_penjadwalan_audit1 == '3' || d.status != '7_1'){
                btnApprove1 = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Approve</button>';
                btnReject1 = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Reject</button>';
            }else{
                btnApprove1='<button class="btn btn-xs btn-green m-r-5 text-white" data-toggle="modal" data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_audit1+'" data-jenis= "audit1"  data-pelaksana1= "'+d.pelaksana1_audit1+'"   data-target="#modalapprove" >Approve</button>';

                btnReject1 = '<button class="btn btn-xs btn-red m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_audit1+'" data-jenis= "audit1" data-pelaksana1= "'+d.pelaksana1_audit1+'"   data-target="#modalreject" >Reject</button>';
            }

            if(d.status_penjadwalan_audit2 == '3' || d.status != '9_1'){
                btnApprove2 = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Approve</button>';
                btnReject2 = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Reject</button>';
            }else{
                btnApprove2=  '<button class="btn btn-xs btn-green m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_audit2+'" data-jenis= "audit2" data-pelaksana1= "'+d.pelaksana1_audit2+'" data-pelaksana2= "'+d.pelaksana2_audit2+'"   data-target="#modalapprove" >Approve</button>';

                btnReject2 =  '<button class="btn btn-xs btn-red m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_audit2+'" data-jenis= "audit2" data-pelaksana1= "'+d.pelaksana1_audit2+'" data-pelaksana2= "'+d.pelaksana2_audit2+'"    data-target="#modalreject" >Reject</button>';
            }

            if(d.status_penjadwalan_tr == '3' || d.status != '11_1'){
                btnApproveTR = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Approve</button>';
                btnRejectTR = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Reject</button>';
            }else{
                btnApproveTR='<button class="btn btn-xs btn-green m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_tr+'" data-jenis= "tr"  data-pelaksana1= "'+d.pelaksana1_tr+'" data-pelaksana2= "'+d.pelaksana2_tr+'"   data-target="#modalapprove" >Approve</button>';

                btnRejectTR =  '<button class="btn btn-xs btn-red m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_tr+'" data-jenis= "tr" data-pelaksana1= "'+d.pelaksana1_tr+'" data-pelaksana2= "'+d.pelaksana2_tr+'"  data-target="#modalreject" >Reject</button>';
            }

            if(d.status_penjadwalan_tinjauan == '3' || d.status != '13_1'){
                btnApproveTinjauan = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Approve</button>';
                btnRejectTinjauan = '<button class="btn btn-xs btn-grey m-r-5 text-white" disable>Reject</button>';
            }else{
                btnApproveTinjauan= '<button class="btn btn-xs btn-green m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_tinjauan+'" data-jenis= "tinjauan"  data-pelaksana1= "'+d.pelaksana1_tinjauan+'" data-pelaksana2= "'+d.pelaksana2_tinjauan+'"   data-target="#modalapprove" >Approve</button>';

                btnRejectTinjauan =  '<button class="btn btn-xs btn-red m-r-5 text-white" data-toggle="modal"  data-id="'+d.id_regis+'" data-catatan-penjadwalan="'+d.catatan_penjadwalan_tinjauan+'" data-jenis= "tinjauan" data-pelaksana1= "'+d.pelaksana1_tinjauan+'" data-pelaksana2= "'+d.pelaksana2_tinjauan+'"  data-target="#modalreject" >Reject</button>';
            }

        

            return '<table  class="ml-5 col-lg-11 table" cellspacing="0" style="width:100% padding-left:50px;">'+
                    '<thead style="background-color:#dff3e3;">'+
                        '<th class="valign-middle text-center">No</th>'+
                        '<th class="valign-middle text-center">Jenis</th>'+
                        '<th class="valign-middle text-center">Tanggal Audit</th>'+
                        '<th class="valign-middle text-center">KTA/TA</th>'+
                        '<th class="valign-middle text-center">Technical Review/Komite</th>'+
                        '<th class="valign-middle text-center">Status</th>'+
                        '<th class="valign-middle text-center">Aksi</th>'+
                        
                    '</thead>'+
                    '<tr>'+
                    '<td class="valign-middle text-center">A</td>'+
                        '<td class="valign-middle text-center">Audit Tahap 1</td>'+
                        '<td class="valign-middle text-center">'+d.mulai_audit1+' s/d '+d.selesai_audit1+'</td>'+
                        '<td class="valign-middle text-center" >'+d.pelaksana1_audit1+'</td>'+    
                        '<td class="valign-middle text-center">-</td>'+
                        '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_audit1)+'</td>'+
                        '<td class="valign-middle text-center">'+btnApprove1+btnReject1+'</td>'+
                         
                     '</tr>'+
                     '<tr>'+
                     '<td class="valign-middle text-center">B</td>'+
                         '<td class="valign-middle text-center">Audit Tahap 2</td>'+
                         '<td class="valign-middle text-center">'+d.mulai_audit2+' s/d '+d.selesai_audit2+'</td>'+
                         '<td class="valign-middle text-center" >'+d.pelaksana1_audit2+'<br>'+d.pelaksana2_audit2+'</td>'+    
                         '<td class="valign-middle text-center" >-</td>'+ 
                         '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_audit2)+'</td>'+
                         '<td class="valign-middle text-center">'+btnApprove2+btnReject2+
                                 
                            
                         '</td>'+
                     '</tr>'+
                     '<tr>'+
                         '<td class="valign-middle text-center">C</td>'+
                         '<td class="valign-middle text-center">Technical Review/td>'+
                         '<td class="valign-middle text-center">-</td>'+
                         '<td class="valign-middle text-center" >-</td>'+    
                         '<td class="valign-middle text-center" >'+d.pelaksana1_tr+'<br>'+d.pelaksana2_tr+'</td>'+ 
                         '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_tr)+'</td>'+
                         '<td class="valign-middle text-center">'+btnApproveTR+btnRejectTR+
                                 
                             
                         '</td>'+   
                     '</tr>'+
                     '<tr>'+
                         '<td class="valign-middle text-center">D</td>'+
                         '<td class="valign-middle text-center">Tinjauan Komite</td>'+
                         '<td class="valign-middle text-center">-</td>'+
                         '<td class="valign-middle text-center" >-</td>'+    
                         '<td class="valign-middle text-center" >'+d.pelaksana1_tinjauan+'<br>'+d.pelaksana2_tinjauan+'</td>'+ 
                         '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_tinjauan)+'</td>'+
                         '<td class="valign-middle text-center">'+btnApproveTinjauan+btnRejectTinjauan+
                                 
                             
                         '</td>'+
                     '</tr>'+
                         
                 
                 '</table>';
        }

        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });

        var xTable = $('#table').DataTable({
            ajax:{
                url:"{{route('datapenjadwalanreviewer')}}",
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
                {
                    "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                        width:"15px"
                },
                {"data":"no_registrasi"},
                {"data":"nama_perusahaan"},
                {"data":"kelompok"}
            
                
                
            ],
            'columnDefs': [
            {
                    "targets": [0,1,2,3,4],
                    "className": "text-center",
                    
            }],
            
            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,

        });


        $(document).ready(function () {

            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

        

           

            $('#table tbody').on('click', 'td.details-control', function () {
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
             });
        
    
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