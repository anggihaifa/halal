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
            <table id="table" class="table table-striped table-bordered table-td-valign-middle table-sm" cellspacing="0" style="width:100%">
                <thead>
                <tr>
                    <th class="text-nowrap valign-middle text-center">No</th>                  
                    <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                    <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                    <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal</th>
                    <th class="text-nowrap valign-middle text-center">Jenis </th>
                    <th class="text-nowrap valign-middle text-center">Status</th>
                    <th class="text-nowrap valign-middle text-center">Progress</th>
                    <th class="valign-middle text-center">Status Berkas</th>
                    <th class="text-nowrap valign-middle text-center">Wilayah</th>
                    <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
        function format ( d ) {
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                    '<td>Metode Pembayaran:</td>'+
                    '<td>'+d.metode_pembayaran+'</td>'+
                '</tr>'+
               
            '</table>';
        }

        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $(document).ready(function () {
            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('dataregistrasipelangganaktif')}}",
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
                    {"data":"tgl_registrasi"},
                    {"data":"jenis"},
                    {"data":"status_registrasi"},
                   
                    {
                        "data":"status",
                        "render":function (data) {return checkProgress(data);}
                    },
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkStatusBerkas(full.status_berkas)
                        }
                    },
                    {
                        
                        "data":null,
                        "render":function (data,type,full,meta) {
                            return checkWilayah(full.kode_wilayah)
                        }
                    },
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

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

                            
                            var status18 = (full.status == 18) ? dButton('Tinjauan Hasil Audit'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/18" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Tinjauan Hasil Audit??')">Tinjauan Hasil Audit</a>`;
                            
                            var status19 = (full.status == 19) ? dButton('Rekomendasi Hasil Pemeriksaan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/19" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Rekomendasi Hasil Pemeriksaan??')">Rekomendasi Hasil Pemeriksaan</a>`;

                             var status20 = (full.status == 20) ? dButton('Proses Sidang Fatwa'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/20" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Sidang Fatwa??')">Proses Sidang Fatwa</a>`;

                            var status21 = (full.status == 21 ) ? dButton('Pelunasan'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/21" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Pelunasan??')">Pelunasan</a>`;

                            
                           
                            
                            var status26 = (full.status == 26) ? dButton('Proses Penerbitan Sertifikat'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/26" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Proses Penerbitan Sertifikat??')">Proses Penerbitan Sertifikat</a>`;
                            
                            var status27 = (full.status == 27) ? dButton('Keputusan Halal/ Haram'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/27" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Kepututsan Halal/ Haram??')">Keputusan Halal/ Haram</a>`;
                            
                            var status28 = (full.status == 28) ? dButton('Sertifikat Halal'):`<a href="{{url('update_status_registrasi')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/28" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data ke tahapan Sertifikat Halal??')">Sertifikat Halal</a>`;


                         
                            return `<div class="btn-group m-r-5 show">
                                    <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                    <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                        <a href="{{url('detail_registrasi')}}/`+full.id+`" class="dropdown-item" ><i class="ion-ios-eye"></i> Detail Data</a>

                                        <a href="{{url('detail_unggah_data_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Lihat Dokumen</a>
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-button-title">Update Progress</div>`+
                                        status1+status2+status3+status4+status5+status6+status9+status14+statusg+status15+status16+status18+status19+status20+status21+status26+
                                    `</div>
                                </div>`
                        }
                    }
                ],
                'columnDefs': [
                {
                      "targets": [1,2,3,4,5,6,7,8,9,10],
                      "className": "text-center",
                     
                }],
                
                processing:true,
                serverSide:true,
                order:[[0,'asc']],
                "searching": false,



            });
        
        
         // Add event listener for opening and closing details
             /*$('#table tbody').on('click', 'td.details-control', function () {
                 var tr = $(this).closest('tr');
                 var tdi = tr.find("i.fa");
                 var row = xTable.row(tr);

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