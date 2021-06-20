@extends('layouts.default')

@section('title', 'Tehnical Review')

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
        <li class="breadcrumb-item"><a href="#">Tehnical Review</a></li>
        <li class="breadcrumb-item active"><a href="#">List Tehnical Review</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Tehnical Review  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Tehnical Review</h4>
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
                                                    <option value="14">Proses Tehnical Review</option>
                                                    <
                                                    
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
                        <th class="valign-middle text-center">No</th>      
                        <th class="valign-middle text-center">No. Registrasi</th>
                        <th class="valign-middle text-center">Perusahaan</th>
                        <th class="valign-middle text-center">Jenis Produk</th>
                        <th class="valign-middle text-center" style="max-width:20%">Auditor 1</th>
                        <th class="valign-middle text-center" style="max-width:20%">Auditor 2</th>
                        <th class="valign-middle text-center" >Unduh</th>
                        
                        <th class="valign-middle text-center" style="max-width:20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>

    <div id="modaltr" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="{{route('storelaporantr')}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Review Laporan Audit</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class = "modal-body">
                        

                        <div>
                            <table class="table  table-sm table-borderless border-none">
                            
                                <thead class="table-success">   
                                <th >Upload File</th>

                                </thead>
                                <tbody>
                                    <tr>
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
                                            <label class=" control-label font-weight-bold" for="id">Review Laporan Audit</label>  
                                            <div >
                                                <input id="file_laporan_tr"  name="file_laporan_tr" type="file" placeholder="" >
                                            
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
                                <th >Hasil Tehnical Review Review</th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class=" control-label font-weight-bold" for="id">Catatan Tehnical Review</label>  
                                                <div >
                                                    <input type="text" id="catatan_tr" class="form-control"  name="catatan_tr" placeholder="" >
                                                
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                            <label class=" control-label font-weight-bold" for="id">Hasil</label>  
                                            <select id="status_laporan_tr" name="status_laporan_tr" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" requied>
                                                <option value="">==Pilih==</option>
                                                <option value="1">Laporan Audit Dapat Dilanjutkan Ke Tahapan Bertikutnya</option>
                                                <option value="0">Laporan Audit Harus Diperbaiki Sesuai Catatan</option>                                                               
                                            </select>
                                            </div
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                                
                        </div>

                    <div>
                        <table class="table  table-sm">
                        
                            <thead class="table-success">   
                            <th >Apakah Membutuhkan Tahapan Komite Sertifikasi ?</th>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="status_lanjut_ks" name="status_lanjut_ks" class="form-control selectpicker" data-size="100" data-live-search="true" data-style="btn-white" requied>
                                            <option value="">==Pilih==</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak, Lanjutkan Ke Tahapan Persiapan Sidang Komisi Fatwa</option>                                                               
                                        </select>
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

    
    <script>
        window.addEventListener('load', (event) => {
            $('#modaltr').find('form').trigger('reset');
            
        });

        $('#modaltr').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
    
        
        })

         $('#modaltr').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var id = $this.data('id');
            var status_laporan_tr = $this.data('status-laporan-tr');
            var catatan_tr = $this.data('catatan-tr');
            var status_lanjut_ks = $this.data('status-lanjut-ks');

            var modal = $('#modaltr');
           
          
            if(modal.find('#id').val()){
               
            }else{

               
                modal.find('#id').val(id);

                modal.find('#status_laporan_tr').val(status_laporan_tr).change();   
                modal.find('#status_lanjut_ks').val(status_lanjut_ks).change();   
                //alert(total);
                modal.find('#catatan_tr').val(catatan_tr);        
               
               
                  
                modal.find('#modaltr').attr('action', function (i,old) {
                   return old + '/' + data_id;
            });  
            }
           

        });



        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });


        $(document).ready(function () {

           

            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('datatehicalreview')}}",
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
 
                    {"data":"no_registrasi"},
                    {"data":"nama_perusahaan"},
                    {"data":"kelompok"},
                   
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            if(full.pelaksana1_tr){
                                var str = full.pelaksana1_tr.split("_");
                                return str[1]
                            }else{
                                return ''
                            }
                        }
                    },
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            if(full.pelaksana2_tr){
                                var str = full.pelaksana2_tr.split("_");
                                return str[1]
                            }else{
                                return ''
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

                            if(full.file_laporan_audit1 ){

                                var unduhLaporan1 = `<a href="{{ url('').Storage::url('public/laporan/download/Laporan Audit1/`+full.file_laporan_audit1+`') }}" class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Laporan Audit1&nbsp;&nbsp;</a>`;

                                                                            
                                }else{
                                var unduhLaporan1 = `<a  href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbspLaporan Audit1&nbsp;&nbsp;</a>`;

                                }

                            if(full.file_laporan_audit_tahap_2 ){

                                var unduhLaporan2 = `<a href="{{ url('').Storage::url('public/laporan/download/Laporan Audit Tahap 2/`+full.file_laporan_audit_tahap_2+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Lap. Audit2&nbsp;&nbsp;</a>`;
                               
                                                                             
                            }else{
                                var unduhLaporan2 = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;Lap. Audit2&nbsp;&nbsp;</a>`;
                               
                            }

                            if(full.file_bap ){

                                var unduhBAP = `<a href="{{ url('').Storage::url('public/laporan/download/BAP/`+full.file_bap+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;

                                                                            
                            }else{
                                var unduhBAP = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;BAP&nbsp;&nbsp;</a>`;

                            }
                            if(full.file_laporan_ketidaksesuaian ){

                                var unduhTS = `<a href="{{ url('').Storage::url('public/laporan/download/Laporan Ketidaksesuaian/`+full.file_laporan_ketidaksesuaian+`') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Lap. Ketidaksesuaian&nbsp;&nbsp;</a>`;

                                                                            
                                }else{
                                var unduhTS = `<a href="" class="btn-red btn-xs text-center align-midle" disableButton>&nbsp;&nbsp;Lap. Ketidaksesuaian&nbsp;&nbsp;</a>`;

                            }

                            var unduhDPR = `<a href="{{ url('').Storage::url('public/laporan/fix/FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi.docx') }}"class="btn-green btn-xs text-center align-midle" download>&nbsp;&nbsp;Daftar Periksa&nbsp;&nbsp;</a>`;

                            // if(full.status_dpra == '0'){

                            //     var dpra = ` <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modaldpra' >Unggah</button>`;

                                                                            
                            // }else{
                            //     var dpra = `<button class="btn btn-xs btn-grey m-r-5" data-toggle='modal' data-id='`+full.id+`' data-target='#modaldpra' >Unggah</button>`;

                            // }

                            return `<table class="table-xs table-borderless p-0 m-0">
                                        <tr class="text-center align-midle">
                                            <td class="text-center align-midle">
                                               `+unduhLaporan1+`
                                            </td>
                                        </tr>
                                        <tr class="text-center align-midle">
                                            <td class="text-center align-midle">
                                                `+unduhLaporan2+`
                                            </td>
                                        </tr>
                                        <tr class="text-center align-midle">
                                            <td class="text-center align-midle">
                                                `+unduhBAP+`
                                            </td>
                                        </tr>
                                        <tr class="text-center align-midle">
                                            <td class="text-center align-midle">
                                                `+unduhTS+`
                                            </td>
                                        </tr>
                                        <tr class="text-center align-midle">
                                            <td class="text-center align-midle">
                                                `+unduhDPR+`
                                            </td>
                                        </tr>
                                      
                                    </table>`
                                       
                           
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
                                                <button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id='`+full.id_regis+`' data-catatan-tr='`+full.catatan_tr+`' data-status-laporan-tr='`+full.status_laporan_tr+`' data-status-lanjut-ks='`+full.status_lanjut_ks+`' data-target='#modaltr' > Upload Review Laporan Audit</button>
                                            </td>
                                        </tr>
                                    </table>`
                                       
                           
                        }
                    }
                ],
                'columnDefs': [
                {
                      "targets": [0,1,2,3,4,5,6,7],
                      "className": "text-center",
                     
                }],
                
                processing:true,
                serverSide:true,
                order:[[0,'asc']],

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