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
        <li class="breadcrumb-item active"><a href="#">List Pembayaran Registrasi Halal</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Pembayaran Registrasi Halal  <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Pembayaran Registrasi Halal</h4>
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
                    <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                    <th class="text-nowrap valign-middle text-center">Jenis </th>
                    <th class="text-nowrap valign-middle text-center">Pelanggan</th>
                    <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                    <th class="text-nowrap valign-middle text-center">Tanggal</th>
                    <th class="text-nowrap valign-middle text-center">Metode / Status Bayar</th>
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
                url:"{{route('dataregistrasipelanggan')}}",
                data:function(d){
                    d.no_registrasi = $('input[name=no_registrasi]').val();
                    d.name = $('input[name=name]').val();
                    d.perusahaan = $('input[name=perusahaan]').val();
                    
                    d.tgl_registrasi = $('input[name=tgl_registrasi]').val();

                    
                    d.jenis_registrasi = $('#jenis_registrasi').val();
                    d.metode_pembayaran = $('#metode_pembayaran').val();
                    d.status_pembayaran = $('#status_pembayaran').val();
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
                        return `<a href="#" class="btn btn-white btn-xs">&nbsp;&nbsp;`+full.metode_pembayaran+`&nbsp;&nbsp;</a> `+ checkStatusPembayaran(full.status_pembayaran)
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        if(full.metode_pembayaran == 'tunai'){
                            return `Tunai`
                        }else{
                            if(full.status_pembayaran == 0 || full.status_pembayaran == null){
                            return `-`
                        }else{
                            return `<a href="{{ url('').Storage::url('public/buktipembayaran/`+full.id_user+`/`+full.bukti_pembayaran+`') }}" class="btn btn-indigo btn-xs" download>&nbsp;&nbsp;Unduh&nbsp;&nbsp;</a>`    
                        }    
                        }
                        
                        
                    }
                },
                {
                    "data":null,
                    "searchable":false,
                    "orderable":false,
                    "render":function (data,type,full,meta) {
                        if(full.metode_pembayaran == 'tunai'){
                            return `<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="btn btn-primary btn-xs" onclick= "return confirm('Apakah anda yakin untuk mengkonfirmasi pembayaran??')">Konfirmasi</a> `+ `<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-inverse btn-xs" >Detail</a>`   
                        }else{
                            if(full.status_pembayaran == 0 || full.status_pembayaran == null){
                                return `<a href="#" class="btn btn-primary btn-xs disabled" >Konfirmasi</a> `+`<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-inverse btn-xs" >Detail</a>`
                            }else{
                                return `<a href="{{url('konfirmasi_pembayaran_registrasi')}}/`+full.id+`" class="btn btn-primary btn-xs" onclick= "return confirm('Apakah anda yakin untuk mengkonfirmasi pembayaran??')">Konfirmasi</a> `+ `<a href="{{url('detail_registrasi')}}/`+full.id+`" class="btn btn-inverse btn-xs">Detail</a>`    
                            }
                        }
                        
                    }
                }
            ],
            processing:true,
            serverSide:true,
            order:[[0,'asc']],
            "searching": false,

        });
        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush