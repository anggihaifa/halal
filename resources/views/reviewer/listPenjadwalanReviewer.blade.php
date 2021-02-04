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
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">List Registrasi Aktif</a></li>
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
                                            
                                            <label for="kelompok" class="col-lg-2 col-form-label">Kelompok Produk</label>

                                            <div class="col-lg-4">
                                                <select id="kelompok_produk" name="kelompok_produk" class="form-control selectpicker forKelompok" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">--Pilih Kelompok Produk--</option>
                                                    @if(isset($dataKelompok))
                                                        @foreach($dataKelompok as $index => $value)
                                                            <option value="{{$value['kelompok_produk']}}"> - {{$value['kelompok_produk']}}</i></option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            

                                            <label for="kelompok" class="col-lg-2 col-form-label">Jenis Registrasi</label>

                                            <div class="col-lg-4">
                                                <select id="jenis_registrasi" name="jenis_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="">--Pilih Jenis Registrasi--</option>
                                                    @if(isset($dataJenis))
                                                        @foreach($dataJenis as $index => $value)
                                                            <option value="{{$value['jenis_registrasi']}}"> - {{$value['jenis_registrasi']}}</i></option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            @component('components.inputfilter',['name'=> 'perusahaan','label' => 'Perusahaan'])@endcomponent   

                                            
                                            <label class="col-lg-2 col-form-label">Status Registrasi</label>
                                            <div class="col-lg-4">
                                                <select id="status_registrasi" name="status_registrasi" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Status Registrasi--</option>
                                                    <option value="baru">Baru</option>
                                                    <option value="perpanjangan">Perpanjangan</option>
                                                    <option value="pengembangan">Pengembangan</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label">Tanggal Registrasi</label>
                                            <div class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control" placeholder="Tanggal Registrasi" value="" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            <label class="col-lg-2 col-form-label">Status Progress</label>
                                            <div class="col-lg-4">
                                                <select id="status" name="status" class="form-control selectpicker forSearch" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Status Progress--</option>
                                                    <option value="1">Pengajuan Baru</option>
                                                    <option value="2">Melengkapi Berkas</option>
                                                    <option value="3">Verifikasi Data</option>
                                                    <option value="4">Perbaiki Data Berkas</option>
                                                    <option value="5">Konfirmasi Data Berkas</option>
                                                    <option value="6">Akad</option>
                                                    <option value="7">Akad Gagal</option>
                                                    <option value="8">Akad Terkonfirmasi</option>
                                                    <option value="9">Pembayaran</option>
                                                    <option value="10">Nominal Pembayaran Kurang</option>
                                                    <option value="11">Nominal Pembayaran Lebih</option>
                                                    <option value="12">Pembayaran Gagal</option>
                                                    <option value="13">Pembayaran Terkonfirmasi</option>
                                                    <option value="14">Proses Audit Tahap 1</option>
                                                    <option value="15">Proses Audit Tahap 2</option>
                                                    <option value="16">Pelaporan Audit Tahap 2</option>
                                                    <option value="17">Konfirmasi Berita Acara</option>
                                                    <option value="18">Tinjauan Hasil Audit</option>
                                                    <option value="19">Rekomendasi Hasil Pemeriksaan</option>
                                                    <option value="20">Proses Sidang Fatwa</option>
                                                    <option value="21">Pelunasan</option>
                                                    <option value="22">Nominal Pelunasan Kurang</option>
                                                    <option value="23">Nominal Pelunasan Lebih</option>
                                                    <option value="24">Pelunasan Gagal</option>
                                                    <option value="25">Pelunasan Terkonfirmasi</option>
                                                    <option value="26">Proses Penerbitan Sertifikat</option>
                                                    <option value="27">Keputusan Halal/ Haram</option>
                                                    <option value="28">Sertifikat Halal</option>
                                                    <option value="g">Pembayaran Tahap2</option>
                                                    <option value="h">Nominal Pembayaran Tahap2 Kurang</option>
                                                    <option value="i">Nominal Pembayaran Tahap2 Lebih</option>
                                                    <option value="j">Pembayaran Tahap2 Gagal</option>
                                                    <option value="l">Pembayaran Tahap2 Terkonfirmasi</option>
                                                    
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
            <table id="table" class="table table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead class="thead-light">
                    <tr>
                        <th class="text-nowrap valign-middle text-center">No</th>      
                        <th class="text-nowrap valign-middle text-center">Detail</th>                  
                        <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                        <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                        <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>
                        <th class="valign-middle text-center">Status Tahap 1</th>
                        <th class="valign-middle text-center">Status Tahap 2</th>
                        <th class="valign-middle text-center">Status Rapat</th>
                        <th class="valign-middle text-center">Status Tinjauan</th>
                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
                            <div class="form-group">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis1" name="idregis1" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Tanggal Mulai</label>
                             
                                <input id="mulai_audit1"  name="mulai_audit1" class="form-control" data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control"></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>       
                            </div>

                            <div class="form-group">
                              <label>Tanggal Selesai</label>
                              
                                <input  id="selesai_audit1" name="selesai_audit1" class="form-control" data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control"></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                               
                            </div>

                            <div class="form-group">
                                <label>Pelaksana 1</label>
                                <select id="pelaksana1_audit1" name="pelaksana1_audit1" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pelaksana 2</label>
                                <select id="pelaksana2_audit1" name="pelaksana2_audit1" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white">
                                    <option value="">==Pilih Auditor==</option>                                                                        
                                </select>
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

    
    
    
@endsection
@push('scripts')


    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    
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
            // `d` is the original data object for the row
            if(d.pelaksana1_audit1 != null){
                $str1 =  d.pelaksana1_audit1.split("_");
                d.pelaksana1_audit1 = $str1[1];
            }else{
                d.pelaksana1_audit1 ="";
            }


             if(d.pelaksana2_audit1 != null){
                $str2 =  d.pelaksana2_audit1.split("_");
                d.pelaksana2_audit1 = $str2[1];
            
            }else{
                d.pelaksana2_audit1 ="";
            }


            if(d.pelaksana1_audit2 != null){
                $str3 = d.pelaksana1_audit2.split("_");
                d.pelaksana1_audit2 = $str3[1];
            }
            else{
                d.pelaksana1_audit2 ="";
            }


            if(d.pelaksana2_audit2 != null){
                $str4 =  d.pelaksana2_audit2.split("_");
                d.pelaksana2_audit2 = $str4[1];
            }else{
                d.pelaksana2_audit2 ="";
            }

            if(d.pelaksana1_rapat != null){
                $str5 =  d.pelaksana1_rapat.split("_");
                d.pelaksana1_rapat = $str5[1];
            }else{
                d.pelaksana1_rapat ="";
            }

            if(d.pelaksana2_rapat != null){
                $str6 =  d.pelaksana2_rapat.split("_");
                d.pelaksana2_rapat = $str6[1];
            }else{
                d.pelaksana2_rapat ="";
            }

            if(d.pelaksana3_rapat != null){
                $str7 =  d.pelaksana3_rapat.split("_");
                d.pelaksana3_rapat = $str7[1];
            }else{
                d.pelaksana3_rapat ="";
            }

            if(d.pelaksana1_tinjauan != null){
                $str8 =  d.pelaksana1_tinjauan.split("_");
                d.pelaksana1_tinjauan = $str8[1];
            }else{
                d.pelaksana1_tinjauan ="";
            }

            if(d.pelaksana12_tinjauan != null){
                $str9 =  d.pelaksana2_tinjauan.split("_");
                d.pelaksana2_tinjauan = $str9[1];
            }else{
                d.pelaksana2_tinjauan ="";
            }

            if(d.pelaksana3_tinjauan != null){
                $str10 = d.pelaksana3_tinjauan.split("_");
                d.pelaksana3_tinjauan = $str10[1];
            }else{
                d.pelaksana3_tinjauan ="";
            }

        

            return '<table  class="table" cellspacing="0" style="width:100% padding-left:50px;">'+
                '<thead style="background-color:#dff3e3;">'+
                    '<th class="valign-middle text-center">No</th>'+
                    '<th class="valign-middle text-center">Jenis</th>'+
                    '<th class="valign-middle text-center">Mulai Audit</th>'+
                    '<th class="valign-middle text-center">Selesai Audit</th>'+
                    '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    '<th class="valign-middle text-center">Akomodasi</th>'+
                    '<th class="valign-middle text-center">Aksi</th>'+
                    
                '</thead>'+
                '<tr>'+
                    '<td class="valign-middle text-center">1</td>'+
                    '<td class="valign-middle text-center">Audit Tahap 1</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_audit1+'</td>'+
                    '<td class="valign-middle text-center">'+d.selesai_audit1+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_audit1+'</td>'+    
                    '<td class="valign-middle text-center">'+d.pelaksana2_audit1+'</td>'+
                    '<td class="valign-middle text-center"></td>'+ 
                     '<td class="valign-middle text-center"></td>'+ 
                    '<td class="valign-middle text-center"><input type="button" class="btn btn-xs btn-green" style"color:white;" value="Approve"><input type="button" class="btn btn-xs btn-red" style"color:white;" value="Reject"></td>'+    
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">2</td>'+
                    '<td class="valign-middle text-center">Audit Tahap 2</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_audit2+'</td>'+
                    '<td class="valign-middle text-center">'+d.selesai_audit2+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_audit2+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_audit2+'</td>'+ 
                    '<td class="valign-middle text-center"></td>'+ 
                    '<td class="valign-middle text-center">'+d.akomodasi_audit2+'</td>'+  
                    '<td class="valign-middle text-center"><input type="button" class="btn btn-xs btn-green" style"color:white; margin-right:3px;" value="Approve"><input type="button" class="btn btn-xs btn-red" style"color:white;" value="Reject"></td>'+  
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">3</td>'+
                    '<td class="valign-middle text-center">Rapat Auditor</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_rapat+'</td>'+
                    '<td class="valign-middle text-center">'+d.selesai_rapat+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_rapat+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_rapat+'</td>'+ 
                    '<td class="valign-middle text-center" >'+d.pelaksana3_rapat+'</td>'+
                     '<td class="valign-middle text-center"></td>'+ 
                    '<td class="valign-middle text-center"><input type="button" class="btn btn-xs btn-green" style"color:white; margin-right:3px;" value="Approve"><input type="button" class="btn btn-xs btn-red" style"color:white;" value="Reject"></td>'+   
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">4</td>'+
                    '<td class="valign-middle text-center">Tinjauan Komite</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_tinjauan+'</td>'+
                    '<td class="valign-middle text-center">'+d.selesai_tinjauan+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_tinjauan+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_tinjauan+'</td>'+ 
                    '<td class="valign-middle text-center" >'+d.pelaksana3_tinjauan+'</td>'+ 
                     '<td class="valign-middle text-center"></td>'+ 
                    '<td class="valign-middle text-center"><input type="button" class="btn btn-xs btn-green" style"color:white; margin-right:3px;" value="Approve"><input type="button" class="btn btn-xs btn-red" style"color:white;" value="Reject"></td>'+  
                '</tr>'+
                    
               
            '</table>';
        }

        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });


        $(document).ready(function () {

            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

        

            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('datapenjadwalanadmin')}}",
                    data:function(d){
                        d.no_registrasi = $('input[name=no_registrasi]').val();
                        d.perusahaan = $('input[name=perusahaan]').val();
                        d.tgl_registrasi = $('input[name=tgl_registrasi]').val();
                        d.kelompok_produk = $('#kelompok_produk').val();
                        d.jenis_registrasi = $('#jenis_registrasi').val();
                        d.status_registrasi = $('#status_registrasi').val();
                        d.status = $('#status').val();

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
                    {"data":"kelompok"},
                
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkPenjadwalan(full.status_audit1)
                        }
                    },
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkPenjadwalan(full.status_audit2)
                        }
                    },
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkPenjadwalan(full.status_rapat)
                        }
                    },
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkPenjadwalan(full.status_tinjauan)
                        }
                    },
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                    
                            
                          
                            
                            var audit1 = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-target='#modalPenjadwalan1'>Audit Tahap 1</a>`;
                            var audit2 = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-pelaksana1="`+full.pelaksana1_audit1+`" data-pelaksana2="`+full.pelaksana2_audit1+`" data-target='#modalPenjadwalan2'>Audit Tahap 2</a>`;
                            var rapat = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-target='#modalPenjadwalan3'>Rapat Auditor</a>`;
                            var tinjauan = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-target='#modalPenjadwalan4'>Tinjauan Komite Ahli</a>`;

                            //var audit1 ="<button type='button' class='dropdown-item' data-toggle='modal' data-id=\"" + full[0] + "\" data-target='#modalPenjadwalan'>Audit Tahap 1</button>";
                         
                            return `<div class="btn-group m-r-5 show">
                                    <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                    <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                        <a href="{{url('detail_registrasi')}}/`+full.id+`" class="dropdown-item" ><i class="ion-ios-eye"></i> Detail Data</a>

                                        <a href="{{url('detail_unggah_data_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Lihat Dokumen</a>
                                        
                                    </div>
                                </div>`
                        }
                    }
                ],
                'columnDefs': [
                {
                      "targets": [1,2,3,4,5,6,7,8,9],
                      "className": "text-center",
                     
                }],
                
                processing:true,
                serverSide:true,
                order:[[0,'asc']],
                "searching": false,

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
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush