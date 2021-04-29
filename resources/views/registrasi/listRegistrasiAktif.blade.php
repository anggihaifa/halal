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
        
        function formatRupiah(d) {
            return Number(d).toLocaleString('id', {
              maximumFractionDigits: 2,
              style: 'currency',
              currency: 'IDR'
            });
        }
      
        $(document).ready(function () {

           

            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('dataregistrasipelangganaktif')}}",
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

                            
                            // var key = 'base64:Vm437YM3oDMW9KbhaCp4eW+iMguVZQYhnjBixWAWI8U=';
                            // var full.id = encodeURIComponent(CryptoJS.AES.encrypt(full.id.toString(), key).toString());
                            // var full.id_user = encodeURIComponent(CryptoJS.AES.encrypt(full.id_user.toString(), key).toString());
                            // var full.no_registrasi = encodeURIComponent(CryptoJS.AES.encrypt(full.no_registrasi.toString(), key).toString());
                            
                            //console.log(full.id);

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                            var status1 = (full.status == 1) ? dButton('Pengajuan Baru'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data?')">Pengajuan Baru</a>`;

                           
                            var status2 = (full.status == 2) ? dButton('Melengkapi Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Melengkapi Berkas??')">Melengkapi Berkas</a>`;
                            
                            var status3 = (full.status == 3) ? dButton('Verifikasi Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Verifikasi Berkas??')">Verifikasi Berkas</a>`;

                            var status4 = (full.status == 4) ? dButton('Perbaiki Data Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/4" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaiki Data Berkas??')">Perbaiki Data Berkas</a>`;

                            var status5 = (full.status == 5) ? dButton('Konfirmasi Data Berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Konfirmasi Data Berkas??')">Konfirmasi Data Berkas</a>`;
                            
                            var status6 = (full.status == 6) ? dButton('Akad'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Akad??')">Akad</a>`;

                           
                            
                            var status9 = (full.status == 9 ) ? dButton('Pembayaran'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran??')">Pembayaran</a>`;

                           

                             var status14 = (full.status == 14) ? dButton('Proses Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/14" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Audit Tahap 1??')">Proses Audit Tahap 1</a>`;
                             var statusg = (full.status == 'g') ? dButton('Pembayaran Tahap2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/g" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Pembayaran Tahap 2??')">Pembayaran Tahap 2</a>`;

                             var status15 = (full.status == 15) ? dButton('Proses Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/15" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Audit Tahap 2??')">Proses Audit Tahap 2</a>`;

                            
                            var status16 = (full.status == 16) ? dButton('Pelaporan Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/16" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Pelaporan Audit Tahap 2??')">Pelaporan Audit Tahap 2</a>`;

                            
                            var status18 = (full.status == 18) ? dButton('Rapat Auditor'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/18" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Rapat Auditor??')">Rapat Auditor</a>`;
                            
                            var status19 = (full.status == 19) ? dButton('Tinjauan Komite Sertifikasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/19" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Tinjauan Komite Sertifikasi??')">Tinjauan Komite Sertifikasi</a>`;

                             var status20 = (full.status == 20) ? dButton('Proses Sidang Fatwa'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/20" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Sidang Fatwa??')">Proses Sidang Fatwa</a>`;

                            var status21 = (full.status == 21 ) ? dButton('Pelunasan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/21" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Pelunasan??')">Pelunasan</a>`;
                            
                            var status26 = (full.status == 26) ? dButton('Proses Penerbitan Sertifikat'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/26" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Penerbitan Sertifikat??')">Proses Penerbitan Sertifikat</a>`;
                            
                            var status27 = (full.status == 27) ? dButton('Keputusan Halal/ Haram'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/27" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Kepututsan Halal/ Haram??')">Keputusan Halal/ Haram</a>`;
                            
                            var status28 = (full.status == 28) ? dButton('Sertifikat Halal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/28" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Sertifikat Halal??')">Sertifikat Halal</a>`;
                            var status10 = (full.status == 10 ) ? dButton('Nominal Pembayaran Kurang'):`<a href="{{url('kurang')}}/`+full.id+`/1" class="dropdown-item" >Nominal Pembayaran Kurang</a>`;

                            var status11 = (full.status == 11 ) ? dButton('Nominal Pembayaran Lebih'):`<a href="{{url('lebih')}}/`+full.id+`/1" class="dropdown-item">Nominal Pembayaran Lebih</a>`;

                            var status12 = (full.status == 12) ? dButton('Pembayaran Gagal'):`<a href="{{url('update_status_pembayaran')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Pembayaran Gagal</a>`;
                            var status36 = (full.status == 'h' ) ? dButton('Nominal Pembayaran Kurang'):`<a href="{{url('kurang')}}/`+full.id+`/2" class="dropdown-item" >Nominal Pembayaran Kurang</a>`;

                            var status37 = (full.status == 'i' ) ? dButton('Nominal Pembayaran Lebih'):`<a href="{{url('lebih')}}/`+full.id+`/2" class="dropdown-item">Nominal Pembayaran Lebih</a>`;

                            var status38 = (full.status == 'j') ? dButton('Pembayaran Gagal'):`<a href="{{url('update_status_pembayaran_tahap2')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/j" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Pembayaran Gagal</a>`;
                            var status22 = (full.status == 22 ) ? dButton('Nominal Pelunasan Kurang'):`<a href="{{url('kurang')}}/`+full.id+`/3" class="dropdown-item" >Nominal Pelunasan Kurang</a>`;

                            var status23 = (full.status == 23 ) ? dButton('Nominal Pelunasan Lebih'):`<a href="{{url('lebih')}}/`+full.id+`/3" class="dropdown-item">Nominal Pelunasan Lebih</a>`;

                            var status24 = (full.status == 24) ? dButton('Pelunasan Gagal'):`<a href="{{url('update_status_pelunasan')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/24" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Pelunasan Gagal</a>`;

                            var upload = `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`"  class="dropdown-item" >Kontrak Akad</a> `;

                            var status8 = `<a href="{{url('update_status_akad')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7"   class="dropdown-item"> Akad Gagal</a> `;
                            var konfirmAkad = `<a href="{{url('konfirmasi_akad_admin')}}/`+full.id+`/`+full.status_akad+`"  class="dropdown-item" >Konfirmasi Akad</a>` ;
                           
                            var konfirmBayar3 = (full.status ==  25) ? dButton('Konfirmasi dan Upload Invoice'):`<a href="{{url('upload_invoice')}}/`+full.id+`" class="dropdown-item" >Konfirmasi dan Upload Invoice</a>`;
                           
                            var konfirmBayar2 = (full.status == 'l') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_tahap2')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;
                           
                            var konfirmBayar1 = (full.status == 13) ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;

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
                           

                            //var kw = full.kode_wilayah;

                            var ddCabang = `<form action="{{route('registrasi.updatecabang')}}" method="post">    
                                                @csrf
                                                @method('PUT')
                                               
                                                <input type="text" name="id" value="`+full.id+`" hidden></input>
                                                <select id="kode_wilayah" name="kode_wilayah" class="form-control" onchange="this.form.submit()">

                                                    <option value="`+full.kode_wilayah+`">`+checkWilayah(full.kode_wilayah)+`</option>

                                                   
                                                    @foreach($cabang as $dataCabang =>$value){

                                                        <option value='{{$value->ATTRIBUTE2}}'>{{$value->NAME}}
                                                        </option>
                                                      
                                                    @endforeach

                                                </select>
                                            </form>`;
                            
                            return `<div class="col-lg-12 row border-left rounded-lg border-primary" >
                                    
                                   
                                    
                                       
                                        <div class="col-lg-5 row" >
                                             <div class="col-lg-4 " >
                                                <i class="fa fa-building text-primary" style="zoom:10.0; padding-top:20%"></i> 
                                                    
                                            </div>
                                            <div class="col-lg-8 ">
                                                <h4 class="text-grey" style=>`+full.nama_perusahaan+`</h4>
                                                <a  href="{{url('detail_registrasi')}}/`+full.id+`"  style="color: white; " class="label label-success">NOMOR ID: `+full.no_registrasi+`</a><br> 
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.kelompok+`<br>
                                                <i class="fa fa-info text-primary" ></i>
                                                `+full.jenis+`<br>
                                                <i class="fa fa-info text-primary" ></i> Alamat: 
                                                `+full.alamat_kantor+`<br>
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
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-4-`+full.id+`">Penjadwalan</a>
                                                        </li>
                                                        <li class="nav-item text-center">
                                                            
                                                            <a class="nav-link" data-toggle="tab" href="#card-tab-2-`+full.id+`">Akad</a>
                                                        </li>
                                                        <li class="nav-item text-center">
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-3-`+full.id+`">Pembayaran</a>
                                                        </li>
                                                       
                                                        <li class="nav-item text-center">
                                                            <a class="nav-link text-primary"  data-toggle="tab" href="#card-tab-5-`+full.id+`">Berita Acara</a>
                                                        </li>
                                                        
                                                        
                                                        

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
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
                                                        <td class="text-center"  style="width:20%">
                                                            `+checkProgress(full.status)+`
                                                        </td>
                                                        <td class="text-center"  style="width:20%">
                                                            `+checkStatusBerkas(full.status_berkas)+`
                                                        </td>

                                                        <td class="text-center" style="width:25%">
                                                            `+ddCabang+`
                                                               
                                                            
                                                        
                                                        </td>

                                                        <td class="text-center">
                                                            <div class="btn-group m-r-5 show">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <a href="{{url('detail_unggah_data_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit">

                                                                    </i> Lihat Dokumen
                                                                </a>
                                                                <div class="dropdown-divider"></div>

                                                                <div class="dropdown-button-title">Update Progress</div>`+status1+status2+status6+status9+status14+statusg+status15+status16+status18+status19+status20+status21+status26+`
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
                                                            <td class="text-center">Aksi</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                        <td class="text-center">
                                                            Akad
                                                        </td>
                                                        <td class="text-center">
                                                            `+checkStatusAkad(full.status_akad)+`
                                                        </td>

                                                        <td class="text-center">
                                                            `+formatRupiah(full.total_biaya_sertifikasi)+`
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            `+unduhAkad+`

                                                        </td>

                                                        <td class="text-center">
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <div class="dropdown-button-title">Update Progress</div>`+upload+status8+konfirmAkad+`
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
                                                        <td class="text-center">
                                                            Pembayaran 1
                                                        </td>
                                                        <td class="text-center">
                                                            `+checkStatusPembayaran(full.status_tahap1)+`
                                                        </td>

                                                        <td class="text-center">
                                                            `+formatRupiah(full.nominal_tahap1)+`
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            `+unduhBayar1+`

                                                        </td>

                                                        <td class="text-center">
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <div class="dropdown-button-title">Update Progress</div>`+status10+status11+status12+konfirmBayar1+`
                                                                </div> 
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-center">
                                                             Pembayaran 2
                                                        </td>
                                                        <td class="text-center">
                                                            `+checkStatusPembayaran(full.status_tahap2)+`
                                                        </td>
                                                        <td class="text-center">
                                                            `+formatRupiah(full.nominal_tahap2)+`
                                                        </td>
                                                        <td class="text-center">
                                                             `+unduhBayar2+`
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                    <div class="dropdown-button-title">Update Progress</div>`+status36+status37+status38+konfirmBayar2+`
                                                                </div> 
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="text-center">
                                                            Pelunasan 
                                                        </td>
                                                        <td class="text-center"> 
                                                            `+checkStatusPembayaran(full.status_tahap3)+`
                                                        </td>
                                                        <td class="text-center">
                                                            `+formatRupiah(full.nominal_tahap3)+`
                                                        </td>
                                                        <td class="text-center">
                                                             `+unduhBayar3+`
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true">
                                                                    <b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                       
                                                                <div class="dropdown-button-title">Update Progress</div>`+status22+status23+status24+konfirmBayar3+`
                                                                </div>
                                                            </div>
                                                        </td>

                                                        </tr>
                                                        </table>
                                                    </div>  
                                                    <div class="tab-pane fade" id="card-tab-4-`+full.id+`">

                                                        <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-center">Tipe</td>
                                                            <td class="text-center">Status</td>
                                                            <td class="text-center">Tipe</td>
                                                            <td class="text-center">Status</td>
                                                           
                                                        </tr>

                                                       
                                                        
                                                        <tr>
                                                            <td class="text-center">
                                                                Audit Tahap 1
                                                            </td>
                                                            <td class="text-center">
                                                                `+checkPenjadwalan(full.status_audit1)+`
                                                            </td>
                                                            <td class="text-center">
                                                                Audit Tahap 2
                                                            </td>
                                                            <td class="text-center">
                                                                `+checkPenjadwalan(full.status_audit2)+`
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">
                                                                Rapat Auditor
                                                            </td>
                                                            <td class="text-center">
                                                                `+checkPenjadwalan(full.status_rapat)+`
                                                            </td>
                                                            <td class="text-center">
                                                                Tinjauan Komite
                                                            </td>
                                                            <td class="text-center">
                                                                `+checkPenjadwalan(full.status_tinjauan)+`
                                                            </td>
                                                        </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="card-tab-5-`+full.id+`">

                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td class="text-center">Tipe</td>
                                                                <td class="text-center">Status</td>
                                                                <td class="text-center">File</td>
                                                                <td class="text-center">Aksi</td>
                                                               
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    Berita Acara
                                                                </td>
                                                                <td class="text-center">
                                                                    `+checkStatusBeritaAcara(full.status_berita_acara)+`
                                                                </td>
                                                                <td class="text-center">
                                                                    `+unduhBeritaAcara+`
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="btn-group m-r-5 show">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true">
                                                                            <b class="ion-ios-arrow-down"></b>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                        <div class="dropdown-button-title">Update Progress</div>`+uploadBeritaAcara+`
                                                                        </div> 
                                                                    </div>
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