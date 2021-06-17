@extends('layouts.default')

@section('title', 'List Keuangan Registrasi Halal')

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
            <h4 class="label-primary panel-title">List Keuangan Registrasi Halal</h4>
            <div class="panel-heading-btn">
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body">
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
                                            <label class="col-lg-1 col-form-label">Nama Perusahaan</label>
                                            <div class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="" />
                                                   
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
            <table id="table" class="table " cellspacing="0" style="width:100%">
                <thead style="display: none;">
                    <tr>
                        <th ></th>                         
                    </tr>
                </thead>
            </table>
            
          
            
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

     <div id="modalbayar1" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('registrasi.konfirmasipembayaran')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload Bukti Pembayaran Tahap 1</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="id1">ID</label>  
                            <div >
                                <input id="id1"  name="id1" type="text" placeholder="" class="form-control " readonly>
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" control-label" for="id">Bukti Pembayaran</label>  
                            <div >
                                <input id="bukti_bayar1"  name="bukti_bayar1" type="file" placeholder="" >
                            
                            </div>
                        </div>
                    </div>
                    <div class = "modal-footer">
                        <div >
                            <button class="btn btn-sm btn-success" type="submit" >Unggah</button>
                        
                        </div>
                    </div>
                </div>
            </form>

           
            
        </div>
    </div>   

    <div id="modalbayar2" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('registrasi.konfirmasipembayaranusertahap2')}}" method="post"   enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload Bukti Pembayaran Tahap 2</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="id2">ID</label>  
                            <div >
                                <input id="id2"  name="id2" type="text" placeholder="" class="form-control " readonly>
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" control-label" for="id">Bukti Pemabayaran</label>  
                            <div >
                                <input id="bukti_bayar2"  name="bukti_bayar2" type="file" placeholder="" >
                            
                            </div>
                        </div>
                    </div>
                    <div class = "modal-footer">
                        <div >
                            <button class="btn btn-sm btn-success" type="submit" >Unggah</button>
                        
                        </div>
                    </div>
                </div>
            </form>

           
            
        </div>
    </div>   
    <div id="modalbayar3" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('registrasi.konfirmasipelunasanuser')}}" method="post"   enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload Bukti Pelunasan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        <div class="form-group">
                            <label class="control-label" for="id3">ID</label>  
                            <div >
                                <input id="id3"  name="id3" type="text" placeholder="" class="form-control " readonly>
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" control-label" for="id">Bukti Pelunasan</label>  
                            <div >
                                <input id="bukti_bayar3"  name="bukti_bayar3" type="file" placeholder="" >
                            
                            </div>
                        </div>
                    </div>
                    <div class = "modal-footer">
                        <div >
                            <button class="btn btn-sm btn-success" type="submit" >Unggah</button>
                        
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

    
    <script>


        $('#modalbayar1').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var id = $this.data('id');
            var modal = $('#modalbayar1');

            modal.find('#id1').val(id);
            modal.find('#modalbayar1').attr('action', function (i,old) {
            return old + '/' + id;

            });

        });

 
        $('#modalbayar2').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var id = $this.data('id');
            var modal = $('#modalbayar2');

            modal.find('#id2').val(id);
            modal.find('#modalbayar2').attr('action', function (i,old) {
            return old + '/' + id;

            });

        });
        
        $('#modalbayar3').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            var id = $this.data('id');
            var modal = $('#modalbayar3');

            modal.find('#id3').val(id);
            modal.find('#modalbayar3').attr('action', function (i,old) {
            return old + '/' + id;

            });

        });

        
        $('#btncalendar').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        
        function formatRupiah(d) {
            return Number(d).toLocaleString('id', {
              maximumFractionDigits: 2,
              style: 'currency',
              currency: 'IDR'
            });
        }
      
        $(document).ready(function () {

           

            var xTable = $('#table').DataTable({
               
                
                columns:[
                   
                   {
                        "data":'no_registrasi',
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {
                       
                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                            var uploadAkad =  `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`"  class="dropdown-item" >Upload Kontrak Akad</a> `;

                            
                            var konfirmAkad = `<a href="{{url('konfirmasi_akad_admin')}}/`+full.id+`/`+full.status_akad+`"  class="dropdown-item" >Konfirmasi Akad</a>` ;
                           
                            var konfirmBayar3 = (full.status ==  '12_3') ? dButton('Konfirmasi dan Upload Invoice'):`<a href="{{url('upload_invoice')}}/`+full.id+`" class="dropdown-item" >Konfirmasi dan Upload Invoice</a>`;
                           
                            var konfirmBayar2 = (full.status == '9_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_tahap2')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;
                           
                            var konfirmBayar1 = (full.status == '6_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;

                            var uploadBeritaAcara = `<a href="{{url('upload_berita_acara_admin')}}/`+full.id+`"   class="dropdown-item">Upload Berita Acara</a> `;
                            
                            if(full.status_akad == null || full.status_akad == 0 || full.status_akad == 1 ){
                                var unduhAkad = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhAkad = `<a href="{{ url('').Storage::url('public/buktiakad/`+full.id_user+`/`+full.berkas_akad+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.status_tahap1 == null || full.status_tahap1 == 0 ){
                                var unduhBayar1 = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhBayar1 = `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bb_tahap1+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            }
                            if(full.status_oc == null || full.status_oc == 0 ){
                                var unduhOC = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                                                                             
                            }else{

                                var unduhOC = `<a href="{{ url('').Storage::url('public/buktiOC/`+full.id_user+`/`+full.file_oc+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
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
                            if(full.status_berita_acara == null || full.status_berita_acara == 0 ){
                                var unduhBeritaAcara = `<a class="btn btn-grey btn-xs" disableButton>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;

                                var unduhBeritaAcara = `<a href="{{ url('').Storage::url('public/beritaacara/`+full.id_user+`/`+full.file_berita_acara+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`;
                            } 
                            var upload_OC = `<a href="{{url('upload_oc_admin')}}/`+full.id+`"  class="dropdown-item" >Upload OC</a> `;

                            
                            var konfirm_OC = `<a href="{{url('konfirmasi_oc_admin')}}/`+full.id+`/5_4"  class="dropdown-item" >Konfirmasi OC</a>` ;
                           

                            //var kw = full.kode_wilayah;

                            var ddCabang = `<form action="{{route('registrasi.updatecabang')}}" method="post">    
                                                @csrf
                                                @method('PUT')
                                               
                                                <input type="text" name="id" value="`+full.id+`" hidden></input>
                                                <select id="kode_wilayah" name="kode_wilayah" class="form-control" onchange="this.form.submit()">

                                                    <option value="`+full.kode_wilayah+`">`+checkWilayah(full.kode_wilayah)+`</option>

                                                   @if($cabang != null)
                                                    @foreach($cabang as $dataCabang =>$value){

                                                        <option value='{{$value->ATTRIBUTE2}}'>{{$value->NAME}}
                                                        </option>
                                                      
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </form>`;
                            
                            return `<div class="col-lg-12 row border-left rounded-lg border-primary" >
                                    
                                   
                                    
                                       
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
                                                <i class="fa fa-info text-primary" ></i> Alamat: 
                                                `+full.alamat_perusahaan+`<br>
                                                <i class="fa fa-info text-primary" ></i> Status Registrasi: 
                                                `+full.status_registrasi+`<br>
                                                <i class="fa fa-info text-primary" ></i> Tanggal Update: 
                                                `+full.updated_at+`<br>
                                                
                                            </div>     
                                            
                                           
                                        </div>
                                      

                                        <div class="col-lg-7 row d-flex justify-content-center " >

                                            <div class="card border-0 col-lg-12 align-items-center">
                                                <div class="card-header  tab-overflow   p-t-0 p-b-0 ">
                                                    <ul class="nav nav-tabs card-header-tabs">
                                                        
                                                        <li class="nav-item text-center">
                                                            
                                                            <a class="nav-link active" data-toggle="tab" href="#card-tab-2-`+full.id+`">Akad</a>
                                                        </li>
                                                        <li class="nav-item text-center">
                                                            
                                                            
                                                            <a class="nav-link " data-toggle="tab" href="#card-tab-1-`+full.id+`">Penerbitan OC</a>
                                                        </li>
                                                       
                                                       
                                                        <li class="nav-item text-center">
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-3-`+full.id+`">Pembayaran</a>
                                                        </li>
                                                       
                                                       
                                      
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content p-0 m-0">
                                                   
                                                    <div class="tab-pane active show  fade" id="card-tab-2-`+full.id+`">

                                                        <table class="table table-sm"> 
                                                        <tr>
                                                            <td class="text-center">Tipe</td>
                                                            <td class="text-center">Status</td>
                                                            <td class="text-center">Total Biaya</td>
                                                            <td class="text-center">Bukti Akad</td>
                                                            <td class="text-center">Aksi</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                        <td class="text-center">
                                                            Akad
                                                        </td>
                                                        <td class="text-center align-middle" style="width:20%">
                                                            `+checkStatusAkad(full.status_akad)+`
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            `+formatRupiah(full.total_biaya_sertifikasi)+`
                                                        </td>
                                                        
                                                        <td class="text-center align-middle">
                                                            `+unduhAkad+`

                                                        </td>

                                                        <td class="text-center align-middle">
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <div class="dropdown-button-title">Update Progress</div>`+uploadAkad+`
                                                                </div> 
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade " id="card-tab-1-`+full.id+`">
                                                        <table class="table table-sm"> 
                                                            <tr>
                                                                <td class="text-center"  style="width:20%">Status OC</td>

                                                                <td class="text-center"  style="width:20%">Berkas OC</td>
                                                                
                                                                <td class="text-center"  style="width:10%">Aksi</td>
                                                            </tr>
                                                        
                                                        <tr>
                                                            <td class="text-center align-middle"  style="width:20%">
                                                                `+checkStatusPenerbitanOrderConfirmation(full.status_oc)+`
                                                            </td>

                                                            <td class="text-center align-middle">
                                                            `+unduhOC+`

                                                        </td>

                                                            

                                                            <td class="text-center align-middle">
                                                                <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end"> 
                                                                    <div class= "dropdown-button-title"> Update Progress </div>`+upload_OC+`
                                                                </div> 
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade" id="card-tab-3-`+full.id+`">

                                                        <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-center">Tipe</td>
                                                            <td class="text-center">Status</td>
                                                            <td class="text-center">Nominal</td>
                                                            <td class="text-center">Bukti Transfer</td>
                                                            <td class="text-center">Aksi</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                Pembayaran 1
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkStatusPembayaran(full.status_tahap1)+`
                                                            </td>

                                                            <td class="text-center align-middle">
                                                                `+formatRupiah(full.nominal_tahap1)+`
                                                            </td>
                                                            
                                                            <td class="text-center align-middle">
                                                                `+unduhBayar1+`

                                                            </td>

                                                            <td class="text-center align-middle">
                                                                <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modalbayar1' >Unggah</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                Pembayaran 2
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkStatusPembayaran(full.status_tahap2)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+formatRupiah(full.nominal_tahap2)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+unduhBayar2+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                            
                                                                <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modalbayar2' >Unggah</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                Pelunasan 
                                                            </td>
                                                            <td class="text-center align-middle"> 
                                                                `+checkStatusPembayaran(full.status_tahap3)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+formatRupiah(full.nominal_tahap3)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+unduhBayar3+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                            
                                                                <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modalbayar3' >Unggah</button>
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
                // processing:true,
                // serverSide:true,
                // //bFilter: false,
                // //bSortable: false,              
                // ordering: false 
               
                bSortable: false,
                ordering: false,
                processing:true,
                serverSide:true,
                ajax:"{{route('datakeuangan')}}",
               
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