@extends('layouts.default')

@section('title', 'Registrasi Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">Monitoring Registrasi</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Monitoring Registrasi<small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Monitoring Registrasi</h4>
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
                                                    <option value="11">Persiapan Technical Review</option>
                                                    <option value="12">Technical Review</option>
                                                    <option value="13">Persiapan Tinjauan Komite Sertifikasi</option>
                                                    <option value="14">Tinjauan Komite Sertifikasi</option>
                                                    <option value="15">Persiapan Sidang Fatwa Halal</option>
                                                    <option value="16">Sidang Fatwa Halal</option>
                                                    <option value="17">Ketetapan Halal</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label">Status Aktif</label>
                                            <div class="col-lg-4">
                                                <select id="status_cancel" name="status_cancel" class="form-control"  data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Status--</option>
                                                    <option value="0">Aktif</option>
                                                    <option value="1">Cancel</option>
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
            <table id="table" class="table table-hover table-bordered table-td-valign-middle table-sm " cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class=" valign-middle text-center">No</th>   
                    <th class=" valign-middle text-center" >ID</th>
                    <th class=" valign-middle text-center" style="display:none">No. Registrasi BPJPH</th>
                    <th class=" valign-middle text-center">Status Sertifikasi</th> 
                    <th class=" valign-middle text-center" style="display:none">PIC Pelaku Usaha</th>
                    <th class=" valign-middle text-center">Perusahaan</th>
                    <th class=" valign-middle text-center">Alamat</th>
                    <th class=" valign-middle text-center" style="display:none">Kota/Kab</th>
                    <th class=" valign-middle text-center">Jenis Registrasi</th>
                    <th class=" valign-middle text-center">Rincian Jenis Produk</th>
                    <th class=" valign-middle text-center" style="display:none">Pelaksana</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal Pendaftaran</th>
                    <th class=" valign-middle text-center" style="display:none">Jenis Skema Audit</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal Audit1</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal Audit2</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal TR</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal KS</th>
                    <th class=" valign-middle text-center" style="display:none">Nomor Sertfikat Halal</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal Terbit Sertifikat Halal</th>
                    <th class=" valign-middle text-center" style="display:none">Tanggal Berakhir Sertifikat Halal</th>
                    <th class=" valign-middle text-center" style="display:none">Mata Uang</th>
                    <th class=" valign-middle text-center" style="display:none">Total Biaya</th>
                    <th class=" valign-middle text-center" style="display:none">Nomor OC</th>
                    <th class=" valign-middle text-center">Status Pembayaran</th>
                    <th class=" valign-middle text-center" style="display:none">Jenis Pendanaan</th>
                    <th class=" valign-middle text-center" style="display:none">Nama Fasilitator</th>
                    <th class=" valign-middle text-center" style="display:none">Provinsi</th>
                    <th class=" valign-middle text-center" style="width:10%">Audior</th>             
                    <th class=" valign-middle text-center">Monitoring</th>
                </tr>
                </thead>
            </table>            
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->    
@endsection
@push('scripts')
    <script src="{{asset('/assets/js/checkData.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('/assets/js/jszip.min.js')}}"></script>
    <script src="{{asset('/assets/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('/assets/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('/assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('/assets/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/assets/css/select.dataTables.min.css')}}"></script>
   

    <script>    
         var role = {!! json_encode((array)auth()->user()->usergroup_id) !!};
        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        
        var xTable = $('#table').DataTable({

            ajax:{
                url:"{{route('datamonitoringregistrasi')}}",
                data:function(d){
                    d.no_registrasi = $('#no_registrasi').val();
                    d.nama_perusahaan = $('#nama_perusahaan').val();
                    d.status = $('#status').val();
                    d.status_cancel = $('#status_cancel').val();
                }   
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    className: 'btn-green btn',
                    exportOptions: {
                        columns: 'th:not(:last-child)',
                        modifier: {
                            page: 'all',
                            selected: null
                        }
                    }
                }                
            ],       
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
                {"data":"no_registrasi_bpjph"},
                {
                    "data":"status",
                    "render":function (data) {return checkProgress(data);}
                },   
                {"data":"name"},
                {"data":"nama_perusahaan"}, 
                {"data":"alamat_perusahaan"}, 
                {"data":"kota"}, 
                {"data":"jenis"},
                {"data":"rincian_jenis_produk"},
                {
                    "data":"kode_wilayah",
                    "render":function (data) {return checkWilayah(data);}
                },
                {"data":"tgl_registrasi"},
                {"data":"skema"},
                {"data":"mulai_audit1"},
                {"data":"mulai_audit2"},
                {"data":"mulai_tr"},
                {"data":"mulai_tinjauan"},
                {"data":"nomor_sh"},
                {"data":"tgl_terbit_sh"},
                {"data":"tgl_akhir_sh"},
                {"data":"mata_uang"},
                {"data":"total_biaya"},
                {"data":"nomor_oc"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type, full, meta) {
                        if(full.nominal_tahap2){
                            if(full.status_tahap2 != '0' && full.status_tahap1 != '0' && full.status_tahap3 != '0'){
                                return `<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }
                        }else if(full.nominal_tahap3){
                            if(full.status_tahap1 != '0' && full.status_tahap3 != '0'){
                                return`<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }
                        }else if(full.status_tahap1){
                           
                            if(full.status_tahap1 != '0'){
                                return `<a style="color:green">Lunas</a>`
                            }else{
                                return `<a style="color:red">Belum Lunas</a>`
                            }

                        }else{
                            return `<a style="color:red">Belum Akad</a>`
                        }
                    }
                }, 
                {"data":"jenis_pendanaan"},
                {"data":"nama_fasilitator"},
                {"data":"provinsi"},
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type, full, meta) {
                        if(full.pelaksana1_audit1 != null){
                            if (full.pelaksana1_audit1.indexOf('_') > -1)
                            {
                                $str1 =  full.pelaksana1_audit1.split("_");
                                full.pelaksana1_audit1 = $str1[1];
                            }
                        
                        }else{
                            full.pelaksana1_audit1 ="-";
                        }


                    


                        if(full.pelaksana1_audit2 != null){
                            
                            if (full.pelaksana1_audit2.indexOf('_') > -1){
                                $str3 = full.pelaksana1_audit2.split("_");
                                full.pelaksana1_audit2 = $str3[1];
                            }
                            
                        
                        }
                        else{
                        
                            full.pelaksana1_audit2 ="-";
                        }


                        if(full.pelaksana2_audit2 != null){
                            if (full.pelaksana2_audit2.indexOf('_') > -1){
                                $str4 =  full.pelaksana2_audit2.split("_");
                                full.pelaksana2_audit2 = $str4[1];
                            }
                            
                        }else{
                            full.pelaksana2_audit2 ="-";
                        }
                       return`<strong>Tahap 1 </strong><br>`+full.mulai_audit1+`<br><strong> KTA: </strong>`+` <br>`+full.pelaksana1_audit1+`<br>`+`<strong>Tahap 2 </strong><br>`+full.mulai_audit2+`<br><strong> KTA: </strong>`+full.pelaksana1_audit2+`<br> <strong>Tim Audit: <strong>`+full.pelaksana2_audit2
                    }
                }, 
               
               
                             
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {

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

                            
                            var status11 = (full.status == 11) ? dButton('Persiapan Audit Technical Review'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Persiapan Technical Review??')"> Persiapan Technical Review</a>`;

                            var status11_0 = (full.status == '11_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status11_1 = (full.status == '11_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status11_2 = (full.status == '11_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status11_3 = (full.status == '11_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status12 = (full.status == 12) ? dButton('Proses Technical Review'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Technical Review??')">Proses Technical Review</a>`;

                            var status12_0 = (full.status == '12_0') ? dButton('Reviewer Belum Upload Review Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Reviewer Belum Upload Review Laporan Audit??')">Reviewer Belum Upload Review Laporan Audit</a>`;

                            var status12_1 = (full.status == '12_1') ? dButton('Proses Technical Review Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Technical Review Selesai??')">Proses Technical Review Selesai</a>`;

                           

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
                            var status20 = (full.status == 20) ? dButton('Cancel'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/20" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengcance registrasi ini??')">Cancel Registrasi</a>`;
                            
                            if(role == 3){
                                var backProgres = `<div class="dropdown-button-title">Update Progress</div>`
                                            +status1+status2+status3+status4+status5+status6+status7+status8+status9+status10+status11+status12+status13+status14+status15+status16+status17+status20+`
                                        </div>`;
                            }else{
                                var backProgres = ``;
                            }
                          

                            
                            return `<div class="btn-group m-r-5 show">
                                    <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                    <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">
                                        <a href="{{url('monitoring_log_registrasi')}}/`+full.id+`" class="dropdown-item" ></i>Log Kegiatan</a>
                                        <a href="{{url('verifikasi_dokumen_sertifikasi')}}/`+full.id+`" class="dropdown-item" >Lihat Dokumen Pelaku Usaha
                                        </a>
                                        <a href="{{url('daftar_periksa_rekomendasi')}}/`+full.id+`" class="dropdown-item" >Kelengkapan Dokumen Sidang
                                        </a><div class="dropdown-divider"></div>
                                        `+backProgres+`
                                        
                                </div>`
                                      
                        
                    }
                },
            ],
           'columnDefs': [
                {
                    //   "targets": [1,2,3,4,5,6,7,8,9],
                    "targets": "_all",
                    "className": "text-center",
                    
                },
                {
                "targets": [ 2,4,7,10,11,12,13,14,15,16,17,18,19,20,21,22,24,25,26],
                "visible": false,
                "searchable": false,
                }
            ],

            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,
            paging: false,
            

        });
       /* $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });*/        

        function dButton(x){
            var disableButton = `<a href="#" class="dropdown-item" style="color:#3dad55;">`+ x +` <i class="ion-ios-checkmark-circle" style='color:#1fe01f;'></i></a>`;
            return disableButton;
        }
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush