<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FileUploadServices{
	

	public static function getFileName($x,$id_user,$id_registrasi,$status,$key,$no_registrasi){

		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		$filename = strtoupper($key).$no_registrasi.".".$originalExtension;

		return $filename;
		
	}

	public static function getFileNameHPAS($x,$id_user,$id_registrasi,$status,$key,$no_registrasi){

		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		//dd($key);
		if($key == 'has_1'){
			$filename = strtoupper("HPAS_1_Manual_SJH_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_2'){
			$filename = strtoupper("HPAS_2_Matriks_Bahan_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_3'){
			$filename = strtoupper("HPAS_3_Produk_Hasil_Sendiri_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_4'){
			$filename = strtoupper("HPAS_4_Produk_Titipan_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_5'){
			$filename = strtoupper("HPAS_5_Bahan_Baku_Tambahan_Penolong_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_6'){
			$filename = strtoupper("HPAS_6_Sertifikat_Halal_sebelumnya_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_7'){
			$filename = strtoupper("HPAS_7_Sertifikat_Halal_Produk_Titipan_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_8'){
			$filename = strtoupper("HPAS_8_Resep Produk Tanpa Gramasi_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_9'){
			$filename = strtoupper("HPAS_9_Diagram_Alir_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_10'){
			$filename = strtoupper("HPAS_10_Izin Usaha_NIB_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_11'){
			$filename = strtoupper("HPAS_11_Bukti_Registrasi_Dari BPJPH_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_12'){
			$filename = strtoupper("HPAS_12_Pernyataan_Fasilitas_Produksi_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_13'){
			$filename = strtoupper("HPAS_13_Daftar_Alamat_Fasilitas_Produksi_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_14'){
			$filename = strtoupper("HPAS_14_Bukti_Sosialisasi_Kebijakan_Halal_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_15'){
			$filename = strtoupper("HPAS_15_Bukti_Pelatihan_Internal_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_16'){
			$filename = strtoupper("HPAS_16_Bukti_Audit_Internal_").$no_registrasi.".".$originalExtension;
		}elseif($key == 'has_17'){
			$filename = strtoupper("HPAS_17_Informasi_Denah_Lokasi_Produksi_").$no_registrasi.".".$originalExtension;
		}
		

		return $filename;
		
	}

	public static function getFileNameMaster($x,$status,$key){

		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		$filename = $status.strtoupper($key).".".$originalExtension;

		return $filename;
		
	}

	public static function getUploadFile($x, $id_user, $id_registrasi,$status,$key,$no_registrasi){
		
		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		$filename = strtoupper($key).$no_registrasi.".".$originalExtension;

		$store = $x->storeAs("public/uploadDokumen/".$id_user."/".$id_registrasi."/".$status."/", $filename);

		return $store;
	}

	public static function getUploadFileHPAS($x, $id_user, $id_registrasi,$status,$key,$no_registrasi){
		
		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		$filename = strtoupper("HPAS_").$no_registrasi.".".$originalExtension;

		$store = $x->storeAs("public/uploadDokumen/".$id_user."/".$id_registrasi."/".$status."/", $filename);

		return $store;
	}

	public static function getUploadFileMaster($x,$status,$key){
		
		$originalName = $x->getClientOriginalName();
		$originalExtension = $x->getClientOriginalExtension();
		$filename = $status.strtoupper($key).".".$originalExtension;

		$store = $x->storeAs("public/master/".$status."/", $filename);

		return $store;
	}

	public static function deleteUploadFile($id_user,$id_registrasi,$status){
		//Storage::delete("public/uploadDokumen/".$id_user."/".$id_registrasi."/".$status);
		Storage::deleteDirectory("public/uploadDokumen/".$id_user."/".$id_registrasi."/".$status);
	}

	public static function deleteUploadFileMaster($x,$status){

		Storage::delete("public/master/".$status."/".$x);
	}

}