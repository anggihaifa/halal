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
		$filename = strtoupper("HPAS_").$no_registrasi.".".$originalExtension;

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