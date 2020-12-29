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
        <li class="breadcrumb-item active"><a href="#">List Pembayaran Tahap 2</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Pembayaran Tahap 2 <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Pembayaran Tahap 2</h4>
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
                                            
                                            @component('components.inputfilter',['name'=> 'name','label' => 'Nama'])@endcomponent

                                            <label for="kelompok" class="col-lg-2 col-form-label">Kelompok Produk</label>
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

                                            
                                            <label class="col-lg-2 col-form-label">Status Pembayaran</label>
                                            <div class="col-lg-4">
                                                <select id="status_pembayaran" name="status_pembayaran" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Status Pembayaran--</option>
                                                    <option value="0">Belum Bayar</option>
                                                    <option value="1">Menunggu Konfirmasi</option>
                                                    <option value="2">Sudah Dikonfirmasi </option>
                                                </select>
                                            </div>

                                            <label class="col-lg-2 col-form-label">Metode Pembayaran</label>
                                            <div class="col-lg-4">
                                                <select id="metode_pembayaran" name="metode_pembayaran" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                                    <option value="" selected>--Pilih Metode Pembayaran--</option>
                                                    <option value="tunai">Tunai</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>

                                            <label class="col-lg-2 col-form-label">Tanggal Registrasi</label>
                                            <div class="col-lg-4">
                                                <div class="input-group date">
                                                    <input type="text" id="tgl_registrasi" name="tgl_registrasi" class="form-control" placeholder="Tanggal Registrasi" value="" />
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
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
                    <th class="text-nowrap valign-middle text-center">No</th>
                    <!-- <th class="text-nowrap valign-middle text-center">Id User</th> -->
                    <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                    <th class="text-nowrap valign-middle text-center">Jenis </th>
                    <th class="text-nowrap valign-middle text-center">Pelanggan</th>
                    <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal</th>
                   <!--  <th class="text-nowrap valign-middle text-center">status</th> -->
                    <th class="text-nowrap valign-middle text-center">Status Bayar</th>
                    <th class="text-nowrap valign-middle text-center">Bukti Bayar </th>
                    <th class="text-nowrap valign-middle text-center">Aksi</th>
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
    <script>
        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        var xTable = $('#table').DataTable({

            ajax:{
                url:"{{route('datapembayarantahap2')}}",
                data:function(d){
                    d.no_registrasi = $('input[name=no_registrasi]').val();
                    d.name = $('input[name=name]').val();
                    d.perusahaan = $('input[name=perusahaan]').val();
                    
                    d.tgl_registrasi = $('input[name=tgl_registrasi]').val();

                    
                    d.jenis_registrasi = $('#jenis_registrasi').val();
                    d.metode_pembayaran = $('#metode_pembayaran').val();
                    d.status_tahap2 = $('#status_tahap2').val();
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
                {"data":"jenis"},
                {"data":"name"},
                {"data":"perusahaan"},
                {"data":"tgl_registrasi"},
                {
                    
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        return checkStatusPembayaran(full.status_tahap2)
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        
                        if(full.status_tahap2 == 0 || full.status_tahap2 == null){
                        return `-`
                        }else{
                            return `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bb_tahap2+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`    
                        }    
                        
                        
                        
                    }
                },
                {
                    "data":"null",
                    "render":function (data,type,full,meta) {
                        var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                        var status36 = (full.status == 'h' ) ? dButton('Nominal Pembayaran Kurang'):`<a href="{{url('update_status_pembayaran_tahap2')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/i" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Nominal Pembayaran Kurang</a>`;

                        var status37 = (full.status == 'i' ) ? dButton('Nominal Pembayaran Lebih'):`<a href="{{url('update_status_pembayaran_tahap2')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/i" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Nominal Pembayaran Lebih</a>`;

                        var status38 = (full.status == 'j') ? dButton('Pembayaran Gagal'):`<a href="{{url('update_status_pembayaran_tahap2')}}/`+full.id+`/`+full.no_registrasi+`/`+full.id_user+`/j" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk mengupdate data??')">Pembayaran Gagal</a>`;
                       
                        var konfirm = (full.status == 'l') ? dButton('Konfirmasi Pembayaran'):`<a href="{{url('konfirmasi_pembayaran_tahap2')}}/`+full.id+`" class="dropdown-item" onclick= "return confirm('Apakah anda yakin untuk Konfirmasi Pembayaran??')">Konfirmasi Pembayaran</a>`;

                        return `<div class="btn-group m-r-5 show">
                                <a href="#" class="btn btn-info btn-xs">Pilih Aksi</a>
                                <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b></a>
                                     <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">

                                        <a href="{{url('detail_registrasi')}}/`+full.id+`" class="dropdown-item" ><i class="ion-ios-eye"></i> Detail Data</a>
                                        <a href="{{url('detail_unggah_data_sertifikasi')}}/`+full.id+`" class="dropdown-item" ><i class="fa fa-edit"></i> Lihat Dokumen</a>
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-button-title">Update Progress</div>`+
                                        status36+status37+konfirm+`
                                    </div>
                                </div>`




                    }
                },

               
            ],
           

            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,

        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
        function dButton(x){
            var disableButton = `<a href="#" class="dropdown-item" style="color:#3dad55;">`+ x +` <i class="ion-ios-checkmark-circle" style='color:#1fe01f;'></i></a>`;
            return disableButton;
        }
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush