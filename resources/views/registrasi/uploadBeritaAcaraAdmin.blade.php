@extends('layouts.default')

@section('title', 'Upload Report')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Upload Berita Acara</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Upload Berita Acara<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Upload Berita Acara</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body panel-form">
					<form action="{{route('registrasi.uploadfileberitaacaraadmin',["id" => $data->id])}}" method="post"  class="form-horizontal form-bordered" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group row" >
							<label class="col-lg-4 col-form-label">No Registrasi</label>
							<div class="col-lg-8">
								<input type="text" name="id" value="{{$data->id}}" hidden readonly>
								<input type="text" class="form-control" name='no_registrasi' value="{{$data->no_registrasi}}" readonly/>
							</div>
																					
                            {{-- @if($data->file_berita_acara == null)
								<!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload Berita Acara</label>
								<div class="col-lg-8">
									<input type="file" id="fille" name="file" oninvalid="this.setCustomValidity('File berita acara masih kosong')" oninput="setCustomValidity('')" onchange="getValue('file')" accept="application/pdf,application/msword" required />
								</div>															
																
                            @elseif($data->file_berita_acara != null)
                            <!--Auto Download-->
								<label class="col-lg-4 col-form-label">Upload Berita Acara</label>
								<div class="col-lg-8">
									<input type="file" id="file" name="file" oninvalid="this.setCustomValidity('File berita acara masih kosong')" oninput="setCustomValidity('')"  onchange="getValue('file')" accept="application/pdf,application/msword" required />
								</div>															
								

								<label class="col-lg-4 col-form-label">Berita Acara</label>
								<div id="sh" class="col-lg-8">
									<div class="form-control" readonly>
										<a href="{{url('') .Storage::url('public/beritaacara/'.$data->id_user.'/'.$data->file_berita_acara) }}" download>{{$data->file_berita_acara}}</a>
									</div>
								</div>
							@endif --}}

							<div class="wrapper col-lg-12">
								<div class="row">
									<label class="col-lg-4 col-form-label"><b>Waktu</b></label>
									<div id="shb" class="col-lg-8">
										<div class="input-group date">
											<input type="text" id="tgl_berita_acara" name="tgl_berita_acara" class="form-control" placeholder="Waktu Berita Acara" value="" data-date-start-date="Date.default" />
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'nama_pelaku_usaha','label' => 'Nama Pelaku Usaha','required'=>true,'placeholder'=>'Nama Pelaku Usaha','readonly'=>true,'value'=>$data->nama_perusahaan])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'nomor_registrasi_bpjph','label' => 'No Registrasi BPJPH','required'=>true,'placeholder'=>'No Registrasi BPJPH','readonly'=>true,'value'=>$data->no_surat])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@if($dataAlamatKantor[0]->kota != null)
										@component('components.inputtext',['name'=> 'alamat','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$dataAlamatKantor[0]->alamat.', '.$dataAlamatKantor[0]->kota.', '.$dataAlamatKantor[0]->provinsi.', '.$dataAlamatKantor[0]->negara])@endcomponent
									@else
										@component('components.inputtext',['name'=> 'alamat','label' => 'Alamat','required'=>true,'placeholder'=>'Alamat','readonly'=>true,'value'=>$dataAlamatKantor[0]->alamat.', '.$dataAlamatKantor[0]->kota_domestik.', '.$dataAlamatKantor[0]->provinsi_domestik.', '.$dataAlamatKantor[0]->negara])@endcomponent
									@endif									
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'izin_usaha','label' => 'Izin Usaha','required'=>true,'placeholder'=>'Izin Usaha','readonly'=>true,'value'=>$data->jenis_izin])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'kategori_produk','label' => 'Kategori Produk','required'=>true,'placeholder'=>'Kategori Produk','readonly'=>true,'value'=>'Makanan'])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">									

									@php
									$arr_nama=[];

									foreach ($dataNamaProduk as $key) {
										$arr_nama[] = $key->merk;
									}									
									$nama_produk = implode(', ',$arr_nama);
									@endphp

									@component('components.inputtext',['name'=> 'nama_produk','label' => 'Nama Produk','required'=>true,'placeholder'=>'Nama Produk','readonly'=>true,'value'=>$nama_produk])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@foreach ($dataKelProduk as $item)
										@component('components.inputtext',['name'=> 'jenis_produk','label' => 'Jenis Produk','required'=>true,'placeholder'=>'Jenis Produk','readonly'=>true,'value'=>$item->kelompok_produk])@endcomponent
									@endforeach									
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'status_sertifikasi','label' => 'Status Sertifikasi','required'=>true,'placeholder'=>'Status Sertifikasi','readonly'=>true,'value'=>$data->status_registrasi])@endcomponent
								</div>
							</div>

							@foreach ($dataPemilik as $item)
							<div class="wrapper col-lg-12">
								<div class="row">									
										@component('components.inputtext',['name'=> 'pemilik_perusahaan','label' => 'Nama Pemilik Perusahaan','required'=>true,'placeholder'=>'Nama Pemilik Perusahaan','readonly'=>true,'value'=>$item->nama_pemilik])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'jabatan_pemilik','label' => 'Jabatan Pemilik','required'=>true,'placeholder'=>'Jabatan Pemilik','readonly'=>true,'value'=>$item->jabatan_pemilik])@endcomponent
								</div>
							</div>
							@endforeach							

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'nama_petugas1','label' => 'Nama Petugas 1','required'=>true,'placeholder'=>'Nama Petugas 1'])@endcomponent
								</div>
							</div>

							<div class="wrapper col-lg-12">
								<div class="row">
									@component('components.inputtext',['name'=> 'nama_petugas2','label' => 'Nama Petugas 2','required'=>true,'placeholder'=>'Nama Petugas 2'])@endcomponent
								</div>
							</div>
								
							
								<div class="col-md-12 offset-md-5">

								@component('components.buttonback',['href' => route("listberitaacara")])@endcomponent
								@if($data->status_berita_acara == 0)
									<button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                @elseif($data->status_berita_acara == 1)
                                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Konfirmasi</button>
                                    <button  class="btn btn-sm btn-warning m-r-5" disabled>Menunggu persetujuan user</button>
                                @elseif($data->status_berita_acara == 2)
                                    <button type="submit" class="btn btn-sm btn-warning m-r-5" disabled>User Telah Setuju</button>
                                @endif
									
								</div>
						</div>
					</form>
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
	<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
	<script src="{{asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/demo/form-plugins.demo.js')}}"></script>    
    <script src="{{asset('/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript">
		$('#tgl_berita_acara').datepicker({
			format: "yyyy-mm-dd",
			todayHighlight: true,
		});
    	//var date = new Date();
        // var today = new Date();
    	// $('#tgl_akad').datepicker({
        //     format: "yyyy-mm-dd",
        //     todayHighlight: true,
        // });
        // $('#tgl_akad').datepicker('setDate', today);       
    function getValue(y){
    	const x  = document.getElementById(y);

    	// var length = x.files[0];
    	// console.log(length);

        var getSize = x.files[0].size;
        //var maxSize = 5120*1024;
        var maxSize = 2048*1024;
        var values = x.value;
        var ext = values.split('.').pop();
        if(getSize > maxSize){
                alert("File terlalu besar, ukuran file maksimal 2MB");
                x.value = "";
                return false;
        }

      
    }

    </script>
    <!--  <script src="{{asset('/assets/js/cleave.js')}}"></script> -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    
   

@endpush