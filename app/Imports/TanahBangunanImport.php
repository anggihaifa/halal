<?php

namespace App\Imports;

use App\Models\TanahBangunan;
use App\Models\NonTanahBangunan;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue; //IMPORT SHOUDLQUEUE
use Maatwebsite\Excel\Concerns\WithChunkReading; //IMPORT CHUNK READING
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;


class TanahBangunanImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null

     */
    public function __construct($statusUpload,$kategori,$bumn,$xstatus)
    {
        $this->statusUpload = $statusUpload;
        $this->kategori     = $kategori;
        $this->bumn     = $bumn;
        $this->xstatus = $xstatus;
        
        /*if($kategori =='TB'){
            if($statusUpload == '1'){
                //TanahBangunan::truncate();
                TanahBangunan::where('bumn_code',$this->bumn)->delete();
            }
        }
        elseif ($kategori == 'NTB'){
            if($statusUpload == '1'){
                //NonTanahBangunan::truncate();
                NonTanahBangunan::where('bumn_code',$this->bumn)->delete();
            }
        }*/
        if($xstatus == '1'){
            if($statusUpload == '1'){
                if($kategori =='TB'){
                    TanahBangunan::where('bumn_code',$this->bumn)->delete();
                }
                elseif ($kategori == 'NTB'){
                    NonTanahBangunan::where('bumn_code',$this->bumn)->delete();
                }
            }            
        }

    }

    public function model(array $row)
    {
        $statusUpload   = $this->statusUpload;
        $kategori       = $this->kategori;
        $bumn       = $this->bumn;


        //Insert Data Tanah Bangunan
        if($kategori == 'TB'){
            if($statusUpload == '1'){
                //insert new data

                return new TanahBangunan([
                    'bumn_code'             => $bumn,
                    'no_item'               => $row['no_item_tb'],
                    'nama_asset'            => $row['nama_asset'],
                    'kode_kelompok_asset'   => $row['kodeasset'],
                    'provinsi'              => $row['provinsi'],
                    'p_nilai_awal'          => $row['nilai_awal']
                ]);
            }
            else if($statusUpload == '2'){
                $check = TanahBangunan::where('no_item','=', $row['no_item_tb'])->first();
                if($check === null){
                    return new TanahBangunan([
                        'bumn_code'             => $bumn,
                        'no_item'               => $row['no_item_tb'],
                        'nama_asset'            => $row['nama_asset'],
                        'kode_kelompok_asset'   => $row['kodeasset'],
                        'provinsi'              => $row['provinsi'],
                        'p_nilai_awal'          => $row['nilai_awal']
                    ]);
                }
            }
        }
        //Insert Data non tanah bangunan
        elseif($kategori == 'NTB'){
            if($statusUpload == '1'){
                //insert new data
                
                return new NonTanahBangunan([
                    'bumn_code'             => $bumn,
                    'no_item'               => $row['no_item_ntb'],
                    'nama_asset'            => $row['nama_asset'],
                    'kode_kelompok_asset'   => $row['kodeasset'],
                    'provinsi'              => $row['provinsi'],
                    'p_nilai_awal'          => $row['nilai_awal']
                ]);
            }
            else if($statusUpload == '2'){
                $check = NonTanahBangunan::where('no_item','=', $row['no_item_ntb'])->first();
                if($check === null){
                    return new NonTanahBangunan([
                        'bumn_code'             => $bumn,
                        'no_item'               => $row['no_item_ntb'],
                        'nama_asset'            => $row['nama_asset'],
                        'kode_kelompok_asset'   => $row['kodeasset'],
                        'provinsi'              => $row['provinsi'],
                        'p_nilai_awal'          => $row['nilai_awal']
                    ]);
                }
            }
        }
    }

    public function headingRow(): int{
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
