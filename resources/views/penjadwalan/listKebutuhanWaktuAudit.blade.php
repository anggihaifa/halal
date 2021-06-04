@extends('layouts.default')

@section('title', 'List Kebutuhan Waktu Audit')

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
        <li class="breadcrumb-item"><a href="#">List Kebutuhan Waktu Audit</a></li>
        <li class="breadcrumb-item active"><a href="#">Penentuan Kebutuhan Waktu Audit</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">List Kebutuhan Waktu Audit<small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">List Kebutuhan Waktu Audit</h4>
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
                                            
                                            

                                            @component('components.inputfilter',['name'=> 'perusahaan','label' => 'Perusahaan'])@endcomponent   

                                            
                                          
                                            
                                            
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
                        <th class="text-nowrap valign-middle text-center">No. Registrasi</th>
                        <th class="text-nowrap valign-middle text-center">Perusahaan</th>
                        <th class="text-nowrap valign-middle text-center">Kelompok Produk</th>
                        <th class="valign-middle text-center">Status</th>
                        <th class="text-nowrap valign-middle text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end panel-body -->

    </div>
     <!-- end panel -->

     <!--modal-->
    <div id="modalKebutuhan" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('storekebutuhanwaktuaudit')}}" method="post" name="registerForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Penentuan Waktu Audit</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formkebutuhanaudit">
                        <div class="modal-body">
                            <div class="">
                                <table class="table  table-sm">
                            
                                    <thead class="table-secondary">   
                                        <th><h5 class="modal-title">Data Pelaku Usaha</h5></th>
    
                                    </thead>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>ID Registrasi</label>
                                <input type="text" class="form-control"
                                id="idregis1" name="idregis1" readonly/>
                            </div>
                           
                            
                        <!-- Text input-->
                            <div class="form-group">
                                <label class="control-label" for="no_registrasi_bpjph">Nomor Registrasi BPJPH</label>  
                                <div class="">
                                    <input id="no_registrasi_bpjph" type="text" readonly class="form-control">
                                    
                                </div>
                            </div>

                            <!-- Multiple Radios (inline) -->
                            <div class="form-group">
                                <label class="control-label" for="status_registrasi">Jenis Registrasi</label>
                                <div>
                                    <div class="form-check form-check-inline"> 
                                        <label class="form-check-label" for="jenis_registrasi-0">
                                            <input class="form-check-input" name="status_registrasi" type="radio"  id="status_registrasi-0" value="permohonan Baru" readonly>Permohonan Baru
                                        </label> 
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="jenis_registrasi-1">
                                            <input class="form-check-input" name="status_registrasi" type="radio" " id="status_registrasi-1" value="pembaruan" readonly>Pembaruan
                                        </label> 
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="jenis_registrasi-2">
                                            <input class="form-check-input" name="status_registrasi" type="radio"  id="status_registrasi-2" value="perluasan" readonly>Perluasan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class=" control-label" for="ruang_lingkup">Ruang Lingkup Sertifikasi</label>  
                                <div >
                                    <input id="ruang_lingkup"  type="text" placeholder="" class="form-control " readonly>
                                
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="ccontrol-label" for="name">Nama Pelaku Usaha</label>  
                                <div >
                                    <input id="name"  type="text" placeholder="" class="form-control " readonly>
                                
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="control-label" for="alamat_perusahaan">Alamat Pelaku Usaha</label>  
                                <div >
                                    <input id="alamat_perusahaan" type="text" placeholder="" class="form-control " readonly>
                                
                                </div>
                            </div>

                            <div class="">
                                <table class="table  table-sm">
                            
                                    <thead class="table-secondary">   
                                        <th><h5 class="modal-title">Penghitungan Waktu Audit</h5></th>
    
                                    </thead>
                                </table>
                            </div>
                            <div class="">
                                <table class="table  table-sm">
                            
                                    <thead class="table-success">   
                                        <th colspan="2">Kategori Produk</th>
    
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                            
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod1" value="Produk tidak berisiko">
                                                    <label class="form-check-label" for="ktgprod1">Produk tidak berisiko</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod2" value="Produk olahan pangan">
                                                    <label class="form-check-label" for="ktgprod2">Produk olahan pangan</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod3" value="Flavor, seasoning, fragrance">
                                                    <label class="form-check-label" for="ktgprod3">Flavor, seasoning, fragrance</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod4" value="Whey, gelatin, kolagen, kondroitin, enzim hewani">
                                                    <label class="form-check-label" for="ktgprod4">Whey, gelatin, kolagen, kondroitin, enzim hewani</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod5" value="Produk mikrobial">
                                                    <label class="form-check-label" for="ktgprod5">Produk mikrobial</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod6" value="Jamu dan obat-obatan">
                                                    <label class="form-check-label" for="ktgprod6">Jamu dan obat-obatan</label>
                                                </div>  
                                            </td>
                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod7" value="Vaksin">
                                                    <label class="form-check-label" for="ktgprod7">Vaksin</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod8" value="Produk kosmetik">
                                                    <label class="form-check-label" for="ktgprod8">Produk kosmetik</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod9" value="Restoran, katering, dapur">
                                                    <label class="form-check-label" for="ktgprod9">Restoran, katering, dapur</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod10" value="RPH">
                                                    <label class="form-check-label" for="ktgprod10">RPH</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod11" value="Industri jasa">
                                                    <label class="form-check-label" for="ktgprod11">Industri jasa</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod12" value="Barang gunaan">
                                                    <label class="form-check-label" for="ktgprod12">Barang gunaan</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ktgprod" id="ktgprod13" value="Kelompok pabrik lainnya">
                                                    <label class="form-check-label" for="ktgprod13">Kelompok pabrik lainnya</label>
                                                </div>  
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">

                                <div class="">
                                    <table class="table  table-sm">
                                
                                        <thead class="table-success">   
                                            <th colspan="6">Waktu Minimal Audit Sertifikasi Awal (Audit Tahap I dan II)</th>
        
                                        </thead>
                                
                                        <tbody>
                                            <tr>
                                                <td>Waktu dasar audit lapangan</td>
                                                <td>Hari audit untuk tambahan studi keamanan pangan</td>
                                                <td>Hari audit untuk variasi produk</td>
                                                <td>Hari audit berdasarkan jumlah bahan</td>
                                                <td>Full Time Equivalent</td>
                                                <td>Tambahan lokasi yang dikunjungi</td>
                                            </tr>
                                            <tr>
                                            
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_dasar" id="w_dasar" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="h_keamanan_pangan" id="h_keamanan_pangan" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="h_variasi_produk" id="h_variasi_produk" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="h_jumlah_bahan" id="h_jumlah_bahan" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="ft_equivalent" id="ft_equivalent" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="t_lokasi_dikunjungi" id="t_lokasi_dikunjungi" placeholder="hari"></input>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="">
                                    <table class="table  table-sm">
                                
                                        <thead class="table-success">   
                                            <th colspan="6">Waktu Tambahan Audit Sertifikasi Awal</th>
        
                                        </thead>
                                
                                        <tbody>
                                            <tr>
                                                <td>Persiapan Audit</td>
                                                <td>Pengujian</td>
                                                <td>Pelaporan Audit</td>
                                                <td>Verifikasi</td>
                                                <td>Tehnical Review</td>
                                                <td>Rapat Komite Sertifikasi</td>
                                            </tr>
                                            <tr>
                                            
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_p_audit" id="w_p_audit" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_pengujian" id="w_pengujian" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_pelaporan_audit" id="w_pelaporan_audit" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_verifikasi" id="w_verifikasi" placeholder="hari"></input>
                                                </td>
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_tehnical_review" id="w_tehnical_review" placeholder="hari"></input>
                                                </td>
                                                
                                                <td>
                                                    <input type="text"  class="form-control input-sm" name="w_rapat_komite" id="w_rapat_komite" placeholder="hari"></input>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="">
                                <table class="table  table-sm">
                            
                                    <thead class="table-success">   
                                        <th colspan="2">Faktor Penambah/Pengurang Waktu Minimal Audit (≤ 20%)</th>
    
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                            
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor1" id="faktor1" value="persyaratan standar halal">
                                                    <label class="form-check-label" for="faktor1">Persyaratan standar halal</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor2" id="faktor2" value="sertifikasi sistem manajemen keamanan pangan ">
                                                    <label class="form-check-label" for="faktor2">Sertifikasi sistem manajemen keamanan pangan </label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor3" id="faktor3" value="sertifikasi multilokasi (jumlah lokasi)">
                                                    <label class="form-check-label" for="faktor3">Sertifikasi multilokasi (jumlah lokasi)</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor4" id="faktor4" value=" tipe produk, ukuran dan kompleksitas organisasi">
                                                    <label class="form-check-label" for="faktor4">Tipe produk, ukuran dan kompleksitas organisasi</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor5" id="faktor5" value="jumlah lini produk">
                                                    <label class="form-check-label" for="faktor5">Jumlah lini produk</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor6" id="faktor6" value="Critical Control Points (CCP)">
                                                    <label class="form-check-label" for="faktor6">Critical Control Points (CCP)</label>
                                                </div> 
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor7" id="faktor7" value="kegiatan yang dialih daya (outsource)">
                                                    <label class="form-check-label" for="faktor7">Kegiatan yang dialih daya (outsource)</label>
                                                </div> 
                                            </td>
                                            <td>
                                                
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor8" id="faktor8" value="Prerequisite Program PRP">
                                                    <label class="form-check-label" for="faktor8">Prerequisite Program PRP</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor9" id="faktor9" value="area bangunan">
                                                    <label class="form-check-label" for="faktor9">area bangunan</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor10" id="faktor10" value="infrastruktur">
                                                    <label class="form-check-label" for="faktor10">Infrastruktur</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor11" id="faktor11" value="laboratorium pengujian (in house)">
                                                    <label class="form-check-label" for="faktor11">Laboratorium pengujian (in house)</label>
                                                    </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor12" id="faktor12" value="teknologi dan regulasi">
                                                    <label class="form-check-label" for="faktor12">Teknologi dan regulasi</label>
                                                </div>  

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor13" id="faktor13" value="hasil audit sebelumnya">
                                                    <label class="form-check-label" for="faktor13">Hasil audit sebelumnya</label>
                                                </div>  
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="faktor14" id="faktor14" value="kebutuhan penterjemah">
                                                    <label class="form-check-label" for="faktor14">Kebutuhan penterjemah</label>
                                                </div>  
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="">
                                <table class="table  table-sm">
                            
                                    <thead class="table-success">   
                                        <th >Total Waktu Audit Sertifikasi (2) ± (3)</th>
    
                                    </thead>
                            
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text"  class="form-control input-sm" name="total_waktu_kebutuhan_audit" id="total_waktu_kebutuhan_audit" placeholder="hari"></input>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan penjadwalan?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>
    
    
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


         $('#modalKebutuhan').on('show.bs.modal', function(e) {



            var $this = $(e.relatedTarget);
            
            var data_id = $this.data('id');
            var no_registrasi_bpjph = $this.data('no-registrasi-bpjph');
            var status_registrasi = $this.data('status-registrasi');
            var name = $this.data('name');
            var alamat_perusahaan = $this.data('alamat-perusahaan');
            var ruang_lingkup = $this.data('ruang-lingkup');
            var modal = $('#modalKebutuhan');
           
          
            if(modal.find('#idregis1').val()){
                //alert(status_registrasi);
            }else{

               
                modal.find('#idregis1').val(data_id);
                modal.find('#no_registrasi_bpjph').val(no_registrasi_bpjph);
                //$("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');
                if(status_registrasi == 'permohonan baru'){
                    modal.find('#status_registrasi-0').attr('checked', 'checked');
                }else if(status_registrasi == 'pembaruan'){
                    modal.find('#status_registrasi-1').attr('checked', 'checked');
                }else if(status_registrasi == 'perluasan'){
                    modal.find('#status_registrasi-2').attr('checked', 'checked');
                }
               
                modal.find('#name').val(name);
                modal.find('#ruang_lingkup').val(ruang_lingkup);
                modal.find('#alamat_perusahaan').val(alamat_perusahaan);
                
                  
                modal.find('#modalKebutuhan').attr('action', function (i,old) {
                   return old + '/' + data_id;
            });  
            }
           

        });


       


        $(document).ready(function () {

            $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                
           $('#mulai_audit1').on('change', function () {
                $.ajax({

                    url: '{{ route('dropdown1.dataauditor') }}',
                    method: 'POST',
                    data: {
                         _token: "{{ csrf_token() }}",
                        mulai: $('#mulai_audit1').val(),
                        selesai: $('#selesai_audit1').val(),
                        selected_pelaksana1: $('#pelaksana1_audit1').val(),
                        id_regis: $('#idregis1').val()
                    },
                    success: function (response) {
                    
                        $('#pelaksana1_audit1').empty();  
                        $("#pelaksana1_audit1").append(new Option('==Pilih Auditor==',''))                       
                        $.each(response, function (name, id) {                                                                    
                            // document.getElementById("kotkantor").append(new Option(nama_kabupaten, id));
                            $("#pelaksana1_audit1").append(new Option(id +"_"+ name,id +"_"+ name))
                        })
                         $('#pelaksana1_audit1').selectpicker('refresh');
                         //$('#pelaksana2_audit1').empty();                         
                        
                    }
                })
            });
           

         

            var xTable = $('#table').DataTable({
                ajax:{
                    url:"{{route('datakebutuhanwaktuaudit')}}",
                    data:function(d){
                        d.no_registrasi = $('input[name=no_registrasi]').val();
                        d.perusahaan = $('input[name=perusahaan]').val();
                    
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
                    
                  

                    {"data":"no_registrasi_bpjph"},
                    {"data":"name"},
                    {"data":"kelompok"},
                    {
                        
                        "data":null,
                        "searchable":false,
                        "render":function (data,type,full,meta) {
                            return checkStatusKebutuhanAudit(full.status_kebutuhuan_audit)
                        }
                    },
                
                   
                    {
                        "data":null,
                        "searchable":false,
                        "orderable":false,
                        "render":function (data,type,full,meta) {

                            var checklist = `<i class="ion-ios-checkmark-circle" style='color:green;'></i>`;
                            // var kebutuhanAudit = `<a class="dropdown-item"  data-toggle='modal' data-id=`+full.id_registrasi+` data-target='modalKebutuhan'>Penentuan Waktu Audit</a>`;
                
                            // data-no-registrasi-bpjph=`+full.no_registrasi_bpjph+` data-status-registrasi=`+full.status_registrasi+` data-name=`+full.name+` data-alamat-perusahaan=`+full.alamat_perusahaan+`
                            return `<button class="btn btn-xs btn-primary m-r-5" data-toggle='modal' data-id=`+full.id_regis+` data-status-registrasi='`+full.status_registrasi+`' data-no-registrasi-bpjph=`+full.no_registrasi_bpjph+` data-name='`+full.name+`' data-alamat-perusahaan='`+full.alamat_perusahaan+`' data-ruang-lingkup='`+full.ruang_lingkup+`'  data-target='#modalKebutuhan' >Penentuan Waktu Audit</button>`
                        
                        }
                    }
                ],
                'columnDefs': [
                {
                      "targets": [1,2,3,4],
                      "className": "text-center",
                     
                }],
                
                processing:true,
                serverSide:true,
                order:[[0,'asc']],
                "searching": false,

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