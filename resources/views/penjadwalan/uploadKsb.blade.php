@extends('layouts.default')

@section('title', 'Upload Berkas Konfirmasi Jadwal, Syarat & Ketentuan Audit, Surat Tugas, Berita Acara')

@push('css')
	<link href="{{asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item">Registrasi</li>
		<li class="breadcrumb-item active">Upload Berkas Konfirmasi Jadwal, Syarat & Ketentuan Audit, Surat Tugas, Berita Acara</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Upload Berkas Konfirmasi Jadwal, Syarat & Ketentuan Audit, Surat Tugas, Berita Acara<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-7">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">No Registrasi : {{$data->no_registrasi}}</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body ">																		
							<table class="table table-lg"> 							
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Jenis Berkas</th>
								<th class="text-center">Download</th>
								<th class="text-center">Upload</th>
								<th class="text-center">Berkas</th>
								<th class="text-center">Tanggal Upload</th>
							</tr>
							<tr>
								<td class="text-center">1</td>
								<td class="text-center">Konfirmasi Jadwal, Syarat & Ketentuan Audit</td>
								<td class="text-center">
								<form action="{{route('downloadberkas')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                @csrf																	
									<div class="wrapper col-lg-12" style="display: none">
									@component('components.inputtext',['name'=> 'no','label' => 'No','required'=>true,'placeholder'=>'No','readonly'=>true,'value'=>1])@endcomponent
									@component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$id_regis])@endcomponent
									@component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan','required'=>true,'placeholder'=>'Nama Perusahaan','readonly'=>true,'value'=>$data->nama_perusahaan])@endcomponent
									</div>
									<button type="submit" class="btn btn-sm btn-info">Download Disini</button>
								</form>
								</td>								
								<td class="text-center">
									@if (Auth::user()->usergroup_id == 1 || Auth::user()->usergroup_id == 3)
										<a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$id_regis}}` data-target='#modalPenjadwalan4' style="cursor:pointer">Upload Disini</a>
									@else
										-
									@endif
								</td>
								<td class="text-center">
									@foreach ($laporan2 as $val)
										@if ($val['file_konfirmasi_sk_audit'])										
											<a href="{{url('') .Storage::url('public/laporan/upload/Konfirmasi SK Audit/'.$val['file_konfirmasi_sk_audit']) }}" download>{{$val['file_konfirmasi_sk_audit']}}</a>
										@else		
										-																
										@endif																			
									@endforeach									
								</td>
								<td class="text-center">
									@foreach ($laporan2 as $val)										
										{{$val['tgl_penyerahan_konfirmasi_sk_audit'] == null? "-" : $val['tgl_penyerahan_konfirmasi_sk_audit']}}
									@endforeach									
								</td>
							</tr>
							<tr>
								<td class="text-center">2</td>
								<td class="text-center">Berita Acara Pemeriksaan</td>
								<td class="text-center">
									{{-- <a href="{{url('').Storage::url('public/laporan/fix/FOR-HALAL-OPS-07 Berita Acara Pemeriksaaan.docx') }}" download>Download Disini</a> --}}
									<form action="{{route('downloadberkas')}}" method="post" name="registerForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
										@csrf																			
											<div class="wrapper col-lg-12" style="display: none">
											@component('components.inputtext',['name'=> 'no','label' => 'No','required'=>true,'placeholder'=>'No','readonly'=>true,'value'=>2])@endcomponent
											@component('components.inputtext',['name'=> 'id_registrasi','label' => 'ID Registrasi','required'=>true,'placeholder'=>'ID Registrasi','readonly'=>true,'value'=>$id_regis])@endcomponent
											@component('components.inputtext',['name'=> 'nama_perusahaan','label' => 'Nama Perusahaan','required'=>true,'placeholder'=>'Nama Perusahaan','readonly'=>true,'value'=>$data->nama_perusahaan])@endcomponent
											</div>
										<button type="submit" class="btn btn-sm btn-info">Download Disini</button>
									</form>
								</td>
								<td class="text-center">
									@if (Auth::user()->usergroup_id == 10)
										<a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$id_regis}}` data-target='#modalPenjadwalan5' style="cursor:pointer">Upload Disini</a>
									@else
										{{-- <a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$id_regis}}` data-target='#modalPenjadwalan5' style="cursor:pointer">Upload Disini</a> --}}
										-
									@endif
								</td>
								<td class="text-center">
									@foreach ($laporan2 as $val)
										@if ($val['file_bap'])
											<a href="{{url('') .Storage::url('public/laporan/upload/BAP/'.$val['file_bap']) }}" download>{{$val['file_bap']}}</a>
										@else		
										-																
										@endif																			
									@endforeach									
								</td>
								<td class="text-center">
									@foreach ($laporan2 as $val)										
										{{$val['tgl_penyerahan_bap'] == null? "-" : $val['tgl_penyerahan_bap']}}
									@endforeach									
								</td>
							</tr>
							<tr>
								<td class="text-center">3</td>
								<td class="text-center">Surat Tugas</td>
								<td class="text-center">-</td>
								<td class="text-center">
									@if (Auth::user()->usergroup_id == 10)
										<a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$id_regis}}` data-target='#modalST' style="cursor:pointer">Upload Disini</a>
									@else
										<a class="btn btn-sm btn-primary text-white" data-toggle='modal' data-id=`{{$id_regis}}` data-target='#modalST' style="cursor:pointer">Upload Disini</a>										
									@endif
								</td>
								<td class="text-center">
									@foreach ($laporan2 as $val)
										@if ($val['file_surat_tugas'])
											<a href="{{url('') .Storage::url('public/laporan/upload/Surat Tugas/'.$val['file_surat_tugas']) }}" download>{{$val['file_surat_tugas']}}</a>
										@else		
										-																
										@endif																			
									@endforeach									
								</td>								
								<td class="text-center">
									@foreach ($laporan2 as $val)										
										{{$val['tgl_penyerahan_surat_tugas'] == null? "-" : $val['tgl_penyerahan_surat_tugas']}}
									@endforeach									
								</td>
							</tr>
							</table>
						<div class="col-md-12 offset-md-5">				
							<button type="button"  onclick="window.history.go(-1);" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Kembali</button>
						</div>
				</div>
				<!-- end panel-body -->				
			</div>
			<!-- end panel -->			
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->

	<div id="modalPenjadwalan4" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Konfirmasi Jadwal, SK Audit</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan4">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control"
                                id="no" name="no" value="1" readonly />
								<input type="text" class="form-control"
                                id="noregis" name="noregis" value="{{$data->no_registrasi}}" readonly />
                                <input type="text" class="form-control"
                                id="idregis" name="idregis" value="{{$id_regis}}" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Berkas</label>                            
                                <input id="file" name="berkas_sk" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
                            </div>                                                                                    
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan berkas?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>

	<div id="modalPenjadwalan5" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Berita Acara Pemeriksaan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan5">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control"
                                id="no" name="no" value="2" readonly />
								<input type="text" class="form-control"
                                id="noregis" name="noregis" value="{{$data->no_registrasi}}" readonly />
                                <input type="text" class="form-control"
                                id="idregis" name="idregis" value="{{$id_regis}}" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Berkas</label>                            
                                <input id="file" name="berkas_bap" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
                            </div>                                                                                    
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan berkas?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>

	<div id="modalST" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{route('uploadberkas')}}" method="post" name="registerForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Upload File Surat Tugas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <form id="formpenjadwalan5">
                        <div class="modal-body">
                            <div class="form-group" style="display: none">
                                <label>ID Registrasi</label>
								<input type="text" class="form-control"
                                id="no" name="no" value="2" readonly />
								<input type="text" class="form-control"
                                id="noregis" name="noregis" value="{{$data->no_registrasi}}" readonly />
                                <input type="text" class="form-control"
                                id="idregis" name="idregis" value="{{$id_regis}}" readonly />
                            </div>
                           
                           
                            <div class="form-group">
                              <label>Berkas</label>                            
                                <input id="file" name="berkas_surattugas" class="form-control" type="file" class="form-control" accept="application/pdf" required/>
                            </div>                                                                                    
                           
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-sm btn-primary m-r-5" onclick="confirm('Apakah anda yakin ingin menambahkan berkas?')">Submit</button>
                        </div>
                    </form>
                </div>  
            </form>
        </div>
    </div>
