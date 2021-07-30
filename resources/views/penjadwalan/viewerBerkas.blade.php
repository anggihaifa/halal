@extends('layouts.default', ['boxedLayout' => true], ['sidebarLight' => true], ['sidebarWide' => true])

@section('title', 'Lihat Data Dokumen Halal')

@push('css')
    <link href="{{asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="#">Dokumen Hala</a></li>
        <li class="breadcrumb-item active">Lihat Data Dokumen Halal</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Lihat Data Dokumen Halal<small></small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Lihat Data Dokumen Halal</h4>
                    
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <!-- <div id ="cover" class="panel-body panel-form" style="position:absolute; z-index: 2; opacity: 0; background-color: red;">
                </div> -->                

                <div id="pdf" class="panel-body panel-form embed-responsive embed-responsive-1by1" style="position: relative; z-index: 1;">

                    @if (isset($penawaranHarga))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/buktiAkad/'.$penawaranHarga->id_user.'/'.$penawaranHarga->file_akad.'')}}" class ="embed-responsive-item">
                    @elseif (isset($konfirmasiSK))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/Konfirmasi SK Audit/'.$konfirmasiSK->file_konfirmasi_sk_audit.'')}}" class ="embed-responsive-item">
                    @elseif (isset($suratTugas))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/Surat Tugas/'.$suratTugas->file_surat_tugas.'')}}" class ="embed-responsive-item">
                    @elseif (isset($auditPlan))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/AP/'.$auditPlan->file_rencana_audit.'')}}" class ="embed-responsive-item">
                    @elseif (isset($audit2))
                        @if ($audit2->file_laporan_audit_tahap_2_ulang != null)
                            <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/Laporan Audit Tahap 2/'.$audit2->file_laporan_audit_tahap_2_ulang.'')}}" class ="embed-responsive-item">
                        @else
                            <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/Laporan Audit Tahap 2/'.$audit2->file_laporan_audit_tahap_2.'')}}" class ="embed-responsive-item">
                        @endif                        
                    @elseif (isset($bap))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/BAP/'.$bap->file_bap.'')}}" class ="embed-responsive-item">
                    @elseif (isset($baps))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/BAPS/'.$baps->file_bap_sampel.'')}}" class ="embed-responsive-item">
                    @elseif (isset($daftarHadir))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/laporan/upload/Daftar Hadir/'.$daftarHadir->file_daftar_hadir.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi1))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi1->id_user.'/'.$dataRegistrasi1->file_surat_permohonan_sidang.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi2))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi2->id_user.'/'.$dataRegistrasi2->file_daftar_hadir_sidang.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi3))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi3->id_user.'/'.$dataRegistrasi3->file_berita_acara_sidang.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi4))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi4->id_user.'/'.$dataRegistrasi4->file_tanda_terima_sidang.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi5))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi5->id_user.'/'.$dataRegistrasi6->file_dokumentasi_sidang.'')}}" class ="embed-responsive-item">
                    @elseif (isset($dataRegistrasi6))
                        <object type="application/pdf;base64" data="{{url('') .Storage::url('public/Berkas Sidang Fatwa Halal/'.$dataRegistrasi6->id_user.'/'.$dataRegistrasi6->file_dokumentasi_sidang.'')}}" class ="embed-responsive-item">
                    @endif
                                                        
                        <p>Pdf/DOCX  File Tidak Dapat Ditampilkan Silahkan Gunakan FItur Unduh</p>
                    </object>

                </div>


                

                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 --> 
    </div>
    <!-- end row -->
@endsection

@push('scripts')
    <script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        // $(document).ready(function() {

        //     var x = document.getElementById("pdf").offsetWidth;
        //     var z = document.getElementById("pdf").offsetHeight;

        //     document.getElementById("cover").style.width = (x-15)+'px';
        //     document.getElementById("cover").style.height = (z-15)+'px';
                
        //     //console.log(document.getElementById("pdf").offsetWidth);

        //     if (window.addEventListener) {  // all browsers except IE before version 9
        //         window.addEventListener ("resize", onResizeEvent, true);
        //     } else {
        //         if (window.attachEvent) {   // IE before version 9
        //         window.attachEvent("onresize", onResizeEvent);
        //         }
        //     }
            
        //     function onResizeEvent() {
        //         var y = document.getElementById("pdf").offsetWidth;
        //         var w = document.getElementById("pdf").offsetHeight;

        //         //bodyElement = document.getElementsByTagName("BODY")[0];
        //         //newWidth = bodyElement.offsetWidth;
        //         if(y != x || w != z){
        //             document.getElementById("cover").style.width = (y-15)+'px';
        //             document.getElementById("cover").style.height = (w-15)+'px';
        //             //width = newWidth;
        //             //console.log(x);
        //             //console.log(y);
        //         }
        //     }

            
            
        // });

        // const cover = document.getElementById("cover");
        // const pdf = document.getElementById("pdf");

        // const myObserver = new ResizeObserver(entries => {
        //   entries.forEach(entry => {
        //     //console.log('width', entry.contentRect.width);
        //     cover.style.width = entry.contentRect.width-15 +'px';
        //     cover.style.height = entry.contentRect.height-15 +'px';
        //     //console.log('height', entry.contentRect.height);
        //   });
        // });

        // myObserver.observe(pdf);
        // //myObserver.observe(cover);

    </script>
@endpush