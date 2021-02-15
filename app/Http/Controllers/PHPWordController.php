<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PDF;
use HTML;
use TemplateProcessor;


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

    public function downloadAuditPlan(Request $request){

        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();        

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan.docx');

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

        $templateProcessor->saveAs("AuditPlan.docx");        
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                
        $phpWord = $objReader->load("AuditPlan.docx");                
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('AuditPlan.html');        
        return response()->download('AuditPlan.docx');

        $dompdf = new Dompdf();
        $html = file_get_contents("AP.html"); 
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'landscape');
        
        $dompdf->render();
        
        $dompdf->stream();
        
    }

    public function downloadAuditPlanFix(Request $request){
        // dd("didieu");

        $data = $request->except('_token','_method');
        // dd("disini");
        $phpWord = new \PhpOffice\PhpWord\PhpWord();        

        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('FOR-SCI-HALAL-13 Rencana Audit atau Audit Plan Complete.docx');

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
        $templateProcessor->setValue('tujuan_audit', $data['tujuan_audit']);
        $templateProcessor->setValue('standar', $data['standar']);
        $templateProcessor->setValue('lingkup_audit', $data['lingkup_audit']);
        $templateProcessor->setValue('lokasi_audit1', $data['lokasi_audit1']);
        $templateProcessor->setValue('lokasi_audit2', $data['lokasi_audit2']);
        $templateProcessor->setValue('tim_audit1', $data['tim_audit1']);
        $templateProcessor->setValue('tim_audit2', $data['tim_audit2']);
        $templateProcessor->setValue('tim_audit3', $data['tim_audit3']);

        $values = [                        
            ['tgl_waktu' => 'Selasa, 1/12/2021', 'detail_waktu' => '07.00 - 09.00', 'judul_kegiatan' => 'Opening', 'detail_kegiatan' => 'Pembukaan Doa','personil' => 'Hamdan'],
        ];                
        $templateProcessor->cloneRowAndSetValues('tgl_waktu', $values);

        $templateProcessor->saveAs("AuditPlan.docx");        
        
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                
        $phpWord = $objReader->load("AuditPlan.docx");                
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('AuditPlan.html');        
        return response()->download('AuditPlan.docx');

        $dompdf = new Dompdf();
        $html = file_get_contents("AP.html"); 
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'landscape');
        
        $dompdf->render();
        
        $dompdf->stream();
        
    }
}
