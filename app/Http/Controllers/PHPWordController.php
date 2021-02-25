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

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/docx/FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan.docx');

        $templateProcessor->setValue('judul', 'Rencana Audit');        

        if($data['jenis_audit'] == "baru"){
            $templateProcessor->setValue('baru', 'Baru');
            $templateProcessor->setValue('pembaruan', ' ');
            $templateProcessor->setValue('perubahan', ' ');
        }else if($data['jenis_audit'] == "pembaruan"){
            $templateProcessor->setValue('baru', ' ');
            $templateProcessor->setValue('pembaruan', 'Pembaruan');
            $templateProcessor->setValue('perubahan', ' ');
        }else if($data['jenis_audit'] == "perubahan"){
            $templateProcessor->setValue('baru', ' ');
            $templateProcessor->setValue('pembaruan', ' ');
            $templateProcessor->setValue('perubahan', 'Perubahan');
        }

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('alamat', $data['alamat_perusahaan']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);        

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_AuditPlan_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs("storage/docx/download/".$fileName);
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                
        $phpWord = $objReader->load("storage/docx/download/".$fileName);
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $fileName2 = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_AuditPlan_'.$data['nama_perusahaan'].'.html';
        $objWriter->save('storage/docx/download/'.$fileName2);
        return response()->download('storage/docx/download/'.$fileName);

        $dompdf = new Dompdf();
        $html = file_get_contents('storage/docx/download/'.$fileName); 
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'landscape');
        
        $dompdf->render();
        
        $dompdf->stream();
        
    }

    public function downloadLaporanAuditSJPH(Request $request){
        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();                
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-07 Format Laporan SJPH.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);

        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanSJPH_'.$data['nama_perusahaan'].'.docx';
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
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/docx/FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan Complete.docx');

        $templateProcessor->setValue('judul', 'Rencana Audit');        

        if($data['jenis_audit'] == "baru"){
            $templateProcessor->setValue('baru', 'Baru');
            $templateProcessor->setValue('pembaruan', ' ');
            $templateProcessor->setValue('perubahan', ' ');
        }else if($data['jenis_audit'] == "pembaruan"){
            $templateProcessor->setValue('baru', ' ');
            $templateProcessor->setValue('pembaruan', 'Pembaruan');
            $templateProcessor->setValue('perubahan', ' ');
        }else if($data['jenis_audit'] == "perubahan"){
            $templateProcessor->setValue('baru', ' ');
            $templateProcessor->setValue('pembaruan', ' ');
            $templateProcessor->setValue('perubahan', 'Perubahan');
        }

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('alamat', $data['alamat_perusahaan']);
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);
        $templateProcessor->setValue('no_organisasi', $data['no_organisasi']);
        $templateProcessor->setValue('no_audit', $data['no_audit']);
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('standar', $data['standar']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        $templateProcessor->setValue('tim_audit1', $data['tim_audit1']);
        $templateProcessor->setValue('tim_audit2', $data['tim_audit2']);
        $templateProcessor->setValue('tim_audit3', $data['tim_audit3']);        
        
        $jml=0;
        $arrData=array();
        
        $temp=0;
        $temp2=0;
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
            $jml = $data['jumlah_kegiatan'][$i];

            $temp2 = $temp;
            for ($j=$temp; $j < $temp2+$jml; $j++) { 
                if($j == $temp2){
                    $arrData[] = array('tgl_waktu' => $hari.', '.$tgl.'','detail_waktu' => $data['jam_audit'][$j], 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $data['detail_kegiatan'][$j], 'personil' => $data['personil'][$j]);
                }else{
                    $arrData[] = array('tgl_waktu' => "",'detail_waktu' => $data['jam_audit'][$j], 'judul_kegiatan' => $data['judul_kegiatan'][$j], 'detail_kegiatan' => $data['detail_kegiatan'][$j], 'personil' => $data['personil'][$j]);
                }
                $temp = $j+1;
            }            
        }    
        // dd($arrData);                      
        // dd($data);

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('tgl_waktu', $values);
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_AuditPlan_'.$data['nama_perusahaan'].'_'.$data['no_audit'].'.docx';
        $templateProcessor->saveAs('storage/docx/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                
        $phpWord = $objReader->load('storage/docx/upload/'.$fileName);
        // $phpWord = $objReader->load("AuditPlan.docx");
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $fileName2 = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_AuditPlan_'.$data['nama_perusahaan'].'_'.$data['no_audit'].'.html';
        $objWriter->save('storage/docx/upload/'.$fileName2);
        // $objWriter->save('AuditPlan.html');   
        DB::beginTransaction();
        $model = new Registrasi;
        $model2 = new Penjadwalan;

        // $e = $model->find($data['id_registrasi']);
        $f = $model2->find($data['id_penjadwalan']);
        $f->berkas_audit_plan = $fileName;
        // dd($f->berkas_audit_plan);
        $f->save();
        DB::Commit();

        return response()->download('storage/docx/upload/'.$fileName);        
        
    }

    public function downloadLaporanAuditSJPHFix(Request $request){
        $data = $request->except('_token','_method');        

        // dd($data);
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-07 Format Laporan SJPH Complete.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);        
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

            $arrData[] = array('no' => $no, 'kriteria' => $kriteria, 'temuan' => $temuan);
            $jml++;            
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanSJPH_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                        
        
        // DB::beginTransaction();
        // $model = new Registrasi;
        // $model2 = new Penjadwalan;

        
        // $f = $model2->find($data['id_penjadwalan']);
        // $f->berkas_audit_plan = $fileName;
        // $f->save();
        // DB::Commit();

        return response()->download('storage/laporan/upload/'.$fileName);
    }

    public function downloadLaporanAuditBahanFix(Request $request){
        $data = $request->except('_token','_method');        

        // dd($data);
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('storage/laporan/FOR-SCI-HALAL-06 Format Laporan Bahan Complete.docx');

        $templateProcessor->setValue('nama_organisasi', $data['nama_perusahaan']);
        $templateProcessor->setValue('no_registrasi', $data['no_registrasi']);
        $templateProcessor->setValue('nama_auditor', $data['nama_auditor']);            
        $templateProcessor->setValue('tgl_audit', $data['tanggal_audit']);
        
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

            $arrData[] = array('no' => $no, 'bahan' => $bahan, 'temuan' => $temuan, 'kategori_bahan' => $kategori_bahan, 'catatan' => $catatan);
            $jml++;            
        }            

        $values = $arrData;
        $templateProcessor->cloneRowAndSetValues('no', $values);
        
        $fileName = $data['id_registrasi'].'_'.$data['id_penjadwalan'].'_LaporanBahan_'.$data['nama_perusahaan'].'.docx';
        $templateProcessor->saveAs('storage/laporan/upload/'.$fileName);
        // $templateProcessor->saveAs("AuditPlan.docx");
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');                        
        
        // DB::beginTransaction();
        // $model = new Registrasi;
        // $model2 = new Penjadwalan;

        
        // $f = $model2->find($data['id_penjadwalan']);
        // $f->berkas_audit_plan = $fileName;
        // $f->save();
        // DB::Commit();

        return response()->download('storage/laporan/upload/'.$fileName);
    }
}
