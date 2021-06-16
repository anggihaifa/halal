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
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

     <!--modal-->
      <!--modal-->
    

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

            if(d.mulai_audit1  == null){

                d.mulai_audit1 ="-";
            }
            
            if(d.mulai_audit2  == null){

                d.mulai_audit2 ="-";
            }
            
           


            if(d.pelaksana1_audit1 != null){
                if (d.pelaksana1_audit1.indexOf('_') > -1)
                {
                    $str1 =  d.pelaksana1_audit1.split("_");
                    d.pelaksana1_audit1 = $str1[1];
                }
            
            }else{
                d.pelaksana1_audit1 ="-";
            }


           


            if(d.pelaksana1_audit2 != null){
                
                if (d.pelaksana1_audit2.indexOf('_') > -1){
                    $str3 = d.pelaksana1_audit2.split("_");
                    d.pelaksana1_audit2 = $str3[1];
                }
                
            
            }
            else{
            
                d.pelaksana1_audit2 ="-";
            }


            if(d.pelaksana2_audit2 != null){
                if (d.pelaksana2_audit2.indexOf('_') > -1){
                    $str4 =  d.pelaksana2_audit2.split("_");
                    d.pelaksana2_audit2 = $str4[1];
                }
                
            }else{
                d.pelaksana2_audit2 ="-";
            }

            if(d.pelaksana1_tr != null){
                if (d.pelaksana1_tr.indexOf('_') > -1){
                    $str5 =  d.pelaksana1_tr.split("_");
                    d.pelaksana1_tr = $str5[1];
                }
                
            }else{
                d.pelaksana1_tr ="-";
            }

            if(d.pelaksana2_tr != null){
                if (d.pelaksana2_tr.indexOf('_') > -1){
                    $str6 =  d.pelaksana2_tr.split("_");
                    d.pelaksana2_tr = $str6[1];
                }
                
            }else{
                d.pelaksana2_tr ="-";
            }

        
            if(d.pelaksana1_tinjauan != null){
                if (d.pelaksana1_tinjauan.indexOf('_') > -1){
                    $str8 =  d.pelaksana1_tinjauan.split("_");
                    d.pelaksana1_tinjauan = $str8[1];
                }
            
            }else{
                d.pelaksana1_tinjauan ="-";
            }

            if(d.pelaksana12_tinjauan != null){
                if (d.pelaksana2_tinjauan.indexOf('_') > -1){
                    $str9 =  d.pelaksana2_tinjauan.split("_");
                    d.pelaksana2_tinjauan = $str9[1];
                }
                
            }else{
                d.pelaksana2_tinjauan ="-";
            }

           
        

            return '<table  class="table" cellspacing="0" style="width:100% padding-left:50px;">'+
                '<thead style="background-color:#dff3e3;">'+
                    '<th class="valign-middle text-center">No</th>'+
                    '<th class="valign-middle text-center">Jenis</th>'+
                    '<th class="valign-middle text-center">Mulai Audit</th>'+
                    '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    '<th class="valign-middle text-center">Auditor/Komite</th>'+
                    '<th class="valign-middle text-center">Status</th>'+
                    '<th class="valign-middle text-center">Aksi</th>'+
                    
                '</thead>'+
                '<tr>'+
                    '<td class="valign-middle text-center">1</td>'+
                    '<td class="valign-middle text-center">Audit Tahap 1</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_audit1+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_audit1+'</td>'+    
                    '<td class="valign-middle text-center">-</td>'+
                    '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_audit1)+'</td>'+
                    '<td class="valign-middle text-center">'+
                        '<form action="{{route("approvepenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="audit1" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-green" style"color:white;">Approve</button>'+
                            
                        '</form>'+
                        '<form action="{{route("rejectpenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="audit1" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-red" style"color:white;">reject</button>'+
                            
                        '</form>'+
                    '</td>'+
                    
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">2</td>'+
                    '<td class="valign-middle text-center">Audit Tahap 2</td>'+
                    '<td class="valign-middle text-center">'+d.mulai_audit2+'</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_audit2+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_audit2+'</td>'+ 
                    '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_audit2)+'</td>'+
                    '<td class="valign-middle text-center">'+
                        '<form action="{{route("approvepenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="audit2" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-green" style"color:white;">Approve</button>'+
                            
                        '</form>'+
                        '<form action="{{route("rejectpenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="audit2" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-red" style"color:white;">reject</button>'+
                            
                        '</form>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">3</td>'+
                    '<td class="valign-middle text-center">Rapat Auditor</td>'+
                    '<td class="valign-middle text-center">-</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_tr+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_tr+'</td>'+ 
                    '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_tr)+'</td>'+
                    '<td class="valign-middle text-center">'+
                        '<form action="{{route("approvepenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="tr" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-green" style"color:white;">Approve</button>'+
                            
                        '</form>'+
                        '<form action="{{route("rejectpenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="tr" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-red" style"color:white;">reject</button>'+
                            
                        '</form>'+
                    '</td>'+   
                '</tr>'+
                '<tr>'+
                    '<td class="valign-middle text-center">4</td>'+
                    '<td class="valign-middle text-center">Tinjauan Komite</td>'+
                    '<td class="valign-middle text-center">-</td>'+
                    '<td class="valign-middle text-center" >'+d.pelaksana1_tinjauan+'</td>'+    
                    '<td class="valign-middle text-center" >'+d.pelaksana2_tinjauan+'</td>'+ 
                    '<td class="valign-middle text-center">'+checkPenjadwalan(d.status_penjadwalan_tinjauan)+'</td>'+
                    '<td class="valign-middle text-center">'+
                        '<form action="{{route("approvepenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="tinjauan" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-green" style"color:white;">Approve</button>'+
                            
                        '</form>'+
                        '<form action="{{route("rejectpenjadwalanreviewer")}}" method="post">'+    
                            '@csrf'+
                            '@method("PUT")'+
                            
                            '<input type="text" name="idregis" value="'+d.id_regis+'" hidden></input>'+
                            '<input type="text" name="jenis" value="tinjauan" hidden></input>'+
                            '<button type="submit" class="btn btn-xs btn-red" style"color:white;">reject</button>'+
                            
                        '</form>'+
                    '</td>'+
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
                    url:"{{route('datapenjadwalanreviewer')}}",
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
                    {"data":"kelompok"}
                
                   
                    
                ],
                'columnDefs': [
                {
                      "targets": [0,1,2,3,4],
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