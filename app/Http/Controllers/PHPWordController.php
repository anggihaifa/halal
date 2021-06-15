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
use App\DetailLaporanSJPH;
use App\LaporanBahan;
use App\DetailLaporanBahan;
use App\LaporanFasilitasProduk;
use App\DetailLaporanFasilitasProduk;
use App\LaporanProduk;
use App\LaporanAudit2;
use App\DetailLaporanProduk;
use App\DetailLaporanProdukFoto;
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
        // dd("didieu");

        $data = $request->except('_token','_method');        

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/docx/FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan Complete.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/fix/FOR-HALAL-OPS-04 Rencana Audit Isian.docx');

        $templateProcessor->setValue('no_id_bpjph', $data['no_id_bpjph']);        

        $model = new PerencanaanAudit();
        DB::beginTransaction();
            $model->id_user = Auth::user()->id;
            $model->id_registrasi = $data['id_registrasi'];
            $model->no_id_bpjph = $data['no_id_bpjph'];
            $model->skema_audit = $data['skema_audit'];
            $model->status_sertifikasi = $data['status_sertifikasi'];
            $model->no_audit = $data['no_audit'];
            $model->nama_organisasi = $data['nama_perusahaan'];
            $model->alamat = $data['alamat'];
            $model->tanggal_audit = $data['tanggal_audit'];
            $model->tujuan_audit = $data['tujuan_audit'];
            $model->lingkup_audit = $data['lingkup_audit'];
            $model->jenis_produk = $data['jenis_produk'];
            $model->lokasi_audit1 = $data['lokasi_audit1'];
            $model->lokasi_audit2 = $data['lokasi_audit2'];
            $model->tim_audit1 = $data['tim_audit1'];
            $model->tim_audit2 = $data['tim_audit2'];
            $model->tim_audit3 = $data['tim_audit3'];                    

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        if($data['skema_audit'] == 'sjh'){            
            $templateProcessor->setValue('sjh', 'SJH');

            $inline = new TextRun();
            $inline->addText('SJPH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjph', $inline);
            
            $model->skema_audit = 'sjh';
        }else if($data['skema_audit'] == 'sjph'){
            $templateProcessor->setValue('sjph', 'SJPH');

            $inline = new TextRun();
            $inline->addText('SJH', array('strikethrough' => true));
            $templateProcessor->setComplexValue('sjh', $inline);

            $model->skema_audit = 'sjph';
        }

        if($data['status_sertifikasi'] == 'baru'){
            $templateProcessor->setValue('baru', 'Baru');

            $inline = new TextRun();
            $inline->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);

            $model->status_sertifikasi = 'baru';
        }else if($data['status_sertifikasi'] == 'perpanjangan'){            
            $templateProcessor->setValue('perpanjangan', 'Perpanjangan');            

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perubahan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);            

            $model->status_sertifikasi = 'perpanjangan';
        }else if($data['status_sertifikasi'] == 'perubahan'){            
            $templateProcessor->setValue('perubahan', 'Perubahan');

            $inline = new TextRun();
            $inline->addText('Baru', array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText('Perpanjangan', array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline2);

            $model->status_sertifikasi = 'perubahan';
        }

        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('nama_organisasi', $data['nama_organisasi']);
        $templateProcessor->setValue('alamat', $data['alamat']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);
        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('jenis_produk', $data['jenis_produk']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        $templateProcessor->setValue('tim_audit1', $data['tim_audit1']);
        $templateProcessor->setValue('tim_audit2', $data['tim_audit2']);
        $templateProcessor->setValue('tim_audit3', $data['tim_audit3']);        
        
        $model->save();
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
            for ($j=$temp; $j < $temp2+$jml; $j++) {                 
                if($j == $temp2){
                    $harike++;
                    $arrData[] = array('hari_ke' => 'Hari '.$harike.'','tgl_waktu' => $hari.', '.$tgl.'','detail_waktu' => $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j], 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $data['detail_kegiatan'][$j], 'personil' => $data['personil'][$j]);

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
                    $arrData[] = array('hari_ke' => '','tgl_waktu' => $data['jam_audit'][$j].' - '.$data['jam_audit2'][$j],'detail_waktu' => '', 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $data['detail_kegiatan'][$j], 'personil' => $data['personil'][$j]);

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
                $temp = $j+1;
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
                    $model->id_registrasi = $data['idregis'];                    
                    $model->save();
                DB::Commit();
            }else{
                $model2 = new LaporanAudit2;                
                $f = $model2->find($dataLaporan[0]->id);
                $f->rencana_audit_isian = $fileName;                
                $f->save();                
            }
            DB::Commit();        

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

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL Laporan Audit Tahap 2 Complete.docx');

        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);
        $templateProcessor->setValue('nomor_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('merk_dagang', $data['merk_dagang']);
        $templateProcessor->setValue('alamat_perusahaan', $data['alamat_perusahaan']);

        $tglhari = strtotime($data['tanggal_audit']);
        $hari = date('l', $tglhari);

        $templateProcessor->setValue('hari', $hari);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);
        $templateProcessor->setValue('auditor1', $data['nama_auditor1']);
        $templateProcessor->setValue('posisi1', "Ketua Tim Auditor");
        $templateProcessor->setValue('auditor2', $data['nama_auditor2']);
        $templateProcessor->setValue('posisi2', "Auditor");
        $templateProcessor->setValue('auditor3', $data['nama_auditor3']);
        $templateProcessor->setValue('posisi3', "Auditor");
        $templateProcessor->setValue('auditee', $data['auditee']);
        
        if($data['status_sertifikasi'] == "baru"){
            $inline = new TextRun();
            $inline->addText("Perpanjangan", array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline);

            $inline2 = new TextRun();
            $inline2->addText("Perubahan", array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);

            $templateProcessor->setValue('baru', "Baru");            
        }else if($data['status_sertifikasi'] == "perpanjangan"){
            $inline = new TextRun();
            $inline->addText("Baru", array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText("Perubahan", array('strikethrough' => true));
            $templateProcessor->setComplexValue('perubahan', $inline2);

            $templateProcessor->setValue('perpanjangan', "Perpanjangan");
        }else if($data['status_sertifikasi'] == "perubahan"){
            $inline = new TextRun();
            $inline->addText("Baru", array('strikethrough' => true));
            $templateProcessor->setComplexValue('baru', $inline);

            $inline2 = new TextRun();
            $inline2->addText("Perpanjangan", array('strikethrough' => true));
            $templateProcessor->setComplexValue('perpanjangan', $inline2);

            $templateProcessor->setValue('perubahan', "Perubahan");
        }

        $templateProcessor->setValue('penyelia_halal', $data['penyelia_halal']);

        $jml=1;
        $arrData=array();
        
        $temp=0;
                
        // $templateProcessor->cloneBlock('foto', 1, true, true);
        for ($i=0; $i < sizeof($data['nama_fasilitas']); $i++) {
            $no = $jml;            

            $nama_fasilitas = $data['nama_fasilitas'][$i];
            $alamat_fasilitas = $data['alamat_fasilitas'][$i];
            $kota_fasilitas = $data['kota_fasilitas'][$i];
            $negara_fasilitas = $data['negara_fasilitas'][$i];

            $file = $request->file("foto_fasilitas_produksi_fix");
            $file = $data["foto_fasilitas_produksi_fix"][$i];
            // $profileImage = "LaporanFasilitasProduksi_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $profileImage = "LaporanFasilitasProduksi_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->storeAs("public/laporanproduk/",$profileImage);
            // dd('foto_fasilitas_produksi#'.$no);
            $templateProcessor->setImageValue('foto_fasilitas_produksi#'.$no, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 70, 'height' =>70, 'ratio' => true));
            // $templateProcessor->cloneBlock('foto', sizeof($data['foto_fasilitas_produksi_fix']), true, true);
            // $templateProcessor->setImageValue('foto_fasilitas_produksi#'.$no, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 70, 'height' =>70, 'ratio' => true));
            // $templateProcessor->setImageValue('foto_fasilitas_produksi#'.$i, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 70, 'height' =>70, 'ratio' => false));

            $arrData[] = array('no' => $no, 'nama_fasilitas' => $nama_fasilitas, 'alamat_fasilitas' => $alamat_fasilitas, 'kota_fasilitas' => $kota_fasilitas, 'negara_fasilitas' => $negara_fasilitas);
            // $arrData[] = array('no' => $no, 'nama_fasilitas' => $nama_fasilitas, 'foto_fasilitas_produksi' => $profileImage, 'alamat_fasilitas' => $alamat_fasilitas, 'kota_fasilitas' => $kota_fasilitas, 'negara_fasilitas' => $negara_fasilitas);
            $jml++;
        }            

        $values = $arrData;        
        // $templateProcessor->cloneRow('no', sizeof($data['nama_fasilitas']));
        $templateProcessor->cloneRowAndSetValues('no', $values);

        // $jml2=1;
        // $arrData2=array();
        
        // $temp2=0;
        // $templateProcessor->cloneBlock('foto', sizeof($data['foto_produk']), true, true);
        // for ($i=0; $i < sizeof($data['foto_produk']); $i++) {
        //     $no = $jml2;

        //     $file = $request->file("foto_produk");
        //     $file = $data["foto_produk"][$i];
        //     $profileImage = "LaporanProduk_".$i.$data['id_registrasi']."_".$data['id_penjadwalan']."_".date('YmdHis') . "." . $file->getClientOriginalExtension();
        //     $file->storeAs("public/laporanproduk/",$profileImage);

        //     // $pelatihan->gambar_cover = $profileImage;
        //     $templateProcessor->setImageValue('foto_produk#'.$no, array('path' => 'storage/laporanproduk/'.$profileImage, 'width' => 300, 'height' =>300, 'ratio' => true));
        //     $templateProcessor->setValue('keterangan_foto#'.$no, $data['keterangan_foto'][$i]);

        //     $model3 = new DetailLaporanProdukFoto();
        //     DB::beginTransaction();
        //         $model3->id_laporan_produk = $idlaporanproduk;
        //         $model3->kategori = "Industri Pengolahan";
        //         $model3->foto_produk = $profileImage;
        //         $model3->keterangan_foto = $data['keterangan_foto'][$i];
        //         $model3->save();
        //     DB::Commit();

        //     $jml2++;
        // }

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanBahan_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                

        return response()->download('storage/laporan/upload/'.$fileName);
    }

    public function downloadLaporanAuditTahap2Fix(Request $request){
        $data = $request->except('_token','_method');

        dd($data);
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 

        $model = new LaporanAuditTahap2();             
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-05 Laporan Audit Tahap 2 Complete.docx');

        $templateProcessor->setValue('no_id', $data['nomor_id']);
        $templateProcessor->setValue('skema_audit', $data['skema_audit']);
        $templateProcessor->setValue('jenis_audit', $data['jenis_audit']);
        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('nama_perusahaan', $data['nama_perusahaan']);
        $templateProcessor->setValue('alamat', $data['alamat']);
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('jenis_produk', $data['jenis_produk']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        $templateProcessor->setValue('tim_audit1', $data['tim_audit1']);
        $templateProcessor->setValue('tim_audit2', $data['tim_audit2']);
        $templateProcessor->setValue('tanggal_audit', $data['tanggal_audit']);

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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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
        $model2->id_laporan_audit_tahap2 = $idlap;      
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

            $fileName = 'FOR-HALAL-OPS-03 Konfirmasi Jadwal,Syarat & Ketentuan Audit ('.$data['idregis'].').pdf';
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
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_konfirmasi_sk_audit = $fileName;
                $f->tgl_penyerahan_konfirmasi_sk_audit = $ldate;
                $f->save();                
            }
            DB::Commit();
        }else if($request->has("berkas_bap")){
            $file = $request->file("berkas_bap");            
            $file = $data["berkas_bap"];

            $fileName = 'FOR-HALAL-OPS-07 Berita Acara Pemeriksaaan ('.$data['idregis'].').pdf';
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
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_bap = $fileName;
                $f->tgl_penyerahan_bap = $ldate;
                $f->save();                
            }
            DB::Commit();
        }else if($request->has("berkas_ap")){
            $file = $request->file("berkas_ap");            
            $file = $data["berkas_ap"];

            $fileName = 'FOR-HALAL-OPS-04 Rencana Audit ('.$data['idregis'].').pdf';
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
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_rencana_audit = $fileName;
                $f->tgl_penyerahan_rencana_audit = $ldate;
                $f->save();                
            }
            DB::Commit();
        }else if($request->has("berkas_laporan2")){
            $file = $request->file("berkas_laporan2");            
            $file = $data["berkas_laporan2"];

            $fileName = 'FOR-HALAL-OPS-06 Laporan Audit Tahap II ('.$data['idregis'].').pdf';
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
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_laporan_audit_tahap_2 = $fileName;
                $f->tgl_penyerahan_laporan_audit_tahap_2 = $ldate;
                $f->save();                
            }
            DB::Commit();
        }else if($request->has("berkas_checklist")){
            $file = $request->file("berkas_checklist");            
            $file = $data["berkas_checklist"];

            $fileName = 'FOR-HALAL-OPS-09 Formulir Ceklist Audit ('.$data['idregis'].').pdf';
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
            }else{
                $model2 = new LaporanAudit2;
                $ldate = date('Y-m-d H:i:s');
                $f = $model2->find($dataLaporan[0]->id);
                $f->file_form_ceklis = $fileName;
                $f->tgl_penyerahan_form_ceklis = $ldate;
                $f->save();                
            }
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
    
}