@endsection

@push('scripts')
	<script src="{{asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>	

    <script type="text/javascript">		
	if(document.getElementById("biaya_pemeriksaan")){
		var rupiah1 = document.getElementById("biaya_pemeriksaan");
		rupiah1.addEventListener('keyup', function(e){									
			rupiah1.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
	
	if(document.getElementById("biaya_pengujian")){
		var rupiah2 = document.getElementById("biaya_pengujian");
		rupiah2.addEventListener('keyup', function(e){									
			rupiah2.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
	
	if(document.getElementById("biaya_fatwa")){
		var rupiah3 = document.getElementById("biaya_fatwa");
		rupiah3.addEventListener('keyup', function(e){									
			rupiah3.value = formatRupiah(this.value, 'Rp. ');			
		});
	}
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){			
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
		}
		
    	//var date = new Date();
        var today = new Date();
    	$('#tgl_akad').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
        });
        $('#tgl_akad').datepicker('setDate', today);


        function jml(){
    		 
    		 var nominal1 = parseInt(removeCommas(document.getElementById('biaya_pemeriksaan').value));			 
    		 var nominal2 = parseInt(removeCommas(document.getElementById('biaya_pengujian').value));
    		 var nominal3 = parseInt(removeCommas(document.getElementById('biaya_fatwa').value));

			
			if (isNaN(nominal1)){

				nominal1 = parseInt("0");
				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			

			}else if (isNaN(nominal2)){

				nominal2 = parseInt("0");

				if (isNaN(nominal1)){

					nominal1 = parseInt("0");
				}else if (isNaN(nominal3)){

					nominal3 = parseInt("0");

				}

			}else if (isNaN(nominal3)){

				nominal3 = parseInt("0");

				if (isNaN(nominal2)){

					nominal2 = parseInt("0");
				}else if (isNaN(nominal1)){

					nominal1 = parseInt("0");

				}

			}
			var jumlah = nominal1+nominal2+nominal3;
    		
    		//console.log(nominal1);
    		//console.log(nominal2);
    		//console.log(nominal3);
    		//console.log(jumlah);
			const formatRupiah = (money) => {
			return new Intl.NumberFormat('id-ID',
				{ style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
			).format(money);
			}
			document.getElementById('total_biaya2').value= jumlah;
			document.getElementById('total_biaya').value= formatRupiah(jumlah);			
			// document.getElementById('total_biaya').value= jumlah;
    	}
    	function removeCommas(str) {
			str = str.split('.').join("");
			str2 = str.split('Rp').join("");
		    return str2;
		};
		
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