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

                            var status5 = (full.status == 5) ? dButton('Pembayaran'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran??')">Pembayaran</a>`;

                            var status5_0 = (full.status == '5_0') ? dButton('Belum Upload Bukti Bayar'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Bukti Bayar??')">Belum Upload Bukti Bayar</a>`;

                            var status5_1 = (full.status == '5_1') ? dButton('Menunggu Sales Officer Mengkonfirmasi Pembayaran'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Sales Officer Mengkonfirmasi Pembayaran??')">Menunggu Sales Officer Mengkonfirmasi Pembayaran</a>`;

                            var status5_2 = (full.status == '5_2') ? dButton('Pembayaran Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Gagal??')">Pembayaran Gagal</a>`;

                            var status5_3 = (full.status == '5_3') ? dButton('Pembayaran Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/5_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Terkonfirmasi??')">Pembayaran Terkonfirmasi</a>`;

                            
                            var status6 = (full.status == 6) ? dButton('Penerbitan Order Confirmation'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan Order Confirmation??')">Penerbitan Order Confirmation (OC)</a>`;

                            var status6_0 = (full.status == '6_0') ? dButton('Belum Upload OC'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload OC??')">Belum Upload OC</a>`;

                            var status6_1 = (full.status == '6_1') ? dButton('Menunggu Pelanggan Upload Ulang OC'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Pelanggan Upload Ulang OC??')">Menunggu Pelanggan Upload Ulang OC</a>`;

                            var status6_2 = (full.status == '6_2') ? dButton('Menunggu Konfirmasi Admin'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Konfirmasi Admin??')">Menunggu Konfirmasi Admin</a>`;

                            var status6_3 = (full.status == '6_3') ? dButton('Penerbitan OC Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan OC Gagal??')">Penerbitan OC Gagal</a>`;

                            var status6_4 = (full.status == '6_4') ? dButton('Penerbitan OC Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/6_4" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penerbitan OC Terkonfirmasi??')">Penerbitan OC Terkonfirmasi</a>`;


                            var status7 = (full.status == 7) ? dButton('Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan??')">Penjadwalan</a>`;

                            var status7_0 = (full.status == '7_0') ? dButton('Belum Dijadwalkan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Dijadwalkan??')">Belum Dijadwalkan</a>`;

                            var status7_1 = (full.status == '7_1') ? dButton('Menunggu Reviewer Mengkonfirmasi Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Mengkonfirmasi Penjadwalan??')">Menunggu Reviewer Mengkonfirmasi Penjadwalan</a>`;

                            var status7_2 = (full.status == '7_2') ? dButton('Perbaikan Penjadwalan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Penjadwalan??')">Menunggu Konfirmasi Admin</a>`;

                            var status7_3 = (full.status == '7_3') ? dButton('Penjadwalan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/7_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Penjadwalan Terkonfirmasi??')">Penjadwalan Terkonfirmasi</a>`;

                            var status8 = (full.status == 8) ? dButton('Proses Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Audit Tahap 1??')">Proses Audit Tahap 1</a>`;

                            var status8_1 = (full.status == '8_1') ? dButton('Menunggu Auditor Memverifikasi berkas'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Auditor Memverifikasi berkas??')">Menunggu Auditor Memverifikasi berkas</a>`;

                            var status8_2 = (full.status == '8_2') ? dButton('Perbaikan Berkas Audit Tahap 1'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Berkas Audit Tahap 1??')">Perbaikan Berkas Audit Tahap 1</a>`;

                            var status8_3 = (full.status == '8_3') ? dButton('Audit Tahap 1 Selesai'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/8_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Audit Tahap 1 Selesai??')">Audit Tahap 1 Selesai</a>`;

                            var status9 = (full.status == 9) ? dButton('Pembayaran Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Tahap 2??')">Pembayaran Tahap 2</a>`;

                            var status9_0 = (full.status == '9_0') ? dButton('Belum Upload Bukti Bayar'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Bukti Bayar??')">Belum Upload Bukti Bayar</a>`;

                            var status9_1 = (full.status == '9_1') ? dButton('Menunggu Sales Officer Mengkonfirmasi Pembayaran Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Sales Officer Mengkonfirmasi Pembayaran Tahap 2??')">Menunggu Sales Officer Mengkonfirmasi Pembayaran Tahap 2</a>`;

                            var status9_2 = (full.status == '9_2') ? dButton('Pembayaran Tahap 2 Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Tahap 2 Gagal??')">Pembayaran Tahap 2 Gagal</a>`;

                            var status9_3 = (full.status == '9_3') ? dButton('Pembayaran Tahap 2 Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/9_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pembayaran Tahap 2 Terkonfirmasi??')">Pembayaran Tahap 2 Terkonfirmasi</a>`;

                            var status10 = (full.status == 10) ? dButton('Proses Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Audit Tahap 2??')">Proses Audit Tahap 2</a>`;

                            var status10_0 = (full.status == '10_0') ? dButton('Belum Upload Audit Plan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Audit Plan??')">Belum Upload Audit Plan</a>`;

                            var status10_1 = (full.status == '10_1') ? dButton('Menunggu Pelaku Usaha Mwngkonfirmasi Audit Plan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Pelaku Usaha Mwngkonfirmasi Audit Plan??')">Menunggu Pelaku Usaha Mwngkonfirmasi Audit Plan</a>`;

                            var status10_2 = (full.status == '10_2') ? dButton('Pelaku Usaha Menolak Audit Plan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pelaku Usaha Menolak Audit Plan??')">Pelaku Usaha Menolak Audit Plan</a>`;

                            var status10_3 = (full.status == '10_3') ? dButton('Audit Plan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Audit Plan Terkonfirmasi??')">Audit Plan Terkonfirmasi</a>`;

                            var status10_4 = (full.status == '10_4') ? dButton('Menunggu Tehnical Reviewer Mengkonfirmasi Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_4" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Tehnical Reviewer Mengkonfirmasi Laporan Auditi??')">Menunggu Tehnical Reviewer Mengkonfirmasi Laporan Audit</a>`;
                            
                            var status10_5 = (full.status == '10_5') ? dButton('Perbaikan Laporan Audit Tahap 2'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_5" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Perbaikan Laporan Audit Tahap 2??')">Perbaikan Laporan Audit Tahap 2</a>`;

                            var status10_6 = (full.status == '10_6') ? dButton('Menunggu Komite Sertifikasi Mengkonfirmasi Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_6" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Komite Sertifikasi Mengkonfirmasi Laporan Audit??')">Menunggu Komite Sertifikasi Mengkonfirmasi Laporan Audit</a>`;

                            var status10_7 = (full.status == '10_7') ? dButton('Menunggu Reviewer Operasi Mengkonfirmasi Laporan Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_7" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Reviewer Operasi Mengkonfirmasi Laporan Audit??')">Menunggu Reviewer Operasi Mengkonfirmasi Laporan Audit</a>`;

                            var status10_8 = (full.status == '10_8') ? dButton('Laporan Audit Tahap 2 Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/10_8" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Laporan Audit Tahap 2 Terkonfirmasi??')">Laporan Audit Tahap 2 Terkonfirmasi</a>`;

                            var status11 = (full.status == 11) ? dButton('Penyampaian Berita Acara'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Proses Audit Tahap 1??')">Proses Audit Tahap 1</a>`;

                            var status11_1 = (full.status == '11_1') ? dButton('Menunggu Pelanggan Upload Ulang Berita Acara'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Pelanggan Upload Ulang Berita Acara??')">Menunggu Pelanggan Upload Ulang Berita Acara</a>`;

                            var status11_2 = (full.status == '11_2') ? dButton('Berita Acara Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/11_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Berita Acara Terkonfirmasi??')">Berita Acara Terkonfirmasi</a>`;

                            var status12 = (full.status == 12) ? dButton('Pelunasan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pelunasan??')">Pelunasan</a>`;

                            var status12_0 = (full.status == '12_0') ? dButton('Belum Upload Bukti Pelunasan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_0" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Belum Upload Bukti Pelunasan??')">Belum Upload Bukti Pelunasan</a>`;

                            var status12_1 = (full.status == '12_1') ? dButton('Menunggu Sales Officer Mengkonfirmasi Pelunasan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_1" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Menunggu Sales Officer Mengkonfirmasi Pelunasan??')">Menunggu Sales Officer Mengkonfirmasi Pelunasan</a>`;

                            var status12_2 = (full.status == '12_2') ? dButton('Pelunasan Gagal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_2" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pelunasan Gagal??')">Pelunasan Gagal</a>`;

                            var status12_3 = (full.status == '12_3') ? dButton('Pelunasan Terkonfirmasi'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/12_3" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate ke tahapan Pelunasan Terkonfirmasi??')">Pelunasan Terkonfirmasi</a>`;

                            var status13 = (full.status == 13) ? dButton('Proses Sidang Fatwa'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/13" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Sidang Fatwa?')">Proses Sidang Fatwa</a>`;

                            var upload = `<a href="{{url('upload_kontrak_akad_admin')}}/`+full.id+`"  class="dropdown-item" >Kontrak Akad</a> `;

                            
                            var konfirmAkad = `<a href="{{url('konfirmasi_akad_admin')}}/`+full.id+`/`+full.status_akad+`"  class="dropdown-item" >Konfirmasi Akad</a>` ;
                           
                            var konfirmBayar3 = (full.status ==  '12_3') ? dButton('Konfirmasi dan Upload Invoice'):`<a href="{{url('upload_invoice')}}/`+full.id+`" class="dropdown-item" >Konfirmasi dan Upload Invoice</a>`;
                           
                            var konfirmBayar2 = (full.status == '9_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_tahap2')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;
                           
                            var konfirmBayar1 = (full.status == '5_3') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;

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
                                                <i class="fa fa-building text-primary" style="font-size:1000%; padding-top:20%"></i> 
                                                    
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

                                                                <a href="{{url('detail_unggah_data_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit">

                                                                    </i> Lihat Dokumen
                                                                </a>
                                                                <div class="dropdown-divider"></div>

                                                                <div class="dropdown-button-title">Update Progress</div>`+status1+status2+status3+status4+status5+status6+status7+status8+status9+status10+status11+status12+status13+`
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
                                                        <td class="text-center align-middle">
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

                                                                <div class="dropdown-button-title">Update Progress</div>`+upload+`
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
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                <div class="dropdown-button-title">Update Progress</div>`+status5_2+konfirmBayar1+`
                                                                </div> 
                                                            </div>
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
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                    <div class="dropdown-button-title">Update Progress</div>`+status9_2+konfirmBayar2+`
                                                                </div> 
                                                            </div>
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
                                                            <div class="btn-group m-r-5 show">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true">
                                                                    <b class="ion-ios-arrow-down"></b>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                                                       
                                                                <div class="dropdown-button-title">Update Progress</div>`+status12_2+konfirmBayar3+`
                                                                </div>
                                                            </div>
                                                        </td>

                                                        </tr>
                                                        </table>
                                                    </div>  
                                                    <div class="tab-pane fade" id="card-tab-4-`+full.id+`">

                                                        <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-center align-middle">Tipe</td>
                                                            <td class="text-center align-middle">Status</td>
                                                            <td class="text-center align-middle">Tipe</td>
                                                            <td class="text-center align-middle">Status</td>
                                                           
                                                        </tr>

                                                       
                                                        
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                Audit Tahap 1
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkPenjadwalan(full.status_audit1)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                Audit Tahap 2
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkPenjadwalan(full.status_audit2)+`
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                Rapat Auditor
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkPenjadwalan(full.status_rapat)+`
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                Tinjauan Komite
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                `+checkPenjadwalan(full.status_tinjauan)+`
                                                            </td>
                                                        </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="card-tab-5-`+full.id+`">

                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td class="text-center align-middle">Tipe</td>
                                                                <td class="text-center align-middle">Status</td>
                                                                <td class="text-center align-middle">File</td>
                                                                <td class="text-center align-middle">Aksi</td>
                                                               
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    Berita Acara
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    `+checkStatusBeritaAcara(full.status_berita_acara)+`
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    `+unduhBeritaAcara+`
                                                                </td>
                                                                <td class="text-center align-middle">
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