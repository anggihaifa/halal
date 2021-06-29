@extends('layouts.default')

@section('title', 'Registrasi Halal')

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
            <h4 class="label-primary panel-title">Registrasi Halal</h4>
            <div class="panel-heading-btn">
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body">
            <div class="forFilter panel-inverse">
                <div id="dtransfer">
                    <div id="accordionFilter" class="accordion">
                        <!-- begin card -->
                        <div class="card">
                            <div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapseFilter" style="cursor: pointer; padding: 2px 5px">
                                <img class="animated bounceIn " src="{{asset('/assets/img/user/halal-search.png')}}" alt="" style="height: 30px;margin-right: 10px;"> 
                                <span class="faq-ask">Filter</span>
                            </div>
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                            <div id="collapseFilter" class="collapse" data-parent="#accordionFilter">
                                <div class="card-body" style="overflow-y: auto;">
                                    <form id="search-form" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            @component('components.inputfilter',['name'=> 'no_registrasi','label' => 'No Registrasi'])@endcomponent
                                            
                                            @component('components.inputfilter',['name'=> 'nama_perusahaan','label' => 'Perusahaan'])@endcomponent   
                                            
                                            <label class="col-lg-2 col-form-label">Progres Status</label>
                                            <div class="col-lg-4">
                                                <select id="status" name="status" class="form-control"  data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Progres Status--</option>
                                                    <option value="1">Pengajuan Baru</option>
                                                    <option value="2">Menentukan Kebutuhan Audit</option>
                                                    <option value="3">Penawaran Harga dan Akad</option>
                                                    <option value="4">Penerbitan Order Confirmation</option>
                                                    <option value="5">Pembayaran</option>
                                                    <option value="6">Penawaran Harga dan Akad</option>
                                                    <option value="7">Persiapan Audit Tahap 1</option>
                                                    <option value="8">Audit Tahap 1</option>
                                                    <option value="9">Persiapan Audit Tahap 2</option>
                                                    <option value="10">Audit Tahap 2</option>
                                                    <option value="11">Persiapan Tehnical Review</option>
                                                    <option value="12">Tehnical Review</option>
                                                    <option value="13">Persiapan Tinjauan Komite Sertifikasi</option>
                                                    <option value="14">Tinjauan Komite Sertifikasi</option>
                                                    <option value="15">Persiapan Sidang Fatwa Halal</option>
                                                    <option value="16">Sidang Fatwa Halal</option>
                                                    <option value="17">Ketetapan Halal</option>
                                                </select>
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
            
          
        </div>    
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

     <!--modal-->
    <div id="modalPenjadwalan1" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('audit1')}}" method="post" name="registerForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Penjadwalan Audit Tahap 1</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan1">
                        <div class="modal-body">
                            <div class="form-group" style="display:none">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis1" name="idregis1" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Tanggal Mulai</label>
                             
                                <input id="mulai_audit1"  name="mulai_audit1" class="form-control" data-format="dd-mm-yyyy" type="date" class="form-control" required></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>       
                            </div>


                            <div class="form-group">
                                <label>Auditor</label>
                                <select id="pelaksana1_audit1" name="pelaksana1_audit1" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <!-- <div class="form-group">
                                <label>Auditor 2</label>
                                <select id="pelaksana2_audit1" name="pelaksana2_audit1" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div> -->

                            <div class="form-group">
                                <label>Skema audit</label>
                                <select id="skema_audit" name="skema_audit" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                    <option value="">==Pilih Skema Audit==</option>
                                    <option value="SJPH">Sistem Jaminan Produk Halal</option>
                                    <option value="SMH">SMH SNI 99001:2016</option>                                                                        
                                </select>
                            </div>    

                             <div class="form-group">
                                <label>Catatan Perbaikan</label>
                                <input type="text" class="form-control"
                                id="catatan_penjadwalan_audit1" readonly />
                            </div>                                       
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan penjadwalan?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>

    <!--- Modal Audit 2 -->
    <div id="modalPenjadwalan2" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('audit2')}}" method="post" name="registerForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Penjadwalan Audit Tahap 2</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan2">
                        <div class="modal-body">
                            <div class="form-group" style="display:none">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis2" name="idregis2" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Tanggal Mulai</label>
                             
                                <input id="mulai_audit2"  name="mulai_audit2" class="form-control" data-format="dd-mm-yyyy" type="date" class="form-control" required></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar" required>
                                  </i>
                                </span>       
                            </div>

                           

                            <div class="form-group">
                                <label>Saran Ketua Tim Auditor:  </label> <a id="saran1"></a><br>
                                <label>Ketua Tim Auditor</label>
                                <select id="pelaksana1_audit2" name="pelaksana1_audit2" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <!-- <label>Saran Auditor 2 :  </label> <a id="saran2"><b></b></a><br> -->
                                <label>Auditor</label>
                                <select id="pelaksana2_audit2" name="pelaksana2_audit2" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">

                                <label >Kategori Audit</label> 
                                <select id="ktg_audit2" name="ktg_audit2" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" required>
                                    <option value="">==Pilih Kategori Audit==</option>
                                    <option value="Onsite">Onsite Audit</option>
                                    <option value="Remote">Remote Audit</option>                                                                        
                                </select>
       
                            </div>

                            <div class="form-group">
                                <label>Catatan Perbaikan</label>
                                <input type="text" class="form-control"
                                id="catatan_penjadwalan_audit2" readonly />
                            </div>        

                            <!-- <div class="form-group">

                                <label >Akomodasi</label> 
                                <select id="jenis_akomodasi" name="jenis_akomodasi" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Jenis Akomodasi==</option>                                                                        
                                </select>
       
                            </div>

                            <div class="form-group">

                                <label>Pilih</label>
                                </select>
                                <select id="opsi_akomodasi" name="opsi_akomodasi" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Opsi Akomodasi==</option>                                                                        
                                </select>
                            </div>

                           

                            <div id="tAkomodasi" name="tAkomodasi" class="form-group" style="visibility:hidden;display:none;">
                                 <table id="tableAkomodasi" name="tableAkomodasi" class="table table-bordered" >
                                    <thead>
                                        <tr>   
                                            <th>Jenis Akomodasi</th>
                                            <th>Opsi Akomodasi</th>     
                                            <th>Aksi</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
  
                                    </tbody>
                                </table>
                           
                            </div> -->
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-info m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan penjadwalan?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>
    
    <div id="modalPenjadwalan3" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('tehnicalreview')}}" method="post" name="registerForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Penjadwalan Tehnical Review</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan3">
                        <div class="modal-body">
                            <div class="form-group" style="display:none">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis3" name="idregis3" readonly />
                            </div>
                           
                           
                            <!-- <div class="form-group">
                              <label>Tanggal Mulai</label>
                             
                                <input id="mulai_rapat"  name="mulai_rapat" class="form-control" data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" required></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>       
                            </div> -->

                            <div class="form-group">
                                <label>Tehnical Reviwer 1</label>
                                <select id="pelaksana1_tr" name="pelaksana1_tr" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white"required>
                                    <option value="">==Pilih Tehnical Reviewer==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tehnical Reviwer 2</label>
                                <select id="pelaksana2_tr" name="pelaksana2_tr" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Tehnical Reviewer==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Catatan Perbaikan</label>
                                <input type="text" class="form-control"
                                id="catatan_penjadwalan_tr" readonly />
                            </div>    

                            <!-- <div class="form-group">
                                <label>Auditor 3</label>
                                <select id="pelaksana3_tr" name="pelaksana3_tr" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div> -->
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan penjadwalan?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>

    <div id="modalPenjadwalan4" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('tinjauan')}}" method="post" name="registerForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Penjadwalan Tinjauan Komite Sertifikasi</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display:none">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis4" name="idregis4" readonly />
                            </div>
                           
                           
                            <!-- <div class="form-group">
                              <label>Tanggal Mulai</label>
                             
                                <input id="mulai_tinjauan"  name="mulai_tinjauan" class="form-control" data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control"required></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>       
                            </div> -->


                            <div class="form-group">
                                <label>Komite Sertifikasi 1</label>
                                <select id="pelaksana1_tinjauan" name="pelaksana1_tinjauan" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white"required>
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Komite Sertifikasi 2</label>
                                <select id="pelaksana2_tinjauan" name="pelaksana2_tinjauan" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Catatan Perbaikan</label>
                                <input type="text" class="form-control"
                                id="catatan_penjadwalan_tinjauan" readonly />
                            </div>    

                            <!-- <div class="form-group">
                                <label>Komite Sertifikasi 3</label>
                                <select id="pelaksana3_tinjauan" name="pelaksana3_tinjauan" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div> -->
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan penjadwalan?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>

    <div id="modaljadwal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class ="modal-content">
                <table  class="table" cellspacing="0" style="width:100% padding-left:50px;">
                    <thead style="background-color:#dff3e3;">
                        <th class="valign-middle text-center">No</th>
                        <th class="valign-middle text-center">Jenis</th>
                        <th class="valign-middle text-center">Mulai Audit</th>
                        <th class="valign-middle text-center">Kategori</th>
                        <th class="valign-middle text-center">Ketua Tim Auditor</th>
                        <th class="valign-middle text-center">Auditor</th>
                        
                    </thead>
                    <tr>
                        <td class="valign-middle text-center">1</td>
                        <td class="valign-middle text-center">Audit Tahap 1</td>
                        <td class="valign-middle text-center" id="t_mulai1">-</td>
                        <td class="valign-middle text-center">Remote Audit</td>
                        <td class="valign-middle text-center" id="t_p1_a1">d.pelaksana1_audit1</td>    
                        <td class="valign-middle text-center">-</td>
                    </tr>
                    <tr>
                        <td class="valign-middle text-center">2</td>
                        <td class="valign-middle text-center">Audit Tahap 2</td>
                        <td class="valign-middle text-center" id="t_mulai2"></td>
                        <td class="valign-middle text-center"id="ktg_audit2"></td>
                        <td class="valign-middle text-center" id="t_p1_a2"></td>    
                        <td class="valign-middle text-center" id="t_p2_a2"></td>     
                    </tr>
                    <tr>
                        <td class="valign-middle text-center">3</td>
                        <td class="valign-middle text-center">Tehnical Review</td>
                        <td class="valign-middle text-center" id="mulai_tr"></td>
                        <td class="valign-middle text-center">Remote</td>
                        <td class="valign-middle text-center" id="t_p1_tr"></td>    
                        <td class="valign-middle text-center" id="t_p2_tr"></td>    
                    </tr>
                    <tr>
                        <td class="valign-middle text-center">4</td>
                        <td class="valign-middle text-center">Tinjauan Komite</td>
                        <td class="valign-middle text-center" id="mulai_tinjauan"></td>
                        <td class="valign-middle text-center">Remote</td>
                        <td class="valign-middle text-center" id="t_p1_tk" ></td>    
                        <td class="valign-middle text-center" id="t_p2_tk"></td>   
                    </tr>
                        
                    
                </table>
            </div>
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
            $('#modalPenjadwalan1').find('form').trigger('reset');
            $('#modalPenjadwalan2').find('form').trigger('reset');
            $('#modalPenjadwalan3').find('form').trigger('reset');
            $('#modalPenjadwalan4').find('form').trigger('reset');
            $('#modaljadwal').removeData();
        });

        $('#modalPenjadwalan1').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
           //$(this).find('#pelaksana1_audit1').empty();  
            $('#pelaksana1_audit1').selectpicker('destroy');
            $('#pelaksana1_audit1').selectpicker('refresh'); 
           
        })
        $('#modalPenjadwalan2').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $(this).find('#pelaksana1_audit2').empty();
            $(this).find('#pelaksana2_audit2').empty();
        })
        $('#modalPenjadwalan3').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })
        $('#modalPenjadwalan4').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })


        // $('#mulai_audit1').datepicker({ 
        //     dateFormat: 'dd-mm-yy'
        //  });
      
        // $('#mulai_audit2').datepicker({ 
        //     dateFormat: 'dd-mm-yy' 
        // });
       
        // $('#mulai_rapat').datepicker();
      
        // $('#mulai_tinjauan').datepicker();
        

        $('#modalPenjadwalan1').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var data_id = $this.data('id');
            var catatan_penjadwalan_audit1 = $this.data('catatan-penjadwalan-audit1');
            var modal = $('#modalPenjadwalan1');
           
          
            if(modal.find('#idregis1').val()){

            }else{
                modal.find('#idregis1').val(data_id);
                modal.find('#catatan_penjadwalan_audit1').val(catatan_penjadwalan_audit1);
                  
                modal.find('#formpenjadwalan1').attr('action', function (i,old) {
                   return old + '/' + data_id;
            });  
            }
           

        });


        $('#modalPenjadwalan2').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var data_id = $this.data('id');
            var catatan_penjadwalan_audit2 = $this.data('catatan-penjadwalan-audit2');
            var data_saran1 = $this.data('pelaksana1');

            if(data_saran1 != null){
                if (data_saran1.indexOf('_') > -1)
                {
                    $str1 =  data_saran1.split("_");
                    data_saran1 = $str1[1];
                }
            
            }else{
                data_saran1 ="-";
            }
            //console.log(data_saran1);
            //var data_saran2 = $this.data('pelaksana2');
            var modal = $('#modalPenjadwalan2');

           //alert($this.data('pelaksana1'));
           var z = document.getElementById("idregis2"); 

           var x = document.getElementById("saran1"); 
           //var y = document.getElementById("saran2"); 
          
            if(modal.find('#idregis2').val()){

            }else{
                modal.find('#catatan_penjadwalan_audit2').val(catatan_penjadwalan_audit2);
                modal.find("#idregis2").val(data_id);
                x.innerHTML = '<b>'+data_saran1+'</b>' ;
                //modal.find("#saran1").text(data_saran1);
                //y.innerHTML = '<b>'+data_saran2+'</b>' ;
                // $.ajax({

                //     url: '{{ route('jenis_akomodasi.data') }}',
                //     method: 'POST',
                //     data: {
                //          _token: "{{ csrf_token() }}",
                //        /* mulai: $('#mulai_audit1').val(),
                //         selesai: $('#selesai_audit1').val(),
                //         selected_pelaksana1: $('#pelaksana1_audit1').val(),
                //         id_regis: $('#idregis1').val()*/
                //     },
                //     success: function (response) {
                    
                //         $('#jenis_akomodasi').empty();  
                //         $('#jenis_akomodasi').append(new Option('==Pilih Jenis Akomodasi==',''))                       
                //         $.each(response, function (jenis_akomodasi, id) {                                                                    
                //             // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));
                //             $('#jenis_akomodasi').append(new Option(jenis_akomodasi,id))
                //         })

                //         $('#jenis_akomodasi').selectpicker('destroy');
                //         $('#jenis_akomodasi').selectpicker();
                                     
                        
                //     }
                // })
   
            }
        });


         $('#modalPenjadwalan3').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var catatan_penjadwalan_tr = $this.data('catatan-penjadwalan-tr');
            var data_id = $this.data('id');
            var modal = $('#modalPenjadwalan3');
           
          
            if(modal.find('#idregis3').val()){

            }else{
                modal.find('#idregis3').val(data_id);
                modal.find('#catatan_penjadwalan_tr').val(catatan_penjadwalan_tr);
                modal.find('#formpenjadwalan3').attr('action', function (i,old) {
                   return old + '/' + data_id;
                });  
            }

            $.ajax({

                url: '{{ route('auditor_dropdown.dataddtehnicalreview') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    //mulai: $('#mulai_rapat').val(),
                    //selesai: $('#selesai_rapat').val(),
                    //selected_pelaksana1: $('#pelaksana1_tr').val(),
                    //selected_pelaksana2: $('#pelaksana2_tr').val(),
                    id_regis: $('#idregis3').val()
                },
                success: function (response) {
                    //$('#pelaksana1_audit1').empty();   
                    $('#pelaksana1_tr').empty();  

                    $("#pelaksana1_tr").append(new Option('==Pilih Tehnical Reviewer==',''))                       
                    $.each(response, function (name, id) {                                                                    
                        // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));
                        $("#pelaksana1_tr").append(new Option(id +"_"+ name,id +"_"+ name+"_tr"))
                    })
                

                    //$('#pelaksana2_audit1').empty();  
                    $('#pelaksana1_tr').selectpicker('refresh');                       
                    
                }
            })
           

        });



         $('#modalPenjadwalan4').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var catatan_penjadwalan_tinjauan = $this.data('catatan-penjadwalan-tinjauan');
            var data_id = $this.data('id');
            var modal = $('#modalPenjadwalan4');
           

          
            if(modal.find('#idregis4').val()){

               // console.log(data_id);

            }else{
                modal.find('#idregis4').val(data_id);
                modal.find('#catatan_penjadwalan_tinjauan').val(catatan_penjadwalan_tinjauan);
                modal.find('#formpenjadwalan4').attr('action', function (i,old) {
                   return old + '/' + data_id;
                });  
            }
            $.ajax({

                url: '{{ route('komite_dropdown.datakomite') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    //mulai: $('#mulai_tinjauan').val(),
                    //selesai: $('#selesai_tinjauan').val(),
                    //selected_pelaksana1: $('#pelaksana1_tinjauan').val(),
                    //selected_pelaksana2: $('#pelaksana2_tinjauan').val(),
                    id_regis: $('#idregis4').val()
                },
                success: function (response) {
                    //$('#pelaksana1_audit1').empty();                         
                    $('#pelaksana1_tinjauan').empty();  

                    $("#pelaksana1_tinjauan").append(new Option('==Pilih Komite Sertifikasi==',''))                       
                    $.each(response, function (name, id) {                                                                    
                        // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));

                        $("#pelaksana1_tinjauan").append(new Option(id +"_"+ name,id +"_"+ name+"_tinjauan"))
                    })

                    $('#pelaksana1_tinjauan').selectpicker('refresh'); 
                }
            })
           

        });

         $('#modaljadwal').on('show.bs.modal', function(e) {




            var $this = $(e.relatedTarget);
            
            var p1_a1 = $this.data('pelaksana1-audit1');
            var p1_a2 = $this.data('pelaksana1-audit2');
            var p2_a2 = $this.data('pelaksana2-audit2');
            var p1_tr = $this.data('pelaksana1-tr');
            var p2_tr = $this.data('pelaksana2-tr');
            var p1_tk = $this.data('pelaksana1-tinjauan');
            var p2_tk = $this.data('pelaksana2-tinjauan');
            var mulai_audit1 = $this.data('mulai-audit1');
            var mulai_audit2 = $this.data('mulai-audit2');
            var ktg_audit2 = $this.data('ktg-audit2');
            var mulai_tr = $this.data('mulai-tr');
            var mulai_tinjauan = $this.data('mulai-tinjauan');
            var modal = $('#modaljadwal');
            
           
            if(mulai_audit1  == null){

                mulai_audit1 ="-";
            }else{
                if (mulai_audit1.indexOf('-') > -1){
                    $str_mulai1 =  mulai_audit1.split("-");
                    mulai_audit1 = $str_mulai1[2]+"-"+$str_mulai1[1]+"-"+$str_mulai1[0];
                }

            }
           
            if(mulai_audit2  == null){

                mulai_audit2 ="-";
            }else{
                if (mulai_audit2.indexOf('-') > -1){
                    $str_mulai2 =  mulai_audit2.split("-");
                    mulai_audit2 = $str_mulai2[2]+"-"+$str_mulai2[1]+"-"+$str_mulai2[0];
                }

            }

            if(mulai_tr  == null){

                mulai_tr ="-";
            }else{
                if (mulai_tr.indexOf('-') > -1){
                    $str_tr =  mulai_tr.split("-");
                    mulai_tr = $str_tr[2]+"-"+$str_tr[1]+"-"+$str_tr[0];
                }

            }

            if(mulai_tinjauan  == null){
                 mulai_tinjauan ="-";
            }else{
                if (mulai_tinjauan.indexOf('-') > -1){
                    $str_tinjauan =  mulai_tinjauan.split("-");
                    mulai_tinjauan = $str_tinjauan[2]+"-"+$str_tinjauan[1]+"-"+$str_tinjauan[0];
                }
            }
           
           
            


            if(p1_a1 != null){
                if (p1_a1.indexOf('_') > -1)
                {
                    $str1 =  p1_a1.split("_");
                    p1_a1 = $str1[1];
                }
            
            }else{
                p1_a1 ="-";
            }


            if(p1_a2 != null){

                if (p1_a2.indexOf('_') > -1){
                    $str2 =  p1_a2.split("_");
                    p1_a2 = $str2[1];
                }
                        
            }else{
                p1_a2="-";
            }


           


            if(p2_a2 != null){
                if (p2_a2.indexOf('_') > -1){
                    $str4 =  p2_a2.split("_");
                    p2_a2= $str4[1];
                }
                
            }else{
                p2_a2 ="-";
            }

            if(p1_tr != null){
                if (p1_tr.indexOf('_') > -1){
                    $str5 =  p1_tr.split("_");
                    p1_tr = $str5[1];
                }
                
            }else{
                p1_tr ="-";
            }

            if(p2_tr != null){
                if (p2_tr.indexOf('_') > -1){
                    $str6 =  p2_tr.split("_");
                    p2_tr = $str6[1];
                }
                
            }else{
                p2_tr ="-";
            }

            if(p1_tk != null){
                if (p1_tk.indexOf('_') > -1){
                    $str8 =  p1_tk.split("_");
                    p1_tk = $str8[1];
                }
            
            }else{
                p1_tk ="-";
            }

            if(p2_tk != null){
                if (p2_tk.indexOf('_') > -1){
                    $str9 =  p2_tk.split("_");
                    p2_tk = $str9[1];
                }
                
            }else{
                p2_tk ="-";
            }

          
          
        
            modal.find('#t_p1_a1').html(p1_a1);
            modal.find('#t_p1_a2').html(p1_a2);
            modal.find('#t_p2_a2').html(p2_a2);
            modal.find('#t_p1_tr').html(p1_tr);
            modal.find('#t_p2_tr').html(p2_tr);
            modal.find('#t_p1_tk').html(p1_tk);
            modal.find('#t_p2_tk').html(p2_tk);
            modal.find('#t_mulai1').html(mulai_audit1);
            modal.find('#t_mulai2').html(mulai_audit2);
            modal.find('#ktg_audit2').html(ktg_audit2);
            modal.find('#mulai_tr').html(mulai_tr);
            modal.find('#mulai_tinjauan').html(mulai_tinjauan);
                
            modal.find('#modaljadwal').attr('action', function (i,old) {
                return old + '/' + data_id;
            });  
           
        });


        // function checkNamaAuditor(d,dom) {
        //     //var detailNama;
        //     $('#loading-image').show();
        //     $.ajax({

                   
        //         url: '{{ route('detail_auditor.detail') }}',
        //         method: 'POST',
        //         data: {
        //              _token: "{{ csrf_token() }}",
        //             id: d,
                  
        //         },
        //          success: function (response) {
                    
        //                 //alert(response);
        //                 if(response == ""){
        //                     document.getElementById(dom).innerHTML = "";
        //                 }else{
        //                     document.getElementById(dom).innerHTML = response[0];
        //                 }
                        
                       
        //                 //response = parseJSON(response);
        //                 //console.log(response[0]);
        //         },
               
               
        //     });   

        // }

        // var i =0;

        // function deleteAkomodasi(d){
        //     d.closest('tr').remove();

        // }

        // function tambahAkomodasi (d) {
            
            
        //     //var value = 0;
        //     var jenis_a = 'jenis_a['+i+']';
        //     var opsi_a = 'opsi_a['+i+']';

        //     var table = document.getElementById("tableAkomodasi").getElementsByTagName('tbody')[0];;
        //     var row = table.insertRow(0);
        //     var cell1 = row.insertCell(0);
        //     var cell2 = row.insertCell(1);
        //     var cell3 = row.insertCell(2);
        //     //var i =0;

        //     var jenis = document.getElementById("jenis_akomodasi");
        //     var jenisText = jenis.options[jenis.selectedIndex].text;

        //     var opsi = document.getElementById("opsi_akomodasi");
        //     var opsiText = opsi.options[opsi.selectedIndex].text;

        //     cell1.innerHTML = '<input type="text"  class="form-control" name='+jenis_a+' value="'+jenisText+'">';

        //     cell2.innerHTML = '<input type="text" class="form-control"  name='+opsi_a+' value="'+opsiText+'">';

        //     cell3.innerHTML = '<input type="button" class="btn btn-danger btn-sm" id="hapus" style="color:white;" value="X" onClick="deleteAkomodasi(this)">';

        //     i++;

        //     //cell3.innerHTML = opsiText;

        //     console.log(i);

        //     var x = document.getElementById("tAkomodasi");

        //     if(x.style.visibility == "hidden"){

        //          x.style.visibility = "visible";
        //          x.style.display = "block";
        //     }                               
        // }

        // function format ( d ) {

        //     if(d.mulai_audit1  == null){

        //         d.mulai_audit1 ="-";
        //     }
        //     if(d.selesai_audit1  == null){

        //         d.selesai_audit1 ="-";
        //     }
        //     if(d.mulai_audit2  == null){

        //         d.mulai_audit2 ="-";
        //     }
        //     if(d.selesai_audit2  == null){

        //         d.selesai_audit2 ="-";
        //     }
        //     if(d.mulai_tr  == null){

        //         d.mulai_tr ="-";
        //     }
        //     if(d.selesai_tr  == null){

        //         d.selesai_tr="-";
        //     }
        //     if(d.mulai_tinjauan  == null){

        //         d.mulai_tinjauan ="-";
        //     }
        //     if(d.selesai_tinjauan  == null){

        //         d.selesai_tinjauan ="-";
        //     }


        //     if(d.pelaksana1_audit1 != null){
        //         if (d.pelaksana1_audit1.indexOf('_') > -1)
        //         {
        //             $str1 =  d.pelaksana1_audit1.split("_");
        //             d.pelaksana1_audit1 = $str1[1];
        //         }
            
        //     }else{
        //         d.pelaksana1_audit1 ="-";
        //     }


        //     if(d.pelaksana2_audit1 != null){

        //         if (d.pelaksana2_audit1.indexOf('_') > -1){
        //             $str2 =  d.pelaksana2_audit1.split("_");
        //             d.pelaksana2_audit1 = $str2[1];
        //         }
                        
        //     }else{
        //         d.pelaksana2_audit1 ="-";
        //     }


        //     if(d.pelaksana1_audit2 != null){
                
        //         if (d.pelaksana1_audit2.indexOf('_') > -1){
        //             $str3 = d.pelaksana1_audit2.split("_");
        //             d.pelaksana1_audit2 = $str3[1];
        //         }
                
            
        //     }
        //     else{
            
        //         d.pelaksana1_audit2 ="-";
        //     }


        //     if(d.pelaksana2_audit2 != null){
        //         if (d.pelaksana2_audit2.indexOf('_') > -1){
        //             $str4 =  d.pelaksana2_audit2.split("_");
        //             d.pelaksana2_audit2 = $str4[1];
        //         }
                
        //     }else{
        //         d.pelaksana2_audit2 ="-";
        //     }

        //     if(d.pelaksana1_tr != null){
        //         if (d.pelaksana1_tr.indexOf('_') > -1){
        //             $str5 =  d.pelaksana1_tr.split("_");
        //             d.pelaksana1_tr = $str5[1];
        //         }
                
        //     }else{
        //         d.pelaksana1_tr ="-";
        //     }

        //     if(d.pelaksana2_tr != null){
        //         if (d.pelaksana2_tr.indexOf('_') > -1){
        //             $str6 =  d.pelaksana2_tr.split("_");
        //             d.pelaksana2_tr = $str6[1];
        //         }
                
        //     }else{
        //         d.pelaksana2_tr ="-";
        //     }

        //     if(d.pelaksana3_tr != null){
        //         if (d.pelaksana3_tr.indexOf('_') > -1){
        //             $str7 =  d.pelaksana3_tr.split("_");
        //             d.pelaksana3_tr = $str7[1];
        //         }
                
        //     }else{
        //         d.pelaksana3_tr ="-";
        //     }

        //     console.log(d.pelaksana1_tinjauan);
        //     if(d.pelaksana1_tinjauan != null){
        //         if (d.pelaksana1_tinjauan.indexOf('_') > -1){
        //             $str8 =  d.pelaksana1_tinjauan.split("_");
        //             d.pelaksana1_tinjauan = $str8[1];
        //         }
            
        //     }else{
        //         d.pelaksana1_tinjauan ="-";
        //     }

        //     if(d.pelaksana12_tinjauan != null){
        //         if (d.pelaksana2_tinjauan.indexOf('_') > -1){
        //             $str9 =  d.pelaksana2_tinjauan.split("_");
        //             d.pelaksana2_tinjauan = $str9[1];
        //         }
                
        //     }else{
        //         d.pelaksana2_tinjauan ="-";
        //     }

        //     if(d.pelaksana3_tinjauan != null){
        //         if (d.pelaksana3_tinjauan.indexOf('_') > -1){
        //             $str10 = d.pelaksana3_tinjauan.split("_");
        //             d.pelaksana3_tinjauan = $str10[1];
        //         }
            
        //     }else{
        //         d.pelaksana3_tinjauan ="-";
        //     }







        //     return '<table  class="table" cellspacing="0" style="width:100% padding-left:50px;">'+
        //         '<thead style="background-color:#dff3e3;">'+
        //             '<th class="valign-middle text-center">No</th>'+
        //             '<th class="valign-middle text-center">Jenis</th>'+
        //             '<th class="valign-middle text-center">Mulai Audit</th>'+
        //             '<th class="valign-middle text-center">Selesai Audit</th>'+
        //             '<th class="valign-middle text-center">Kategori</th>'+
        //             '<th class="valign-middle text-center">Auditor/Komite</th>'+
        //             '<th class="valign-middle text-center">Auditor/Komite</th>'+
        //             '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    
        //         '</thead>'+
        //         '<tr>'+
        //             '<td class="valign-middle text-center">1</td>'+
        //             '<td class="valign-middle text-center">Audit Tahap 1</td>'+
        //             '<td class="valign-middle text-center">'+d.mulai_audit1+'</td>'+
        //             '<td class="valign-middle text-center">'+d.selesai_audit1+'</td>'+
        //             '<td class="valign-middle text-center">Remote</td>'+
        //             '<td class="valign-middle text-center" >'+d.pelaksana1_audit1+'</td>'+    
        //             '<td class="valign-middle text-center">'+d.pelaksana2_audit1+'</td>'+
        //             '<td class="valign-middle text-center">-</td>'+    
        //         '</tr>'+
        //         '<tr>'+
        //             '<td class="valign-middle text-center">2</td>'+
        //             '<td class="valign-middle text-center">Audit Tahap 2</td>'+
        //             '<td class="valign-middle text-center">'+d.mulai_audit2+'</td>'+
        //             '<td class="valign-middle text-center">'+d.selesai_audit2+'</td>'+
        //             '<td class="valign-middle text-center">'+d.ktg_audit2+'</td>'+
        //             '<td class="valign-middle text-center" >'+d.pelaksana1_audit2+'</td>'+    
        //             '<td class="valign-middle text-center" >'+d.pelaksana2_audit2+'</td>'+ 
        //             '<td class="valign-middle text-center">-</td>'+    
        //         '</tr>'+
        //         '<tr>'+
        //             '<td class="valign-middle text-center">3</td>'+
        //             '<td class="valign-middle text-center">Tehnical Review</td>'+
        //             '<td class="valign-middle text-center">'+d.mulai_tr+'</td>'+
        //             '<td class="valign-middle text-center">'+d.selesai_tr+'</td>'+
        //             '<td class="valign-middle text-center">Remote</td>'+
        //             '<td class="valign-middle text-center" >'+d.pelaksana1_tr+'</td>'+    
        //             '<td class="valign-middle text-center" >'+d.pelaksana2_tr+'</td>'+ 
        //             '<td class="valign-middle text-center" >'+d.pelaksana3_tr+'</td>'+    
        //         '</tr>'+
        //         '<tr>'+
        //             '<td class="valign-middle text-center">4</td>'+
        //             '<td class="valign-middle text-center">Tinjauan Komite</td>'+
        //             '<td class="valign-middle text-center">'+d.mulai_tinjauan+'</td>'+
        //             '<td class="valign-middle text-center">'+d.selesai_tinjauan+'</td>'+
        //             '<td class="valign-middle text-center">Remote</td>'+
        //             '<td class="valign-middle text-center" >'+d.pelaksana1_tinjauan+'</td>'+    
        //             '<td class="valign-middle text-center" >'+d.pelaksana2_tinjauan+'</td>'+ 
        //             '<td class="valign-middle text-center" >'+d.pelaksana3_tinjauan+'</td>'+    
        //         '</tr>'+
                    
            
        //     '</table>';
        // }

        
        function formatRupiah(d, mata_uang) {
            if(mata_uang){
                return Number(d).toLocaleString('id', {
                maximumFractionDigits: 2,
                style: 'currency',
                currency: mata_uang
                });
            }else{
                return Number(d).toLocaleString('id', {
                maximumFractionDigits: 2,
                style: 'currency',
                currency: 'IDR'
                });
            }      
        }

        var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('dataregistrasipelangganaktif')}}",
                    data:function(d){
                        d.no_registrasi = $('#no_registrasi').val();
                        d.nama_perusahaan = $('#nama_perusahaan').val();
                        d.status = $('#status').val();
     

                    }
                },
                
                columns:[
                   
                   {
                        "data":'no_registrasi',
                        
                        "render":function (data,type,full,meta) {

                            
                            // var key = 'base64:Vm437YM3oDMW9KbhaCp4eW+iMguVZQYhnjBixWAWI8U=';
                            // var full.id = encodeURIComponent(CryptoJS.AES.encrypt(full.id.toString(), key).toString());
                            // var full.id_user = encodeURIComponent(CryptoJS.AES.encrypt(full.id_user.toString(), key).toString());
                            // var full.no_registrasi = encodeURIComponent(CryptoJS.AES.encrypt(full.no_registrasi.toString(), key).toString());
                            
                            //console.log(full.id);

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                            var status1 = (full.status == 1) ? dButton('Pengajuan Baru'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data?')">Pengajuan Baru</a>`;
                           
                            var status2 = (full.status == 2) ? dButton('Verifikasi Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Verifikasi Berkas??')">Verifikasi Berkas</a>`;

                            var status2_0 = (full.status == '2_0') ? dButton('Belum Upload Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Berkas??')">Belum Upload Berkas</a>`;

                            var status2_1 = (full.status == '2_1') ? dButton('Menunggu Admin Memverifikasi Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Admin Memverifikasi Berkas??')">Menunggu Admin Memverifikasi Berkas</a>`;

                            var status2_2 = (full.status == '2_2') ? dButton('Perbaikan Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Berkas??')">Perbaikan Berkas</a>`;

                            var status2_3 = (full.status == '2_3') ? dButton('Berkas Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Berkas Terkonfirmasi??')">Berkas Terkonfirmasi</a>`;
                            
                            var status3 = (full.status == 3) ? dButton('Menentukan Kebutuhan Waktu Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menentukan Kebutuhan Waktu Audit??')">Menentukan Kebutuhan Waktu Audit</a>`;

                            var status3_0 = (full.status == '3_0') ? dButton('Belum Ditentukan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Ditentukan??')">Belum Ditentukan</a>`;

                            var status3_1 = (full.status == '3_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Kebutuhan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Kebutuhan Audit??')">Menunggu Reviewer Mengkonfirmasi Kebutuhan Audit</a>`;

                            var status3_2 = (full.status == '3_2') ? dButton('Perbaikan Kebutuhan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Kebutuhan Audit??')">Perbaikan Kebutuhan Audit</a>`;

                            var status3_3 = (full.status == '3_3') ? dButton('Kebutuhan Waktu Audit Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Kebutuhan Waktu Audit Terkonfirmasi??')">Kebutuhan Waktu Audit Terkonfirmasi</a>`;

                            var status4 = (full.status == 4) ? dButton('Penawaran Harga dan Akad'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/4" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penawaran Harga dan Akad??')">Penawaran Harga dan Akad</a>`;

                            var status4_0 = (full.status == '4_0') ? dButton('Belum Upload Bukti Penawaran dan Akad'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/4_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Bukti Penawaran dan Akad??')">Belum Upload Bukti Penawaran dan Akad</a>`;

                            var status4_1 = (full.status == '4_1') ? dButton('Sudah Upload Bukti Penawaran dan Akad'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/4_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Sudah Upload Bukti Penawaran dan Akad??')">Sudah Upload Bukti Penawaran dan Akad</a>`;

                            var status6 = (full.status == 6) ? dButton('Pembayaran'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran??')">Pembayaran</a>`;

                            var status6_0 = (full.status == '6_0') ? dButton('Belum Upload Bukti Bayar'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Bukti Bayar??')">Belum Upload Bukti Bayar</a>`;

                            var status6_1 = (full.status == '6_1') ? dButton('Menunggu Sales Officer Mengkonfirmasi Pembayaran'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Sales Officer Mengkonfirmasi Pembayaran??')">Menunggu Sales Officer Mengkonfirmasi Pembayaran</a>`;

                            var status6_2 = (full.status == '6_2') ? dButton('Pembayaran Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Gagal??')">Pembayaran Gagal</a>`;

                            var status6_3 = (full.status == '6_3') ? dButton('Pembayaran Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Terkonfirmasi??')">Pembayaran Terkonfirmasi</a>`;
                            
                            var status5 = (full.status == 5) ? dButton('Penerbitan Order Confirmation'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan Order Confirmation??')">Penerbitan Order Confirmation (OC)</a>`;

                            var status5_0 = (full.status == '5_0') ? dButton('Belum Upload OC'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload OC??')">Belum Upload OC</a>`;

                            var status5_1 = (full.status == '5_1') ? dButton('Menunggu Pelanggan Upload Ulang OC'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Pelanggan Upload Ulang OC??')">Menunggu Pelanggan Upload Ulang OC</a>`;

                            var status5_2 = (full.status == '5_2') ? dButton('Menunggu Konfirmasi Admin'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Konfirmasi Admin??')">Menunggu Konfirmasi Admin</a>`;

                            var status5_3 = (full.status == '5_3') ? dButton('Penerbitan OC Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan OC Gagal??')">Penerbitan OC Gagal</a>`;

                            var status5_4 = (full.status == '5_4') ? dButton('Penerbitan OC Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_4" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan OC Terkonfirmasi??')">Penerbitan OC Terkonfirmasi</a>`;

                            var status7 = (full.status == 7) ? dButton('Persiapan Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Audit Tahap 1??')">Persiapan Audit Tahap 1</a>`;

                            var status7_0 = (full.status == '7_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status7_1 = (full.status == '7_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status7_2 = (full.status == '7_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status7_3 = (full.status == '7_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status8 = (full.status == 8) ? dButton('Proses Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Audit Tahap 1??')">Proses Audit Tahap 1</a>`;

                            var status8_1 = (full.status == '8_1') ? dButton('Menunggu Auditor Membuat Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Auditor Membuat Laporan Audit??')">Menunggu Auditor Membuat Laporan Audit</a>`;

                            var status8_2 = (full.status == '8_2') ? dButton('Perbaikan Berkas Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Berkas Audit Tahap 1??')">Perbaikan Berkas Audit Tahap 1</a>`;

                            var status8_3 = (full.status == '8_3') ? dButton('Audit Tahap 1 Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Audit Tahap 1 Selesai??')">Audit Tahap 1 Selesai</a>`;

                            var status9 = (full.status == 9) ? dButton('Persiapan Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Audit Tahap 2??')">Persiapan Audit Tahap 2</a>`;

                            var status9_0 = (full.status == '9_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status9_1 = (full.status == '9_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status9_2 = (full.status == '9_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status9_3 = (full.status == '9_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status10 = (full.status == 10) ? dButton('Proses Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Audit Tahap 2??')">Proses Audit Tahap 2</a>`;

                            var status10_0 = (full.status == '10_0') ? dButton('Belum Upload Audit Plan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Audit Plan??')">Belum Upload Audit Plan</a>`;

                            var status10_1 = (full.status == '10_1') ? dButton('Perbaikan Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Audit Tahap 2??')">Perbaikan Audit Tahap 2</a>`;

                            var status10_2 = (full.status == '10_2') ? dButton('Audit Tahap 2 Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Audit Tahap 2 Selesai??')">Audit Tahap 2 Selesai</a>`;

                            
                            var status11 = (full.status == 11) ? dButton('Persiapan Audit Tehnical Review'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Tehnical Review??')"> Persiapan Tehnical Review</a>`;

                            var status11_0 = (full.status == '11_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status11_1 = (full.status == '11_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status11_2 = (full.status == '11_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status11_3 = (full.status == '11_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status12 = (full.status == 12) ? dButton('Proses Tehnical Review'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Tehnical Review??')">Proses Tehnical Review</a>`;

                            var status12_0 = (full.status == '12_0') ? dButton('Reviewer Belum Upload Review Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Reviewer Belum Upload Review Laporan Audit??')">Reviewer Belum Upload Review Laporan Audit</a>`;

                            var status12_1 = (full.status == '12_1') ? dButton('Proses Tehnical Review Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Tehnical Review Selesai??')">Proses Tehnical Review Selesai</a>`;

                           

                            var status13 = (full.status == 13) ? dButton('Persiapan Tinjauan Komite Sertifikasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Tinjauan Komite Sertifikasi??')">Persiapan Tinjauan Komite Sertifikasi</a>`;

                            var status13_0 = (full.status == '13_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status13_1 = (full.status == '13_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status13_2 = (full.status == '13_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status13_3 = (full.status == '13_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status14 = (full.status == 14) ? dButton('Proses Tinjauan Komite Sertifikasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/14" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Tinjauan Komite Sertifikasi??')">Proses Tinjauan Komite Sertifikasi</a>`;

                            var status14_0 = (full.status == '14_0') ? dButton('Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/14_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan RKomite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit??')">Komite Sertifikasi Belum Upload Hasil Tinjauan Laporan Audit</a>`;

                            var status14_1 = (full.status == '14_1') ? dButton('Proses Tinjauan Komite Sertifikasi Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/14_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Tinjauan Komite Sertifikasi Selesai??')">Proses Tinjauan Komite Sertifikasi Selesai</a>`;

                            var status15 = (full.status == 15) ? dButton('Persiapan Sidang Fatwa Halal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/15" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Sidang Fatwa Halal??')">Persiapan Sidang Fatwa Halal</a>`;

                            var status15_0 = (full.status == '15_0') ? dButton('Reviewer Belum Mereview Laporan Hasil Akhir Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/15_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Reviewer Belum Mereview Laporan Hasil Akhir Audit??')">Reviewer Belum Mereview Laporan Hasil Akhir Audit</a>`;

                            var status15_1 = (full.status == '15_1') ? dButton('Laporan Akhir Audit Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/15_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Laporan Akhir Audit Terkonfirmasi??')">Laporan Akhir Audit Terkonfirmasi</a>`;

                            var status16 = (full.status == 16) ? dButton('Proses Sidang Fatwa Halal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/16" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Sidang Fatwa Halal??')">Proses Sidang Fatwa Halal</a>`;

                            var status17 = (full.status == 17) ? dButton('Ketetapan Halal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/17" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Ketetapan Halal??')">Ketetapan Halal</a>`;

                          


                            var upload = `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`"  class="dropdown-item" >Kontrak Akad</a> `;

                            
                            var konfirmAkad = `<a href="{{url('konfirmasi_akad_admin')}}/`+full.id+`/`+full.status_akad+`"  class="dropdown-item" >Konfirmasi Akad</a>` ;
                           
                            var konfirmBayar3 = (full.status ==  '12_3') ? dButton('Konfirmasi dan Upload Invoice'):`<a href="{{url('upload_invoice')}}/`+full.id+`" class="dropdown-item" >Konfirmasi dan Upload Invoice</a>`;
                           
                            var konfirmBayar2 = (full.status == '9_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_tahap2')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;
                           
                            var konfirmBayar1 = (full.status == '5_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;

                            var uploadBeritaAcara = `<a href="{{url('upload_berita_acara_admin')}}/`+full.id+`"   class="dropdown-item">Upload Berita Acara</a> `;

                            var audit1 = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id+` data-catatan-penjadwalan-audit1="`+full.catatan_penjadwalan_audit1+`" data-target='#modalPenjadwalan1' style="cursor:pointer">Audit Tahap 1</a>`;
                            var audit2 = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id+` data-pelaksana1="`+full.pelaksana1_audit1+`" data-catatan-penjadwalan-audit2="`+full.catatan_penjadwalan_audit2+`" data-target='#modalPenjadwalan2' style="cursor:pointer">Audit Tahap 2</a>`;
                            var tehnicalReview = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id+` data-catatan-penjadwalan-tr="`+full.catatan_penjadwalan_tr+`" data-target='#modalPenjadwalan3' style="cursor:pointer">Tehnical Review</a>`;
                            var tinjauan = `<a class="dropdown-item"  data-toggle='modal' data-catatan-penjadwalan-tinjauan="`+full.catatan_penjadwalan_tinjauan+`" data-id=`+full.id+` data-target='#modalPenjadwalan4' style="cursor:pointer">Tinjauan Komite</a>`;

                            var ksb = `<a class="dropdown-item" style="cursor:pointer" href="{{url('upload_ksb')}}/`+full.id+`">Input Berkas Konfirmasi, Surat Tugas dan Berita Acara</a>`;
                            
                            if(full.status_akad == null || full.status_akad == 0){
                                var unduhAkad = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhAkad = `<a href="{{ url('').Storage::url('public/buktiakad/`+full.id_user+`/`+full.file_akad+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.status_tahap1 == null || full.status_tahap1 == 0 ){
                                var unduhBayar1 = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhBayar1 = `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bb_tahap1+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.status_tahap2 == null || full.status_tahap2 == 0 ){
                                var unduhBayar2 = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                              
                            }else{

                                var unduhBayar2 = `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bb_tahap2+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.status_tahap3 == null || full.status_tahap3 == 0 ){
                                var unduhBayar3 = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhBayar3 = `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bb_tahap3+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.file_bap == null ){
                                var unduhBAP = `<a style="background-color:red; color:white; border-radius:4px;">&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;
                            }else{            
                                var unduhBAP = `<a href="{{ url('').Storage::url('public/laporan/upload/BAP/`+full.file_bap+`') }}" style="background-color:green; color:white; border-radius:4px;"  download>&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;
                            } 

                            if(full.file_surat_tugas == null ){
                                var unduhST = `<a  style="background-color:red; color:white; border-radius:4px;">&nbsp;&nbsp;ST&nbsp;&nbsp;</a>`;
                            }else{              
                                var unduhST = `<a href="{{ url('').Storage::url('public/laporan/upload/Surat Tugas/`+full.file_surat_tugas+`') }}" style="background-color:green; color:white; border-radius:4px;"   download>&nbsp;&nbsp;ST&nbsp;&nbsp;</a>`;
                            } 
                            if(full.file_konfirmasi_sk_audit == null ){
                               
                                var unduhKSA = `<a style="background-color:red ; color:white; border-radius:4px;">&nbsp;&nbsp;KSA&nbsp;&nbsp;</a>`;
                            }else{              
                                
                                var unduhKSA = `<a style="background-color:green; color:white; border-radius:4px;" href="{{ url('').Storage::url('public/laporan/upload/Konfirmasi SK Audit/`+full.file_konfirmasi_sk_audit+`') }}" download>&nbsp;&nbsp;KSA&nbsp;&nbsp;</a>`;
                            } 

                            
                            if(full.status == 7 || full.status == '7_1' || full.status == '7_2' || full.status == '7_3' ){
                                  var penjadwalan = audit1  ;
                            }else if(full.status == 9 || full.status == '9_1' || full.status == '9_2' || full.status == '9_3' ){
                                var penjadwalan = audit2+ksb;
                            }else if(full.status == 11 || full.status == '11_1' || full.status == '11_2' || full.status == '11_3'||full.status == 12 || full.status == '12_1' || full.status == '12_2' || full.status == '12_3' ){
                                var penjadwalan = tehnicalReview;
                            }else if(full.status == 13 || full.status == '13_1' || full.status == '13_2' || full.status == '13_3' ){
                                var penjadwalan = tinjauan;
                            }else{
                                var penjadwalan = "Belum masuk tahapan";
                            }
                           
                           

                            //var kw = full.kode_wilayah;

                            var ddCabang = `<form action="{{route('registrasi.updatecabang')}}" method="post">    
                                                @csrf
                                                @method('PUT')
                                               
                                                <input type="text" name="id" value="`+full.id+`" hidden></input>
                                                <select id="kode_wilayah" name="kode_wilayah" class="form-control" onchange="this.form.submit()" @if(Auth::user()->kode_wilayah != 119) disabled @endif>

                                                    <option value="`+full.kode_wilayah+`">`+checkWilayah(full.kode_wilayah)+`</option>
                                                    
                                                    @if($cabang != null)
                                                        @foreach($cabang as $dataCabang =>$value)

                                                            <option value='{{$value->ATTRIBUTE2}}'>{{$value->NAME}}
                                                            </option>
                                                        
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </form>`;                                            
                            
                            return `<div class="col-lg-12 row rounded-sm shadow-sm border pt-3 pb-3 m-0">
                                    
                                   
                                    
                                       
                                        <div class="col-lg-5 row" >
                                            <div class="col-lg-4 d-flex justify-content-center align-items-center">
                                                <i class="fa fa-building text-primary" style="font-size:600%"></i>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <h4 class="text-grey" style=>`+full.nama_perusahaan+`</h4>
                                                <a  href="{{url('detail_registrasi')}}/`+full.id+`"  style="color: white; " class="label label-success">NOMOR ID: `+full.no_registrasi+`</a><br> 
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.kelompok+`<br>
                                                <i class="fa fa-info text-primary" ></i>
                                                `+full.jenis+`<br>
                                                <div style="overflow:hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><i class="fa fa-info text-primary"></i> Alamat: 
                                                `+full.alamat_perusahaan+`</div><br>
                                                <i class="fa fa-info text-primary" ></i> Status Registrasi: 
                                                `+full.status_registrasi+`<br>
                                                <i class="fa fa-info text-primary" ></i> Tanggal Update: 
                                                `+full.updated_at+`<br>
                                                
                                            </div>     
                                            
                                           
                                        </div>
                                      

                                        <div class="col-lg-7 row d-flex justify-content-center" >

                                            <div class="card border-0 ">
                                                <div class="card-header tab-overflow p-t-0 p-b-0 ">
                                                    <ul class="nav nav-tabs card-header-tabs">
                                                        
                                                        <li class="nav-item text-center">
                                                            
                                                            
                                                            <a class="nav-link active" data-toggle="tab" href="#card-tab-1-`+full.id+`">Detail</a>
                                                        </li>
                                                      
                                                        <li class="nav-item text-center">
                                                            
                                                            <a class="nav-link" data-toggle="tab" href="#card-tab-2-`+full.id+`">Akad</a>
                                                        </li>
                                                        <li class="nav-item text-center">
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-4-`+full.id+`">Penjadwalan</a>
                                                        </li>
                                                        <li class="nav-item text-center">
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-3-`+full.id+`">Pembayaran</a>
                                                        </li>
                                                       
                                                       
                                                        
                                                        

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body p-0 m-0" >
                                                <div class="tab-content p-0 m-0">
                                                    <div class="tab-pane fade active show" id="card-tab-1-`+full.id+`">

                                                        <table class="table table-sm"> 
                                                        <tr>
                                                            <td class="text-center"  style="width:20%">Progres</td>
                                                            <td class="text-center"  style="width:10%">Status Berkas</td>
                                                            <td class="text-center"  style="width:25%">Cabang Pelaksana</td>
                                                            <td class="text-center"  style="width:10%">Aksi</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                        <td class="text-center align-middle"  style="width:20%">
                                                            `+checkProgress(full.status)+`
                                                        </td>
                                                        <td class="text-center align-middle"  style="width:20%">
                                                            `+checkStatusBerkas(full.status_berkas)+`
                                                        </td>

                                                        <td class="text-center align-middle" style="width:25%">
                                                            `+ddCabang+`
                                                               
                                                            
                                                        
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            <div class="btn-group m-r-5 show">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <a href="{{url('verifikasi_dokumen_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit">

                                                                    </i> Verifikasi Dokumen
                                                                </a>
                                                                <div class="dropdown-divider"></div>

                                                                <div class="dropdown-button-title">Update Progress</div>`+status1+status2+status3+status4+status5+status6+status7+status8+status9+status10+status11+status12+status13+status14+status15+status16+status17+`
                                                            </div> 
                                                        </div>
                                                        </td>
                                                        </tr>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade" id="card-tab-2-`+full.id+`">

                                                        <table class="table table-sm"> 
                                                        <tr>
                                                            <td class="text-center">Tipe</td>
                                                            <td class="text-center">Status</td>
                                                            <td class="text-center">Total Biaya</td>
                                                            <td class="text-center">Bukti Akad</td>
                                                           
                                                        </tr>
                                                        
                                                        <tr>
                                                        <td class="text-center">
                                                            Akad
                                                        </td>
                                                        <td class="text-center align-middle" style="max-width:20%;">
                                                            `+checkStatusAkad(full.status_akad)+`
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            `+formatRupiah(full.total_biaya,  full.mata_uang)+`
                                                        </td>
                                                        
                                                        <td class="text-center align-middle">
                                                            `+unduhAkad+`

                                                        </td>

                                                       
                                                        </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="card-tab-3-`+full.id+`">

                                                        <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-center">Status Tahap 1</td>
                                                            <td class="text-center">Status Tahap 2</td>
                                                            <td class="text-center">Status Pelunasan</td>
                                                            <td class="text-center">Nominal Total</td>
                                                      
                                                        </tr>
                                                        
                                                        <tr>
                                                       
                                                        <td class="text-center align-middle"  style="max-width:20%;">
                                                            `+checkStatusPembayaran(full.status_tahap1)+`
                                                        </td>
                                                        <td class="text-center align-middle"  style="max-width:20%;">
                                                            `+checkStatusPembayaran(full.status_tahap2)+`
                                                        </td>
                                                        <td class="text-center align-middle"  style="max-width:20%;">
                                                            `+checkStatusPembayaran(full.status_tahap3)+`
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            `+formatRupiah(full.total_biaya,  full.mata_uang)+`
                                                        </td>
                                                         
                                                       
                                                        </table>
                                                    </div>  
                                                    <div class="tab-pane fade" id="card-tab-4-`+full.id+`">

                                                        <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-center align-middle">Status Tahap 1</td>
                                                            <td class="text-center align-middle">Status Tahap 2</td>
                                                            <td class="text-center align-middle">Status TR</td>
                                                            <td class="text-center align-middle">Status KS</td>
                                                           
                                                            <td class="text-center align-middle">File</td>
                                                            <td class="text-center align-middle">Aksi</td>
                                                        </tr>

                                                       
                                                        
                                                        <tr>
                                                           
                                                            <td class="text-center align-middle"  style="max-width:20%;">
                                                                `+checkPenjadwalan(full.status_penjadwalan_audit1)+`
                                                            </td>
                                                            
                                                            <td class="text-center align-middle"  style="max-width:20%;">
                                                                `+checkPenjadwalan(full.status_penjadwalan_audit2)+`
                                                            </td>
                                                            <td class="text-center align-middle"  style="max-width:20%;">
                                                                `+checkPenjadwalan(full.status_penjadwalan_tr)+`
                                                            </td>
                                                            
                                                            <td class="text-center align-middle"  style="max-width:20%;">
                                                                `+checkPenjadwalan(full.status_penjadwalan_tinjauan)+`
                                                            </td>
                                                            <td>
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <td class="text-center">
                                                                        `+unduhBAP+`
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td class="text-center">
                                                                        `+unduhST+`
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                        `+unduhKSA+`
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            
                                                            <td class="text-center align-middle">
                                                                <table class="table-borderless text-center align-middle">
                                                                <tr>
                                                                    <td class="text-center align-middle">
                                                                        <i class="fa fa-eye" style="cursor:pointer" aria-hidden="true" data-toggle='modal' data-pelaksana1-audit1='`+full.pelaksana1_audit1+`' data-pelaksana1-audit2='`+full.pelaksana1_audit2+`' data-pelaksana2-audit2='`+full.pelaksana2_audit2+`' data-pelaksana1-tr='`+full.pelaksana1_tr+`' data-pelaksana2-tr='`+full.pelaksana2_tr+`' data-pelaksana1-tinjauan='`+full.pelaksana1_tinjauan+`' data-pelaksana2-tinjauan='`+full.pelaksana2_tinjauan+`' 
                                                                        data-mulai-audit1='`+full.mulai_audit1+`' 
                                                                        data-mulai-audit2='`+full.mulai_audit2+`' data-ktg-audit2='`+full.ktg_audit2+`' data-mulai-audit1='`+full.mulai_audit1+`' 
                                                                        data-mulai-audit2='`+full.mulai_audit2+`' data-mulai-tr='`+full.mulai_tr+`' 
                                                                        data-mulai-tinjauan='`+full.mulai_tinjauan+`'  data-target='#modaljadwal'></i>

                                                                    </td>
                                                                </tr>
                                                                <tr >
                                                                    <td class="text-center align-middle">

                                                                    <div class="btn-group m-r-5 show">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true">
                                                                            <b class="ion-ios-arrow-down"></b>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end"> `
                                                                            +penjadwalan+
                                                                        `</div>
                                                                    </div>
                                                                    </td>
                                                                   

                                                                </tr>
                                                                </table>
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        </table>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>`  
                        }
                    }
                ],
                
              
               
               //tambahkan bkti bayar 1,2,3, bkti kontrak akad, berita acara,
                
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

            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

           
           
            $('#modaljadwal').on('hidden.bs.modal', function () {
                $(this).removeData();
            })

            $('#mulai_audit1').on('change', function () {
                $.ajax({

                    url: '{{ route('dropdown1.dataauditor') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        mulai: $('#mulai_audit1').val(),
                        // selesai: $('#selesai_audit1').val(),
                        //selected_pelaksana1: $('#pelaksana1_audit1').val(),
                        id_regis: $('#idregis1').val()
                    },
                    success: function (response) {
                    
                        $('#pelaksana1_audit1').empty();  
                        $("#pelaksana1_audit1").append(new Option('==Pilih Auditor==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));
                            $("#pelaksana1_audit1").append(new Option(id +"_"+ name,id +"_"+ name+"_tahap1"))
                        })
                         $('#pelaksana1_audit1').selectpicker('refresh');
                         //$('#pelaksana2_audit1').empty();                         
                        
                    }
                })
            });
           
            $('#mulai_audit2').on('change', function () {
                $.ajax({

                    url: '{{ route('dropdown2.dataauditor') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        mulai: $('#mulai_audit2').val(),
                        // selesai: $('#selesai_audit2').val(),
                        selected_pelaksana1: $('#pelaksana1_audit2').val(),
                        id_regis: $('#idregis2').val()
                    },
                    success: function (response) {
                        //$('#pelaksana1_audit1').empty();   
                         $('#pelaksana1_audit2').empty();  

                        $("#pelaksana1_audit2").append(new Option('==Pilih Auditor==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));
                            $("#pelaksana1_audit2").append(new Option(id +"_"+ name,id +"_"+ name+"_tahap2"))
                        })
                         $('#pelaksana1_audit2').selectpicker('refresh');
                         //$('#pelaksana2_audit1').empty();                         
                        
                    }
                })
            });

           

            $('#pelaksana1_audit2').on('change', function () {
                $.ajax({

                    url: '{{ route('dropdown2.dataauditor') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        mulai: $('#mulai_audit2').val(),
                        //selesai: $('#selesai_audit2').val(),
                        selected_pelaksana1: $('#pelaksana1_audit2').val(),
                        id_regis: $('#idregis2').val()
                    },
                    success: function (response) {
                        //$('#pelaksana1_audit1').empty();                         
                        $('#pelaksana2_audit2').empty();  

                        $("#pelaksana2_audit2").append(new Option('==Pilih Auditor==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));

                            $("#pelaksana2_audit2").append(new Option(id +"_"+ name,id +"_"+ name+"_tahap2"))
                        })
                         $('#pelaksana2_audit2').selectpicker('refresh');
                    }
                })

                
            });

           
            $('#pelaksana1_tr').on('change', function () {
                $.ajax({

                    url: '{{ route('auditor_dropdown.dataddtehnicalreview') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        //mulai: $('#mulai_rapat').val(),
                        //selesai: $('#selesai_rapat').val(),
                        selected_pelaksana1: $('#pelaksana1_tr').val(),
                        selected_pelaksana2: $('#pelaksana2_tr').val(),
                        id_regis: $('#idregis3').val()
                    },
                    success: function (response) {
                        //$('#pelaksana1_audit1').empty();                         
                        $('#pelaksana2_tr').empty();  

                        $("#pelaksana2_tr").append(new Option('==Pilih Auditor==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));

                            $("#pelaksana2_tr").append(new Option(id +"_"+ name,id +"_"+ name+"_tr"))
                        })
                        $('#pelaksana2_tr').selectpicker('refresh'); 
                    }
                })
            });

            

            $('#pelaksana1_tinjauan').on('change', function () {
                $.ajax({

                    url: '{{ route('komite_dropdown.datakomite') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        //mulai: $('#mulai_tinjauan').val(),
                        //selesai: $('#selesai_tinjauan').val(),
                        selected_pelaksana1: $('#pelaksana1_tinjauan').val(),
                        selected_pelaksana2: $('#pelaksana2_tinjauan').val(),
                        id_regis: $('#idregis4').val()
                    },
                    success: function (response) {
                        //$('#pelaksana1_audit1').empty();                         
                        $('#pelaksana2_tinjauan').empty();  

                        $("#pelaksana2_tinjauan").append(new Option('==Pilih Komite Ahli==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));

                            $("#pelaksana2_tinjauan").append(new Option(id +"_"+ name,id +"_"+ name+"_tinjauan"))
                        })

                        $('#pelaksana2_tinjauan').selectpicker('refresh'); 
                    }
                })
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