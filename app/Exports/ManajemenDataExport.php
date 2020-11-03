<?php

namespace App\Exports;

use App\Models\TanahBangunan;
use App\Models\NonTanahBangunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ManajemenDataExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($code,$kategori)
    {
        $this->code     = $code;
        $this->kategori = $kategori;
    }

    public function collection()
    {
        $kategori   = $this->kategori;
        $code       = $this->code;

        if($kategori == "TB"){
            if($code == '0'){
                $getData    =   DB::table('tanahbangunanproto')
                                ->orderBy('id','asc')
                                ->get();
            }else{
                $getData    =   DB::table('tanahbangunanproto')
                                ->where('bumn_code','=',$code)
                                ->orderBy('id','asc')
                                ->get();
            }

        }elseif($kategori == "NTB"){
            if($code == '0'){
                $getData    =   DB::table('nontanahbangunanproto')
                    ->orderBy('id','asc')
                    ->get();
            }else{
                $getData    =   DB::table('nontanahbangunanproto')
                    ->where('bumn_code','=',$code)
                    ->orderBy('id','asc')
                    ->get();
            }
        }

        //return TanahBangunan::all();
        return $getData;
    }

    public function headings(): array
    {
        $kategori   = $this->kategori;

        $headTB = [
            'id',
            'bumn_code',
            'no_item',
            'nama_asset',
            'kode_kelompok_asset',
            'provinsi',
            'lokasi_koordinat',
            'lokasi_rutr',
            'lokasi_alamat',
            'kondisi_fisik',
            'keterangan_detail',
            'kondisi_utilitas',
            'kondisi_histori',
            'luasan_tanah',
            'luasan_tanah',
            'luasan_bangunan',
            'luasan_bangunan_2',
            'faktor_gempa',
            'faktor_banjir',
            'faktor_longsor',
            'faktor_tsunami',
            'faktor_puting_beliung',
            'faktor_petir',
            'faktor_erupsi',
            'publik_air',
            'publik_listrik',
            'publik_jaringan',
            'publik_telekomunikasi',
            'legal_hgb',
            'legal_masalah',
            'legal_imb',
            'p_nilai_awal',
            'p_nilai_revaluasi',
            'p_tahun_awal',
            'p_tahun_revaluasi',
        ];

        $headNTB = [
            'id',
            'bumn_code',
            'no_item',
            'nama_asset',
            'kode_kelompok_asset',
            'provinsi',
            'lokasi_koordinat',
            'lokasi_alamat',
            'spek_merek',
            'spek_tipe',
            'spek_dimensi',
            'spek_mobilitas',
            'spek_keterangan',
            'spek_sdk',
            'kondisi_fisik',
            'keterangan_detail',
            'utilitas',
            'histori_perbaikan',
            'kalibrasi_periode',
            'kalibrasi_tanggal_terakhir',
            'kalibrasi_tanggal_berikut',
            'kalibrasi_institusi',
            'lisensi_perolehan',
            'lisensi_tanggal_akhir',
            'lisensi_tanggal_berikut',
            'lisensi_institusi',
            'p_nilai_awal',
            'p_nilai_revaluasi',
            'p_tahun_awal',
            'p_tahun_revaluasi',
        ];

        if($kategori == 'TB'){
            return $headTB;
        }
        if($kategori == 'NTB'){
            return $headNTB;
        }
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $kategori   = $this->kategori;
                if($kategori == 'TB'){ $cellRange = 'A1:AI1';}
                if($kategori == 'NTB'){ $cellRange = 'A1:AD1';}
                //$cellRange = 'A1:AC1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function map($row): array
    {
        $kategori   = $this->kategori;

        if($kategori =='TB'){
            $getRow = [
                $row->id,
                $row->bumn_code,
                $row->no_item,
                $row->nama_asset,
                $row->kode_kelompok_asset,
                $row->provinsi,
                $row->lokasi_koordinat,
                ($row->lokasi_rutr == '1') ? "Investasi"
                    :(($row->lokasi_rutr == '2') ? "Perumahan"
                        : "Perkebunan"),
                $row->lokasi_alamat,
                ($row->kondisi_fisik == '0')? 'Rusak':'Baik',
                ($row->keterangan_detail == '1') ? "Perlu perbaikan"
                    :(($row->keterangan_detail == '2') ? "Siap digunanakan"
                    :(($row->keterangan_detail == '3') ? "Masih bisa digunakan"
                    : "Tidak bisa digunakan")),
                ($row->kondisi_utilitas == '0')? 'Idle':'Terpakai',
                $row->kondisi_histori,
                $row->luasan_tanah,
                $row->luasan_bangunan,
                $row->luasan_bangunan_2,
                ($row->faktor_gempa == '0')? 'Tidak':'Ya',
                ($row->faktor_banjir == '0')? 'Tidak':'Ya',
                ($row->faktor_longsor == '0')? 'Tidak':'Ya',
                ($row->faktor_tsunami == '0')? 'Tidak':'Ya',
                ($row->faktor_puting_beliung == '0')? 'Tidak':'Ya',
                ($row->faktor_petir == '0')? 'Tidak':'Ya',
                ($row->faktor_erupsi == '0')? 'Tidak':'Ya',
                ($row->publik_air == '0')? 'Air Tanah':'PAM',
                ($row->publik_listrik == '1') ? "PLN"
                    :(($row->publik_listrik == '2') ? "Genset"
                : "Solar Cell"),
                ($row->publik_jaringan == '0')? 'Tidak':'Ada',
                ($row->publik_telekomunikasi == '0')? 'Fixed':'Celluler',
                $row->legal_hgb,
                ($row->legal_masalah == '0')? 'Tidak':'Ya',
                ($row->legal_imb == '0')? 'Tidak':'Ya',
                ($row->legal_imb == '0')? 'Tidak':'Ya',
                $row->p_nilai_awal,
                $row->p_nilai_revaluasi,
                $row->p_tahun_awal,
                $row->p_tahun_revaluasi,
            ];
        }
        if($kategori =='NTB'){
            $getRow = [
                $row->id,
                $row->bumn_code,
                $row->no_item,
                $row->nama_asset,
                $row->kode_kelompok_asset,
                $row->provinsi,
                $row->lokasi_koordinat,
                $row->lokasi_alamat,
                $row->spek_merek,
                $row->spek_tipe,
                $row->spek_dimensi,
                ($row->spek_mobilitas == '0')? 'Portable':'Fixed',
                $row->spek_keterangan,
                ($row->spek_sdk == '0')? 'Tidak':'Ya',
                ($row->kondisi_fisik == '0')? 'Rusak':'Baik',
                ($row->keterangan_detail == '1') ? "Perlu perbaikan"
                    :(($row->keterangan_detail == '2') ? "Siap digunanakan"
                    :(($row->keterangan_detail == '3') ? "Masih bisa digunakan"
                        : "Tidak bisa digunakan")),
                ($row->utilitas == '0')? 'Idle':'Terpakai',
                $row->histori_perbaikan,
                $row->kalibrasi_periode,
                $row->kalibrasi_tanggal_terakhir,
                $row->kalibrasi_tanggal_berikut,
                $row->kalibrasi_institusi,
                $row->lisensi_perolehan,
                $row->lisensi_tanggal_akhir,
                $row->lisensi_tanggal_berikut,
                $row->lisensi_institusi,
                $row->p_nilai_awal,
                $row->p_nilai_revaluasi,
                $row->p_tahun_awal,
                $row->p_tahun_revaluasi,
            ];
        }

        return  $getRow;
    }
}
