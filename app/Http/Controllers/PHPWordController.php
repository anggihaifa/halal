<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Registrasi;
use App\Models\Penjadwalan;
use App\Services\FileUploadServices;
use Dompdf\Dompdf;
use PDF;
use HTML;
use TemplateProcessor;
use Carbon\Carbon;
use App\LaporanAuditTahap2;
use App\DetailLaporanAuditTahap2;
use App\PerencanaanAudit;
use App\DetailPerencanaanAudit;
use App\LaporanSJPH;
use App\LogKegiatan;
use App\DetailLaporanSJPH;
use App\LaporanBahan;
use App\DetailLaporanBahan;
use App\LaporanFasilitasProduk;
use App\DetailLaporanFasilitasProduk;
use App\LaporanProduk;
use App\LaporanAudit2;
use App\DetailLaporanProduk;
use App\DetailLaporanProdukFoto;
use App\Ketidaksesuaian;
use App\TemuanKetidaksesuaian;
use App\DaftarPeriksaRekomendasi;
use App\DetailDaftarPeriksaRekomendasi;
use PhpOffice\PhpWord\Element\TextRun;


class PHPWordController extends Controller
{
    public function download(Request $request){

        $data = $request->except('_token','_method');

        $newData = ['registrasiData'=>$data];        
        $pdf = view('pdf/pdf_detailregis',$newData);
        // dd($pdf);
        
        $dompdf = new Dompdf();
        // $html = file_get_contents("AP.html");
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'landscape');        
        $dompdf->render();        
        $dompdf->stream();
        
    }

    public function uploadAuditPlan(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;
        
        if($request->has("file_audit_plan")){
            $file = $request->file("file_audit_plan");
            $file = $data["file_audit_plan"];

            $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_AuditPlan_'.$data['nama_perusahaan'].'.docx';

            $file->storeAs("public/docx/upload/",$fileName);

            $f = $model2->find($data['id_penjadwalan']);
            $f->berkas_audit_plan = $fileName;
            $f->save();
            DB::Commit();
        }

        // $e = $model->find($data['id_registrasi']);
        
        
        // $file->storeAs("public/buktipembayaran/".Auth::user()->id."/", $filename);
        // dd($f->berkas_audit_plan);        

        $redirect = redirect()->route('listpenjadwalanauditor');
        return $redirect;
    }

    public function downloadAuditPlan(Request $request){

        $data = $request->except('_token','_method');
        // dd("disini");        

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
                
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-04 Rencana Audit.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);

        $fileName = 'FOR-HALAL-OPS-04 Rencana Audit ('.$data['nama_perusahaan'].').docx';
        $templateProcessor->saveAs("storage/laporan/download/Rencana Audit/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                
        $phpWord = $objReader->load("storage/laporan/download/Rencana Audit/".$fileName);
        // $fileName2 = 'FOR-HALAL-OPS-04 Rencana Audit.docx ('.$data['nama_perusahaan'].').docx';
        // $objWriter->save('storage/docx/download/'.$fileName2);
        return response()->download('storage/laporan/download/Rencana Audit/'.$fileName);
    }

    public function downloadLaporanAuditFasilitasProduk(Request $request){
        $data = $request->except('_token','_method');
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-08 Format Laporan Fasilitas Produksi.docx');

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);
        $templateProcessor->setValue('nomor_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);
        // dd("disini");

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Fasilitas Produksi_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);        

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);
    }

    public function downloadLaporanAuditFasilitasProdukFix(Request $request){
        $data = $request->except('_token','_method');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-08 Format Laporan Fasilitas Produksi Complete.docx');
        // dd("disini");
        $model = new LaporanFasilitasProduk();
        DB::beginTransaction();
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->nama_organisasi = $data['nama_perusahaan'];
            $model->nomor_registrasi = $data['no_registrasi'];                        
            $model->nama_auditor = $data['nama_auditor'];
            $model->tanggal_audit = $data['tanggal_audit'];         

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);
        $templateProcessor->setValue('nomor_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);

        $file = $request->file("foto_fasilitas_produksi");
        $file2 = $request->file("foto_fasilitas_produksi_lainnya");
        $file2 = $request->file("denah_fasilitas_produksi");

        $file = $data["foto_fasilitas_produksi"];
        $file2 = $data["foto_fasilitas_produksi_lainnya"];
        $file3 = $data["denah_fasilitas_produksi"];

        $profileImage = "FasilitasProduksi_".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
        $profileImage2 = "FasilitasProduksiLainnya_".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
        $profileImage3 = "DenahFasilitasProduksi_".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();

        $file->storeAs("public/fasilitasproduksi/",$profileImage);
        $file2->storeAs("public/fasilitasproduksi/",$profileImage2);
        $file3->storeAs("public/fasilitasproduksi/",$profileImage3);
        // $size = getimagesize($file);
        // $width = $size[0];
        // $height = $size[1];
        // $pelatihan->gambar_cover = $profileImage;
        
        $templateProcessor->setImageValue('foto_fasilitas_produksi', array('path' => 'storage/fasilitasproduksi/'.$profileImage, 'width' => 300, 'height' =>300, 'ratio' => true));
        $templateProcessor->setImageValue('foto_fasilitas_produksi_lainnya', array('path' => 'storage/fasilitasproduksi/'.$profileImage2, 'width' => 300, 'height' =>300, 'ratio' => true));
        $templateProcessor->setImageValue('gambar_denah', array('path' => 'storage/fasilitasproduksi/'.$profileImage3, 'width' => 400, 'height' =>400, 'ratio' => true));

            $model->foto_fasilitas_produksi = $profileImage;
            $model->foto_fasilitas_produksi_lainnya = $profileImage2;
            $model->gambar_denah = $profileImage3;
        $model->save();
        DB::Commit(); 
        
        $id = DB::table('laporan_fasilitas_produk')           
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idfp = $id_asli;
                }                
            }

        $jml=1;
        $arrData=array();
        
        $temp=0;

        for ($i=0; $i < sizeof($data['daftar_peralatan']); $i++) { 
            $no = $jml;
            $daftar_peralatan = $data['daftar_peralatan'][$i];
            $bahan_peralatan = $data['bahan_peralatan'][$i];            

            $model2 = new DetailLaporanFasilitasProduk();
            DB::beginTransaction();
                $model2->id_laporan_fasilitas_produksi = $idfp;
                $model2->daftar_peralatan = $daftar_peralatan;
                $model2->bahan_peralatan = $bahan_peralatan;
                $model2->save();
            DB::Commit();

            $arrData[] = array('no' => $no, 'daftar_peralatan' => $daftar_peralatan, 'bahan_peralatan' => $bahan_peralatan);
            $jml++;            
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Fasilitas Produksi_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);        

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);
    }

    public function downloadLaporanProduk(Request $request){
        $data = $request->except('_token','_method');
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-09 Format Laporan Produk Sesuai Ruang Lingkup.docx');

        $templateProcessor->setValue('nama_pelaku_usaha', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);
        // dd("disini");

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Produk_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);        

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);
        // dd("disini");
    }

    public function downloadLaporanProdukFix(Request $request){
        $data = $request->except('_token','_method');
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-09 Format Laporan Produk Sesuai Ruang Lingkup Complete.docx');
        // dd("disini");
        $model = new LaporanProduk();
        DB::beginTransaction();
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->nama_pelaku_usaha = $data['nama_perusahaan'];
            $model->nomor_registrasi = $data['no_registrasi'];                        
            $model->nama_auditor = $data['nama_auditor'];
            $model->tanggal_audit = $data['tanggal_audit'];
            $model->save();
        DB::Commit();        

        $templateProcessor->setValue('nama_pelaku_usaha', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);

        $id = DB::table('laporan_produk')
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idlaporanproduk = $id_asli;
                }                
            }

        $jml=1;
        $arrData=array();
        
        $temp=0;

        for ($i=0; $i < sizeof($data['jenis_produk']); $i++) {
            $no = $jml;            

            $jenis_produk = $data['jenis_produk'][$i];
            $nama_produk = $data['nama_produk'][$i];
            $karakteristik_sensori = $data['karakteristik_sensori'][$i];
            $bentuk = $data['bentuk'][$i];
            $penjualan = $data['penjualan'][$i];

            $model2 = new DetailLaporanProduk();
            DB::beginTransaction();
                $model2->id_laporan_produk = $idlaporanproduk;
                $model2->kategori = "Industri Pengolahan";
                $model2->jenis_produk = $jenis_produk;
                $model2->nama_produk = $nama_produk;
                $model2->karakteristik = $karakteristik_sensori;
                $model2->bentuk = $bentuk;
                $model2->penjualan = $penjualan;
                $model2->save();
            DB::Commit();

            $arrData[] = array('no' => $no, 'jenis_produk' => $jenis_produk, 'nama_produk' => $nama_produk, 'karakteristik' => $karakteristik_sensori, 'bentuk' => $bentuk, 'penjualan' => $penjualan);
            $jml++;
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);

        $jml2=1;
        $arrData2=array();
        
        $temp2=0;
        $templateProcessor->cloneBlock('foto', sizeof($data['foto_produk']), true, true);
        for ($i=0; $i < sizeof($data['foto_produk']); $i++) {
            $no = $jml2;

            $file = $request->file("foto_produk");
            $file = $data["foto_produk"][$i];
            $profileImage = "LaporanProduk_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporanproduk/",$profileImage);

            // $pelatihan->gambar_cover = $profileImage;
            $templateProcessor->setImageValue('foto_produk#'.$no, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 300, 'height' =>300, 'ratio' => true));
            $templateProcessor->setValue('keterangan_foto#'.$no, $data['keterangan_foto'][$i]);

            $model3 = new DetailLaporanProdukFoto();
            DB::beginTransaction();
                $model3->id_laporan_produk = $idlaporanproduk;
                $model3->kategori = "Industri Pengolahan";
                $model3->foto_produk = $profileImage;
                $model3->keterangan_foto = $data['keterangan_foto'][$i];
                $model3->save();
            DB::Commit();

            $jml2++;
        }

        $jml3=1;
        $arrData3=array();
        
        $temp3=0;

        for ($i=0; $i < sizeof($data['jenis_produk2']); $i++) {
            $no = $jml3;
            $jenis_produk2 = $data['jenis_produk2'][$i];
            $nama_produk2 = $data['nama_produk2'][$i];
            $karakteristik_sensori2 = $data['karakteristik_sensori2'][$i];
            $bentuk2 = $data['bentuk2'][$i];
            $penjualan2 = $data['penjualan2'][$i];

            $model2 = new DetailLaporanProduk();
            DB::beginTransaction();
                $model2->id_laporan_produk = $idlaporanproduk;
                $model2->kategori = "Restoran/Katering";
                $model2->jenis_produk = $jenis_produk2;
                $model2->nama_produk = $nama_produk2;
                $model2->karakteristik = $karakteristik_sensori2;
                $model2->bentuk = $bentuk2;
                $model2->penjualan = $penjualan2;
                $model2->save();
            DB::Commit();

            $arrData3[] = array('no2' => $no, 'jenis_produk2' => $jenis_produk2, 'nama_produk2' => $nama_produk2, 'karakteristik2' => $karakteristik_sensori2, 'bentuk2' => $bentuk2, 'penjualan2' => $penjualan2);
            $jml3++;
        }            

        $values3 = $arrData3;
        $templateProcessor->cloneRowAndSetValues('no2', $values3);

        $jml4=1;
        $arrData4=array();
        
        $temp4=0;
        $templateProcessor->cloneBlock('foto2', sizeof($data['foto_produk2']), true, true);
        for ($i=0; $i < sizeof($data['foto_produk2']); $i++) {
            $no = $jml4;

            $file = $request->file("foto_produk2");
            $file = $data["foto_produk2"][$i];
            $profileImage = "LaporanProduk_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporanproduk/",$profileImage);

            // $pelatihan->gambar_cover = $profileImage;
            $templateProcessor->setImageValue('foto_produk2#'.$no, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 300, 'height' =>300, 'ratio' => true));
            $templateProcessor->setValue('keterangan_foto2#'.$no, $data['keterangan_foto2'][$i]);

            $model3 = new DetailLaporanProdukFoto();
            DB::beginTransaction();
                $model3->id_laporan_produk = $idlaporanproduk;
                $model3->kategori = "Restoran/Katering";
                $model3->foto_produk = $profileImage;
                $model3->keterangan_foto = $data['keterangan_foto2'][$i];
                $model3->save();
            DB::Commit();

            $jml4++;
        }

        //     $model->foto_fasilitas_produksi = $profileImage;
        //     $model->foto_fasilitas_produksi_lainnya = $profileImage2;
        //     $model->gambar_denah = $profileImage3;
        // $model->save();
        // DB::Commit();                 

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Fasilitas Produksi_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);        

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);        
    }

    public function downloadLaporanAuditSJPH(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-06 Laporan Audit Tahap II.docx');

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);        

        $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs("storage/laporan/download/Laporan Audit Tahap 2/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/Laporan Audit Tahap 2/'.$fileName);
    }

    public function downloadLaporanAudit2(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-05 Laporan Audit Tahap 2.docx');

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Audit Tahap 2_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);       
    }

    public function downloadLaporanAuditBahan(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-06 Format Laporan Bahan.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanBahan_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/laporan/download/".$fileName);        
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/'.$fileName);
    }

    public function downloadAuditPlanFix(Request $request){        

        $data = $request->except('_token','_method');
        // dd($data);

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/docx/FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan Complete.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-04 Rencana Audit Isian.docx');

        $templateProcessor->setValue('no_id_bpjph', $data['no_id_bpjph']);        

        $model = new PerencanaanAudit();        

        $dataAP = DB::table('perencanaan_audit')
                    ->where('id_registrasi',$data['id_registrasi'])
                    ->get();
        // dd(count($dataAP));

        DB::beginTransaction();

        if(count($dataAP) == 0){
            // dd("disini");
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->no_id_bpjph = $data['no_id_bpjph'];
            $model->skema_audit = $data['skema_audit'];
            $model->status_sertifikasi = $data['status_sertifikasi'];
            $model->no_audit = $data['no_audit'];
            $model->nama_organisasi = $data['nama_perusahaan'];
            $model->alamat = $data['alamat'];
            $model->tanggal_audit = $data['tanggal_audit'].' s/d '.$data['tanggal_audit_'];
            $model->tujuan_audit = $data['tujuan_audit'];
            $model->lingkup_audit = $data['lingkup_audit'];
            $model->jenis_produk = $data['jenis_produk'];
            $model->lokasi_audit1 = $data['lokasi_audit1'];
            $model->lokasi_audit2 = $data['lokasi_audit2'];
            $model->tim_audit1 = $data['tim_audit1'];
            if($data['tim_audit2'] == null){
                $model->tim_audit2 = "-";
            }else{
                $model->tim_audit2 = $data['tim_audit2'];
            }            
            $model->tim_audit3 = implode(',',$data['tim_audit3']);
        }else{
            // dd("ada");
            $ap = json_decode($dataAP,true);
            // dd($ap);

            foreach ($ap as $key) {
                $id = $key['id'];
                $e = $model->find($id);                

                $e->id_user = Auth::user()->id;
                $e->id_registrasi = $data['id_registrasi'];
                $e->no_id_bpjph = $data['no_id_bpjph'];
                $e->skema_audit = $data['skema_audit'];
                $e->status_sertifikasi = $data['status_sertifikasi'];
                $e->no_audit = $data['no_audit'];
                $e->nama_organisasi = $data['nama_perusahaan'];
                $e->alamat = $data['alamat'];
                $e->tanggal_audit = $data['tanggal_audit'].' s/d '.$data['tanggal_audit_'];
                $e->tujuan_audit = $data['tujuan_audit'];
                $e->lingkup_audit = $data['lingkup_audit'];
                $e->jenis_produk = $data['jenis_produk'];
                $e->lokasi_audit1 = $data['lokasi_audit1'];
                $e->lokasi_audit2 = $data['lokasi_audit2'];
                $e->tim_audit1 = $data['tim_audit1'];
                if($data['tim_audit2'] == null){
                    $e->tim_audit2 = "-";
                }else{
                    $e->tim_audit2 = $data['tim_audit2'];
                }                            
                $e->tim_audit3 = implode(',',$data['tim_audit3']);
            }
        }
        

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        if($data['skema_audit'] == 'sjh'){            
            $templateProcessor->setValue('sjh', 'SJH');

            $inline = new TextRun();
            $inline->addText('SJPH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjph', $inline);

            if(count($dataAP) == 0){
                $model->skema_audit = 'sjh';
            }else{
                $e->skema_audit = 'sjh';
            }
        }else if($data['skema_audit'] == 'sjph'){
            $templateProcessor->setValue('sjph', 'SJPH');

            $inline = new TextRun();
            $inline->addText('SJH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjh', $inline);
            
            if(count($dataAP) == 0){
                $model->skema_audit = 'sjph';
            }else{
                $e->skema_audit = 'sjph';
            }
        }

        if($data['status_sertifikasi'] == 'baru'){
            $templateProcessor->setValue('baru', 'Baru');

            $inline = new TextRun();
            $inline->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);
            
            if(count($dataAP) == 0){
                $model->status_sertifikasi = 'baru';
            }else{
                $e->status_sertifikasi = 'baru';
            }
        }else if($data['status_sertifikasi'] == 'perpanjangan'){            
            $templateProcessor->setValue('perpanjangan', 'Perpanjangan');            

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);                        

            if(count($dataAP) == 0){
                $model->status_sertifikasi = 'perpanjangan';
            }else{
                $e->status_sertifikasi = 'perpanjangan';
            }
        }else if($data['status_sertifikasi'] == 'perubahan'){            
            $templateProcessor->setValue('perubahan', 'Perubahan');

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline2);
            
            if(count($dataAP) == 0){
                $model->status_sertifikasi = 'perubahan';
            }else{
                $e->status_sertifikasi = 'perubahan';
            }
        }        

        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('nama_organisasi', $data['nama_organisasi']);
        $templateProcessor->setValue('alamat', $data['alamat']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit'].' s/d '.$data['tanggal_audit_']);
        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('jenis_produk', $data['jenis_produk']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        
                
        $nameparts = explode(' ',trim($data['tim_audit1']));
        $firstname = $nameparts[0];
        $lastname = $nameparts[count($nameparts) - 1];
        $initial = $firstname[0]."".$lastname[0];

        $templateProcessor->setValue('tim_audit1', $data['tim_audit1'].' ('.$initial.')');

        // dd($data['tim_audit2']);
        if($data['tim_audit2'] != null){
            $nameparts2 = explode(' ',trim($data['tim_audit2']));
            $firstname2 = $nameparts2[0];
            $lastname2 = $nameparts2[count($nameparts2) - 1];
            $initial2 = $firstname2[0]."".$lastname2[0];

            $templateProcessor->setValue('tim_audit2', $data['tim_audit2'].' ('.$initial2.')');
        }                                            
        // $templateProcessor->setValue('tim_audit3', $data['tim_audit3']);        
        // if($data['tim_audit3'][0] != 0){
            $arrAnggota=array();
            for ($i=0; $i < sizeof($data['tim_audit3']); $i++) { 
                if($data['tim_audit3'][$i] == null){
                    $arrAnggota[] = array('noo' => '3','anggota_tambahan' => '','obs' => "Observer",'kta' => "KTA",'auditor' => "Auditor",'ta' => "TA",'ppc' => "PPC",);
                }else{
                    $anggota = $data['tim_audit3'][$i];
                    $nameparts3 = explode(' ',trim($data['tim_audit3'][$i]));
                    $firstname3 = $nameparts3[0];
                    $lastname3 = $nameparts3[count($nameparts3) - 1];
                    $initial3 = $firstname3[0]."".$lastname3[0];

                    $jenis = $data['anggota_tambahan'][$i];

                    if($jenis == 'Observer'){
                        $inline = new TextRun();
                        $inline->addText('KTA', array('strikethrough' => true));

                        $inline2 = new TextRun();
                        $inline2->addText('Auditor', array('strikethrough' => true));

                        $inline3 = new TextRun();
                        $inline3->addText('TA', array('strikethrough' => true));

                        $inline4 = new TextRun();
                        $inline4->addText('PPC', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','obs' => "Observer", $templateProcessor->setComplexValue('kta', $inline), $templateProcessor->setComplexValue('auditor', $inline2), $templateProcessor->setComplexValue('ta', $inline3), $templateProcessor->setComplexValue('ppc', $inline4));
                    }else if($jenis == 'TA'){
                        $inline5 = new TextRun();
                        $inline5->addText('KTA', array('strikethrough' => true));

                        $inline6 = new TextRun();
                        $inline6->addText('Auditor', array('strikethrough' => true));

                        $inline7 = new TextRun();
                        $inline7->addText('Observer', array('strikethrough' => true));

                        $inline8 = new TextRun();
                        $inline8->addText('PPC', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','ta' => $jenis, $templateProcessor->setComplexValue('kta', $inline5), $templateProcessor->setComplexValue('auditor', $inline6), $templateProcessor->setComplexValue('obs', $inline7), $templateProcessor->setComplexValue('ppc', $inline8));
                    }else if($jenis == 'PPC'){
                        $inline9 = new TextRun();
                        $inline9->addText('KTA', array('strikethrough' => true));

                        $inline10 = new TextRun();
                        $inline10->addText('Auditor', array('strikethrough' => true));

                        $inline11 = new TextRun();
                        $inline11->addText('Observer', array('strikethrough' => true));

                        $inline12 = new TextRun();
                        $inline12->addText('TA', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','ppc' => $jenis, $templateProcessor->setComplexValue('kta', $inline9), $templateProcessor->setComplexValue('auditor', $inline10), $templateProcessor->setComplexValue('obs', $inline11), $templateProcessor->setComplexValue('ta', $inline12));
                    }
                }                
            }

            $values0 = $arrAnggota;
            $templateProcessor->cloneRowAndSetValues('noo', $values0);
               
            if(count($dataAP) == 0){
                $model->save();
            }else{
                $e->save();
            }        
        DB::commit();
        
        $jml=0;
        $arrData=array();
        
        $temp=0;
        $temp2=0;
        $harike = 0;
        for ($i=0; $i < sizeof($data['tgl_audit']); $i++) { 
            $tgl = $data['tgl_audit'][$i];
            $tglhari = strtotime($data['tgl_audit'][$i]);
            $hari = date('l', $tglhari);

            switch ($hari) {
                case 'Monday':
                    $hari = "Senin";
                    break;
                case 'Tuesday':
                    $hari = "Selasa";
                    break;
                case 'Wednesday':
                    $hari = "Rabu";
                    break;
                case 'Thursday':
                    $hari = "Kamis";
                    break;
                case 'Friday':
                    $hari = "Jumat";
                    break;
                case 'Saturday':
                    $hari = "Sabtu";
                    break;
                case 'Sunday':
                    $hari = "Minggu";
                    break;
                default:
                    # code...
                    break;
            }            
            // dd($hari);

            $id = DB::table('perencanaan_audit')           
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idpa = $id_asli;
                }                
            }
            
            $jml = $data['jumlah_kegiatan'][$i];

            $temp2 = $temp;   
            // dd($jml);
            for ($j=$temp2; $j < $temp2+$jml; $j++) {                 
                if($j == $temp){
                    $harike++;
                    
                    // $dKegiatan = htmlspecialchars(str_replace("\n","<w:br/>",$data['detail_kegiatan'][$j]));
                    $dKegiatan = htmlspecialchars(str_replace("\n","<w:br/>",$data['detail_kegiatan'][$j]));
                    $dKegiatan_ = str_replace("&lt;","<",$dKegiatan);
                    $dKegiatan__ = str_replace("&gt;",">",$dKegiatan_);
                    // dd($dKegiatan);
                    $arrData[] = array('hari_ke' => 'Hari '.$harike.'','tgl_waktu' => $hari.', '.$tgl.'','detail_waktu' => $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j], 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $dKegiatan__, 'personil' => $data['personil'][$j]);
                    // $arrData[] = array('hari_ke' => 'Hari '.$harike.'','tgl_waktu' => $hari.', '.$tgl.'','detail_waktu' => $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j], 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $dKegiatan, 'personil' => $data['personil'][$j]);

                    $model2 = new DetailPerencanaanAudit();
                    DB::beginTransaction();
                    $model2->id_perencanaan_audit = $idpa;
                    $model2->hari = $hari;
                    $model2->tanggal_audit = $tgl;
                    $model2->jam_audit = $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j];
                    $model2->judul_kegiatan = $data['judul_kegiatan'][$j];
                    $model2->detail_kegiatan = $data['detail_kegiatan'][$j];
                    $model2->personil = $data['personil'][$j];
                    $model2->save();
                    DB::commit();
                }else{
                    $dKegiatan = htmlspecialchars(str_replace("\n","<w:br/>",$data['detail_kegiatan'][$j]));
                    $dKegiatan_ = str_replace("&lt;","<",$dKegiatan);
                    $dKegiatan__ = str_replace("&gt;",">",$dKegiatan_);
                    
                    $arrData[] = array('hari_ke' => '','tgl_waktu' => $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j],'detail_waktu' => '', 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $dKegiatan__, 'personil' => $data['personil'][$j]);

                    $model2 = new DetailPerencanaanAudit();
                    DB::beginTransaction();
                    $model2->id_perencanaan_audit = $idpa;
                    $model2->hari = $hari;
                    $model2->tanggal_audit = $tgl;
                    $model2->jam_audit = $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j];
                    $model2->judul_kegiatan = $data['judul_kegiatan'][$j];
                    $model2->detail_kegiatan = $data['detail_kegiatan'][$j];
                    $model2->personil = $data['personil'][$j];
                    $model2->save();
                    DB::commit();
                }
                // $temp = $j+1;
            }            
        }    
        // dd($arrData);                      
        // dd($data);

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('hari_ke', $values);
        
        $fileName = 'FOR-HALAL-OPS-04 Rencana Audit ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs('storage/laporan/upload/AP/Isian/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        
        $dataLaporan = DB::table('laporan_audit2')
            ->where('id_registrasi',$data['id_registrasi'])
            ->get();                                

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->rencana_audit_isian = $fileName;                    
                    $model->id_registrasi = $data['id_registrasi'];                    
                    $model->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;                
                $f = $model2->find($dataLaporan[0]->id);
                $f->rencana_audit_isian = $fileName;                
                $f->save();                
            }
            DB::Commit();  
            
            $this->LogKegiatan($data['id_registrasi'], Auth::user()->id, Auth::user()->name, 10, "Membuat berkas rencana audit.", Auth::user()->usergroup_id);

        return response()->download('storage/laporan/upload/AP/Isian/'.$fileName);
        
    }    

    public function downloadLaporanAuditSJPHFix(Request $request){
        $data = $request->except('_token','_method');
        
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-07 Format Laporan SJPH Complete.docx');

        $model = new LaporanSJPH;
        DB::beginTransaction();
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->nama_organisasi = $data['nama_perusahaan'];
            $model->nomor_organisasi = $data['no_organisasi'];
            $model->nama_auditor = $data['nama_auditor'];
            $model->tanggal_audit = $data['tanggal_audit'];
            $model->save();
        DB::Commit();

        $id = DB::table('laporan_sjph')
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idlapsjph = $id_asli;
                }                
            }
            
        // $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        // $fontStyle->setStrikethrough(true);

        $inline = new TextRun();
        $inline->addText($data['nama_perusahaan'], array('strikethrough' => true));
        $templateProcessor->setComplexValue('nama_organisasi', $inline);

        // $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_organisasi', $data['no_organisasi']);                
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);            
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);
        
        $jml=1;
        $arrData=array();
        
        $temp=0;
        $temp2=0;
        for ($i=0; $i < sizeof($data['kriteria']); $i++) { 
            $no = $jml;
            $kriteria = $data['kriteria'][$i];                        
            $temuan = $data['temuan'][$i];

            $model2 = new DetailLaporanSJPH;
            DB::beginTransaction();
                $model2->id_laporan_sjph = $idlapsjph;
                $model2->kriteria = $kriteria;
                $model2->temuan = $temuan;
                $model2->save();
            DB::Commit();

            $arrData[] = array('no' => $no, 'kriteria' => $kriteria, 'temuan' => $temuan);
            $jml++;            
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanSJPH_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');        

        return response()->download('storage/laporan/upload/'.$fileName);
    }

    public function downloadLaporanAuditTahap2Fix2(Request $request){
        $data = $request->except('_token','_method');
        // dd($data);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-06 Laporan Audit Tahap II Isian.docx');

        $templateProcessor->setValue('no_id_bpjph', $data['no_id_bpjph']);        
        if($data['skema_audit'] == 'sjh'){            
            $templateProcessor->setValue('sjh', 'SJH');

            $inline = new TextRun();
            $inline->addText('SJPH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjph', $inline);
                    
        }else if($data['skema_audit'] == 'sjph'){
            $templateProcessor->setValue('sjph', 'SJPH');

            $inline = new TextRun();
            $inline->addText('SJH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjh', $inline);            
        }

        if($data['status_sertifikasi'] == 'baru'){
            $templateProcessor->setValue('baru', 'Baru');

            $inline = new TextRun();
            $inline->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);            
        }else if($data['status_sertifikasi'] == 'perpanjangan'){            
            $templateProcessor->setValue('perpanjangan', 'Perpanjangan');            

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);                
        }else if($data['status_sertifikasi'] == 'perubahan'){            
            $templateProcessor->setValue('perubahan', 'Perubahan');

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline2);            
        }

        $templateProcessor->setValue('no_audit', $data['no_audit']);        
        $templateProcessor->setValue('nama_organisasi', $data['nama_organisasi']);
        $templateProcessor->setValue('nama_usaha', $data['nama_usaha']);
        $templateProcessor->setValue('alamat', $data['alamat']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit'].' s/d '.$data['tanggal_audit_']);
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('jenis_produk', $data['jenis_produk2']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        // $templateProcessor->setValue('ketua_tim', $data['ketua_tim']);
        // $templateProcessor->setValue('tim_audit1', $data['tim_audit1']);
        $templateProcessor->setValue('pimpinan_perusahaan', $data['pimpinan_perusahaan']);

        if($data['tim_audit1'] != null){
            $nameparts = explode(' ',trim($data['tim_audit1']));
            $firstname = $nameparts[0];
            $lastname = $nameparts[count($nameparts) - 1];
            $initial = $firstname[0]."".$lastname[0];
            $templateProcessor->setValue('tim_audit1', $data['tim_audit1'].' ('.$initial.')');
        }        

        $nameparts2 = explode(' ',trim($data['ketua_tim']));
        $firstname2 = $nameparts2[0];
        $lastname2 = $nameparts2[count($nameparts2) - 1];
        $initial2 = $firstname2[0]."".$lastname2[0];
        // dd($initial2);
                            
        $templateProcessor->setValue('ketua_tim', $data['ketua_tim'].' ('.$initial2.')');
        // $templateProcessor->setValue('tim_audit3', $data['tim_audit3']);        
        // if($data['tim_audit3'][0] != 0){
            $arrAnggota=array();
            for ($i=0; $i < sizeof($data['tim_audit3']); $i++) { 
                if($data['tim_audit3'][$i] == null){
                    $arrAnggota[] = array('noo' => '3','anggota_tambahan' => '','obs' => "Observer",'kta' => "KTA",'auditor' => "Auditor",'ta' => "TA",'ppc' => "PPC",);
                }else{
                    $anggota = $data['tim_audit3'][$i];
                    $nameparts3 = explode(' ',trim($data['tim_audit3'][$i]));
                    $firstname3 = $nameparts3[0];
                    $lastname3 = $nameparts3[count($nameparts3) - 1];
                    $initial3 = $firstname3[0]."".$lastname3[0];

                    $jenis = $data['anggota_tambahan'][$i];

                    if($jenis == 'Observer'){
                        $inline = new TextRun();
                        $inline->addText('KTA', array('strikethrough' => true));

                        $inline2 = new TextRun();
                        $inline2->addText('Auditor', array('strikethrough' => true));

                        $inline3 = new TextRun();
                        $inline3->addText('TA', array('strikethrough' => true));

                        $inline4 = new TextRun();
                        $inline4->addText('PPC', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','obs' => "Observer", $templateProcessor->setComplexValue('kta', $inline), $templateProcessor->setComplexValue('auditor', $inline2), $templateProcessor->setComplexValue('ta', $inline3), $templateProcessor->setComplexValue('ppc', $inline4));
                    }else if($jenis == 'TA'){
                        $inline5 = new TextRun();
                        $inline5->addText('KTA', array('strikethrough' => true));

                        $inline6 = new TextRun();
                        $inline6->addText('Auditor', array('strikethrough' => true));

                        $inline7 = new TextRun();
                        $inline7->addText('Observer', array('strikethrough' => true));

                        $inline8 = new TextRun();
                        $inline8->addText('PPC', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','ta' => $jenis, $templateProcessor->setComplexValue('kta', $inline5), $templateProcessor->setComplexValue('auditor', $inline6), $templateProcessor->setComplexValue('obs', $inline7), $templateProcessor->setComplexValue('ppc', $inline8));
                    }else if($jenis == 'PPC'){
                        $inline9 = new TextRun();
                        $inline9->addText('KTA', array('strikethrough' => true));

                        $inline10 = new TextRun();
                        $inline10->addText('Auditor', array('strikethrough' => true));

                        $inline11 = new TextRun();
                        $inline11->addText('Observer', array('strikethrough' => true));

                        $inline12 = new TextRun();
                        $inline12->addText('TA', array('strikethrough' => true));

                        $arrAnggota[] = array('noo' => $i+3,'anggota_tambahan' => $anggota.' ('.$initial3.')','ppc' => $jenis, $templateProcessor->setComplexValue('kta', $inline9), $templateProcessor->setComplexValue('auditor', $inline10), $templateProcessor->setComplexValue('obs', $inline11), $templateProcessor->setComplexValue('ta', $inline12));
                    }
                }                
            }

            $values0 = $arrAnggota;
            $templateProcessor->cloneRowAndSetValues('noo', $values0);

        // $tglhari = strtotime($data['tanggal_audit']);
        // $hari = date('l', $tglhari);
        // $templateProcessor->setValue('auditor1', $data['nama_auditor1']);
        // $templateProcessor->setValue('posisi1', "Ketua Tim Auditor");
        // $templateProcessor->setValue('auditor2', $data['nama_auditor2']);
        // $templateProcessor->setValue('posisi2', "Auditor");
        // $templateProcessor->setValue('auditor3', $data['nama_auditor3']);
        // $templateProcessor->setValue('posisi3', "Auditor");
        // $templateProcessor->setValue('auditee', $data['auditee']);               
        // $templateProcessor->setValue('hari', $hari);

        $dDeskripsi = htmlspecialchars(str_replace("\n","<w:br/>",$data['deskripsi_perusahaan']));
        $dDeskripsi_ = str_replace("&lt;","<",$dDeskripsi);
        $dDeskripsi__ = str_replace("&gt;",">",$dDeskripsi_);

        $templateProcessor->setValue('deskripsi_perusahaan', $dDeskripsi__);

        $dNarasi = htmlspecialchars(str_replace("\n","<w:br/>",$data['narasi_halal']));
        $dNarasi_ = str_replace("&lt;","<",$dNarasi);
        $dNarasi__ = str_replace("&gt;",">",$dNarasi_);

        $templateProcessor->setValue('narasi', $dNarasi__);

        if($request->has("flowchart")){
            $file = $request->file("flowchart");
            $file = $data["flowchart"];   
            $namanya = "Flowchart".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/flowchart/",$namanya);
            $templateProcessor->setImageValue('flowchart', array('path' => 'storage/laporan/flowchart/'.$namanya, 'width' => 400, 'height' =>400, 'ratio' => true));
        }else{
            $templateProcessor->setValue('flowchart',"");
        }

        $jml=1;
        $arrData=array();
        
        $temp=0;
                
        // $templateProcessor->cloneBlock('foto', 1, true, true);
        for ($i=0; $i < sizeof($data['nama_fasilitas']); $i++) {
            $no = $jml;            

            $nama_fasilitas = $data['nama_fasilitas'][$i];
            $fungsi = $data['fungsi'][$i];
            $alamat_fasilitas = $data['alamat_fasilitas'][$i];

            // dd($alamat_fasilitas);
            $dAlamatF = htmlspecialchars(str_replace("\n","<w:br/>",$alamat_fasilitas));
            $dAlamatF_ = str_replace("&lt;","<",$dAlamatF);
            $dAlamatF__ = str_replace("&gt;",">",$dAlamatF_);            

            $arrData[] = array('no' => $no, 'nama_fasilitas' => $nama_fasilitas, 'fungsi' => $fungsi, 'alamat_fasilitas' => $dAlamatF__);
            $jml++;
        }            

        $values = $arrData;
        // $templateProcessor->cloneRow('no', sizeof($data['nama_fasilitas']));
        $templateProcessor->cloneRowAndSetValues('no', $values);

        $jml2=1;
        $arrData2=array();
        
        $temp2=0;        
        for ($i=0; $i < sizeof($data['nama_produk']); $i++) {
            $no = $jml2;
            // dd($data);
            $nama_produk = $data['nama_produk'][$i];
            $jenis_produk = $data['jenis_produk'][$i];
            $rincian_jenis_produk = $data['rincian_jenis_produk'][$i];  

            $templateProcessor->cloneBlock('foto', sizeof($data['foto_data_produk']), true, true);
            $file = $request->file("foto_data_produk");
            $file = $data["foto_data_produk"][$i];
            $nama_foto_produk = "FotoProduk_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotoproduk/",$nama_foto_produk);

            // $pelatihan->gambar_cover = $profileImage;
            $templateProcessor->setImageValue('foto_produk#'.$no, array('path' => 'storage/laporan/fotoproduk/'.$nama_foto_produk, 'width' => 300, 'height' =>300, 'ratio' => true));            
            $templateProcessor->setValue('ket_produk#'.$no, $data['nama_produk'][$i]);
            
            $arrData2[] = array('no2' => $no, 'nama_produk' => $nama_produk, 'jenis_produk' => $jenis_produk, 'rincian_jenis_produk' => $rincian_jenis_produk);

            $jml2++;
        }

        $values2 = $arrData2;
        // $templateProcessor->cloneRow('no', sizeof($data['nama_fasilitas']));
        $templateProcessor->cloneRowAndSetValues('no2', $values2);

        $jml3=1;
        $arrData3=array();
        
        $temp3=0;
                
        // $templateProcessor->cloneBlock('foto', 1, true, true);
        for ($i=0; $i < sizeof($data['nama_bahan']); $i++) {
            $no = $jml3;

            $nama_bahan = $data['nama_bahan'][$i];
            $kategori = $data['kategori'][$i];
            $produsen = $data['produsen'][$i];
            $dokumen_pendukung = $data['dokumen_pendukung'][$i];
            $catatan = $data['catatan'][$i];

            $arrData3[] = array('no3' => $no, 'nama_bahan' => $nama_bahan, 'kategori' => $kategori, 'produsen' => $produsen, 'dokumen_pendukung' => $dokumen_pendukung, 'catatan' => $catatan);
            $jml3++;
        }            

        $values3 = $arrData3;
        // $templateProcessor->cloneRow('no', sizeof($data['nama_fasilitas']));
        $templateProcessor->cloneRowAndSetValues('no3', $values3);

        if($data['rbkebijakanhalal'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi1', 'Memenuhi');            

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi1', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi1', 'Tidak Memenuhi');            

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi1', $inline);            
        }

        if($data['cakebijakanhalal'] != null){
            $templateProcessor->setValue('keterangan1', $data['cakebijakanhalal']);
        }else{
            $templateProcessor->setValue('keterangan1', "");
        }

        if($data['rbtimmanajemenhalal'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi2', 'Memenuhi');            

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi2', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi2', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi2', $inline);            
        }

        if($data['catimmanajemenhalal'] != null){
            $templateProcessor->setValue('keterangan2', $data['catimmanajemenhalal']);
        }else{
            $templateProcessor->setValue('keterangan2', "");
        }

        if($data['rbpelatihanedukasi'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi3', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi3', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi3', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi3', $inline);            
        }

        if($data['capelatihanedukasi'] != null){
            $templateProcessor->setValue('keterangan3', $data['capelatihanedukasi']);
        }else{
            $templateProcessor->setValue('keterangan3', "");
        }

        if($data['rbbahan'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi4', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi4', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi4', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi4', $inline);            
        }

        if($data['cabahan'] != null){
            $templateProcessor->setValue('keterangan4', $data['cabahan']);
        }else{
            $templateProcessor->setValue('keterangan4', "");
        }

        if($data['rbproduk'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi5', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi5', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi5', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi5', $inline);            
        }

        if($data['caproduk'] != null){
            $templateProcessor->setValue('keterangan5', $data['caproduk']);
        }else{
            $templateProcessor->setValue('keterangan5', "");
        }

        if($data['rbfasilitasproduksi'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi6', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi6', $inline);            
        }else{
            $templateProcessor->setValue('tidak_memenuhi6', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi6', $inline);            
        }

        if($data['cafasilitasproduksi'] != null){
            $templateProcessor->setValue('keterangan6', $data['cafasilitasproduksi']);
        }else{
            $templateProcessor->setValue('keterangan6', "");
        }

        if($data['rbprosedurtertulis'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi7', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi7', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi7', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi7', $inline);            
        }

        if($data['caprosedurtertulis'] != null){
            $templateProcessor->setValue('keterangan7', $data['caprosedurtertulis']);
        }else{
            $templateProcessor->setValue('keterangan7', "");
        }

        if($data['rbkemampuantelusur'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi8', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi8', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi8', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi8', $inline);            
        }

        if($data['cakemampuantelusur'] != null){
            $templateProcessor->setValue('keterangan8', $data['cakemampuantelusur']);
        }else{
            $templateProcessor->setValue('keterangan8', "");
        }

        if($data['rbpenangananproduk'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi9', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi9', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi9', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi9', $inline);            
        }

        if($data['capenangananproduk'] != null){
            $templateProcessor->setValue('keterangan9', $data['cakemampuantelusur']);
        }else{
            $templateProcessor->setValue('keterangan9', "");
        }

        if($data['rbauditinternal'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi10', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi10', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi10', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi10', $inline);            
        }

        if($data['caauditinternal'] != null){
            $templateProcessor->setValue('keterangan10', $data['caauditinternal']);
        }else{
            $templateProcessor->setValue('keterangan10', "");
        }

        if($data['rbkajiulang'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi11', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi11', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi11', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi11', $inline);            
        }

        if($data['cakajiulang'] != null){
            $templateProcessor->setValue('keterangan11', $data['cakajiulang']);
        }else{
            $templateProcessor->setValue('keterangan11', "");
        }

        if($data['rbksjh'] == 'memenuhi'){
            $templateProcessor->setValue('memenuhi12', 'Memenuhi');

            $inline = new TextRun();
            $inline->addText('Tidak Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('tidak_memenuhi12', $inline);
        }else{
            $templateProcessor->setValue('tidak_memenuhi12', 'Tidak Memenuhi');

            $inline = new TextRun();
            $inline->addText('Memenuhi', array('strikethrough' => true));
            $templateProcessor->setComplexValue('memenuhi12', $inline);            
        }

        if($data['casjh'] != null){
            $templateProcessor->setValue('keterangan12', $data['casjh']);
        }else{
            $templateProcessor->setValue('keterangan12', "");
        }

        if($data['kesimpulan'] == 'memenuhi'){
            $templateProcessor->setValue('kesimpulan1', "x");
            $templateProcessor->setValue('kesimpulan2', "");
        }else{
            $templateProcessor->setValue('kesimpulan2', "x");
            $templateProcessor->setValue('kesimpulan1', "");
        }

        if($data['video1'] != null){
            $templateProcessor->setValue('video1', $data['video1']);
        }else{
            $templateProcessor->setValue('video1', "");
        }

        if($data['video2'] != null){
            $templateProcessor->setValue('video2', $data['video2']);
        }else{
            $templateProcessor->setValue('video2', "");
        }

        if($data['video3'] != null){
            $templateProcessor->setValue('video3', $data['video3']);
        }else{
            $templateProcessor->setValue('video3', "");
        }

        if($data['video4'] != null){
            $templateProcessor->setValue('video4', $data['video4']);
        }else{
            $templateProcessor->setValue('video4', "");
        }

        if($data['video5a'] != null){
            $templateProcessor->setValue('video5a', $data['video5a']);
        }else{
            $templateProcessor->setValue('video5a', "");
        }

        if($data['video5b'] != null){
            $templateProcessor->setValue('video5b', $data['video5b']);
        }else{
            $templateProcessor->setValue('video5b', "");
        }

        if($data['video5c'] != null){
            $templateProcessor->setValue('video5c', $data['video5c']);
        }else{
            $templateProcessor->setValue('video5c', "");
        }

        if($data['video5d'] != null){
            $templateProcessor->setValue('video5d', $data['video5d']);
        }else{
            $templateProcessor->setValue('video5d', "");
        }

        if($data['video5e'] != null){
            $templateProcessor->setValue('video5e', $data['video5e']);
        }else{
            $templateProcessor->setValue('video5e', "");
        }

        if($data['video5f'] != null){
            $templateProcessor->setValue('video5f', $data['video5f']);
        }else{
            $templateProcessor->setValue('video5f', "");
        }

        if($data['video5g'] != null){
            $templateProcessor->setValue('video5g', $data['video5g']);
        }else{
            $templateProcessor->setValue('video5g', "");
        }

        if($data['video5h'] != null){
            $templateProcessor->setValue('video5h', $data['video5h']);
        }else{
            $templateProcessor->setValue('video5h', "");
        }

        if($data['video5i'] != null){
            $templateProcessor->setValue('video5i', $data['video5i']);
        }else{
            $templateProcessor->setValue('video5i', "");
        }

        if($data['video6'] != null){
            $templateProcessor->setValue('video6', $data['video6']);
        }else{
            $templateProcessor->setValue('video6', "");
        }

        if($data['video7'] != null){
            $templateProcessor->setValue('video7', $data['video7']);
        }else{
            $templateProcessor->setValue('video7', "");
        }

        if($data['video8'] != null){
            $templateProcessor->setValue('video8', $data['video8']);
        }else{
            $templateProcessor->setValue('video8', "");
        }

        if($request->has("foto1")){
            $file = $request->file("foto1");
            $file = $data["foto1"];   
            $namanya = "Foto1".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto1', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto1', "");
        }

        if($request->has("foto2")){
            $file = $request->file("foto2");
            $file = $data["foto2"];   
            $namanya = "Foto2".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto2', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto2', "");
        }

        if($request->has("foto3")){
            $file = $request->file("foto3");
            $file = $data["foto3"];   
            $namanya = "Foto3".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto3', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto3', "");
        }

        if($request->has("foto4")){
            $file = $request->file("foto4");
            $file = $data["foto4"];   
            $namanya = "Foto4".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto4', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto4', "");
        }

        if($request->has("foto5a")){
            $file = $request->file("foto5a");
            $file = $data["foto5a"];
            $namanya = "Foto5a".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5a', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5a', "");
        }

        if($request->has("foto5b")){
            $file = $request->file("foto5b");
            $file = $data["foto5b"];
            $namanya = "Foto5b".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5b', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5b', "");
        }

        if($request->has("foto5c")){
            $file = $request->file("foto5c");
            $file = $data["foto5c"];
            $namanya = "Foto5c".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5c', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5c', "");
        }

        if($request->has("foto5d")){
            $file = $request->file("foto5d");
            $file = $data["foto5d"];
            $namanya = "Foto5d".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5d', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5d', "");
        }

        if($request->has("foto5e")){
            $file = $request->file("foto5e");
            $file = $data["foto5e"];
            $namanya = "Foto5e".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5e', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5e', "");
        }

        if($request->has("foto5f")){
            $file = $request->file("foto5f");
            $file = $data["foto5f"];
            $namanya = "Foto5f".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5f', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5f', "");
        }

        if($request->has("foto5g")){
            $file = $request->file("foto5g");
            $file = $data["foto5g"];
            $namanya = "Foto5g".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5g', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5g', "");
        }

        if($request->has("foto5h")){
            $file = $request->file("foto5h");
            $file = $data["foto5h"];
            $namanya = "Foto5h".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5h', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5h', "");
        }

        if($request->has("foto5i")){
            $file = $request->file("foto5i");
            $file = $data["foto5i"];
            $namanya = "Foto5i".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto5i', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto5i', "");
        }

        if($request->has("foto6")){
            $file = $request->file("foto6");
            $file = $data["foto6"];
            $namanya = "Foto6".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto6', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto6', "");
        }

        if($request->has("foto7")){
            $file = $request->file("foto7");
            $file = $data["foto7"];
            $namanya = "Foto7".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto7', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto7', "");
        }

        if($request->has("foto8")){
            $file = $request->file("foto8");
            $file = $data["foto8"];
            $namanya = "Foto8".$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporan/fotolampiran/",$namanya);
            $templateProcessor->setImageValue('foto8', array('path' => 'storage/laporan/fotolampiran/'.$namanya, 'width' => 70, 'height' =>70, 'ratio' => true));
        }else{
            $templateProcessor->setValue('foto8', "");
        }

        $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs('storage/laporan/upload/Laporan Audit Tahap 2/Isian/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');

        $dataLaporan = DB::table('laporan_audit2')
            ->where('id_registrasi',$data['id_registrasi'])
            ->get();                                

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->laporan_audit2_isian = $fileName;                    
                    $model->id_registrasi = $data['id_registrasi'];                    
                    $model->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;                
                $f = $model2->find($dataLaporan[0]->id);
                $f->laporan_audit2_isian = $fileName;                
                $f->save();                
            }
            DB::Commit();

            $this->LogKegiatan($data['id_registrasi'], Auth::user()->id, Auth::user()->name, 10, "Membuat Berkas Laporan Audit Tahap 2.", Auth::user()->usergroup_id);

        return response()->download('storage/laporan/upload/Laporan Audit Tahap 2/Isian/'.$fileName);
    }

    public function downloadLaporanAuditTahap2Fix(Request $request){
        $data = $request->except('_token','_method');

        // dd($data);
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-09 Formulir Ceklist Audit Isian.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('tipe_audit', "Audit Tahap 2");                                 

        // $id = DB::table('laporan_audit_tahap2')            
        //     ->select('id')
        //     ->orderBy('id','desc')
        //     ->limit(1)
        //     ->get();
                        
        //     foreach($id as $id2){
        //         foreach($id2 as $id_asli){
        //             $idlap = $id_asli;
        //         }                
        //     }
        // dd($idlap);

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "1a2";
        //1a
        if($data['rb1a1'] == 'm'){
            $templateProcessor->setValue('m1a1', "&#8730;");
            $templateProcessor->setValue('tm1a1', "");
            $templateProcessor->setValue('tr1a1', "");            

            $model2->status_kriteria = "m";
        }else if($data['rb1a1'] == 'tm'){
            $templateProcessor->setValue('m1a1', "");
            $templateProcessor->setValue('tm1a1', "&#8730;");
            $templateProcessor->setValue('tr1a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a1'] == 'tr'){
            $templateProcessor->setValue('m1a1', "");
            $templateProcessor->setValue('tm1a1', "");
            $templateProcessor->setValue('tr1a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a1'] == null){
            $templateProcessor->setValue('ca1a1', "");            
        }else{
            $templateProcessor->setValue('ca1a1', $data['ca1a1']);
            $model2->catatan_auditor = $data['ca1a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "1a2";
        //1a
        if($data['rb1a2'] == 'm'){
            $templateProcessor->setValue('m1a2', "&#8730;");
            $templateProcessor->setValue('tm1a2', "");
            $templateProcessor->setValue('tr1a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a2'] == 'tm'){
            $templateProcessor->setValue('m1a2', "");
            $templateProcessor->setValue('tm1a2', "&#8730;");
            $templateProcessor->setValue('tr1a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a2'] == 'tr'){
            $templateProcessor->setValue('m1a2', "");
            $templateProcessor->setValue('tm1a2', "");
            $templateProcessor->setValue('tr1a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a2'] == null){
            $templateProcessor->setValue('ca1a2', "");
        }else{
            $templateProcessor->setValue('ca1a2', $data['ca1a2']);
            $model2->catatan_auditor = $data['ca1a2'];
        }
        $model2->save();
        DB::commit();        
        
        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "1a3";
        //1a
        if($data['rb1a3'] == 'm'){
            $templateProcessor->setValue('m1a3', "&#8730;");
            $templateProcessor->setValue('tm1a3', "");
            $templateProcessor->setValue('tr1a3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a3'] == 'tm'){
            $templateProcessor->setValue('m1a3', "");
            $templateProcessor->setValue('tm1a3', "&#8730;");
            $templateProcessor->setValue('tr1a3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a3'] == 'tr'){
            $templateProcessor->setValue('m1a3', "");
            $templateProcessor->setValue('tm1a3', "");
            $templateProcessor->setValue('tr1a3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a3'] == null){
            $templateProcessor->setValue('ca1a3', "");
        }else{
            $templateProcessor->setValue('ca1a3', $data['ca1a3']);
            $model2->catatan_auditor = $data['ca1a3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1a4";
        //1a
        if($data['rb1a4'] == 'm'){
            $templateProcessor->setValue('m1a4', "&#8730;");
            $templateProcessor->setValue('tm1a4', "");
            $templateProcessor->setValue('tr1a4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a4'] == 'tm'){
            $templateProcessor->setValue('m1a4', "");
            $templateProcessor->setValue('tm1a4', "&#8730;");
            $templateProcessor->setValue('tr1a4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a4'] == 'tr'){
            $templateProcessor->setValue('m1a4', "");
            $templateProcessor->setValue('tm1a4', "");
            $templateProcessor->setValue('tr1a4', "&#8730;");
            
            $model2->status_kriteria = "tr";
        }

        if($data['ca1a4'] == null){
            $templateProcessor->setValue('ca1a4', "");
        }else{
            $templateProcessor->setValue('ca1a4', $data['ca1a4']);
            $model2->catatan_auditor = $data['ca1a4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "1b1";
        //1b
        if($data['rb1b1'] == 'm'){
            $templateProcessor->setValue('m1b1', "&#8730;");
            $templateProcessor->setValue('tm1b1', "");
            $templateProcessor->setValue('tr1b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b1'] == 'tm'){
            $templateProcessor->setValue('m1b1', "");
            $templateProcessor->setValue('tm1b1', "&#8730;");
            $templateProcessor->setValue('tr1b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b1'] == 'tr'){
            $templateProcessor->setValue('m1b1', "");
            $templateProcessor->setValue('tm1b1', "");
            $templateProcessor->setValue('tr1b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b1'] == null){
            $templateProcessor->setValue('ca1b1', "");
        }else{
            $templateProcessor->setValue('ca1b1', $data['ca1b1']);
            $model2->catatan_auditor = $data['ca1b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b2";
        //1b
        if($data['rb1b2'] == 'm'){
            $templateProcessor->setValue('m1b2', "&#8730;");
            $templateProcessor->setValue('tm1b2', "");
            $templateProcessor->setValue('tr1b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b2'] == 'tm'){
            $templateProcessor->setValue('m1b2', "");
            $templateProcessor->setValue('tm1b2', "&#8730;");
            $templateProcessor->setValue('tr1b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b2'] == 'tr'){
            $templateProcessor->setValue('m1b2', "");
            $templateProcessor->setValue('tm1b2', "");
            $templateProcessor->setValue('tr1b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b2'] == null){
            $templateProcessor->setValue('ca1b2', "");
        }else{
            $templateProcessor->setValue('ca1b2', $data['ca1b2']);
            $model2->catatan_auditor = $data['ca1b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b3";
        //1b
        if($data['rb1b3'] == 'm'){
            $templateProcessor->setValue('m1b3', "&#8730;");
            $templateProcessor->setValue('tm1b3', "");
            $templateProcessor->setValue('tr1b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b3'] == 'tm'){
            $templateProcessor->setValue('m1b3', "");
            $templateProcessor->setValue('tm1b3', "&#8730;");
            $templateProcessor->setValue('tr1b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b3'] == 'tr'){
            $templateProcessor->setValue('m1b3', "");
            $templateProcessor->setValue('tm1b3', "");
            $templateProcessor->setValue('tr1b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b3'] == null){
            $templateProcessor->setValue('ca1b3', "");
        }else{
            $templateProcessor->setValue('ca1b3', $data['ca1b3']);
            $model2->catatan_auditor = $data['ca1b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b4";
        //1b
        if($data['rb1b4'] == 'm'){
            $templateProcessor->setValue('m1b4', "&#8730;");
            $templateProcessor->setValue('tm1b4', "");
            $templateProcessor->setValue('tr1b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b4'] == 'tm'){
            $templateProcessor->setValue('m1b4', "");
            $templateProcessor->setValue('tm1b4', "&#8730;");
            $templateProcessor->setValue('tr1b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b4'] == 'tr'){
            $templateProcessor->setValue('m1b4', "");
            $templateProcessor->setValue('tm1b4', "");
            $templateProcessor->setValue('tr1b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b4'] == null){
            $templateProcessor->setValue('ca1b4', "");
        }else{
            $templateProcessor->setValue('ca1b4', $data['ca1b4']);
            $model2->catatan_auditor = $data['ca1b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b5";
        //1b
        if($data['rb1b5'] == 'm'){
            $templateProcessor->setValue('m1b5', "&#8730;");
            $templateProcessor->setValue('tm1b5', "");
            $templateProcessor->setValue('tr1b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b5'] == 'tm'){
            $templateProcessor->setValue('m1b5', "");
            $templateProcessor->setValue('tm1b5', "&#8730;");
            $templateProcessor->setValue('tr1b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b5'] == 'tr'){
            $templateProcessor->setValue('m1b5', "");
            $templateProcessor->setValue('tm1b5', "");
            $templateProcessor->setValue('tr1b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b5'] == null){
            $templateProcessor->setValue('ca1b5', "");
        }else{
            $templateProcessor->setValue('ca1b5', $data['ca1b5']);
            $model2->catatan_auditor = $data['ca1b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b6";
        //1b
        if($data['rb1b6'] == 'm'){
            $templateProcessor->setValue('m1b6', "&#8730;");
            $templateProcessor->setValue('tm1b6', "");
            $templateProcessor->setValue('tr1b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b6'] == 'tm'){
            $templateProcessor->setValue('m1b6', "");
            $templateProcessor->setValue('tm1b6', "&#8730;");
            $templateProcessor->setValue('tr1b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b6'] == 'tr'){
            $templateProcessor->setValue('m1b6', "");
            $templateProcessor->setValue('tm1b6', "");
            $templateProcessor->setValue('tr1b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b6'] == null){
            $templateProcessor->setValue('ca1b6', "");
        }else{
            $templateProcessor->setValue('ca1b6', $data['ca1b6']);
            $model2->catatan_auditor = $data['ca1b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "1b7";
        //1b
        if($data['rb1b7'] == 'm'){
            $templateProcessor->setValue('m1b7', "&#8730;");
            $templateProcessor->setValue('tm1b7', "");
            $templateProcessor->setValue('tr1b7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b7'] == 'tm'){
            $templateProcessor->setValue('m1b7', "");
            $templateProcessor->setValue('tm1b7', "&#8730;");
            $templateProcessor->setValue('tr1b7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b7'] == 'tr'){
            $templateProcessor->setValue('m1b7', "");
            $templateProcessor->setValue('tm1b7', "");
            $templateProcessor->setValue('tr1b7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b7'] == null){
            $templateProcessor->setValue('ca1b7', "");
        }else{
            $templateProcessor->setValue('ca1b7', $data['ca1b7']);
            $model2->catatan_auditor = $data['ca1b7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "1c1";
        //1c
        if($data['rb1c1'] == 'm'){
            $templateProcessor->setValue('m1c1', "&#8730;");
            $templateProcessor->setValue('tm1c1', "");
            $templateProcessor->setValue('tr1c1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c1'] == 'tm'){
            $templateProcessor->setValue('m1c1', "");
            $templateProcessor->setValue('tm1c1', "&#8730;");
            $templateProcessor->setValue('tr1c1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c1'] == 'tr'){
            $templateProcessor->setValue('m1c1', "");
            $templateProcessor->setValue('tm1c1', "");
            $templateProcessor->setValue('tr1c1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c1'] == null){
            $templateProcessor->setValue('ca1c1', "");
        }else{
            $templateProcessor->setValue('ca1c1', $data['ca1c1']);
            $model2->catatan_auditor = $data['ca1c1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c2";
        //1c
        if($data['rb1c2'] == 'm'){
            $templateProcessor->setValue('m1c2', "&#8730;");
            $templateProcessor->setValue('tm1c2', "");
            $templateProcessor->setValue('tr1c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c2'] == 'tm'){
            $templateProcessor->setValue('m1c2', "");
            $templateProcessor->setValue('tm1c2', "&#8730;");
            $templateProcessor->setValue('tr1c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c2'] == 'tr'){
            $templateProcessor->setValue('m1c2', "");
            $templateProcessor->setValue('tm1c2', "");
            $templateProcessor->setValue('tr1c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c2'] == null){
            $templateProcessor->setValue('ca1c2', "");
        }else{
            $templateProcessor->setValue('ca1c2', $data['ca1c2']);
            $model2->catatan_auditor = $data['ca1c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c3";
        //1c
        if($data['rb1c3'] == 'm'){
            $templateProcessor->setValue('m1c3', "&#8730;");
            $templateProcessor->setValue('tm1c3', "");
            $templateProcessor->setValue('tr1c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c3'] == 'tm'){
            $templateProcessor->setValue('m1c3', "");
            $templateProcessor->setValue('tm1c3', "&#8730;");
            $templateProcessor->setValue('tr1c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c3'] == 'tr'){
            $templateProcessor->setValue('m1c3', "");
            $templateProcessor->setValue('tm1c3', "");
            $templateProcessor->setValue('tr1c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c3'] == null){
            $templateProcessor->setValue('ca1c3', "");
        }else{
            $templateProcessor->setValue('ca1c3', $data['ca1c3']);
            $model2->catatan_auditor = $data['ca1c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c4";
        //1c
        if($data['rb1c4'] == 'm'){
            $templateProcessor->setValue('m1c4', "&#8730;");
            $templateProcessor->setValue('tm1c4', "");
            $templateProcessor->setValue('tr1c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c4'] == 'tm'){
            $templateProcessor->setValue('m1c4', "");
            $templateProcessor->setValue('tm1c4', "&#8730;");
            $templateProcessor->setValue('tr1c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c4'] == 'tr'){
            $templateProcessor->setValue('m1c4', "");
            $templateProcessor->setValue('tm1c4', "");
            $templateProcessor->setValue('tr1c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c4'] == null){
            $templateProcessor->setValue('ca1c4', "");
        }else{
            $templateProcessor->setValue('ca1c4', $data['ca1c4']);
            $model2->catatan_auditor = $data['ca1c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "21";
        //2
        if($data['rb21'] == 'm'){
            $templateProcessor->setValue('m21', "&#8730;");
            $templateProcessor->setValue('tm21', "");
            $templateProcessor->setValue('tr21', "");

            $model2->status_kriteria = "m";
        }else if($data['rb21'] == 'tm'){
            $templateProcessor->setValue('m21', "");
            $templateProcessor->setValue('tm21', "&#8730;");
            $templateProcessor->setValue('tr21', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb21'] == 'tr'){
            $templateProcessor->setValue('m21', "");
            $templateProcessor->setValue('tm21', "");
            $templateProcessor->setValue('tr21', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca21'] == null){
            $templateProcessor->setValue('ca21', "");
        }else{
            $templateProcessor->setValue('ca21', $data['ca21']);
            $model2->catatan_auditor = $data['ca21'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "22";
        //2
        if($data['rb22'] == 'm'){
            $templateProcessor->setValue('m22', "&#8730;");
            $templateProcessor->setValue('tm22', "");
            $templateProcessor->setValue('tr22', "");

            $model2->status_kriteria = "m";
        }else if($data['rb22'] == 'tm'){
            $templateProcessor->setValue('m22', "");
            $templateProcessor->setValue('tm22', "&#8730;");
            $templateProcessor->setValue('tr22', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb22'] == 'tr'){
            $templateProcessor->setValue('m22', "");
            $templateProcessor->setValue('tm22', "");
            $templateProcessor->setValue('tr22', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca22'] == null){
            $templateProcessor->setValue('ca22', "");
        }else{
            $templateProcessor->setValue('ca22', $data['ca22']);
            $model2->catatan_auditor = $data['ca22'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "23";
        //2
        if($data['rb23'] == 'm'){
            $templateProcessor->setValue('m23', "&#8730;");
            $templateProcessor->setValue('tm23', "");
            $templateProcessor->setValue('tr23', "");

            $model2->status_kriteria = "m";
        }else if($data['rb23'] == 'tm'){
            $templateProcessor->setValue('m23', "");
            $templateProcessor->setValue('tm23', "&#8730;");
            $templateProcessor->setValue('tr23', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb23'] == 'tr'){
            $templateProcessor->setValue('m23', "");
            $templateProcessor->setValue('tm23', "");
            $templateProcessor->setValue('tr23', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca23'] == null){
            $templateProcessor->setValue('ca23', "");
        }else{
            $templateProcessor->setValue('ca23', $data['ca23']);
            $model2->catatan_auditor = $data['ca23'];
        }
        $model2->save();
        DB::commit();

        // $model2 = new DetailLaporanAuditTahap2();
        // DB::beginTransaction();
        // $model2->id_registrasi = $data['id_registrasi'];
        // $model2->id_penjadwalan = $data['id_penjadwalan'];      
        // $model2->kriteria_sjph = "24";
        // //2
        // if($data['rb24'] == 'm'){
        //     $templateProcessor->setValue('m24', "&#8730;");
        //     $templateProcessor->setValue('tm24', "");
        //     $templateProcessor->setValue('tr24', "");

        //     $model2->status_kriteria = "m";
        // }else if($data['rb24'] == 'tm'){
        //     $templateProcessor->setValue('m24', "");
        //     $templateProcessor->setValue('tm24', "&#8730;");
        //     $templateProcessor->setValue('tr24', "");

        //     $model2->status_kriteria = "tm";
        // }else if($data['rb24'] == 'tr'){
        //     $templateProcessor->setValue('m24', "");
        //     $templateProcessor->setValue('tm24', "");
        //     $templateProcessor->setValue('tr24', "&#8730;");

        //     $model2->status_kriteria = "tr";
        // }

        // if($data['ca24'] == null){
        //     $templateProcessor->setValue('ca24', "");
        // }else{
        //     $templateProcessor->setValue('ca24', $data['ca24']);
        //     $model2->catatan_auditor = $data['ca24'];
        // }
        // $model2->save();
        // DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a1";
        //3
        if($data['rb3a1'] == 'm'){
            $templateProcessor->setValue('m3a1', "&#8730;");
            $templateProcessor->setValue('tm3a1', "");
            $templateProcessor->setValue('tr3a1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a1'] == 'tm'){
            $templateProcessor->setValue('m3a1', "");
            $templateProcessor->setValue('tm3a1', "&#8730;");
            $templateProcessor->setValue('tr3a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a1'] == 'tr'){
            $templateProcessor->setValue('m3a1', "");
            $templateProcessor->setValue('tm3a1', "");
            $templateProcessor->setValue('tr3a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a1'] == null){
            $templateProcessor->setValue('ca3a1', "");
        }else{
            $templateProcessor->setValue('ca3a1', $data['ca3a1']);
            $model2->catatan_auditor = $data['ca3a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a2";
        //3
        if($data['rb3a2'] == 'm'){
            $templateProcessor->setValue('m3a2', "&#8730;");
            $templateProcessor->setValue('tm3a2', "");
            $templateProcessor->setValue('tr3a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a2'] == 'tm'){
            $templateProcessor->setValue('m3a2', "");
            $templateProcessor->setValue('tm3a2', "&#8730;");
            $templateProcessor->setValue('tr3a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a2'] == 'tr'){
            $templateProcessor->setValue('m3a2', "");
            $templateProcessor->setValue('tm3a2', "");
            $templateProcessor->setValue('tr3a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a2'] == null){
            $templateProcessor->setValue('ca3a2', "");
        }else{
            $templateProcessor->setValue('ca3a2', $data['ca3a2']);
            $model2->catatan_auditor = $data['ca3a2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a3a";
        //3
        if($data['rb3a3a'] == 'm'){
            $templateProcessor->setValue('m3a3a', "&#8730;");
            $templateProcessor->setValue('tm3a3a', "");
            $templateProcessor->setValue('tr3a3a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3a'] == 'tm'){
            $templateProcessor->setValue('m3a3a', "");
            $templateProcessor->setValue('tm3a3a', "&#8730;");
            $templateProcessor->setValue('tr3a3a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3a'] == 'tr'){
            $templateProcessor->setValue('m3a3a', "");
            $templateProcessor->setValue('tm3a3a', "");
            $templateProcessor->setValue('tr3a3a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3a'] == null){
            $templateProcessor->setValue('ca3a3a', "");
        }else{
            $templateProcessor->setValue('ca3a3a', $data['ca3a3a']);
            $model2->catatan_auditor = $data['ca3a3a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a3b";
        //3
        if($data['rb3a3b'] == 'm'){
            $templateProcessor->setValue('m3a3b', "&#8730;");
            $templateProcessor->setValue('tm3a3b', "");
            $templateProcessor->setValue('tr3a3b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3b'] == 'tm'){
            $templateProcessor->setValue('m3a3b', "");
            $templateProcessor->setValue('tm3a3b', "&#8730;");
            $templateProcessor->setValue('tr3a3b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3b'] == 'tr'){
            $templateProcessor->setValue('m3a3b', "");
            $templateProcessor->setValue('tm3a3b', "");
            $templateProcessor->setValue('tr3a3b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3b'] == null){
            $templateProcessor->setValue('ca3a3b', "");
        }else{
            $templateProcessor->setValue('ca3a3b', $data['ca3a3b']);
            $model2->catatan_auditor = $data['ca3a3b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a3c";
        //3
        if($data['rb3a3c'] == 'm'){
            $templateProcessor->setValue('m3a3c', "&#8730;");
            $templateProcessor->setValue('tm3a3c', "");
            $templateProcessor->setValue('tr3a3c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3c'] == 'tm'){
            $templateProcessor->setValue('m3a3c', "");
            $templateProcessor->setValue('tm3a3c', "&#8730;");
            $templateProcessor->setValue('tr3a3c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3c'] == 'tr'){
            $templateProcessor->setValue('m3a3c', "");
            $templateProcessor->setValue('tm3a3c', "");
            $templateProcessor->setValue('tr3a3c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3c'] == null){
            $templateProcessor->setValue('ca3a3c', "");
        }else{
            $templateProcessor->setValue('ca3a3c', $data['ca3a3c']);
            $model2->catatan_auditor = $data['ca3a3c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a3d";
        //3
        if($data['rb3a3d'] == 'm'){
            $templateProcessor->setValue('m3a3d', "&#8730;");
            $templateProcessor->setValue('tm3a3d', "");
            $templateProcessor->setValue('tr3a3d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3d'] == 'tm'){
            $templateProcessor->setValue('m3a3d', "");
            $templateProcessor->setValue('tm3a3d', "&#8730;");
            $templateProcessor->setValue('tr3a3d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3d'] == 'tr'){
            $templateProcessor->setValue('m3a3d', "");
            $templateProcessor->setValue('tm3a3d', "");
            $templateProcessor->setValue('tr3a3d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3d'] == null){
            $templateProcessor->setValue('ca3a3d', "");
        }else{
            $templateProcessor->setValue('ca3a3d', $data['ca3a3d']);
            $model2->catatan_auditor = $data['ca3a3d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a3e";
        //3
        if($data['rb3a3e'] == 'm'){
            $templateProcessor->setValue('m3a3e', "&#8730;");
            $templateProcessor->setValue('tm3a3e', "");
            $templateProcessor->setValue('tr3a3e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3e'] == 'tm'){
            $templateProcessor->setValue('m3a3e', "");
            $templateProcessor->setValue('tm3a3e', "&#8730;");
            $templateProcessor->setValue('tr3a3e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3e'] == 'tr'){
            $templateProcessor->setValue('m3a3e', "");
            $templateProcessor->setValue('tm3a3e', "");
            $templateProcessor->setValue('tr3a3e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3e'] == null){
            $templateProcessor->setValue('ca3a3e', "");
        }else{
            $templateProcessor->setValue('ca3a3e', $data['ca3a3e']);
            $model2->catatan_auditor = $data['ca3a3e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a3f";
        //3
        if($data['rb3a3f'] == 'm'){
            $templateProcessor->setValue('m3a3f', "&#8730;");
            $templateProcessor->setValue('tm3a3f', "");
            $templateProcessor->setValue('tr3a3f', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3f'] == 'tm'){
            $templateProcessor->setValue('m3a3f', "");
            $templateProcessor->setValue('tm3a3f', "&#8730;");
            $templateProcessor->setValue('tr3a3f', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3f'] == 'tr'){
            $templateProcessor->setValue('m3a3f', "");
            $templateProcessor->setValue('tm3a3f', "");
            $templateProcessor->setValue('tr3a3f', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3f'] == null){
            $templateProcessor->setValue('ca3a3f', "");
        }else{
            $templateProcessor->setValue('ca3a3f', $data['ca3a3f']);
            $model2->catatan_auditor = $data['ca3a3f'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4a";
        //3
        if($data['rb3a4a'] == 'm'){
            $templateProcessor->setValue('m3a4a', "&#8730;");
            $templateProcessor->setValue('tm3a4a', "");
            $templateProcessor->setValue('tr3a4a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4a'] == 'tm'){
            $templateProcessor->setValue('m3a4a', "");
            $templateProcessor->setValue('tm3a4a', "&#8730;");
            $templateProcessor->setValue('tr3a4a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4a'] == 'tr'){
            $templateProcessor->setValue('m3a4a', "");
            $templateProcessor->setValue('tm3a4a', "");
            $templateProcessor->setValue('tr3a4a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4a'] == null){
            $templateProcessor->setValue('ca3a4a', "");
        }else{
            $templateProcessor->setValue('ca3a4a', $data['ca3a4a']);
            $model2->catatan_auditor = $data['ca3a4a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4b";
        //3
        if($data['rb3a4b'] == 'm'){
            $templateProcessor->setValue('m3a4b', "&#8730;");
            $templateProcessor->setValue('tm3a4b', "");
            $templateProcessor->setValue('tr3a4b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4b'] == 'tm'){
            $templateProcessor->setValue('m3a4b', "");
            $templateProcessor->setValue('tm3a4b', "&#8730;");
            $templateProcessor->setValue('tr3a4b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4b'] == 'tr'){
            $templateProcessor->setValue('m3a4b', "");
            $templateProcessor->setValue('tm3a4b', "");
            $templateProcessor->setValue('tr3a4b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4b'] == null){
            $templateProcessor->setValue('ca3a4b', "");
        }else{
            $templateProcessor->setValue('ca3a4b', $data['ca3a4b']);
            $model2->catatan_auditor = $data['ca3a4b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4c";
        //3
        if($data['rb3a4c'] == 'm'){
            $templateProcessor->setValue('m3a4c', "&#8730;");
            $templateProcessor->setValue('tm3a4c', "");
            $templateProcessor->setValue('tr3a4c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4c'] == 'tm'){
            $templateProcessor->setValue('m3a4c', "");
            $templateProcessor->setValue('tm3a4c', "&#8730;");
            $templateProcessor->setValue('tr3a4c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4c'] == 'tr'){
            $templateProcessor->setValue('m3a4c', "");
            $templateProcessor->setValue('tm3a4c', "");
            $templateProcessor->setValue('tr3a4c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4c'] == null){
            $templateProcessor->setValue('ca3a4c', "");
        }else{
            $templateProcessor->setValue('ca3a4c', $data['ca3a4c']);
            $model2->catatan_auditor = $data['ca3a4c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4d";
        //3
        if($data['rb3a4d'] == 'm'){
            $templateProcessor->setValue('m3a4d', "&#8730;");
            $templateProcessor->setValue('tm3a4d', "");
            $templateProcessor->setValue('tr3a4d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4d'] == 'tm'){
            $templateProcessor->setValue('m3a4d', "");
            $templateProcessor->setValue('tm3a4d', "&#8730;");
            $templateProcessor->setValue('tr3a4d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4d'] == 'tr'){
            $templateProcessor->setValue('m3a4d', "");
            $templateProcessor->setValue('tm3a4d', "");
            $templateProcessor->setValue('tr3a4d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4d'] == null){
            $templateProcessor->setValue('ca3a4d', "");
        }else{
            $templateProcessor->setValue('ca3a4d', $data['ca3a4d']);
            $model2->catatan_auditor = $data['ca3a4d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4e";
        //3
        if($data['rb3a4e'] == 'm'){
            $templateProcessor->setValue('m3a4e', "&#8730;");
            $templateProcessor->setValue('tm3a4e', "");
            $templateProcessor->setValue('tr3a4e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4e'] == 'tm'){
            $templateProcessor->setValue('m3a4e', "");
            $templateProcessor->setValue('tm3a4e', "&#8730;");
            $templateProcessor->setValue('tr3a4e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4e'] == 'tr'){
            $templateProcessor->setValue('m3a4e', "");
            $templateProcessor->setValue('tm3a4e', "");
            $templateProcessor->setValue('tr3a4e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4e'] == null){
            $templateProcessor->setValue('ca3a4e', "");
        }else{
            $templateProcessor->setValue('ca3a4e', $data['ca3a4e']);
            $model2->catatan_auditor = $data['ca3a4e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4f";
        //3
        if($data['rb3a4f'] == 'm'){
            $templateProcessor->setValue('m3a4f', "&#8730;");
            $templateProcessor->setValue('tm3a4f', "");
            $templateProcessor->setValue('tr3a4f', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4f'] == 'tm'){
            $templateProcessor->setValue('m3a4f', "");
            $templateProcessor->setValue('tm3a4f', "&#8730;");
            $templateProcessor->setValue('tr3a4f', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4f'] == 'tr'){
            $templateProcessor->setValue('m3a4f', "");
            $templateProcessor->setValue('tm3a4f', "");
            $templateProcessor->setValue('tr3a4f', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4f'] == null){
            $templateProcessor->setValue('ca3a4f', "");
        }else{
            $templateProcessor->setValue('ca3a4f', $data['ca3a4f']);
            $model2->catatan_auditor = $data['ca3a4f'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4g";
        //3
        if($data['rb3a4g'] == 'm'){
            $templateProcessor->setValue('m3a4g', "&#8730;");
            $templateProcessor->setValue('tm3a4g', "");
            $templateProcessor->setValue('tr3a4g', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4g'] == 'tm'){
            $templateProcessor->setValue('m3a4g', "");
            $templateProcessor->setValue('tm3a4g', "&#8730;");
            $templateProcessor->setValue('tr3a4g', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4g'] == 'tr'){
            $templateProcessor->setValue('m3a4g', "");
            $templateProcessor->setValue('tm3a4g', "");
            $templateProcessor->setValue('tr3a4g', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4g'] == null){
            $templateProcessor->setValue('ca3a4g', "");
        }else{
            $templateProcessor->setValue('ca3a4g', $data['ca3a4g']);
            $model2->catatan_auditor = $data['ca3a4g'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];
        $model2->kriteria_sjph = "3a4h";
        //3
        if($data['rb3a4h'] == 'm'){
            $templateProcessor->setValue('m3a4h', "&#8730;");
            $templateProcessor->setValue('tm3a4h', "");
            $templateProcessor->setValue('tr3a4h', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4h'] == 'tm'){
            $templateProcessor->setValue('m3a4h', "");
            $templateProcessor->setValue('tm3a4h', "&#8730;");
            $templateProcessor->setValue('tr3a4h', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4h'] == 'tr'){
            $templateProcessor->setValue('m3a4h', "");
            $templateProcessor->setValue('tm3a4h', "");
            $templateProcessor->setValue('tr3a4h', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4h'] == null){
            $templateProcessor->setValue('ca3a4h', "");
        }else{
            $templateProcessor->setValue('ca3a4h', $data['ca3a4h']);
            $model2->catatan_auditor = $data['ca3a4h'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5a";
        //3
        if($data['rb3a5a'] == 'm'){
            $templateProcessor->setValue('m3a5a', "&#8730;");
            $templateProcessor->setValue('tm3a5a', "");
            $templateProcessor->setValue('tr3a5a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5a'] == 'tm'){
            $templateProcessor->setValue('m3a5a', "");
            $templateProcessor->setValue('tm3a5a', "&#8730;");
            $templateProcessor->setValue('tr3a5a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5a'] == 'tr'){
            $templateProcessor->setValue('m3a5a', "");
            $templateProcessor->setValue('tm3a5a', "");
            $templateProcessor->setValue('tr3a5a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5a'] == null){
            $templateProcessor->setValue('ca3a5a', "");
        }else{
            $templateProcessor->setValue('ca3a5a', $data['ca3a5a']);
            $model2->catatan_auditor = $data['ca3a5a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5b";
        //3
        if($data['rb3a5b'] == 'm'){
            $templateProcessor->setValue('m3a5b', "&#8730;");
            $templateProcessor->setValue('tm3a5b', "");
            $templateProcessor->setValue('tr3a5b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5b'] == 'tm'){
            $templateProcessor->setValue('m3a5b', "");
            $templateProcessor->setValue('tm3a5b', "&#8730;");
            $templateProcessor->setValue('tr3a5b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5b'] == 'tr'){
            $templateProcessor->setValue('m3a5b', "");
            $templateProcessor->setValue('tm3a5b', "");
            $templateProcessor->setValue('tr3a5b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5b'] == null){
            $templateProcessor->setValue('ca3a5b', "");
        }else{
            $templateProcessor->setValue('ca3a5b', $data['ca3a5b']);
            $model2->catatan_auditor = $data['ca3a5b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5c";
        //3
        if($data['rb3a5c'] == 'm'){
            $templateProcessor->setValue('m3a5c', "&#8730;");
            $templateProcessor->setValue('tm3a5c', "");
            $templateProcessor->setValue('tr3a5c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5c'] == 'tm'){
            $templateProcessor->setValue('m3a5c', "");
            $templateProcessor->setValue('tm3a5c', "&#8730;");
            $templateProcessor->setValue('tr3a5c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5c'] == 'tr'){
            $templateProcessor->setValue('m3a5c', "");
            $templateProcessor->setValue('tm3a5c', "");
            $templateProcessor->setValue('tr3a5c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5c'] == null){
            $templateProcessor->setValue('ca3a5c', "");
        }else{
            $templateProcessor->setValue('ca3a5c', $data['ca3a5c']);
            $model2->catatan_auditor = $data['ca3a5c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5d";
        //3
        if($data['rb3a5d'] == 'm'){
            $templateProcessor->setValue('m3a5d', "&#8730;");
            $templateProcessor->setValue('tm3a5d', "");
            $templateProcessor->setValue('tr3a5d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5d'] == 'tm'){
            $templateProcessor->setValue('m3a5d', "");
            $templateProcessor->setValue('tm3a5d', "&#8730;");
            $templateProcessor->setValue('tr3a5d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5d'] == 'tr'){
            $templateProcessor->setValue('m3a5d', "");
            $templateProcessor->setValue('tm3a5d', "");
            $templateProcessor->setValue('tr3a5d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5d'] == null){
            $templateProcessor->setValue('ca3a5d', "");
        }else{
            $templateProcessor->setValue('ca3a5d', $data['ca3a5d']);
            $model2->catatan_auditor = $data['ca3a5d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5e";
        //3
        if($data['rb3a5e'] == 'm'){
            $templateProcessor->setValue('m3a5e', "&#8730;");
            $templateProcessor->setValue('tm3a5e', "");
            $templateProcessor->setValue('tr3a5e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5e'] == 'tm'){
            $templateProcessor->setValue('m3a5e', "");
            $templateProcessor->setValue('tm3a5e', "&#8730;");
            $templateProcessor->setValue('tr3a5e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5e'] == 'tr'){
            $templateProcessor->setValue('m3a5e', "");
            $templateProcessor->setValue('tm3a5e', "");
            $templateProcessor->setValue('tr3a5e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5e'] == null){
            $templateProcessor->setValue('ca3a5e', "");
        }else{
            $templateProcessor->setValue('ca3a5e', $data['ca3a5e']);
            $model2->catatan_auditor = $data['ca3a5e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5f";
        //3
        if($data['rb3a5f'] == 'm'){
            $templateProcessor->setValue('m3a5f', "&#8730;");
            $templateProcessor->setValue('tm3a5f', "");
            $templateProcessor->setValue('tr3a5f', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5f'] == 'tm'){
            $templateProcessor->setValue('m3a5f', "");
            $templateProcessor->setValue('tm3a5f', "&#8730;");
            $templateProcessor->setValue('tr3a5f', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5f'] == 'tr'){
            $templateProcessor->setValue('m3a5f', "");
            $templateProcessor->setValue('tm3a5f', "");
            $templateProcessor->setValue('tr3a5f', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5f'] == null){
            $templateProcessor->setValue('ca3a5f', "");
        }else{
            $templateProcessor->setValue('ca3a5f', $data['ca3a5f']);
            $model2->catatan_auditor = $data['ca3a5f'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a5g";
        //3
        if($data['rb3a5g'] == 'm'){
            $templateProcessor->setValue('m3a5g', "&#8730;");
            $templateProcessor->setValue('tm3a5g', "");
            $templateProcessor->setValue('tr3a5g', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5g'] == 'tm'){
            $templateProcessor->setValue('m3a5g', "");
            $templateProcessor->setValue('tm3a5g', "&#8730;");
            $templateProcessor->setValue('tr3a5g', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5g'] == 'tr'){
            $templateProcessor->setValue('m3a5g', "");
            $templateProcessor->setValue('tm3a5g', "");
            $templateProcessor->setValue('tr3a5g', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5g'] == null){
            $templateProcessor->setValue('ca3a5g', "");
        }else{
            $templateProcessor->setValue('ca3a5g', $data['ca3a5g']);
            $model2->catatan_auditor = $data['ca3a5g'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a6a";
        //3
        if($data['rb3a6a'] == 'm'){
            $templateProcessor->setValue('m3a6a', "&#8730;");
            $templateProcessor->setValue('tm3a6a', "");
            $templateProcessor->setValue('tr3a6a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a6a'] == 'tm'){
            $templateProcessor->setValue('m3a6a', "");
            $templateProcessor->setValue('tm3a6a', "&#8730;");
            $templateProcessor->setValue('tr3a6a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a6a'] == 'tr'){
            $templateProcessor->setValue('m3a6a', "");
            $templateProcessor->setValue('tm3a6a', "");
            $templateProcessor->setValue('tr3a6a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a6a'] == null){
            $templateProcessor->setValue('ca3a6a', "");
        }else{
            $templateProcessor->setValue('ca3a6a', $data['ca3a6a']);
            $model2->catatan_auditor = $data['ca3a6a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a6b";
        //3
        if($data['rb3a6b'] == 'm'){
            $templateProcessor->setValue('m3a6b', "&#8730;");
            $templateProcessor->setValue('tm3a6b', "");
            $templateProcessor->setValue('tr3a6b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a6b'] == 'tm'){
            $templateProcessor->setValue('m3a6b', "");
            $templateProcessor->setValue('tm3a6b', "&#8730;");
            $templateProcessor->setValue('tr3a6b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a6b'] == 'tr'){
            $templateProcessor->setValue('m3a6b', "");
            $templateProcessor->setValue('tm3a6b', "");
            $templateProcessor->setValue('tr3a6b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a6b'] == null){
            $templateProcessor->setValue('ca3a6b', "");
        }else{
            $templateProcessor->setValue('ca3a6b', $data['ca3a6b']);
            $model2->catatan_auditor = $data['ca3a6b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a6c";
        //3
        if($data['rb3a6c'] == 'm'){
            $templateProcessor->setValue('m3a6c', "&#8730;");
            $templateProcessor->setValue('tm3a6c', "");
            $templateProcessor->setValue('tr3a6c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a6c'] == 'tm'){
            $templateProcessor->setValue('m3a6c', "");
            $templateProcessor->setValue('tm3a6c', "&#8730;");
            $templateProcessor->setValue('tr3a6c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a6c'] == 'tr'){
            $templateProcessor->setValue('m3a6c', "");
            $templateProcessor->setValue('tm3a6c', "");
            $templateProcessor->setValue('tr3a6c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a6c'] == null){
            $templateProcessor->setValue('ca3a6c', "");
        }else{
            $templateProcessor->setValue('ca3a6c', $data['ca3a6c']);
            $model2->catatan_auditor = $data['ca3a6c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a7a";
        //3
        if($data['rb3a7a'] == 'm'){
            $templateProcessor->setValue('m3a7a', "&#8730;");
            $templateProcessor->setValue('tm3a7a', "");
            $templateProcessor->setValue('tr3a7a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7a'] == 'tm'){
            $templateProcessor->setValue('m3a7a', "");
            $templateProcessor->setValue('tm3a7a', "&#8730;");
            $templateProcessor->setValue('tr3a7a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7a'] == 'tr'){
            $templateProcessor->setValue('m3a7a', "");
            $templateProcessor->setValue('tm3a7a', "");
            $templateProcessor->setValue('tr3a7a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7a'] == null){
            $templateProcessor->setValue('ca3a7a', "");
        }else{
            $templateProcessor->setValue('ca3a7a', $data['ca3a7a']);
            $model2->catatan_auditor = $data['ca3a7a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a7b";
        //3
        if($data['rb3a7b'] == 'm'){
            $templateProcessor->setValue('m3a7b', "&#8730;");
            $templateProcessor->setValue('tm3a7b', "");
            $templateProcessor->setValue('tr3a7b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7b'] == 'tm'){
            $templateProcessor->setValue('m3a7b', "");
            $templateProcessor->setValue('tm3a7b', "&#8730;");
            $templateProcessor->setValue('tr3a7b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7b'] == 'tr'){
            $templateProcessor->setValue('m3a7b', "");
            $templateProcessor->setValue('tm3a7b', "");
            $templateProcessor->setValue('tr3a7b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7b'] == null){
            $templateProcessor->setValue('ca3a7b', "");
        }else{
            $templateProcessor->setValue('ca3a7b', $data['ca3a7b']);
            $model2->catatan_auditor = $data['ca3a7b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a7c";
        //3
        if($data['rb3a7c'] == 'm'){
            $templateProcessor->setValue('m3a7c', "&#8730;");
            $templateProcessor->setValue('tm3a7c', "");
            $templateProcessor->setValue('tr3a7c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7c'] == 'tm'){
            $templateProcessor->setValue('m3a7c', "");
            $templateProcessor->setValue('tm3a7c', "&#8730;");
            $templateProcessor->setValue('tr3a7c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7c'] == 'tr'){
            $templateProcessor->setValue('m3a7c', "");
            $templateProcessor->setValue('tm3a7c', "");
            $templateProcessor->setValue('tr3a7c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7c'] == null){
            $templateProcessor->setValue('ca3a7c', "");
        }else{
            $templateProcessor->setValue('ca3a7c', $data['ca3a7c']);
            $model2->catatan_auditor = $data['ca3a7c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a7d";
        //3
        if($data['rb3a7d'] == 'm'){
            $templateProcessor->setValue('m3a7d', "&#8730;");
            $templateProcessor->setValue('tm3a7d', "");
            $templateProcessor->setValue('tr3a7d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7d'] == 'tm'){
            $templateProcessor->setValue('m3a7d', "");
            $templateProcessor->setValue('tm3a7d', "&#8730;");
            $templateProcessor->setValue('tr3a7d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7d'] == 'tr'){
            $templateProcessor->setValue('m3a7d', "");
            $templateProcessor->setValue('tm3a7d', "");
            $templateProcessor->setValue('tr3a7d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7d'] == null){
            $templateProcessor->setValue('ca3a7d', "");
        }else{
            $templateProcessor->setValue('ca3a7d', $data['ca3a7d']);
            $model2->catatan_auditor = $data['ca3a7d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a7e";
        //3
        if($data['rb3a7e'] == 'm'){
            $templateProcessor->setValue('m3a7e', "&#8730;");
            $templateProcessor->setValue('tm3a7e', "");
            $templateProcessor->setValue('tr3a7e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7e'] == 'tm'){
            $templateProcessor->setValue('m3a7e', "");
            $templateProcessor->setValue('tm3a7e', "&#8730;");
            $templateProcessor->setValue('tr3a7e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7e'] == 'tr'){
            $templateProcessor->setValue('m3a7e', "");
            $templateProcessor->setValue('tm3a7e', "");
            $templateProcessor->setValue('tr3a7e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7e'] == null){
            $templateProcessor->setValue('ca3a7e', "");
        }else{
            $templateProcessor->setValue('ca3a7e', $data['ca3a7e']);
            $model2->catatan_auditor = $data['ca3a7e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a7f";
        //3
        if($data['rb3a7f'] == 'm'){
            $templateProcessor->setValue('m3a7f', "&#8730;");
            $templateProcessor->setValue('tm3a7f', "");
            $templateProcessor->setValue('tr3a7f', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7f'] == 'tm'){
            $templateProcessor->setValue('m3a7f', "");
            $templateProcessor->setValue('tm3a7f', "&#8730;");
            $templateProcessor->setValue('tr3a7f', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7f'] == 'tr'){
            $templateProcessor->setValue('m3a7f', "");
            $templateProcessor->setValue('tm3a7f', "");
            $templateProcessor->setValue('tr3a7f', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7f'] == null){
            $templateProcessor->setValue('ca3a7f', "");
        }else{
            $templateProcessor->setValue('ca3a7f', $data['ca3a7f']);
            $model2->catatan_auditor = $data['ca3a7f'];
        }
        $model2->save();
        DB::commit();        

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a8a";
        //3
        if($data['rb3a8a'] == 'm'){
            $templateProcessor->setValue('m3a8a', "&#8730;");
            $templateProcessor->setValue('tm3a8a', "");
            $templateProcessor->setValue('tr3a8a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a8a'] == 'tm'){
            $templateProcessor->setValue('m3a8a', "");
            $templateProcessor->setValue('tm3a8a', "&#8730;");
            $templateProcessor->setValue('tr3a8a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a8a'] == 'tr'){
            $templateProcessor->setValue('m3a8a', "");
            $templateProcessor->setValue('tm3a8a', "");
            $templateProcessor->setValue('tr3a8a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a8a'] == null){
            $templateProcessor->setValue('ca3a8a', "");
        }else{
            $templateProcessor->setValue('ca3a8a', $data['ca3a8a']);
            $model2->catatan_auditor = $data['ca3a8a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a8b";
        //3
        if($data['rb3a8b'] == 'm'){
            $templateProcessor->setValue('m3a8b', "&#8730;");
            $templateProcessor->setValue('tm3a8b', "");
            $templateProcessor->setValue('tr3a8b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a8b'] == 'tm'){
            $templateProcessor->setValue('m3a8b', "");
            $templateProcessor->setValue('tm3a8b', "&#8730;");
            $templateProcessor->setValue('tr3a8b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a8b'] == 'tr'){
            $templateProcessor->setValue('m3a8b', "");
            $templateProcessor->setValue('tm3a8b', "");
            $templateProcessor->setValue('tr3a8b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a8b'] == null){
            $templateProcessor->setValue('ca3a8b', "");
        }else{
            $templateProcessor->setValue('ca3a8b', $data['ca3a8b']);
            $model2->catatan_auditor = $data['ca3a8b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a8c";
        //3
        if($data['rb3a8c'] == 'm'){
            $templateProcessor->setValue('m3a8c', "&#8730;");
            $templateProcessor->setValue('tm3a8c', "");
            $templateProcessor->setValue('tr3a8c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a8c'] == 'tm'){
            $templateProcessor->setValue('m3a8c', "");
            $templateProcessor->setValue('tm3a8c', "&#8730;");
            $templateProcessor->setValue('tr3a8c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a8c'] == 'tr'){
            $templateProcessor->setValue('m3a8c', "");
            $templateProcessor->setValue('tm3a8c', "");
            $templateProcessor->setValue('tr3a8c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a8c'] == null){
            $templateProcessor->setValue('ca3a8c', "");
        }else{
            $templateProcessor->setValue('ca3a8c', $data['ca3a8c']);
            $model2->catatan_auditor = $data['ca3a8c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a9a";
        //3
        if($data['rb3a9a'] == 'm'){
            $templateProcessor->setValue('m3a9a', "&#8730;");
            $templateProcessor->setValue('tm3a9a', "");
            $templateProcessor->setValue('tr3a9a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a9a'] == 'tm'){
            $templateProcessor->setValue('m3a9a', "");
            $templateProcessor->setValue('tm3a9a', "&#8730;");
            $templateProcessor->setValue('tr3a9a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a9a'] == 'tr'){
            $templateProcessor->setValue('m3a9a', "");
            $templateProcessor->setValue('tm3a9a', "");
            $templateProcessor->setValue('tr3a9a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a9a'] == null){
            $templateProcessor->setValue('ca3a9a', "");
        }else{
            $templateProcessor->setValue('ca3a9a', $data['ca3a9a']);
            $model2->catatan_auditor = $data['ca3a9a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3a9b";
        //3
        if($data['rb3a9b'] == 'm'){
            $templateProcessor->setValue('m3a9b', "&#8730;");
            $templateProcessor->setValue('tm3a9b', "");
            $templateProcessor->setValue('tr3a9b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a9b'] == 'tm'){
            $templateProcessor->setValue('m3a9b', "");
            $templateProcessor->setValue('tm3a9b', "&#8730;");
            $templateProcessor->setValue('tr3a9b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a9b'] == 'tr'){
            $templateProcessor->setValue('m3a9b', "");
            $templateProcessor->setValue('tm3a9b', "");
            $templateProcessor->setValue('tr3a9b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a9b'] == null){
            $templateProcessor->setValue('ca3a9b', "");
        }else{
            $templateProcessor->setValue('ca3a9b', $data['ca3a9b']);
            $model2->catatan_auditor = $data['ca3a9b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a10a";
        //3
        if($data['rb3a10a'] == 'm'){
            $templateProcessor->setValue('m3a10a', "&#8730;");
            $templateProcessor->setValue('tm3a10a', "");
            $templateProcessor->setValue('tr3a10a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a10a'] == 'tm'){
            $templateProcessor->setValue('m3a10a', "");
            $templateProcessor->setValue('tm3a10a', "&#8730;");
            $templateProcessor->setValue('tr3a10a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a10a'] == 'tr'){
            $templateProcessor->setValue('m3a10a', "");
            $templateProcessor->setValue('tm3a10a', "");
            $templateProcessor->setValue('tr3a10a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a10a'] == null){
            $templateProcessor->setValue('ca3a10a', "");
        }else{
            $templateProcessor->setValue('ca3a10a', $data['ca3a10a']);
            $model2->catatan_auditor = $data['ca3a10a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a10b";
        //3
        if($data['rb3a10b'] == 'm'){
            $templateProcessor->setValue('m3a10b', "&#8730;");
            $templateProcessor->setValue('tm3a10b', "");
            $templateProcessor->setValue('tr3a10b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a10b'] == 'tm'){
            $templateProcessor->setValue('m3a10b', "");
            $templateProcessor->setValue('tm3a10b', "&#8730;");
            $templateProcessor->setValue('tr3a10b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a10b'] == 'tr'){
            $templateProcessor->setValue('m3a10b', "");
            $templateProcessor->setValue('tm3a10b', "");
            $templateProcessor->setValue('tr3a10b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a10b'] == null){
            $templateProcessor->setValue('ca3a10b', "");
        }else{
            $templateProcessor->setValue('ca3a10b', $data['ca3a10b']);
            $model2->catatan_auditor = $data['ca3a10b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a11a";
        //3
        if($data['rb3a11a'] == 'm'){
            $templateProcessor->setValue('m3a11a', "&#8730;");
            $templateProcessor->setValue('tm3a11a', "");
            $templateProcessor->setValue('tr3a11a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a11a'] == 'tm'){
            $templateProcessor->setValue('m3a11a', "");
            $templateProcessor->setValue('tm3a11a', "&#8730;");
            $templateProcessor->setValue('tr3a11a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a11a'] == 'tr'){
            $templateProcessor->setValue('m3a11a', "");
            $templateProcessor->setValue('tm3a11a', "");
            $templateProcessor->setValue('tr3a11a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a11a'] == null){
            $templateProcessor->setValue('ca3a11a', "");
        }else{
            $templateProcessor->setValue('ca3a11a', $data['ca3a11a']);
            $model2->catatan_auditor = $data['ca3a11a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3a11b";
        //3
        if($data['rb3a11b'] == 'm'){
            $templateProcessor->setValue('m3a11b', "&#8730;");
            $templateProcessor->setValue('tm3a11b', "");
            $templateProcessor->setValue('tr3a11b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a11b'] == 'tm'){
            $templateProcessor->setValue('m3a11b', "");
            $templateProcessor->setValue('tm3a11b', "&#8730;");
            $templateProcessor->setValue('tr3a11b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a11b'] == 'tr'){
            $templateProcessor->setValue('m3a11b', "");
            $templateProcessor->setValue('tm3a11b', "");
            $templateProcessor->setValue('tr3a11b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a11a'] == null){
            $templateProcessor->setValue('ca3a11b', "");
        }else{
            $templateProcessor->setValue('ca3a11b', $data['ca3a11b']);
            $model2->catatan_auditor = $data['ca3a11b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a12";
        //3
        if($data['rb3a12'] == 'm'){
            $templateProcessor->setValue('m3a12', "&#8730;");
            $templateProcessor->setValue('tm3a12', "");
            $templateProcessor->setValue('tr3a12', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a12'] == 'tm'){
            $templateProcessor->setValue('m3a12', "");
            $templateProcessor->setValue('tm3a12', "&#8730;");
            $templateProcessor->setValue('tr3a12', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a12'] == 'tr'){
            $templateProcessor->setValue('m3a12', "");
            $templateProcessor->setValue('tm3a12', "");
            $templateProcessor->setValue('tr3a12', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a12'] == null){
            $templateProcessor->setValue('ca3a12', "");
        }else{
            $templateProcessor->setValue('ca3a12', $data['ca3a12']);
            $model2->catatan_auditor = $data['ca3a12'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a13";
        //3
        if($data['rb3a13'] == 'm'){
            $templateProcessor->setValue('m3a13', "&#8730;");
            $templateProcessor->setValue('tm3a13', "");
            $templateProcessor->setValue('tr3a13', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a13'] == 'tm'){
            $templateProcessor->setValue('m3a13', "");
            $templateProcessor->setValue('tm3a13', "&#8730;");
            $templateProcessor->setValue('tr3a13', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a13'] == 'tr'){
            $templateProcessor->setValue('m3a13', "");
            $templateProcessor->setValue('tm3a13', "");
            $templateProcessor->setValue('tr3a13', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a13'] == null){
            $templateProcessor->setValue('ca3a13', "");
        }else{
            $templateProcessor->setValue('ca3a13', $data['ca3a13']);
            $model2->catatan_auditor = $data['ca3a13'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];          
        $model2->kriteria_sjph = "3a14";
        //3
        if($data['rb3a14'] == 'm'){
            $templateProcessor->setValue('m3a14', "&#8730;");
            $templateProcessor->setValue('tm3a14', "");
            $templateProcessor->setValue('tr3a14', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a14'] == 'tm'){
            $templateProcessor->setValue('m3a14', "");
            $templateProcessor->setValue('tm3a14', "&#8730;");
            $templateProcessor->setValue('tr3a14', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a14'] == 'tr'){
            $templateProcessor->setValue('m3a14', "");
            $templateProcessor->setValue('tm3a14', "");
            $templateProcessor->setValue('tr3a14', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a14'] == null){
            $templateProcessor->setValue('ca3a14', "");
        }else{
            $templateProcessor->setValue('ca3a14', $data['ca3a14']);
            $model2->catatan_auditor = $data['ca3a14'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a15";
        //3
        if($data['rb3a15'] == 'm'){
            $templateProcessor->setValue('m3a15', "&#8730;");
            $templateProcessor->setValue('tm3a15', "");
            $templateProcessor->setValue('tr3a15', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a15'] == 'tm'){
            $templateProcessor->setValue('m3a15', "");
            $templateProcessor->setValue('tm3a15', "&#8730;");
            $templateProcessor->setValue('tr3a15', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a15'] == 'tr'){
            $templateProcessor->setValue('m3a15', "");
            $templateProcessor->setValue('tm3a15', "");
            $templateProcessor->setValue('tr3a15', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a15'] == null){
            $templateProcessor->setValue('ca3a15', "");
        }else{
            $templateProcessor->setValue('ca3a15', $data['ca3a15']);
            $model2->catatan_auditor = $data['ca3a15'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a16";
        //3
        if($data['rb3a16'] == 'm'){
            $templateProcessor->setValue('m3a16', "&#8730;");
            $templateProcessor->setValue('tm3a16', "");
            $templateProcessor->setValue('tr3a16', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a16'] == 'tm'){
            $templateProcessor->setValue('m3a16', "");
            $templateProcessor->setValue('tm3a16', "&#8730;");
            $templateProcessor->setValue('tr3a16', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a16'] == 'tr'){
            $templateProcessor->setValue('m3a16', "");
            $templateProcessor->setValue('tm3a16', "");
            $templateProcessor->setValue('tr3a16', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a16'] == null){
            $templateProcessor->setValue('ca3a16', "");
        }else{
            $templateProcessor->setValue('ca3a16', $data['ca3a16']);
            $model2->catatan_auditor = $data['ca3a16'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a17";
        //3
        if($data['rb3a17'] == 'm'){
            $templateProcessor->setValue('m3a17', "&#8730;");
            $templateProcessor->setValue('tm3a17', "");
            $templateProcessor->setValue('tr3a17', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a17'] == 'tm'){
            $templateProcessor->setValue('m3a17', "");
            $templateProcessor->setValue('tm3a17', "&#8730;");
            $templateProcessor->setValue('tr3a17', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a17'] == 'tr'){
            $templateProcessor->setValue('m3a17', "");
            $templateProcessor->setValue('tm3a17', "");
            $templateProcessor->setValue('tr3a17', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a17'] == null){
            $templateProcessor->setValue('ca3a17', "");
        }else{
            $templateProcessor->setValue('ca3a17', $data['ca3a17']);
            $model2->catatan_auditor = $data['ca3a17'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a18";
        //3
        if($data['rb3a18'] == 'm'){
            $templateProcessor->setValue('m3a18', "&#8730;");
            $templateProcessor->setValue('tm3a18', "");
            $templateProcessor->setValue('tr3a18', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a18'] == 'tm'){
            $templateProcessor->setValue('m3a18', "");
            $templateProcessor->setValue('tm3a18', "&#8730;");
            $templateProcessor->setValue('tr3a18', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a18'] == 'tr'){
            $templateProcessor->setValue('m3a18', "");
            $templateProcessor->setValue('tm3a18', "");
            $templateProcessor->setValue('tr3a18', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a18'] == null){
            $templateProcessor->setValue('ca3a18', "");
        }else{
            $templateProcessor->setValue('ca3a18', $data['ca3a18']);
            $model2->catatan_auditor = $data['ca3a18'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a19";
        //3
        if($data['rb3a19'] == 'm'){
            $templateProcessor->setValue('m3a19', "&#8730;");
            $templateProcessor->setValue('tm3a19', "");
            $templateProcessor->setValue('tr3a19', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a19'] == 'tm'){
            $templateProcessor->setValue('m3a19', "");
            $templateProcessor->setValue('tm3a19', "&#8730;");
            $templateProcessor->setValue('tr3a19', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a19'] == 'tr'){
            $templateProcessor->setValue('m3a19', "");
            $templateProcessor->setValue('tm3a19', "");
            $templateProcessor->setValue('tr3a19', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a19'] == null){
            $templateProcessor->setValue('ca3a19', "");
        }else{
            $templateProcessor->setValue('ca3a19', $data['ca3a19']);
            $model2->catatan_auditor = $data['ca3a19'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a20";
        //3
        if($data['rb3a20'] == 'm'){
            $templateProcessor->setValue('m3a20', "&#8730;");
            $templateProcessor->setValue('tm3a20', "");
            $templateProcessor->setValue('tr3a20', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a20'] == 'tm'){
            $templateProcessor->setValue('m3a20', "");
            $templateProcessor->setValue('tm3a20', "&#8730;");
            $templateProcessor->setValue('tr3a20', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a20'] == 'tr'){
            $templateProcessor->setValue('m3a20', "");
            $templateProcessor->setValue('tm3a20', "");
            $templateProcessor->setValue('tr3a20', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a20'] == null){
            $templateProcessor->setValue('ca3a20', "");
        }else{
            $templateProcessor->setValue('ca3a20', $data['ca3a20']);
            $model2->catatan_auditor = $data['ca3a20'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a21";
        //3
        if($data['rb3a21'] == 'm'){
            $templateProcessor->setValue('m3a21', "&#8730;");
            $templateProcessor->setValue('tm3a21', "");
            $templateProcessor->setValue('tr3a21', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a21'] == 'tm'){
            $templateProcessor->setValue('m3a21', "");
            $templateProcessor->setValue('tm3a21', "&#8730;");
            $templateProcessor->setValue('tr3a21', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a21'] == 'tr'){
            $templateProcessor->setValue('m3a21', "");
            $templateProcessor->setValue('tm3a21', "");
            $templateProcessor->setValue('tr3a21', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a21'] == null){
            $templateProcessor->setValue('ca3a21', "");
        }else{
            $templateProcessor->setValue('ca3a21', $data['ca3a21']);
            $model2->catatan_auditor = $data['ca3a21'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a22";
        //3
        if($data['rb3a22'] == 'm'){
            $templateProcessor->setValue('m3a22', "&#8730;");
            $templateProcessor->setValue('tm3a22', "");
            $templateProcessor->setValue('tr3a22', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a22'] == 'tm'){
            $templateProcessor->setValue('m3a22', "");
            $templateProcessor->setValue('tm3a22', "&#8730;");
            $templateProcessor->setValue('tr3a22', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a22'] == 'tr'){
            $templateProcessor->setValue('m3a22', "");
            $templateProcessor->setValue('tm3a22', "");
            $templateProcessor->setValue('tr3a22', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a22'] == null){
            $templateProcessor->setValue('ca3a22', "");
        }else{
            $templateProcessor->setValue('ca3a22', $data['ca3a22']);
            $model2->catatan_auditor = $data['ca3a22'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a23";
        //3
        if($data['rb3a23'] == 'm'){
            $templateProcessor->setValue('m3a23', "&#8730;");
            $templateProcessor->setValue('tm3a23', "");
            $templateProcessor->setValue('tr3a23', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a23'] == 'tm'){
            $templateProcessor->setValue('m3a23', "");
            $templateProcessor->setValue('tm3a23', "&#8730;");
            $templateProcessor->setValue('tr3a23', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a23'] == 'tr'){
            $templateProcessor->setValue('m3a23', "");
            $templateProcessor->setValue('tm3a23', "");
            $templateProcessor->setValue('tr3a23', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a23'] == null){
            $templateProcessor->setValue('ca3a23', "");
        }else{
            $templateProcessor->setValue('ca3a23', $data['ca3a23']);
            $model2->catatan_auditor = $data['ca3a23'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a24";
        //3
        if($data['rb3a24'] == 'm'){
            $templateProcessor->setValue('m3a24', "&#8730;");
            $templateProcessor->setValue('tm3a24', "");
            $templateProcessor->setValue('tr3a24', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a24'] == 'tm'){
            $templateProcessor->setValue('m3a24', "");
            $templateProcessor->setValue('tm3a24', "&#8730;");
            $templateProcessor->setValue('tr3a24', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a24'] == 'tr'){
            $templateProcessor->setValue('m3a24', "");
            $templateProcessor->setValue('tm3a24', "");
            $templateProcessor->setValue('tr3a24', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a24'] == null){
            $templateProcessor->setValue('ca3a24', "");
        }else{
            $templateProcessor->setValue('ca3a24', $data['ca3a24']);
            $model2->catatan_auditor = $data['ca3a24'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a25";
        //3
        if($data['rb3a25'] == 'm'){
            $templateProcessor->setValue('m3a25', "&#8730;");
            $templateProcessor->setValue('tm3a25', "");
            $templateProcessor->setValue('tr3a25', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a25'] == 'tm'){
            $templateProcessor->setValue('m3a25', "");
            $templateProcessor->setValue('tm3a25', "&#8730;");
            $templateProcessor->setValue('tr3a25', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a25'] == 'tr'){
            $templateProcessor->setValue('m3a25', "");
            $templateProcessor->setValue('tm3a25', "");
            $templateProcessor->setValue('tr3a25', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a25'] == null){
            $templateProcessor->setValue('ca3a25', "");
        }else{
            $templateProcessor->setValue('ca3a25', $data['ca3a25']);
            $model2->catatan_auditor = $data['ca3a25'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a26";
        //3
        if($data['rb3a26'] == 'm'){
            $templateProcessor->setValue('m3a26', "&#8730;");
            $templateProcessor->setValue('tm3a26', "");
            $templateProcessor->setValue('tr3a26', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a26'] == 'tm'){
            $templateProcessor->setValue('m3a26', "");
            $templateProcessor->setValue('tm3a26', "&#8730;");
            $templateProcessor->setValue('tr3a26', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a26'] == 'tr'){
            $templateProcessor->setValue('m3a26', "");
            $templateProcessor->setValue('tm3a26', "");
            $templateProcessor->setValue('tr3a26', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a26'] == null){
            $templateProcessor->setValue('ca3a26', "");
        }else{
            $templateProcessor->setValue('ca3a26', $data['ca3a26']);
            $model2->catatan_auditor = $data['ca3a26'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a27";
        //3
        if($data['rb3a27'] == 'm'){
            $templateProcessor->setValue('m3a27', "&#8730;");
            $templateProcessor->setValue('tm3a27', "");
            $templateProcessor->setValue('tr3a27', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a27'] == 'tm'){
            $templateProcessor->setValue('m3a27', "");
            $templateProcessor->setValue('tm3a27', "&#8730;");
            $templateProcessor->setValue('tr3a27', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a27'] == 'tr'){
            $templateProcessor->setValue('m3a27', "");
            $templateProcessor->setValue('tm3a27', "");
            $templateProcessor->setValue('tr3a27', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a27'] == null){
            $templateProcessor->setValue('ca3a27', "");
        }else{
            $templateProcessor->setValue('ca3a27', $data['ca3a27']);
            $model2->catatan_auditor = $data['ca3a27'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a28";
        //3
        if($data['rb3a28'] == 'm'){
            $templateProcessor->setValue('m3a28', "&#8730;");
            $templateProcessor->setValue('tm3a28', "");
            $templateProcessor->setValue('tr3a28', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a28'] == 'tm'){
            $templateProcessor->setValue('m3a28', "");
            $templateProcessor->setValue('tm3a28', "&#8730;");
            $templateProcessor->setValue('tr3a28', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a28'] == 'tr'){
            $templateProcessor->setValue('m3a28', "");
            $templateProcessor->setValue('tm3a28', "");
            $templateProcessor->setValue('tr3a28', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a28'] == null){
            $templateProcessor->setValue('ca3a28', "");
        }else{
            $templateProcessor->setValue('ca3a28', $data['ca3a28']);
            $model2->catatan_auditor = $data['ca3a28'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a29";
        //3
        if($data['rb3a29'] == 'm'){
            $templateProcessor->setValue('m3a29', "&#8730;");
            $templateProcessor->setValue('tm3a29', "");
            $templateProcessor->setValue('tr3a29', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a29'] == 'tm'){
            $templateProcessor->setValue('m3a29', "");
            $templateProcessor->setValue('tm3a29', "&#8730;");
            $templateProcessor->setValue('tr3a29', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a29'] == 'tr'){
            $templateProcessor->setValue('m3a29', "");
            $templateProcessor->setValue('tm3a29', "");
            $templateProcessor->setValue('tr3a29', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a29'] == null){
            $templateProcessor->setValue('ca3a29', "");
        }else{
            $templateProcessor->setValue('ca3a29', $data['ca3a29']);
            $model2->catatan_auditor = $data['ca3a29'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a30";
        //3
        if($data['rb3a30'] == 'm'){
            $templateProcessor->setValue('m3a30', "&#8730;");
            $templateProcessor->setValue('tm3a30', "");
            $templateProcessor->setValue('tr3a30', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a30'] == 'tm'){
            $templateProcessor->setValue('m3a30', "");
            $templateProcessor->setValue('tm3a30', "&#8730;");
            $templateProcessor->setValue('tr3a30', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a30'] == 'tr'){
            $templateProcessor->setValue('m3a30', "");
            $templateProcessor->setValue('tm3a30', "");
            $templateProcessor->setValue('tr3a30', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a30'] == null){
            $templateProcessor->setValue('ca3a30', "");
        }else{
            $templateProcessor->setValue('ca3a30', $data['ca3a30']);
            $model2->catatan_auditor = $data['ca3a30'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a31";
        //3
        if($data['rb3a31'] == 'm'){
            $templateProcessor->setValue('m3a31', "&#8730;");
            $templateProcessor->setValue('tm3a31', "");
            $templateProcessor->setValue('tr3a31', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a31'] == 'tm'){
            $templateProcessor->setValue('m3a31', "");
            $templateProcessor->setValue('tm3a31', "&#8730;");
            $templateProcessor->setValue('tr3a31', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a31'] == 'tr'){
            $templateProcessor->setValue('m3a31', "");
            $templateProcessor->setValue('tm3a31', "");
            $templateProcessor->setValue('tr3a31', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a31'] == null){
            $templateProcessor->setValue('ca3a31', "");
        }else{
            $templateProcessor->setValue('ca3a31', $data['ca3a31']);
            $model2->catatan_auditor = $data['ca3a31'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a32";
        //3
        if($data['rb3a32'] == 'm'){
            $templateProcessor->setValue('m3a32', "&#8730;");
            $templateProcessor->setValue('tm3a32', "");
            $templateProcessor->setValue('tr3a32', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a32'] == 'tm'){
            $templateProcessor->setValue('m3a32', "");
            $templateProcessor->setValue('tm3a32', "&#8730;");
            $templateProcessor->setValue('tr3a32', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a32'] == 'tr'){
            $templateProcessor->setValue('m3a32', "");
            $templateProcessor->setValue('tm3a32', "");
            $templateProcessor->setValue('tr3a32', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a32'] == null){
            $templateProcessor->setValue('ca3a32', "");
        }else{
            $templateProcessor->setValue('ca3a32', $data['ca3a32']);
            $model2->catatan_auditor = $data['ca3a32'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a33";
        //3
        if($data['rb3a33'] == 'm'){
            $templateProcessor->setValue('m3a33', "&#8730;");
            $templateProcessor->setValue('tm3a33', "");
            $templateProcessor->setValue('tr3a33', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a33'] == 'tm'){
            $templateProcessor->setValue('m3a33', "");
            $templateProcessor->setValue('tm3a33', "&#8730;");
            $templateProcessor->setValue('tr3a33', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a33'] == 'tr'){
            $templateProcessor->setValue('m3a33', "");
            $templateProcessor->setValue('tm3a33', "");
            $templateProcessor->setValue('tr3a33', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a33'] == null){
            $templateProcessor->setValue('ca3a33', "");
        }else{
            $templateProcessor->setValue('ca3a33', $data['ca3a33']);
            $model2->catatan_auditor = $data['ca3a33'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];           
        $model2->kriteria_sjph = "3a34";
        //3
        if($data['rb3a34'] == 'm'){
            $templateProcessor->setValue('m3a34', "&#8730;");
            $templateProcessor->setValue('tm3a34', "");
            $templateProcessor->setValue('tr3a34', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a34'] == 'tm'){
            $templateProcessor->setValue('m3a34', "");
            $templateProcessor->setValue('tm3a34', "&#8730;");
            $templateProcessor->setValue('tr3a34', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a34'] == 'tr'){
            $templateProcessor->setValue('m3a34', "");
            $templateProcessor->setValue('tm3a34', "");
            $templateProcessor->setValue('tr3a34', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a34'] == null){
            $templateProcessor->setValue('ca3a34', "");
        }else{
            $templateProcessor->setValue('ca3a34', $data['ca3a34']);
            $model2->catatan_auditor = $data['ca3a34'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3b1";
        //3
        if($data['rb3b1'] == 'm'){
            $templateProcessor->setValue('m3b1', "&#8730;");
            $templateProcessor->setValue('tm3b1', "");
            $templateProcessor->setValue('tr3b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b1'] == 'tm'){
            $templateProcessor->setValue('m3b1', "");
            $templateProcessor->setValue('tm3b1', "&#8730;");
            $templateProcessor->setValue('tr3b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b1'] == 'tr'){
            $templateProcessor->setValue('m3b1', "");
            $templateProcessor->setValue('tm3b1', "");
            $templateProcessor->setValue('tr3b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b1'] == null){
            $templateProcessor->setValue('ca3b1', "");
        }else{
            $templateProcessor->setValue('ca3b1', $data['ca3b1']);
            $model2->catatan_auditor = $data['ca3b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3b2";
        //3
        if($data['rb3b2'] == 'm'){
            $templateProcessor->setValue('m3b2', "&#8730;");
            $templateProcessor->setValue('tm3b2', "");
            $templateProcessor->setValue('tr3b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b2'] == 'tm'){
            $templateProcessor->setValue('m3b2', "");
            $templateProcessor->setValue('tm3b2', "&#8730;");
            $templateProcessor->setValue('tr3b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b2'] == 'tr'){
            $templateProcessor->setValue('m3b2', "");
            $templateProcessor->setValue('tm3b2', "");
            $templateProcessor->setValue('tr3b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b2'] == null){
            $templateProcessor->setValue('ca3b2', "");
        }else{
            $templateProcessor->setValue('ca3b2', $data['ca3b2']);
            $model2->catatan_auditor = $data['ca3b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3b3";
        //3
        if($data['rb3b3'] == 'm'){
            $templateProcessor->setValue('m3b3', "&#8730;");
            $templateProcessor->setValue('tm3b3', "");
            $templateProcessor->setValue('tr3b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b3'] == 'tm'){
            $templateProcessor->setValue('m3b3', "");
            $templateProcessor->setValue('tm3b3', "&#8730;");
            $templateProcessor->setValue('tr3b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b3'] == 'tr'){
            $templateProcessor->setValue('m3b3', "");
            $templateProcessor->setValue('tm3b3', "");
            $templateProcessor->setValue('tr3b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b3'] == null){
            $templateProcessor->setValue('ca3b3', "");
        }else{
            $templateProcessor->setValue('ca3b3', $data['ca3b3']);
            $model2->catatan_auditor = $data['ca3b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b4";
        //3
        if($data['rb3b4'] == 'm'){
            $templateProcessor->setValue('m3b4', "&#8730;");
            $templateProcessor->setValue('tm3b4', "");
            $templateProcessor->setValue('tr3b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b4'] == 'tm'){
            $templateProcessor->setValue('m3b4', "");
            $templateProcessor->setValue('tm3b4', "&#8730;");
            $templateProcessor->setValue('tr3b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b4'] == 'tr'){
            $templateProcessor->setValue('m3b4', "");
            $templateProcessor->setValue('tm3b4', "");
            $templateProcessor->setValue('tr3b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b4'] == null){
            $templateProcessor->setValue('ca3b4', "");
        }else{
            $templateProcessor->setValue('ca3b4', $data['ca3b4']);
            $model2->catatan_auditor = $data['ca3b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b5";
        //3
        if($data['rb3b5'] == 'm'){
            $templateProcessor->setValue('m3b5', "&#8730;");
            $templateProcessor->setValue('tm3b5', "");
            $templateProcessor->setValue('tr3b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b5'] == 'tm'){
            $templateProcessor->setValue('m3b5', "");
            $templateProcessor->setValue('tm3b5', "&#8730;");
            $templateProcessor->setValue('tr3b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b5'] == 'tr'){
            $templateProcessor->setValue('m3b5', "");
            $templateProcessor->setValue('tm3b5', "");
            $templateProcessor->setValue('tr3b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b5'] == null){
            $templateProcessor->setValue('ca3b5', "");
        }else{
            $templateProcessor->setValue('ca3b5', $data['ca3b5']);
            $model2->catatan_auditor = $data['ca3b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b6";
        //3
        if($data['rb3b6'] == 'm'){
            $templateProcessor->setValue('m3b6', "&#8730;");
            $templateProcessor->setValue('tm3b6', "");
            $templateProcessor->setValue('tr3b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b6'] == 'tm'){
            $templateProcessor->setValue('m3b6', "");
            $templateProcessor->setValue('tm3b6', "&#8730;");
            $templateProcessor->setValue('tr3b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b6'] == 'tr'){
            $templateProcessor->setValue('m3b6', "");
            $templateProcessor->setValue('tm3b6', "");
            $templateProcessor->setValue('tr3b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b6'] == null){
            $templateProcessor->setValue('ca3b6', "");
        }else{
            $templateProcessor->setValue('ca3b6', $data['ca3b6']);
            $model2->catatan_auditor = $data['ca3b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b7";
        //3
        if($data['rb3b7'] == 'm'){
            $templateProcessor->setValue('m3b7', "&#8730;");
            $templateProcessor->setValue('tm3b7', "");
            $templateProcessor->setValue('tr3b7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b7'] == 'tm'){
            $templateProcessor->setValue('m3b7', "");
            $templateProcessor->setValue('tm3b7', "&#8730;");
            $templateProcessor->setValue('tr3b7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b7'] == 'tr'){
            $templateProcessor->setValue('m3b7', "");
            $templateProcessor->setValue('tm3b7', "");
            $templateProcessor->setValue('tr3b7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b7'] == null){
            $templateProcessor->setValue('ca3b7', "");
        }else{
            $templateProcessor->setValue('ca3b7', $data['ca3b7']);
            $model2->catatan_auditor = $data['ca3b7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3b8";
        //3
        if($data['rb3b8'] == 'm'){
            $templateProcessor->setValue('m3b8', "&#8730;");
            $templateProcessor->setValue('tm3b8', "");
            $templateProcessor->setValue('tr3b8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b8'] == 'tm'){
            $templateProcessor->setValue('m3b8', "");
            $templateProcessor->setValue('tm3b8', "&#8730;");
            $templateProcessor->setValue('tr3b8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b8'] == 'tr'){
            $templateProcessor->setValue('m3b8', "");
            $templateProcessor->setValue('tm3b8', "");
            $templateProcessor->setValue('tr3b8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b8'] == null){
            $templateProcessor->setValue('ca3b8', "");
        }else{
            $templateProcessor->setValue('ca3b8', $data['ca3b8']);
            $model2->catatan_auditor = $data['ca3b8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b9";
        //3
        if($data['rb3b9'] == 'm'){
            $templateProcessor->setValue('m3b9', "&#8730;");
            $templateProcessor->setValue('tm3b9', "");
            $templateProcessor->setValue('tr3b9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b9'] == 'tm'){
            $templateProcessor->setValue('m3b9', "");
            $templateProcessor->setValue('tm3b9', "&#8730;");
            $templateProcessor->setValue('tr3b9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b9'] == 'tr'){
            $templateProcessor->setValue('m3b9', "");
            $templateProcessor->setValue('tm3b9', "");
            $templateProcessor->setValue('tr3b9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b9'] == null){
            $templateProcessor->setValue('ca3b9', "");
        }else{
            $templateProcessor->setValue('ca3b9', $data['ca3b9']);
            $model2->catatan_auditor = $data['ca3b9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b10";
        //3
        if($data['rb3b10'] == 'm'){
            $templateProcessor->setValue('m3b10', "&#8730;");
            $templateProcessor->setValue('tm3b10', "");
            $templateProcessor->setValue('tr3b10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b10'] == 'tm'){
            $templateProcessor->setValue('m3b10', "");
            $templateProcessor->setValue('tm3b10', "&#8730;");
            $templateProcessor->setValue('tr3b10', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b10'] == 'tr'){
            $templateProcessor->setValue('m3b10', "");
            $templateProcessor->setValue('tm3b10', "");
            $templateProcessor->setValue('tr3b10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b10'] == null){
            $templateProcessor->setValue('ca3b10', "");
        }else{
            $templateProcessor->setValue('ca3b10', $data['ca3b10']);
            $model2->catatan_auditor = $data['ca3b10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b11";
        //3
        if($data['rb3b11'] == 'm'){
            $templateProcessor->setValue('m3b11', "&#8730;");
            $templateProcessor->setValue('tm3b11', "");
            $templateProcessor->setValue('tr3b11', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b11'] == 'tm'){
            $templateProcessor->setValue('m3b11', "");
            $templateProcessor->setValue('tm3b11', "&#8730;");
            $templateProcessor->setValue('tr3b11', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b11'] == 'tr'){
            $templateProcessor->setValue('m3b11', "");
            $templateProcessor->setValue('tm3b11', "");
            $templateProcessor->setValue('tr3b11', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b11'] == null){
            $templateProcessor->setValue('ca3b11', "");
        }else{
            $templateProcessor->setValue('ca3b11', $data['ca3b11']);
            $model2->catatan_auditor = $data['ca3b11'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b12";
        //3
        if($data['rb3b12'] == 'm'){
            $templateProcessor->setValue('m3b12', "&#8730;");
            $templateProcessor->setValue('tm3b12', "");
            $templateProcessor->setValue('tr3b12', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b12'] == 'tm'){
            $templateProcessor->setValue('m3b12', "");
            $templateProcessor->setValue('tm3b12', "&#8730;");
            $templateProcessor->setValue('tr3b12', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b12'] == 'tr'){
            $templateProcessor->setValue('m3b12', "");
            $templateProcessor->setValue('tm3b12', "");
            $templateProcessor->setValue('tr3b12', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b12'] == null){
            $templateProcessor->setValue('ca3b12', "");
        }else{
            $templateProcessor->setValue('ca3b12', $data['ca3b12']);
            $model2->catatan_auditor = $data['ca3b12'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b13";
        //3
        if($data['rb3b13'] == 'm'){
            $templateProcessor->setValue('m3b13', "&#8730;");
            $templateProcessor->setValue('tm3b13', "");
            $templateProcessor->setValue('tr3b13', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b13'] == 'tm'){
            $templateProcessor->setValue('m3b13', "");
            $templateProcessor->setValue('tm3b13', "&#8730;");
            $templateProcessor->setValue('tr3b13', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b13'] == 'tr'){
            $templateProcessor->setValue('m3b13', "");
            $templateProcessor->setValue('tm3b13', "");
            $templateProcessor->setValue('tr3b13', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b13'] == null){
            $templateProcessor->setValue('ca3b13', "");
        }else{
            $templateProcessor->setValue('ca3b13', $data['ca3b13']);
            $model2->catatan_auditor = $data['ca3b13'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];    
        $model2->kriteria_sjph = "3b14";
        //3
        if($data['rb3b14'] == 'm'){
            $templateProcessor->setValue('m3b14', "&#8730;");
            $templateProcessor->setValue('tm3b14', "");
            $templateProcessor->setValue('tr3b14', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b14'] == 'tm'){
            $templateProcessor->setValue('m3b14', "");
            $templateProcessor->setValue('tm3b14', "&#8730;");
            $templateProcessor->setValue('tr3b14', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b14'] == 'tr'){
            $templateProcessor->setValue('m3b14', "");
            $templateProcessor->setValue('tm3b14', "");
            $templateProcessor->setValue('tr3b14', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b14'] == null){
            $templateProcessor->setValue('ca3b14', "");
        }else{
            $templateProcessor->setValue('ca3b14', $data['ca3b14']);
            $model2->catatan_auditor = $data['ca3b14'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b15";
        //3
        if($data['rb3b15'] == 'm'){
            $templateProcessor->setValue('m3b15', "&#8730;");
            $templateProcessor->setValue('tm3b15', "");
            $templateProcessor->setValue('tr3b15', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b15'] == 'tm'){
            $templateProcessor->setValue('m3b15', "");
            $templateProcessor->setValue('tm3b15', "&#8730;");
            $templateProcessor->setValue('tr3b15', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b15'] == 'tr'){
            $templateProcessor->setValue('m3b15', "");
            $templateProcessor->setValue('tm3b15', "");
            $templateProcessor->setValue('tr3b15', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b15'] == null){
            $templateProcessor->setValue('ca3b15', "");
        }else{
            $templateProcessor->setValue('ca3b15', $data['ca3b15']);
            $model2->catatan_auditor = $data['ca3b15'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b16";
        //3
        if($data['rb3b16'] == 'm'){
            $templateProcessor->setValue('m3b16', "&#8730;");
            $templateProcessor->setValue('tm3b16', "");
            $templateProcessor->setValue('tr3b16', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b16'] == 'tm'){
            $templateProcessor->setValue('m3b16', "");
            $templateProcessor->setValue('tm3b16', "&#8730;");
            $templateProcessor->setValue('tr3b16', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b16'] == 'tr'){
            $templateProcessor->setValue('m3b16', "");
            $templateProcessor->setValue('tm3b16', "");
            $templateProcessor->setValue('tr3b16', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b16'] == null){
            $templateProcessor->setValue('ca3b16', "");
        }else{
            $templateProcessor->setValue('ca3b16', $data['ca3b16']);
            $model2->catatan_auditor = $data['ca3b16'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b17";
        //3
        if($data['rb3b17'] == 'm'){
            $templateProcessor->setValue('m3b17', "&#8730;");
            $templateProcessor->setValue('tm3b17', "");
            $templateProcessor->setValue('tr3b17', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b17'] == 'tm'){
            $templateProcessor->setValue('m3b17', "");
            $templateProcessor->setValue('tm3b17', "&#8730;");
            $templateProcessor->setValue('tr3b17', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b17'] == 'tr'){
            $templateProcessor->setValue('m3b17', "");
            $templateProcessor->setValue('tm3b17', "");
            $templateProcessor->setValue('tr3b17', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b17'] == null){
            $templateProcessor->setValue('ca3b17', "");
        }else{
            $templateProcessor->setValue('ca3b17', $data['ca3b17']);
            $model2->catatan_auditor = $data['ca3b17'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];     
        $model2->kriteria_sjph = "3b18";
        //3
        if($data['rb3b18'] == 'm'){
            $templateProcessor->setValue('m3b18', "&#8730;");
            $templateProcessor->setValue('tm3b18', "");
            $templateProcessor->setValue('tr3b18', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b18'] == 'tm'){
            $templateProcessor->setValue('m3b18', "");
            $templateProcessor->setValue('tm3b18', "&#8730;");
            $templateProcessor->setValue('tr3b18', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b18'] == 'tr'){
            $templateProcessor->setValue('m3b18', "");
            $templateProcessor->setValue('tm3b18', "");
            $templateProcessor->setValue('tr3b18', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b18'] == null){
            $templateProcessor->setValue('ca3b18', "");
        }else{
            $templateProcessor->setValue('ca3b18', $data['ca3b18']);
            $model2->catatan_auditor = $data['ca3b18'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b19";
        //3
        if($data['rb3b19'] == 'm'){
            $templateProcessor->setValue('m3b19', "&#8730;");
            $templateProcessor->setValue('tm3b19', "");
            $templateProcessor->setValue('tr3b19', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b19'] == 'tm'){
            $templateProcessor->setValue('m3b19', "");
            $templateProcessor->setValue('tm3b19', "&#8730;");
            $templateProcessor->setValue('tr3b19', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b19'] == 'tr'){
            $templateProcessor->setValue('m3b19', "");
            $templateProcessor->setValue('tm3b19', "");
            $templateProcessor->setValue('tr3b19', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b19'] == null){
            $templateProcessor->setValue('ca3b19', "");
        }else{
            $templateProcessor->setValue('ca3b19', $data['ca3b19']);
            $model2->catatan_auditor = $data['ca3b19'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b20";
        //3
        if($data['rb3b20'] == 'm'){
            $templateProcessor->setValue('m3b20', "&#8730;");
            $templateProcessor->setValue('tm3b20', "");
            $templateProcessor->setValue('tr3b20', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b20'] == 'tm'){
            $templateProcessor->setValue('m3b20', "");
            $templateProcessor->setValue('tm3b20', "&#8730;");
            $templateProcessor->setValue('tr3b20', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b20'] == 'tr'){
            $templateProcessor->setValue('m3b20', "");
            $templateProcessor->setValue('tm3b20', "");
            $templateProcessor->setValue('tr3b20', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b20'] == null){
            $templateProcessor->setValue('ca3b20', "");
        }else{
            $templateProcessor->setValue('ca3b20', $data['ca3b20']);
            $model2->catatan_auditor = $data['ca3b20'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b21";
        //3
        if($data['rb3b21'] == 'm'){
            $templateProcessor->setValue('m3b21', "&#8730;");
            $templateProcessor->setValue('tm3b21', "");
            $templateProcessor->setValue('tr3b21', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b21'] == 'tm'){
            $templateProcessor->setValue('m3b21', "");
            $templateProcessor->setValue('tm3b21', "&#8730;");
            $templateProcessor->setValue('tr3b21', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b21'] == 'tr'){
            $templateProcessor->setValue('m3b21', "");
            $templateProcessor->setValue('tm3b21', "");
            $templateProcessor->setValue('tr3b21', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b21'] == null){
            $templateProcessor->setValue('ca3b21', "");
        }else{
            $templateProcessor->setValue('ca3b21', $data['ca3b21']);
            $model2->catatan_auditor = $data['ca3b21'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b22";
        //3
        if($data['rb3b22'] == 'm'){
            $templateProcessor->setValue('m3b22', "&#8730;");
            $templateProcessor->setValue('tm3b22', "");
            $templateProcessor->setValue('tr3b22', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b22'] == 'tm'){
            $templateProcessor->setValue('m3b22', "");
            $templateProcessor->setValue('tm3b22', "&#8730;");
            $templateProcessor->setValue('tr3b22', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b22'] == 'tr'){
            $templateProcessor->setValue('m3b22', "");
            $templateProcessor->setValue('tm3b22', "");
            $templateProcessor->setValue('tr3b22', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b22'] == null){
            $templateProcessor->setValue('ca3b22', "");
        }else{
            $templateProcessor->setValue('ca3b22', $data['ca3b22']);
            $model2->catatan_auditor = $data['ca3b22'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b23";
        //3
        if($data['rb3b23'] == 'm'){
            $templateProcessor->setValue('m3b23', "&#8730;");
            $templateProcessor->setValue('tm3b23', "");
            $templateProcessor->setValue('tr3b23', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b23'] == 'tm'){
            $templateProcessor->setValue('m3b23', "");
            $templateProcessor->setValue('tm3b23', "&#8730;");
            $templateProcessor->setValue('tr3b23', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b23'] == 'tr'){
            $templateProcessor->setValue('m3b23', "");
            $templateProcessor->setValue('tm3b23', "");
            $templateProcessor->setValue('tr3b23', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b23'] == null){
            $templateProcessor->setValue('ca3b23', "");
        }else{
            $templateProcessor->setValue('ca3b23', $data['ca3b23']);
            $model2->catatan_auditor = $data['ca3b23'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b24";
        //3
        if($data['rb3b24'] == 'm'){
            $templateProcessor->setValue('m3b24', "&#8730;");
            $templateProcessor->setValue('tm3b24', "");
            $templateProcessor->setValue('tr3b24', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b24'] == 'tm'){
            $templateProcessor->setValue('m3b24', "");
            $templateProcessor->setValue('tm3b24', "&#8730;");
            $templateProcessor->setValue('tr3b24', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b24'] == 'tr'){
            $templateProcessor->setValue('m3b24', "");
            $templateProcessor->setValue('tm3b24', "");
            $templateProcessor->setValue('tr3b24', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b24'] == null){
            $templateProcessor->setValue('ca3b24', "");
        }else{
            $templateProcessor->setValue('ca3b24', $data['ca3b24']);
            $model2->catatan_auditor = $data['ca3b24'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b25";
        //3
        if($data['rb3b25'] == 'm'){
            $templateProcessor->setValue('m3b25', "&#8730;");
            $templateProcessor->setValue('tm3b25', "");
            $templateProcessor->setValue('tr3b25', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b25'] == 'tm'){
            $templateProcessor->setValue('m3b25', "");
            $templateProcessor->setValue('tm3b25', "&#8730;");
            $templateProcessor->setValue('tr3b25', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b25'] == 'tr'){
            $templateProcessor->setValue('m3b25', "");
            $templateProcessor->setValue('tm3b25', "");
            $templateProcessor->setValue('tr3b25', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b25'] == null){
            $templateProcessor->setValue('ca3b25', "");
        }else{
            $templateProcessor->setValue('ca3b25', $data['ca3b25']);
            $model2->catatan_auditor = $data['ca3b25'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b26";
        //3
        if($data['rb3b26'] == 'm'){
            $templateProcessor->setValue('m3b26', "&#8730;");
            $templateProcessor->setValue('tm3b26', "");
            $templateProcessor->setValue('tr3b26', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b26'] == 'tm'){
            $templateProcessor->setValue('m3b26', "");
            $templateProcessor->setValue('tm3b26', "&#8730;");
            $templateProcessor->setValue('tr3b26', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b26'] == 'tr'){
            $templateProcessor->setValue('m3b26', "");
            $templateProcessor->setValue('tm3b26', "");
            $templateProcessor->setValue('tr3b26', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b26'] == null){
            $templateProcessor->setValue('ca3b26', "");
        }else{
            $templateProcessor->setValue('ca3b26', $data['ca3b26']);
            $model2->catatan_auditor = $data['ca3b26'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b27";
        //3
        if($data['rb3b27'] == 'm'){
            $templateProcessor->setValue('m3b27', "&#8730;");
            $templateProcessor->setValue('tm3b27', "");
            $templateProcessor->setValue('tr3b27', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b27'] == 'tm'){
            $templateProcessor->setValue('m3b27', "");
            $templateProcessor->setValue('tm3b27', "&#8730;");
            $templateProcessor->setValue('tr3b27', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b27'] == 'tr'){
            $templateProcessor->setValue('m3b27', "");
            $templateProcessor->setValue('tm3b27', "");
            $templateProcessor->setValue('tr3b27', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b27'] == null){
            $templateProcessor->setValue('ca3b27', "");
        }else{
            $templateProcessor->setValue('ca3b27', $data['ca3b27']);
            $model2->catatan_auditor = $data['ca3b27'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b28";
        //3
        if($data['rb3b28'] == 'm'){
            $templateProcessor->setValue('m3b28', "&#8730;");
            $templateProcessor->setValue('tm3b28', "");
            $templateProcessor->setValue('tr3b28', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b28'] == 'tm'){
            $templateProcessor->setValue('m3b28', "");
            $templateProcessor->setValue('tm3b28', "&#8730;");
            $templateProcessor->setValue('tr3b28', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b28'] == 'tr'){
            $templateProcessor->setValue('m3b28', "");
            $templateProcessor->setValue('tm3b28', "");
            $templateProcessor->setValue('tr3b28', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b28'] == null){
            $templateProcessor->setValue('ca3b28', "");
        }else{
            $templateProcessor->setValue('ca3b28', $data['ca3b28']);
            $model2->catatan_auditor = $data['ca3b28'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1a";
        //3
        if($data['rb3c1a'] == 'm'){
            $templateProcessor->setValue('m3c1a', "&#8730;");
            $templateProcessor->setValue('tm3c1a', "");
            $templateProcessor->setValue('tr3c1a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1a'] == 'tm'){
            $templateProcessor->setValue('m3c1a', "");
            $templateProcessor->setValue('tm3c1a', "&#8730;");
            $templateProcessor->setValue('tr3c1a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1a'] == 'tr'){
            $templateProcessor->setValue('m3c1a', "");
            $templateProcessor->setValue('tm3c1a', "");
            $templateProcessor->setValue('tr3c1a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1a'] == null){
            $templateProcessor->setValue('ca3c1a', "");
        }else{
            $templateProcessor->setValue('ca3c1a', $data['ca3c1a']);
            $model2->catatan_auditor = $data['ca3c1a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];         
        $model2->kriteria_sjph = "3c1b";
        //3
        if($data['rb3c1b'] == 'm'){
            $templateProcessor->setValue('m3c1b', "&#8730;");
            $templateProcessor->setValue('tm3c1b', "");
            $templateProcessor->setValue('tr3c1b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1b'] == 'tm'){
            $templateProcessor->setValue('m3c1b', "");
            $templateProcessor->setValue('tm3c1b', "&#8730;");
            $templateProcessor->setValue('tr3c1b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1b'] == 'tr'){
            $templateProcessor->setValue('m3c1b', "");
            $templateProcessor->setValue('tm3c1b', "");
            $templateProcessor->setValue('tr3c1b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1b'] == null){
            $templateProcessor->setValue('ca3c1b', "");
        }else{
            $templateProcessor->setValue('ca3c1b', $data['ca3c1b']);
            $model2->catatan_auditor = $data['ca3c1b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];         
        $model2->kriteria_sjph = "3c1c";
        //3
        if($data['rb3c1c'] == 'm'){
            $templateProcessor->setValue('m3c1c', "&#8730;");
            $templateProcessor->setValue('tm3c1c', "");
            $templateProcessor->setValue('tr3c1c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1c'] == 'tm'){
            $templateProcessor->setValue('m3c1c', "");
            $templateProcessor->setValue('tm3c1c', "&#8730;");
            $templateProcessor->setValue('tr3c1c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1c'] == 'tr'){
            $templateProcessor->setValue('m3c1c', "");
            $templateProcessor->setValue('tm3c1c', "");
            $templateProcessor->setValue('tr3c1c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1c'] == null){
            $templateProcessor->setValue('ca3c1c', "");
        }else{
            $templateProcessor->setValue('ca3c1c', $data['ca3c1c']);
            $model2->catatan_auditor = $data['ca3c1c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];          
        $model2->kriteria_sjph = "3c1d";
        //3
        if($data['rb3c1d'] == 'm'){
            $templateProcessor->setValue('m3c1d', "&#8730;");
            $templateProcessor->setValue('tm3c1d', "");
            $templateProcessor->setValue('tr3c1d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1d'] == 'tm'){
            $templateProcessor->setValue('m3c1d', "");
            $templateProcessor->setValue('tm3c1d', "&#8730;");
            $templateProcessor->setValue('tr3c1d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1d'] == 'tr'){
            $templateProcessor->setValue('m3c1d', "");
            $templateProcessor->setValue('tm3c1d', "");
            $templateProcessor->setValue('tr3c1d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1d'] == null){
            $templateProcessor->setValue('ca3c1d', "");
        }else{
            $templateProcessor->setValue('ca3c1d', $data['ca3c1d']);
            $model2->catatan_auditor = $data['ca3c1d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];          
        $model2->kriteria_sjph = "3c1e";
        //3
        if($data['rb3c1e'] == 'm'){
            $templateProcessor->setValue('m3c1e', "&#8730;");
            $templateProcessor->setValue('tm3c1e', "");
            $templateProcessor->setValue('tr3c1e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1e'] == 'tm'){
            $templateProcessor->setValue('m3c1e', "");
            $templateProcessor->setValue('tm3c1e', "&#8730;");
            $templateProcessor->setValue('tr3c1e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1e'] == 'tr'){
            $templateProcessor->setValue('m3c1e', "");
            $templateProcessor->setValue('tm3c1e', "");
            $templateProcessor->setValue('tr3c1e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1e'] == null){
            $templateProcessor->setValue('ca3c1e', "");
        }else{
            $templateProcessor->setValue('ca3c1e', $data['ca3c1e']);
            $model2->catatan_auditor = $data['ca3c1e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1f";
        //3
        if($data['rb3c1f'] == 'm'){
            $templateProcessor->setValue('m3c1f', "&#8730;");
            $templateProcessor->setValue('tm3c1f', "");
            $templateProcessor->setValue('tr3c1f', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1f'] == 'tm'){
            $templateProcessor->setValue('m3c1f', "");
            $templateProcessor->setValue('tm3c1f', "&#8730;");
            $templateProcessor->setValue('tr3c1f', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1f'] == 'tr'){
            $templateProcessor->setValue('m3c1f', "");
            $templateProcessor->setValue('tm3c1f', "");
            $templateProcessor->setValue('tr3c1f', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1f'] == null){
            $templateProcessor->setValue('ca3c1f', "");
        }else{
            $templateProcessor->setValue('ca3c1f', $data['ca3c1f']);
            $model2->catatan_auditor = $data['ca3c1f'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1g";
        //3
        if($data['rb3c1g'] == 'm'){
            $templateProcessor->setValue('m3c1g', "&#8730;");
            $templateProcessor->setValue('tm3c1g', "");
            $templateProcessor->setValue('tr3c1g', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1g'] == 'tm'){
            $templateProcessor->setValue('m3c1g', "");
            $templateProcessor->setValue('tm3c1g', "&#8730;");
            $templateProcessor->setValue('tr3c1g', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1g'] == 'tr'){
            $templateProcessor->setValue('m3c1g', "");
            $templateProcessor->setValue('tm3c1g', "");
            $templateProcessor->setValue('tr3c1g', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1g'] == null){
            $templateProcessor->setValue('ca3c1g', "");
        }else{
            $templateProcessor->setValue('ca3c1g', $data['ca3c1g']);
            $model2->catatan_auditor = $data['ca3c1g'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1h";
        //3
        if($data['rb3c1h'] == 'm'){
            $templateProcessor->setValue('m3c1h', "&#8730;");
            $templateProcessor->setValue('tm3c1h', "");
            $templateProcessor->setValue('tr3c1h', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1h'] == 'tm'){
            $templateProcessor->setValue('m3c1h', "");
            $templateProcessor->setValue('tm3c1h', "&#8730;");
            $templateProcessor->setValue('tr3c1h', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1h'] == 'tr'){
            $templateProcessor->setValue('m3c1h', "");
            $templateProcessor->setValue('tm3c1h', "");
            $templateProcessor->setValue('tr3c1h', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1h'] == null){
            $templateProcessor->setValue('ca3c1h', "");
        }else{
            $templateProcessor->setValue('ca3c1h', $data['ca3c1h']);
            $model2->catatan_auditor = $data['ca3c1h'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1i";
        //3
        if($data['rb3c1i'] == 'm'){
            $templateProcessor->setValue('m3c1i', "&#8730;");
            $templateProcessor->setValue('tm3c1i', "");
            $templateProcessor->setValue('tr3c1i', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1i'] == 'tm'){
            $templateProcessor->setValue('m3c1i', "");
            $templateProcessor->setValue('tm3c1i', "&#8730;");
            $templateProcessor->setValue('tr3c1i', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1i'] == 'tr'){
            $templateProcessor->setValue('m3c1i', "");
            $templateProcessor->setValue('tm3c1i', "");
            $templateProcessor->setValue('tr3c1i', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1i'] == null){
            $templateProcessor->setValue('ca3c1i', "");
        }else{
            $templateProcessor->setValue('ca3c1i', $data['ca3c1i']);
            $model2->catatan_auditor = $data['ca3c1i'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1j";
        //3
        if($data['rb3c1j'] == 'm'){
            $templateProcessor->setValue('m3c1j', "&#8730;");
            $templateProcessor->setValue('tm3c1j', "");
            $templateProcessor->setValue('tr3c1j', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1j'] == 'tm'){
            $templateProcessor->setValue('m3c1j', "");
            $templateProcessor->setValue('tm3c1j', "&#8730;");
            $templateProcessor->setValue('tr3c1j', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1j'] == 'tr'){
            $templateProcessor->setValue('m3c1j', "");
            $templateProcessor->setValue('tm3c1j', "");
            $templateProcessor->setValue('tr3c1j', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1j'] == null){
            $templateProcessor->setValue('ca3c1j', "");
        }else{
            $templateProcessor->setValue('ca3c1j', $data['ca3c1j']);
            $model2->catatan_auditor = $data['ca3c1j'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1k";
        //3
        if($data['rb3c1k'] == 'm'){
            $templateProcessor->setValue('m3c1k', "&#8730;");
            $templateProcessor->setValue('tm3c1k', "");
            $templateProcessor->setValue('tr3c1k', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1k'] == 'tm'){
            $templateProcessor->setValue('m3c1k', "");
            $templateProcessor->setValue('tm3c1k', "&#8730;");
            $templateProcessor->setValue('tr3c1k', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1k'] == 'tr'){
            $templateProcessor->setValue('m3c1k', "");
            $templateProcessor->setValue('tm3c1k', "");
            $templateProcessor->setValue('tr3c1k', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1k'] == null){
            $templateProcessor->setValue('ca3c1k', "");
        }else{
            $templateProcessor->setValue('ca3c1k', $data['ca3c1k']);
            $model2->catatan_auditor = $data['ca3c1k'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1l";
        //3
        if($data['rb3c1l'] == 'm'){
            $templateProcessor->setValue('m3c1l', "&#8730;");
            $templateProcessor->setValue('tm3c1l', "");
            $templateProcessor->setValue('tr3c1l', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1l'] == 'tm'){
            $templateProcessor->setValue('m3c1l', "");
            $templateProcessor->setValue('tm3c1l', "&#8730;");
            $templateProcessor->setValue('tr3c1l', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1l'] == 'tr'){
            $templateProcessor->setValue('m3c1l', "");
            $templateProcessor->setValue('tm3c1l', "");
            $templateProcessor->setValue('tr3c1l', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1l'] == null){
            $templateProcessor->setValue('ca3c1l', "");
        }else{
            $templateProcessor->setValue('ca3c1l', $data['ca3c1l']);
            $model2->catatan_auditor = $data['ca3c1l'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1m";
        //3
        if($data['rb3c1m'] == 'm'){
            $templateProcessor->setValue('m3c1m', "&#8730;");
            $templateProcessor->setValue('tm3c1m', "");
            $templateProcessor->setValue('tr3c1m', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1m'] == 'tm'){
            $templateProcessor->setValue('m3c1m', "");
            $templateProcessor->setValue('tm3c1m', "&#8730;");
            $templateProcessor->setValue('tr3c1m', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1m'] == 'tr'){
            $templateProcessor->setValue('m3c1m', "");
            $templateProcessor->setValue('tm3c1m', "");
            $templateProcessor->setValue('tr3c1m', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1m'] == null){
            $templateProcessor->setValue('ca3c1m', "");
        }else{
            $templateProcessor->setValue('ca3c1m', $data['ca3c1m']);
            $model2->catatan_auditor = $data['ca3c1m'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1n";
        //3
        if($data['rb3c1n'] == 'm'){
            $templateProcessor->setValue('m3c1n', "&#8730;");
            $templateProcessor->setValue('tm3c1n', "");
            $templateProcessor->setValue('tr3c1n', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1n'] == 'tm'){
            $templateProcessor->setValue('m3c1n', "");
            $templateProcessor->setValue('tm3c1n', "&#8730;");
            $templateProcessor->setValue('tr3c1n', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1n'] == 'tr'){
            $templateProcessor->setValue('m3c1n', "");
            $templateProcessor->setValue('tm3c1n', "");
            $templateProcessor->setValue('tr3c1n', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1n'] == null){
            $templateProcessor->setValue('ca3c1n', "");
        }else{
            $templateProcessor->setValue('ca3c1n', $data['ca3c1n']);
            $model2->catatan_auditor = $data['ca3c1n'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1o";
        //3
        if($data['rb3c1o'] == 'm'){
            $templateProcessor->setValue('m3c1o', "&#8730;");
            $templateProcessor->setValue('tm3c1o', "");
            $templateProcessor->setValue('tr3c1o', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1o'] == 'tm'){
            $templateProcessor->setValue('m3c1o', "");
            $templateProcessor->setValue('tm3c1o', "&#8730;");
            $templateProcessor->setValue('tr3c1o', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1o'] == 'tr'){
            $templateProcessor->setValue('m3c1o', "");
            $templateProcessor->setValue('tm3c1o', "");
            $templateProcessor->setValue('tr3c1o', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1o'] == null){
            $templateProcessor->setValue('ca3c1o', "");
        }else{
            $templateProcessor->setValue('ca3c1o', $data['ca3c1o']);
            $model2->catatan_auditor = $data['ca3c1o'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1p";
        //3
        if($data['rb3c1p'] == 'm'){
            $templateProcessor->setValue('m3c1p', "&#8730;");
            $templateProcessor->setValue('tm3c1p', "");
            $templateProcessor->setValue('tr3c1p', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1p'] == 'tm'){
            $templateProcessor->setValue('m3c1p', "");
            $templateProcessor->setValue('tm3c1p', "&#8730;");
            $templateProcessor->setValue('tr3c1p', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1p'] == 'tr'){
            $templateProcessor->setValue('m3c1p', "");
            $templateProcessor->setValue('tm3c1p', "");
            $templateProcessor->setValue('tr3c1p', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1p'] == null){
            $templateProcessor->setValue('ca3c1p', "");
        }else{
            $templateProcessor->setValue('ca3c1p', $data['ca3c1p']);
            $model2->catatan_auditor = $data['ca3c1p'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1q";
        //3
        if($data['rb3c1q'] == 'm'){
            $templateProcessor->setValue('m3c1q', "&#8730;");
            $templateProcessor->setValue('tm3c1q', "");
            $templateProcessor->setValue('tr3c1q', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1q'] == 'tm'){
            $templateProcessor->setValue('m3c1q', "");
            $templateProcessor->setValue('tm3c1q', "&#8730;");
            $templateProcessor->setValue('tr3c1q', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1q'] == 'tr'){
            $templateProcessor->setValue('m3c1q', "");
            $templateProcessor->setValue('tm3c1q', "");
            $templateProcessor->setValue('tr3c1q', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1q'] == null){
            $templateProcessor->setValue('ca3c1q', "");
        }else{
            $templateProcessor->setValue('ca3c1q', $data['ca3c1q']);
            $model2->catatan_auditor = $data['ca3c1q'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1r";
        //3
        if($data['rb3c1r'] == 'm'){
            $templateProcessor->setValue('m3c1r', "&#8730;");
            $templateProcessor->setValue('tm3c1r', "");
            $templateProcessor->setValue('tr3c1r', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1r'] == 'tm'){
            $templateProcessor->setValue('m3c1r', "");
            $templateProcessor->setValue('tm3c1r', "&#8730;");
            $templateProcessor->setValue('tr3c1r', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1r'] == 'tr'){
            $templateProcessor->setValue('m3c1r', "");
            $templateProcessor->setValue('tm3c1r', "");
            $templateProcessor->setValue('tr3c1r', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1r'] == null){
            $templateProcessor->setValue('ca3c1r', "");
        }else{
            $templateProcessor->setValue('ca3c1r', $data['ca3c1r']);
            $model2->catatan_auditor = $data['ca3c1r'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1s";
        //3
        if($data['rb3c1s'] == 'm'){
            $templateProcessor->setValue('m3c1s', "&#8730;");
            $templateProcessor->setValue('tm3c1s', "");
            $templateProcessor->setValue('tr3c1s', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1s'] == 'tm'){
            $templateProcessor->setValue('m3c1s', "");
            $templateProcessor->setValue('tm3c1s', "&#8730;");
            $templateProcessor->setValue('tr3c1s', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1s'] == 'tr'){
            $templateProcessor->setValue('m3c1s', "");
            $templateProcessor->setValue('tm3c1s', "");
            $templateProcessor->setValue('tr3c1s', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1s'] == null){
            $templateProcessor->setValue('ca3c1s', "");
        }else{
            $templateProcessor->setValue('ca3c1s', $data['ca3c1s']);
            $model2->catatan_auditor = $data['ca3c1s'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c2";
        //3
        if($data['rb3c2'] == 'm'){
            $templateProcessor->setValue('m3c2', "&#8730;");
            $templateProcessor->setValue('tm3c2', "");
            $templateProcessor->setValue('tr3c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c2'] == 'tm'){
            $templateProcessor->setValue('m3c2', "");
            $templateProcessor->setValue('tm3c2', "&#8730;");
            $templateProcessor->setValue('tr3c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c2'] == 'tr'){
            $templateProcessor->setValue('m3c2', "");
            $templateProcessor->setValue('tm3c2', "");
            $templateProcessor->setValue('tr3c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c2'] == null){
            $templateProcessor->setValue('ca3c2', "");
        }else{
            $templateProcessor->setValue('ca3c2', $data['ca3c2']);
            $model2->catatan_auditor = $data['ca3c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c3";
        //3
        if($data['rb3c3'] == 'm'){
            $templateProcessor->setValue('m3c3', "&#8730;");
            $templateProcessor->setValue('tm3c3', "");
            $templateProcessor->setValue('tr3c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c3'] == 'tm'){
            $templateProcessor->setValue('m3c3', "");
            $templateProcessor->setValue('tm3c3', "&#8730;");
            $templateProcessor->setValue('tr3c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c3'] == 'tr'){
            $templateProcessor->setValue('m3c3', "");
            $templateProcessor->setValue('tm3c3', "");
            $templateProcessor->setValue('tr3c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c3'] == null){
            $templateProcessor->setValue('ca3c3', "");
        }else{
            $templateProcessor->setValue('ca3c3', $data['ca3c3']);
            $model2->catatan_auditor = $data['ca3c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c4";
        //3
        if($data['rb3c4'] == 'm'){
            $templateProcessor->setValue('m3c4', "&#8730;");
            $templateProcessor->setValue('tm3c4', "");
            $templateProcessor->setValue('tr3c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c4'] == 'tm'){
            $templateProcessor->setValue('m3c4', "");
            $templateProcessor->setValue('tm3c4', "&#8730;");
            $templateProcessor->setValue('tr3c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c4'] == 'tr'){
            $templateProcessor->setValue('m3c4', "");
            $templateProcessor->setValue('tm3c4', "");
            $templateProcessor->setValue('tr3c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c4'] == null){
            $templateProcessor->setValue('ca3c4', "");
        }else{
            $templateProcessor->setValue('ca3c4', $data['ca3c4']);
            $model2->catatan_auditor = $data['ca3c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c5";
        //3
        if($data['rb3c5'] == 'm'){
            $templateProcessor->setValue('m3c5', "&#8730;");
            $templateProcessor->setValue('tm3c5', "");
            $templateProcessor->setValue('tr3c5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c5'] == 'tm'){
            $templateProcessor->setValue('m3c5', "");
            $templateProcessor->setValue('tm3c5', "&#8730;");
            $templateProcessor->setValue('tr3c5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c5'] == 'tr'){
            $templateProcessor->setValue('m3c5', "");
            $templateProcessor->setValue('tm3c5', "");
            $templateProcessor->setValue('tr3c5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c5'] == null){
            $templateProcessor->setValue('ca3c5', "");
        }else{
            $templateProcessor->setValue('ca3c5', $data['ca3c5']);
            $model2->catatan_auditor = $data['ca3c5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c6";
        //3
        if($data['rb3c6'] == 'm'){
            $templateProcessor->setValue('m3c6', "&#8730;");
            $templateProcessor->setValue('tm3c6', "");
            $templateProcessor->setValue('tr3c6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c6'] == 'tm'){
            $templateProcessor->setValue('m3c6', "");
            $templateProcessor->setValue('tm3c6', "&#8730;");
            $templateProcessor->setValue('tr3c6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c6'] == 'tr'){
            $templateProcessor->setValue('m3c6', "");
            $templateProcessor->setValue('tm3c6', "");
            $templateProcessor->setValue('tr3c6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c6'] == null){
            $templateProcessor->setValue('ca3c6', "");
        }else{
            $templateProcessor->setValue('ca3c6', $data['ca3c6']);
            $model2->catatan_auditor = $data['ca3c6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c7";
        //3
        if($data['rb3c7'] == 'm'){
            $templateProcessor->setValue('m3c7', "&#8730;");
            $templateProcessor->setValue('tm3c7', "");
            $templateProcessor->setValue('tr3c7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c7'] == 'tm'){
            $templateProcessor->setValue('m3c7', "");
            $templateProcessor->setValue('tm3c7', "&#8730;");
            $templateProcessor->setValue('tr3c7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c7'] == 'tr'){
            $templateProcessor->setValue('m3c7', "");
            $templateProcessor->setValue('tm3c7', "");
            $templateProcessor->setValue('tr3c7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c7'] == null){
            $templateProcessor->setValue('ca3c7', "");
        }else{
            $templateProcessor->setValue('ca3c7', $data['ca3c7']);
            $model2->catatan_auditor = $data['ca3c7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c8";
        //3
        if($data['rb3c8'] == 'm'){
            $templateProcessor->setValue('m3c8', "&#8730;");
            $templateProcessor->setValue('tm3c8', "");
            $templateProcessor->setValue('tr3c8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c8'] == 'tm'){
            $templateProcessor->setValue('m3c8', "");
            $templateProcessor->setValue('tm3c8', "&#8730;");
            $templateProcessor->setValue('tr3c8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c8'] == 'tr'){
            $templateProcessor->setValue('m3c8', "");
            $templateProcessor->setValue('tm3c8', "");
            $templateProcessor->setValue('tr3c8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c8'] == null){
            $templateProcessor->setValue('ca3c8', "");
        }else{
            $templateProcessor->setValue('ca3c8', $data['ca3c8']);
            $model2->catatan_auditor = $data['ca3c8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c9";
        //3
        if($data['rb3c9'] == 'm'){
            $templateProcessor->setValue('m3c9', "&#8730;");
            $templateProcessor->setValue('tm3c9', "");
            $templateProcessor->setValue('tr3c9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c9'] == 'tm'){
            $templateProcessor->setValue('m3c9', "");
            $templateProcessor->setValue('tm3c9', "&#8730;");
            $templateProcessor->setValue('tr3c9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c9'] == 'tr'){
            $templateProcessor->setValue('m3c9', "");
            $templateProcessor->setValue('tm3c9', "");
            $templateProcessor->setValue('tr3c9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c9'] == null){
            $templateProcessor->setValue('ca3c9', "");
        }else{
            $templateProcessor->setValue('ca3c9', $data['ca3c9']);
            $model2->catatan_auditor = $data['ca3c9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c10";
        //3
        if($data['rb3c10'] == 'm'){
            $templateProcessor->setValue('m3c10', "&#8730;");
            $templateProcessor->setValue('tm3c10', "");
            $templateProcessor->setValue('tr3c10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c10'] == 'tm'){
            $templateProcessor->setValue('m3c10', "");
            $templateProcessor->setValue('tm3c10', "&#8730;");
            $templateProcessor->setValue('tr3c10', "");
            
            $model2->status_kriteria = "tm";
        }else if($data['rb3c10'] == 'tr'){
            $templateProcessor->setValue('m3c10', "");
            $templateProcessor->setValue('tm3c10', "");
            $templateProcessor->setValue('tr3c10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c10'] == null){
            $templateProcessor->setValue('ca3c10', "");
        }else{
            $templateProcessor->setValue('ca3c10', $data['ca3c10']);
            $model2->catatan_auditor = $data['ca3c10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a1";
        //4
        if($data['rb4a1'] == 'm'){
            $templateProcessor->setValue('m4a1', "&#8730;");
            $templateProcessor->setValue('tm4a1', "");
            $templateProcessor->setValue('tr4a1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a1'] == 'tm'){
            $templateProcessor->setValue('m4a1', "");
            $templateProcessor->setValue('tm4a1', "&#8730;");
            $templateProcessor->setValue('tr4a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a1'] == 'tr'){
            $templateProcessor->setValue('m4a1', "");
            $templateProcessor->setValue('tm4a1', "");
            $templateProcessor->setValue('tr4a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }        

        if($data['ca4a1'] == null){
            $templateProcessor->setValue('ca4a1', "");
        }else{
            $templateProcessor->setValue('ca4a1', $data['ca4a1']);
            $model2->catatan_auditor = $data['ca4a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a2";
        //4
        if($data['rb4a2'] == 'm'){
            $templateProcessor->setValue('m4a2', "&#8730;");
            $templateProcessor->setValue('tm4a2', "");
            $templateProcessor->setValue('tr4a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a2'] == 'tm'){
            $templateProcessor->setValue('m4a2', "");
            $templateProcessor->setValue('tm4a2', "&#8730;");
            $templateProcessor->setValue('tr4a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a2'] == 'tr'){
            $templateProcessor->setValue('m4a2', "");
            $templateProcessor->setValue('tm4a2', "");
            $templateProcessor->setValue('tr4a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a2'] == null){
            $templateProcessor->setValue('ca4a2', "");
        }else{
            $templateProcessor->setValue('ca4a2', $data['ca4a2']);
            $model2->catatan_auditor = $data['ca4a2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3a";
        //4
        if($data['rb4a3a'] == 'm'){
            $templateProcessor->setValue('m4a3a', "&#8730;");
            $templateProcessor->setValue('tm4a3a', "");
            $templateProcessor->setValue('tr4a3a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3a'] == 'tm'){
            $templateProcessor->setValue('m4a3a', "");
            $templateProcessor->setValue('tm4a3a', "&#8730;");
            $templateProcessor->setValue('tr4a3a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3a'] == 'tr'){
            $templateProcessor->setValue('m4a3a', "");
            $templateProcessor->setValue('tm4a3a', "");
            $templateProcessor->setValue('tr4a3a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3a'] == null){
            $templateProcessor->setValue('ca4a3a', "");
        }else{
            $templateProcessor->setValue('ca4a3a', $data['ca4a3a']);
            $model2->catatan_auditor = $data['ca4a3a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3b";
        //4
        if($data['rb4a3b'] == 'm'){
            $templateProcessor->setValue('m4a3b', "&#8730;");
            $templateProcessor->setValue('tm4a3b', "");
            $templateProcessor->setValue('tr4a3b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3b'] == 'tm'){
            $templateProcessor->setValue('m4a3b', "");
            $templateProcessor->setValue('tm4a3b', "&#8730;");
            $templateProcessor->setValue('tr4a3b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3b'] == 'tr'){
            $templateProcessor->setValue('m4a3b', "");
            $templateProcessor->setValue('tm4a3b', "");
            $templateProcessor->setValue('tr4a3b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3b'] == null){
            $templateProcessor->setValue('ca4a3b', "");
        }else{
            $templateProcessor->setValue('ca4a3b', $data['ca4a3b']);
            $model2->catatan_auditor = $data['ca4a3b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3c";
        //4
        if($data['rb4a3c'] == 'm'){
            $templateProcessor->setValue('m4a3c', "&#8730;");
            $templateProcessor->setValue('tm4a3c', "");
            $templateProcessor->setValue('tr4a3c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3c'] == 'tm'){
            $templateProcessor->setValue('m4a3c', "");
            $templateProcessor->setValue('tm4a3c', "&#8730;");
            $templateProcessor->setValue('tr4a3c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3c'] == 'tr'){
            $templateProcessor->setValue('m4a3c', "");
            $templateProcessor->setValue('tm4a3c', "");
            $templateProcessor->setValue('tr4a3c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3c'] == null){
            $templateProcessor->setValue('ca4a3c', "");
        }else{
            $templateProcessor->setValue('ca4a3c', $data['ca4a3c']);
            $model2->catatan_auditor = $data['ca4a3c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3d";
        //4
        if($data['rb4a3d'] == 'm'){
            $templateProcessor->setValue('m4a3d', "&#8730;");
            $templateProcessor->setValue('tm4a3d', "");
            $templateProcessor->setValue('tr4a3d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3d'] == 'tm'){
            $templateProcessor->setValue('m4a3d', "");
            $templateProcessor->setValue('tm4a3d', "&#8730;");
            $templateProcessor->setValue('tr4a3d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3d'] == 'tr'){
            $templateProcessor->setValue('m4a3d', "");
            $templateProcessor->setValue('tm4a3d', "");
            $templateProcessor->setValue('tr4a3d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3d'] == null){
            $templateProcessor->setValue('ca4a3d', "");
        }else{
            $templateProcessor->setValue('ca4a3d', $data['ca4a3d']);
            $model2->catatan_auditor = $data['ca4a3d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3e";
        //4
        if($data['rb4a3e'] == 'm'){
            $templateProcessor->setValue('m4a3e', "&#8730;");
            $templateProcessor->setValue('tm4a3e', "");
            $templateProcessor->setValue('tr4a3e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3e'] == 'tm'){
            $templateProcessor->setValue('m4a3e', "");
            $templateProcessor->setValue('tm4a3e', "&#8730;");
            $templateProcessor->setValue('tr4a3e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3e'] == 'tr'){
            $templateProcessor->setValue('m4a3e', "");
            $templateProcessor->setValue('tm4a3e', "");
            $templateProcessor->setValue('tr4a3e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3e'] == null){
            $templateProcessor->setValue('ca4a3e', "");
        }else{
            $templateProcessor->setValue('ca4a3e', $data['ca4a3e']);
            $model2->catatan_auditor = $data['ca4a3e'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a4";
        //4
        if($data['rb4a4'] == 'm'){
            $templateProcessor->setValue('m4a4', "&#8730;");
            $templateProcessor->setValue('tm4a4', "");
            $templateProcessor->setValue('tr4a4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a4'] == 'tm'){
            $templateProcessor->setValue('m4a4', "");
            $templateProcessor->setValue('tm4a4', "&#8730;");
            $templateProcessor->setValue('tr4a4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a4'] == 'tr'){
            $templateProcessor->setValue('m4a4', "");
            $templateProcessor->setValue('tm4a4', "");
            $templateProcessor->setValue('tr4a4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a4'] == null){
            $templateProcessor->setValue('ca4a4', "");
        }else{
            $templateProcessor->setValue('ca4a4', $data['ca4a4']);
            $model2->catatan_auditor = $data['ca4a4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a5";
        //4
        if($data['rb4a5'] == 'm'){
            $templateProcessor->setValue('m4a5', "&#8730;");
            $templateProcessor->setValue('tm4a5', "");
            $templateProcessor->setValue('tr4a5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a5'] == 'tm'){
            $templateProcessor->setValue('m4a5', "");
            $templateProcessor->setValue('tm4a5', "&#8730;");
            $templateProcessor->setValue('tr4a5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a5'] == 'tr'){
            $templateProcessor->setValue('m4a5', "");
            $templateProcessor->setValue('tm4a5', "");
            $templateProcessor->setValue('tr4a5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a5'] == null){
            $templateProcessor->setValue('ca4a5', "");
        }else{
            $templateProcessor->setValue('ca4a5', $data['ca4a5']);
            $model2->catatan_auditor = $data['ca4a5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a6";
        //4
        if($data['rb4a6'] == 'm'){
            $templateProcessor->setValue('m4a6', "&#8730;");
            $templateProcessor->setValue('tm4a6', "");
            $templateProcessor->setValue('tr4a6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a6'] == 'tm'){
            $templateProcessor->setValue('m4a6', "");
            $templateProcessor->setValue('tm4a6', "&#8730;");
            $templateProcessor->setValue('tr4a6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a6'] == 'tr'){
            $templateProcessor->setValue('m4a6', "");
            $templateProcessor->setValue('tm4a6', "");
            $templateProcessor->setValue('tr4a6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a6'] == null){
            $templateProcessor->setValue('ca4a6', "");
        }else{
            $templateProcessor->setValue('ca4a6', $data['ca4a6']);
            $model2->catatan_auditor = $data['ca4a6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b1";
        //4
        if($data['rb4b1'] == 'm'){
            $templateProcessor->setValue('m4b1', "&#8730;");
            $templateProcessor->setValue('tm4b1', "");
            $templateProcessor->setValue('tr4b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b1'] == 'tm'){
            $templateProcessor->setValue('m4b1', "");
            $templateProcessor->setValue('tm4b1', "&#8730;");
            $templateProcessor->setValue('tr4b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b1'] == 'tr'){
            $templateProcessor->setValue('m4b1', "");
            $templateProcessor->setValue('tm4b1', "");
            $templateProcessor->setValue('tr4b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b1'] == null){
            $templateProcessor->setValue('ca4b1', "");
        }else{
            $templateProcessor->setValue('ca4b1', $data['ca4b1']);
            $model2->catatan_auditor = $data['ca4b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b2";
        //4
        if($data['rb4b2'] == 'm'){
            $templateProcessor->setValue('m4b2', "&#8730;");
            $templateProcessor->setValue('tm4b2', "");
            $templateProcessor->setValue('tr4b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b2'] == 'tm'){
            $templateProcessor->setValue('m4b2', "");
            $templateProcessor->setValue('tm4b2', "&#8730;");
            $templateProcessor->setValue('tr4b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b2'] == 'tr'){
            $templateProcessor->setValue('m4b2', "");
            $templateProcessor->setValue('tm4b2', "");
            $templateProcessor->setValue('tr4b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b2'] == null){
            $templateProcessor->setValue('ca4b2', "");
        }else{
            $templateProcessor->setValue('ca4b2', $data['ca4b2']);
            $model2->catatan_auditor = $data['ca4b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b3";
        //4
        if($data['rb4b3'] == 'm'){
            $templateProcessor->setValue('m4b3', "&#8730;");
            $templateProcessor->setValue('tm4b3', "");
            $templateProcessor->setValue('tr4b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b3'] == 'tm'){
            $templateProcessor->setValue('m4b3', "");
            $templateProcessor->setValue('tm4b3', "&#8730;");
            $templateProcessor->setValue('tr4b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b3'] == 'tr'){
            $templateProcessor->setValue('m4b3', "");
            $templateProcessor->setValue('tm4b3', "");
            $templateProcessor->setValue('tr4b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b3'] == null){
            $templateProcessor->setValue('ca4b3', "");
        }else{
            $templateProcessor->setValue('ca4b3', $data['ca4b3']);
            $model2->catatan_auditor = $data['ca4b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b4";
        //4
        if($data['rb4b4'] == 'm'){
            $templateProcessor->setValue('m4b4', "&#8730;");
            $templateProcessor->setValue('tm4b4', "");
            $templateProcessor->setValue('tr4b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b4'] == 'tm'){
            $templateProcessor->setValue('m4b4', "");
            $templateProcessor->setValue('tm4b4', "&#8730;");
            $templateProcessor->setValue('tr4b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b4'] == 'tr'){
            $templateProcessor->setValue('m4b4', "");
            $templateProcessor->setValue('tm4b4', "");
            $templateProcessor->setValue('tr4b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b4'] == null){
            $templateProcessor->setValue('ca4b4', "");
        }else{
            $templateProcessor->setValue('ca4b4', $data['ca4b4']);
            $model2->catatan_auditor = $data['ca4b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b5";
        //4
        if($data['rb4b5'] == 'm'){
            $templateProcessor->setValue('m4b5', "&#8730;");
            $templateProcessor->setValue('tm4b5', "");
            $templateProcessor->setValue('tr4b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b5'] == 'tm'){
            $templateProcessor->setValue('m4b5', "");
            $templateProcessor->setValue('tm4b5', "&#8730;");
            $templateProcessor->setValue('tr4b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b5'] == 'tr'){
            $templateProcessor->setValue('m4b5', "");
            $templateProcessor->setValue('tm4b5', "");
            $templateProcessor->setValue('tr4b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b5'] == null){
            $templateProcessor->setValue('ca4b5', "");
        }else{
            $templateProcessor->setValue('ca4b5', $data['ca4b5']);
            $model2->catatan_auditor = $data['ca4b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b6";
        //4
        if($data['rb4b6'] == 'm'){
            $templateProcessor->setValue('m4b6', "&#8730;");
            $templateProcessor->setValue('tm4b6', "");
            $templateProcessor->setValue('tr4b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b6'] == 'tm'){
            $templateProcessor->setValue('m4b6', "");
            $templateProcessor->setValue('tm4b6', "&#8730;");
            $templateProcessor->setValue('tr4b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b6'] == 'tr'){
            $templateProcessor->setValue('m4b6', "");
            $templateProcessor->setValue('tm4b6', "");
            $templateProcessor->setValue('tr4b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b6'] == null){
            $templateProcessor->setValue('ca4b6', "");
        }else{
            $templateProcessor->setValue('ca4b6', $data['ca4b6']);
            $model2->catatan_auditor = $data['ca4b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b7";
        //4
        if($data['rb4b7'] == 'm'){
            $templateProcessor->setValue('m4b7', "&#8730;");
            $templateProcessor->setValue('tm4b7', "");
            $templateProcessor->setValue('tr4b7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b7'] == 'tm'){
            $templateProcessor->setValue('m4b7', "");
            $templateProcessor->setValue('tm4b7', "&#8730;");
            $templateProcessor->setValue('tr4b7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b7'] == 'tr'){
            $templateProcessor->setValue('m4b7', "");
            $templateProcessor->setValue('tm4b7', "");
            $templateProcessor->setValue('tr4b7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b7'] == null){
            $templateProcessor->setValue('ca4b7', "");
        }else{
            $templateProcessor->setValue('ca4b7', $data['ca4b7']);
            $model2->catatan_auditor = $data['ca4b7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b8";
        //4
        if($data['rb4b8'] == 'm'){
            $templateProcessor->setValue('m4b8', "&#8730;");
            $templateProcessor->setValue('tm4b8', "");
            $templateProcessor->setValue('tr4b8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b8'] == 'tm'){
            $templateProcessor->setValue('m4b8', "");
            $templateProcessor->setValue('tm4b8', "&#8730;");
            $templateProcessor->setValue('tr4b8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b8'] == 'tr'){
            $templateProcessor->setValue('m4b8', "");
            $templateProcessor->setValue('tm4b8', "");
            $templateProcessor->setValue('tr4b8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b8'] == null){
            $templateProcessor->setValue('ca4b8', "");
        }else{
            $templateProcessor->setValue('ca4b8', $data['ca4b8']);
            $model2->catatan_auditor = $data['ca4b8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b9";
        //4
        if($data['rb4b9'] == 'm'){
            $templateProcessor->setValue('m4b9', "&#8730;");
            $templateProcessor->setValue('tm4b9', "");
            $templateProcessor->setValue('tr4b9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b9'] == 'tm'){
            $templateProcessor->setValue('m4b9', "");
            $templateProcessor->setValue('tm4b9', "&#8730;");
            $templateProcessor->setValue('tr4b9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b9'] == 'tr'){
            $templateProcessor->setValue('m4b9', "");
            $templateProcessor->setValue('tm4b9', "");
            $templateProcessor->setValue('tr4b9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b9'] == null){
            $templateProcessor->setValue('ca4b9', "");
        }else{
            $templateProcessor->setValue('ca4b9', $data['ca4b9']);
            $model2->catatan_auditor = $data['ca4b9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b10";
        //4
        if($data['rb4b10'] == 'm'){
            $templateProcessor->setValue('m4b10', "&#8730;");
            $templateProcessor->setValue('tm4b10', "");
            $templateProcessor->setValue('tr4b10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b10'] == 'tm'){
            $templateProcessor->setValue('m4b10', "");
            $templateProcessor->setValue('tm4b10', "&#8730;");
            $templateProcessor->setValue('tr4b10', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b10'] == 'tr'){
            $templateProcessor->setValue('m4b10', "");
            $templateProcessor->setValue('tm4b10', "");
            $templateProcessor->setValue('tr4b10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b10'] == null){
            $templateProcessor->setValue('ca4b10', "");
        }else{
            $templateProcessor->setValue('ca4b10', $data['ca4b10']);
            $model2->catatan_auditor = $data['ca4b10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b11";
        //4
        if($data['rb4b11'] == 'm'){
            $templateProcessor->setValue('m4b11', "&#8730;");
            $templateProcessor->setValue('tm4b11', "");
            $templateProcessor->setValue('tr4b11', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b11'] == 'tm'){
            $templateProcessor->setValue('m4b11', "");
            $templateProcessor->setValue('tm4b11', "&#8730;");
            $templateProcessor->setValue('tr4b11', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b11'] == 'tr'){
            $templateProcessor->setValue('m4b11', "");
            $templateProcessor->setValue('tm4b11', "");
            $templateProcessor->setValue('tr4b11', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b11'] == null){
            $templateProcessor->setValue('ca4b11', "");
        }else{
            $templateProcessor->setValue('ca4b11', $data['ca4b11']);
            $model2->catatan_auditor = $data['ca4b11'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b12";
        //4
        if($data['rb4b12'] == 'm'){
            $templateProcessor->setValue('m4b12', "&#8730;");
            $templateProcessor->setValue('tm4b12', "");
            $templateProcessor->setValue('tr4b12', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b12'] == 'tm'){
            $templateProcessor->setValue('m4b12', "");
            $templateProcessor->setValue('tm4b12', "&#8730;");
            $templateProcessor->setValue('tr4b12', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b12'] == 'tr'){
            $templateProcessor->setValue('m4b12', "");
            $templateProcessor->setValue('tm4b12', "");
            $templateProcessor->setValue('tr4b12', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b12'] == null){
            $templateProcessor->setValue('ca4b12', "");
        }else{
            $templateProcessor->setValue('ca4b12', $data['ca4b12']);
            $model2->catatan_auditor = $data['ca4b12'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c1";
        //4
        if($data['rb4c1'] == 'm'){
            $templateProcessor->setValue('m4c1', "&#8730;");
            $templateProcessor->setValue('tm4c1', "");
            $templateProcessor->setValue('tr4c1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c1'] == 'tm'){
            $templateProcessor->setValue('m4c1', "");
            $templateProcessor->setValue('tm4c1', "&#8730;");
            $templateProcessor->setValue('tr4c1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c1'] == 'tr'){
            $templateProcessor->setValue('m4c1', "");
            $templateProcessor->setValue('tm4c1', "");
            $templateProcessor->setValue('tr4c1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c1'] == null){
            $templateProcessor->setValue('ca4c1', "");
        }else{
            $templateProcessor->setValue('ca4c1', $data['ca4c1']);
            $model2->catatan_auditor = $data['ca4c1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c2";
        //4
        if($data['rb4c2'] == 'm'){
            $templateProcessor->setValue('m4c2', "&#8730;");
            $templateProcessor->setValue('tm4c2', "");
            $templateProcessor->setValue('tr4c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c2'] == 'tm'){
            $templateProcessor->setValue('m4c2', "");
            $templateProcessor->setValue('tm4c2', "&#8730;");
            $templateProcessor->setValue('tr4c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c2'] == 'tr'){
            $templateProcessor->setValue('m4c2', "");
            $templateProcessor->setValue('tm4c2', "");
            $templateProcessor->setValue('tr4c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c2'] == null){
            $templateProcessor->setValue('ca4c2', "");
        }else{
            $templateProcessor->setValue('ca4c2', $data['ca4c2']);
            $model2->catatan_auditor = $data['ca4c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c3";
        //4
        if($data['rb4c3'] == 'm'){
            $templateProcessor->setValue('m4c3', "&#8730;");
            $templateProcessor->setValue('tm4c3', "");
            $templateProcessor->setValue('tr4c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c3'] == 'tm'){
            $templateProcessor->setValue('m4c3', "");
            $templateProcessor->setValue('tm4c3', "&#8730;");
            $templateProcessor->setValue('tr4c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c3'] == 'tr'){
            $templateProcessor->setValue('m4c3', "");
            $templateProcessor->setValue('tm4c3', "");
            $templateProcessor->setValue('tr4c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c3'] == null){
            $templateProcessor->setValue('ca4c3', "");
        }else{
            $templateProcessor->setValue('ca4c3', $data['ca4c3']);
            $model2->catatan_auditor = $data['ca4c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c4";
        //4
        if($data['rb4c4'] == 'm'){
            $templateProcessor->setValue('m4c4', "&#8730;");
            $templateProcessor->setValue('tm4c4', "");
            $templateProcessor->setValue('tr4c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c4'] == 'tm'){
            $templateProcessor->setValue('m4c4', "");
            $templateProcessor->setValue('tm4c4', "&#8730;");
            $templateProcessor->setValue('tr4c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c4'] == 'tr'){
            $templateProcessor->setValue('m4c4', "");
            $templateProcessor->setValue('tm4c4', "");
            $templateProcessor->setValue('tr4c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c4'] == null){
            $templateProcessor->setValue('ca4c4', "");
        }else{
            $templateProcessor->setValue('ca4c4', $data['ca4c4']);
            $model2->catatan_auditor = $data['ca4c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c5";
        //4
        if($data['rb4c5'] == 'm'){
            $templateProcessor->setValue('m4c5', "&#8730;");
            $templateProcessor->setValue('tm4c5', "");
            $templateProcessor->setValue('tr4c5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c5'] == 'tm'){
            $templateProcessor->setValue('m4c5', "");
            $templateProcessor->setValue('tm4c5', "&#8730;");
            $templateProcessor->setValue('tr4c5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c5'] == 'tr'){
            $templateProcessor->setValue('m4c5', "");
            $templateProcessor->setValue('tm4c5', "");
            $templateProcessor->setValue('tr4c5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c5'] == null){
            $templateProcessor->setValue('ca4c5', "");
        }else{
            $templateProcessor->setValue('ca4c5', $data['ca4c5']);
            $model2->catatan_auditor = $data['ca4c5'];
        }
        $model2->save();
        DB::commit();

        // $model2 = new DetailLaporanAuditTahap2();
        // DB::beginTransaction();
        // $model2->id_registrasi = $data['id_registrasi'];
        // $model2->id_penjadwalan = $data['id_penjadwalan'];      
        // $model2->kriteria_sjph = "4c6";
        // //4
        // if($data['rb4c6'] == 'm'){
        //     $templateProcessor->setValue('m4c6', "&#8730;");
        //     $templateProcessor->setValue('tm4c6', "");
        //     $templateProcessor->setValue('tr4c6', "");

        //     $model2->status_kriteria = "m";
        // }else if($data['rb4c6'] == 'tm'){
        //     $templateProcessor->setValue('m4c6', "");
        //     $templateProcessor->setValue('tm4c6', "&#8730;");
        //     $templateProcessor->setValue('tr4c6', "");

        //     $model2->status_kriteria = "tm";
        // }else if($data['rb4c6'] == 'tr'){
        //     $templateProcessor->setValue('m4c6', "");
        //     $templateProcessor->setValue('tm4c6', "");
        //     $templateProcessor->setValue('tr4c6', "&#8730;");

        //     $model2->status_kriteria = "tr";
        // }

        // if($data['ca4c6'] == null){
        //     $templateProcessor->setValue('ca4c6', "");
        // }else{
        //     $templateProcessor->setValue('ca4c6', $data['ca4c6']);
        //     $model2->catatan_auditor = $data['ca4c6'];
        // }
        // $model2->save();
        // DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4d1";
        //4
        if($data['rb4d1'] == 'm'){
            $templateProcessor->setValue('m4d1', "&#8730;");
            $templateProcessor->setValue('tm4d1', "");
            $templateProcessor->setValue('tr4d1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4d1'] == 'tm'){
            $templateProcessor->setValue('m4d1', "");
            $templateProcessor->setValue('tm4d1', "&#8730;");
            $templateProcessor->setValue('tr4d1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4d1'] == 'tr'){
            $templateProcessor->setValue('m4d1', "");
            $templateProcessor->setValue('tm4d1', "");
            $templateProcessor->setValue('tr4d1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4d1'] == null){
            $templateProcessor->setValue('ca4d1', "");
        }else{
            $templateProcessor->setValue('ca4d1', $data['ca4d1']);
            $model2->catatan_auditor = $data['ca4d1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4d2";
        //4
        if($data['rb4d2'] == 'm'){
            $templateProcessor->setValue('m4d2', "&#8730;");
            $templateProcessor->setValue('tm4d2', "");
            $templateProcessor->setValue('tr4d2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4d2'] == 'tm'){
            $templateProcessor->setValue('m4d2', "");
            $templateProcessor->setValue('tm4d2', "&#8730;");
            $templateProcessor->setValue('tr4d2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4d2'] == 'tr'){
            $templateProcessor->setValue('m4d2', "");
            $templateProcessor->setValue('tm4d2', "");
            $templateProcessor->setValue('tr4d2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4d2'] == null){
            $templateProcessor->setValue('ca4d2', "");
        }else{
            $templateProcessor->setValue('ca4d2', $data['ca4d2']);
            $model2->catatan_auditor = $data['ca4d2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4d3";
        //4
        if($data['rb4d3'] == 'm'){
            $templateProcessor->setValue('m4d3', "&#8730;");
            $templateProcessor->setValue('tm4d3', "");
            $templateProcessor->setValue('tr4d3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4d3'] == 'tm'){
            $templateProcessor->setValue('m4d3', "");
            $templateProcessor->setValue('tm4d3', "&#8730;");
            $templateProcessor->setValue('tr4d3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4d3'] == 'tr'){
            $templateProcessor->setValue('m4d3', "");
            $templateProcessor->setValue('tm4d3', "");
            $templateProcessor->setValue('tr4d3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4d3'] == null){
            $templateProcessor->setValue('ca4d3', "");
        }else{
            $templateProcessor->setValue('ca4d3', $data['ca4d3']);
            $model2->catatan_auditor = $data['ca4d3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4d4";
        //4
        if($data['rb4d4'] == 'm'){
            $templateProcessor->setValue('m4d4', "&#8730;");
            $templateProcessor->setValue('tm4d4', "");
            $templateProcessor->setValue('tr4d4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4d4'] == 'tm'){
            $templateProcessor->setValue('m4d4', "");
            $templateProcessor->setValue('tm4d4', "&#8730;");
            $templateProcessor->setValue('tr4d4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4d4'] == 'tr'){
            $templateProcessor->setValue('m4d4', "");
            $templateProcessor->setValue('tm4d4', "");
            $templateProcessor->setValue('tr4d4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4d4'] == null){
            $templateProcessor->setValue('ca4d4', "");
        }else{
            $templateProcessor->setValue('ca4d4', $data['ca4d4']);
            $model2->catatan_auditor = $data['ca4d4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4d5";
        //4
        if($data['rb4d5'] == 'm'){
            $templateProcessor->setValue('m4d5', "&#8730;");
            $templateProcessor->setValue('tm4d5', "");
            $templateProcessor->setValue('tr4d5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4d5'] == 'tm'){
            $templateProcessor->setValue('m4d5', "");
            $templateProcessor->setValue('tm4d5', "&#8730;");
            $templateProcessor->setValue('tr4d5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4d5'] == 'tr'){
            $templateProcessor->setValue('m4d5', "");
            $templateProcessor->setValue('tm4d5', "");
            $templateProcessor->setValue('tr4d5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4d5'] == null){
            $templateProcessor->setValue('ca4d5', "");
        }else{
            $templateProcessor->setValue('ca4d5', $data['ca4d5']);
            $model2->catatan_auditor = $data['ca4d5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5a";
        //5
        if($data['rb5a'] == 'm'){
            $templateProcessor->setValue('m5a', "&#8730;");
            $templateProcessor->setValue('tm5a', "");
            $templateProcessor->setValue('tr5a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5a'] == 'tm'){
            $templateProcessor->setValue('m5a', "");
            $templateProcessor->setValue('tm5a', "&#8730;");
            $templateProcessor->setValue('tr5a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5a'] == 'tr'){
            $templateProcessor->setValue('m5a', "");
            $templateProcessor->setValue('tm5a', "");
            $templateProcessor->setValue('tr5a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5a'] == null){
            $templateProcessor->setValue('ca5a', "");
        }else{
            $templateProcessor->setValue('ca5a', $data['ca5a']);
            $model2->catatan_auditor = $data['ca5a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5b";
        //5
        if($data['rb5b'] == 'm'){
            $templateProcessor->setValue('m5b', "&#8730;");
            $templateProcessor->setValue('tm5b', "");
            $templateProcessor->setValue('tr5b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5b'] == 'tm'){
            $templateProcessor->setValue('m5b', "");
            $templateProcessor->setValue('tm5b', "&#8730;");
            $templateProcessor->setValue('tr5b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5b'] == 'tr'){
            $templateProcessor->setValue('m5b', "");
            $templateProcessor->setValue('tm5b', "");
            $templateProcessor->setValue('tr5b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5b'] == null){
            $templateProcessor->setValue('ca5b', "");
        }else{
            $templateProcessor->setValue('ca5b', $data['ca5b']);
            $model2->catatan_auditor = $data['ca5b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5c";
        //5
        if($data['rb5c'] == 'm'){
            $templateProcessor->setValue('m5c', "&#8730;");
            $templateProcessor->setValue('tm5c', "");
            $templateProcessor->setValue('tr5c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5c'] == 'tm'){
            $templateProcessor->setValue('m5c', "");
            $templateProcessor->setValue('tm5c', "&#8730;");
            $templateProcessor->setValue('tr5c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5c'] == 'tr'){
            $templateProcessor->setValue('m5c', "");
            $templateProcessor->setValue('tm5c', "");
            $templateProcessor->setValue('tr5c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5c'] == null){
            $templateProcessor->setValue('ca5c', "");
        }else{
            $templateProcessor->setValue('ca5c', $data['ca5c']);
            $model2->catatan_auditor = $data['ca5c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5d";
        //5
        if($data['rb5d'] == 'm'){
            $templateProcessor->setValue('m5d', "&#8730;");
            $templateProcessor->setValue('tm5d', "");
            $templateProcessor->setValue('tr5d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5d'] == 'tm'){
            $templateProcessor->setValue('m5d', "");
            $templateProcessor->setValue('tm5d', "&#8730;");
            $templateProcessor->setValue('tr5d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5d'] == 'tr'){
            $templateProcessor->setValue('m5d', "");
            $templateProcessor->setValue('tm5d', "");
            $templateProcessor->setValue('tr5d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5d'] == null){
            $templateProcessor->setValue('ca5d', "");
        }else{
            $templateProcessor->setValue('ca5d', $data['ca5d']);
            $model2->catatan_auditor = $data['ca5d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
        $model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5e";
        //5
        if($data['rb5e'] == 'm'){
            $templateProcessor->setValue('m5e', "&#8730;");
            $templateProcessor->setValue('tm5e', "");
            $templateProcessor->setValue('tr5e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5e'] == 'tm'){
            $templateProcessor->setValue('m5e', "");
            $templateProcessor->setValue('tm5e', "&#8730;");
            $templateProcessor->setValue('tr5e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5e'] == 'tr'){
            $templateProcessor->setValue('m5e', "");
            $templateProcessor->setValue('tm5e', "");
            $templateProcessor->setValue('tr5e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5e'] == null){
            $templateProcessor->setValue('ca5e', "");
        }else{
            $templateProcessor->setValue('ca5e', $data['ca5e']);
            $model2->catatan_auditor = $data['ca5e'];
        }
        $model2->save();
        DB::commit();

        // DB::beginTransaction();        

        // if($data['kesimpulan'] == null){
        //     $templateProcessor->setValue('kesimpulan', "");
        // }else{
        //     $templateProcessor->setValue('kesimpulan', $data['kesimpulan']);
        //     $model->kesimpulan = $data['kesimpulan'];
        // }
        // $model->save();       
        // DB::commit();        
        
        $fileName = 'FOR-HALAL-OPS-09 Formulir Ceklist Audit ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs('storage/laporan/upload/Checklist Audit/Isian/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");

        $dataLaporan = DB::table('laporan_audit2')
            ->where('id_registrasi',$data['id_registrasi'])
            ->get();                                

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->form_checlist_isian = $fileName;                    
                    $model->id_registrasi = $data['id_registrasi'];                    
                    $model->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;                
                $f = $model2->find($dataLaporan[0]->id);
                $f->form_checlist_isian = $fileName;                
                $f->save();                
            }
            DB::Commit();
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                
        $this->LogKegiatan($data['id_registrasi'], Auth::user()->id, Auth::user()->name, 10, "Membuat Berkas Form Checklist Laporan Audit Tahap 2.", Auth::user()->usergroup_id);

        return response()->download('storage/laporan/upload/Checklist Audit/Isian/'.$fileName);
    }
    
    public function downloadLaporanAuditTahap2Backup(Request $request){
        $data = $request->except('_token','_method');

        dd($data);
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 

        $model = new LaporanAuditTahap2();             
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-05 Laporan Audit Tahap 2 Complete.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('tipe_audit', "Audit Tahap 2");        

        DB::beginTransaction();
        $model->id_user = Auth::user()->id;
        $model->id_registrasi = $data['id_registrasi'];
        $model->nomor_id = $data['nomor_id'];
        $model->skema_audit = $data['skema_audit'];
        $model->jenis_audit = $data['jenis_audit'];
        $model->no_audit = $data['no_audit'];
        $model->nama_perusahaan = $data['nama_perusahaan'];
        $model->alamat = $data['alamat'];
        $model->tanggal_audit = $data['tanggal_audit'];
        $model->tujuan_audit = $data['tujuan_audit'];
        $model->lingkup_audit = $data['lingkup_audit'];
        $model->jenis_produk = $data['jenis_produk'];
        $model->lokasi_audit1 = $data['lokasi_audit1'];
        $model->lokasi_audit2 = $data['lokasi_audit2'];
        $model->tim_audit1 = $data['tim_audit1'];
        $model->tim_audit2 = $data['tim_audit2'];
        // dd($data);
        
        $model->save();
        DB::commit();                   

        $id = DB::table('laporan_audit_tahap2')            
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idlap = $id_asli;
                }                
            }
        // dd($idlap);

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1a1";
        //1a
        if($data['rb1a1'] == 'm'){
            $templateProcessor->setValue('m1a1', "&#8730;");
            $templateProcessor->setValue('tm1a1', "");
            $templateProcessor->setValue('tr1a1', "");            

            $model2->status_kriteria = "m";
        }else if($data['rb1a1'] == 'tm'){
            $templateProcessor->setValue('m1a1', "");
            $templateProcessor->setValue('tm1a1', "&#8730;");
            $templateProcessor->setValue('tr1a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a1'] == 'tr'){
            $templateProcessor->setValue('m1a1', "");
            $templateProcessor->setValue('tm1a1', "");
            $templateProcessor->setValue('tr1a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a1'] == null){
            $templateProcessor->setValue('ca1a1', "");            
        }else{
            $templateProcessor->setValue('ca1a1', $data['ca1a1']);
            $model2->catatan_auditor = $data['ca1a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1a2";
        //1a
        if($data['rb1a2'] == 'm'){
            $templateProcessor->setValue('m1a2', "&#8730;");
            $templateProcessor->setValue('tm1a2', "");
            $templateProcessor->setValue('tr1a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a2'] == 'tm'){
            $templateProcessor->setValue('m1a2', "");
            $templateProcessor->setValue('tm1a2', "&#8730;");
            $templateProcessor->setValue('tr1a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a2'] == 'tr'){
            $templateProcessor->setValue('m1a2', "");
            $templateProcessor->setValue('tm1a2', "");
            $templateProcessor->setValue('tr1a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a2'] == null){
            $templateProcessor->setValue('ca1a2', "");
        }else{
            $templateProcessor->setValue('ca1a2', $data['ca1a2']);
            $model2->catatan_auditor = $data['ca1a2'];
        }
        $model2->save();
        DB::commit();        
        
        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1a3";
        //1a
        if($data['rb1a3'] == 'm'){
            $templateProcessor->setValue('m1a3', "&#8730;");
            $templateProcessor->setValue('tm1a3', "");
            $templateProcessor->setValue('tr1a3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a3'] == 'tm'){
            $templateProcessor->setValue('m1a3', "");
            $templateProcessor->setValue('tm1a3', "&#8730;");
            $templateProcessor->setValue('tr1a3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a3'] == 'tr'){
            $templateProcessor->setValue('m1a3', "");
            $templateProcessor->setValue('tm1a3', "");
            $templateProcessor->setValue('tr1a3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1a3'] == null){
            $templateProcessor->setValue('ca1a3', "");
        }else{
            $templateProcessor->setValue('ca1a3', $data['ca1a3']);
            $model2->catatan_auditor = $data['ca1a3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1a4";
        //1a
        if($data['rb1a4'] == 'm'){
            $templateProcessor->setValue('m1a4', "&#8730;");
            $templateProcessor->setValue('tm1a4', "");
            $templateProcessor->setValue('tr1a4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1a4'] == 'tm'){
            $templateProcessor->setValue('m1a4', "");
            $templateProcessor->setValue('tm1a4', "&#8730;");
            $templateProcessor->setValue('tr1a4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1a4'] == 'tr'){
            $templateProcessor->setValue('m1a4', "");
            $templateProcessor->setValue('tm1a4', "");
            $templateProcessor->setValue('tr1a4', "&#8730;");
            
            $model2->status_kriteria = "tr";
        }

        if($data['ca1a4'] == null){
            $templateProcessor->setValue('ca1a4', "");
        }else{
            $templateProcessor->setValue('ca1a4', $data['ca1a4']);
            $model2->catatan_auditor = $data['ca1a4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b1";
        //1b
        if($data['rb1b1'] == 'm'){
            $templateProcessor->setValue('m1b1', "&#8730;");
            $templateProcessor->setValue('tm1b1', "");
            $templateProcessor->setValue('tr1b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b1'] == 'tm'){
            $templateProcessor->setValue('m1b1', "");
            $templateProcessor->setValue('tm1b1', "&#8730;");
            $templateProcessor->setValue('tr1b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b1'] == 'tr'){
            $templateProcessor->setValue('m1b1', "");
            $templateProcessor->setValue('tm1b1', "");
            $templateProcessor->setValue('tr1b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b1'] == null){
            $templateProcessor->setValue('ca1b1', "");
        }else{
            $templateProcessor->setValue('ca1b1', $data['ca1b1']);
            $model2->catatan_auditor = $data['ca1b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b2";
        //1b
        if($data['rb1b2'] == 'm'){
            $templateProcessor->setValue('m1b2', "&#8730;");
            $templateProcessor->setValue('tm1b2', "");
            $templateProcessor->setValue('tr1b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b2'] == 'tm'){
            $templateProcessor->setValue('m1b2', "");
            $templateProcessor->setValue('tm1b2', "&#8730;");
            $templateProcessor->setValue('tr1b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b2'] == 'tr'){
            $templateProcessor->setValue('m1b2', "");
            $templateProcessor->setValue('tm1b2', "");
            $templateProcessor->setValue('tr1b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b2'] == null){
            $templateProcessor->setValue('ca1b2', "");
        }else{
            $templateProcessor->setValue('ca1b2', $data['ca1b2']);
            $model2->catatan_auditor = $data['ca1b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b3";
        //1b
        if($data['rb1b3'] == 'm'){
            $templateProcessor->setValue('m1b3', "&#8730;");
            $templateProcessor->setValue('tm1b3', "");
            $templateProcessor->setValue('tr1b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b3'] == 'tm'){
            $templateProcessor->setValue('m1b3', "");
            $templateProcessor->setValue('tm1b3', "&#8730;");
            $templateProcessor->setValue('tr1b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b3'] == 'tr'){
            $templateProcessor->setValue('m1b3', "");
            $templateProcessor->setValue('tm1b3', "");
            $templateProcessor->setValue('tr1b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b3'] == null){
            $templateProcessor->setValue('ca1b3', "");
        }else{
            $templateProcessor->setValue('ca1b3', $data['ca1b3']);
            $model2->catatan_auditor = $data['ca1b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b4";
        //1b
        if($data['rb1b4'] == 'm'){
            $templateProcessor->setValue('m1b4', "&#8730;");
            $templateProcessor->setValue('tm1b4', "");
            $templateProcessor->setValue('tr1b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b4'] == 'tm'){
            $templateProcessor->setValue('m1b4', "");
            $templateProcessor->setValue('tm1b4', "&#8730;");
            $templateProcessor->setValue('tr1b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b4'] == 'tr'){
            $templateProcessor->setValue('m1b4', "");
            $templateProcessor->setValue('tm1b4', "");
            $templateProcessor->setValue('tr1b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b4'] == null){
            $templateProcessor->setValue('ca1b4', "");
        }else{
            $templateProcessor->setValue('ca1b4', $data['ca1b4']);
            $model2->catatan_auditor = $data['ca1b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b5";
        //1b
        if($data['rb1b5'] == 'm'){
            $templateProcessor->setValue('m1b5', "&#8730;");
            $templateProcessor->setValue('tm1b5', "");
            $templateProcessor->setValue('tr1b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b5'] == 'tm'){
            $templateProcessor->setValue('m1b5', "");
            $templateProcessor->setValue('tm1b5', "&#8730;");
            $templateProcessor->setValue('tr1b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b5'] == 'tr'){
            $templateProcessor->setValue('m1b5', "");
            $templateProcessor->setValue('tm1b5', "");
            $templateProcessor->setValue('tr1b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b5'] == null){
            $templateProcessor->setValue('ca1b5', "");
        }else{
            $templateProcessor->setValue('ca1b5', $data['ca1b5']);
            $model2->catatan_auditor = $data['ca1b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1b6";
        //1b
        if($data['rb1b6'] == 'm'){
            $templateProcessor->setValue('m1b6', "&#8730;");
            $templateProcessor->setValue('tm1b6', "");
            $templateProcessor->setValue('tr1b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1b6'] == 'tm'){
            $templateProcessor->setValue('m1b6', "");
            $templateProcessor->setValue('tm1b6', "&#8730;");
            $templateProcessor->setValue('tr1b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1b6'] == 'tr'){
            $templateProcessor->setValue('m1b6', "");
            $templateProcessor->setValue('tm1b6', "");
            $templateProcessor->setValue('tr1b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1b6'] == null){
            $templateProcessor->setValue('ca1b6', "");
        }else{
            $templateProcessor->setValue('ca1b6', $data['ca1b6']);
            $model2->catatan_auditor = $data['ca1b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c1";
        //1c
        if($data['rb1c1'] == 'm'){
            $templateProcessor->setValue('m1c1', "&#8730;");
            $templateProcessor->setValue('tm1c1', "");
            $templateProcessor->setValue('tr1c1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c1'] == 'tm'){
            $templateProcessor->setValue('m1c1', "");
            $templateProcessor->setValue('tm1c1', "&#8730;");
            $templateProcessor->setValue('tr1c1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c1'] == 'tr'){
            $templateProcessor->setValue('m1c1', "");
            $templateProcessor->setValue('tm1c1', "");
            $templateProcessor->setValue('tr1c1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c1'] == null){
            $templateProcessor->setValue('ca1c1', "");
        }else{
            $templateProcessor->setValue('ca1c1', $data['ca1c1']);
            $model2->catatan_auditor = $data['ca1c1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c2";
        //1c
        if($data['rb1c2'] == 'm'){
            $templateProcessor->setValue('m1c2', "&#8730;");
            $templateProcessor->setValue('tm1c2', "");
            $templateProcessor->setValue('tr1c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c2'] == 'tm'){
            $templateProcessor->setValue('m1c2', "");
            $templateProcessor->setValue('tm1c2', "&#8730;");
            $templateProcessor->setValue('tr1c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c2'] == 'tr'){
            $templateProcessor->setValue('m1c2', "");
            $templateProcessor->setValue('tm1c2', "");
            $templateProcessor->setValue('tr1c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c2'] == null){
            $templateProcessor->setValue('ca1c2', "");
        }else{
            $templateProcessor->setValue('ca1c2', $data['ca1c2']);
            $model2->catatan_auditor = $data['ca1c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c3";
        //1c
        if($data['rb1c3'] == 'm'){
            $templateProcessor->setValue('m1c3', "&#8730;");
            $templateProcessor->setValue('tm1c3', "");
            $templateProcessor->setValue('tr1c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c3'] == 'tm'){
            $templateProcessor->setValue('m1c3', "");
            $templateProcessor->setValue('tm1c3', "&#8730;");
            $templateProcessor->setValue('tr1c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c3'] == 'tr'){
            $templateProcessor->setValue('m1c3', "");
            $templateProcessor->setValue('tm1c3', "");
            $templateProcessor->setValue('tr1c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c3'] == null){
            $templateProcessor->setValue('ca1c3', "");
        }else{
            $templateProcessor->setValue('ca1c3', $data['ca1c3']);
            $model2->catatan_auditor = $data['ca1c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "1c4";
        //1c
        if($data['rb1c4'] == 'm'){
            $templateProcessor->setValue('m1c4', "&#8730;");
            $templateProcessor->setValue('tm1c4', "");
            $templateProcessor->setValue('tr1c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb1c4'] == 'tm'){
            $templateProcessor->setValue('m1c4', "");
            $templateProcessor->setValue('tm1c4', "&#8730;");
            $templateProcessor->setValue('tr1c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb1c4'] == 'tr'){
            $templateProcessor->setValue('m1c4', "");
            $templateProcessor->setValue('tm1c4', "");
            $templateProcessor->setValue('tr1c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca1c4'] == null){
            $templateProcessor->setValue('ca1c4', "");
        }else{
            $templateProcessor->setValue('ca1c4', $data['ca1c4']);
            $model2->catatan_auditor = $data['ca1c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "21";
        //2
        if($data['rb21'] == 'm'){
            $templateProcessor->setValue('m21', "&#8730;");
            $templateProcessor->setValue('tm21', "");
            $templateProcessor->setValue('tr21', "");

            $model2->status_kriteria = "m";
        }else if($data['rb21'] == 'tm'){
            $templateProcessor->setValue('m21', "");
            $templateProcessor->setValue('tm21', "&#8730;");
            $templateProcessor->setValue('tr21', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb21'] == 'tr'){
            $templateProcessor->setValue('m21', "");
            $templateProcessor->setValue('tm21', "");
            $templateProcessor->setValue('tr21', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca21'] == null){
            $templateProcessor->setValue('ca21', "");
        }else{
            $templateProcessor->setValue('ca21', $data['ca21']);
            $model2->catatan_auditor = $data['ca21'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "22";
        //2
        if($data['rb22'] == 'm'){
            $templateProcessor->setValue('m22', "&#8730;");
            $templateProcessor->setValue('tm22', "");
            $templateProcessor->setValue('tr22', "");

            $model2->status_kriteria = "m";
        }else if($data['rb22'] == 'tm'){
            $templateProcessor->setValue('m22', "");
            $templateProcessor->setValue('tm22', "&#8730;");
            $templateProcessor->setValue('tr22', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb22'] == 'tr'){
            $templateProcessor->setValue('m22', "");
            $templateProcessor->setValue('tm22', "");
            $templateProcessor->setValue('tr22', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca22'] == null){
            $templateProcessor->setValue('ca22', "");
        }else{
            $templateProcessor->setValue('ca22', $data['ca22']);
            $model2->catatan_auditor = $data['ca22'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "23";
        //2
        if($data['rb23'] == 'm'){
            $templateProcessor->setValue('m23', "&#8730;");
            $templateProcessor->setValue('tm23', "");
            $templateProcessor->setValue('tr23', "");

            $model2->status_kriteria = "m";
        }else if($data['rb23'] == 'tm'){
            $templateProcessor->setValue('m23', "");
            $templateProcessor->setValue('tm23', "&#8730;");
            $templateProcessor->setValue('tr23', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb23'] == 'tr'){
            $templateProcessor->setValue('m23', "");
            $templateProcessor->setValue('tm23', "");
            $templateProcessor->setValue('tr23', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca23'] == null){
            $templateProcessor->setValue('ca23', "");
        }else{
            $templateProcessor->setValue('ca23', $data['ca23']);
            $model2->catatan_auditor = $data['ca23'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "24";
        //2
        if($data['rb24'] == 'm'){
            $templateProcessor->setValue('m24', "&#8730;");
            $templateProcessor->setValue('tm24', "");
            $templateProcessor->setValue('tr24', "");

            $model2->status_kriteria = "m";
        }else if($data['rb24'] == 'tm'){
            $templateProcessor->setValue('m24', "");
            $templateProcessor->setValue('tm24', "&#8730;");
            $templateProcessor->setValue('tr24', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb24'] == 'tr'){
            $templateProcessor->setValue('m24', "");
            $templateProcessor->setValue('tm24', "");
            $templateProcessor->setValue('tr24', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca24'] == null){
            $templateProcessor->setValue('ca24', "");
        }else{
            $templateProcessor->setValue('ca24', $data['ca24']);
            $model2->catatan_auditor = $data['ca24'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a1";
        //3
        if($data['rb3a1'] == 'm'){
            $templateProcessor->setValue('m3a1', "&#8730;");
            $templateProcessor->setValue('tm3a1', "");
            $templateProcessor->setValue('tr3a1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a1'] == 'tm'){
            $templateProcessor->setValue('m3a1', "");
            $templateProcessor->setValue('tm3a1', "&#8730;");
            $templateProcessor->setValue('tr3a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a1'] == 'tr'){
            $templateProcessor->setValue('m3a1', "");
            $templateProcessor->setValue('tm3a1', "");
            $templateProcessor->setValue('tr3a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a1'] == null){
            $templateProcessor->setValue('ca3a1', "");
        }else{
            $templateProcessor->setValue('ca3a1', $data['ca3a1']);
            $model2->catatan_auditor = $data['ca3a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a2";
        //3
        if($data['rb3a2'] == 'm'){
            $templateProcessor->setValue('m3a2', "&#8730;");
            $templateProcessor->setValue('tm3a2', "");
            $templateProcessor->setValue('tr3a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a2'] == 'tm'){
            $templateProcessor->setValue('m3a2', "");
            $templateProcessor->setValue('tm3a2', "&#8730;");
            $templateProcessor->setValue('tr3a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a2'] == 'tr'){
            $templateProcessor->setValue('m3a2', "");
            $templateProcessor->setValue('tm3a2', "");
            $templateProcessor->setValue('tr3a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a2'] == null){
            $templateProcessor->setValue('ca3a2', "");
        }else{
            $templateProcessor->setValue('ca3a2', $data['ca3a2']);
            $model2->catatan_auditor = $data['ca3a2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a3";
        //3
        if($data['rb3a3'] == 'm'){
            $templateProcessor->setValue('m3a3', "&#8730;");
            $templateProcessor->setValue('tm3a3', "");
            $templateProcessor->setValue('tr3a3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a3'] == 'tm'){
            $templateProcessor->setValue('m3a3', "");
            $templateProcessor->setValue('tm3a3', "&#8730;");
            $templateProcessor->setValue('tr3a3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a3'] == 'tr'){
            $templateProcessor->setValue('m3a3', "");
            $templateProcessor->setValue('tm3a3', "");
            $templateProcessor->setValue('tr3a3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a3'] == null){
            $templateProcessor->setValue('ca3a3', "");
        }else{
            $templateProcessor->setValue('ca3a3', $data['ca3a3']);
            $model2->catatan_auditor = $data['ca3a3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a4";
        //3
        if($data['rb3a4'] == 'm'){
            $templateProcessor->setValue('m3a4', "&#8730;");
            $templateProcessor->setValue('tm3a4', "");
            $templateProcessor->setValue('tr3a4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a4'] == 'tm'){
            $templateProcessor->setValue('m3a4', "");
            $templateProcessor->setValue('tm3a4', "&#8730;");
            $templateProcessor->setValue('tr3a4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a4'] == 'tr'){
            $templateProcessor->setValue('m3a4', "");
            $templateProcessor->setValue('tm3a4', "");
            $templateProcessor->setValue('tr3a4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a4'] == null){
            $templateProcessor->setValue('ca3a4', "");
        }else{
            $templateProcessor->setValue('ca3a4', $data['ca3a4']);
            $model2->catatan_auditor = $data['ca3a4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a5";
        //3
        if($data['rb3a5'] == 'm'){
            $templateProcessor->setValue('m3a5', "&#8730;");
            $templateProcessor->setValue('tm3a5', "");
            $templateProcessor->setValue('tr3a5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a5'] == 'tm'){
            $templateProcessor->setValue('m3a5', "");
            $templateProcessor->setValue('tm3a5', "&#8730;");
            $templateProcessor->setValue('tr3a5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a5'] == 'tr'){
            $templateProcessor->setValue('m3a5', "");
            $templateProcessor->setValue('tm3a5', "");
            $templateProcessor->setValue('tr3a5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a5'] == null){
            $templateProcessor->setValue('ca3a5', "");
        }else{
            $templateProcessor->setValue('ca3a5', $data['ca3a5']);
            $model2->catatan_auditor = $data['ca3a5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a6";
        //3
        if($data['rb3a6'] == 'm'){
            $templateProcessor->setValue('m3a6', "&#8730;");
            $templateProcessor->setValue('tm3a6', "");
            $templateProcessor->setValue('tr3a6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a6'] == 'tm'){
            $templateProcessor->setValue('m3a6', "");
            $templateProcessor->setValue('tm3a6', "&#8730;");
            $templateProcessor->setValue('tr3a6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a6'] == 'tr'){
            $templateProcessor->setValue('m3a6', "");
            $templateProcessor->setValue('tm3a6', "");
            $templateProcessor->setValue('tr3a6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a6'] == null){
            $templateProcessor->setValue('ca3a6', "");
        }else{
            $templateProcessor->setValue('ca3a6', $data['ca3a6']);
            $model2->catatan_auditor = $data['ca3a6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a7a";
        //3
        if($data['rb3a7a'] == 'm'){
            $templateProcessor->setValue('m3a7a', "&#8730;");
            $templateProcessor->setValue('tm3a7a', "");
            $templateProcessor->setValue('tr3a7a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7a'] == 'tm'){
            $templateProcessor->setValue('m3a7a', "");
            $templateProcessor->setValue('tm3a7a', "&#8730;");
            $templateProcessor->setValue('tr3a7a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7a'] == 'tr'){
            $templateProcessor->setValue('m3a7a', "");
            $templateProcessor->setValue('tm3a7a', "");
            $templateProcessor->setValue('tr3a7a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7a'] == null){
            $templateProcessor->setValue('ca3a7a', "");
        }else{
            $templateProcessor->setValue('ca3a7a', $data['ca3a7a']);
            $model2->catatan_auditor = $data['ca3a7a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a7b";
        //3
        if($data['rb3a7b'] == 'm'){
            $templateProcessor->setValue('m3a7b', "&#8730;");
            $templateProcessor->setValue('tm3a7b', "");
            $templateProcessor->setValue('tr3a7b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7b'] == 'tm'){
            $templateProcessor->setValue('m3a7b', "");
            $templateProcessor->setValue('tm3a7b', "&#8730;");
            $templateProcessor->setValue('tr3a7b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7b'] == 'tr'){
            $templateProcessor->setValue('m3a7b', "");
            $templateProcessor->setValue('tm3a7b', "");
            $templateProcessor->setValue('tr3a7b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7b'] == null){
            $templateProcessor->setValue('ca3a7b', "");
        }else{
            $templateProcessor->setValue('ca3a7b', $data['ca3a7b']);
            $model2->catatan_auditor = $data['ca3a7b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a7c";
        //3
        if($data['rb3a7c'] == 'm'){
            $templateProcessor->setValue('m3a7c', "&#8730;");
            $templateProcessor->setValue('tm3a7c', "");
            $templateProcessor->setValue('tr3a7c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a7c'] == 'tm'){
            $templateProcessor->setValue('m3a7c', "");
            $templateProcessor->setValue('tm3a7c', "&#8730;");
            $templateProcessor->setValue('tr3a7c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a7c'] == 'tr'){
            $templateProcessor->setValue('m3a7c', "");
            $templateProcessor->setValue('tm3a7c', "");
            $templateProcessor->setValue('tr3a7c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a7c'] == null){
            $templateProcessor->setValue('ca3a7c', "");
        }else{
            $templateProcessor->setValue('ca3a7c', $data['ca3a7c']);
            $model2->catatan_auditor = $data['ca3a7c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a8";
        //3
        if($data['rb3a8'] == 'm'){
            $templateProcessor->setValue('m3a8', "&#8730;");
            $templateProcessor->setValue('tm3a8', "");
            $templateProcessor->setValue('tr3a8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a8'] == 'tm'){
            $templateProcessor->setValue('m3a8', "");
            $templateProcessor->setValue('tm3a8', "&#8730;");
            $templateProcessor->setValue('tr3a8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a8'] == 'tr'){
            $templateProcessor->setValue('m3a8', "");
            $templateProcessor->setValue('tm3a8', "");
            $templateProcessor->setValue('tr3a8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a8'] == null){
            $templateProcessor->setValue('ca3a8', "");
        }else{
            $templateProcessor->setValue('ca3a8', $data['ca3a8']);
            $model2->catatan_auditor = $data['ca3a8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a9";
        //3
        if($data['rb3a9'] == 'm'){
            $templateProcessor->setValue('m3a9', "&#8730;");
            $templateProcessor->setValue('tm3a9', "");
            $templateProcessor->setValue('tr3a9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a9'] == 'tm'){
            $templateProcessor->setValue('m3a9', "");
            $templateProcessor->setValue('tm3a9', "&#8730;");
            $templateProcessor->setValue('tr3a9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a9'] == 'tr'){
            $templateProcessor->setValue('m3a9', "");
            $templateProcessor->setValue('tm3a9', "");
            $templateProcessor->setValue('tr3a9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a9'] == null){
            $templateProcessor->setValue('ca3a9', "");
        }else{
            $templateProcessor->setValue('ca3a9', $data['ca3a9']);
            $model2->catatan_auditor = $data['ca3a9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a10";
        //3
        if($data['rb3a10'] == 'm'){
            $templateProcessor->setValue('m3a10', "&#8730;");
            $templateProcessor->setValue('tm3a10', "");
            $templateProcessor->setValue('tr3a10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a10'] == 'tm'){
            $templateProcessor->setValue('m3a10', "");
            $templateProcessor->setValue('tm3a10', "&#8730;");
            $templateProcessor->setValue('tr3a10', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a10'] == 'tr'){
            $templateProcessor->setValue('m3a10', "");
            $templateProcessor->setValue('tm3a10', "");
            $templateProcessor->setValue('tr3a10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a10'] == null){
            $templateProcessor->setValue('ca3a10', "");
        }else{
            $templateProcessor->setValue('ca3a10', $data['ca3a10']);
            $model2->catatan_auditor = $data['ca3a10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a11";
        //3
        if($data['rb3a11'] == 'm'){
            $templateProcessor->setValue('m3a11', "&#8730;");
            $templateProcessor->setValue('tm3a11', "");
            $templateProcessor->setValue('tr3a11', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a11'] == 'tm'){
            $templateProcessor->setValue('m3a11', "");
            $templateProcessor->setValue('tm3a11', "&#8730;");
            $templateProcessor->setValue('tr3a11', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a11'] == 'tr'){
            $templateProcessor->setValue('m3a11', "");
            $templateProcessor->setValue('tm3a11', "");
            $templateProcessor->setValue('tr3a11', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a11'] == null){
            $templateProcessor->setValue('ca3a11', "");
        }else{
            $templateProcessor->setValue('ca3a11', $data['ca3a11']);
            $model2->catatan_auditor = $data['ca3a11'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a12";
        //3
        if($data['rb3a12'] == 'm'){
            $templateProcessor->setValue('m3a12', "&#8730;");
            $templateProcessor->setValue('tm3a12', "");
            $templateProcessor->setValue('tr3a12', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a12'] == 'tm'){
            $templateProcessor->setValue('m3a12', "");
            $templateProcessor->setValue('tm3a12', "&#8730;");
            $templateProcessor->setValue('tr3a12', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a12'] == 'tr'){
            $templateProcessor->setValue('m3a12', "");
            $templateProcessor->setValue('tm3a12', "");
            $templateProcessor->setValue('tr3a12', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a12'] == null){
            $templateProcessor->setValue('ca3a12', "");
        }else{
            $templateProcessor->setValue('ca3a12', $data['ca3a12']);
            $model2->catatan_auditor = $data['ca3a12'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a13";
        //3
        if($data['rb3a13'] == 'm'){
            $templateProcessor->setValue('m3a13', "&#8730;");
            $templateProcessor->setValue('tm3a13', "");
            $templateProcessor->setValue('tr3a13', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a13'] == 'tm'){
            $templateProcessor->setValue('m3a13', "");
            $templateProcessor->setValue('tm3a13', "&#8730;");
            $templateProcessor->setValue('tr3a13', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a13'] == 'tr'){
            $templateProcessor->setValue('m3a13', "");
            $templateProcessor->setValue('tm3a13', "");
            $templateProcessor->setValue('tr3a13', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a13'] == null){
            $templateProcessor->setValue('ca3a13', "");
        }else{
            $templateProcessor->setValue('ca3a13', $data['ca3a13']);
            $model2->catatan_auditor = $data['ca3a13'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a14";
        //3
        if($data['rb3a14'] == 'm'){
            $templateProcessor->setValue('m3a14', "&#8730;");
            $templateProcessor->setValue('tm3a14', "");
            $templateProcessor->setValue('tr3a14', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a14'] == 'tm'){
            $templateProcessor->setValue('m3a14', "");
            $templateProcessor->setValue('tm3a14', "&#8730;");
            $templateProcessor->setValue('tr3a14', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a14'] == 'tr'){
            $templateProcessor->setValue('m3a14', "");
            $templateProcessor->setValue('tm3a14', "");
            $templateProcessor->setValue('tr3a14', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a14'] == null){
            $templateProcessor->setValue('ca3a14', "");
        }else{
            $templateProcessor->setValue('ca3a14', $data['ca3a14']);
            $model2->catatan_auditor = $data['ca3a14'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a15";
        //3
        if($data['rb3a15'] == 'm'){
            $templateProcessor->setValue('m3a15', "&#8730;");
            $templateProcessor->setValue('tm3a15', "");
            $templateProcessor->setValue('tr3a15', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a15'] == 'tm'){
            $templateProcessor->setValue('m3a15', "");
            $templateProcessor->setValue('tm3a15', "&#8730;");
            $templateProcessor->setValue('tr3a15', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a15'] == 'tr'){
            $templateProcessor->setValue('m3a15', "");
            $templateProcessor->setValue('tm3a15', "");
            $templateProcessor->setValue('tr3a15', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a15'] == null){
            $templateProcessor->setValue('ca3a15', "");
        }else{
            $templateProcessor->setValue('ca3a15', $data['ca3a15']);
            $model2->catatan_auditor = $data['ca3a15'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a16";
        //3
        if($data['rb3a16'] == 'm'){
            $templateProcessor->setValue('m3a16', "&#8730;");
            $templateProcessor->setValue('tm3a16', "");
            $templateProcessor->setValue('tr3a16', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a16'] == 'tm'){
            $templateProcessor->setValue('m3a16', "");
            $templateProcessor->setValue('tm3a16', "&#8730;");
            $templateProcessor->setValue('tr3a16', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a16'] == 'tr'){
            $templateProcessor->setValue('m3a16', "");
            $templateProcessor->setValue('tm3a16', "");
            $templateProcessor->setValue('tr3a16', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a16'] == null){
            $templateProcessor->setValue('ca3a16', "");
        }else{
            $templateProcessor->setValue('ca3a16', $data['ca3a16']);
            $model2->catatan_auditor = $data['ca3a16'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a17";
        //3
        if($data['rb3a17'] == 'm'){
            $templateProcessor->setValue('m3a17', "&#8730;");
            $templateProcessor->setValue('tm3a17', "");
            $templateProcessor->setValue('tr3a17', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a17'] == 'tm'){
            $templateProcessor->setValue('m3a17', "");
            $templateProcessor->setValue('tm3a17', "&#8730;");
            $templateProcessor->setValue('tr3a17', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a17'] == 'tr'){
            $templateProcessor->setValue('m3a17', "");
            $templateProcessor->setValue('tm3a17', "");
            $templateProcessor->setValue('tr3a17', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a17'] == null){
            $templateProcessor->setValue('ca3a17', "");
        }else{
            $templateProcessor->setValue('ca3a17', $data['ca3a17']);
            $model2->catatan_auditor = $data['ca3a17'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a18";
        //3
        if($data['rb3a18'] == 'm'){
            $templateProcessor->setValue('m3a18', "&#8730;");
            $templateProcessor->setValue('tm3a18', "");
            $templateProcessor->setValue('tr3a18', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a18'] == 'tm'){
            $templateProcessor->setValue('m3a18', "");
            $templateProcessor->setValue('tm3a18', "&#8730;");
            $templateProcessor->setValue('tr3a18', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a18'] == 'tr'){
            $templateProcessor->setValue('m3a18', "");
            $templateProcessor->setValue('tm3a18', "");
            $templateProcessor->setValue('tr3a18', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a18'] == null){
            $templateProcessor->setValue('ca3a18', "");
        }else{
            $templateProcessor->setValue('ca3a18', $data['ca3a18']);
            $model2->catatan_auditor = $data['ca3a18'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3a19";
        //3
        if($data['rb3a19'] == 'm'){
            $templateProcessor->setValue('m3a19', "&#8730;");
            $templateProcessor->setValue('tm3a19', "");
            $templateProcessor->setValue('tr3a19', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3a19'] == 'tm'){
            $templateProcessor->setValue('m3a19', "");
            $templateProcessor->setValue('tm3a19', "&#8730;");
            $templateProcessor->setValue('tr3a19', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3a19'] == 'tr'){
            $templateProcessor->setValue('m3a19', "");
            $templateProcessor->setValue('tm3a19', "");
            $templateProcessor->setValue('tr3a19', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3a19'] == null){
            $templateProcessor->setValue('ca3a19', "");
        }else{
            $templateProcessor->setValue('ca3a19', $data['ca3a19']);
            $model2->catatan_auditor = $data['ca3a19'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b1";
        //3
        if($data['rb3b1'] == 'm'){
            $templateProcessor->setValue('m3b1', "&#8730;");
            $templateProcessor->setValue('tm3b1', "");
            $templateProcessor->setValue('tr3b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b1'] == 'tm'){
            $templateProcessor->setValue('m3b1', "");
            $templateProcessor->setValue('tm3b1', "&#8730;");
            $templateProcessor->setValue('tr3b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b1'] == 'tr'){
            $templateProcessor->setValue('m3b1', "");
            $templateProcessor->setValue('tm3b1', "");
            $templateProcessor->setValue('tr3b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b1'] == null){
            $templateProcessor->setValue('ca3b1', "");
        }else{
            $templateProcessor->setValue('ca3b1', $data['ca3b1']);
            $model2->catatan_auditor = $data['ca3b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b2";
        //3
        if($data['rb3b2'] == 'm'){
            $templateProcessor->setValue('m3b2', "&#8730;");
            $templateProcessor->setValue('tm3b2', "");
            $templateProcessor->setValue('tr3b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b2'] == 'tm'){
            $templateProcessor->setValue('m3b2', "");
            $templateProcessor->setValue('tm3b2', "&#8730;");
            $templateProcessor->setValue('tr3b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b2'] == 'tr'){
            $templateProcessor->setValue('m3b2', "");
            $templateProcessor->setValue('tm3b2', "");
            $templateProcessor->setValue('tr3b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b2'] == null){
            $templateProcessor->setValue('ca3b2', "");
        }else{
            $templateProcessor->setValue('ca3b2', $data['ca3b2']);
            $model2->catatan_auditor = $data['ca3b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b3";
        //3
        if($data['rb3b3'] == 'm'){
            $templateProcessor->setValue('m3b3', "&#8730;");
            $templateProcessor->setValue('tm3b3', "");
            $templateProcessor->setValue('tr3b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b3'] == 'tm'){
            $templateProcessor->setValue('m3b3', "");
            $templateProcessor->setValue('tm3b3', "&#8730;");
            $templateProcessor->setValue('tr3b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b3'] == 'tr'){
            $templateProcessor->setValue('m3b3', "");
            $templateProcessor->setValue('tm3b3', "");
            $templateProcessor->setValue('tr3b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b3'] == null){
            $templateProcessor->setValue('ca3b3', "");
        }else{
            $templateProcessor->setValue('ca3b3', $data['ca3b3']);
            $model2->catatan_auditor = $data['ca3b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b4";
        //3
        if($data['rb3b4'] == 'm'){
            $templateProcessor->setValue('m3b4', "&#8730;");
            $templateProcessor->setValue('tm3b4', "");
            $templateProcessor->setValue('tr3b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b4'] == 'tm'){
            $templateProcessor->setValue('m3b4', "");
            $templateProcessor->setValue('tm3b4', "&#8730;");
            $templateProcessor->setValue('tr3b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b4'] == 'tr'){
            $templateProcessor->setValue('m3b4', "");
            $templateProcessor->setValue('tm3b4', "");
            $templateProcessor->setValue('tr3b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b4'] == null){
            $templateProcessor->setValue('ca3b4', "");
        }else{
            $templateProcessor->setValue('ca3b4', $data['ca3b4']);
            $model2->catatan_auditor = $data['ca3b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b5";
        //3
        if($data['rb3b5'] == 'm'){
            $templateProcessor->setValue('m3b5', "&#8730;");
            $templateProcessor->setValue('tm3b5', "");
            $templateProcessor->setValue('tr3b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b5'] == 'tm'){
            $templateProcessor->setValue('m3b5', "");
            $templateProcessor->setValue('tm3b5', "&#8730;");
            $templateProcessor->setValue('tr3b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b5'] == 'tr'){
            $templateProcessor->setValue('m3b5', "");
            $templateProcessor->setValue('tm3b5', "");
            $templateProcessor->setValue('tr3b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b5'] == null){
            $templateProcessor->setValue('ca3b5', "");
        }else{
            $templateProcessor->setValue('ca3b5', $data['ca3b5']);
            $model2->catatan_auditor = $data['ca3b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b6";
        //3
        if($data['rb3b6'] == 'm'){
            $templateProcessor->setValue('m3b6', "&#8730;");
            $templateProcessor->setValue('tm3b6', "");
            $templateProcessor->setValue('tr3b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b6'] == 'tm'){
            $templateProcessor->setValue('m3b6', "");
            $templateProcessor->setValue('tm3b6', "&#8730;");
            $templateProcessor->setValue('tr3b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b6'] == 'tr'){
            $templateProcessor->setValue('m3b6', "");
            $templateProcessor->setValue('tm3b6', "");
            $templateProcessor->setValue('tr3b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b6'] == null){
            $templateProcessor->setValue('ca3b6', "");
        }else{
            $templateProcessor->setValue('ca3b6', $data['ca3b6']);
            $model2->catatan_auditor = $data['ca3b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b7";
        //3
        if($data['rb3b7'] == 'm'){
            $templateProcessor->setValue('m3b7', "&#8730;");
            $templateProcessor->setValue('tm3b7', "");
            $templateProcessor->setValue('tr3b7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b7'] == 'tm'){
            $templateProcessor->setValue('m3b7', "");
            $templateProcessor->setValue('tm3b7', "&#8730;");
            $templateProcessor->setValue('tr3b7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b7'] == 'tr'){
            $templateProcessor->setValue('m3b7', "");
            $templateProcessor->setValue('tm3b7', "");
            $templateProcessor->setValue('tr3b7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b7'] == null){
            $templateProcessor->setValue('ca3b7', "");
        }else{
            $templateProcessor->setValue('ca3b7', $data['ca3b7']);
            $model2->catatan_auditor = $data['ca3b7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b8";
        //3
        if($data['rb3b8'] == 'm'){
            $templateProcessor->setValue('m3b8', "&#8730;");
            $templateProcessor->setValue('tm3b8', "");
            $templateProcessor->setValue('tr3b8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b8'] == 'tm'){
            $templateProcessor->setValue('m3b8', "");
            $templateProcessor->setValue('tm3b8', "&#8730;");
            $templateProcessor->setValue('tr3b8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b8'] == 'tr'){
            $templateProcessor->setValue('m3b8', "");
            $templateProcessor->setValue('tm3b8', "");
            $templateProcessor->setValue('tr3b8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b8'] == null){
            $templateProcessor->setValue('ca3b8', "");
        }else{
            $templateProcessor->setValue('ca3b8', $data['ca3b8']);
            $model2->catatan_auditor = $data['ca3b8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b9";
        //3
        if($data['rb3b9'] == 'm'){
            $templateProcessor->setValue('m3b9', "&#8730;");
            $templateProcessor->setValue('tm3b9', "");
            $templateProcessor->setValue('tr3b9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b9'] == 'tm'){
            $templateProcessor->setValue('m3b9', "");
            $templateProcessor->setValue('tm3b9', "&#8730;");
            $templateProcessor->setValue('tr3b9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b9'] == 'tr'){
            $templateProcessor->setValue('m3b9', "");
            $templateProcessor->setValue('tm3b9', "");
            $templateProcessor->setValue('tr3b9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b9'] == null){
            $templateProcessor->setValue('ca3b9', "");
        }else{
            $templateProcessor->setValue('ca3b9', $data['ca3b9']);
            $model2->catatan_auditor = $data['ca3b9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b10";
        //3
        if($data['rb3b10'] == 'm'){
            $templateProcessor->setValue('m3b10', "&#8730;");
            $templateProcessor->setValue('tm3b10', "");
            $templateProcessor->setValue('tr3b10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b10'] == 'tm'){
            $templateProcessor->setValue('m3b10', "");
            $templateProcessor->setValue('tm3b10', "&#8730;");
            $templateProcessor->setValue('tr3b10', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b10'] == 'tr'){
            $templateProcessor->setValue('m3b10', "");
            $templateProcessor->setValue('tm3b10', "");
            $templateProcessor->setValue('tr3b10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b10'] == null){
            $templateProcessor->setValue('ca3b10', "");
        }else{
            $templateProcessor->setValue('ca3b10', $data['ca3b10']);
            $model2->catatan_auditor = $data['ca3b10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b11";
        //3
        if($data['rb3b11'] == 'm'){
            $templateProcessor->setValue('m3b11', "&#8730;");
            $templateProcessor->setValue('tm3b11', "");
            $templateProcessor->setValue('tr3b11', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b11'] == 'tm'){
            $templateProcessor->setValue('m3b11', "");
            $templateProcessor->setValue('tm3b11', "&#8730;");
            $templateProcessor->setValue('tr3b11', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b11'] == 'tr'){
            $templateProcessor->setValue('m3b11', "");
            $templateProcessor->setValue('tm3b11', "");
            $templateProcessor->setValue('tr3b11', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b11'] == null){
            $templateProcessor->setValue('ca3b11', "");
        }else{
            $templateProcessor->setValue('ca3b11', $data['ca3b11']);
            $model2->catatan_auditor = $data['ca3b11'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b12";
        //3
        if($data['rb3b12'] == 'm'){
            $templateProcessor->setValue('m3b12', "&#8730;");
            $templateProcessor->setValue('tm3b12', "");
            $templateProcessor->setValue('tr3b12', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b12'] == 'tm'){
            $templateProcessor->setValue('m3b12', "");
            $templateProcessor->setValue('tm3b12', "&#8730;");
            $templateProcessor->setValue('tr3b12', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b12'] == 'tr'){
            $templateProcessor->setValue('m3b12', "");
            $templateProcessor->setValue('tm3b12', "");
            $templateProcessor->setValue('tr3b12', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b12'] == null){
            $templateProcessor->setValue('ca3b12', "");
        }else{
            $templateProcessor->setValue('ca3b12', $data['ca3b12']);
            $model2->catatan_auditor = $data['ca3b12'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3b13";
        //3
        if($data['rb3b13'] == 'm'){
            $templateProcessor->setValue('m3b13', "&#8730;");
            $templateProcessor->setValue('tm3b13', "");
            $templateProcessor->setValue('tr3b13', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3b13'] == 'tm'){
            $templateProcessor->setValue('m3b13', "");
            $templateProcessor->setValue('tm3b13', "&#8730;");
            $templateProcessor->setValue('tr3b13', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3b13'] == 'tr'){
            $templateProcessor->setValue('m3b13', "");
            $templateProcessor->setValue('tm3b13', "");
            $templateProcessor->setValue('tr3b13', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3b13'] == null){
            $templateProcessor->setValue('ca3b13', "");
        }else{
            $templateProcessor->setValue('ca3b13', $data['ca3b13']);
            $model2->catatan_auditor = $data['ca3b13'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c1";
        //3
        if($data['rb3c1'] == 'm'){
            $templateProcessor->setValue('m3c1', "&#8730;");
            $templateProcessor->setValue('tm3c1', "");
            $templateProcessor->setValue('tr3c1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c1'] == 'tm'){
            $templateProcessor->setValue('m3c1', "");
            $templateProcessor->setValue('tm3c1', "&#8730;");
            $templateProcessor->setValue('tr3c1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c1'] == 'tr'){
            $templateProcessor->setValue('m3c1', "");
            $templateProcessor->setValue('tm3c1', "");
            $templateProcessor->setValue('tr3c1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c1'] == null){
            $templateProcessor->setValue('ca3c1', "");
        }else{
            $templateProcessor->setValue('ca3c1', $data['ca3c1']);
            $model2->catatan_auditor = $data['ca3c1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c2";
        //3
        if($data['rb3c2'] == 'm'){
            $templateProcessor->setValue('m3c2', "&#8730;");
            $templateProcessor->setValue('tm3c2', "");
            $templateProcessor->setValue('tr3c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c2'] == 'tm'){
            $templateProcessor->setValue('m3c2', "");
            $templateProcessor->setValue('tm3c2', "&#8730;");
            $templateProcessor->setValue('tr3c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c2'] == 'tr'){
            $templateProcessor->setValue('m3c2', "");
            $templateProcessor->setValue('tm3c2', "");
            $templateProcessor->setValue('tr3c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c2'] == null){
            $templateProcessor->setValue('ca3c2', "");
        }else{
            $templateProcessor->setValue('ca3c2', $data['ca3c2']);
            $model2->catatan_auditor = $data['ca3c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c3";
        //3
        if($data['rb3c3'] == 'm'){
            $templateProcessor->setValue('m3c3', "&#8730;");
            $templateProcessor->setValue('tm3c3', "");
            $templateProcessor->setValue('tr3c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c3'] == 'tm'){
            $templateProcessor->setValue('m3c3', "");
            $templateProcessor->setValue('tm3c3', "&#8730;");
            $templateProcessor->setValue('tr3c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c3'] == 'tr'){
            $templateProcessor->setValue('m3c3', "");
            $templateProcessor->setValue('tm3c3', "");
            $templateProcessor->setValue('tr3c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c3'] == null){
            $templateProcessor->setValue('ca3c3', "");
        }else{
            $templateProcessor->setValue('ca3c3', $data['ca3c3']);
            $model2->catatan_auditor = $data['ca3c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c4";
        //3
        if($data['rb3c4'] == 'm'){
            $templateProcessor->setValue('m3c4', "&#8730;");
            $templateProcessor->setValue('tm3c4', "");
            $templateProcessor->setValue('tr3c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c4'] == 'tm'){
            $templateProcessor->setValue('m3c4', "");
            $templateProcessor->setValue('tm3c4', "&#8730;");
            $templateProcessor->setValue('tr3c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c4'] == 'tr'){
            $templateProcessor->setValue('m3c4', "");
            $templateProcessor->setValue('tm3c4', "");
            $templateProcessor->setValue('tr3c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c4'] == null){
            $templateProcessor->setValue('ca3c4', "");
        }else{
            $templateProcessor->setValue('ca3c4', $data['ca3c4']);
            $model2->catatan_auditor = $data['ca3c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c5";
        //3
        if($data['rb3c5'] == 'm'){
            $templateProcessor->setValue('m3c5', "&#8730;");
            $templateProcessor->setValue('tm3c5', "");
            $templateProcessor->setValue('tr3c5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c5'] == 'tm'){
            $templateProcessor->setValue('m3c5', "");
            $templateProcessor->setValue('tm3c5', "&#8730;");
            $templateProcessor->setValue('tr3c5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c5'] == 'tr'){
            $templateProcessor->setValue('m3c5', "");
            $templateProcessor->setValue('tm3c5', "");
            $templateProcessor->setValue('tr3c5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c5'] == null){
            $templateProcessor->setValue('ca3c5', "");
        }else{
            $templateProcessor->setValue('ca3c5', $data['ca3c5']);
            $model2->catatan_auditor = $data['ca3c5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c6";
        //3
        if($data['rb3c6'] == 'm'){
            $templateProcessor->setValue('m3c6', "&#8730;");
            $templateProcessor->setValue('tm3c6', "");
            $templateProcessor->setValue('tr3c6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c6'] == 'tm'){
            $templateProcessor->setValue('m3c6', "");
            $templateProcessor->setValue('tm3c6', "&#8730;");
            $templateProcessor->setValue('tr3c6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c6'] == 'tr'){
            $templateProcessor->setValue('m3c6', "");
            $templateProcessor->setValue('tm3c6', "");
            $templateProcessor->setValue('tr3c6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c6'] == null){
            $templateProcessor->setValue('ca3c6', "");
        }else{
            $templateProcessor->setValue('ca3c6', $data['ca3c6']);
            $model2->catatan_auditor = $data['ca3c6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c7";
        //3
        if($data['rb3c7'] == 'm'){
            $templateProcessor->setValue('m3c7', "&#8730;");
            $templateProcessor->setValue('tm3c7', "");
            $templateProcessor->setValue('tr3c7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c7'] == 'tm'){
            $templateProcessor->setValue('m3c7', "");
            $templateProcessor->setValue('tm3c7', "&#8730;");
            $templateProcessor->setValue('tr3c7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c7'] == 'tr'){
            $templateProcessor->setValue('m3c7', "");
            $templateProcessor->setValue('tm3c7', "");
            $templateProcessor->setValue('tr3c7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c7'] == null){
            $templateProcessor->setValue('ca3c7', "");
        }else{
            $templateProcessor->setValue('ca3c7', $data['ca3c7']);
            $model2->catatan_auditor = $data['ca3c7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c8";
        //3
        if($data['rb3c8'] == 'm'){
            $templateProcessor->setValue('m3c8', "&#8730;");
            $templateProcessor->setValue('tm3c8', "");
            $templateProcessor->setValue('tr3c8', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c8'] == 'tm'){
            $templateProcessor->setValue('m3c8', "");
            $templateProcessor->setValue('tm3c8', "&#8730;");
            $templateProcessor->setValue('tr3c8', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c8'] == 'tr'){
            $templateProcessor->setValue('m3c8', "");
            $templateProcessor->setValue('tm3c8', "");
            $templateProcessor->setValue('tr3c8', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c8'] == null){
            $templateProcessor->setValue('ca3c8', "");
        }else{
            $templateProcessor->setValue('ca3c8', $data['ca3c8']);
            $model2->catatan_auditor = $data['ca3c8'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c9";
        //3
        if($data['rb3c9'] == 'm'){
            $templateProcessor->setValue('m3c9', "&#8730;");
            $templateProcessor->setValue('tm3c9', "");
            $templateProcessor->setValue('tr3c9', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c9'] == 'tm'){
            $templateProcessor->setValue('m3c9', "");
            $templateProcessor->setValue('tm3c9', "&#8730;");
            $templateProcessor->setValue('tr3c9', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb3c9'] == 'tr'){
            $templateProcessor->setValue('m3c9', "");
            $templateProcessor->setValue('tm3c9', "");
            $templateProcessor->setValue('tr3c9', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c9'] == null){
            $templateProcessor->setValue('ca3c9', "");
        }else{
            $templateProcessor->setValue('ca3c9', $data['ca3c9']);
            $model2->catatan_auditor = $data['ca3c9'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "3c10";
        //3
        if($data['rb3c10'] == 'm'){
            $templateProcessor->setValue('m3c10', "&#8730;");
            $templateProcessor->setValue('tm3c10', "");
            $templateProcessor->setValue('tr3c10', "");

            $model2->status_kriteria = "m";
        }else if($data['rb3c10'] == 'tm'){
            $templateProcessor->setValue('m3c10', "");
            $templateProcessor->setValue('tm3c10', "&#8730;");
            $templateProcessor->setValue('tr3c10', "");
            
            $model2->status_kriteria = "tm";
        }else if($data['rb3c10'] == 'tr'){
            $templateProcessor->setValue('m3c10', "");
            $templateProcessor->setValue('tm3c10', "");
            $templateProcessor->setValue('tr3c10', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca3c10'] == null){
            $templateProcessor->setValue('ca3c10', "");
        }else{
            $templateProcessor->setValue('ca3c10', $data['ca3c10']);
            $model2->catatan_auditor = $data['ca3c10'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a1";
        //4
        if($data['rb4a1'] == 'm'){
            $templateProcessor->setValue('m4a1', "&#8730;");
            $templateProcessor->setValue('tm4a1', "");
            $templateProcessor->setValue('tr4a1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a1'] == 'tm'){
            $templateProcessor->setValue('m4a1', "");
            $templateProcessor->setValue('tm4a1', "&#8730;");
            $templateProcessor->setValue('tr4a1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a1'] == 'tr'){
            $templateProcessor->setValue('m4a1', "");
            $templateProcessor->setValue('tm4a1', "");
            $templateProcessor->setValue('tr4a1', "&#8730;");

            $model2->status_kriteria = "tr";
        }        

        if($data['ca4a1'] == null){
            $templateProcessor->setValue('ca4a1', "");
        }else{
            $templateProcessor->setValue('ca4a1', $data['ca4a1']);
            $model2->catatan_auditor = $data['ca4a1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a2";
        //4
        if($data['rb4a2'] == 'm'){
            $templateProcessor->setValue('m4a2', "&#8730;");
            $templateProcessor->setValue('tm4a2', "");
            $templateProcessor->setValue('tr4a2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a2'] == 'tm'){
            $templateProcessor->setValue('m4a2', "");
            $templateProcessor->setValue('tm4a2', "&#8730;");
            $templateProcessor->setValue('tr4a2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a2'] == 'tr'){
            $templateProcessor->setValue('m4a2', "");
            $templateProcessor->setValue('tm4a2', "");
            $templateProcessor->setValue('tr4a2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a2'] == null){
            $templateProcessor->setValue('ca4a2', "");
        }else{
            $templateProcessor->setValue('ca4a2', $data['ca4a2']);
            $model2->catatan_auditor = $data['ca4a2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a3";
        //4
        if($data['rb4a3'] == 'm'){
            $templateProcessor->setValue('m4a3', "&#8730;");
            $templateProcessor->setValue('tm4a3', "");
            $templateProcessor->setValue('tr4a3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a3'] == 'tm'){
            $templateProcessor->setValue('m4a3', "");
            $templateProcessor->setValue('tm4a3', "&#8730;");
            $templateProcessor->setValue('tr4a3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a3'] == 'tr'){
            $templateProcessor->setValue('m4a3', "");
            $templateProcessor->setValue('tm4a3', "");
            $templateProcessor->setValue('tr4a3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a3'] == null){
            $templateProcessor->setValue('ca4a3', "");
        }else{
            $templateProcessor->setValue('ca4a3', $data['ca4a3']);
            $model2->catatan_auditor = $data['ca4a3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a4";
        //4
        if($data['rb4a4'] == 'm'){
            $templateProcessor->setValue('m4a4', "&#8730;");
            $templateProcessor->setValue('tm4a4', "");
            $templateProcessor->setValue('tr4a4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a4'] == 'tm'){
            $templateProcessor->setValue('m4a4', "");
            $templateProcessor->setValue('tm4a4', "&#8730;");
            $templateProcessor->setValue('tr4a4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a4'] == 'tr'){
            $templateProcessor->setValue('m4a4', "");
            $templateProcessor->setValue('tm4a4', "");
            $templateProcessor->setValue('tr4a4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a4'] == null){
            $templateProcessor->setValue('ca4a4', "");
        }else{
            $templateProcessor->setValue('ca4a4', $data['ca4a4']);
            $model2->catatan_auditor = $data['ca4a4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a5";
        //4
        if($data['rb4a5'] == 'm'){
            $templateProcessor->setValue('m4a5', "&#8730;");
            $templateProcessor->setValue('tm4a5', "");
            $templateProcessor->setValue('tr4a5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a5'] == 'tm'){
            $templateProcessor->setValue('m4a5', "");
            $templateProcessor->setValue('tm4a5', "&#8730;");
            $templateProcessor->setValue('tr4a5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a5'] == 'tr'){
            $templateProcessor->setValue('m4a5', "");
            $templateProcessor->setValue('tm4a5', "");
            $templateProcessor->setValue('tr4a5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a5'] == null){
            $templateProcessor->setValue('ca4a5', "");
        }else{
            $templateProcessor->setValue('ca4a5', $data['ca4a5']);
            $model2->catatan_auditor = $data['ca4a5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4a6";
        //4
        if($data['rb4a6'] == 'm'){
            $templateProcessor->setValue('m4a6', "&#8730;");
            $templateProcessor->setValue('tm4a6', "");
            $templateProcessor->setValue('tr4a6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4a6'] == 'tm'){
            $templateProcessor->setValue('m4a6', "");
            $templateProcessor->setValue('tm4a6', "&#8730;");
            $templateProcessor->setValue('tr4a6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4a6'] == 'tr'){
            $templateProcessor->setValue('m4a6', "");
            $templateProcessor->setValue('tm4a6', "");
            $templateProcessor->setValue('tr4a6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4a6'] == null){
            $templateProcessor->setValue('ca4a6', "");
        }else{
            $templateProcessor->setValue('ca4a6', $data['ca4a6']);
            $model2->catatan_auditor = $data['ca4a6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b1";
        //4
        if($data['rb4b1'] == 'm'){
            $templateProcessor->setValue('m4b1', "&#8730;");
            $templateProcessor->setValue('tm4b1', "");
            $templateProcessor->setValue('tr4b1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b1'] == 'tm'){
            $templateProcessor->setValue('m4b1', "");
            $templateProcessor->setValue('tm4b1', "&#8730;");
            $templateProcessor->setValue('tr4b1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b1'] == 'tr'){
            $templateProcessor->setValue('m4b1', "");
            $templateProcessor->setValue('tm4b1', "");
            $templateProcessor->setValue('tr4b1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b1'] == null){
            $templateProcessor->setValue('ca4b1', "");
        }else{
            $templateProcessor->setValue('ca4b1', $data['ca4b1']);
            $model2->catatan_auditor = $data['ca4b1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b2";
        //4
        if($data['rb4b2'] == 'm'){
            $templateProcessor->setValue('m4b2', "&#8730;");
            $templateProcessor->setValue('tm4b2', "");
            $templateProcessor->setValue('tr4b2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b2'] == 'tm'){
            $templateProcessor->setValue('m4b2', "");
            $templateProcessor->setValue('tm4b2', "&#8730;");
            $templateProcessor->setValue('tr4b2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b2'] == 'tr'){
            $templateProcessor->setValue('m4b2', "");
            $templateProcessor->setValue('tm4b2', "");
            $templateProcessor->setValue('tr4b2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b2'] == null){
            $templateProcessor->setValue('ca4b2', "");
        }else{
            $templateProcessor->setValue('ca4b2', $data['ca4b2']);
            $model2->catatan_auditor = $data['ca4b2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b3";
        //4
        if($data['rb4b3'] == 'm'){
            $templateProcessor->setValue('m4b3', "&#8730;");
            $templateProcessor->setValue('tm4b3', "");
            $templateProcessor->setValue('tr4b3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b3'] == 'tm'){
            $templateProcessor->setValue('m4b3', "");
            $templateProcessor->setValue('tm4b3', "&#8730;");
            $templateProcessor->setValue('tr4b3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b3'] == 'tr'){
            $templateProcessor->setValue('m4b3', "");
            $templateProcessor->setValue('tm4b3', "");
            $templateProcessor->setValue('tr4b3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b3'] == null){
            $templateProcessor->setValue('ca4b3', "");
        }else{
            $templateProcessor->setValue('ca4b3', $data['ca4b3']);
            $model2->catatan_auditor = $data['ca4b3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b4";
        //4
        if($data['rb4b4'] == 'm'){
            $templateProcessor->setValue('m4b4', "&#8730;");
            $templateProcessor->setValue('tm4b4', "");
            $templateProcessor->setValue('tr4b4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b4'] == 'tm'){
            $templateProcessor->setValue('m4b4', "");
            $templateProcessor->setValue('tm4b4', "&#8730;");
            $templateProcessor->setValue('tr4b4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b4'] == 'tr'){
            $templateProcessor->setValue('m4b4', "");
            $templateProcessor->setValue('tm4b4', "");
            $templateProcessor->setValue('tr4b4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b4'] == null){
            $templateProcessor->setValue('ca4b4', "");
        }else{
            $templateProcessor->setValue('ca4b4', $data['ca4b4']);
            $model2->catatan_auditor = $data['ca4b4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b5";
        //4
        if($data['rb4b5'] == 'm'){
            $templateProcessor->setValue('m4b5', "&#8730;");
            $templateProcessor->setValue('tm4b5', "");
            $templateProcessor->setValue('tr4b5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b5'] == 'tm'){
            $templateProcessor->setValue('m4b5', "");
            $templateProcessor->setValue('tm4b5', "&#8730;");
            $templateProcessor->setValue('tr4b5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b5'] == 'tr'){
            $templateProcessor->setValue('m4b5', "");
            $templateProcessor->setValue('tm4b5', "");
            $templateProcessor->setValue('tr4b5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b5'] == null){
            $templateProcessor->setValue('ca4b5', "");
        }else{
            $templateProcessor->setValue('ca4b5', $data['ca4b5']);
            $model2->catatan_auditor = $data['ca4b5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b6";
        //4
        if($data['rb4b6'] == 'm'){
            $templateProcessor->setValue('m4b6', "&#8730;");
            $templateProcessor->setValue('tm4b6', "");
            $templateProcessor->setValue('tr4b6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b6'] == 'tm'){
            $templateProcessor->setValue('m4b6', "");
            $templateProcessor->setValue('tm4b6', "&#8730;");
            $templateProcessor->setValue('tr4b6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b6'] == 'tr'){
            $templateProcessor->setValue('m4b6', "");
            $templateProcessor->setValue('tm4b6', "");
            $templateProcessor->setValue('tr4b6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b6'] == null){
            $templateProcessor->setValue('ca4b6', "");
        }else{
            $templateProcessor->setValue('ca4b6', $data['ca4b6']);
            $model2->catatan_auditor = $data['ca4b6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4b7";
        //4
        if($data['rb4b7'] == 'm'){
            $templateProcessor->setValue('m4b7', "&#8730;");
            $templateProcessor->setValue('tm4b7', "");
            $templateProcessor->setValue('tr4b7', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4b7'] == 'tm'){
            $templateProcessor->setValue('m4b7', "");
            $templateProcessor->setValue('tm4b7', "&#8730;");
            $templateProcessor->setValue('tr4b7', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4b7'] == 'tr'){
            $templateProcessor->setValue('m4b7', "");
            $templateProcessor->setValue('tm4b7', "");
            $templateProcessor->setValue('tr4b7', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4b7'] == null){
            $templateProcessor->setValue('ca4b7', "");
        }else{
            $templateProcessor->setValue('ca4b7', $data['ca4b7']);
            $model2->catatan_auditor = $data['ca4b7'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c1";
        //4
        if($data['rb4c1'] == 'm'){
            $templateProcessor->setValue('m4c1', "&#8730;");
            $templateProcessor->setValue('tm4c1', "");
            $templateProcessor->setValue('tr4c1', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c1'] == 'tm'){
            $templateProcessor->setValue('m4c1', "");
            $templateProcessor->setValue('tm4c1', "&#8730;");
            $templateProcessor->setValue('tr4c1', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c1'] == 'tr'){
            $templateProcessor->setValue('m4c1', "");
            $templateProcessor->setValue('tm4c1', "");
            $templateProcessor->setValue('tr4c1', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c1'] == null){
            $templateProcessor->setValue('ca4c1', "");
        }else{
            $templateProcessor->setValue('ca4c1', $data['ca4c1']);
            $model2->catatan_auditor = $data['ca4c1'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c2";
        //4
        if($data['rb4c2'] == 'm'){
            $templateProcessor->setValue('m4c2', "&#8730;");
            $templateProcessor->setValue('tm4c2', "");
            $templateProcessor->setValue('tr4c2', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c2'] == 'tm'){
            $templateProcessor->setValue('m4c2', "");
            $templateProcessor->setValue('tm4c2', "&#8730;");
            $templateProcessor->setValue('tr4c2', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c2'] == 'tr'){
            $templateProcessor->setValue('m4c2', "");
            $templateProcessor->setValue('tm4c2', "");
            $templateProcessor->setValue('tr4c2', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c2'] == null){
            $templateProcessor->setValue('ca4c2', "");
        }else{
            $templateProcessor->setValue('ca4c2', $data['ca4c2']);
            $model2->catatan_auditor = $data['ca4c2'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c3";
        //4
        if($data['rb4c3'] == 'm'){
            $templateProcessor->setValue('m4c3', "&#8730;");
            $templateProcessor->setValue('tm4c3', "");
            $templateProcessor->setValue('tr4c3', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c3'] == 'tm'){
            $templateProcessor->setValue('m4c3', "");
            $templateProcessor->setValue('tm4c3', "&#8730;");
            $templateProcessor->setValue('tr4c3', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c3'] == 'tr'){
            $templateProcessor->setValue('m4c3', "");
            $templateProcessor->setValue('tm4c3', "");
            $templateProcessor->setValue('tr4c3', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c3'] == null){
            $templateProcessor->setValue('ca4c3', "");
        }else{
            $templateProcessor->setValue('ca4c3', $data['ca4c3']);
            $model2->catatan_auditor = $data['ca4c3'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c4";
        //4
        if($data['rb4c4'] == 'm'){
            $templateProcessor->setValue('m4c4', "&#8730;");
            $templateProcessor->setValue('tm4c4', "");
            $templateProcessor->setValue('tr4c4', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c4'] == 'tm'){
            $templateProcessor->setValue('m4c4', "");
            $templateProcessor->setValue('tm4c4', "&#8730;");
            $templateProcessor->setValue('tr4c4', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c4'] == 'tr'){
            $templateProcessor->setValue('m4c4', "");
            $templateProcessor->setValue('tm4c4', "");
            $templateProcessor->setValue('tr4c4', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c4'] == null){
            $templateProcessor->setValue('ca4c4', "");
        }else{
            $templateProcessor->setValue('ca4c4', $data['ca4c4']);
            $model2->catatan_auditor = $data['ca4c4'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c5";
        //4
        if($data['rb4c5'] == 'm'){
            $templateProcessor->setValue('m4c5', "&#8730;");
            $templateProcessor->setValue('tm4c5', "");
            $templateProcessor->setValue('tr4c5', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c5'] == 'tm'){
            $templateProcessor->setValue('m4c5', "");
            $templateProcessor->setValue('tm4c5', "&#8730;");
            $templateProcessor->setValue('tr4c5', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c5'] == 'tr'){
            $templateProcessor->setValue('m4c5', "");
            $templateProcessor->setValue('tm4c5', "");
            $templateProcessor->setValue('tr4c5', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c5'] == null){
            $templateProcessor->setValue('ca4c5', "");
        }else{
            $templateProcessor->setValue('ca4c5', $data['ca4c5']);
            $model2->catatan_auditor = $data['ca4c5'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "4c6";
        //4
        if($data['rb4c6'] == 'm'){
            $templateProcessor->setValue('m4c6', "&#8730;");
            $templateProcessor->setValue('tm4c6', "");
            $templateProcessor->setValue('tr4c6', "");

            $model2->status_kriteria = "m";
        }else if($data['rb4c6'] == 'tm'){
            $templateProcessor->setValue('m4c6', "");
            $templateProcessor->setValue('tm4c6', "&#8730;");
            $templateProcessor->setValue('tr4c6', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb4c6'] == 'tr'){
            $templateProcessor->setValue('m4c6', "");
            $templateProcessor->setValue('tm4c6', "");
            $templateProcessor->setValue('tr4c6', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca4c6'] == null){
            $templateProcessor->setValue('ca4c6', "");
        }else{
            $templateProcessor->setValue('ca4c6', $data['ca4c6']);
            $model2->catatan_auditor = $data['ca4c6'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5a";
        //5
        if($data['rb5a'] == 'm'){
            $templateProcessor->setValue('m5a', "&#8730;");
            $templateProcessor->setValue('tm5a', "");
            $templateProcessor->setValue('tr5a', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5a'] == 'tm'){
            $templateProcessor->setValue('m5a', "");
            $templateProcessor->setValue('tm5a', "&#8730;");
            $templateProcessor->setValue('tr5a', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5a'] == 'tr'){
            $templateProcessor->setValue('m5a', "");
            $templateProcessor->setValue('tm5a', "");
            $templateProcessor->setValue('tr5a', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5a'] == null){
            $templateProcessor->setValue('ca5a', "");
        }else{
            $templateProcessor->setValue('ca5a', $data['ca5a']);
            $model2->catatan_auditor = $data['ca5a'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5b";
        //5
        if($data['rb5b'] == 'm'){
            $templateProcessor->setValue('m5b', "&#8730;");
            $templateProcessor->setValue('tm5b', "");
            $templateProcessor->setValue('tr5b', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5b'] == 'tm'){
            $templateProcessor->setValue('m5b', "");
            $templateProcessor->setValue('tm5b', "&#8730;");
            $templateProcessor->setValue('tr5b', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5b'] == 'tr'){
            $templateProcessor->setValue('m5b', "");
            $templateProcessor->setValue('tm5b', "");
            $templateProcessor->setValue('tr5b', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5b'] == null){
            $templateProcessor->setValue('ca5b', "");
        }else{
            $templateProcessor->setValue('ca5b', $data['ca5b']);
            $model2->catatan_auditor = $data['ca5b'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5c";
        //5
        if($data['rb5c'] == 'm'){
            $templateProcessor->setValue('m5c', "&#8730;");
            $templateProcessor->setValue('tm5c', "");
            $templateProcessor->setValue('tr5c', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5c'] == 'tm'){
            $templateProcessor->setValue('m5c', "");
            $templateProcessor->setValue('tm5c', "&#8730;");
            $templateProcessor->setValue('tr5c', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5c'] == 'tr'){
            $templateProcessor->setValue('m5c', "");
            $templateProcessor->setValue('tm5c', "");
            $templateProcessor->setValue('tr5c', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5c'] == null){
            $templateProcessor->setValue('ca5c', "");
        }else{
            $templateProcessor->setValue('ca5c', $data['ca5c']);
            $model2->catatan_auditor = $data['ca5c'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5d";
        //5
        if($data['rb5d'] == 'm'){
            $templateProcessor->setValue('m5d', "&#8730;");
            $templateProcessor->setValue('tm5d', "");
            $templateProcessor->setValue('tr5d', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5d'] == 'tm'){
            $templateProcessor->setValue('m5d', "");
            $templateProcessor->setValue('tm5d', "&#8730;");
            $templateProcessor->setValue('tr5d', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5d'] == 'tr'){
            $templateProcessor->setValue('m5d', "");
            $templateProcessor->setValue('tm5d', "");
            $templateProcessor->setValue('tr5d', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5d'] == null){
            $templateProcessor->setValue('ca5d', "");
        }else{
            $templateProcessor->setValue('ca5d', $data['ca5d']);
            $model2->catatan_auditor = $data['ca5d'];
        }
        $model2->save();
        DB::commit();

        $model2 = new DetailLaporanAuditTahap2();
        DB::beginTransaction();
        $model2->id_registrasi = $data['id_registrasi'];
$model2->id_penjadwalan = $data['id_penjadwalan'];      
        $model2->kriteria_sjph = "5e";
        //5
        if($data['rb5e'] == 'm'){
            $templateProcessor->setValue('m5e', "&#8730;");
            $templateProcessor->setValue('tm5e', "");
            $templateProcessor->setValue('tr5e', "");

            $model2->status_kriteria = "m";
        }else if($data['rb5e'] == 'tm'){
            $templateProcessor->setValue('m5e', "");
            $templateProcessor->setValue('tm5e', "&#8730;");
            $templateProcessor->setValue('tr5e', "");

            $model2->status_kriteria = "tm";
        }else if($data['rb5e'] == 'tr'){
            $templateProcessor->setValue('m5e', "");
            $templateProcessor->setValue('tm5e', "");
            $templateProcessor->setValue('tr5e', "&#8730;");

            $model2->status_kriteria = "tr";
        }

        if($data['ca5e'] == null){
            $templateProcessor->setValue('ca5e', "");
        }else{
            $templateProcessor->setValue('ca5e', $data['ca5e']);
            $model2->catatan_auditor = $data['ca5e'];
        }
        $model2->save();
        DB::commit();

        DB::beginTransaction();        

        if($data['kesimpulan'] == null){
            $templateProcessor->setValue('kesimpulan', "");
        }else{
            $templateProcessor->setValue('kesimpulan', $data['kesimpulan']);
            $model->kesimpulan = $data['kesimpulan'];
        }
        $model->save();       
        DB::commit();
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_Laporan Audit Tahap 2_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                

        return response()->download('storage/laporan/upload/'.$fileName);
    }

    public function downloadBerkas(Request $request){
        $data = $request->except('_token','_method');

        // dd($data);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        if($data['no'] == 1){
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-03 Konfirmasi Jadwal,Syarat & Ketentuan Audit.docx');
            $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);

            $fileName = 'FOR-HALAL-OPS-03 Konfirmasi Jadwal,Syarat & Ketentuan Audit ('.$data['nama_perusahaan'].').docx';
            $templateProcessor->saveAs('storage/laporan/download/Konfirmasi SK Audit/'.$fileName);
            $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                        
                
            return response()->download('storage/laporan/download/Konfirmasi SK Audit/'.$fileName);
        }else if($data['no'] == 2){
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-07 Berita Acara Pemeriksaaan.docx');
            $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);

            $fileName = 'FOR-HALAL-OPS-07 Berita Acara Pemeriksaaan ('.$data['nama_perusahaan'].').docx';
            $templateProcessor->saveAs('storage/laporan/download/BAP/'.$fileName);
            $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                        
                
            return response()->download('storage/laporan/download/BAP/'.$fileName);
        }                                        
    }

    public function uploadBerkas(Request $request){
        $data = $request->except('_token','_method');

        $dataLaporan = DB::table('laporan_audit2')
            ->where('id_registrasi',$data['idregis'])
            ->get();        
        // dd($dataLaporan[0]->id);
        // dd(count($dataLaporan));
        
        if($request->has("berkas_sk")){
            $file = $request->file("berkas_sk");            
            $file = $data["berkas_sk"];                        

            $fileName = 'FOR-HALAL-OPS-03 Konfirmasi Jadwal,Syarat & Ketentuan Audit ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Konfirmasi SK Audit/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_konfirmasi_sk_audit = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_konfirmasi_sk_audit = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();                
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_konfirmasi_sk_audit = $fileName;
                $f->tgl_penyerahan_konfirmasi_sk_audit = $ldate;
                $f->save();                                  
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 9, "Upload Berkas Konfirmasi Syarat dan Ketentuan Audit.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_bap")){
            $file = $request->file("berkas_bap");            
            $file = $data["berkas_bap"];

            $fileName = 'FOR-HALAL-OPS-07 Berita Acara Pemeriksaaan ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/BAP/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_bap = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_bap = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_bap = $fileName;
                $f->tgl_penyerahan_bap = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 9, "Upload Berkas Berita Acara Pemeriksaan.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_surattugas")){
            $file = $request->file("berkas_surattugas");            
            $file = $data["berkas_surattugas"];

            $fileName = 'Surat Tugas ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Surat Tugas/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_surat_tugas = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_surat_tugas = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_surat_tugas = $fileName;
                $f->tgl_penyerahan_surat_tugas = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 9, "Upload Berkas Surat Tugas.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_ap")){
            $file = $request->file("berkas_ap");            
            $file = $data["berkas_ap"];

            $fileName = 'FOR-HALAL-OPS-04 Rencana Audit ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/AP/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_rencana_audit = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_rencana_audit = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_rencana_audit = $fileName;
                $f->tgl_penyerahan_rencana_audit = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Rencana Audit.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_laporan2")){
            $file = $request->file("berkas_laporan2");            
            $file = $data["berkas_laporan2"];

            $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Laporan Audit Tahap 2/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_laporan_audit_tahap_2 = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_laporan_audit_tahap_2 = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_laporan_audit_tahap_2 = $fileName;
                $f->tgl_penyerahan_laporan_audit_tahap_2 = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Laporan Audit Tahap 2.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_laporan2_ulang")){
            $file = $request->file("berkas_laporan2_ulang");            
            $file = $data["berkas_laporan2_ulang"];

            $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['idregis'].') Revisi.'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Laporan Audit Tahap 2/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_laporan_audit_tahap_2_ulang = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_laporan_audit_tahap_2_ulang = $ldate;
                    $model->save();
                DB::Commit();                
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_laporan_audit_tahap_2_ulang = $fileName;
                $f->tgl_penyerahan_laporan_audit_tahap_2_ulang = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Ulang Berkas Laporan Audit Tahap 2.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_checklist")){
            $file = $request->file("berkas_checklist");            
            $file = $data["berkas_checklist"];

            $fileName = 'FOR-HALAL-OPS-09 Formulir Ceklist Audit ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Checklist Audit/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_form_ceklis = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_form_ceklis = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_form_ceklis = $fileName;
                $f->tgl_penyerahan_form_ceklis = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Form Checklist Audit Tahap 2.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_ketidaksesuaian")){
            $file = $request->file("berkas_ketidaksesuaian");            
            $file = $data["berkas_ketidaksesuaian"];

            $fileName = 'FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Laporan Ketidaksesuaian/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_laporan_ketidaksesuaian = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_laporan_ketidaksesuaian = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();

                $dataKT= DB::table('ketidaksesuaian')
                    ->where('id_registrasi',$data['idregis'])
                    ->orderBy('id','desc')
                    ->limit(1)
                    ->get();
                    // dd($dataKT);
                    
                        // $model2 = new LaporanAudit2;                
                        // $f = $model2->find($dataLaporan[0]->id);
                        // $f->ketidaksesuaian_isian = $fileName;                
                        // $f->save();
                        // DB::Commit();                        

                $modelkt = new KetidakSesuaian;
                $kt = $modelkt->find($dataKT[0]->id);
                $kt->status = 'close';
                $kt->jumlah_tidak_sesuai = 0;
                $kt->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_laporan_ketidaksesuaian = $fileName;
                $f->tgl_penyerahan_laporan_ketidaksesuaian = $ldate;
                $f->save();   
                
                $dataKT= DB::table('ketidaksesuaian')
                    ->where('id_registrasi',$data['idregis'])
                    ->orderBy('id','desc')
                    ->limit(1)
                    ->get();
                    
                    // dd($dataKT);
                    
                        // $model2 = new LaporanAudit2;                
                        // $f = $model2->find($dataLaporan[0]->id);
                        // $f->ketidaksesuaian_isian = $fileName;                
                        // $f->save();
                        // DB::Commit();

                        $model2 = new LaporanAudit2;                
                        $f = $model2->find($dataLaporan[0]->id);
                        $f->status = 1;
                        $f->save();
                        DB::Commit();

                        $modelReg = new Registrasi;
                        $x = $modelReg->find($data['idregis']);
                        $x->status = 11;
                        $x->save();

                $modelkt = new KetidakSesuaian;
                $kt = $modelkt->find($dataKT[0]->id);
                $kt->status = 'close';
                $kt->jumlah_tidak_sesuai = 0;
                $kt->save();
                DB::Commit();
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Laporan Ketidaksesuaian.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_ketidaksesuaian2")){
            $file = $request->file("berkas_ketidaksesuaian2");            
            $file = $data["berkas_ketidaksesuaian2"];

            $fileName = 'FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Laporan Ketidaksesuaian/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_laporan_ketidaksesuaian = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_laporan_ketidaksesuaian = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();                
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_laporan_ketidaksesuaian = $fileName;
                $f->tgl_penyerahan_laporan_ketidaksesuaian = $ldate;
                $f->save();                                  

                        // $model2 = new LaporanAudit2;                
                        // $f = $model2->find($dataLaporan[0]->id);
                        // $f->status = 1;
                        // $f->save();
                        // DB::Commit();

                        // $modelReg = new Registrasi;
                        // $x = $modelReg->find($data['idregis']);
                        // $x->status = 11;
                        // $x->save();

                $modelkt = new KetidakSesuaian;
                $modelkt->id_registrasi = $data['idregis'];
                // $modelkt->id_penjadwalan = $data['id_penjadwalan'];
                $modelkt->status = 'open';
                // $kt->jumlah_tidak_sesuai = 0;
                $modelkt->save();
                DB::Commit();
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Laporan Ketidaksesuaian.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_baps")){
            $file = $request->file("berkas_baps");
            $file = $data["berkas_baps"];

            $fileName = 'FOR-HALAL-OPS-10 Berita Acara Pengambilan Sampel ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/BAPS/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_bap_sampel = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_bap_sampel = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_bap_sampel = $fileName;
                $f->tgl_penyerahan_bap_sampel = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Berita Acara Pengambilan Sampel.", Auth::user()->usergroup_id);
            DB::Commit();
        }else if($request->has("berkas_daftarhadir")){
            $file = $request->file("berkas_daftarhadir");
            $file = $data["berkas_daftarhadir"];

            $fileName = 'FOR-HALAL-OPS-12 Daftar Hadir ('.$data['idregis'].').'.$file->getClientOriginalExtension();
            // dd($fileName);

            $file->storeAs("public/laporan/upload/Daftar Hadir/", $fileName);

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->file_daftar_hadir = $fileName;
                    $ldate = date('Y-m-d H:i:s');
                    $model->id_registrasi = $data['idregis'];
                    $model->tgl_penyerahan_daftar_hadir = $ldate;
                    $model->save();
                DB::Commit();

                $dataLaporanBaru = DB::table('laporan_audit2')
                    ->where('id_registrasi',$data['idregis'])                    
                    ->get();

                $modelRe = new Registrasi;
                $x = $modelRe->find($data['idregis']);
                $x->id_laporan_audit2 = $dataLaporanBaru[0]->id;
                $x->save();
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_daftar_hadir = $fileName;
                $f->tgl_penyerahan_daftar_hadir = $ldate;
                $f->save();                
            }
            $this->LogKegiatan($data['idregis'], Auth::user()->id, Auth::user()->name, 10, "Upload Berkas Daftar Hadir Opening dan Closing Meeting.", Auth::user()->usergroup_id);
            DB::Commit();
        }

        Session::flash('success', "Upload Berkas Berhasil");
        $redirect = redirect()->back();
        return $redirect;
    }

    public function downloadLaporanAuditBahanFix(Request $request){
        $data = $request->except('_token','_method');

        // dd($data);
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-06 Format Laporan Bahan Complete.docx');

        $model = new LaporanBahan;
        DB::beginTransaction();
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->nama_organisasi = $data['nama_perusahaan'];
            $model->nomor_registrasi = $data['no_registrasi'];                        
            $model->nama_auditor = $data['nama_auditor'];
            $model->tanggal_audit = $data['tanggal_audit'];
            $model->save();            
        DB::Commit();

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);            
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);

        $id = DB::table('laporan_bahan')
            ->select('id')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
                        
            foreach($id as $id2){
                foreach($id2 as $id_asli){
                    $idlapbahan = $id_asli;
                }                
            }
        
        $jml=1;
        $arrData=array();
        
        $temp=0;
        $temp2=0;
        for ($i=0; $i < sizeof($data['bahan']); $i++) { 
            $no = $jml;
            $bahan = $data['bahan'][$i];                        
            $temuan = $data['temuan'][$i];
            $kategori_bahan = $data['kategori_bahan'][$i];
            $catatan = $data['catatan'][$i];

            $model2 = new DetailLaporanBahan;
            DB::beginTransaction();
                $model2->id_laporan_bahan = $idlapbahan;
                $model2->bahan = $bahan;
                $model2->temuan = $temuan;
                $model2->kategori_bahan = $kategori_bahan;
                $model2->catatan = $catatan;
                $model2->save();
            DB::Commit();

            $arrData[] = array('no' => $no, 'bahan' => $bahan, 'temuan' => $temuan, 'kategori_bahan' => $kategori_bahan, 'catatan' => $catatan);
            $jml++;            
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanBahan_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                

        return response()->download('storage/laporan/upload/'.$fileName);
    }

    public function downloadChecklistTahap2(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-09 Formulir Ceklist Audit.docx');

        // $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);

        // $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['id_registrasi'].').docx';
        // $templateProcessor->saveAs("storage/laporan/download/Laporan Audit Tahap 2/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/fix/FOR-HALAL-OPS-09 Formulir Ceklist Audit.docx');
    }

    public function downloadKetidaksesuaian(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian.docx');

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);

        $fileName = 'FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs("storage/laporan/download/Laporan Ketidaksesuaian/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                                
        return response()->download('storage/laporan/download/Laporan Ketidaksesuaian/'.$fileName);
    }

    public function downloadKetidaksesuaianFix(Request $request){
        $data = $request->except('_token','_method');
        // dd($data);        
        // dd($tgl);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian Isian.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_id_bpjph', $data['no_id_bpjph']);
        $templateProcessor->setValue('standar_acuan', $data['standar_acuan']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);
        $templateProcessor->setValue('ketua_tim', $data['ketua_tim']);

        $jml=1;
        $arrData=array();
        $jmlTidakSesuai = 0;
        $jmlSesuai = 0;

        $getKT =   DB::table('ketidaksesuaian')
                    ->select('id')
                    ->where('id_registrasi', $data['id_registrasi'])
                    ->get();
        $dataKet = json_decode($getKT,true);

        // dd(count($dataKet));

        if(count($dataKet) == 0){
            $model = new Ketidaksesuaian;
            DB::beginTransaction();
                $model->id_registrasi = $data['id_registrasi'];                
                $model->id_penjadwalan = $data['id_penjadwalan'];
                $model->save();
            DB::Commit();
            
            $id_ketidaksesuaian_fix = DB::table('ketidaksesuaian')           
                ->select('id')
                ->orderBy('id','desc')
                ->limit(1)
                ->get();
            
                foreach($id_ketidaksesuaian_fix as $id2){
                    foreach($id2 as $id_asli){
                        $idkt = $id_asli;
                    }                
                }
                // dd($idkt);
            
            $temp=0;
            $temp2=0;
            for ($i=0; $i < sizeof($data['klausul']); $i++) { 
                $no = $jml;
                $id_ketidaksesuaian = $idkt;
                $klausul = $data['klausul'][$i];
                $auditor = $data['auditor'][$i];
                $deskripsi = $data['deskripsi'][$i];
                $batas_akhir = $data['batas_akhir'][$i];
                $investigasi = $data['investigasi'][$i];
                $tindakan_perbaikan = $data['tindakan_perbaikan'][$i];
                $tindakan_pencegahan = $data['tindakan_pencegahan'][$i];
                $hasil = $data['hasil'][$i];

                $dDeskripsi = htmlspecialchars(str_replace("\n","<w:br/>",$deskripsi));
                $dDeskripsi_ = str_replace("&lt;","<",$dDeskripsi);
                $dDeskripsi__ = str_replace("&gt;",">",$dDeskripsi_);

                $dInvestigasi = htmlspecialchars(str_replace("\n","<w:br/>",$investigasi));
                $dInvestigasi_ = str_replace("&lt;","<",$dInvestigasi);
                $dInvestigasi__ = str_replace("&gt;",">",$dInvestigasi_);

                $dPerbaikan = htmlspecialchars(str_replace("\n","<w:br/>",$tindakan_perbaikan));
                $dPerbaikan_ = str_replace("&lt;","<",$dPerbaikan);
                $dPerbaikan__ = str_replace("&gt;",">",$dPerbaikan_);

                $dPencegahan = htmlspecialchars(str_replace("\n","<w:br/>",$tindakan_pencegahan));
                $dPencegahan_ = str_replace("&lt;","<",$dPencegahan);
                $dPencegahan__ = str_replace("&gt;",">",$dPencegahan_);

                date_default_timezone_set('Asia/Jakarta');
                $date = date("d-m-Y H:i:s");
                $tgl = $date;

                $model2 = new TemuanKetidaksesuaian;
                DB::beginTransaction();                
                    $model2->id_ketidaksesuaian = $id_ketidaksesuaian;
                    $model2->klausul = $klausul;
                    $model2->auditor = $auditor;
                    $model2->deskripsi = $deskripsi;
                    $model2->batas_akhir = $batas_akhir;
                    $model2->investigasi_akar_permasalahan = $investigasi;
                    $model2->tindakan_perbaikan = $tindakan_perbaikan;
                    $model2->tindakan_pencegahan = $tindakan_pencegahan;

                    if($hasil == 'open'){
                        $jmlTidakSesuai++;
                        $model2->hasil_tinjauan = $hasil;
                    }else{
                        $jmlSesuai++;
                        $model2->hasil_tinjauan = $hasil;
                    }
                    $model2->save();
                DB::Commit();

                $arrData[] = array('no' => $no, 'klausul' => $klausul, 'auditor' => $auditor, 'deskripsi' => $dDeskripsi__, 'batas_akhir' => $batas_akhir, 'investigasi' => $dInvestigasi__, 'tindakan_koreksi' => $dPerbaikan__, 'tindakan_pencegahan' => $dPencegahan__, 'hasil_tinjauan' => $hasil, 'tgl' => $date);
                $jml++;            
            }
            
            if($jmlTidakSesuai > 0){
                $model3 = new Ketidaksesuaian;                
                $f = $model3->find($idkt);
                $f->status = "open";
                $f->jumlah_tidak_sesuai = $jmlTidakSesuai;
                $f->jumlah_sesuai = $jmlSesuai;
                $f->save();
            }else{
                $model3 = new Ketidaksesuaian;                
                $f = $model3->find($idkt);
                $f->status = "close";
                $f->jumlah_tidak_sesuai = $jmlTidakSesuai;
                $f->jumlah_sesuai = $jmlSesuai;
                $f->save();
            }         

            $values = $arrData;
            $templateProcessor->cloneRowAndSetValues('no', $values);
        }else{
            // dd("disiniii");
            foreach($dataKet as $id_){
                foreach($id_ as $id_asli){
                    $idket2 = $id_asli;
                }                
            }
            // dd($idket2);

            $model = new Ketidaksesuaian;
            $e = $model->find($idket2);
            DB::beginTransaction();
                $e->id_registrasi = $data['id_registrasi'];                
                $e->id_penjadwalan = $data['id_penjadwalan'];
                $e->save();
            DB::Commit();                        
            
            $temp=0;
            $temp2=0;
            for ($i=0; $i < sizeof($data['klausul']); $i++) { 
                $no = $jml;
                $id_ketidaksesuaian = $idket2;
                $klausul = $data['klausul'][$i];
                $auditor = $data['auditor'][$i];
                $deskripsi = $data['deskripsi'][$i];
                $batas_akhir = $data['batas_akhir'][$i];
                $investigasi = $data['investigasi'][$i];
                $tindakan_perbaikan = $data['tindakan_perbaikan'][$i];
                $tindakan_pencegahan = $data['tindakan_pencegahan'][$i];
                $hasil = $data['hasil'][$i];

                $dDeskripsi = htmlspecialchars(str_replace("\n","<w:br/>",$deskripsi));
                $dDeskripsi_ = str_replace("&lt;","<",$dDeskripsi);
                $dDeskripsi__ = str_replace("&gt;",">",$dDeskripsi_);

                $dInvestigasi = htmlspecialchars(str_replace("\n","<w:br/>",$investigasi));
                $dInvestigasi_ = str_replace("&lt;","<",$dInvestigasi);
                $dInvestigasi__ = str_replace("&gt;",">",$dInvestigasi_);

                $dPerbaikan = htmlspecialchars(str_replace("\n","<w:br/>",$tindakan_perbaikan));
                $dPerbaikan_ = str_replace("&lt;","<",$dPerbaikan);
                $dPerbaikan__ = str_replace("&gt;",">",$dPerbaikan_);

                $dPencegahan = htmlspecialchars(str_replace("\n","<w:br/>",$tindakan_pencegahan));
                $dPencegahan_ = str_replace("&lt;","<",$dPencegahan);
                $dPencegahan__ = str_replace("&gt;",">",$dPencegahan_);

                date_default_timezone_set('Asia/Jakarta');
                $date = date("d-m-Y H:i:s");
                $tgl = $date;

                $model2 = new TemuanKetidaksesuaian;
                DB::beginTransaction();                                   
                    $model2->id_ketidaksesuaian = $id_ketidaksesuaian;
                    $model2->klausul = $klausul;
                    $model2->auditor = $auditor;
                    $model2->deskripsi = $deskripsi;
                    $model2->batas_akhir = $batas_akhir;
                    $model2->investigasi_akar_permasalahan = $investigasi;
                    $model2->tindakan_perbaikan = $tindakan_perbaikan;
                    $model2->tindakan_pencegahan = $tindakan_pencegahan;

                    if($hasil == 'open'){
                        $jmlTidakSesuai++;
                        $model2->hasil_tinjauan = $hasil;
                    }else{
                        $jmlSesuai++;
                        $model2->hasil_tinjauan = $hasil;
                    }
                    $model2->save();
                DB::Commit();

                // $arrData[] = array('no' => $no, 'klausul' => $klausul, 'auditor' => $auditor, 'deskripsi' => $dDeskripsi__, 'investigasi' => $investigasi, 'tindakan_koreksi' => $tindakan, 'hasil_tinjauan' => $hasil, 'tgl' => $date);
                $arrData[] = array('no' => $no, 'klausul' => $klausul, 'auditor' => $auditor, 'deskripsi' => $dDeskripsi__, 'batas_akhir' => $batas_akhir, 'investigasi' => $dInvestigasi__, 'tindakan_koreksi' => $dPerbaikan__, 'tindakan_pencegahan' => $dPencegahan__, 'hasil_tinjauan' => $hasil, 'tgl' => $date);
                $jml++;            
            }
            
            if($jmlTidakSesuai > 0){
                $model3 = new Ketidaksesuaian;                
                $f = $model3->find($idket2);
                $f->status = "open";
                $f->jumlah_tidak_sesuai = $jmlTidakSesuai;
                $f->jumlah_sesuai = $jmlSesuai;
                $f->save();
            }else{
                $model3 = new Ketidaksesuaian;                
                $f = $model3->find($idket2);
                $f->status = "close";
                $f->jumlah_tidak_sesuai = $jmlTidakSesuai;
                $f->jumlah_sesuai = $jmlSesuai;
                $f->save();
            }         

            $values = $arrData;
            $templateProcessor->cloneRowAndSetValues('no', $values);
        }

        $fileName = 'FOR-HALAL-OPS-08 Laporan Temuan Ketidaksesuaian ('.$data['id_registrasi'].').docx';
        $templateProcessor->saveAs("storage/laporan/download/Laporan Ketidaksesuaian/Isian/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');

        $dataLaporan = DB::table('laporan_audit2')
            ->where('id_registrasi',$data['id_registrasi'])
            ->get();

            if(count($dataLaporan) == 0){
                $model = new LaporanAudit2;
                    $model->ketidaksesuaian_isian = $fileName;                    
                    $model->id_registrasi = $data['id_registrasi'];                    
                    $model->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;                
                $f = $model2->find($dataLaporan[0]->id);
                $f->ketidaksesuaian_isian = $fileName;                
                $f->save();                
            }
            DB::Commit(); 

        $this->LogKegiatan($data['id_registrasi'], Auth::user()->id, Auth::user()->name, 10, "Membuat Berkas Laporan Ketidaksesuaian.", Auth::user()->usergroup_id);
                                
        return response()->download('storage/laporan/download/Laporan Ketidaksesuaian/Isian/'.$fileName);
    }

    public function LogKegiatan($id_registrasi, $id_user, $nama, $id_kegiatan, $judul_kegiatan, $usergroup_id){
        $model3 = new LogKegiatan();
        DB::beginTransaction();
            $model3->id_registrasi = $id_registrasi;
            $model3->id_user = $id_user;
            $model3->nama_user = $nama;
            $model3->id_kegiatan = $id_kegiatan;
            $model3->usergroup_id = $usergroup_id;
            $model3->judul_kegiatan = $judul_kegiatan;            
            $model3->save();
        DB::commit();
    }

    public function uploadDaftarPeriksaRekomendasi(Request $request){
        $data = $request->except('_token','_method');

        $model = new DaftarPeriksaRekomendasi();        

        $dataRekomen = DB::table('daftar_periksa_rekomendasi')
            ->where('id_registrasi',$data['id_registrasi'])
            ->select('id')
            ->get();

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi Isian.docx');
        
        // dd($data);

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('nomor_id_bpjph', $data['nomor_id_bpjph']);
        $templateProcessor->setValue('jenis_produk', $data['jenis_produk']);

        $tglAudit = htmlspecialchars(str_replace("\n","<w:br/>",$data['mulai_audit1']));
        $tglAudit_ = str_replace("&lt;","<",$tglAudit);
        $tglAudit__ = str_replace("&gt;",">",$tglAudit_);
        $templateProcessor->setValue('tgl_audit', $tglAudit__);

        $pelaksana = htmlspecialchars(str_replace("\n","<w:br/>",$data['pelaksana1_audit1']));
        $pelaksana_ = str_replace("&lt;","<",$pelaksana);
        $pelaksana__ = str_replace("&gt;",">",$pelaksana_);        
        $templateProcessor->setValue('tim_audit', $pelaksana__);

        if(sizeOf($dataRekomen) == 0){
                if(Auth::user()->usergroup_id == '10' || Auth::user()->usergroup_id == '11' || Auth::user()->usergroup_id == '12'){
                    
                    DB::beginTransaction();
                    $model->nama_rekomendasi_tr = $data['nama_tr'];
                    $templateProcessor->setValue('nama_rekomendasi', $data['nama_tr']);
                    $templateProcessor->setValue('nama_rekomendasi2', '');

                    $model->tgl_rekomendasi_tr = $data['tanggal_rekomendasi_tr'];
                    $templateProcessor->setValue('tgl_rekomendasi', $data['tanggal_rekomendasi_tr']);
                    $templateProcessor->setValue('tgl_rekomendasi2', '');

                    $model->status_rekomendasi_tr = $data['kesiapanrekomen_tr'];
                    if($data['kesiapanrekomen_tr'] == 'siap'){                        
                        $templateProcessor->setValue('siap', 'Siap');

                        $inline = new TextRun();
                        $inline->addText('Belum Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('belum_siap', $inline);                        
                    }else{                        
                        $templateProcessor->setValue('belum_siap', 'Belum Siap');

                        $inline = new TextRun();
                        $inline->addText('Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('siap', $inline);
                    }     
                    $templateProcessor->setValue('siap2', 'Siap');
                    $templateProcessor->setValue('belum_siap2', 'Belum Siap');

                    $model->id_registrasi = $data['id_registrasi'];

                    $model->status1 = $data['rbpenawaran'];
                    $caPenawaran = htmlspecialchars(str_replace("\n","<w:br/>",$data['capenawaran']));
                    $caPenawaran_ = str_replace("&lt;","<",$caPenawaran);
                    $caPenawaran__ = str_replace("&gt;",">",$caPenawaran_);
                    $model->catatan1 = $data['capenawaran'];

                    if($data['rbpenawaran'] == 'ada'){
                        $templateProcessor->setValue('11', "&#8730;");
                        $templateProcessor->setValue('10', "");
                    }else{
                        $templateProcessor->setValue('11', "");
                        $templateProcessor->setValue('10', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan11', $caPenawaran__);

                    $model->status2 = $data['rbkonfirmasi'];
                    $caKonfirmasi = htmlspecialchars(str_replace("\n","<w:br/>",$data['cakonfirmasi']));
                    $caKonfirmasi_ = str_replace("&lt;","<",$caKonfirmasi);
                    $caKonfirmasi__ = str_replace("&gt;",">",$caKonfirmasi_);
                    $model->catatan2 = $data['cakonfirmasi'];

                    if($data['rbkonfirmasi'] == 'ada'){
                        $templateProcessor->setValue('21', "&#8730;");
                        $templateProcessor->setValue('20', "");
                    }else{
                        $templateProcessor->setValue('21', "");
                        $templateProcessor->setValue('20', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan12', $caKonfirmasi__);

                    $model->status3 = $data['rbst'];
                    $caST = htmlspecialchars(str_replace("\n","<w:br/>",$data['cast']));
                    $caST_ = str_replace("&lt;","<",$caST);
                    $caST__ = str_replace("&gt;",">",$caST_);
                    $model->catatan3 = $data['cast'];

                    if($data['rbst'] == 'ada'){
                        $templateProcessor->setValue('31', "&#8730;");
                        $templateProcessor->setValue('30', "");
                    }else{
                        $templateProcessor->setValue('31', "");
                        $templateProcessor->setValue('30', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan13', $caST__);

                    $model->status4 = $data['rbap'];
                    $caAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['caap']));
                    $caAP_ = str_replace("&lt;","<",$caAP);
                    $caAP__ = str_replace("&gt;",">",$caAP_);
                    $model->catatan4 = $data['caap'];

                    if($data['rbap'] == 'ada'){
                        $templateProcessor->setValue('41', "&#8730;");
                        $templateProcessor->setValue('40', "");
                    }else{
                        $templateProcessor->setValue('41', "");
                        $templateProcessor->setValue('40', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan14', $caAP__);

                    $model->status5 = $data['rbaudit1'];
                    $caAudit1 = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit1']));
                    $caAudit1_ = str_replace("&lt;","<",$caAudit1);
                    $caAudit1__ = str_replace("&gt;",">",$caAudit1_);
                    $model->catatan5 = $data['caaudit1'];

                    if($data['rbaudit1'] == 'ada'){
                        $templateProcessor->setValue('51', "&#8730;");
                        $templateProcessor->setValue('50', "");
                    }else{
                        $templateProcessor->setValue('51', "");
                        $templateProcessor->setValue('50', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan15', $caAP__);
                    $templateProcessor->setValue('catatan25', "");

                    $model->status6a = $data['rbaudit2a'];
                    $caAudit2a = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2a']));
                    $caAudit2a_ = str_replace("&lt;","<",$caAudit2a);
                    $caAudit2a__ = str_replace("&gt;",">",$caAudit2a_);
                    $model->catatan6a = $data['caaudit2a'];

                    if($data['rbaudit2a'] == 'ada'){
                        $templateProcessor->setValue('6a1', "&#8730;");
                        $templateProcessor->setValue('6a0', "");
                    }else{
                        $templateProcessor->setValue('6a1', "");
                        $templateProcessor->setValue('6a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16a', $caAudit2a__);
                    $templateProcessor->setValue('catatan26a', "");

                    $model->status6b = $data['rbaudit2b'];
                    $caAudit2b = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2b']));
                    $caAudit2b_ = str_replace("&lt;","<",$caAudit2b);
                    $caAudit2b__ = str_replace("&gt;",">",$caAudit2b_);
                    $model->catatan6b = $data['caaudit2b'];

                    if($data['rbaudit2b'] == 'ada'){
                        $templateProcessor->setValue('6b1', "&#8730;");
                        $templateProcessor->setValue('6b0', "");
                    }else{
                        $templateProcessor->setValue('6b1', "");
                        $templateProcessor->setValue('6b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16b', $caAudit2a__);
                    $templateProcessor->setValue('catatan26b', "");

                    $model->status6c = $data['rbaudit2c'];
                    $caAudit2c = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2c']));
                    $caAudit2c_ = str_replace("&lt;","<",$caAudit2c);
                    $caAudit2c__ = str_replace("&gt;",">",$caAudit2c_);
                    $model->catatan6c = $data['caaudit2c'];

                    if($data['rbaudit2c'] == 'ada'){
                        $templateProcessor->setValue('6c1', "&#8730;");
                        $templateProcessor->setValue('6c0', "");
                    }else{
                        $templateProcessor->setValue('6c1', "");
                        $templateProcessor->setValue('6c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16c', $caAudit2c__);
                    $templateProcessor->setValue('catatan26c', "");

                    $model->status6d = $data['rbaudit2d'];
                    $caAudit2d = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2d']));
                    $caAudit2d_ = str_replace("&lt;","<",$caAudit2d);
                    $caAudit2d__ = str_replace("&gt;",">",$caAudit2d_);
                    $model->catatan6d = $data['caaudit2d'];

                    if($data['rbaudit2d'] == 'ada'){
                        $templateProcessor->setValue('6d1', "&#8730;");
                        $templateProcessor->setValue('6d0', "");
                    }else{
                        $templateProcessor->setValue('6d1', "");
                        $templateProcessor->setValue('6d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16d', $caAudit2d__);
                    $templateProcessor->setValue('catatan26d', "");

                    $model->status7 = $data['rbbap'];
                    $caBAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabap']));
                    $caBAP_ = str_replace("&lt;","<",$caBAP);
                    $caBAP__ = str_replace("&gt;",">",$caBAP_);
                    $model->catatan7 = $data['cabap'];

                    if($data['rbbap'] == 'ada'){
                        $templateProcessor->setValue('71', "&#8730;");
                        $templateProcessor->setValue('70', "");
                    }else{
                        $templateProcessor->setValue('71', "");
                        $templateProcessor->setValue('70', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan17', $caBAP__);
                    $templateProcessor->setValue('catatan27', "");

                    $model->status8 = $data['rbbaps'];
                    $caBAPS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabaps']));
                    $caBAPS_ = str_replace("&lt;","<",$caBAPS);
                    $caBAPS__ = str_replace("&gt;",">",$caBAPS_);
                    $model->catatan8 = $data['cabaps'];

                    if($data['rbbaps'] == 'ada'){
                        $templateProcessor->setValue('81', "&#8730;");
                        $templateProcessor->setValue('80', "");
                    }else{
                        $templateProcessor->setValue('81', "");
                        $templateProcessor->setValue('80', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan18', $caBAPS__);
                    $templateProcessor->setValue('catatan28', "");

                    $model->status9 = $data['rbdh'];
                    $caDH = htmlspecialchars(str_replace("\n","<w:br/>",$data['cadh']));
                    $caDH_ = str_replace("&lt;","<",$caDH);
                    $caDH__ = str_replace("&gt;",">",$caDH_);
                    $model->catatan9 = $data['cadh'];

                    if($data['rbdh'] == 'ada'){
                        $templateProcessor->setValue('91', "&#8730;");
                        $templateProcessor->setValue('90', "");
                    }else{
                        $templateProcessor->setValue('91', "");
                        $templateProcessor->setValue('90', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan19', $caDH__);
                    $templateProcessor->setValue('catatan29', "");

                    $model->status10a = $data['rbskfa'];
                    $caSKFA = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfa']));
                    $caSKFA_ = str_replace("&lt;","<",$caSKFA);
                    $caSKFA__ = str_replace("&gt;",">",$caSKFA_);
                    $model->catatan10a = $data['caskfa'];

                    if($data['rbskfa'] == 'ada'){
                        $templateProcessor->setValue('10a1', "&#8730;");
                        $templateProcessor->setValue('10a0', "");
                    }else{
                        $templateProcessor->setValue('10a1', "");
                        $templateProcessor->setValue('10a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110a', $caDH__);

                    $model->status10b = $data['rbskfb'];
                    $caSKFB = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfb']));
                    $caSKFB_ = str_replace("&lt;","<",$caSKFB);
                    $caSKFB__ = str_replace("&gt;",">",$caSKFB_);
                    $model->catatan10b = $data['caskfb'];

                    if($data['rbskfb'] == 'ada'){
                        $templateProcessor->setValue('10b1', "&#8730;");
                        $templateProcessor->setValue('10b0', "");
                    }else{
                        $templateProcessor->setValue('10b1', "");
                        $templateProcessor->setValue('10b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110b', $caSKFB__);

                    $model->status10c = $data['rbskfc'];
                    $caSKFC = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfc']));
                    $caSKFC_ = str_replace("&lt;","<",$caSKFC);
                    $caSKFC__ = str_replace("&gt;",">",$caSKFC_);
                    $model->catatan10c = $data['caskfc'];

                    if($data['rbskfc'] == 'ada'){
                        $templateProcessor->setValue('10c1', "&#8730;");
                        $templateProcessor->setValue('10c0', "");
                    }else{
                        $templateProcessor->setValue('10c1', "");
                        $templateProcessor->setValue('10c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110c', $caSKFC__);

                    $model->status10d = $data['rbskfd'];
                    $caSKFD = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfd']));
                    $caSKFD_ = str_replace("&lt;","<",$caSKFD);
                    $caSKFD__ = str_replace("&gt;",">",$caSKFD_);
                    $model->catatan10d = $data['caskfd'];

                    if($data['rbskfd'] == 'ada'){
                        $templateProcessor->setValue('10d1', "&#8730;");
                        $templateProcessor->setValue('10d0', "");
                    }else{
                        $templateProcessor->setValue('10d1', "");
                        $templateProcessor->setValue('10d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110d', $caSKFD__);

                    $model->status10e = $data['rbskfe'];
                    $caSKFE = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfe']));
                    $caSKFE_ = str_replace("&lt;","<",$caSKFE);
                    $caSKFE__ = str_replace("&gt;",">",$caSKFE_);
                    $model->catatan10e = $data['caskfe'];

                    if($data['rbskfe'] == 'ada'){
                        $templateProcessor->setValue('10e1', "&#8730;");
                        $templateProcessor->setValue('10e0', "");
                    }else{
                        $templateProcessor->setValue('10e1', "");
                        $templateProcessor->setValue('10e0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110e', $caSKFE__);

                    $model->status10f = $data['rbskff'];
                    $caSKFF = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskff']));
                    $caSKFF_ = str_replace("&lt;","<",$caSKFF);
                    $caSKFF__ = str_replace("&gt;",">",$caSKFF_);
                    $model->catatan10f = $data['caskff'];

                    if($data['rbskff'] == 'ada'){
                        $templateProcessor->setValue('10f1', "&#8730;");
                        $templateProcessor->setValue('10f0', "");
                    }else{
                        $templateProcessor->setValue('10f1', "");
                        $templateProcessor->setValue('10f0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110f', $caSKFF__);

                    $model->save();
                    DB::commit();                    
                    // dd($id_daftar_rekomen);                                        
                }

                $fileName = 'FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi ('.$data['id_registrasi'].').docx';
                $templateProcessor->saveAs("storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian/".$fileName);
        
                $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                return response()->download('storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian/'.$fileName);
            
        }else{
            if(Auth::user()->usergroup_id == '10' || Auth::user()->usergroup_id == '11' || Auth::user()->usergroup_id == '12'){

                foreach($dataRekomen as $id){
                    foreach($id as $id_daftar_periksa_rekomendasi){
                        $id_daftar_rekomen = $id_daftar_periksa_rekomendasi;
                    }
                }

                // dd($id_daftar_rekomen);
                    $d = $model->find($id_daftar_rekomen);

                    DB::beginTransaction();
                    $d->nama_rekomendasi_tr = $data['nama_tr'];
                    $templateProcessor->setValue('nama_rekomendasi', $data['nama_tr']);
                    $templateProcessor->setValue('nama_rekomendasi2', '');

                    $d->tgl_rekomendasi_tr = $data['tanggal_rekomendasi_tr'];
                    $templateProcessor->setValue('tgl_rekomendasi', $data['tanggal_rekomendasi_tr']);
                    $templateProcessor->setValue('tgl_rekomendasi2', '');

                    $d->status_rekomendasi_tr = $data['kesiapanrekomen_tr'];
                    if($data['kesiapanrekomen_tr'] == 'siap'){                        
                        $templateProcessor->setValue('siap', 'Siap');

                        $inline = new TextRun();
                        $inline->addText('Belum Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('belum_siap', $inline);                        
                    }else{                        
                        $templateProcessor->setValue('belum_siap', 'Belum Siap');

                        $inline = new TextRun();
                        $inline->addText('Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('siap', $inline);
                    }     
                    $templateProcessor->setValue('siap2', 'Siap');
                    $templateProcessor->setValue('belum_siap2', 'Belum Siap');

                    $d->id_registrasi = $data['id_registrasi'];

                    $d->status1 = $data['rbpenawaran'];
                    $caPenawaran = htmlspecialchars(str_replace("\n","<w:br/>",$data['capenawaran']));
                    $caPenawaran_ = str_replace("&lt;","<",$caPenawaran);
                    $caPenawaran__ = str_replace("&gt;",">",$caPenawaran_);
                    $d->catatan1 = $data['capenawaran'];

                    if($data['rbpenawaran'] == 'ada'){
                        $templateProcessor->setValue('11', "&#8730;");
                        $templateProcessor->setValue('10', "");
                    }else{
                        $templateProcessor->setValue('11', "");
                        $templateProcessor->setValue('10', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan11', $caPenawaran__);

                    $d->status2 = $data['rbkonfirmasi'];
                    $caKonfirmasi = htmlspecialchars(str_replace("\n","<w:br/>",$data['cakonfirmasi']));
                    $caKonfirmasi_ = str_replace("&lt;","<",$caKonfirmasi);
                    $caKonfirmasi__ = str_replace("&gt;",">",$caKonfirmasi_);
                    $d->catatan2 = $data['cakonfirmasi'];

                    if($data['rbkonfirmasi'] == 'ada'){
                        $templateProcessor->setValue('21', "&#8730;");
                        $templateProcessor->setValue('20', "");
                    }else{
                        $templateProcessor->setValue('21', "");
                        $templateProcessor->setValue('20', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan12', $caKonfirmasi__);

                    $d->status3 = $data['rbst'];
                    $caST = htmlspecialchars(str_replace("\n","<w:br/>",$data['cast']));
                    $caST_ = str_replace("&lt;","<",$caST);
                    $caST__ = str_replace("&gt;",">",$caST_);
                    $d->catatan3 = $data['cast'];

                    if($data['rbst'] == 'ada'){
                        $templateProcessor->setValue('31', "&#8730;");
                        $templateProcessor->setValue('30', "");
                    }else{
                        $templateProcessor->setValue('31', "");
                        $templateProcessor->setValue('30', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan13', $caST__);

                    $d->status4 = $data['rbap'];
                    $caAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['caap']));
                    $caAP_ = str_replace("&lt;","<",$caAP);
                    $caAP__ = str_replace("&gt;",">",$caAP_);
                    $d->catatan4 = $data['caap'];

                    if($data['rbap'] == 'ada'){
                        $templateProcessor->setValue('41', "&#8730;");
                        $templateProcessor->setValue('40', "");
                    }else{
                        $templateProcessor->setValue('41', "");
                        $templateProcessor->setValue('40', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan14', $caAP__);

                    $d->status5 = $data['rbaudit1'];
                    $caAudit1 = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit1']));
                    $caAudit1_ = str_replace("&lt;","<",$caAudit1);
                    $caAudit1__ = str_replace("&gt;",">",$caAudit1_);
                    $d->catatan5 = $data['caaudit1'];

                    if($data['rbaudit1'] == 'ada'){
                        $templateProcessor->setValue('51', "&#8730;");
                        $templateProcessor->setValue('50', "");
                    }else{
                        $templateProcessor->setValue('51', "");
                        $templateProcessor->setValue('50', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan15', $caAP__);
                    $templateProcessor->setValue('catatan25', "");

                    $d->status6a = $data['rbaudit2a'];
                    $caAudit2a = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2a']));
                    $caAudit2a_ = str_replace("&lt;","<",$caAudit2a);
                    $caAudit2a__ = str_replace("&gt;",">",$caAudit2a_);
                    $d->catatan6a = $data['caaudit2a'];

                    if($data['rbaudit2a'] == 'ada'){
                        $templateProcessor->setValue('6a1', "&#8730;");
                        $templateProcessor->setValue('6a0', "");
                    }else{
                        $templateProcessor->setValue('6a1', "");
                        $templateProcessor->setValue('6a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16a', $caAudit2a__);
                    $templateProcessor->setValue('catatan26a', "");

                    $d->status6b = $data['rbaudit2b'];
                    $caAudit2b = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2b']));
                    $caAudit2b_ = str_replace("&lt;","<",$caAudit2b);
                    $caAudit2b__ = str_replace("&gt;",">",$caAudit2b_);
                    $d->catatan6b = $data['caaudit2b'];

                    if($data['rbaudit2b'] == 'ada'){
                        $templateProcessor->setValue('6b1', "&#8730;");
                        $templateProcessor->setValue('6b0', "");
                    }else{
                        $templateProcessor->setValue('6b1', "");
                        $templateProcessor->setValue('6b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16b', $caAudit2a__);
                    $templateProcessor->setValue('catatan26b', "");

                    $d->status6c = $data['rbaudit2c'];
                    $caAudit2c = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2c']));
                    $caAudit2c_ = str_replace("&lt;","<",$caAudit2c);
                    $caAudit2c__ = str_replace("&gt;",">",$caAudit2c_);
                    $d->catatan6c = $data['caaudit2c'];

                    if($data['rbaudit2c'] == 'ada'){
                        $templateProcessor->setValue('6c1', "&#8730;");
                        $templateProcessor->setValue('6c0', "");
                    }else{
                        $templateProcessor->setValue('6c1', "");
                        $templateProcessor->setValue('6c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16c', $caAudit2c__);
                    $templateProcessor->setValue('catatan26c', "");

                    $d->status6d = $data['rbaudit2d'];
                    $caAudit2d = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2d']));
                    $caAudit2d_ = str_replace("&lt;","<",$caAudit2d);
                    $caAudit2d__ = str_replace("&gt;",">",$caAudit2d_);
                    $d->catatan6d = $data['caaudit2d'];

                    if($data['rbaudit2d'] == 'ada'){
                        $templateProcessor->setValue('6d1', "&#8730;");
                        $templateProcessor->setValue('6d0', "");
                    }else{
                        $templateProcessor->setValue('6d1', "");
                        $templateProcessor->setValue('6d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16d', $caAudit2d__);
                    $templateProcessor->setValue('catatan26d', "");

                    $d->status7 = $data['rbbap'];
                    $caBAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabap']));
                    $caBAP_ = str_replace("&lt;","<",$caBAP);
                    $caBAP__ = str_replace("&gt;",">",$caBAP_);
                    $d->catatan7 = $data['cabap'];

                    if($data['rbbap'] == 'ada'){
                        $templateProcessor->setValue('71', "&#8730;");
                        $templateProcessor->setValue('70', "");
                    }else{
                        $templateProcessor->setValue('71', "");
                        $templateProcessor->setValue('70', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan17', $caBAP__);
                    $templateProcessor->setValue('catatan27', "");

                    $d->status8 = $data['rbbaps'];
                    $caBAPS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabaps']));
                    $caBAPS_ = str_replace("&lt;","<",$caBAPS);
                    $caBAPS__ = str_replace("&gt;",">",$caBAPS_);
                    $d->catatan8 = $data['cabaps'];

                    if($data['rbbaps'] == 'ada'){
                        $templateProcessor->setValue('81', "&#8730;");
                        $templateProcessor->setValue('80', "");
                    }else{
                        $templateProcessor->setValue('81', "");
                        $templateProcessor->setValue('80', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan18', $caBAPS__);
                    $templateProcessor->setValue('catatan28', "");

                    $d->status9 = $data['rbdh'];
                    $caDH = htmlspecialchars(str_replace("\n","<w:br/>",$data['cadh']));
                    $caDH_ = str_replace("&lt;","<",$caDH);
                    $caDH__ = str_replace("&gt;",">",$caDH_);
                    $d->catatan9 = $data['cadh'];

                    if($data['rbdh'] == 'ada'){
                        $templateProcessor->setValue('91', "&#8730;");
                        $templateProcessor->setValue('90', "");
                    }else{
                        $templateProcessor->setValue('91', "");
                        $templateProcessor->setValue('90', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan19', $caDH__);
                    $templateProcessor->setValue('catatan29', "");

                    $d->status10a = $data['rbskfa'];
                    $caSKFA = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfa']));
                    $caSKFA_ = str_replace("&lt;","<",$caSKFA);
                    $caSKFA__ = str_replace("&gt;",">",$caSKFA_);
                    $d->catatan4 = $data['caskfa'];

                    if($data['rbskfa'] == 'ada'){
                        $templateProcessor->setValue('10a1', "&#8730;");
                        $templateProcessor->setValue('10a0', "");
                    }else{
                        $templateProcessor->setValue('10a1', "");
                        $templateProcessor->setValue('10a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110a', $caDH__);

                    $d->status10b = $data['rbskfb'];
                    $caSKFB = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfb']));
                    $caSKFB_ = str_replace("&lt;","<",$caSKFB);
                    $caSKFB__ = str_replace("&gt;",">",$caSKFB_);
                    $d->catatan10b = $data['caskfb'];

                    if($data['rbskfb'] == 'ada'){
                        $templateProcessor->setValue('10b1', "&#8730;");
                        $templateProcessor->setValue('10b0', "");
                    }else{
                        $templateProcessor->setValue('10b1', "");
                        $templateProcessor->setValue('10b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110b', $caSKFB__);

                    $d->status10c = $data['rbskfc'];
                    $caSKFC = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfc']));
                    $caSKFC_ = str_replace("&lt;","<",$caSKFC);
                    $caSKFC__ = str_replace("&gt;",">",$caSKFC_);
                    $d->catatan10c = $data['caskfc'];

                    if($data['rbskfc'] == 'ada'){
                        $templateProcessor->setValue('10c1', "&#8730;");
                        $templateProcessor->setValue('10c0', "");
                    }else{
                        $templateProcessor->setValue('10c1', "");
                        $templateProcessor->setValue('10c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110c', $caSKFC__);

                    $d->status10d = $data['rbskfd'];
                    $caSKFD = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfd']));
                    $caSKFD_ = str_replace("&lt;","<",$caSKFD);
                    $caSKFD__ = str_replace("&gt;",">",$caSKFD_);
                    $d->catatan10d = $data['caskfd'];

                    if($data['rbskfd'] == 'ada'){
                        $templateProcessor->setValue('10d1', "&#8730;");
                        $templateProcessor->setValue('10d0', "");
                    }else{
                        $templateProcessor->setValue('10d1', "");
                        $templateProcessor->setValue('10d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110d', $caSKFD__);

                    $d->status10e = $data['rbskfe'];
                    $caSKFE = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfe']));
                    $caSKFE_ = str_replace("&lt;","<",$caSKFE);
                    $caSKFE__ = str_replace("&gt;",">",$caSKFE_);
                    $d->catatan10e = $data['caskfe'];

                    if($data['rbskfe'] == 'ada'){
                        $templateProcessor->setValue('10e1', "&#8730;");
                        $templateProcessor->setValue('10e0', "");
                    }else{
                        $templateProcessor->setValue('10e1', "");
                        $templateProcessor->setValue('10e0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110e', $caSKFE__);

                    $d->status10f = $data['rbskff'];
                    $caSKFF = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskff']));
                    $caSKFF_ = str_replace("&lt;","<",$caSKFF);
                    $caSKFF__ = str_replace("&gt;",">",$caSKFF_);
                    $d->catatan10f = $data['caskff'];

                    if($data['rbskff'] == 'ada'){
                        $templateProcessor->setValue('10f1', "&#8730;");
                        $templateProcessor->setValue('10f0', "");
                    }else{
                        $templateProcessor->setValue('10f1', "");
                        $templateProcessor->setValue('10f0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110f', $caSKFF__);

                    $d->save();
                    DB::commit();

                    $fileName = 'FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi ('.$data['id_registrasi'].').docx';
                    $templateProcessor->saveAs("storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian/".$fileName);
            
                    $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                    return response()->download('storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian/'.$fileName);
                
            }else{
                foreach($dataRekomen as $id){
                    foreach($id as $id_daftar_periksa_rekomendasi){
                        $id_daftar_rekomen = $id_daftar_periksa_rekomendasi;
                    }
                }

                // dd($id_daftar_rekomen);
                    $d = $model->find($id_daftar_rekomen);

                    DB::beginTransaction();
                    $d->nama_rekomendasi_tr = $data['nama_tr'];
                    $d->nama_rekomendasi_ks = $data['nama_ks'];
                    $templateProcessor->setValue('nama_rekomendasi', $data['nama_tr']);
                    $templateProcessor->setValue('nama_rekomendasi2', $data['nama_ks']);

                    $d->tgl_rekomendasi_tr = $data['tanggal_rekomendasi_tr'];
                    $d->tgl_rekomendasi_ks = $data['tanggal_rekomendasi_ks'];
                    $templateProcessor->setValue('tgl_rekomendasi', $data['tanggal_rekomendasi_tr']);
                    $templateProcessor->setValue('tgl_rekomendasi2', $data['tanggal_rekomendasi_ks']);

                    $d->status_rekomendasi_tr = $data['kesiapanrekomen_tr'];
                    if($data['kesiapanrekomen_tr'] == 'siap'){                        
                        $templateProcessor->setValue('siap', 'Siap');

                        $inline = new TextRun();
                        $inline->addText('Belum Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('belum_siap', $inline);                        
                    }else{                        
                        $templateProcessor->setValue('belum_siap', 'Belum Siap');

                        $inline = new TextRun();
                        $inline->addText('Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('siap', $inline);
                    }

                    $d->status_rekomendasi_ks = $data['kesiapanrekomen_ks'];
                    if($data['kesiapanrekomen_ks'] == 'siap'){
                        $templateProcessor->setValue('siap2', 'Siap');

                        $inline = new TextRun();
                        $inline->addText('Belum Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('belum_siap2', $inline);
                    }else{                        
                        $templateProcessor->setValue('belum_siap2', 'Belum Siap');

                        $inline = new TextRun();
                        $inline->addText('Siap', array('strikethrough' => true));
                        $templateProcessor->setComplexValue('siap2', $inline);
                    }

                    $d->id_registrasi = $data['id_registrasi'];

                    $d->status1 = $data['rbpenawaran'];
                    $caPenawaran = htmlspecialchars(str_replace("\n","<w:br/>",$data['capenawaran']));
                    $caPenawaran_ = str_replace("&lt;","<",$caPenawaran);
                    $caPenawaran__ = str_replace("&gt;",">",$caPenawaran_);
                    $d->catatan1 = $data['capenawaran'];

                    if($data['rbpenawaran'] == 'ada'){
                        $templateProcessor->setValue('11', "&#8730;");
                        $templateProcessor->setValue('10', "");
                    }else{
                        $templateProcessor->setValue('11', "");
                        $templateProcessor->setValue('10', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan11', $caPenawaran__);

                    $d->status2 = $data['rbkonfirmasi'];
                    $caKonfirmasi = htmlspecialchars(str_replace("\n","<w:br/>",$data['cakonfirmasi']));
                    $caKonfirmasi_ = str_replace("&lt;","<",$caKonfirmasi);
                    $caKonfirmasi__ = str_replace("&gt;",">",$caKonfirmasi_);
                    $d->catatan2 = $data['cakonfirmasi'];

                    if($data['rbkonfirmasi'] == 'ada'){
                        $templateProcessor->setValue('21', "&#8730;");
                        $templateProcessor->setValue('20', "");
                    }else{
                        $templateProcessor->setValue('21', "");
                        $templateProcessor->setValue('20', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan12', $caKonfirmasi__);

                    $d->status3 = $data['rbst'];
                    $caST = htmlspecialchars(str_replace("\n","<w:br/>",$data['cast']));
                    $caST_ = str_replace("&lt;","<",$caST);
                    $caST__ = str_replace("&gt;",">",$caST_);
                    $d->catatan3 = $data['cast'];

                    if($data['rbst'] == 'ada'){
                        $templateProcessor->setValue('31', "&#8730;");
                        $templateProcessor->setValue('30', "");
                    }else{
                        $templateProcessor->setValue('31', "");
                        $templateProcessor->setValue('30', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan13', $caST__);

                    $d->status4 = $data['rbap'];
                    $caAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['caap']));
                    $caAP_ = str_replace("&lt;","<",$caAP);
                    $caAP__ = str_replace("&gt;",">",$caAP_);
                    $d->catatan4 = $data['caap'];

                    if($data['rbap'] == 'ada'){
                        $templateProcessor->setValue('41', "&#8730;");
                        $templateProcessor->setValue('40', "");
                    }else{
                        $templateProcessor->setValue('41', "");
                        $templateProcessor->setValue('40', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan14', $caAP__);

                    $d->status5 = $data['rbaudit1'];
                    $caAudit1 = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit1']));
                    $caAudit1_ = str_replace("&lt;","<",$caAudit1);
                    $caAudit1__ = str_replace("&gt;",">",$caAudit1_);
                    $d->catatan5 = $data['caaudit1'];

                    $caAudit1KS = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit1_ks']));
                    $caAudit1KS_ = str_replace("&lt;","<",$caAudit1KS);
                    $caAudit1KS__ = str_replace("&gt;",">",$caAudit1KS_);
                    $d->catatan5_2 = $data['caaudit1_ks'];

                    if($data['rbaudit1'] == 'ada'){
                        $templateProcessor->setValue('51', "&#8730;");
                        $templateProcessor->setValue('50', "");
                    }else{
                        $templateProcessor->setValue('51', "");
                        $templateProcessor->setValue('50', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan15', $caAudit1__);
                    $templateProcessor->setValue('catatan25', $caAudit1KS__);

                    $d->status6a = $data['rbaudit2a'];
                    $caAudit2a = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2a']));
                    $caAudit2a_ = str_replace("&lt;","<",$caAudit2a);
                    $caAudit2a__ = str_replace("&gt;",">",$caAudit2a_);
                    $d->catatan6a = $data['caaudit2a'];

                    $caAudit2aKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2a_ks']));
                    $caAudit2aKS_ = str_replace("&lt;","<",$caAudit2aKS);
                    $caAudit2aKS__ = str_replace("&gt;",">",$caAudit2aKS_);
                    $d->catatan6a_2 = $data['caaudit2a_ks'];

                    if($data['rbaudit2a'] == 'ada'){
                        $templateProcessor->setValue('6a1', "&#8730;");
                        $templateProcessor->setValue('6a0', "");
                    }else{
                        $templateProcessor->setValue('6a1', "");
                        $templateProcessor->setValue('6a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16a', $caAudit2a__);
                    $templateProcessor->setValue('catatan26a', $caAudit2aKS__);

                    $d->status6b = $data['rbaudit2b'];
                    $caAudit2b = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2b']));
                    $caAudit2b_ = str_replace("&lt;","<",$caAudit2b);
                    $caAudit2b__ = str_replace("&gt;",">",$caAudit2b_);
                    $d->catatan6b = $data['caaudit2b'];

                    $caAudit2bKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2b_ks']));
                    $caAudit2bKS_ = str_replace("&lt;","<",$caAudit2bKS);
                    $caAudit2bKS__ = str_replace("&gt;",">",$caAudit2bKS_);
                    $d->catatan6b_2 = $data['caaudit2b_ks'];

                    if($data['rbaudit2b'] == 'ada'){
                        $templateProcessor->setValue('6b1', "&#8730;");
                        $templateProcessor->setValue('6b0', "");
                    }else{
                        $templateProcessor->setValue('6b1', "");
                        $templateProcessor->setValue('6b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16b', $caAudit2a__);
                    $templateProcessor->setValue('catatan26b', $caAudit2bKS__);

                    $d->status6c = $data['rbaudit2c'];
                    $caAudit2c = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2c']));
                    $caAudit2c_ = str_replace("&lt;","<",$caAudit2c);
                    $caAudit2c__ = str_replace("&gt;",">",$caAudit2c_);
                    $d->catatan6c = $data['caaudit2c'];

                    $caAudit2cKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2c_ks']));
                    $caAudit2cKS_ = str_replace("&lt;","<",$caAudit2cKS);
                    $caAudit2cKS__ = str_replace("&gt;",">",$caAudit2cKS_);
                    $d->catatan6c_2 = $data['caaudit2c_ks'];

                    if($data['rbaudit2c'] == 'ada'){
                        $templateProcessor->setValue('6c1', "&#8730;");
                        $templateProcessor->setValue('6c0', "");
                    }else{
                        $templateProcessor->setValue('6c1', "");
                        $templateProcessor->setValue('6c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16c', $caAudit2c__);
                    $templateProcessor->setValue('catatan26c', $caAudit2cKS__);

                    $d->status6d = $data['rbaudit2d'];
                    $caAudit2d = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2d']));
                    $caAudit2d_ = str_replace("&lt;","<",$caAudit2d);
                    $caAudit2d__ = str_replace("&gt;",">",$caAudit2d_);
                    $d->catatan6d = $data['caaudit2d'];

                    $caAudit2dKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['caaudit2d_ks']));
                    $caAudit2dKS_ = str_replace("&lt;","<",$caAudit2dKS);
                    $caAudit2dKS__ = str_replace("&gt;",">",$caAudit2dKS_);
                    $d->catatan6d_2 = $data['caaudit2d_ks'];

                    if($data['rbaudit2d'] == 'ada'){
                        $templateProcessor->setValue('6d1', "&#8730;");
                        $templateProcessor->setValue('6d0', "");
                    }else{
                        $templateProcessor->setValue('6d1', "");
                        $templateProcessor->setValue('6d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan16d', $caAudit2d__);
                    $templateProcessor->setValue('catatan26d', $caAudit2dKS__);

                    $d->status7 = $data['rbbap'];
                    $caBAP = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabap']));
                    $caBAP_ = str_replace("&lt;","<",$caBAP);
                    $caBAP__ = str_replace("&gt;",">",$caBAP_);
                    $d->catatan7 = $data['cabap'];

                    $caBAPKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabap_ks']));
                    $caBAPKS_ = str_replace("&lt;","<",$caBAPKS);
                    $caBAPKS__ = str_replace("&gt;",">",$caBAPKS_);
                    $d->catatan7_2 = $data['cabap_ks'];

                    if($data['rbbap'] == 'ada'){
                        $templateProcessor->setValue('71', "&#8730;");
                        $templateProcessor->setValue('70', "");
                    }else{
                        $templateProcessor->setValue('71', "");
                        $templateProcessor->setValue('70', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan17', $caBAP__);
                    $templateProcessor->setValue('catatan27', $caBAPKS__);

                    $d->status8 = $data['rbbaps'];
                    $caBAPS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabaps']));
                    $caBAPS_ = str_replace("&lt;","<",$caBAPS);
                    $caBAPS__ = str_replace("&gt;",">",$caBAPS_);
                    $d->catatan8 = $data['cabaps'];

                    $caBAPSKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cabaps_ks']));
                    $caBAPSKS_ = str_replace("&lt;","<",$caBAPSKS);
                    $caBAPSKS__ = str_replace("&gt;",">",$caBAPSKS_);
                    $d->catatan8_2 = $data['cabaps_ks'];

                    if($data['rbbaps'] == 'ada'){
                        $templateProcessor->setValue('81', "&#8730;");
                        $templateProcessor->setValue('80', "");
                    }else{
                        $templateProcessor->setValue('81', "");
                        $templateProcessor->setValue('80', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan18', $caBAPS__);
                    $templateProcessor->setValue('catatan28', $caBAPSKS__);

                    $d->status9 = $data['rbdh'];
                    $caDH = htmlspecialchars(str_replace("\n","<w:br/>",$data['cadh']));
                    $caDH_ = str_replace("&lt;","<",$caDH);
                    $caDH__ = str_replace("&gt;",">",$caDH_);
                    $d->catatan9 = $data['cadh'];

                    $caDHKS = htmlspecialchars(str_replace("\n","<w:br/>",$data['cadh_ks']));
                    $caDHKS_ = str_replace("&lt;","<",$caDHKS);
                    $caDHKS__ = str_replace("&gt;",">",$caDHKS_);
                    $d->catatan9_2 = $data['cadh_ks'];

                    if($data['rbdh'] == 'ada'){
                        $templateProcessor->setValue('91', "&#8730;");
                        $templateProcessor->setValue('90', "");
                    }else{
                        $templateProcessor->setValue('91', "");
                        $templateProcessor->setValue('90', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan19', $caDH__);
                    $templateProcessor->setValue('catatan29', $caDHKS__);

                    $d->status10a = $data['rbskfa'];
                    $caSKFA = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfa']));
                    $caSKFA_ = str_replace("&lt;","<",$caSKFA);
                    $caSKFA__ = str_replace("&gt;",">",$caSKFA_);
                    $d->catatan10a = $data['caskfa'];

                    if($data['rbskfa'] == 'ada'){
                        $templateProcessor->setValue('10a1', "&#8730;");
                        $templateProcessor->setValue('10a0', "");
                    }else{
                        $templateProcessor->setValue('10a1', "");
                        $templateProcessor->setValue('10a0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110a', $caDH__);

                    $d->status10b = $data['rbskfb'];
                    $caSKFB = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfb']));
                    $caSKFB_ = str_replace("&lt;","<",$caSKFB);
                    $caSKFB__ = str_replace("&gt;",">",$caSKFB_);
                    $d->catatan10b = $data['caskfb'];

                    if($data['rbskfb'] == 'ada'){
                        $templateProcessor->setValue('10b1', "&#8730;");
                        $templateProcessor->setValue('10b0', "");
                    }else{
                        $templateProcessor->setValue('10b1', "");
                        $templateProcessor->setValue('10b0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110b', $caSKFB__);

                    $d->status10c = $data['rbskfc'];
                    $caSKFC = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfc']));
                    $caSKFC_ = str_replace("&lt;","<",$caSKFC);
                    $caSKFC__ = str_replace("&gt;",">",$caSKFC_);
                    $d->catatan10c = $data['caskfc'];

                    if($data['rbskfc'] == 'ada'){
                        $templateProcessor->setValue('10c1', "&#8730;");
                        $templateProcessor->setValue('10c0', "");
                    }else{
                        $templateProcessor->setValue('10c1', "");
                        $templateProcessor->setValue('10c0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110c', $caSKFC__);

                    $d->status10d = $data['rbskfd'];
                    $caSKFD = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfd']));
                    $caSKFD_ = str_replace("&lt;","<",$caSKFD);
                    $caSKFD__ = str_replace("&gt;",">",$caSKFD_);
                    $d->catatan10d = $data['caskfd'];

                    if($data['rbskfd'] == 'ada'){
                        $templateProcessor->setValue('10d1', "&#8730;");
                        $templateProcessor->setValue('10d0', "");
                    }else{
                        $templateProcessor->setValue('10d1', "");
                        $templateProcessor->setValue('10d0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110d', $caSKFD__);

                    $d->status10e = $data['rbskfe'];
                    $caSKFE = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskfe']));
                    $caSKFE_ = str_replace("&lt;","<",$caSKFE);
                    $caSKFE__ = str_replace("&gt;",">",$caSKFE_);
                    $d->catatan10e = $data['caskfe'];

                    if($data['rbskfe'] == 'ada'){
                        $templateProcessor->setValue('10e1', "&#8730;");
                        $templateProcessor->setValue('10e0', "");
                    }else{
                        $templateProcessor->setValue('10e1', "");
                        $templateProcessor->setValue('10e0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110e', $caSKFE__);

                    $d->status10f = $data['rbskff'];
                    $caSKFF = htmlspecialchars(str_replace("\n","<w:br/>",$data['caskff']));
                    $caSKFF_ = str_replace("&lt;","<",$caSKFF);
                    $caSKFF__ = str_replace("&gt;",">",$caSKFF_);
                    $d->catatan10f = $data['caskff'];

                    if($data['rbskff'] == 'ada'){
                        $templateProcessor->setValue('10f1', "&#8730;");
                        $templateProcessor->setValue('10f0', "");
                    }else{
                        $templateProcessor->setValue('10f1', "");
                        $templateProcessor->setValue('10f0', "&#8730;");
                    }
                    $templateProcessor->setValue('catatan110f', $caSKFF__);

                    $d->save();
                    DB::commit();

                    $fileName = 'FOR-HALAL-OPS-13 Daftar Periksa dan Rekomendasi ('.$data['id_registrasi'].').docx';
                    $templateProcessor->saveAs("storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian2/".$fileName);
            
                    $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                    return response()->download('storage/laporan/download/Daftar Periksa Dan Rekomendasi/Isian2/'.$fileName);
            }
        }
    }
    
}
