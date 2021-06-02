@extends('layouts.default')

@section('title', 'Registrasi Halal')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Registrasi Halal</a></li>
        <li class="breadcrumb-item active"><a href="#">List Registrasi Halal</a></li>
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
                @if(isset($data))
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: Reg No.  {{$data->no_registrasi==null ? "-" : $data->no_registrasi }}</a>
                @else
                    <a href="#" class="btn btn-xs btn-default btn-default active">Aktif: ---</a>
                @endif
                
                <a href="{{route('registrasiHalal.create')}}" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                <a href="#" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body" style="min-height: 230px">
            <h5 style="color: #ff6961;">NOTE: Silahkan Aktifkan Registrasi Anda Untuk Melanjutkan Ke Tahapan Berikutnya</h5>
           <table id="table" class="table" cellspacing="0" style="width:100%">
                <thead style="display: none;">
                    <tr>
                        <th ></th>                         
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->
    </div>

    
    
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

            var aktif_reg =  {!! json_encode(Auth::user()->registrasi_id) !!};

            var xTable = $('#table').DataTable({
               
                columns:[
                   
                   {                       
                        "render":function (data,type,full,meta) {

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;

                           
                            var akad = `<a href="{{url('upload_kontrak_akad_user')}}/`+full.id+`"  class="dropdown-item" >Kontrak Akad</a> `;

                            var pembayaran = `<a href="{{url('pembayaran_registrasi')}}/`+full.id+`"  class="dropdown-item"> Pembayaran</a> `;
                            var pembayaran2 = `<a href="{{url('pembayaran_tahap2')}}/`+full.id+`"  class="dropdown-item"> Pembayaran Tahap 2</a> `;
                            var pelunasan = `<a href="{{url('pelunasan')}}/`+full.id+`"  class="dropdown-item" >Pelunasan</a>` ;
                            var reportA = `<a href="{{url('report_audit')}}/`+full.id+`"  class="dropdown-item" >Report Audit dan Berita Acara</a>`;
                           

                            if(full.id == aktif_reg ){
                                var aktif =`<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-yellow btn-xs" >Non Aktifkan</a>`;
                                var uploadBerkas = `<a href="{{url('unggah_dokumen_sertifikasi')}}"  class="dropdown-item" ><i class="fa fa-edit"></i>Berkas Sertifikasi</a>`;
                                var div_aktif = `<div class="col-lg-12 row border-left rounded-lg border-primary" style="background-color:#fafbfc" >`;
                            }else{
                                var aktif = `<a href="{{url('activate_registrasi')}}/`+full.id+`" class="btn btn-green btn-xs" >Aktifkan</a>`;
                                var uploadBerkas = `<a href="#"  class="dropdown-item" >Aktifkan Untuk edit berkas</a>`;
                                 var div_aktif = `<div class="col-lg-12 row border-left rounded-lg border-primary" >`;
                            }
                            
                            return ``+div_aktif+`
                                       
                                          
                                       
                                        <div class="col-lg-5 row" >
                                             <div class="col-lg-4 " >
                                                <i class="fa fa-building text-primary" style="font-size:900%"></i> 
                                                    
                                            </div>
                                            <div class="col-lg-8 ">
                                                <h4 class="text-grey" style=>`+full.nama_perusahaan+`</h4>
                                                <a  href="{{url('detail_registrasi')}}/`+full.id+`"  style="color: white; " class="label label-success">NOMOR ID: `+full.no_registrasi+`</a><br> 
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.tgl_registrasi+`<br>
                                                <i class="fa fa-info text-primary" ></i> 
                                                `+full.kelompok+`<br>
                                                <i class="fa fa-info text-primary" ></i>
                                                `+full.jenis+`<br>
                                                <i class="fa fa-info text-primary" ></i> Aktivasi: 
                                                `+aktif+`<br>
                                             </div>     
                                            
                                           
                                        </div>
                                      

                                        <div class="col-lg-7 row " >

                                            <table class="table table-sm"> 
                                                <tr>
                                                     <td class="text-center">Cabang Pelaksana</td>
                                                    <td class="text-center" style="max-width:20%; min-width:20%;">Progres</td>
                                                    <td class="text-center">Status</td>
                                                    <td class="text-center">Status Berkas</td>
                                                    <td class="text-center">Aksi</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkWilayah(full.kode_wilayah)+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkProgress(full.status)+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+full.status_registrasi+`
                                                    </td>
                                                    <td class="text-center" style="width:20%;">
                                                        `+checkStatusBerkas(full.status_berkas)+`
                                                    </td>

                                              

                                                    <td class="text-center">
                                                        <div class="btn-group m-r-5 show">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" aria-expanded="true"><b class="ion-ios-arrow-down"></b>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdownIcon" x-placement="top-end">
                                                                `+uploadBerkas+`
                                                                <div class="dropdown-divider"></div>
                                                                <div class="dropdown-button-title">Update Progress</div>`+akad+pembayaran+pembayaran2+reportA+pelunasan+`
                                                               
                                                            </div> 
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                                    
                                        </div>
                                    </div>`  
                        }
                    }
                ],

              
               
               //tambahkan bkti bayar 1,2,3, bkti kontrak akad, berita acara,
                
                
               
                
                bSortable: false,
                ordering: false,
                processing:true,
                serverSide:true,
                ajax:"{{route('registrasi.datatable')}}",
                order:[[0,'asc']]

            });



        });

  
        
        
      

        $(".fordelete").on("submit",function () {
            return confirm("Apakah anda yakin?");
        });
    </script>
    <script src="{{asset('/assets/js/filterData.js')}}"></script>
@endpush